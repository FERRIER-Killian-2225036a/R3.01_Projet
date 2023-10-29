<?php

final class Constants
{

    const VIEW_DIRECTORY = '/views/';
    const MODEL_DIRECTORY = '/models/';
    const CORE_DIRECTORY = '/core/';
    const EXCEPTION_DIRECTORY = '/monitoring/exceptions/';
    const CONTROLLER_DIRECTORY = '/controllers/';
    const ORM_DIRECTORY = '/models/ORM/';
    const MEDIA_DIRECTORY = '/media/';
    const MEDIA_DIRECTORY_USERS = '/media/users/';
    const UserIdForItArticle = 238;
    const DECONNEXION_TIME = 86400;
    const PICTURE_URL_DEFAULT = "/media/public_assets/imageTest.jpeg";
    const PDP_URL_DEFAULT = "/media/users/Profil.png";
    const MAIL_FROM_EMAIL = "noreply@cyphub.tech";

    public static $BDD_PASSWORD = '';
    public static $DB; // TODO : mettre une image par défaut
    public static mixed $API_KEY_GOOGLE_VISION;

    public static mixed $PEPPER;
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
    public static function mediaDirectory(): string
    {
        return self::rootDirectory() . self::MEDIA_DIRECTORY;
    }
    public static function mediaDirectoryUsers(): string
    {
        return self::rootDirectory() . self::MEDIA_DIRECTORY_USERS;
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
        $chemin_pwd_bdd = dirname(__FILE__, 2) . "/../CONSTANTES_MDP.txt";
        if (file_exists($chemin_pwd_bdd)) {
            $mot_de_passe = file_get_contents($chemin_pwd_bdd);
            Constants::setBDDPASSWORD($mot_de_passe);
            Constants::setDB(array(
                "dbname" => "cyphubte_db",
                "host" => "localhost",
                "usr" => "cyphubte_normal_user",
                "pwd" => Constants::$BDD_PASSWORD, // TODO on changera le mot de passe quand ce sera en prod, (mot de passe temporaire)
                "charset" => "utf8mb4"));
        }
        $chemin_apiKey = dirname(__FILE__, 2) . "/../APIKEY.txt";
        if (file_exists($chemin_apiKey)) {
            $API = file_get_contents($chemin_apiKey);
            Constants::setApiKey($API);
        }
        $chemin_pepper = dirname(__FILE__, 2) . "/../PEPPER.txt";
        if (file_exists($chemin_pepper)) {
            $Pepper = file_get_contents($chemin_pepper);
            Constants::setPepper($Pepper);
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
    public static function setPepper($Pepper): void
    {
        self::$PEPPER = $Pepper;
    }
    public static function setApiKey($ApiKey): void
    {
        self::$API_KEY_GOOGLE_VISION = $ApiKey;
    }
}

