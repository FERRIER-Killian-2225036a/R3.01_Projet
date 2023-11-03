<?php

/**
 * la Classe BlacklistUser de l'orm pour faire les acces a la base de données et recuperer les valeurs de la table BLACKLIST
 *
 * les attributs de la table BLACKLIST sont :
 * - idBlacklist : int
 * - UserID : int
 * - DateB : datetime
 * - Reason : varchar(100)
 * - Duration : datetime
 *
 * Cette classe permet de récuperer les données des utilisateurs banni afin de bloquer leur accès aux fonctionnalités
 * du site (temporairement ou non).
 *
 * La gestion des bans se fait par les modérateurs et administrateurs.
 *
 * @see ControllerModo
 * @see UserSite
 *
 * @package models/ORM
 * @since 1.0
 * @version 1.0
 * @category modération
 * @author Tom Carvajal & Vanessa Guil
 */
class BlacklistUser
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
     * ITPage constructor.
     */
    public function __construct()
    {
        $this->DBBrain = new DBBrain();
        $this->conn = $this->DBBrain->getConn();
    }

    /**
     * pour rechercher un utilisateur banni par son id ou sa raison
     *
     * @param $inputToSearch
     * @return array|false
     */
    public function getIdBlacklistByResearch($inputToSearch): false|array
    {
        $sql = "SELECT idBlacklist FROM BLACKLIST WHERE UserID = ? OR Reason LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $inputToSearch, PDO::PARAM_INT);
        $stmt->bindValue(2, $inputToSearch, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserIdByBlacklistId(mixed $id)
    {
        $sql = "SELECT UserID FROM BLACKLIST WHERE idBlacklist = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}