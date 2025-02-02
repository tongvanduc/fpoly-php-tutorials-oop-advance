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

    public function index()
    {
        $title = 'Trang danh sách';
        $data = $this->user->findAll();

        return view(
            'admin.users.index',
            compact('title', 'data')
        );
    }

    public function testUploadFile()
    {
        try {
            $this->uploadFile($_FILES['avatar'], 'users');

            $_SESSION['msg'] = 'Upload file THÀNH CÔNG!';
        } catch (\Throwable $th) {
            $this->logError($th->getMessage());

            $_SESSION['msg'] = 'Upload file THẤT BẠI!';
        }

        header('Location: /admin/users');
        exit;
    }
}
