<?php

require_once SRC_DIR . 'Models/Database.php';
require_once SRC_DIR . 'Models/Answer.php';
require_once SRC_DIR . 'Models/Exercise.php';
require_once SRC_DIR . 'Models/Field.php';
require_once SRC_DIR . 'Renderer.php';

class Answers
{
    private $db;
    private $exerciseModel;
    private $fieldModel;
    private $answerModel;
    private $renderer;

    public function __construct()
    {
        $this->db = new Database();
        $this->exerciseModel = new Exercise($this->db);
        $this->fieldModel = new Field($this->db);
        $this->answerModel = new Answer($this->db);
        $this->renderer = new Renderer();
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

    public function fulfillment($exerciseId)
    {
        $exercise = $this->exerciseModel->getById($exerciseId);

        if (!$exercise) {
            header('Location: /Errors/404');
            exit;
        }

        if ($exercise['status'] !== 'answering') {
            header('Location: /Errors/404');
            exit;
        }

        $fields = $this->fieldModel->getAllByExerciseId($exerciseId);

        $data = [
            'exercise' => $exercise,
            'fields' => $fields
        ];

        $this->renderer->render('Answering/Fulfillment.php', $data);
    }

    public function save()
    {
        $exercise_id = $_POST['exercise_id'] ?? null;
        $fields_ids = $_POST['field_ids'] ?? [];
        $answers = $_POST['answers'] ?? [];

        if (!$exercise_id) {
            header('Location: /exercises/answering');
            exit;
        }

        $errors = [];

        foreach ($answers as $answer) {
            if (strlen($answer) > 1000) {
                $errors['length'] = 'Une ou plusieurs réponses dépassent la limite de 1000 caractères.';
                break;
            }
        }

        $hasAtLeastOneAnswer = false;
        foreach ($answers as $answer) {
            if (!empty(trim($answer))) {
                $hasAtLeastOneAnswer = true;
                break;
            }
        }

        if (!$hasAtLeastOneAnswer) {
            $errors['empty'] = 'Vous devez remplir au moins une réponse.';
        }

        if (!empty($errors)) {
            $exercise = $this->exerciseModel->getById($exercise_id);
            $fields = $this->fieldModel->getAllByExerciseId($exercise_id);

            $data = [
                'exercise' => $exercise,
                'fields' => $fields,
                'answers' => $answers,
                'errors' => $errors
            ];

            $this->renderer->render('Answering/Fulfillment.php', $data);
            return;
        }

        $fulfillmentId = $this->answerModel->createFulfillment($exercise_id);

        foreach ($fields_ids as $index => $field_id) {
            $answerId = $this->answerModel->insert($fulfillmentId, $field_id);
            if (isset($answers[$index])) {
                $this->answerModel->updateById($answers[$index], $answerId);
            }
        }

        header("Location: /exercises/{$exercise_id}/fulfillments/{$fulfillmentId}/edit");
        exit;
    }

    public function edit($exerciseId, $fulfillmentId)
    {
        $exercise = $this->exerciseModel->getById($exerciseId);

        if (!$exercise) {
            header('Location: /Errors/404');
            exit;
        }

        if ($exercise['status'] !== 'answering') {
            header('Location: /Errors/404');
            exit;
        }

        $fields = $this->fieldModel->getAllByExerciseId($exerciseId);

        if (empty($fields)) {
            header('Location: /Errors/404');
            exit;
        }

        $answers = $this->answerModel->getByFulfillmentId($fulfillmentId);

        $data = [
            'exercise' => $exercise,
            'fields' => $fields,
            'answers' => $answers,
            'fulfillmentId' => $fulfillmentId,
            'isEdit' => true
        ];

        $this->renderer->render('Answering/Fulfillment.php', $data);
    }

    public function update($fulfillmentId)
    {
        $exercise_id = $_POST['exercise_id'] ?? null;
        $fields_ids = $_POST['field_ids'] ?? [];
        $answers = $_POST['answers'] ?? [];
        $answer_ids = $_POST['answer_ids'] ?? [];

        if (!$exercise_id) {
            header('Location: /exercises/answering');
            exit;
        }

        $errors = [];

        foreach ($answers as $answer) {
            if (strlen($answer) > 1000) {
                $errors['length'] = 'Une ou plusieurs réponses dépassent la limite de 1000 caractères.';
                break;
            }
        }

        $hasAtLeastOneAnswer = false;
        foreach ($answers as $answer) {
            if (!empty(trim($answer))) {
                $hasAtLeastOneAnswer = true;
                break;
            }
        }

        if (!$hasAtLeastOneAnswer) {
            $errors['empty'] = 'Vous devez remplir au moins une réponse.';
        }

        if (!empty($errors)) {
            $exercise = $this->exerciseModel->getById($exercise_id);
            $fields = $this->fieldModel->getAllByExerciseId($exercise_id);
            $existingAnswers = $this->answerModel->getByFulfillmentId($fulfillmentId);

            $data = [
                'exercise' => $exercise,
                'fields' => $fields,
                'answers' => $existingAnswers,
                'fulfillmentId' => $fulfillmentId,
                'isEdit' => true,
                'errors' => $errors
            ];

            $this->renderer->render('Answering/Fulfillment.php', $data);
            return;
        }

        foreach ($answer_ids as $index => $answer_id) {
            if (isset($answers[$index])) {
                $this->answerModel->updateById($answers[$index], $answer_id);
            }
        }

        header("Location: /exercises/{$exercise_id}/fulfillments/{$fulfillmentId}/edit");
        exit;
    }
}