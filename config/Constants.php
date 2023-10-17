<?php
require "safe.php"; // Ici, je récupère les identifiants de connexion à la base de données

final class Constants
{
    const VIEW_DIRECTORY        = '/views/';
    const MODEL_DIRECTORY      = '/models/';
    const CORE_DIRECTORY       = '/core/';
    const EXCEPTION_DIRECTORY  = '/monitoring/exceptions/';
    const CONTROLLER_DIRECTORY = '/controllers/';

    //const DB = ;

    public static function rootDirectory(): false|string
    {
        return realpath(__DIR__ . '/../');
    }

    public static function coreDirectory(): string
    {
        return self::rootDirectory() . self::CORE_DIRECTORY;
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
}