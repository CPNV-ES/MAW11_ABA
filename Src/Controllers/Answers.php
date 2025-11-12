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
            header('Location: /exercises/answering');
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
        $fields_ids = $_POST['field_ids'];
        $answers = $_POST['answers'] ?? [];

        foreach ($fields_ids as $index => $field_id){
            $id = $this->answerModel->insert($field_id);
            if (isset($answers[$index])) {
                $this->answerModel->updateById($answers[$index], $id);
            }
        }
    }

}