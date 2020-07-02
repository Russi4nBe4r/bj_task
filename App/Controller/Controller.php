<?php


namespace App\Controller;

use \Twig\Loader\FilesystemLoader;
use \Twig\Environment;

class Controller
{
    protected $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . '/../App/View');
        $this->twig = new Environment($loader);
    }
}