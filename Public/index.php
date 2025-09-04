<?php

define('SRC_DIR', __DIR__ . '/../src/');

require_once SRC_DIR . 'dispatcher.php';

$dispatcher = new Dispatcher();
$dispatcher->dispatch();
