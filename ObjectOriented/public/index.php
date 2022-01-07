<?php

require_once dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
require_once dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . 'env.php';

$views = new Elit1\ObjectOriented\View();
$router = new Elit1\ObjectOriented\Router($views, new Elit1\ObjectOriented\Request());
$views->header();


$router->setRoute($_GET['route'] ?? 'default')->resolve();

$views->footer();