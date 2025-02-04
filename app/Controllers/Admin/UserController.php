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
        $title = 'Danh sách người dùng';

        $data = $this->user->findAll();

        return view('admin.users.index', compact('data', 'title'));
    }

    public function create()
    {
        $title = 'Thêm mới người dùng';

        return view('admin.users.create', compact('title'));
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
                    'email'                 => [
                        'required',
                        'email',
                        function ($value) {
                            $flag = (new User)->checkExistsEmailForCreate($value);

                            if ($flag) {
                                return ":attribute has existed";
                            }
                        }
                    ],
                    'password'              => 'required|min:6|max:30',
                    'confirm_password'      => 'required|same:password',
                    'avatar'                => 'nullable|uploaded_file:0,2048K,png,jpeg,jpg',
                    'type'                  => [$validator('in', ['admin', 'client'])]
                ]
            );

            if (!empty($errors)) {
                $_SESSION['status']     = false;
                $_SESSION['msg']        = 'Thao tác KHÔNG thành công!';
                $_SESSION['data']       = $_POST;
                $_SESSION['errors']     = $errors;

                redirect('/admin/users/create');
            } else {
                $_SESSION['data'] = null;
            }

            // Upload file 
            if (is_upload('avatar')) {
                $data['avatar'] = $this->uploadFile($data['avatar'], 'users');
            } else {
                $data['avatar'] = null;
            }

            // Điểu chỉnh dữ liệu
            unset($data['confirm_password']);
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            
            // Insert
            $this->user->insert($data);

            $_SESSION['status'] = true;
            $_SESSION['msg'] = 'Thao tác thành công!';
            $_SESSION['data'] = null;

            redirect('/admin/users');
        } catch (\Throwable $th) {
            $this->logError($th->__tostring());

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

        $title = 'Chi tiết người dùng';

        return view('admin.users.show', compact('user', 'title'));
    }

    public function edit($id)
    {
        $user = $this->user->find($id);

        if (empty($user)) {
            redirect404();
        }

        $title = 'Cập nhật người dùng';

        return view('admin.users.edit', compact('user', 'title'));
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
                    'email'                 => [
                        'required',
                        'email',
                        function ($value) use ($id) {
                            $flag = (new User)->checkExistsEmailForUpdate($id, $value);

                            if ($flag) {
                                return ":attribute has existed";
                            }
                        }
                    ],
                    'avatar'                => 'nullable|uploaded_file:0,2048K,png,jpeg,jpg',
                    'type'                  => [$validator('in', ['admin', 'client'])]
                ]
            );

            if (!empty($errors)) {
                $_SESSION['status']     = false;
                $_SESSION['msg']        = 'Thao tác KHÔNG thành công!';
                $_SESSION['errors']     = $errors;

                redirect('/admin/users/edit/' . $id);
            }

            // Upload file 
            if (is_upload('avatar')) {
                $data['avatar'] = $this->uploadFile($data['avatar'], 'users');
            } else {
                $data['avatar'] = $user['avatar'];
            }

            // Điểu chỉnh dữ liệu
            $data['updated_at'] = date('Y-m-d H:i:s');

            // Update
            $this->user->update($id, $data);

            if (
                $data['avatar'] != $user['avatar']
                && $user['avatar']
                && file_exists($user['avatar'])
            ) {
                unlink($user['avatar']);
            }

            $_SESSION['status'] = true;
            $_SESSION['msg'] = 'Thao tác thành công!';

            redirect('/admin/users/edit/' . $id);
        } catch (\Throwable $th) {
            $this->logError($th->__tostring());

            $_SESSION['status'] = false;
            $_SESSION['msg'] = 'Thao tác KHÔNG thành công!';

            redirect('/admin/users/edit/' . $id);
        }
    }

    public function delete($id)
    {
        $user = $this->user->find($id);

        if (empty($user)) {
            redirect404();
        }

        $this->user->delete($id);

        if ($user['avatar'] && file_exists($user['avatar'])) {
            unlink($user['avatar']);
        }

        $_SESSION['status'] = true;
        $_SESSION['msg'] = 'Thao tác thành công!';

        redirect('/admin/users');
    }
}
