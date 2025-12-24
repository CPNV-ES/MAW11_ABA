<?php

require_once SRC_DIR . "Renderer.php";

class Dispatcher
{
    private $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }

    public function dispatch()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = rtrim($uri, '/') ?: '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if (preg_match('#^/exercises/(\d+)/fields$#', $uri, $matches)) {
            $exerciseId = $matches[1];
            require_once SRC_DIR . 'Controllers/Fields.php';
            $fieldController = new Fields();

            if ($method === 'GET') {
                $fieldController->manageFields($exerciseId);
            } elseif ($method === 'POST') {
                $fieldController->createField($exerciseId);
            }

            return;
        }

        if (preg_match('#^/exercises/(\d+)/fields/(\d+)$#', $uri, $matches)) {
            $exerciseId = $matches[1];
            $fieldId = $matches[2];
            require_once SRC_DIR . 'Controllers/Fields.php';
            $fieldController = new Fields();

            if ($method === 'GET') {
                $fieldController->destroy($exerciseId, $fieldId);
            }
            return;
        }

        if (preg_match('#^/exercises/(\d+)/fields/(\d+)/edit$#', $uri, $matches)) {
            $exerciseId = $matches[1];
            $fieldId = $matches[2];
            require_once SRC_DIR . 'Controllers/Fields.php';
            $fieldController = new Fields();

            if ($method === 'GET') {
                $fieldController->editField($exerciseId, $fieldId);
            } elseif ($method === 'POST') {
                $fieldController->updateField($exerciseId, $fieldId);
            }
            return;
        }

        if (preg_match('#^/exercises/(\d+)/fulfillments/new$#', $uri, $matches)) {
            $exerciseId = $matches[1];
            require_once SRC_DIR . 'Controllers/Answers.php';
            $answerController = new Answers();

            if ($method === 'GET') {
                $answerController->fulfillment($exerciseId);
            } elseif ($method === 'POST') {
                $answerController->save();
            }
            return;
        }

        if (preg_match('#^/exercises/(\d+)/fulfillments/(\d+)/edit$#', $uri, $matches)) {
            $exerciseId = $matches[1];
            $fulfillmentId = $matches[2];
            require_once SRC_DIR . 'Controllers/Answers.php';
            $answerController = new Answers();

            if ($method === 'GET') {
                $answerController->edit($exerciseId, $fulfillmentId);
            }
            return;
        }

        if (preg_match('#^/exercises/(\d+)/fulfillments/(\d+)$#', $uri, $matches)) {
            $exerciseId = $matches[1];
            $fulfillmentId = $matches[2];
            require_once SRC_DIR . 'Controllers/Answers.php';
            $answerController = new Answers();

            if ($method === 'POST') {
                $answerController->update($fulfillmentId);
            } elseif ($method === 'GET') {
                $answerController->showAnAnswer($exerciseId, $fulfillmentId);
            }
            return;
        }

        if (preg_match('#^/exercises/(\d+)/?$#', parse_url($uri, PHP_URL_PATH), $matches)) {
            $exerciseId = $matches[1];
            $status = $_GET['exercise']['status'] ?? null;

            if (!$status || $status !== 'answering') {
                $this->renderer->render("Errors/404.php");
                return;
            }

            if ($method === 'GET') {
                require_once SRC_DIR . 'Controllers/Exercises.php';
                $exerciseController = new Exercises();
                $exerciseController->setStatusToAnswering($exerciseId);
            }
            return;
        }

        if (preg_match('#^/exercises/(\d+)/results$#', parse_url($uri, PHP_URL_PATH), $matches)) {
            $exerciseId = $matches[1];
            require_once SRC_DIR . 'Controllers/Answers.php';
            $answerController = new Answers();

            if ($method === 'GET') {
                $answerController->showAllAnswers($exerciseId);
            }
            return;
        }

        if (preg_match('#^/exercises/(\d+)/results/(\d+)$#', parse_url($uri, PHP_URL_PATH), $matches)) {
            $exerciseId = $matches[1];
            $fieldId = $matches[2];
            require_once SRC_DIR . 'Controllers/Fields.php';
            $fieldController = new Fields();

            if ($method === 'GET') {
                $fieldController->showAllAnswersFromAField($exerciseId, $fieldId);
            }
            return;
        }

        switch ($uri) {
            case '/':
                $this->renderer->render("Home.php");
                break;

            case '/exercises/new':
                require_once SRC_DIR . 'Controllers/Exercises.php';
                $exerciseController = new Exercises();

                if ($method === 'GET') {
                    $this->renderer->render("New/Exercise.php");
                } elseif ($method === 'POST') {
                    $result = $exerciseController->create();
                    $this->renderer->render($result['view'], ['data' => $result['data']]);
                }
                break;

            case '/exercises/answering':
                require_once SRC_DIR . 'Controllers/Exercises.php';
                $exerciseController = new Exercises();
                $exerciseController->showExercises();
                break;

            case '/exercises':
                require_once SRC_DIR . 'Controllers/Exercises.php';
                $exerciseController = new Exercises();
                $exerciseController->showManageExercises();
                break;

            case '/exercises/delete':
                require_once SRC_DIR . 'Controllers/Exercises.php';
                $exerciseController = new Exercises();

                if ($method === 'POST') {
                    $exerciseController->delete();
                }
                break;

            case '/exercises/close':
                require_once SRC_DIR . 'Controllers/Exercises.php';
                $exerciseController = new Exercises();

                if ($method === 'POST') {
                    $exerciseController->setStatusToClosed();
                }
                break;

            default:
                http_response_code(404);
                $this->renderer->render("Errors/404.php");
                exit;
        }
    }
}