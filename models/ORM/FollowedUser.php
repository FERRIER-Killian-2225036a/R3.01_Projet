<?php

/**
 * la Classe FollowedUser de l'orm pour faire les acces a la base de données et recuperer les valeurs de la table FollowedUser
 *
 * les attributs de la table FollowedUser sont :
 * - FollowId : int
 * - UserId : int
 * - UserFollow : int
 * - dateF : datetime
 *
 * Cette classe fait le lien entre un User et ses abonnements a d'autres utilisateurs
 *
 * @see UserSite
 *
 * @package models/ORM
 * @since 1.0
 * @version 1.0
 * @category FollowedUser
 * @author Tom Carvajal & Vanessa Guil
 */
class FollowedUser
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
     * Blog_PageLike constructor.
     */
    public function __construct()
    {
        $this->DBBrain = new DBBrain();
        $this->conn = $this->DBBrain->getConn();
    }

    /**
     * cette methode renvoie le nombre d'abonnée d'un utilisateur;
     *
     * @param int $UserID
     * @return int|array|false
     */
    public function getNumberOfFollower(int $UserID): bool|int|array
    {
        $sql = "SELECT COUNT(*) FROM FollowedUser WHERE UserId = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $UserID, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result;
    }

    /**
     *
     * Méthode pour savoir si un utilisateur est abonné à un autre
     *
     * @param int $Id
     * @param int $UserId
     * @return bool
     */
    public function isFollowed(int $Id, int $UserId): bool
    {
        $sql = "SELECT COUNT(*) FROM FollowedUser WHERE UserId = ? AND UserFollow = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $Id, PDO::PARAM_INT); // verifier si il faut pas inverser ces deux lignes
        $stmt->bindValue(2, $UserId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        if ($result > 0) {
            return true;
        }
        return false;

    }

    /**
     * Méthode pour supprimer un abonnée
     *
     * @param int $Id
     * @param int $UserId
     * @return void
     */
    public function removeFollower(int $Id, int $UserId): void
    {
        $sql = "DELETE FROM FollowedUser WHERE UserId = ? AND UserFollow = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $Id, PDO::PARAM_INT); // verifier ordre bdd
        $stmt->bindValue(2, $UserId, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * méthode pour ajouté un abonné a sa liste d'abonnée
     *
     * @param int $Id
     * @param int $UserId
     * @return void
     */
    public function addFollower(int $Id, int $UserId): void
    {
        // si Userid n'est pas deja abonné a Id
        if (!$this->isFollowed($Id, $UserId)) {
            $sql = "INSERT INTO FollowedUser (UserId, UserFollow,dateF) VALUES (?, ?,CURRENT_TIMESTAMP)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $Id, PDO::PARAM_INT); // verifier ordre bdd
            $stmt->bindValue(2, $UserId, PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    /**
     * méthode pour recuperer tous les abonnements d'un utilisateur
     *
     * @param int|string $UserId
     * @return array|false
     */
    public function getAllFollowedUser(int|string $UserId): false|array
    {
        $sql = "SELECT UserId FROM FollowedUser WHERE UserFollow = ?"; // TODO a verifier pcq la dislexie
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $UserId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * méthode pour recuperer le nombre d'abonnements d'un utilisateur
     *
     * @param int|string $UserId
     * @return int|false
     */
    public function getNumberOfFollowed(int|string $UserId): false|int
    {
        $sql = "SELECT COUNT(*) FROM FollowedUser WHERE UserFollow = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $UserId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result;
    }
}