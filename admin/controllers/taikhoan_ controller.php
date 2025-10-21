<?php
// File: admin/controllers/taikhoan_controller.php

require_once('controllers/base_controller.php');
// Luôn đảm bảo gọi đúng Model an toàn từ thư mục /models
require_once('models/taikhoan_model.php');

class TaikhoanController extends BaseController
{
    function __construct()
    {
        $this->folder = 'taikhoan'; //Tên thư mục của view.
    }

    // Action: Hiển thị danh sách tất cả tài khoản
    public function index()
    {
        $taikhoans = TaiKhoan::all(); // Lấy tất cả dữ liệu từ model
        $data = array('taikhoans' => $taikhoans); // Sửa key thành 'taikhoans' cho nhất quán với View
        $this->render('index', $data);
    }

    // Action: Hiển thị chi tiết một tài khoản
    public function detail()
    {
        // Sử dụng $_GET['id'] như đã định nghĩa trong routes và view
        $taikhoan = TaiKhoan::find($_GET['id']);
        $data = array('taikhoan' => $taikhoan);
        $this->render('detail', $data);
    }

    // Action: Hiển thị form để thêm tài khoản mới
    public function add()
    {
        $this->render('add'); // Chỉ cần hiển thị view 'add.php'
    }

    // Action: Xử lý dữ liệu gửi từ form thêm mới
    public function add_submit()
    {
        // Lấy dữ liệu từ form
        $tendangnhap = isset($_POST['tendangnhap']) ? $_POST['tendangnhap'] : '';
        $matkhau = isset($_POST['matkhau']) ? md5($_POST['matkhau']) : ''; // Mã hóa mật khẩu
        $email = isset($_POST['email']) ? $_POST['email'] : '';

        // Kiểm tra dữ liệu đầu vào cơ bản
        if (empty($tendangnhap) || empty($matkhau)) {
            // Có thể thêm thông báo lỗi ở đây (sử dụng session flash)
            // Tạm thời chuyển hướng về trang thêm mới
            header('Location: index.php?controller=taikhoan&action=add');
            return; // Dừng thực thi
        }

        // Tạo đối tượng TaiKhoan từ model
        $taikhoan = new TaiKhoan($tendangnhap, $matkhau, $email);
        
        // Gọi phương thức save() từ model để lưu vào CSDL
        $taikhoan->save();
        
        // Chuyển hướng về trang danh sách tài khoản
        header('Location: index.php?controller=taikhoan&action=index');
    }

    // Action: Hiển thị form để sửa thông tin tài khoản
    public function edit()
    {
        $taikhoan = TaiKhoan::find($_GET['id']); // Tìm tài khoản cần sửa
        $data = array('taikhoan' => $taikhoan);
        $this->render('edit', $data); // Trả về view 'edit.php' với dữ liệu cũ
    }

    // Action: Xử lý dữ liệu gửi từ form sửa
    public function edit_submit()
    {
        // Lấy dữ liệu từ form
        $tendangnhap = isset($_POST['tendangnhap']) ? $_POST['tendangnhap'] : '';
        $matkhau = isset($_POST['matkhau']) ? md5($_POST['matkhau']) : ''; // Mã hóa mật khẩu mới
        $email = isset($_POST['email']) ? $_POST['email'] : '';

        // Tạo đối tượng TaiKhoan
        $taikhoan = new TaiKhoan($tendangnhap, $matkhau, $email);

        // Gọi phương thức update() từ model
        $taikhoan->update();
        
        // Chuyển hướng về trang danh sách
        header('Location: index.php?controller=taikhoan&action=index');
    }

    // Action: Xóa một tài khoản
    public function del()
    {
        // Gọi phương thức delete() từ model
        TaiKhoan::delete($_GET['id']);
        
        // Chuyển hướng về trang danh sách
        header('Location: index.php?controller=taikhoan&action=index');
    }
}
?>