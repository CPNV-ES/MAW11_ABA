<?php
require_once SRC_DIR . 'Models/Database.php';
require_once SRC_DIR . 'Models/Exercise.php';
require_once SRC_DIR . 'Renderer.php';
class Exercises
{
    private $db;
    private $exerciseModel;
    private $renderer;

    public function __construct()
    {
        $this->db = new Database();
        $this->exerciseModel = new Exercise($this->db);
        $this->renderer = new Renderer();
    }

    public function create()
    {
        $title = $_POST['exercise_title'] ?? null;
        $data = [];

        if (empty($title)) {
            $data['title_error'] = "Le titre est requis";
        }

        if (empty($data)) {
            $id = $this->exerciseModel->create($title);

            $data = $this->exerciseModel->getTitle($id);

            return ['view' => 'New/ExerciseFields.php', 'data' => $data];
        }

        // Invalid, render the view
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
}
