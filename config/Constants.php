<?php
final class Constants
{
    const VIEW_DIRECTORY        = '/views/';
    const MODEL_DIRECTORY      = '/models/';
    const CORE_DIRECTORY       = '/core/';
    const EXCEPTION_DIRECTORY  = '/monitoring/exceptions/';
    const CONTROLLER_DIRECTORY = '/controllers/';

    const DB = array(
        "dbname"=>"temp", // /!\ NE JAMAIS METTRE LE MOT DE PASSE EN CLAIR LORS D'UN PUSH
        "host"=>"temp", // /!\ NE JAMAIS METTRE LE MOT DE PASSE EN CLAIR LORS D'UN PUSH
        "usr"=>"temp", // /!\ NE JAMAIS METTRE LE MOT DE PASSE EN CLAIR LORS D'UN PUSH
        "pwd"=>"temp", // /!\ NE JAMAIS METTRE LE MOT DE PASSE EN CLAIR LORS D'UN PUSH
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
}