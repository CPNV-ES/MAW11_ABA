<?php
require_once 'Database.php';

class Answer {
    private $pdo;

    public function __construct(Database $db)
    {
        $this->pdo = $db->getConnection();
    }

    function insert($field_id){

    $stmt = $this->pdo->prepare("INSERT INTO `answers` (field_id,answer_text,answer_date) VALUES (:field_id,:answer_text,:answer_date)");
    $stmt->execute(
        [
            'field_id' => $field_id,
            'answer_text' => null,
            'answer_date' => date("Y-m-d H:i:s")
        ]);

    return date("Y-m-d H:i:s");
    }
    function updateByDate($answer,$date){


    }

}

?>