<?php
// Nhúng file kết nối CSDL
require_once('models/db_model.php');

// Lấy tham số controller và action từ URL
if (isset($_GET['controller'])) {
    $controller = $_GET['controller'];
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
    } else {
        $action = 'index'; // Action mặc định là 'index'
    }
} else {
    $controller = 'taikhoan'; // Controller mặc định là 'taikhoan'
    $action = 'index';
}

// Nhúng file routes để xử lý
require_once('routes.php');