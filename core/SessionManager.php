<?php

class SessionManager
{
    //private $sessionID;
    private static ?USERSite $userObject = null;

    public static function sessionLinkObject(){
        $_SESSION['UserId']=self::$userObject->getId();
        $_SESSION['Username']=self::$userObject->getPseudo();
        $_SESSION['Ip']=self::$userObject->getLastIpAdress();
        $_SESSION['Status']=self::$userObject->getStatus();
        $_SESSION['LastConnexion']=self::$userObject->getDateLastLogin();
    }

    //TODO limité taille entrée utilisateur: pseudo, mail, password
    public static function SignUp($A_postParams)
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

    public static function Login($A_postParams)
    {
        // on vérifie qu'il n'y est pas une session active
            if (self::$userObject!==null) {
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

    public static function disconnect()
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
    public static function logout() //alias
    {
        self::disconnect();
    }
}