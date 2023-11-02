<?php

/**
 * la Classe USERSiteModel du model directement en lien avec l'orm , on a cette classe pour eviter de trop faire
 * de requete de lecture sur les données d'un utilisateur.
 *
 * Cette classe principale concerne les données de tout les utilisateurs de notre site dans notre base de donnée.
 *
 * @see UserSite
 * @see ControllerSettings
 * @see SessionManager
 *
 * @package models
 * @since 1.0
 * @version 1.0
 * @category User
 * @author Tom Carvajal
 */
class USERSiteModel
{
    /**
     * @var int L'identifiant de l'utilisateur.
     */
    private int $Id;

    /**
     * @var string|null L'URL de la photo de profil.
     */
    private ?string $UrlPicture;

    /**
     * @var string L'adresse e-mail de l'utilisateur.
     */
    private string $Mail;

    /**
     * @var string Le pseudo ou nom d'utilisateur.
     */
    private string $Pseudo;

    /**
     * @var string La date du premier accès.
     */
    private string $DateFirstLogin;

    /**
     * @var string La date du dernier accès.
     */
    private string $DateLastLogin;

    /**
     * @var string Le rôle ou le niveau d'autorisation de l'utilisateur.
     */
    private string $Role;

    /**
     * @var int Le niveau d'alerte de l'utilisateur.
     */
    private int $AlertLevelUser;

    /**
     * @var int Le nombre d'actions de l'utilisateur.
     */
    private int $NumberOfAction;

    /**
     * @var string Le statut de l'utilisateur.
     */
    private string $Status;

    /**
     * @var string L'adresse IP du dernier accès.
     */
    private string $lastIpAdress;

    /**
     * @var int Le nombre de connexions de l'utilisateur.
     */
    private int $NumberOfConnection;

    /**
     * USERSiteModel constructor.
     * @param int $A_Id
     */
    public function __construct(int $A_Id)
    {
        $temp_array = (new UserSite)->getValuesById($A_Id);
        $this->Id = $A_Id;
        $this->Mail = $temp_array["Mail"];
        $this->Pseudo = $temp_array["Pseudo"];
        $this->DateFirstLogin = $temp_array["DateFirstLogin"];
        $this->DateLastLogin = $temp_array["DateLastLogin"];
        $this->Role = $temp_array["Role"];
        $this->AlertLevelUser = $temp_array["AlertLevelUser"];
        $this->NumberOfAction = $temp_array["NumberOfAction"];
        $this->Status = $temp_array["Status"];
        $this->lastIpAdress = $temp_array["LastIpAdress"];
        $this->NumberOfConnection = $temp_array["NumberOfConnection"];
        $this->UrlPicture = $temp_array["UrlPicture"];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->Id;
    }

    /**
     * @return string
     */
    public function getUrlPicture(): string
    {
        return $this->UrlPicture;
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->Mail;
    }

    /**
     * @return string
     */
    public function getPseudo(): string
    {
        return $this->Pseudo;
    }

    /**
     * @return string
     */
    public function getDateFirstLogin(): string
    {
        return $this->DateFirstLogin;
    }

    /**
     * @return string
     */
    public function getDateLastLogin(): string
    {
        return $this->DateLastLogin;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->Role;
    }

    /**
     * @return int
     */
    public function getAlertLevelUser(): int
    {
        return $this->AlertLevelUser;
    }

    /**
     * @return int
     */
    public function getNumberOfAction(): int
    {
        return $this->NumberOfAction;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->Status;
    }

    /**
     * @return string
     */
    public function getLastIpAdress(): string
    {
        return $this->lastIpAdress;
    }

    /**
     * @return int
     */
    public function getNumberOfConnection(): int
    {
        return $this->NumberOfConnection;
    }

    /**
     * méthode pour recuperer le nombre de follower d'un utilisateur (pas le nombre d'abonnement de l'utilisateur)
     *
     * @return bool|int
     */
    public function getNumberOfFollower(): bool|int
    {
        return (new FollowedUser)->getNumberOfFollower($this->Id);
    }


}