<?php

require_once SRC_DIR . 'Models/database.php';
require_once SRC_DIR . 'Models/exercises.php';
require_once SRC_DIR . 'Models/fields.php';
require_once SRC_DIR . 'renderer.php';

class FieldController
{
    private $db;
    private $exerciseModel;
    private $fieldModel;
    private $renderer;

    public function __construct()
    {
        $this->db = new Database();
        $this->exerciseModel = new Exercise($this->db);
        $this->fieldModel = new Field($this->db);
        $this->renderer = new Renderer();
    }

    public function manageFields($exerciseId)
    {
        $exercise = $this->exerciseModel->getById($exerciseId);

        if (!$exercise) {
            header('Location: /exercises');
            exit;
        }

        $fields = $this->fieldModel->getAllByExerciseId($exerciseId);

        $data = [
            'exercise' => $exercise,
            'fields' => $fields
        ];

        $this->renderer->render('manageExerciseFields.php', $data);
    }
}