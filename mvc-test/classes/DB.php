<?php

class DB
{
    private $host = '127.0.0.1',
        $dbName = 'hanzeleaderboard',
        $username = 'root',
        $password = '',
        $pdo = null;

    // TODO Steal from other class
    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbName . ";charset=utf8",
                $this->username,
                $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function connect()
    {
        if (!isset($this->pdo)) {
            new DB();
        }
        return $this->pdo;
    }

    public function query($sql, $params = array())
    {
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }
}