<?php
// Xây dựng Controller (trong controllers)
require_once('controllers/base_controller.php');
require_once('models/taikhoan_model.php');

class TaikhoanController extends BaseController
{
    function __construct()
    {
        $this->folder = 'taikhoan'; //Tên thư mục của view.
    }

    public function index()
    {
        $taikhoan = TaiKhoan::all(); // Lấy tất cả dữ liệu từ model
        $data = array('taikhoan' => $taikhoan);
        $this->render('index', $data); // Trả về view cùng với dữ liệu
    }

    public function detail()
    {
        $taikhoan = TaiKhoan::find($_GET['tendangnhap']); // Lấy chi tiết một tài khoản
        $data = array('taikhoan' => $taikhoan);
        $this->render('detail', $data);
    }

    public function add()
    {
        $this->render('add'); // Trả về view để thêm mới
    }

    public function add_submit()
    {
        // Lấy giá trị từ form, loại bỏ trường 'hoten' không tồn tại
        $tendangnhap = isset($_POST['tendangnhap']) ? $_POST['tendangnhap'] : '';
        $matkhau = isset($_POST['matkhau']) ? $_POST['matkhau'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';

        // Tạo đối tượng TaiKhoan với 3 tham số, không có 'hoten'
        $taikhoan = new TaiKhoan($tendangnhap, $matkhau, $email);
        
        // Gọi phương thức save() từ model để lưu vào CSDL
        $result = $taikhoan->save();
        if ($result) {
            echo "<script>alert('Thêm mới thành công!');</script>";
        } else {
            echo "<script>alert('Thêm mới không thành công!');</script>";
        }
        
        // Chuyển hướng về trang chủ
        header('Location: index.php?controller=taikhoan');
    }

    public function edit()
    {
        $taikhoan = TaiKhoan::find($_GET['tendangnhap']); // Tìm tài khoản cần sửa
        $data = array('taikhoan' => $taikhoan);
        $this->render('edit', $data); // Trả về view để sửa
    }

    public function edit_submit()
    {
        // Lấy giá trị từ form, loại bỏ trường 'hoten' không tồn tại
        $tendangnhap = isset($_POST['tendangnhap']) ? $_POST['tendangnhap'] : '';
        $matkhau = isset($_POST['matkhau']) ? $_POST['matkhau'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';

        // Tạo đối tượng TaiKhoan với 3 tham số, không có 'hoten'
        $taikhoan = new TaiKhoan($tendangnhap, $matkhau, $email);

        // Gọi phương thức update() từ model
        $result = $taikhoan->update();
        if ($result) {
            echo "<script>alert('Cập nhật thành công!');</script>";
        } else {
            echo "<script>alert('Cập nhật không thành công!');</script>";
        }
        
        // Chuyển hướng về trang chủ
        header('Location: index.php?controller=taikhoan');
    }

    public function del()
    {
        // Gọi phương thức delete() từ model
        TaiKhoan::delete($_GET['tendangnhap']);
        // Chuyển hướng về trang chủ
        header('Location: index.php?controller=taikhoan');
    }
}