<?php

namespace App\Controllers\Admin;

use App\Controller;
use App\Models\User;
use Rakit\Validation\Validator;

class UserController extends Controller
{
    private User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function index()
    {
        $data = $this->user->findAll();

        return view('admin.users.index', compact('data'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store()
    {
        try {
            $data = $_POST + $_FILES;

            // Validate
            $validator = new Validator;

            $errors = $this->validate(
                $validator,
                $data,
                [
                    'name'                  => 'required|max:50',
                    'email'                 => 'required|email|max:100',
                    'password'              => 'required|min:6|max:30',
                    'confirm_password'      => 'required|same:password',
                    'avatar'                => 'nullable|uploaded_file:0,2048K,png,jpeg,jpg',
                    'type'                  => [$validator('in', ['admin', 'client'])]
                ]
            );

            // Nếu Không có lỗi khi validate hoặc không tồn tại lỗi liên quan đển email
            // Thì mới tiến hành check lỗi có bị trùng email không
            // Nếu có thì lưu lỗi vào thằng error email
            if (
                ( empty($errors) || !isset($errors['email']) )
                && $this->user->checkExistsEmailForCreate($data['email'])
                ) {
                    $errors['email'] = 'Email đã tồn tại';
            }

            if (!empty($errors)) {
                $_SESSION['status']     = false;
                $_SESSION['msg']        = 'Thao tác KHÔNG thành công!';
                $_SESSION['data']       = $_POST;
                $_SESSION['errors']     = $errors;

                redirect('/admin/users/create');
            }

            // Upload file 
            if (isUpload('avatar')) {
                $data['avatar'] = $this->uploadFile($data['avatar'], 'users');
            }

            // Xử lý lại dữ liệu cho đúng
            unset($data['confirm_password']);

            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            // Insert
            $this->user->insert($data);

            $_SESSION['status'] = true;
            $_SESSION['msg'] = 'Thao tác thành công!';

            redirect('/admin/users');
        } catch (\Throwable $th) {
            $this->logError($th->getMessage());

            $_SESSION['status'] = false;
            $_SESSION['msg'] = 'Thao tác KHÔNG thành công!';
            $_SESSION['data'] = $_POST;

            redirect('/admin/users/create');
        }
    }

    public function show($id)
    {
        $user = $this->user->find($id);

        if (empty($user)) {
            redirect404();
        }
        
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = $this->user->find($id);

        if (empty($user)) {
            redirect404();
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update($id)
    {
        $user = $this->user->find($id);

        if (empty($user)) {
            redirect404();
        }

        try {
            $data = $_POST + $_FILES;

            // Validate
            $validator = new Validator;

            $errors = $this->validate(
                $validator,
                $data,
                [
                    'name'                  => 'required|max:50',
                    'email'                 => 'required|email|max:100',
                    'password'              => 'required|min:6|max:30',
                    'confirm_password'      => 'required|same:password',
                    'avatar'                => 'nullable|uploaded_file:0,2048K,png,jpeg,jpg',
                    'type'                  => [$validator('in', ['admin', 'client'])]
                ]
            );

            if (
                ( empty($errors) || !isset($errors['email']) )
                && $this->user->checkExistsEmailForUpdate($id, $data['email'])
                ) {
                    $errors['email'] = 'Email đã tồn tại';
            }

            if (!empty($errors)) {
                $_SESSION['status']     = false;
                $_SESSION['msg']        = 'Thao tác KHÔNG thành công!';
                $_SESSION['data']       = $_POST;
                $_SESSION['errors']     = $errors;

                redirect('/admin/users/create');
            }

            // Upload file 
            if (isUpload('avatar')) {
                $data['avatar'] = $this->uploadFile($data['avatar'], 'users');
            }

            // Xử lý lại dữ liệu cho đúng
            unset($data['confirm_password']);

            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            // Insert
            $this->user->update($id, $data);

            if (
                isUpload('avatar')
                && $user['avatar']
                && file_exists($user['avatar'])
            ) {
                unlink($user['avatar']);
            }

            $_SESSION['status'] = true;
            $_SESSION['msg'] = 'Thao tác thành công!';

            redirect('/admin/users');
        } catch (\Throwable $th) {
            $this->logError($th->getMessage());

            $_SESSION['status'] = false;
            $_SESSION['msg'] = 'Thao tác KHÔNG thành công!';
            $_SESSION['data'] = $_POST;

            redirect('/admin/users/create');
        }
    }

    public function delete($id)
    {
        $this->user->delete($id);

        $_SESSION['status'] = true;
        $_SESSION['msg'] = 'Thao tác thành công!';

        redirect('/admin/users');
    }
}
