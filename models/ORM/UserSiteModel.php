<?php

class UserSiteModel
{
    private $conn;
    private $DBBrain;

    public function __construct()
    {
        $this->DBBrain = new DBBrain();
        $this->conn = $this->DBBrain->getConn();
    }

    public function getValuesById($Id)
    {
        $mapArrayOfUserValues = null;
        try {
            if (!$this->isUserIDExists($Id)) {
                throw new ExceptionsDatabase("This user doesn't exist");
            }

            $stmt = $this->conn->prepare("SELECT * FROM USERSite WHERE UserID = ?");
            $stmt->bindParam(1, $Id, PDO::PARAM_STR);
            $stmt->execute();
            $mapArrayOfUserValues = $stmt->fetch(PDO::FETCH_ASSOC); // Stocke le résultat dans le tableau

            $stmt->closeCursor();
        } catch (ExceptionsDatabase $e) {
                // Gérer l'exception ici
            echo $e->getMessage();
        }

        return $mapArrayOfUserValues; // Retourne le tableau avec les valeurs de la requete
    }


    public function loginUser($mail_a, $password_a): ExceptionsDatabase|string
    {
        try{

            $pwd_peppered = hash_hmac("sha256", $password_a, Constants::PEPPER);


            if (!$this->DBBrain->isValidEmail($mail_a)) { // si l'email n'a pas un format valide
                throw new ExceptionsDatabase("This email format is not valid");
            }
            if (!$this->isEmailUse($mail_a)) { // si l'email n'est pas utilisé
                echo " email not used";
                throw new ExceptionsDatabase("Email or password does not match");
            }

            $stmt = $this->conn->prepare("SELECT UserId FROM USERSite WHERE Mail = ?");
            $stmt->bindParam(1, $mail_a, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            /*if (!$result) { //n'arrive jamais car on test avant si l'email est utilisé
                throw new ExceptionsDatabase("User does not exist");
                }
            */
            $userId = $result['UserId'];

            $stmt2= $this->conn->prepare("SELECT Password FROM PASSWORD WHERE UserId = ?");
            $stmt2->bindParam(1, $userId, PDO::PARAM_INT);
            $stmt2->execute();
            $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $stmt2->closeCursor();
            $userPassword = $result2['Password'];


            if (!password_verify($pwd_peppered, $userPassword)) { // si le mot de passe ne correspond pas                throw new ExceptionsDatabase("Email or password does not match");
                //echo "do not match";
                throw new ExceptionsDatabase("Email or password does not match");
            }
            /*
            if ($userStatus !== 'disconnected') { // not normal user status ? on peut supposer que c'est un attaquant OU
                // que l'utilisateur essai de se connecter depuis un autre appareil , dans les deux cas on deconnecte
                SessionManager::disconnect();
                //throw new ExceptionsDatabase("You are already connected");
            }
            */
            // Update user status to 'connected'
            $stmt = $this->conn->prepare("UPDATE USERSite SET Status = 'connected' WHERE UserId = ?");
            $stmt->bindParam(1, $userId, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
            // Change date of last login
            $updateQuery = "UPDATE USERSite SET dateLastLogin = CURRENT_TIMESTAMP WHERE UserId = ?";
            $stmt = $this->conn->prepare($updateQuery);
            $stmt->bindParam(1, $userId, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
            // Change lastIpAddress
            $updateQuery = "UPDATE USERSite SET LastIpAdress = ? WHERE UserId = ?";
            $stmt = $this->conn->prepare($updateQuery);
            $stmt->bindParam(1, $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
            $stmt->bindParam(2, $userId, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
            // Increment the number of connections
            $result = $this->DBBrain->incrementNumberOfConnexion($userId);
            if (!$result) {
                throw new ExceptionsDatabase("Error incrementing number of connections");
            }
            // Return UserID

            return $userId;

        }
        catch (ExceptionsDatabase $e)
        {
            //echo "Error login user: " . $e->getMessage();
            return $e;
        }

    }


    public function createUser($pseudo_a,$mail_a,  $password_a): ExceptionsDatabase|string
    {
        try {
            // désensibilisation a la casse pour le pseudo
            $pseudo_a= strtolower($pseudo_a);

            if (!$this->DBBrain->isValidEmail($mail_a)) {
                throw new ExceptionsDatabase("This email format is not valid");
            }
            if ($this->isUserExists($mail_a, $pseudo_a)) {
                throw new ExceptionsDatabase("User with this email or pseudo already exists");
            }
            if ($this->isPasswordNotSafe($password_a)) {
                throw new ExceptionsDatabase("This Password is not strong enough, please choose another one");
            }
            // on ajoute un poivre
            $pwd_peppered = hash_hmac("sha256", $password_a, Constants::PEPPER);
            // on utilise l'algo de hachage ARGON2ID
            $options = [ // configuration minimale recommandé par OWASP TOP 10 (cheat sheet)
                'memory_cost' => 65536, // 19 MiB en kibibytes (1024 * 19)
                'time_cost' => 2, // 2 itérations
                'threads' => 1, // Degré de parallélisme de 1
            ];
            $hashedPassword = password_hash($pwd_peppered, PASSWORD_ARGON2ID, $options);
            // on utilisera password_verify($passwordFromUser, $storedHashedPassword)) pour verifier le mot de passe
            // lors de la connexion

            $this->conn->beginTransaction();
            // Insert user into USERSite
            $insertUserSQL = "INSERT INTO USERSite (Mail, Pseudo, DateFirstLogin, DateLastLogin, Role, AlertLevelUser, NumberOfAction, Status, LastIpAdress, NumberOfConnection) VALUES (?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 'registered', 0, 0, 'connected', ?, 1)";
            $stmt1 = $this->conn->prepare($insertUserSQL);
            $stmt1->bindParam(1, $mail_a, PDO::PARAM_STR);
            $stmt1->bindParam(2, $pseudo_a, PDO::PARAM_STR);
            $stmt1->bindParam(3, $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
            $stmt1->execute();
            // recupération de UserId
            $userId = $this->conn->lastInsertId();
            // Insert password into PASSWORD
            $insertPasswordSQL = "INSERT INTO PASSWORD (Password, UserId) VALUES (?, ?)";
            $stmt2 = $this->conn->prepare($insertPasswordSQL);
            $stmt2->bindParam(1, $hashedPassword, PDO::PARAM_STR);
            $stmt2->bindParam(2, $userId, PDO::PARAM_INT);
            $stmt2->execute();
            // Commit de la transaction
            $this->conn->commit();
            // renvoi l'identifiant du nouvel utilisateur
            return $userId;
            // TODO : envoyer un mail de confirmation
            // TODO : limiter taille

        } catch (ExceptionsDatabase $e) {
            //echo "Error creating user: " . $e->getMessage();
            return $e;
        }
    }

    private function isUserExists($mail_a, $pseudo_a): bool
    {
        //FONCTIONNE CORRECTEMENT

        $checkUserSQL = "SELECT COUNT(*) FROM USERSite WHERE Mail = ? OR Pseudo = ?";
        $stmt = $this->conn->prepare($checkUserSQL);
        $stmt->bindParam(1, $mail_a, PDO::PARAM_STR);
        $stmt->bindParam(2, $pseudo_a, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        //echo $count > 0;
        return $count > 0;

    }
    private function isEmailUse($mail_a): bool
    {
        //FONCTIONNE CORRECTEMENT

        $checkUserSQL = "SELECT COUNT(*) FROM USERSite WHERE Mail = ? ";
        $stmt = $this->conn->prepare($checkUserSQL);
        $stmt->bindParam(1, $mail_a, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        //echo $count > 0;
        return $count > 0;

    }

    private function isPasswordNotSafe($password_a): bool
    {
        //FONCTIONNE CORRECTEMENT

        $hashedPassword = strtoupper(sha1($password_a));
        // Prenez les 5 premiers caractères du hachage (préfixe)
        $prefix = substr($hashedPassword, 0, 5);
        // Faites une requête à l'API Have I Been Pwned
        $apiUrl = "https://api.pwnedpasswords.com/range/" . $prefix;
        $response = file_get_contents($apiUrl);
        // Recherchez le reste du hachage dans la réponse
        $searchTerm = substr($hashedPassword, 5);
        $searchResult = preg_match('/' . $searchTerm . ':(\d+)/', $response, $matches);
        // Si le mot de passe est apparu dans une fuite, retournez false
        if ($searchResult) {
            return true;
        }
        // Si le mot de passe est suffisamment fort, retournez true
        // Vous pouvez ajouter d'autres critères de force ici
        return false;
    }

    public function disconnectUser(int $id)
    {
        try {

            if (!$this->isUserIDExists($id)) {
                throw new ExceptionsDatabase("User with this email or pseudo already exists");
            }
            // Checking the existence of the user by UserId
            $stmt = $this->conn->prepare("SELECT Status FROM USERSite WHERE UserId = ?");
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();

            // Update user status to 'disconnected'
            $stmt = $this->conn->prepare("UPDATE USERSite SET Status = 'disconnected' WHERE UserId = ?");
            $stmt->bindParam(1, $userId_a, PDO::PARAM_INT);
            $stmt->execute();
            error_log("disconnectUser".$id);
            return "success";
        } catch (ExceptionsDatabase $e) {
            return $e;
        }
    }

    private function isUserIDExists(int $id)
    {
        $checkUserSQL = "SELECT COUNT(*) FROM USERSite WHERE UserId = ? ";
        $stmt = $this->conn->prepare($checkUserSQL);
        $stmt->bindParam(1, $id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        //echo $count > 0;
        return $count > 0;
    }
}
