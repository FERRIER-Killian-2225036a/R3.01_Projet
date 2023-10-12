<?php
require 'config/constants.php';

final class AutoLoad
{
    public static function coreClassesLoader ($S_className)
    {
        $S_file = Constants::coreDirectory() . "$S_className.php";
        return static::_load($S_file);
    }

    public static function exceptionsClassesLoader ($S_className)
    {
        $S_file = Constants::exceptionsDirectory() . "$S_className.php";

        return static::_load($S_file);
    }

    public static function modelClassesLoader ($S_className)
    {
        $S_file = Constants::modelDirectory() . "$S_className.php";

        return static::_load($S_file);
    }


    public static function viewClassesLoader ($S_className)
    {
        $S_file = Constants::viewsDirectory() . "$S_className.php";

        return static::_load($S_file);
    }

    public static function controllerClassesLoader ($S_className)
    {
        $S_file = Constants::controllerDirectory() . "$S_className.php";

        return static::_load($S_file);
    }
    private static function _load ($S_fileACharger)
    {
        if (is_readable($S_fileACharger))
        {
            require $S_fileACharger;
        }
    }
}

// J'empile tout ce beau monde comme j'ai toujours appris à le faire...
spl_autoload_register('autoLoad::coreClassesLoader');
spl_autoload_register('autoLoad::exceptionsClassesLoader');
spl_autoload_register('autoLoad::modelClassesLoader');
spl_autoload_register('autoLoad::viewClassesLoader');
spl_autoload_register('autoLoad::controllerClassesLoader');