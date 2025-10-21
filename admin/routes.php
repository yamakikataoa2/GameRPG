<?php
// LẤY VÀ GÁN GIÁ TRỊ CHO CONTROLLER VÀ ACTION (PHẦN BỊ THIẾU)
// Lấy controller và action từ URL
// Nếu không có tham số nào được truyền, sẽ gán giá trị mặc định là 'home' và 'index'
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';


// Mảng định nghĩa các controller và action hợp lệ
$controllers = array(
    'home'        => ['index', 'error'],
    'taikhoan'    => ['index', 'add', 'add_submit', 'edit', 'edit_submit', 'del', 'detail'],
    'nhomsanpham' => ['index', 'add', 'add_submit', 'edit', 'edit_submit', 'del', 'detail'],
    'sanpham'     => ['index', 'add', 'add_submit', 'edit', 'edit_submit', 'del', 'detail'],
    'dathang'     => ['index', 'add', 'add_submit', 'edit', 'edit_submit', 'del', 'detail'],
);

// Kiểm tra xem controller và action có hợp lệ không
if (!array_key_exists($controller, $controllers) || !in_array($action, $controllers[$controller])) {
    $controller = 'home';
    $action = 'error';
    echo "<script> alert('Không tồn tại controller hoặc action!') </script>";
}

// Nhúng file controller tương ứng
include_once('controllers/' . $controller . '_controller.php');

// Tạo tên class controller (ví dụ: 'taikhoan' -> 'TaikhoanController')
$klass = str_replace('_', '', ucwords($controller, '_')) . 'Controller';

// Khởi tạo đối tượng từ class controller
$controller_obj = new $klass; // Dùng biến mới để không ghi đè lên biến $controller cũ

// Gọi đến action (phương thức) tương ứng
$controller_obj->$action();