<?php
class Index {
    public function render($viewFile) {
        $viewPath = '../src/views/' . $viewFile;
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            // Envoyer le code d'erreur 404
            header("HTTP/1.1 404 Not Found");
            echo "Erreur 404 : La page demandée n'existe pas.";
        }
    }
}
$page = new Index();

$page->render('home2.php');

