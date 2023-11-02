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
     * @return int|false
     */
    public function getNumberOfFollower(int $UserID): bool|int
    {
        $sql = "SELECT COUNT(FollowId) FROM FollowedUser WHERE UserFollow = :Id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':Id', $UserID, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}