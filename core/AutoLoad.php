<?php
require 'config/Constants.php';

/**
 * La classe AutoLoad permet le chargement des classes de maniere automatique
 *
 * cette classe est en lien direct avec le fichier Constants.php qui contient les emplacements des dossiers,
 * on charge les classes suivantes :
 * - les classes du core
 * - les classes des exceptions
 * - les classes de l'orm (dans le model)
 * - les classes du model
 * - les classes de la vue
 * - les classes du controller
 *
 * @see Constants
 * @package core
 * @since 1.0
 * @version 1.0
 * @category Autoload
 * @author Tom Carvajal & Killian Ferrier
 */
final class AutoLoad
{

    /**
     * Méthode pour charger les classes du core
     *
     * @param string $S_className
     * @return void|null
     */
    public static function coreClassesLoader ($S_className)
    {
        $S_file = Constants::coreDirectory() . "$S_className.php";
        return static::_load($S_file);
    }

    /**
     * Méthode pour charger les classes des exceptions
     *
     * @param string $S_className
     * @return void|null
     */
    public static function exceptionsClassesLoader ($S_className)
    {
        $S_file = Constants::exceptionsDirectory() . "$S_className.php";

        return static::_load($S_file);
    }

    /**
     * Méthode pour charger les classes du model
     *
     * @param string $S_className
     * @return void|null
     */
    public static function modelClassesLoader ($S_className)
    {
        $S_file = Constants::modelDirectory() . "$S_className.php";

        return static::_load($S_file);
    }

    /**
     * Méthode pour charger les classes de l'orm
     *
     * @param string $S_className
     * @return void|null
     */
    public static function ORMClassesLoader ($S_className)
    {
        $S_file = Constants::ORMDirectory() . "$S_className.php";

        return static::_load($S_file);
    }

    /**
     * Méthode pour charger les classes des views
     *
     * @param string $S_className
     * @return void|null
     */
    public static function viewClassesLoader ($S_className)
    {
        $S_file = Constants::viewsDirectory() . "$S_className.php";

        return static::_load($S_file);
    }

    /**
     * Méthode pour charger les classes du controller
     *
     * @param string $S_className
     * @return void|null
     */
    public static function controllerClassesLoader ($S_className)
    {
        $S_file = Constants::controllerDirectory() . "$S_className.php";

        return static::_load($S_file);
    }

    /**
     * Méthode pour charger le fichier entré en paramètre
     *
     * @param $fileToLoad
     * @return void
     */
    private static function _load ($fileToLoad): void
    {
        if (is_readable($fileToLoad))
        {
            require $fileToLoad;
        }
    }
}

// J'empile tout ce beau monde comme j'ai toujours appris à le faire...
spl_autoload_register('autoLoad::coreClassesLoader');
spl_autoload_register('autoLoad::exceptionsClassesLoader');
spl_autoload_register('autoLoad::modelClassesLoader');
spl_autoload_register('autoLoad::viewClassesLoader');
spl_autoload_register('autoLoad::controllerClassesLoader');
spl_autoload_register('autoLoad::ORMClassesLoader');