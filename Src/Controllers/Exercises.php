<?php

require_once SRC_DIR . 'Models/Database.php';
require_once SRC_DIR . 'Models/Exercise.php';
require_once SRC_DIR . 'Models/Field.php';
require_once SRC_DIR . 'Renderer.php';

class Exercises
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

    public function showExercises()
    {
        $exercises = $this->exerciseModel->getAll();
        $this->renderer->render("Answering/Exercises.php", ['exercises' => $exercises]);
    }

    public function showManageExercises()
    {
        $exercises = $this->exerciseModel->getAll();

        $fields = $this->fieldModel->getAll();

        foreach ($exercises as &$exercise) {
            $exercise['isfield'] = false;

            foreach ($fields as $field) {
                if ($exercise['exercise_id'] == $field['exercise_id']) {
                    $exercise['isfield'] = true;
                    break;
                }
            }
        }
        unset($exercise);

        $this->renderer->render("Manage/Exercises.php", ['exercises' => $exercises]);
    }

    public function create()
    {
        $title = $_POST['exercise_title'] ?? null;
        $data = [];

        if (empty($title)) {
            $data['title_error'] = "Le titre est requis";
        }

        if (strlen($title) > 75) {
            $data['title_error'] = "Le titre ne peut pas être plus long que 75 caractères";
        }

        if (empty($data)) {
            $id = $this->exerciseModel->create($title);
            $data = $this->exerciseModel->getTitle($id);
            header('Location: ' . $id . '/fields');
            exit;
        }

        return ['view' => 'New/Exercise.php', 'data' => $data];
    }

    public function delete()
    {
        $id = $_POST['exercise_id'] ?? null;

        if (!empty($id)) {
            $this->exerciseModel->delete($id);
        }

        header('Location: /exercises');
        exit;
    }

    public function setStatusToAnswering($id)
    {
        $exercise = $this->exerciseModel->getById($id);

        if (!$exercise) {
            header('Location: /Errors/404');
            exit;
        }

        if ($exercise['status'] !== 'building') {
            header('Location: /Errors/404');
            exit;
        }

        if (!empty($this->fieldModel->getAllByExerciseId($id))) {
            if ($this->exerciseModel->setStatusToAnswering($id)) {
                header('Location: /exercises');
                exit;
            } else {
                header('Location: ' . $id . '/fields');
                exit;
            }
        } else {
            header('Location: ' . $id . '/fields');
            exit;
        }
    }

    public function setStatusToClosed()
    {
        $id = $_POST['exercise_id'] ?? null;

        if (!$id) {
            header('Location: /exercises');
            exit;
        }

        $exercise = $this->exerciseModel->getById($id);

        if (!$exercise) {
            header('Location: /exercises');
            exit;
        }

        if ($exercise['status'] !== 'answering') {
            header('Location: /exercises');
            exit;
        }

        $this->exerciseModel->setStatusToClosed($id);
        header('Location: /exercises/');
        exit;
    }
}