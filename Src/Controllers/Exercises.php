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

    public function create()
    {
        $title = $_POST['exercise_title'] ?? null;
        $data = [];

        if (empty($title)) {
            $data['title_error'] = "Le titre est requis";
        }

        if (strlen($title) > 75) {
            $data['title_error'] = "le titre ne peut pas être plus long que 75 caracteres";
        }

        if (empty($data)) {
            $id = $this->exerciseModel->create($title);

            $data = $this->exerciseModel->getTitle($id);
            header('Location:' . $id . '/fields');
        }
        return ['view' => 'New/Exercise.php', 'data' => $data];
    }
    
    public function delete()
    {
        $id = $_POST['exercise_id'] ?? null;

        if (!empty($id)) {
            $this->exerciseModel->delete($id);
        }

        // Redirect to exercises page
        header('Location: /exercises');
        exit;
    }

    public function setStatusToAnswering($id) {
        if (!empty($this->fieldModel->getAllByExerciseId($id))) {
            if ($this->exerciseModel->setStatusToAnswering($id)) {
                header('Location: /exercises');
            } else {
                header('Location:' . $id . '/fields');
            }
        } else {
            header('Location:' . $id . '/fields');
        }

    }
    public function setStatusToClosed() {
            
            $id = $_POST['exercise_id'] ?? null;

            $this->exerciseModel->setStatusToClosed($id);
            header('Location: /exercises/');
    }
}
