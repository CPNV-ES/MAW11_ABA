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

    public function manageFields($exerciseId, $errors = [], $oldInput = [])
    {
        $exercise = $this->exerciseModel->getById($exerciseId);

        if (!$exercise || $exercise['status'] == "closed") {
            header('Location: /Errors/404');
            exit;
        }

        $fields = $this->fieldModel->getAllByExerciseId($exerciseId);

        $data = [
            'exercise' => $exercise,
            'fields' => $fields,
            'errors' => $errors,
            'old' => $oldInput
        ];

        $this->renderer->render('Manage/ExerciseFields.php', $data);
    }

    public function editField($exerciseId, $fieldId)
    {
        $exercise = $this->exerciseModel->getById($exerciseId);
        $field = $this->fieldModel->getById($fieldId);

        if (!$exercise || !$field) {
            header('Location: /Errors/404');
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

    public function createField($exerciseId)
    {
        $exercise = $this->exerciseModel->getById($exerciseId);

        if (!$exercise) {
            header('Location: /Errors/404');
            exit;
        }

        $label = trim($_POST['field']['label'] ?? '');
        $valueKind = $_POST['field']['value_kind'] ?? 'single_line';

        $errors = [];

        if (empty($label)) {
            $errors['label'] = 'Le label est obligatoire.';
        } elseif (strlen($label) > 255) {
            $errors['label'] = 'Le label ne peut pas dépasser 255 caractères.';
        }

        if (!empty($errors)) {
            $oldInput = [
                'label' => $label,
                'value_kind' => $valueKind
            ];
            $this->manageFields($exerciseId, $errors, $oldInput);
            return;
        }

        $this->fieldModel->create($exerciseId, $label, $valueKind);

        header("Location: /exercises/$exerciseId/fields");
        exit;
    }
}