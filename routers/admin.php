<?php

use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\UserController;

$router->mount('/admin', function() use ($router) {

    // will result in '/admin/'
    $router->get('/', DashboardController::class . '@index');

    // CRUD: Xem (Danh sách và chi tiết), Thêm, Sửa, Xóa
    $router->get('/users',              UserController::class . '@index');
    $router->get('/users/create',       UserController::class . '@create');
    $router->post('/users/store',       UserController::class . '@store');
    $router->get('/users/show/{id}',    UserController::class . '@show');
    $router->get('/users/edit/{id}',    UserController::class . '@edit');
    $router->post('/users/update/{id}', UserController::class . '@update');
    $router->get('/users/delete/{id}',  UserController::class . '@delete');
});