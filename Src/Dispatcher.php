<?php
require_once SRC_DIR . "Renderer.php";

Class Dispatcher{

    private $renderer;

    function __construct(){
        $this->renderer = new Renderer();
    }

    function dispatch(){
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = rtrim($uri, '/') ?: '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if (preg_match('#^/exercises/(\d+)/fields$#', $uri, $matches)) {
            $exerciseId = $matches[1];
            require_once SRC_DIR . 'Controllers/Fields.php';
            $fieldController = new Fields();

            if ($method == 'GET') {
                $fieldController->manageFields($exerciseId);
            } else if ($method == 'POST') {
                $fieldController->createField($exerciseId);
            }

            return;
        }

        if (preg_match('#^/exercises/(\d+)/fields/(\d+)/edit$#', $uri, $matches)) {
            $exerciseId = $matches[1];
            $fieldId = $matches[2];
            require_once SRC_DIR . 'Controllers/Fields.php';
            $fieldController = new Fields();

            if ($method == 'GET') {
                $fieldController->editField($exerciseId, $fieldId);
            } else if ($method == 'POST') {
                $fieldController->updateField($exerciseId, $fieldId);
            }
            return;
        }

        if (preg_match('#^/exercises/(\d+)/fulfillments/new$#', $uri, $matches)) {
            $exerciseId = $matches[1];
            require_once SRC_DIR . 'Controllers/Answers.php';
            $answerController = new Answers();

            if ($method == 'GET') {
                $answerController->fulfillment($exerciseId);
            }

            if ($method == 'POST') {
                $answerController->save();
            }
            return;
        }

        if (preg_match('#^/exercises/(\d+)/?$#', parse_url($uri, PHP_URL_PATH), $matches)) {
            $exerciseId = $matches[1];

            $status = $_GET['exercise']['status'] ?? null;

            require_once SRC_DIR . 'Controllers/Exercises.php';
            $exerciseController = new Exercises();
            if (!$status) {
                $this->renderer->render("Errors/404.php");
                return;
            }
            if ($method == 'GET' && $status == 'answering') {
                $exerciseController->setStatusToAnswering($exerciseId);
            }
            return;
        }
        if (preg_match('#^/exercises/(\d+)/fulfillments/(\d+)$#', parse_url($uri, PHP_URL_PATH), $matches)) {
            $exerciseId = $matches[1];
            $fullfillmentId = $matches[2];

            require_once SRC_DIR . 'Controllers/Navigate.php';
            $navigate = new Navigate();

            if ($method == 'GET') {
                $navigate->showAnAnswer($exerciseId,$fullfillmentId);
            }
            return;
        }
        if (preg_match('#^/exercises/(\d+)/results$#', parse_url($uri, PHP_URL_PATH), $matches)) {
            $exerciseId = $matches[1];

            require_once SRC_DIR . 'Controllers/Navigate.php';
            $navigate = new Navigate();

            if ($method == 'GET') {
                $navigate->showAllAnswers($exerciseId);
            }
            return;
        }
        if (preg_match('#^/exercises/(\d+)/results/(\d+)$#', parse_url($uri, PHP_URL_PATH), $matches)) {
            $exerciseId = $matches[1];
            $fieldId = $matches[2];

            require_once SRC_DIR . 'Controllers/Fields.php';
            $fieldController = new Fields();

            if ($method == 'GET') {
                $fieldController->showAllAnswersFromAQuestion($exerciseId,$fieldId);
            }
            return;
        }
        switch ($uri) {
            case '/':
                $renderer = new Renderer();
                $renderer->render("Home.php");
                break;

            case '/exercises/new':
                require_once SRC_DIR . 'Controllers/Exercises.php';
                $exerciseController = new Exercises();

                if ($method == 'GET') {
                    $renderer = new Renderer(); //repeat fix ?
                    $renderer->render("New/Exercise.php");
                }
                if ($method == 'POST') {
                    $result = $exerciseController->create();

                    $renderer = new Renderer();
                    $renderer->render($result['view'], ['data' => $result['data']]);
                }
                break;

            case '/exercises/answering':
                require_once SRC_DIR . 'Controllers/Navigate.php';
                $navigate = new Navigate();
                $navigate->showExercises();
                break;

            case '/exercises':
                require_once SRC_DIR . 'Controllers/Navigate.php';
                $navigate = new Navigate();
                $navigate->showManageExercises();
                break;

            case '/exercises/delete':
                require_once SRC_DIR . 'Controllers/Exercises.php';
                $exerciseController = new Exercises();

                if ($method == 'POST') {
                    $exerciseController->delete();
                }
                break;
            default:
                http_response_code(404);
                require_once __DIR__ . '/Views/Errors/404.php';
                exit;
        }
    }
}