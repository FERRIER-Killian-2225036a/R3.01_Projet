<?php
final class Constants
{
    const VIEW_DIRECTORY        = '/views/';
    const MODEL_DIRECTORY      = '/models/';
    const CORE_DIRECTORY       = '/core/';
    const EXCEPTION_DIRECTORY  = '/monitoring/exceptions/';
    const CONTROLLER_DIRECTORY = '/controllers/';
    const ORM_DIRECTORY = '/models/ORM/';

    const DB = array(
        "dbname"=>"cyphubte_db",
        "host"=>"localhost",
        "usr"=>"cyphubte_normal_user",
        "pwd"=>"eyeF[9ek&MTi", // on changera le mot de passe quand ce sera en prod, (mot de passe temporaire)
        "charset"=>"utf8mb4"
    );


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

    public static function ORMDirectory(): string
    {
        return self::rootDirectory() . self::ORM_DIRECTORY;
    }
}