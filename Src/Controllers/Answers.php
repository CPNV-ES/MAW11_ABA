<?php
require_once SRC_DIR . 'Models/Database.php';
require_once SRC_DIR . 'Models/Answer.php';
require_once SRC_DIR . 'Models/Exercise.php';
require_once SRC_DIR . 'Models/Field.php';
require_once SRC_DIR . 'Renderer.php';

class Answers
{
    private $db;
    private $exerciseModel;
    private $fieldModel;
    private $answerModel;
    private $renderer;

    public function __construct()
    {
        $this->db = new Database();
        $this->exerciseModel = new Exercise($this->db);
        $this->fieldModel = new Field($this->db);
        $this->answerModel = new Answer($this->db);
        $this->renderer = new Renderer();
    }

    public function fulfillment($exerciseId)
    {
        $exercise = $this->exerciseModel->getById($exerciseId);

        if (!$exercise) {
            header('Location: /Errors/404');
            exit;
        }

        $fields = $this->fieldModel->getAllByExerciseId($exerciseId);

        $data = [
            'exercise' => $exercise,
            'fields' => $fields
        ];

        $this->renderer->render('Answering/Fulfillment.php', $data);
    }

    public function save(){
        $exercise_id = $_POST['exercise_id'] ?? null;
        $fields_ids = $_POST['field_ids'] ?? [];
        $answers = $_POST['answers'] ?? [];

        if (!$exercise_id) {
            header('Location: /exercises/answering');
            exit;
        }

        $fulfillmentId = $this->answerModel->createFulfillment($exercise_id);

        foreach ($fields_ids as $index => $field_id){
            $answerId = $this->answerModel->insert($fulfillmentId, $field_id);
            if (isset($answers[$index])) {
                $this->answerModel->updateById($answers[$index], $answerId);
            }
        }
        header('Location: /exercises/answering');
        exit;
    }
    public function showAllAnswersFromAQuestion($exerciseId,$fieldId){

    }
}