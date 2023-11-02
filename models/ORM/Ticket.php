<?php

/**
 * Classe de l'orm pour faire les acces a la base de données et recuperer les valeurs de la table TICKET
 *
 * les attributs de la table TICKET sont :
 * - TicketId : int
 * - mail : varchar(50)
 * - date : datetime
 * - description : text
 * - statusT : enum('inProgress','read','do') DEFAULT 'inProgress'
 * - title : varchar(50)
 * - UserId : int
 *
 * Cette classe fait permet de récuperer les tickets des utilisateurs en demande de support
 *
 * @see ControllerModo
 * @see ControllerSettings
 * @see UserSite
 * @see TicketModel
 *
 * @package models/ORM
 * @since 1.0
 * @version 1.0
 * @category support
 * @author Tom Carvajal & Vanessa Guil
 */
class Ticket
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
     * Ticket constructor.
     */
    public function __construct()
    {
        $this->DBBrain = new DBBrain();
        $this->conn = $this->DBBrain->getConn();
    }

    /**
     * Cette méthode permet de créer un ticket
     *
     * @param string $mail
     * @param string $description
     * @param string $statusT
     * @param string $title
     * @param int $UserId
     * @return false|string
     */
    public function createTicket(string $mail, string $description, string $statusT,
                                 string $title, int $UserId): false|string
    {
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

    /**
     * cette méthode permet de recuperer les infos d'un ticket par rapport a son identifiant, si il existe
     *
     * @param int $TicketId
     * @return false|array
     */
    public function getTicket(int $TicketId): bool|array
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

    /**
     * Cette méthode permet de recuperer les infos de tout les tickets d'un utilisateur
     *
     * @param int $UserId
     * @return array
     */
    public function getAllTicketIdOfUser(int $UserId): array
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

    /**
     * Cette méthode permet de mettre a jour le statut d'un ticket par rapport a son identifiant
     *
     * @param int $TicketId
     * @param string $StatusT
     * @return void
     */
    public function updateStatusT(int $TicketId, string $StatusT): void
    {
        if ($this->isTicketExist($TicketId)) {
            $sql = "UPDATE TICKET SET StatusT = :StatusT WHERE TicketId = :TicketId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':StatusT', $StatusT);
            $stmt->bindParam(':TicketId', $TicketId);
            $stmt->execute();
        }

    }

    /**
     * Cette méthode permet de verifier si un ticket existe grace a son identifiant
     *
     * @param int $TicketId
     * @return bool
     */
    public function isTicketExist(int $TicketId): bool
    {
        $sql = "SELECT count(*) FROM TICKET WHERE TicketId = :TicketId";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':TicketId', $TicketId);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    /**
     * Cette methode permet de supprimer un ticket par rapport a son identifiant
     *
     * @param int $TicketId
     * @return void
     */
    public function deleteTicket(int $TicketId): void
    {
        if ($this->isTicketExist($TicketId)) {
            $sql = "DELETE FROM TICKET WHERE TicketId = :TicketId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':TicketId', $TicketId);
            $stmt->execute();
        }
    }

    /**
     * Cette méthode permet de recuperer tout les attributs d'un ticket selon son identifiant.
     *
     * @param int $Id
     * @return array|false
     */
    public function getValuesById($Id)
    {
        $sql = "SELECT * FROM TICKET WHERE TicketId = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $Id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* on ne fais pas ca car pour la plus part des autres objet on a tjrs fait par rapport a clé primaire
    public function getValuesByUserId($UserId)
    {
          error_log("UserId in getValuesByUserId = ".$UserId);
          //$arrayOfValues = array();
          $sql = "SELECT * FROM TICKET WHERE UserId = ?";
          $stmt = $this->conn->prepare($sql);
          $stmt->bindParam(1, $UserId);
          $stmt->execute();
          return $stmt->fetch(PDO::FETCH_ASSOC);
    }*/
}