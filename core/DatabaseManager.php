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

    public function __construct(){
        $this->conn = new PDO("mysql:dbname=". Constants::DB['dbname'].
                                ";host=". Constants::DB['host'],
                                Constants::DB['usr'],
                                Constants::DB['pwd']);
        if ($this->conn->errorInfo() != null) {
            throw new ExceptionsDatabase("Connection failed: " .implode($this->conn->errorInfo()));
        }

    }



}