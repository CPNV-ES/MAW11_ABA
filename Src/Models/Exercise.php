<?php

require_once 'Database.php';

class Exercise
{
    private $pdo;

    public function __construct(Database $db)
    {
        $this->pdo = $db->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT exercise_id, title, status FROM `exercises`");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllAnswersByExercise($exerciseId)
    {
        $sql = "
        SELECT
            a.answer_id,
            a.answer_text,
            f.label,
            ff.fulfillment_date,
            f.field_id,
            f.exercise_id,
            ff.fulfillment_id
        FROM answers a
        JOIN fields f ON a.field_id = f.field_id
        JOIN fulfillments ff ON a.fulfillment_id = ff.fulfillment_id
        WHERE f.exercise_id = :exerciseId
        ORDER BY ff.fulfillment_date ASC, f.field_id ASC;
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['exerciseId' => $exerciseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllAnswersByFulfillment($fulfillmentId)
    {
        $sql = "
            SELECT 
                a.answer_id,
                a.answer_text,
                ff.fulfillment_date,
                f.label,
                f.field_id,
                f.exercise_id,
                ff.fulfillment_id
            FROM answers a
            JOIN fields f ON a.field_id = f.field_id
            JOIN fulfillments ff ON a.fulfillment_id = :fulfillmentId
            WHERE ff.fulfillment_id = :fulfillmentId
            ORDER BY ff.fulfillment_date DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['fulfillmentId' => $fulfillmentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllFieldsFromAnExercise($id)
    {
        $stmt = $this->pdo->prepare("SELECT exercise_id, label, field_id FROM `fields` WHERE `exercise_id` = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($title)
    {
        $stmt = $this->pdo->prepare("INSERT INTO `exercises` (title) VALUES (:title)");
        $stmt->execute(['title' => $title]);
        $lastid = $this->pdo->lastInsertId();
        return $lastid;
    }

    public function getTitle($id)
    {
        $stmt = $this->pdo->prepare("SELECT title FROM `exercises` WHERE exercise_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getDateOfExercise($id)
    {
        $stmt = $this->pdo->prepare("SELECT fulfillment_date FROM `fulfillments` WHERE fulfillment_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getIdOfExercise($id)
    {
        $stmt = $this->pdo->prepare("SELECT exercise_id FROM `fulfillments` WHERE fulfillment_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `exercises` WHERE exercise_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM `exercises` WHERE exercise_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }

    public function setStatusToAnswering($id)
    {
        $stmt = $this->pdo->prepare("UPDATE `exercises` SET status = 'answering' WHERE exercise_id = :id AND status = 'building'");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }

    public function setStatusToClosed($id)
    {
        $stmt = $this->pdo->prepare("UPDATE `exercises` SET status = 'closed' WHERE exercise_id = :id AND status = 'answering'");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }
}