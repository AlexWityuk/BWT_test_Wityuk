<?php
//FRONT CONTROLLER

//1. Общие настройки
// отображение ошибок
ini_set('display_errors',1);
error_reporting(E_ALL);

//2. Подключение файлов системы
define('ROOT', dirname(__FILE__));
require_once (ROOT.'/components/Router.php');
//Class Db
require_once (ROOT.'/components/Db.php');
//echo ROOT; //Путь к файлу index.php

//4  Вызов Router
$router = new Router();
$router->run();
