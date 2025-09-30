<?php
class Database {
    private $host = 'localhost';
    private $db   = 'Maw.1.1Looper';
    private $user = 'root';
    private $pass = 'Pa$$w0rd';
    private $charset = 'utf8mb4';

    private $pdo;

    public function __construct() {
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

    public function getConnection() {
        return $this->pdo;
    }
}
