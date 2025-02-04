<?php

use App\Controllers\Auth\AuthController;

$router->get('/auth',       AuthController::class . '@showForm');
$router->post('/login',     AuthController::class . '@login');
$router->post('/register',  AuthController::class . '@register');
$router->get('/logout',     AuthController::class . '@logout');

$router->before('GET|POST', '/.*', function() {
    middleware_auth();
});