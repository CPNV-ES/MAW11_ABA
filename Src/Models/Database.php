<?php

class Database
{
    private $host;
    private $db;
    private $user;
    private $pass;
    private $charset;
    private $pdo;

    public function __construct()
    {
        $config = require __DIR__ . '/Config.php';

        $this->host = $config['host'];
        $this->db = $config['db'];
        $this->user = $config['user'];
        $this->pass = $config['pass'];
        $this->charset = $config['charset'];
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
            exit;
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}