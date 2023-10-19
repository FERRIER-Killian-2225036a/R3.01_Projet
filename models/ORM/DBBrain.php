<?php

class DBBrain
{
    private $conn;
    public function __construct()
    {
        $this->conn= DatabaseManager::getInstance();
    }

    public function getConn(): PDO
    {
        return $this->conn;
    }

    public function isValidEmail($mail_a): bool
    {
        return filter_var($mail_a, FILTER_VALIDATE_EMAIL)!== false;
    }


}