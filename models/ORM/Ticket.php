<?php

class Ticket
{
    private PDO $conn;
    private DBBrain $DBBrain;

    public function __construct()
    {
        $this->DBBrain = new DBBrain();
        $this->conn = $this->DBBrain->getConn();
    }

    public function createTicket($mail, $description, $statusT, $title, $UserId)
    {
        //$mail, $date, $description, $statusT, $title, $UserId
        $sql = "INSERT INTO Ticket (mail, date, description, statusT, title, UserId) VALUES (:mail, CURRENT_TIMESTAMP, :description, :statusT, :title, :UserId)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':statusT', $statusT);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':UserId', $UserId);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function getTicket($TicketId)
    {
        if ($this->isTicketExist($TicketId)) {
            $sql = "SELECT * FROM Ticket WHERE TicketId = :TicketId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':TicketId', $TicketId);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function getAllTicketIdOfUser($UserId)
    {
        $ArrayOfTicketId = array();
        $sql = "SELECT TicketId FROM Ticket WHERE UserId = :UserId";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':UserId', $UserId);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ArrayOfTicketId[] = $row['TicketId'];
        }
        return $ArrayOfTicketId;
    }

    public function updateStatusT($TicketId, $StatusT)
    {
        if ($this->isTicketExist($TicketId)) {
            $sql = "UPDATE Ticket SET StatusT = :StatusT WHERE TicketId = :TicketId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':StatusT', $StatusT);
            $stmt->bindParam(':TicketId', $TicketId);
            $stmt->execute();
        }

    }

    public function isTicketExist($TicketId): bool
    {
        $sql = "SELECT count(*) FROM Ticket WHERE TicketId = :TicketId";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':TicketId', $TicketId);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    public function deleteTicket($TicketId)
    {
        if ($this->isTicketExist($TicketId)) {
            $sql = "DELETE FROM Ticket WHERE TicketId = :TicketId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':TicketId', $TicketId);
            $stmt->execute();
        }
    }

    public function getValuesByUserId($UserId)
    {
        $sql = "SELECT * FROM Ticket WHERE UserId = :UserId";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':UserId', $UserId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}