<?php

final class Constants
{

    const VIEW_DIRECTORY = '/views/';
    const MODEL_DIRECTORY = '/models/';
    const CORE_DIRECTORY = '/core/';
    const EXCEPTION_DIRECTORY = '/monitoring/exceptions/';
    const CONTROLLER_DIRECTORY = '/controllers/';
    const ORM_DIRECTORY = '/models/ORM/';
    const UserIdForItArticle = 238;
    const DECONNEXION_TIME = 86400;
    const PICTURE_URL_DEFAULT = "";
    const PDP_URL_DEFAULT = "";
    const PEPPER = "mjOlvxisvFdxMDpecFwc1d";
    const MAIL_FROM_EMAIL = "noreply@cyphub.tech";
    public static $BDD_PASSWORD = '';
    public static $DB; // TODO : mettre une image par défaut

    public static function coreDirectory(): string
    {
        return self::rootDirectory() . self::CORE_DIRECTORY;
    } // TODO : mettre une image par défaut

    public static function rootDirectory(): false|string
    {
        return realpath(__DIR__ . '/../');
    }

    public static function exceptionsDirectory(): string
    {
        return self::rootDirectory() . self::EXCEPTION_DIRECTORY;
    }

    public static function viewsDirectory(): string
    {
        return self::rootDirectory() . self::VIEW_DIRECTORY;
    }

    public static function modelDirectory(): string
    {
        return self::rootDirectory() . self::MODEL_DIRECTORY;
    }

    public static function controllerDirectory(): string
    {
        return self::rootDirectory() . self::CONTROLLER_DIRECTORY;
    }

    public static function ORMDirectory(): string
    {
        return self::rootDirectory() . self::ORM_DIRECTORY;
    }

    public static function defineFakeConst()
    {
        $chemin_pwd_bdd = dirname(__FILE__, 2) . "../../CONSTANTES_MDP.txt";
        error_log($chemin_pwd_bdd);
        if (file_exists($chemin_pwd_bdd)) {
            error_log("le fichier existe");
            $mot_de_passe = file_get_contents($chemin_pwd_bdd);
            // Assurez-vous de nettoyer ou valider le mot de passe lu depuis le fichier, par exemple, en utilisant trim() ou d'autres validations.
            Constants::setBDDPASSWORD($mot_de_passe);
            Constants::setDB(array(
                "dbname" => "cyphubte_db",
                "host" => "localhost",
                "usr" => "cyphubte_normal_user",
                "pwd" => Constants::$BDD_PASSWORD, // TODO on changera le mot de passe quand ce sera en prod, (mot de passe temporaire)
                "charset" => "utf8mb4"));
        }
        else {
            error_log("le fichier n'existe pas");
        }
    }

    public static function setBDDPASSWORD(string $BDD_PASSWORD): void
    {
        self::$BDD_PASSWORD = $BDD_PASSWORD;
    }

    public static function setDB($DB): void
    {
        self::$DB = $DB;
    }
}

