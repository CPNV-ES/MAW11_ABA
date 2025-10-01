<?php
require_once 'database.php';

class Exercise {
    private $pdo;

    public function __construct(Database $db)
    {
        $this->pdo = $db->getConnection();
    }

    public function getExercises() {
        $stmt = $this->pdo->query("SELECT id, titre FROM `exercise`");
        return $stmt->fetchAll();
    }
}

