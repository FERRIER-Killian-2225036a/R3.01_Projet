<?php

/**
 * la Classe MutedUser de l'orm pour faire les acces a la base de données et recuperer les valeurs de la table MUTE
 *
 * les attributs de la table MUTE sont :
 * - idMute : int
 * - UserID : int
 * - DateM : datetime
 * - Reason : varchar(100)
 * - Duration : datetime
 *
 * Cette classe permet de récuperer les données des utilisateurs mutés afin de bloquer leur accès aux fonctionnalités
 * du site (temporairement ou non). On cible ici l'impossibilité pour un utilisateur de poster des commentaires/du contenu.
 * il est spectateur seulement.
 *
 * La gestion des mutes se fait par les modérateurs et administrateurs.
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
class MutedUser
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
    public function getIdMuteByResearch($inputToSearch): false|array
    {
        $sql = "SELECT idMute FROM MUTE WHERE UserID = ? OR Reason LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $inputToSearch, PDO::PARAM_INT);
        $stmt->bindValue(2, $inputToSearch, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * méthode pour recuperer l'userId d'un mute
     *
     * @param string|int $id
     * @return false|array
     */
    public function getUserIdByMuteId(string|int $id) :false|array
    {
        $sql = "SELECT UserID FROM MUTE WHERE idMute = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}