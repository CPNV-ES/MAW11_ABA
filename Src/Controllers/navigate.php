<?php
require_once SRC_DIR . 'Models/database.php';
require_once SRC_DIR . 'Models/exercises.php';
require_once SRC_DIR . 'Renderer.php';
class Navigate
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

    public function showExercises()
    {
        $exercises = $this->exerciseModel->getExercises();
        $this->renderer->render("showExercises.php", ['exercises' => $exercises]);
    }
}
