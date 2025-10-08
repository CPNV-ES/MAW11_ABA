<?php
require_once 'database.php';

class Exercise {
    private $pdo;

    public function __construct(Database $db)
    {
        $this->pdo = $db->getConnection();
    }

    public function getExercises() {
        $stmt = $this->pdo->query("SELECT exercise_id, title FROM `exercises`");
        return $stmt->fetchAll();
    }
}

