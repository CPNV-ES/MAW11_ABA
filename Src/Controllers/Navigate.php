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
    public function showAllAnswers($exerciseId)
    {
        $data = $this->exerciseModel->getTitle($exerciseId);

        if (!is_array($data) || empty($data['title'])) {
            $this->renderer->render("Errors/404.php");
            return;
        }

        $data['id'] = $exerciseId;

        $fields = $this->exerciseModel->getAllFieldsFromAnExercise($exerciseId);
        $answersRaw = $this->exerciseModel->getAllAnswersByExercise($exerciseId);

        $answersGrouped = [];

        foreach ($answersRaw as $row) {
            $date = $row['fulfillment_date'] ?? null;
            $fulfillmentId = $row['fulfillment_id'] ?? null;
            $fieldId = $row['field_id'] ?? null;
            if (!$date || !$fulfillmentId || !$fieldId) continue;

            if (!isset($answersGrouped[$date])) {
                $answersGrouped[$date] = [
                    'fulfillment_id' => $fulfillmentId,
                    'fields' => []
                ];
            }

            $text = trim($row['answer_text'] ?? '');
            $length = strlen($text);

            if ($length === 0) {
                $state = 'empty';
            } elseif ($length <= 20) {
                $state = 'short';
            } else {
                $state = 'long';
            }

            $answersGrouped[$date]['fields'][$fieldId] = [
                'answer_text' => $text,
                'state' => $state
            ];
        }

        $this->renderer->render("Answers/All.php", [
            'answers' => $answersGrouped,
            'fields' => $fields,
            'data' => $data
        ]);
    }
    function showAnAnswer($exerciseId, $fulfillmentId)
    {
        $id = $exerciseId;
        $idfullfillment = $fulfillmentId;
        $title = $this->exerciseModel->getTitle($exerciseId);
        $date  = $this->exerciseModel->getDateOfExercise($fulfillmentId);
        $idexercisetoverif = $this->exerciseModel->getIdOfExercise($fulfillmentId);

        $data = [
            'id' => $id,
            'idfullfillment' => $idfullfillment,
            'title' => $title['title'] ?? null,
            'fulfillment_date' => $date['fulfillment_date'] ?? null
        ];

        $answers = $this->exerciseModel->getAllAnswersByFulfillment($fulfillmentId);


        if ($idexercisetoverif && isset($idexercisetoverif['exercise_id']) && $id == $idexercisetoverif['exercise_id']) {
            if ($date != null) {
                $this->renderer->render("Answers/One.php", [
                    'answers' => $answers,
                    'data' => $data,
                ]);
            } else {
                $this->renderer->render("Errors/404.php");
            }
        } else {
            $this->renderer->render("Errors/404.php");
        }
    }
}
