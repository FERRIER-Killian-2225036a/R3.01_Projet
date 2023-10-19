<?php

class SessionManager
{
    //private $sessionID;
    private static ?USERSite $userObject = null;

    public static function createSession(): void
    {
        session_start();
    }
    public static function sessionLinkObject(): void
    {
        $_SESSION['UserId']=self::$userObject->getId();
        $_SESSION['Username']=self::$userObject->getPseudo();
        $_SESSION['Ip']=self::$userObject->getLastIpAdress();
        $_SESSION['Status']=self::$userObject->getStatus();
        $_SESSION['LastConnexion']=self::$userObject->getDateLastLogin();
    }

    //TODO limité taille entrée utilisateur: pseudo, mail, password
    public static function SignUp($A_postParams): string
    {
        $status = ((new UserSiteModel)->createUser(
            $A_postParams["pseudo"],
            $A_postParams["mail"],
            $A_postParams["password"]));

        if ($status instanceof ExceptionsDatabase) {
            return "Error : " . $status->getMessage();
        }
        else {
            self::$userObject=new USERSite($status); // création d'un utilisateur pour la classe
            self::sessionLinkObject();
            //$_SESSION["UserId"] = $status;
            //$_SESSION['Ip'] = $_SERVER['REMOTE_ADDR'];
            //$_SESSION['Username'] = strtolower($A_postParams['pseudo']);
            return "success";
        }
    }

    public static function Login($A_postParams): string
    {
        // on vérifie qu'il n'y est pas une session active
            if (self::$userObject!==null) {
                session_regenerate_id();
                header("Location: /");
                return "success";

            }
        else {
            // essai de se connecter

            // TODO to change
            $status = ((new UserSiteModel)->loginUser(
                $A_postParams["mail"],
                $A_postParams["password"]));

            if ($status instanceof ExceptionsDatabase) {
                return "Error : " . $status->getMessage();
            }
            else {
                self::$userObject=new USERSite($status); // création d'un utilisateur pour la classe
                self::sessionLinkObject();
                //$_SESSION["UserId"] = $status;
                //$_SESSION['Ip'] = $_SERVER['REMOTE_ADDR'];
                //$_SESSION['Username'] = strtolower($A_postParams['pseudo']);
                return "success";

            }
        }
    }

    public static function disconnect(): void
    {   //TODO CORRIGER CA
        if (isset($_SESSION["UserId"])) { // self::$userObject!==null ? a remplacer ???
                $id = $_SESSION["UserId"];
                ((new UserSiteModel)->disconnectUser($id));
                session_unset();
                session_destroy();
                header("Location: /");

        }else {
            session_start();
            session_unset();
            session_destroy();
            header("Location: /");
        }
    }
    public static function logout(): void //alias
    {
        self::disconnect();
    }

    public static function checkValiditySessionTime(): void
    {
        if (isset($_SESSION["LastConnexion"]) && (time() -$_SESSION["LastConnexion"])>86400 ){
            session_unset();
            session_destroy();
            header("Location : /");
        }
    }
}