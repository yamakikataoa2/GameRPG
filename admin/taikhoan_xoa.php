<?php
require_once("class/database.class.php"); //Nhúng file class DB. Nên đặt trong file header.php
require_once("class/taikhoan.class.php"); //Nhúng file class TaiKhoan.
$obj = new TaiKhoan(); //Tạo đối tượng của lớp TaiKhoan.

//Lấy biến xác định dòng cần xóa
$tendangnhap = isset($_GET['tendangnhap']) ? $_GET['tendangnhap'] : '';

//Thực hiện xóa
$results = $obj->delete($tendangnhap);

//Kiểm tra
if ($results) {
    echo "<script> alert('Xóa thành công.') </script>";
    echo "<script> window.location.href='taikhoan.php' </script>";
} else {
    echo "<script> alert('Lỗi!') </script>";
    echo "<script> history.go(-1) </script>";
}
?>