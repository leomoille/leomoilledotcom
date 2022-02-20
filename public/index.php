<?php

use App\Autoloader;
use App\Core\Main;

session_start();
//var_dump($_SESSION);
define('ROOT', dirname(__DIR__));
setlocale(LC_TIME, 'fr_FR');
date_default_timezone_set('Europe/Paris');

require_once ROOT . '/Autoloader.php';
Autoloader::register();

$app = new Main();
$app->start();
