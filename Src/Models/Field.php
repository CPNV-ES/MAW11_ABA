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
    public function getAll()
    {
        $stmt = $this->pdo->prepare("
        SELECT f.exercise_id
        FROM fields f
        GROUP BY f.exercise_id
    ");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    public function showAllAnswersFromAField($exerciseId, $fieldId) {
        $stmt = $this->pdo->prepare("
        SELECT 
            a.answer_id,
            fld.exercise_id,
            a.answer_text,
            f.fulfillment_id,
            f.fulfillment_date
        FROM fields AS fld
        JOIN answers AS a
            ON fld.field_id = a.field_id
        JOIN fulfillments AS f
            ON a.fulfillment_id = f.fulfillment_id
        WHERE fld.field_id = :fieldId
          AND fld.exercise_id = :exerciseId
        ORDER BY a.answer_id ASC, f.fulfillment_date ASC
    ");
        $stmt->execute([
            'fieldId'    => $fieldId,
            'exerciseId' => $exerciseId
        ]);

        return $stmt->fetchAll();
    }
    public function getLabel($id) {
        $stmt = $this->pdo->prepare("SELECT label FROM `fields` WHERE field_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function destroy($fieldId){
        $stmt = $this->pdo->prepare("DELETE FROM `fields` WHERE field_id = :id");
        $stmt->execute(['id' => $fieldId]);
        return $stmt->rowCount() > 0;
    }
}