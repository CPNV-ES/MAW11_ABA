<?php
require_once SRC_DIR . "renderer.php";
Class Dispatcher{

    function __construct(){}

    function dispatch(){
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = rtrim($uri, '/') ?: '/';

        switch ($uri) {
            case '/':
                $renderer = new Renderer();
                $renderer->render("home.php");
                break;

            case '/exercises/new':
                $renderer = new Renderer();
                $renderer->render("newExercise.php");
                break;

            case 'exercises/answering':
                $renderer = new Renderer();
                $renderer->render("answerExercise.php");
                break;

            case '/exercises':
                $renderer = new Renderer();
                $renderer->render("manageExercise.php");
                break;

            default:
                header('HTTP/1.0 404 Not Found');
                break;
        }
    }
}