<?php

namespace App\Controllers\Admin;

use App\Controller;
use App\Models\User;

class UserController extends Controller
{
    private User $user;

    public function __construct()
    {
        $this->user = new User();
    }
}
