<?php

/**
 * Classe de constantes pour la config assez globale
 *
 * définit des constantes et des méthodes pour la gestion des répertoires, des chemins et des paramètres
 * ainsi que des constantes pour l'authentification ou clé d'api.
 * on s'en sert pas mal pour les chemins de fichiers qui seront utilisé dans notre autoloader
 *
 * @see AutoLoad
 * @since 1.0
 * @package config
 * @version 1.0
 * @author Tom Carvajal And Killian Ferrier
 */
final class Constants
{
    /**
     * Constantes pour les chemins de vue
     *
     * @var string
     */
    const VIEW_DIRECTORY = '/views/';

    /**
     * Constantes pour les chemins de modèle
     *
     * @var string
     */
    const MODEL_DIRECTORY = '/models/';

    /**
     * Constantes pour les chemins du noyau / coeur
     *
     * @var string
     */
    const CORE_DIRECTORY = '/core/';

    /**
     * Constantes pour les chemins des exceptions
     *
     * @var string
     */
    const EXCEPTION_DIRECTORY = '/monitoring/exceptions/';

    /**
     * Constantes pour les chemins des contrôleurs
     *
     * @var string
     */
    const CONTROLLER_DIRECTORY = '/controllers/';

    /**
     * Constantes pour les chemins des ORM au niveau du model
     *
     * @var string
     */
    const ORM_DIRECTORY = '/models/ORM/';

    /**
     * Constantes pour le chemin des médias (on stock dans le dossier média surtout des images)
     *
     * @var string
     */
    const MEDIA_DIRECTORY = '/media/';

    /**
     * Constantes pour le chemin des médias des utilisateurs càd leurs photos de profil  (disponible sur le serveur)
     *
     * @var string
     */
    const MEDIA_DIRECTORY_USERS = '/media/users/';

    /**
     * Constantes pour le chemin des médias des posts
     * (blog/forum uniquement car on stock les liens des images des articles) (disponible sur le serveur)
     *
     * @var string
     */
    const MEDIA_DIRECTORY_POSTS = '/media/posts/';


    /**
     * Constantes pour le chemin des médias des blogs (uniquement les images de miniature)
     *
     * @var string
     */
    const MEDIA_DIRECTORY_BLOGS = '/media/posts/blogs/';


    /**
     * Constantes pour l'identifiant du user qui écrit les articles de l'onglet veille tech / actu
     *
     * @var int
     */
    const UserIdForItArticle = 238;

    /**
     * Constantes pour la valeur de durée de vie d'une session (par default 30 minutes) ici 1 jour
     *
     * @var int
     */
    const DECONNEXION_TIME = 86400;

    /**
     * Constantes pour le chemin de l'image par default, on l'utilise pour les Posts par exemple
     *
     * @var int
     */
    const PICTURE_URL_DEFAULT = "/media/public_assets/imageTest.jpeg";

    /**
     * Constantes pour le chemin de l'image de profil par default, on l'utilise pour les Users par exemple
     *
     * @var int
     */
    const PDP_URL_DEFAULT = "/media/users/Profil.png";

    /**
     * Constantes pour l'adresse mail d'envoi de cyphub, on l'avait mit pour l'envoi de mail en tant que cyphub
     *
     * @var string
     */
    const MAIL_FROM_EMAIL = "noreply@cyphub.tech";


    /**
     *  Fausse constante pour le stockage du mdp de la bdd (recup dans un fichier sur le serveur)
     *
     *  on est sur des fausses constantes histoire de garder une syntaxe proche des vrai constantes, la différence est
     *  la présence du $ devant les fausses constantes, toujours accessible avec les ::
     *
     * @var string
     */
    public static string $BDD_PASSWORD = '';

    /**
     *  Fausse constante pour stocker le contenu des credentials de la bdd (recup dans un fichier sur le serveur)
     *
     * @var Array
     */
    public static array $DB;

    /**
     *  Fausse constante pour stocker le contenu de l'api key de google vision (recup dans un fichier sur le serveur)
     *
     * @var string
     */
    public static mixed $API_KEY_GOOGLE_VISION;


    /**
     *  Fausse constante pour stocker le poivre (recup dans un fichier sur le serveur)
     *
     * @var string
     */
    public static mixed $PEPPER;

    /**
     * methode pour renvoyer le chemin absolu du dossier noyau / coeur
     *
     * @return string
     */
    public static function coreDirectory(): string
    {
        return self::rootDirectory() . self::CORE_DIRECTORY;
    }

    /**
     * methode pour renvoyer le chemin absolu du dossier racine
     *
     * @return false|string (false si le chemin n'existe pas)
     */
    public static function rootDirectory(): false|string
    {
        return realpath(__DIR__ . '/../');
    }

    /**
     * methode pour renvoyer le chemin absolu du dossier des exceptions
     *
     * @return string
     */
    public static function exceptionsDirectory(): string
    {
        return self::rootDirectory() . self::EXCEPTION_DIRECTORY;
    }

    /**
     * methode pour renvoyer le chemin absolu du dossier des médias
     *
     * @return string
     */
    public static function mediaDirectory(): string
    {
        return self::rootDirectory() . self::MEDIA_DIRECTORY;
    }

    /**
     * methode pour renvoyer le chemin absolu du dossier des médias des utilisateurs (photos de profil)
     *
     * @return string
     */
    public static function mediaDirectoryUsers(): string
    {
        return self::rootDirectory() . self::MEDIA_DIRECTORY_USERS;
    }


    /**
     * methode pour renvoyer le chemin absolu du dossier des médias des posts (images des posts)
     *
     * @return string
     */
    public static function mediaDirectoryPosts(): string
    {
        return self::rootDirectory() . self::MEDIA_DIRECTORY_POSTS;
    }

    /**
     * methode pour renvoyer le chemin absolu du dossier des views pour l'autoloader
     *
     * @return string
     */
    public static function viewsDirectory(): string
    {
        return self::rootDirectory() . self::VIEW_DIRECTORY;
    }

    /**
     * methode pour renvoyer le chemin absolu du dossier des models pour l'autoloader
     *
     * @return string
     */
    public static function modelDirectory(): string
    {
        return self::rootDirectory() . self::MODEL_DIRECTORY;
    }

    /**
     * methode pour renvoyer le chemin absolu du dossier des controllers pour l'autoloader
     *
     * @return string
     */
    public static function controllerDirectory(): string
    {
        return self::rootDirectory() . self::CONTROLLER_DIRECTORY;
    }


    /**
     * methode pour renvoyer le chemin absolu du dossier de l'ORM pour l'autoloader
     *
     * @return string
     */
    public static function ORMDirectory(): string
    {
        return self::rootDirectory() . self::ORM_DIRECTORY;
    }

    /**
     * methode pour renvoyer le chemin absolu du dossier des médias des blogs (uniquement les images de miniature)
     *
     * @return string
     */
    public static function mediaDirectoryblogs(): string
    {
        return self::rootDirectory() . self::MEDIA_DIRECTORY_BLOGS;

    }

    /**
     * methode pour charger les fausses constantes depuis les fichiers liés
     * @see $BDD_PASSWORD
     * @see $DB
     * @see $API_KEY_GOOGLE_VISION
     * @see $PEPPER
     *
     * @return void
     */
    public static function defineFakeConst(): void
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

    /**
     * setter pour la fausse constante $BDD_PASSWORD
     *
     * @param string $BDD_PASSWORD (valeur de changement)
     * @return void
     */
    public static function setBDDPASSWORD(string $BDD_PASSWORD): void
    {
        self::$BDD_PASSWORD = $BDD_PASSWORD;
    }

    /**
     * setter pour la fausse constante $DB
     *
     * @param array $DB (valeur de changement)
     * @return void
     */
    public static function setDB(array $DB): void
    {
        self::$DB = $DB;
    }

    /**
     * setter pour la fausse constante $API_KEY_GOOGLE_VISION
     *
     * @param string $ApiKey (valeur de changement)
     * @return void
     */
    public static function setApiKey(string $ApiKey): void
    {
        self::$API_KEY_GOOGLE_VISION = $ApiKey;
    }

    /**
     * setter pour la fausse constante $PEPPER
     *
     * @param string $Pepper (valeur de changement)
     * @return void
     */
    public static function setPepper(string $Pepper): void
    {
        self::$PEPPER = $Pepper;
    }


}

