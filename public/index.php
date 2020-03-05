<?php

use App\services\Autoload;

include dirname(__DIR__) . "/services/Autoload.php";
spl_autoload_register([new Autoload(), 'loadClass']);

$controllerName = 'good';
if (!empty($_GET['c'])) {
    $controllerName = $_GET['c'];
}

$actionName = '';
if (!empty($_GET['a'])) {
    $actionName = $_GET['a'];
}

$controllerClass = 'App\\controllers\\' . ucfirst($controllerName) . 'Controller';

if (class_exists($controllerClass)) {
    /** @var App\controllers\GoodController $controller */
    $controller = new $controllerClass;
    echo $controller->run($actionName);
}



