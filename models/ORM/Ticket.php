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
        $sql = "INSERT INTO TICKET (mail, date, description, statusT, title, UserId) VALUES (:mail, CURRENT_TIMESTAMP, :description, :statusT, :title, :UserId)";
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
            $sql = "SELECT * FROM TICKET WHERE TicketId = :TicketId";
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
        $sql = "SELECT TicketId FROM TICKET WHERE UserId = :UserId";
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
            $sql = "UPDATE TICKET SET StatusT = :StatusT WHERE TicketId = :TicketId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':StatusT', $StatusT);
            $stmt->bindParam(':TicketId', $TicketId);
            $stmt->execute();
        }

    }

    public function isTicketExist($TicketId): bool
    {
        $sql = "SELECT count(*) FROM TICKET WHERE TicketId = :TicketId";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':TicketId', $TicketId);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    public function deleteTicket($TicketId)
    {
        if ($this->isTicketExist($TicketId)) {
            $sql = "DELETE FROM TICKET WHERE TicketId = :TicketId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':TicketId', $TicketId);
            $stmt->execute();
        }
    }

    public function getValuesByUserId($UserId)
    {
        //$arrayOfValues = array();
        $sql = "SELECT * FROM TICKET WHERE UserId = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $UserId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}