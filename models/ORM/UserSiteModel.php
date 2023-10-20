<?php

class UserSiteModel
{
    private PDO $conn;
    private DBBrain $DBBrain;

    public function __construct()
    {
        $this->DBBrain = new DBBrain();
        $this->conn = $this->DBBrain->getConn();
    }



    // ----------- AUTHENTIFICATION ------------

    public function loginUser($mail_a, $password_a): ExceptionsDatabase|string
    {
        try {

            $pwd_peppered = hash_hmac("sha256", $password_a, Constants::PEPPER);

            if (!$this->DBBrain->isValidEmail($mail_a)) { // si l'email n'a pas un format valide
                throw new ExceptionsDatabase("This email format is not valid");
            }
            if (!$this->isEmailUse($mail_a)) { // si l'email n'est pas utilisé
                //echo " email not used";
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

            $stmt2 = $this->conn->prepare("SELECT Password FROM PASSWORD WHERE UserId = ?");
            $stmt2->bindParam(1, $userId, PDO::PARAM_INT);
            $stmt2->execute();
            $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $stmt2->closeCursor();
            $userPassword = $result2['Password'];


            if (!password_verify($pwd_peppered, $userPassword)) { // si le mot de passe ne correspond pas                throw new ExceptionsDatabase("Email or password does not match");
                //echo "do not match";
                //TODO LOG DANS LA BASE DE LOG (tentative de connexion échouée avec l'ip)
                //TODO INCREMENTER LE NIVEAU D'ALERTE
                //TODO BLOQUER LE COMPTE SI NIVEAU D'ALERTE TROP ELEVE
                throw new ExceptionsDatabase("Email or password does not match");
            }
            /* //TODO : a voir si on laisse cette partie
            if ($userStatus !== 'disconnected') { // not normal user status ? on peut supposer que c'est un attaquant OU
                // que l'utilisateur essai de se connecter depuis un autre appareil , dans les deux cas on déconnecte
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
            $result = $this->incrementNumberOfConnexion($userId);
            if (!$result) {
                throw new ExceptionsDatabase("Error incrementing number of connections");
            }
            // Return UserID
            return $userId;

        } catch (ExceptionsDatabase $e) {
            //echo "Error login user: " . $e->getMessage();
            return $e;
        }
    }
    public function createUser($pseudo_a, $mail_a, $password_a): ExceptionsDatabase|string
    {
        try {
            // désensibilisation a la casse pour le pseudo
            $pseudo_a = strtolower($pseudo_a);

            if (!$this->DBBrain->isValidEmail($mail_a)) {
                throw new ExceptionsDatabase("This email format is not valid");
            }
            if ($this->isUserExists($mail_a, $pseudo_a)) {
                throw new ExceptionsDatabase("User with this email or pseudo already exists");
            }
            if ($this->DBBrain->isPasswordNotSafe($password_a)) {
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
    public function disconnectUser(int $id): ExceptionsDatabase|string
    {
        try {

            if (!$this->isUserIDExists($id)) {
                throw new ExceptionsDatabase("User with this email or pseudo already exists");
            }
            // Update user status to 'disconnected'
            $stmt = $this->conn->prepare("UPDATE USERSite SET Status = 'disconnected' WHERE UserId = ?");
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            //error_log("disconnectUser".$id); debug only
            return "success";
        } catch (ExceptionsDatabase $e) {
            return $e;
        }
    }



    // ----------- UTILITAIRE ------------
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
    private function isUserIDExists(int $id): bool
    {
        $checkUserSQL = "SELECT COUNT(*) FROM USERSite WHERE UserId = ? ";
        $stmt = $this->conn->prepare($checkUserSQL);
        $stmt->bindParam(1, $id, PDO::PARAM_STR);
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

    // ----------- GETTERS ------------

    public function getValuesById($Id)
    {
        //$mapArrayOfUserValues = null;
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
            //echo $e->getMessage();
            return $e;
        }

        return $mapArrayOfUserValues; // Retourne le tableau avec les valeurs de la requete
    }

    public function getPseudoOfUser($UserId)
    {
        try {
            $query = "SELECT Pseudo FROM USERSite WHERE UserId = :userId";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':userId', $UserId, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor(); // Fermez le curseur (si nécessaire)
            return $data['Pseudo'];
        } catch (PDOException $e) {//TODO ExceptionsDatabase ?
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function getStatusOfUser($UserId)
    {
        try {
            $query = "SELECT Status FROM USERSite WHERE UserId = :userId";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':userId', $UserId, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor(); // Fermez le curseur (si nécessaire)
            return $data['Status'];
        } catch (PDOException $e) { //TODO ExceptionsDatabase ?
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    // ----------- UPDATERS ------------
    public function incrementNumberOfConnexion($UserId): Bool|ExceptionsDatabase
    {
        try {
            // Increment the value and update the database
            if (!$this->isUserIDExists($UserId)) {
                throw new ExceptionsDatabase("User not exist");
            }
            $updateQuery = "UPDATE USERSite SET NumberOfConnection = NumberOfConnection + 1 WHERE UserId = ?";
            $stmt = $this->conn->prepare($updateQuery);
            $stmt->bindParam(1, $UserId);
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } catch (ExceptionsDatabase $e) {
            //echo "Error: " . $e->getMessage();
            return $e;
        }
    }
    private function incrementNumberOfAction($CurrentUserId): bool|ExceptionsDatabase
    {

        try {
            if (!$this->isUserIDExists($CurrentUserId)) {
                throw new ExceptionsDatabase("User not exist");
            }
            // Increment the value and update the database
            $updateQuery = "UPDATE USERSite SET NumberOfAction = NumberOfAction + 1 WHERE UserId = ?";
            $stmt = $this->conn->prepare($updateQuery);
            $stmt->bindParam(1, $CurrentUserId);
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } catch (ExceptionsDatabase $e) {
            //echo "Error: " . $e->getMessage();
            return $e;
        }

    }
    public function update_pseudo($CurrentUserId, $new_pseudo): bool|ExceptionsDatabase
    {
        try {
            // Check the user status*
            if (!$this->isUserIDExists($CurrentUserId)) {
                throw new ExceptionsDatabase("User not exist");
            }
            if ($this->getStatusOfUser($CurrentUserId) == "Disconnected") {
                throw new ExceptionsDatabase("User status not valid");
            }

            // Change pseudo
            $stmt = $this->conn->prepare("UPDATE USERSite SET Pseudo = ? WHERE UserId = ?");
            $stmt->bindParam(1, $new_pseudo);
            $stmt->bindParam(2, $CurrentUserId);
            $stmt->execute();
            $stmt->closeCursor();
            // Insert log entry into the log database
            // $stmt = $logConn->prepare("INSERT INTO LogUser (UserId, dateC, action) VALUES (?, CURRENT_TIMESTAMP, 'Change Pseudo')");
            // $stmt->bind_param("is", $CurrentUserId);
            // $stmt->execute();
            // $stmt->close();
            // Increment number action user
            $this->incrementNumberOfAction($CurrentUserId);
            return true;
        } catch (ExceptionsDatabase $e) {
            //echo "Error: " . $e->getMessage();
            return $e;
        }
    }
    public function update_mail($CurrentUserId, $new_mail): bool|ExceptionsDatabase
    {
        try {
            // Check the user status
            if (!$this->isUserIDExists($CurrentUserId)) {
                throw new ExceptionsDatabase("User not exist");
            }
            if ($this->getStatusOfUser($CurrentUserId) == "Disconnected") {
                throw new ExceptionsDatabase("User status not valid");
            }
            // Test the format of mail
            if (!$this->DBBrain->isValidEmail($new_mail)) {
                throw new ExceptionsDatabase("mail not valid");
            }
            // Change mail
            $stmt = $this->conn->prepare("UPDATE USERSite SET mail = ? WHERE UserId = ?");
            $stmt->bindParam(1, $new_mail);
            $stmt->bindParam(2, $CurrentUserId);
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } catch (ExceptionsDatabase $e) {
            //echo "Error: " . $e->getMessage();
            return $e;
        }
    }
}