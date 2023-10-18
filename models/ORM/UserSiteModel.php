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

    public function createUser($pseudo_a,$mail_a,  $password_a) {
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
            

            $this->conn->beginTransaction();
            // Insert user into USERSite
            $insertUserSQL = "INSERT INTO USERSite (Mail, Pseudo, DateFirstLogin, DateLastLogin, Role, AlertLevelUser, NumberOfAction, Status, lastIpAdress, NumberOfConnection) VALUES (?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 'registered', 0, 0, 'connected', ?, 1)";
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
            $stmt2->bindParam(1, $password_a, PDO::PARAM_STR);
            $stmt2->bindParam(2, $userId, PDO::PARAM_INT);
            $stmt2->execute();
            // Commit de la transaction
            $this->conn->commit();
            // renvoi l'identifiant du nouvel utilisateur
            return $userId;
        } catch (ExceptionsDatabase $e) {
            //annulation de la transaction si erreur
            //$this->conn->rollback();
            echo "Error creating user: " . $e->getMessage();
            //echo "$mail_a, $pseudo_a, $password_a" ;
            return false;
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
        echo $count > 0;
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
}
