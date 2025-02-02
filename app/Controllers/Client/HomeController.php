<?php

namespace App\Controllers\Client;

use App\Models\Product;

class HomeController
{
    public function index() {

        $data = Product::getAll();

        require 'views/client/home.php';
    }
}