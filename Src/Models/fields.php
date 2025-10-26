<?php
require_once 'database.php';

class Field {
    private $pdo;

    public function __construct(Database $db)
    {
        $this->pdo = $db->getConnection();
    }

    public function getAllByExerciseId($exerciseId) {
        $stmt = $this->pdo->prepare("SELECT * FROM `fields` WHERE exercise_id = :exercise_id ORDER BY position ASC, field_id ASC");
        $stmt->execute(['exercise_id' => $exerciseId]);
        return $stmt->fetchAll();
    }

}