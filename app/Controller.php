<?php 

namespace App;

class Controller
{
    public function logError($message) {
        $date = date('d-m-Y');

        // Type: 3 - Ghi vào file
        error_log($message, 3, "storage/logs/$date.log");
    }
    
    public function uploadFile(array $file, $folder = null) {
        // Thông tin về file
        $fileTmpPath = $file['tmp_name']; // Đường dẫn tạm thời của file
        $fileName = time() . '-' . $file['name']; // Tên file chống trùng bằng timestamp

        $uploadDir = 'storage/uploads/' . $folder . '/';

        // Tạo thư mục nếu chưa tồn tại
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Đường dẫn đầy đủ để lưu file
        $destPath = $uploadDir . $fileName;

        // Di chuyển file từ thư mục tạm thời đến thư mục đích
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            return $destPath;
        }
        
        throw new \Exception('Lỗi upload file!');
    }
}