<?php

class SessionManager
{
    public static function isUserConnected(): bool
    {
        if (isset($_SESSION["UserId"])) {
            return true;
        }
        return false;
    }
    //private $sessionID;
    private static ?USERSiteModel $userObject = null;

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
        $_SESSION['UrlPicture']=self::$userObject->getUrlPicture(); //TODO SECURISER IMAGES
    }
    public static function SignUp($A_postParams): string
    {
        $status = ((new UserSite)->createUser(
            $A_postParams["pseudo"],
            $A_postParams["mail"],
            $A_postParams["password"]));

        if ($status instanceof ExceptionsDatabase) {
            return "Error : " . $status->getMessage();
        }
        else {
            self::$userObject=new USERSiteModel($status); // création d'un utilisateur pour la classe
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
                // test si l'ip enregistré est la meme que celle de la session
                if (self::$userObject->getLastIpAdress() !== $_SERVER['REMOTE_ADDR']) {
                    // on deconnecte
                    self::disconnect();
                    return "disconnected" ;
                }

                session_regenerate_id();
                header("Location: /");
                return "success";

            }
        else {
            // essai de se connecter

            $status = ((new UserSite)->loginUser(
                $A_postParams["mail"],
                $A_postParams["password"]));

            if ($status instanceof ExceptionsDatabase) {
                return "Error : " . $status->getMessage();
            }
            else {
                self::$userObject=new USERSiteModel($status); // création d'un utilisateur pour la classe
                self::sessionLinkObject();
                //$_SESSION["UserId"] = $status;
                //$_SESSION['Ip'] = $_SERVER['REMOTE_ADDR'];
                //$_SESSION['Username'] = strtolower($A_postParams['pseudo']);
                return "success";

            }
        }
    }
    public static function disconnect(): void
    {
        if (isset($_SESSION["UserId"])) { // self::$userObject!==null ? a remplacer ???
            $id = $_SESSION["UserId"];
            ((new UserSite)->disconnectUser($id));
            session_unset();
            session_destroy();
            header("Location: /");
            exit;

        }else {
            session_start();
            session_unset();
            session_destroy();
            header("Location: /");
            exit;
        }
    }
    public static function logout(): void //alias
    {
        self::disconnect();
    }
    public static function checkValiditySessionTime(): void
    {
        // Fonctionne correctement
        if (isset($_SESSION["LastConnexion"])) {
            $lastConnexionDate = DateTime::createFromFormat('Y-m-d H:i:s', $_SESSION["LastConnexion"]);
            $lastConnexionTimestamp = $lastConnexionDate->getTimestamp();

            if ((time() - $lastConnexionTimestamp) > Constants::DECONNEXION_TIME){
                self::disconnect();
            }
        }
    }
}