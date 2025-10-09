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
    public function create($title)
    {
        $stmt = $this->pdo->prepare("INSERT INTO `exercises` (title) VALUES (:title)");
        $stmt->execute(['title' => $title]);
        $lastid = $this->pdo->lastInsertId();
        return $lastid;
    }
    public function getTitleExercise($id) {
        $stmt = $this->pdo->prepare("SELECT title FROM `exercises` WHERE exercise_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

