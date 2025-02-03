<?php

use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\UserController;

$router->mount('/admin', function() use ($router) {

    // will result in '/admin/'
    $router->get('/', DashboardController::class . '@index');
});