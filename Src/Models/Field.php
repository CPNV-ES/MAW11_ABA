<?php
require_once 'Database.php';

class Field {
    private $pdo;

    public function __construct(Database $db)
    {
        $this->pdo = $db->getConnection();
    }

    public function getAllByExerciseId($exerciseId) {
        $stmt = $this->pdo->prepare("SELECT * FROM `fields` WHERE exercise_id = :exercise_id ORDER BY field_id ASC");
        $stmt->execute(['exercise_id' => $exerciseId]);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM `fields` WHERE field_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($exerciseId, $label, $valueKind)
    {
        $stmt = $this->pdo->prepare("INSERT INTO `fields` (exercise_id, label, value_kind) VALUES (:exercise_id, :label, :value_kind)");
        $stmt->execute([
            'exercise_id' => $exerciseId,
            'label' => $label,
            'value_kind' => $valueKind
        ]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $label, $valueKind)
    {
        $stmt = $this->pdo->prepare("UPDATE `fields` SET label = :label, value_kind = :value_kind WHERE field_id = :id");
        $stmt->execute([
            'id' => $id,
            'label' => $label,
            'value_kind' => $valueKind
        ]);
        return $stmt->rowCount() > 0;
    }

}