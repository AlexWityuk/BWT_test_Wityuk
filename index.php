<?php
//FRONT CONTROLLER

//1. Общие настройки
// отображение ошибок
ini_set('display_errors',1);
error_reporting(E_ALL);

//2. Подключение файлов системы
define('ROOT', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);

require_once (ROOT . DS . 'autoload.php');

$router = new components\Router();
$router->run();