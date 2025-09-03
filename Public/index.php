<?php
require_once '../src/dispatcher.php';
class Index {
    function __construct() {
        $dispatcher = new Dispatcher();
        $dispatcher->dispatch();
    }
}
new Index();