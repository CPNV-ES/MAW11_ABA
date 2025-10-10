<?php
require_once SRC_DIR . 'Models/database.php';
require_once SRC_DIR . 'Models/exercises.php';
require_once SRC_DIR . 'renderer.php';
class ExerciseController
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

            return ['view' => 'newExerciseFields.php', 'data' => $data];
        }

        // Invalid, render the view
        return ['view' => 'newExercise.php', 'data' => $data];
    }

}
