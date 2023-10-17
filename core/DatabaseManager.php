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
            $this->conn = new PDO(
                "mysql:dbname=" . Constants::DB['dbname'] .
                ";host=" . Constants::DB['host'],
                Constants::DB['usr'],
                Constants::DB['pwd']
            );

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new ExceptionsDatabase("Connection failed: " . $e->getMessage());
        }
    }


}