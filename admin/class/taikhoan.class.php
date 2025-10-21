<?php
class TaiKhoan
{
    // Khai báo các thuộc tính tương ứng với các trường trong bảng
    public $tendangnhap;
    public $matkhau;
    public $email;

    // Phương thức khởi tạo
    function __construct()
    {
    }

    // Lấy toàn bộ dữ liệu tài khoản
    function get_all()
    {
        $db = DB::getInstance();
        $req = $db->query('SELECT * FROM taikhoan');
        return $req->fetchAll();
    }

    // Lấy thông tin 1 tài khoản theo tên đăng nhập
    function get_byid($tendangnhap)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT * FROM taikhoan WHERE tendangnhap=:tendangnhap');
        $req->execute(array('tendangnhap' => $tendangnhap));
        return $req->fetch();
    }

    // Thêm tài khoản mới
    function insert()
    {
        $db = DB::getInstance();
        $req = "INSERT INTO taikhoan(tendangnhap, matkhau, email)
                VALUES ('$this->tendangnhap', '$this->matkhau', '$this->email');";
        return $db->exec($req);
    }

    // Cập nhật thông tin tài khoản
    function update()
    {
        $db = DB::getInstance();
        $sql = "UPDATE taikhoan SET
                matkhau = '$this->matkhau',
                email = '$this->email'
                WHERE tendangnhap = '$this->tendangnhap';";
        return $db->exec($sql);
    }

    // Xóa tài khoản
    function delete($tendangnhap)
    {
        $db = DB::getInstance();
        $sql = "DELETE FROM taikhoan WHERE tendangnhap='$tendangnhap';";
        return $db->exec($sql);
    }
}
?>