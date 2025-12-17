<?php
require_once 'Database.php';

class Answer {
    private $pdo;

    public function __construct(Database $db)
    {
        $this->pdo = $db->getConnection();
    }

    function createFulfillment($exercise_id) {
        date_default_timezone_set('Europe/Zurich');
        $stmt = $this->pdo->prepare("INSERT INTO fulfillments (exercise_id, fulfillment_date) VALUES (:exercise_id, :fulfillment_date)");
        $stmt->execute([
            'exercise_id' => $exercise_id,
            'fulfillment_date' => date("Y-m-d H:i:s")
        ]);

        return $this->pdo->lastInsertId();
    }

    function insert($fulfillment_id, $field_id){
        date_default_timezone_set('Europe/Zurich');
        $stmt = $this->pdo->prepare("INSERT INTO answers (fulfillment_id, field_id, answer_text) VALUES (:fulfillment_id, :field_id, :answer_text)");
        $stmt->execute([
            'fulfillment_id' => $fulfillment_id,
            'field_id' => $field_id,
            'answer_text' => null
        ]);

        return $this->pdo->lastInsertId();
    }

    function updateById($answer, $answer_id){
        $stmt = $this->pdo->prepare("UPDATE answers SET answer_text = :answer_text WHERE answer_id = :answer_id");
        $stmt->execute([
            'answer_text' => $answer,
            'answer_id' => $answer_id
        ]);
    }

    function getByFulfillmentId($fulfillment_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM answers WHERE fulfillment_id = :fulfillment_id ORDER BY answer_id");
        $stmt->execute(['fulfillment_id' => $fulfillment_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}