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
        $string = trim($string, $separator) . random_string(6);

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
