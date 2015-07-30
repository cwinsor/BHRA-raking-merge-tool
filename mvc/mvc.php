<?php

include_once 'Model.php';
include_once 'View.php';
include_once 'Controller.php';

$model = new Model();
$controller = new Controller($model);
$view = new View($controller, $model);
 
if (isset($_GET['action']) && !empty($_GET['action'])) {
    echo "hello";
    $controller->{$_GET['action']}();
}
 

echo var_dump($_GET);
//echo $view->output();
