<?php
require '../src/dispatcher.php';
class Index {

    function __construct() {
        $dispatcher = new Dispatcher();
        $dispatcher->dispatch();
    }
    public function render($viewFile) {
        $viewPath = '../src/views/' . $viewFile;
        require $viewPath;
    }
}