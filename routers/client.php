<?php

use App\Controllers\Client\AboutController;
use App\Controllers\Client\HomeController;

$router->get('/', HomeController::class . '@index');

$router->get('/about', AboutController::class . '@index');