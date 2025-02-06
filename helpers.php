<?php

use eftec\bladeone\BladeOne;

if (!function_exists('view')) {
    function view($view, $data = [])
    {
        $views = __DIR__ . '/views';
        $cache = __DIR__ . '/storage/compiles';

        // MODE_DEBUG allows to pinpoint troubles.
        $blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);

        echo $blade->run($view, $data);
    }
}

if (!function_exists('is_upload')) {
    function is_upload($key)
    {
        return isset($_FILES[$key]) && $_FILES[$key]['size'] > 0;
    }
}

if (!function_exists('redirect')) {
    function redirect($path)
    {
        header('Location: ' . $path);
        exit;
    }
}

if (!function_exists('redirect404')) {
    function redirect404()
    {
        header('HTTP/1.1 404 Not Found');
        exit;
    }
}

if (!function_exists('middleware_auth')) {
    function middleware_auth()
    {
        $currentUrl = $_SERVER['REQUEST_URI'];
        $authRegex = '/^\/(auth|login|register)$/';
        $adminUrlRegex = '/^\/admin/';

        // Nếu người dùng chưa đăng nhập
        if (empty($_SESSION['user'])) {

            // Chuyển hướng trang
            if (
                !preg_match($authRegex, $currentUrl)
                && preg_match($adminUrlRegex, $currentUrl)
            ) {
                redirect('/auth');
            }
        } else {
            // Nếu người dùng đã đăng nhập và đang truy cập trang đăng nhập, đăng ký
            if (preg_match($authRegex, $currentUrl)) {
                $redirectTo = ($_SESSION['user']['type'] == 'admin') ? '/admin' : '/';
                redirect($redirectTo);
            }

            // Kiểm tra quyền truy cập vào trang admin
            if (preg_match($adminUrlRegex, $currentUrl) && $_SESSION['user']['type'] != 'admin') {
                redirect('/');
            }
        }
    }
}

if (!function_exists('file_url')) {
    function file_url($path)
    {
        if (!file_exists($path)) {
            return null;
        }

        return $_ENV['APP_URL'] . $path;
    }
}

if (!function_exists('debug')) {
    function debug(...$data)
    {
        echo '<pre>';
        print_r($data);
        die;
    }
}

if (!function_exists('slug')) {
    function slug($string, $separator = '-')
    {
        // Chuyển đổi chuỗi sang chữ thường
        $string = mb_strtolower($string, 'UTF-8');

        // Thay thế các ký tự đặc biệt và dấu tiếng Việt
        $string = preg_replace('/[^\p{L}\p{N}\s]/u', '', $string);
        $string = preg_replace('/[\s]+/', $separator, $string);

        // Loại bỏ các ký tự phân cách ở đầu và cuối chuỗi
        $string = trim($string, $separator) . '-' . random_string(6);

        return $string;
    }
}

if (!function_exists('random_string')) {
    function random_string($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
