<?php
require_once SRC_DIR . 'Models/Database.php';
require_once SRC_DIR . 'Models/Exercise.php';
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
        $exercises = $this->exerciseModel->getAll();
        $this->renderer->render("Answering/Exercises.php", ['exercises' => $exercises]);
    }
    public function showTakeExercises()
    {
        $exercises = $this->exerciseModel->getAll();
        $this->renderer->render("Manage/Exercise.php", ['exercises' => $exercises]);
    }
}
