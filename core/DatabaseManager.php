<?php

/**
 * La classe Database Manager integre un singleton pour la connexion a la base de donnée,
 *
 * cette classe permet de se connecter a la base de donnée. Et rejeter des exceptions si la connexion echoue
 * elle cherche les authentifiants dans le fichier constant
 *
 * @see Constants
 *
 * @package core
 * @since 1.0
 * @version 1.0
 * @category DatabaseManager
 * @author Tom Carvajal
 */
class DatabaseManager
{
    /**
     * @var PDO (contient la connexion a la base de donnée)
     */
    private PDO $conn;

    /**
     * getter de la connexion pdo
     * @return PDO
     */
    public function getConn(): PDO
    {
        return $this->conn;
    }

    /**
     * @var DatabaseManager (contient l'instance de la classe qui est un singleton)
     */
    private static DatabaseManager $instance;

    /**
     * getter de l'instance  (singleton)
     *
     * @return PDO
     */
    public static function getInstance(): PDO
    {
        if(empty(self::$instance)){
            self::$instance = new DatabaseManager();
        }
        return self::$instance->conn;
    }

    /**
     * Constructeur de la classe DatabaseManager
     *
     * @throws ExceptionsDatabase
     */
    public function __construct() {
        try {
            // d'apres https://phpdelusions.net/pdo
            $dsn = "mysql:host=".Constants::$DB['host'].";dbname=".Constants::$DB['dbname'].";charset=".Constants::$DB['charset'];
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $this->conn = new PDO(
                $dsn,
                Constants::$DB['usr'],
                Constants::$DB['pwd'],
                $options
            );

        } catch (PDOException $e) {
            throw new ExceptionsDatabase("Connection failed: " . $e->getMessage());
        }
    }


}