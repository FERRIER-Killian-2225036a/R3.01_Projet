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

    public function createUser($mail_a, $pseudo_a, $password_a) {
        try {
            // Test le format d'un email
            if (!$this->DBBrain->isValidEmail($mail_a)) {
                throw new Exception("Invalid email format");
            }
            $this->conn->beginTransaction();
            // Insert user into USERSite
            $insertUserSQL = "INSERT INTO USERSite (Mail, Pseudo, DateFirstLogin, DateLastLogin, Role, AlertLevelUser, 
                              NumberOfAction, Status, lastIpAdress, NumberOfConnection) VALUES (?, ?, CURRENT_TIMESTAMP, 
                              CURRENT_TIMESTAMP, 'registered', 0, 0, 'connected', ?, 1)";
            $stmt1 = $this->conn->prepare($insertUserSQL);
            $stmt1->bindParam("sss", $mail_a, $pseudo_a, $_SERVER['REMOTE_ADDR']);
            $stmt1->execute();
            $stmt1->closeCursor();
            // Get UserId
            $userId = $this->conn->lastInsertId();
            // Insert password into PASSWORD
            $insertPasswordSQL = "INSERT INTO Password (Password, UserId) VALUES (?, ?)";
            $stmt2 = $this->conn->prepare($insertPasswordSQL);
            $stmt2->bindParam("si", $password_a, $userId);
            $stmt2->execute();
            $stmt2->closeCursor();
            // Commit the transaction
            $this->conn->commit();
            // Return the UserId
            return $userId;
        } catch (Exception $e) {
            // In case of an error, rollback the transaction
            $this->conn->rollback();
            echo "Error creating user: " . $e->getMessage();
        }
    }

}