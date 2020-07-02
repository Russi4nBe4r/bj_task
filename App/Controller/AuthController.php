<?php


namespace App\Controller;


class AuthController extends Controller
{
    public function loginPage()
    {
        echo $this->twig->load('login.html')->render();
    }

    public function login()
    {
        if ($_ENV['ADMIN_LOGIN'] == $_POST['username'] && $_ENV['ADMIN_PASSWORD'] == $_POST['password'])
        {
            $_SESSION['isAdmin'] = true;
            header('Location: /');
            exit();
        }
        echo $this->twig->load('login.html')->render(['error' => 'Invalid login or password']);
    }

    public function logout()
    {
        $_SESSION['isAdmin'] = false;
        header('Location: /');
    }
}