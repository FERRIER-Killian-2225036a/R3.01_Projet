<?php

class DatabaseManager
{
    private PDO $conn;

    public function getConn(): PDO
    {
        return $this->conn;
    }
    private static DatabaseManager $instance;

    public static function getInstance(): PDO
    {
        if(empty(self::$instance)){
            self::$instance = new DatabaseManager();
        }
        return self::$instance->conn;
    }

    public function __construct() {
        try {
            // d'apres https://phpdelusions.net/pdo
            $dsn = "mysql:host=".Constants::DB['host'].";dbname=".Constants::DB['dbname'].";charset=".Constants::DB['charset'];
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $this->conn = new PDO(
                $dsn,
                Constants::DB['usr'],
                Constants::DB['pwd'],
                $options
            );

        } catch (PDOException $e) {
            throw new ExceptionsDatabase("Connection failed: " . $e->getMessage());
        }
    }


}