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
    public function showManageExercises()
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

            if (!isset($answersGrouped[$fulfillmentId])) {
                $answersGrouped[$fulfillmentId] = [
                    'date' => $date,
                    'fields' => []
                ];
            }

            $text = trim($row['answer_text'] ?? '');
            if ($text === '') {
                $state = 'empty';
            } elseif (strlen($text) <= 20) {
                $state = 'short';
            } else {
                $state = 'long';
            }

            $answersGrouped[$fulfillmentId]['fields'][$fieldId] = [
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
    public function showAnAnswer($exerciseId, $fulfillmentId)
    {
        $titleData = $this->exerciseModel->getTitle($exerciseId);
        $dateData  = $this->exerciseModel->getDateOfExercise($fulfillmentId);
        $exerciseCheck = $this->exerciseModel->getIdOfExercise($fulfillmentId);

        $title = $titleData['title'] ?? null;
        $fulfillmentDate = $dateData['fulfillment_date'] ?? null;
        $exerciseIdFromFulfillment = $exerciseCheck['exercise_id'] ?? null;

        if (!$title || !$fulfillmentDate || $exerciseIdFromFulfillment != $exerciseId) {
            $this->renderer->render("Errors/404.php");
            return;
        }

        $data = [
            'id' => $exerciseId,
            'fulfillment_id' => $fulfillmentId,
            'title' => $title,
            'fulfillment_date' => $fulfillmentDate
        ];

        $answers = $this->exerciseModel->getAllAnswersByFulfillment($fulfillmentId);

        $this->renderer->render("Answers/One.php", [
            'answers' => $answers,
            'data' => $data,
        ]);
    }
}
