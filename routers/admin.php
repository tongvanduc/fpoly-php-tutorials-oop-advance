<?php

use App\Controllers\Admin\BannerController;
use App\Controllers\Admin\CategoryController;
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

    $router->get('/categories',              CategoryController::class . '@index');
    $router->get('/categories/create',       CategoryController::class . '@create');
    $router->post('/categories/store',       CategoryController::class . '@store');
    $router->get('/categories/show/{id}',    CategoryController::class . '@show');
    $router->get('/categories/edit/{id}',    CategoryController::class . '@edit');
    $router->post('/categories/update/{id}', CategoryController::class . '@update');
    $router->get('/categories/delete/{id}',  CategoryController::class . '@delete');

    $router->get('/banners',              BannerController::class . '@index');
    $router->get('/banners/create',       BannerController::class . '@create');
    $router->post('/banners/store',       BannerController::class . '@store');
    $router->get('/banners/show/{id}',    BannerController::class . '@show');
    $router->get('/banners/edit/{id}',    BannerController::class . '@edit');
    $router->post('/banners/update/{id}', BannerController::class . '@update');
    $router->get('/banners/delete/{id}',  BannerController::class . '@delete');
});