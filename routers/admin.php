<?php

use App\Controllers\Admin\UserController;

$router->mount('/admin', function() use ($router) {

    // will result in '/admin/'
    $router->get('/', function() {
        echo 'Dashboard Page';
    });

    // will result in '/admin/users'
    $router->get('/users', UserController::class . '@testBaseModel');

});