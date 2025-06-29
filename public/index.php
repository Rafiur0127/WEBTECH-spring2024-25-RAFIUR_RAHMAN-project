<?php
session_start();

define('ROOT', dirname(__DIR__));

$controller = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'login';

$controllerFile = ROOT . "/app/controllers/" . ucfirst($controller) . "Controller.php";

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    if (function_exists($action)) {
        call_user_func($action);
    } else {
        echo "404 - Action '$action' not found.";
    }
} else {
    echo "404 - Controller '$controller' not found.";
}
