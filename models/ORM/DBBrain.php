<?php

class DBBrain
{
    private $conn;
    public function __construct()
    {
        $this->conn= DatabaseManager::getInstance();
    }
    public function getPseudoOfUser($UserId) {
        try {
            $query = "SELECT pseudo FROM USERSite WHERE UserId = :userId";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':userId',$UserId, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor(); // Fermez le curseur (si nécessaire)
            return $data['pseudo'];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function getConn(): PDO
    {
        return $this->conn;
    }

    public function isValidEmail($mail_a): bool
    {
        return filter_var($mail_a, FILTER_VALIDATE_EMAIL)!== false;
    }

    public function incrementNumberOfConnexion(): bool
    {
        try {
            // Increment the value and update the database
            $updateQuery = "UPDATE USERSite SET numberOfConnection = numberOfConnection + 1 WHERE UserId = ?";
            $stmt = $this->conn->prepare($updateQuery);
            $stmt->bindParam(1, $UserId);
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}