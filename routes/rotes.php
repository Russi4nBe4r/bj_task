<?php

/**
 * middlewares for routes
 */
$router->before('GET|POST', '/tasks/.*',  function () {
    if (!isset($_SESSION['isAdmin']) || !$_SESSION['isAdmin'])
    {
        header('location: /login');
        exit();
    }
});

$router->before('GET|POST', '/login',  function () {
    if ($_SESSION['isAdmin'])
    {
        header('location: /');
        exit();
    }
});

/**
 * routes in system
 */
$router->get('/', 'TaskController@taskList');

$router->post('/', 'TaskController@taskAdd');

$router->get('/login', 'AuthController@loginPage');

$router->post('/login', 'AuthController@login');

$router->get('/logout', 'AuthController@logout');

$router->get('/tasks/(\d+)', 'TaskController@taskGetById');

$router->post('/tasks/(\d+)', 'TaskController@taskUpdate');

$router->post('/tasks/(\d+)/complete', 'TaskController@taskComplete');