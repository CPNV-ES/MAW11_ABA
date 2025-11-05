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
    public function showAllAnswers()
    {
        $id = $_POST['exercise_id'] ?? null;

        $data = $this->exerciseModel->getTitle($id);
        $data['id'] = $id;
        $fields = $this->exerciseModel->getAllFieldsFromAnExercise($id);
        $answersRaw = $this->exerciseModel->getAllAnswersByExercise($id);

        $answersGrouped = [];
        foreach ($answersRaw as $row) {
            $date = $row['answer_date'];
            if (!isset($answersGrouped[$date])) {
                $answersGrouped[$date] = [];
            }
            $answersGrouped[$date][$row['field_id']] = [
                'answer_text' => $row['answer_text'],
                'answered' => !empty(trim($row['answer_text']))
            ];
        }

        $this->renderer->render("Answers/All.php", [
            'answers' => $answersGrouped,
            'fields' => $fields,
            'data' => $data
        ]);
    }
}
