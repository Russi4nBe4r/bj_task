<?php
require_once '../vendor/autoload.php';

session_start();

if (!isset($_SESSION['isAdmin']))
{
    $_SESSION['isAdmin'] = false;
}

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load($_SERVER['DOCUMENT_ROOT'] .'/../.env');

$router = new \Bramus\Router\Router();

$router->setNamespace('\App\Controller');

require_once '../routes/rotes.php';

$router->run();