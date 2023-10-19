<?php

class USERSite
{
    private $Id;
    private $Mail;
    private $Pseudo;
    private $DateFirstLogin;
    private $DateLastLogin;
    private $Role;
    private $AlertLevelUser;
    private $NumberOfAction;
    private $Status;
    private $lastIpAdress;
    private $NumberOfConnection;

    public function getMail(): mixed
    {
        return $this->Mail;
    }

    public function setMail(mixed $Mail): void
    {
        $this->Mail = $Mail;
    }

    public function getPseudo(): mixed
    {
        return $this->Pseudo;
    }

    public function setPseudo(mixed $Pseudo): void
    {
        $this->Pseudo = $Pseudo;
    }

    public function getDateFirstLogin(): mixed
    {
        return $this->DateFirstLogin;
    }

    public function setDateFirstLogin(mixed $DateFirstLogin): void
    {
        $this->DateFirstLogin = $DateFirstLogin;
    }

    public function getDateLastLogin(): mixed
    {
        return $this->DateLastLogin;
    }

    public function setDateLastLogin(mixed $DateLastLogin): void
    {
        $this->DateLastLogin = $DateLastLogin;
    }

    public function getRole(): mixed
    {
        return $this->Role;
    }

    public function setRole(mixed $Role): void
    {
        $this->Role = $Role;
    }

    public function getAlertLevelUser(): mixed
    {
        return $this->AlertLevelUser;
    }

    public function setAlertLevelUser(mixed $AlertLevelUser): void
    {
        $this->AlertLevelUser = $AlertLevelUser;
    }

    public function getNumberOfAction(): mixed
    {
        return $this->NumberOfAction;
    }

    public function setNumberOfAction(mixed $NumberOfAction): void
    {
        $this->NumberOfAction = $NumberOfAction;
    }

    public function getStatus(): mixed
    {
        return $this->Status;
    }

    public function setStatus(mixed $Status): void
    {
        $this->Status = $Status;
    }

    public function getLastIpAdress(): mixed
    {
        return $this->lastIpAdress;
    }

    public function setLastIpAdress(mixed $lastIpAdress): void
    {
        $this->lastIpAdress = $lastIpAdress;
    }

    public function getNumberOfConnection(): mixed
    {
        return $this->NumberOfConnection;
    }

    public function setNumberOfConnection(mixed $NumberOfConnection): void
    {
        $this->NumberOfConnection = $NumberOfConnection;
    }

    public function getId()
    {
        return $this->Id;
    }

    public function setId($Id): void
    {
        $this->Id = $Id;
    }
    public function __construct($A_Id)
    {
        $temp_array = (new UserSiteModel)->getValuesById($A_Id);
        $this->Id = $A_Id;
        $this->Mail=$temp_array["Mail"];
        $this->Pseudo=$temp_array["Pseudo"];
        $this->DateFirstLogin=$temp_array["DateFirstLogin"];
        $this->DateLastLogin=$temp_array["DateLastLogin"];
        $this->Role=$temp_array["Role"];
        $this->AlertLevelUser=$temp_array["AlertLevelUser"];
        $this->NumberOfAction=$temp_array["NumberOfAction"];
        $this->Status=$temp_array["Status"];
        $this->lastIpAdress=$temp_array["LastIpAdress"];
        $this->NumberOfConnection=$temp_array["NumberOfConnection"];

    }



}