<?php
require_once SRC_DIR . "Renderer.php";

Class Dispatcher{

    function __construct(){}

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

        if (preg_match('#^/exercises/(\d+)/?$#', parse_url($uri, PHP_URL_PATH), $matches)) {
            $exerciseId = $matches[1];

            $status = $_GET['exercise']['status'] ?? null;

            require_once SRC_DIR . 'Controllers/Exercises.php';
            $exerciseController = new Exercises();

            if ($method == 'GET' && $status == 'answering') {
                $exerciseController->setStatusToAnswering($exerciseId);
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
                $navigate->showTakeExercises();
                break;

            case '/exercises/delete':
                require_once SRC_DIR . 'Controllers/Exercises.php';
                $exerciseController = new Exercises();

                if ($method == 'POST') {
                    $exerciseController->delete();
                }
                break;

            case '/exercises/allAnswers':
                require_once SRC_DIR . 'Controllers/Navigate.php';
                $navigate = new Navigate();
                $navigate->showAllAnswers();
                break;
            default:
                header('HTTP/1.0 404 Not Found');
                break;
        }
    }
}