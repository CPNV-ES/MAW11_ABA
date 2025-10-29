<?php

require_once SRC_DIR . 'Models/Database.php';
require_once SRC_DIR . 'Models/Exercise.php';
require_once SRC_DIR . 'Models/Field.php';
require_once SRC_DIR . 'Renderer.php';

class Fields
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

        $this->renderer->render('Manage/ExerciseFields.php', $data);
    }

    public function editField($exerciseId, $fieldId)
    {
        $exercise = $this->exerciseModel->getById($exerciseId);
        $field = $this->fieldModel->getById($fieldId);

        if (!$exercise || !$field) {
            header('Location: /exercises');
            exit;
        }

        $data = [
            'exercise' => $exercise,
            'field' => $field
        ];

        $this->renderer->render('Manage/EditField.php', $data);
    }

    public function updateField($exerciseId, $fieldId)
    {
        $label = $_POST['field']['label'] ?? null;
        $valueKind = $_POST['field']['value_kind'] ?? 'single_line';

        if (empty($label)) {
            header("Location: /exercises/$exerciseId/fields/$fieldId/edit");
            exit;
        }

        $this->fieldModel->update($fieldId, $label, $valueKind);

        header("Location: /exercises/$exerciseId/fields");
        exit;
    }
}