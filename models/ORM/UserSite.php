<?php

/**
 * la Classe UserSite de l'orm pour faire les acces a la base de données et recuperer les valeurs de la table USERSite
 *
 * les attributs de la table USERSite sont :
 * - UserId : int
 * - Mail : varchar(50)
 * - Pseudo : varchar(20)
 * - DateFirstLogin : datetime
 * - DateLastLogin : datetime
 * - Role : enum('registered','moderator','admin','superadmin') DEFAULT 'registered'
 * - AlertLevelUser : int
 * - NumberOfAction : int
 * - Status : enum('connected','disconnected','banned','muted') DEFAULT 'disconnected'
 * - UrlPicture : text
 * - LastIpAdress : text
 * - NumberOfConnection : int
 *
 * Cette classe principale concerne les données de tout les utilisateurs de notre site dans notre base de donnée.
 *
 * @see USERSiteModel
 * @see ControllerSettings
 * @see ControllerUser
 * @see ControllerAuth
 * @see UserSite
 * @see SessionManager
 * @see PictureVerificator
 * @see mailSender
 * @see DBBrain
 *
 * @package models/ORM
 * @since 1.0
 * @version 1.0
 * @category User
 * @author Tom Carvajal & Vanessa Guil
 */
class UserSite
{
    /**
     * @var PDO $conn variable de connexion a la base de données
     */
    private PDO $conn;

    /**
     * @var DBBrain $DBBrain variable pour recuperer le cerveau de la bdd (méthodes utiles)
     */
    private DBBrain $DBBrain;

    /**
     * UserSite constructor.
     */
    public function __construct()
    {
        $this->DBBrain = new DBBrain();
        $this->conn = $this->DBBrain->getConn();
    }

    // ----------- AUTHENTIFICATION ------------

    /**
     * Méthode pour verifier si les données dans la base de donnée correspondent a l'input recup par le controlleur
     *
     * @param string $mail_a
     * @param string $password_a
     * @return ExceptionsDatabase|string
     */
    public function loginUser(string $mail_a, string $password_a): ExceptionsDatabase|string
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
            $stmt->bindParam(1, $mail_a);
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
            $stmt->bindParam(1, $_SERVER['REMOTE_ADDR']);
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
            return $e;
        }
    }

    /**
     * Cette methode permet de créer un utilisateur
     *
     * @param string $pseudo_a
     * @param string $mail_a
     * @param string $password_a
     * @return ExceptionsDatabase|string
     */
    public function createUser(string $pseudo_a, string $mail_a, string $password_a): ExceptionsDatabase|string
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
            $stmt1->bindParam(1, $mail_a);
            $stmt1->bindParam(2, $ValidPseudo);
            $stmt1->bindParam(3, $_SERVER['REMOTE_ADDR']);
            $stmt1->execute();
            // recupération de UserId
            $userId = $this->conn->lastInsertId();
            // Insert password into PASSWORD

            $insertPasswordSQL = "INSERT INTO PASSWORD (Password, UserId) VALUES (?, ?)";
            $stmt2 = $this->conn->prepare($insertPasswordSQL);
            $stmt2->bindParam(1, $argonifiedPassword);
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
            return $e;
        }
    }

    /**
     * cette méthode met a jour les infos d'un utilisateur lorsqu'il se deconnecte
     *
     * @param int $id
     * @return ExceptionsDatabase|string
     */
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
            return "success";
        } catch (ExceptionsDatabase $e) {
            return $e;
        }
    }

    // ----------- UTILITAIRE ------------


    /**
     * methode pour savoir si un utilisateur existe avec un mail ou un pseudo donnée
     *
     * @param string $mail_a
     * @param string $pseudo_a
     * @return bool
     */
    public function isUserExists(string $mail_a, string $pseudo_a): bool
    {
        //FONCTIONNE CORRECTEMENT

        $checkUserSQL = "SELECT COUNT(*) FROM USERSite WHERE Mail = ? OR Pseudo = ?";
        $stmt = $this->conn->prepare($checkUserSQL);
        $stmt->bindParam(1, $mail_a);
        $stmt->bindParam(2, $pseudo_a);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        //echo $count > 0;
        return $count > 0;
    }

    /**
     * methode pour savoir si un pseudo est utilisé
     *
     * @param string $pseudo_a
     * @return bool
     */
    public function isPseudoUse(string $pseudo_a): bool
    {
        //FONCTIONNE CORRECTEMENT

        $checkUserSQL = "SELECT COUNT(*) FROM USERSite WHERE Pseudo = ?";
        $stmt = $this->conn->prepare($checkUserSQL);
        $stmt->bindParam(1, $pseudo_a);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        //echo $count > 0;
        return $count > 0;
    }

    /**
     * cette methode permet de verifier si un utilisateur existe avec un id donnée
     *
     * @param int $id
     * @return bool
     */
    public function isUserIDExists(int $id): bool
    {
        $checkUserSQL = "SELECT COUNT(*) FROM USERSite WHERE UserId = ? ";
        $stmt = $this->conn->prepare($checkUserSQL);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    /**
     * cette methode verifie si un email est utilisé.
     *
     * @param string $mail_a
     * @return bool
     */
    public function isEmailUse(string $mail_a): bool
    {
        //FONCTIONNE CORRECTEMENT

        $checkUserSQL = "SELECT COUNT(*) FROM USERSite WHERE Mail = ? ";
        $stmt = $this->conn->prepare($checkUserSQL);
        $stmt->bindParam(1, $mail_a);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        //echo $count > 0;
        return $count > 0;

    }

    // ----------- GETTERS ------------

    /**
     * Cette methode permet de recupere tout les champs d'un utilisateur par rapport a son id
     * on s'en sert pour la construction de son model, afin de limiter le nombre d'appel dans la bdd
     *
     * @param int $Id
     * @return Exception|ExceptionsDatabase|array|false
     */
    public function getValuesById(int $Id): bool|ExceptionsDatabase|Exception|array
    {
        try {
            if (!$this->isUserIDExists($Id)) {
                throw new ExceptionsDatabase("This user doesn't exist");
            }

            $stmt = $this->conn->prepare("SELECT * FROM USERSite WHERE UserID = ?");
            $stmt->bindParam(1, $Id);
            $stmt->execute();
            $mapArrayOfUserValues = $stmt->fetch(PDO::FETCH_ASSOC); // Stocke le résultat dans le tableau

            $stmt->closeCursor();
        } catch (ExceptionsDatabase $e) {
            return $e;
        }
        return $mapArrayOfUserValues; // Retourne le tableau avec les valeurs de la requete
    }


    /**
     * Cette methode permet de recuperer le pseudo d'un user selon son id
     *
     * @param int $UserId
     * @return string|Exception|PDOException
     */
    public function getPseudoOfUser(int $UserId): PDOException|Exception|string
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
            return $e;
        }
    }

    /**
     * Cette methode permet de recuperer le status d'un user selon son id
     *
     * @param int $UserId
     * @return string|null
     */
    public function getStatusOfUser(int $UserId): string|null
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
            return null;
        }
    }

    // ----------- UPDATERS ------------

    /**
     * cette methode permet d'incrementer d'un, le nombre de connexions d'un user par rapport a son id
     *
     * @param int $UserId
     * @return true|ExceptionsDatabase
     */
    public function incrementNumberOfConnexion(int $UserId): bool|ExceptionsDatabase
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
            return $e;
        }
    }

    /**
     * cette méthode increment le nombre d'action d'un utilisateur par rapport a son id
     * //TODO : mettre bien plus en place l'utilisation de cette methode pour verifier la suspicion de bot/spam
     *
     * @param int $CurrentUserId
     * @return bool|ExceptionsDatabase
     */
    public function incrementNumberOfAction(int $CurrentUserId): bool|ExceptionsDatabase
    {
        try {
            if (!$this->isUserIDExists($CurrentUserId)) {
                throw new ExceptionsDatabase("User not exist");
            }
            $updateQuery = "UPDATE USERSite SET NumberOfAction = NumberOfAction + 1 WHERE UserId = ?";
            $stmt = $this->conn->prepare($updateQuery);
            $stmt->bindParam(1, $CurrentUserId);
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } catch (ExceptionsDatabase $e) {
            return $e;
        }
    }

    /**
     * Cette méthode permet d'incrementer le niveau d'alerte d'un utilisateur par rapport a son id
     *
     * @param int $CurrentUserId
     * @return bool|ExceptionsDatabase
     */
    public function incrementAlertLevelUser(int $CurrentUserId): bool|ExceptionsDatabase
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
            return $e;
        }

    }

    /**
     * Cette methode permet de mettre a jour le pseudo d'un utilisateur par rapport a son id
     *
     * @param int $CurrentUserId
     * @param string $new_pseudo
     * @return bool|ExceptionsDatabase
     */
    public function update_pseudo(int $CurrentUserId, string $new_pseudo): bool|ExceptionsDatabase
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
            return $e;
        }
    }

    /**
     * Cette methode permet de mettre a jour le mail d'un utilisateur par rapport a son id
     *
     * @param int $CurrentUserId
     * @param string $new_mail
     * @return bool|ExceptionsDatabase
     */
    public function update_mail(int $CurrentUserId, string $new_mail): bool|ExceptionsDatabase
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
            return $e;
        }
    }

    /**
     * Cette methode permet de mettre a jour le mot de passe d'un utilisateur par rapport a son id
     *
     * @param int $CurrentUserId
     * @param string $new_password
     * @return bool|ExceptionsDatabase
     */
    public function update_password(int $CurrentUserId, string $new_password): bool|ExceptionsDatabase
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
            return $e;
        }

    }

    /**
     * Cette methode permet de mettre a jour l'image de profil d'un user (chemin de l'image)
     *
     * @param int $CurrentUserId
     * @param string $new_picture
     * @return bool|ExceptionsDatabase
     */
    public function update_picture(int $CurrentUserId, string $new_picture): bool|ExceptionsDatabase
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
            return $e;
        }
    }

    // ----------- REMOVERS ------------

    /**
     * Cette méthode permet de supprimer l'image de profil d'un utilisateur par rapport a son id
     * (on remet l'image par defaut)
     *
     * @param string $CurrentUserId
     * @return bool|ExceptionsDatabase
     */
    public function remove_picture(string $CurrentUserId): bool|ExceptionsDatabase
    {
        try {
            $this->update_picture($CurrentUserId, Constants::PICTURE_URL_DEFAULT);
            return true;// on incrémente pas car on le fait deja dans update_picture
        }
        catch (ExceptionsDatabase $e) {
            return $e;
        }
    }

    /**
     * Cette methode permet de supprimer un utilisateur par rapport a son id
     * on supprime pour l'instant pas vraiment car contrainte de la bdd
     *
     * @param int $CurrentUserId
     * @return bool|ExceptionsDatabase
     */
    public function remove_user (int $CurrentUserId): bool|ExceptionsDatabase{
        // TODO refaire cette fonction car très problématique au niveau de la bdd
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
            $hashId= hash_hmac("sha256", $CurrentUserId, Constants::$PEPPER);
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
            return $e;
        }

    }

    /**
     * méthode utiliser pour verifier si un mot de passe match bien avec celui de la bdd
     *
     * @param int $UserId
     * @param string $password
     * @return bool
     */
    public function checkPassword(int $UserId, string $password): bool
    {
        $pwd_peppered = hash_hmac("sha256", $password, Constants::$PEPPER);

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

    /**
     * méthode pour recuperer les identifiants des pseudos qui match avec l'input donné
     *
     * @param int|string $inputToSearch
     * @param bool $BLACKLIST
     * @return false|array
     */
    public function getUserIdByPseudo(int|string $inputToSearch, bool $BLACKLIST): false|array
    {
        if ($BLACKLIST) { // on cherche meme les users bannis
            $stmt = $this->conn->prepare("SELECT UserId FROM USERSite WHERE Pseudo LIKE ?");
        } else {
            $stmt = $this->conn->prepare("SELECT UserId FROM USERSite WHERE Pseudo LIKE ? AND Status != 'banned'");

        }
        $stmt->bindValue(1, '%'.$inputToSearch.'%');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        print_r($result);
        return $result;

    }

    /**
     * méthode pour chercher a travers plusieurs attributs d'un user et voir si son input match avec l'un d'eux pour recuperer l'id
     *
     * @param int|string $inputToSearch
     * @param bool $BLACKLIST
     * @return false|array
     */
    public function getUserIdByResearch(int|string $inputToSearch, bool $BLACKLIST): false|array
    {
        if ($BLACKLIST){
            $stmt = $this->conn->prepare("SELECT UserId FROM USERSite WHERE UserID = ? OR Pseudo LIKE ? OR Mail LIKE ? OR LastIpAdress LIKE ?");
        }
        else{
            $stmt = $this->conn->prepare("SELECT UserId FROM USERSite WHERE UserID = ? OR Pseudo LIKE ? OR Mail LIKE ? OR LastIpAdress LIKE ? AND Status != 'banned'");
        }
        $stmt->bindValue(1, '%'.$inputToSearch.'%');
        $stmt->bindValue(2, '%'.$inputToSearch.'%');
        $stmt->bindValue(3, '%'.$inputToSearch.'%');
        $stmt->bindValue(4, '%'.$inputToSearch.'%');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $result;
    }


}