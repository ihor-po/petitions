<?php

session_start();

require_once '../vendor/autoload.php';
require_once '../config/app.php';

// $loader = new Twig_Loader_Filesystem('../app/View');
// $twig = new Twig_Environment($loader, array(
//     'cache' => '../app/cache',
// ));

Framework\Router::start();



