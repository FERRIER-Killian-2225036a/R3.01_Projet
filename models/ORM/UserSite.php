<?php

class UserSite
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

            if(!$this->checkPassword($userId, $password_a))
            {
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

            $ValidPseudo = $this->DBBrain->isValidPseudo($pseudo_a);
            if ($ValidPseudo === false) {
                throw new ExceptionsDatabase("Pseudo not valid");
            }

            if (!$this->DBBrain->isValidEmail($mail_a)) {
                throw new ExceptionsDatabase("This email format is not valid");
            }
            if ($this->isUserExists($mail_a, $ValidPseudo)) {
                throw new ExceptionsDatabase("User with this email or pseudo already exists");
            }
            if ($this->DBBrain->isPasswordNotSafe($password_a)) {
                throw new ExceptionsDatabase("This Password is not strong enough, please choose another one");
            }

            $ValidPseudo = strtolower($ValidPseudo);


            $argonifiedPassword = $this->DBBrain->argonifiedPassword($password_a);

            $this->conn->beginTransaction();
            // Insert user into USERSite
            $insertUserSQL = "INSERT INTO USERSite (Mail, Pseudo, DateFirstLogin, DateLastLogin, Role, AlertLevelUser, NumberOfAction, Status, LastIpAdress, NumberOfConnection) VALUES (?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 'registered', 0, 0, 'connected', ?, 1)";
            $stmt1 = $this->conn->prepare($insertUserSQL);
            $stmt1->bindParam(1, $mail_a, PDO::PARAM_STR);
            $stmt1->bindParam(2, $ValidPseudo, PDO::PARAM_STR);
            $stmt1->bindParam(3, $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
            $stmt1->execute();
            // recupération de UserId
            $userId = $this->conn->lastInsertId();
            // Insert password into PASSWORD

            $insertPasswordSQL = "INSERT INTO PASSWORD (Password, UserId) VALUES (?, ?)";
            $stmt2 = $this->conn->prepare($insertPasswordSQL);
            $stmt2->bindParam(1, $argonifiedPassword, PDO::PARAM_STR);
            $stmt2->bindParam(2, $userId, PDO::PARAM_INT);
            $stmt2->execute();
            // Commit de la transaction
            $this->conn->commit();
            // renvoi l'identifiant du nouvel utilisateur



            $subject = "Bienvenue sur Cyphub !";
            $message = "Bonjour ".$ValidPseudo.",\n\nBienvenue sur Cyphub !\n\nNous sommes heureux de vous compter parmi nous !\n\nL'équipe Cyphub.";
            (new mailSender($mail_a,$subject,$message  )); // on peut ajouter getstatus si on veut savoir si le mail a été envoyé
            //TODO on pourra améliorer le system de mail pour avoir des templates automatique
            //TODO et des mails plus jolie, mais pour l'instant on fait simple

            return $userId;
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
    private function isPseudoUse($pseudo_a): bool
    {
        //FONCTIONNE CORRECTEMENT

        $checkUserSQL = "SELECT COUNT(*) FROM USERSite WHERE Pseudo = ?";
        $stmt = $this->conn->prepare($checkUserSQL);
        $stmt->bindParam(1, $pseudo_a, PDO::PARAM_STR);
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
    private function incrementAlertLevelUser($CurrentUserId): bool|ExceptionsDatabase
    {
        try {
            if (!$this->isUserIDExists($CurrentUserId)) {
                throw new ExceptionsDatabase("User not exist");
            }
            // Increment the value and update the database
            $updateQuery = "UPDATE USERSite SET AlertLevelUser = AlertLevelUser + 1 WHERE UserId = ?";
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
            $ValidPseudo = $this->DBBrain->isValidPseudo($new_pseudo);
            if ($ValidPseudo === false) {
                throw new ExceptionsDatabase("Pseudo not valid");
            }
            // Check the user status*
            if (!$this->isUserIDExists($CurrentUserId)) {
                throw new ExceptionsDatabase("User not exist");
            }
            if ($this->getStatusOfUser($CurrentUserId) == "Disconnected") {
                throw new ExceptionsDatabase("User status not valid");
            }
            if ($this->isPseudoUse( $ValidPseudo)) {
                throw new ExceptionsDatabase("User with this pseudo already exists");
            }


            // nettoyage du pseudo
            $ValidPseudo = strtolower($ValidPseudo);

            // Change pseudo
            $stmt = $this->conn->prepare("UPDATE USERSite SET Pseudo = ? WHERE UserId = ?");
            $stmt->bindParam(1, $ValidPseudo);
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
            $this->incrementNumberOfAction($CurrentUserId);
            return true;
        } catch (ExceptionsDatabase $e) {
            //echo "Error: " . $e->getMessage();
            return $e;
        }
    }
    public function update_password($CurrentUserId, $new_password): bool|ExceptionsDatabase
    {
        try {
            // Check the user status
            if (!$this->isUserIDExists($CurrentUserId)) {
                throw new ExceptionsDatabase("User not exist");
            }
            if ($this->getStatusOfUser($CurrentUserId) == "Disconnected") {
                throw new ExceptionsDatabase("User status not valid");
            }
            // Test the format of password
            if ($this->DBBrain->isPasswordNotSafe($new_password)) {
                //TODO on pensera a affiché une erreur dans la page de profil pour dire que le mot de passe n'est pas assez fort
                //TODO et qu'il faut en choisir un autre
                throw new ExceptionsDatabase("Password not valid, you need to choose another one");
            }

            $argonifiedPassword = $this->DBBrain->argonifiedPassword($new_password);
            // Change password
            $stmt = $this->conn->prepare("UPDATE PASSWORD SET Password = ? WHERE UserId = ?");
            $stmt->bindParam(1, $argonifiedPassword);
            $stmt->bindParam(2, $CurrentUserId);
            $stmt->execute();
            $stmt->closeCursor();
            $this->incrementNumberOfAction($CurrentUserId);

            return true;
        } catch (ExceptionsDatabase $e) {
            //echo "Error: " . $e->getMessage();
            return $e;
        }

    }
    public function update_picture($CurrentUserId, $new_picture): bool|ExceptionsDatabase
    {
        error_log("update_picture");
        try {
            // Check the user status
            if (!$this->isUserIDExists($CurrentUserId)) {
                throw new ExceptionsDatabase("User not exist");
            }
            if ($this->getStatusOfUser($CurrentUserId) == "Disconnected") { // on pourrait imaginé une condition pour
                // que le staff puisse changer la photo de profil de qqln d'autre même si il est déconnecté
                throw new ExceptionsDatabase("User status not valid");
            }
            // Change picture
            $stmt = $this->conn->prepare("UPDATE USERSite SET UrlPicture = ? WHERE UserId = ?");
            $stmt->bindParam(1, $new_picture);
            $stmt->bindParam(2, $CurrentUserId);
            $stmt->execute();
            $stmt->closeCursor();
            $this->incrementNumberOfAction($CurrentUserId);

            return true;
        } catch (ExceptionsDatabase $e) {
            //echo "Error: " . $e->getMessage();
            return $e;
        }
    }

    // ----------- REMOVERS ------------
    public function remove_picture($CurrentUserId): bool|ExceptionsDatabase
    {
        try {
            $this->update_picture($CurrentUserId, Constants::PICTURE_URL_DEFAULT);
            return true;// on incrémente pas car on le fait deja dans update_picture
        }
        catch (ExceptionsDatabase $e) {
            //echo "Error: " . $e->getMessage();
            return $e;
        }
    }
    public function remove_user ($CurrentUserId): bool|ExceptionsDatabase{
        // TODO refaire cette fonction car très problématique au niveau de la bdd
        // TODO suppression impossible avec utilisateurs bdd par defaut, (concept de permissions)
        // la suppresion revient a changer le pseudo & mail en deleted user.
        // (on pourrait imaginer une suppression définitive)
        try {
            // Check the user status
            if (!$this->isUserIDExists($CurrentUserId)) {
                throw new ExceptionsDatabase("User not exist");
            }
            if ($this->getStatusOfUser($CurrentUserId) == "Disconnected") {
                throw new ExceptionsDatabase("User status not valid");
            }
            $this->remove_picture($CurrentUserId);
            $hashId= hash_hmac("sha256", $CurrentUserId, Constants::PEPPER);
            $account_name = "Deleted_User_".$hashId;
            $mail_name = $account_name."@cyphub.tech"; // reflechir a si on change le mail ou
            // pas pour permettre un restoration de compte



            $this->update_password($CurrentUserId, $hashId); // en changeant le mot de passe on empeche
            // d'ailleurs la réstoration du compte;

            $stmt = $this->conn->prepare("UPDATE USERSite 
                                                SET 
                                                Pseudo = ?,
                                                Mail = ?,
                                                WHERE UserId = ?;");
            $stmt->bindParam(1, $account_name);
            $stmt->bindParam(2, $mail_name);
            $stmt->bindParam(3, $CurrentUserId);
            $stmt->execute();

            return true;
        }
        catch (ExceptionsDatabase $e) {
            //echo "Error: " . $e->getMessage();
            return $e;
        }

    }

    public function checkPassword(int $UserId, string $oldPassword)
    {
        $pwd_peppered = hash_hmac("sha256", $oldPassword, Constants::PEPPER);

        $stmt2 = $this->conn->prepare("SELECT Password FROM PASSWORD WHERE UserId = ?");
        $stmt2->bindParam(1, $UserId, PDO::PARAM_INT);
        $stmt2->execute();
        $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        $stmt2->closeCursor();
        $userPassword = $result2['Password'];

        if (!password_verify($pwd_peppered, $userPassword)) { // si le mot de passe ne correspond pas
            //      throw new ExceptionsDatabase("Email or password does not match");
            //echo "do not match";
            //TODO LOG DANS LA BASE DE LOG (tentative de connexion échouée avec l'ip)
            //TODO INCREMENTER LE NIVEAU D'ALERTE
            //TODO BLOQUER LE COMPTE SI NIVEAU D'ALERTE TROP ELEVE
            $this->incrementAlertLevelUser($UserId);
            return false;
        }
        return true;
    }


}