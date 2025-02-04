<?php

namespace App\Controllers\Admin;

use App\Controller;
use App\Models\Category;
use Rakit\Validation\Validator;

class CategoryController extends Controller
{
    private Category $category;

    public function __construct()
    {
        $this->category = new Category();
    }

    public function index()
    {
        $title = 'Danh sách danh mục';

        $data = $this->category->findAll();

        return view('admin.categories.index', compact('data', 'title'));
    }

    public function create()
    {
        $title = 'Thêm mới danh mục';

        return view('admin.categories.create', compact('title'));
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
                    'name'                 => [
                        'required',
                        'max:50',
                        function ($value) {
                            $flag = (new Category)->checkExistsNameForCreate($value);

                            if ($flag) {
                                return ":attribute has existed";
                            }
                        }
                    ],
                    'img'                   => 'nullable|uploaded_file:0,2048K,png,jpeg,jpg',
                    'is_active'             => [$validator('in', [0, 1])]
                ]
            );

            if (!empty($errors)) {
                $_SESSION['status']     = false;
                $_SESSION['msg']        = 'Thao tác KHÔNG thành công!';
                $_SESSION['data']       = $_POST;
                $_SESSION['errors']     = $errors;

                redirect('/admin/categories/create');
            } else {
                $_SESSION['data'] = null;
            }

            // Upload file 
            if (is_upload('img')) {
                $data['img'] = $this->uploadFile($data['img'], 'categories');
            } else {
                $data['img'] = null;
            }

            // Điểu chỉnh dữ liệu
            $data['is_active'] = $data['is_active'] ?? 0;
            
            // Insert
            $this->category->insert($data);

            $_SESSION['status'] = true;
            $_SESSION['msg'] = 'Thao tác thành công!';

            redirect('/admin/categories');
        } catch (\Throwable $th) {
            $this->logError($th->__tostring());

            $_SESSION['status'] = false;
            $_SESSION['msg'] = 'Thao tác KHÔNG thành công!';
            $_SESSION['data'] = $_POST;

            redirect('/admin/categories/create');
        }
    }

    public function show($id)
    {
        $category = $this->category->find($id);

        if (empty($category)) {
            redirect404();
        }

        $title = 'Chi tiết danh mục';

        return view('admin.categories.show', compact('category', 'title'));
    }

    public function edit($id)
    {
        $category = $this->category->find($id);

        if (empty($category)) {
            redirect404();
        }

        $title = 'Cập nhật danh mục';

        return view('admin.categories.edit', compact('category', 'title'));
    }

    public function update($id)
    {
        $category = $this->category->find($id);

        if (empty($category)) {
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
                    'name'                 => [
                        'required',
                        'max:50',
                        function ($value) use ($id) {
                            $flag = (new Category)->checkExistsNameForUpdate($id, $value);

                            if ($flag) {
                                return ":attribute has existed";
                            }
                        }
                    ],
                    'img'                   => 'nullable|uploaded_file:0,2048K,png,jpeg,jpg',
                    'is_active'             => [$validator('in', [0, 1])]
                ]
            );

            if (!empty($errors)) {
                $_SESSION['status']     = false;
                $_SESSION['msg']        = 'Thao tác KHÔNG thành công!';
                $_SESSION['errors']     = $errors;

                redirect('/admin/categories/edit/' . $id);
            }

            // Upload file 
            if (is_upload('img')) {
                $data['img'] = $this->uploadFile($data['img'], 'categories');
            } else {
                $data['img'] = $category['img'];
            }

            // Điểu chỉnh dữ liệu
            $data['is_active'] = $data['is_active'] ?? 0;
            $data['updated_at'] = date('Y-m-d H:i:s');

            // Update
            $this->category->update($id, $data);

            if (
                $data['img'] != $category['img']
                && $category['img']
                && file_exists($category['img'])
            ) {
                unlink($category['img']);
            }

            $_SESSION['status'] = true;
            $_SESSION['msg'] = 'Thao tác thành công!';

            redirect('/admin/categories/edit/' . $id);
        } catch (\Throwable $th) {
            $this->logError($th->__tostring());

            $_SESSION['status'] = false;
            $_SESSION['msg'] = 'Thao tác KHÔNG thành công!';

            redirect('/admin/categories/edit/' . $id);
        }
    }

    public function delete($id)
    {
        $category = $this->category->find($id);

        if (empty($category)) {
            redirect404();
        }

        $this->category->delete($id);

        if ($category['img'] && file_exists($category['img'])) {
            unlink($category['img']);
        }

        $_SESSION['status'] = true;
        $_SESSION['msg'] = 'Thao tác thành công!';

        redirect('/admin/categories');
    }
}
