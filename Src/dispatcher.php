<?php

Class Dispatcher{

    function __construct(){}

    function dispatch(){
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = rtrim($uri, '/') ?: '/';

        switch ($uri) {
            case '/':
                require 'views/home.php';
                break;

            default:
                header('HTTP/1.0 404 Not Found');
                break;
        }
    }
}