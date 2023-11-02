<?php

/**
 * la Classe SessionManager utilitaire de gestion des sessions
 *
 * cette classe est responsable de la gestion des sessions est en lien avec tout les mécanisme d'authentification entre
 * le model et le controller d'authentification, ainsi qu'au niveau du motor controller afin de verifier si
 * un utilisateur est connecter ou non.
 *
 * @see ControllerAuth
 * @see MotorController
 * @see ControllerSettings
 * @see ControllerPost
 * @see USERSiteModel
 *
 * @package core
 * @since 1.0
 * @version 1.0
 * @category SessionManager
 * @author Tom Carvajal
 */
class SessionManager
{
    /**
     * @var USERSiteModel|null $userObject objet utilisateur contenant les infos depuis le model (bdd)
     */
    private static ?USERSiteModel $userObject = null;

    /**
     * Méthode pour vérifier si l'utilisateur courant est connecté
     * on detecte ca par rapport a la super global $_SESSION
     *
     * @return boolean
     */
    public static function isUserConnected(): bool
    {
        if (isset($_SESSION["UserId"])) {
            return true;
        }
        return false;
    }

    /**
     * Méthode pour creer une session (et pour recuperer la session si elle existe)
     *
     * @return void
     */
    public static function createSession(): void
    {
        session_start();
    }

    /**
     * Méthode pour lier l'objet utilisateur a la session
     *
     * @return void
     */
    public static function sessionLinkObject(): void
    {
        $_SESSION['UserId']=self::$userObject->getId();
        $_SESSION['Username']=self::$userObject->getPseudo();
        $_SESSION['Ip']=self::$userObject->getLastIpAdress();
        $_SESSION['Status']=self::$userObject->getStatus();
        $_SESSION['LastConnexion']=self::$userObject->getDateLastLogin();
        $_SESSION['UrlPicture']=self::$userObject->getUrlPicture();
        $_SESSION['Mail']=self::$userObject->getMail();
    }

    /**
     * Méthode pour s'inscrire (creer un compte)
     *
     * @param $A_postParams
     * @return string
     */
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
            return "success";
        }
    }

    /**
     * Méthode pour se connecter
     *
     * @param $A_postParams
     * @return string
     */
    public static function Login($A_postParams): string
    {
        // on vérifie qu'il n'y est pas une session active
            if (self::$userObject!==null) { // comportement suspect ?
                // test si l'ip enregistré est la meme que celle de la session
                if (self::$userObject->getLastIpAdress() !== $_SERVER['REMOTE_ADDR']) {
                    // on deconnecte
                    self::disconnect();
                    return "disconnected" ;
                }
                session_regenerate_id(); // on regenere l'id de la session pour eviter les attaques par fixation de session
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

    /**
     * Méthode pour se deconnecter
     *
     * @return void
     */
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

    /**
     * Méthode pour se deconnecter (alias)
     *
     * @return void
     */
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