<?php
require_once SRC_DIR . "renderer.php";
Class Dispatcher{

    function __construct(){}

    function dispatch(){
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = rtrim($uri, '/') ?: '/';
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($uri) {
            case '/':
                $renderer = new Renderer();
                $renderer->render("home.php");
                break;

            case '/exercises/new':
                require_once SRC_DIR . 'Controllers/exercise.php';
                $exerciseController = new ExerciseController();

                if ($method == 'GET') {
                    $renderer = new Renderer(); //repeat fix ?
                    $renderer->render("newExercise.php");
                }
                if ($method == 'POST') {
                    $result = $exerciseController->createExercise();

                    $renderer = new Renderer();
                    $renderer->render($result['view'], ['data' => $result['data']]);
                }
                break;

            case '/exercises/answering':
                require_once SRC_DIR . 'Controllers/navigate.php';
                $navigate = new Navigate();
                $navigate->showExercises();
                break;

            case '/exercises':
                require_once SRC_DIR . 'Controllers/navigate.php';
                $navigate = new Navigate();
                $navigate->showTakeExercises();
                break;
            case '/exercises/newExerciseFields':
                $renderer = new Renderer(); //repeat fix ?
                $renderer->render("newExerciseFields.php");
                break;
            default:
                header('HTTP/1.0 404 Not Found');
                break;
        }
    }
}