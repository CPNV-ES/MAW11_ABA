<?php
class Index {
    private $title;
    private $content;

    public function __construct($title = "Ma Page", $content = "Bienvenue sur ma page!") {
        $this->title = $title;
        $this->content = $content;
    }

    public function render() {
        echo "<!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta charset='UTF-8'>
            <title>{$this->title}</title>
        </head>
        <body>
            <h1>{$this->title}</h1>
            <p>{$this->content}</p>
        </body>
        </html>";
    }
}

$page = new Index("Accueil", "Bonjour! Ceci est une page PHP orientée objet.");

$page->render();
