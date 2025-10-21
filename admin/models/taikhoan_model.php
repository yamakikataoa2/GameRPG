<?php
// Xây dựng Model (trong models/taikhoan_model.php)
class TaiKhoan
{
    // 1. Khai báo các thuộc tính tương ứng với các cột của bảng trong CSDL.
    public $tendangnhap;
    public $matkhau;
    public $email;

    // 2. Hàm khởi tạo dùng để gán giá trị truyền vào cho các thuộc
    // tính mỗi khi tạo một đối tượng của lớp này.
    function __construct($tendangnhap, $matkhau, $email)
    {
        $this->tendangnhap = $tendangnhap;
        $this->matkhau = $matkhau;
        $this->email = $email;
    }

    // 3. Phương thức all() dùng để lấy toàn bộ dữ liệu của bảng.
    // Phương thức static để truy xuất trực tiếp qua tên lớp mà phải tạo đối
    // tượng của lớp. VD: TaiKhoan::all()
    static function all()
    {
        $list = [];
        $db = DB::getInstance();
        $req = $db->query('SELECT * FROM taikhoan');
        // Duyệt từng bản ghi gốc, chuyển bản ghi thành đối tượng
        // và gán vào list.
        foreach ($req->fetchAll() as $item) {
            $list[] = new TaiKhoan($item['tendangnhap'], $item['matkhau'], $item['email']);
        }
        return $list; //trả về mảng các đối tượng TaiKhoan
    }

    // 4. Phương thức find() dùng để lấy thông tin 1 dòng theo tendangnhap.
    // Tương tự all() đây là phương thức static.
    static function find($tendangnhap)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT * FROM taikhoan WHERE tendangnhap = :tendangnhap');
        $req->execute(array('tendangnhap' => $tendangnhap));
        // Lấy ra bản ghi gán cho item, tạo đối tượng rồi trả về.
        if ($req->rowCount() > 0) {
            $item = $req->fetch();
            return new TaiKhoan($item['tendangnhap'], $item['matkhau'], $item['email']);
        }
        return null;
    }

    // 5. Phương thức save() dùng để lưu (thêm mới)
    function save()
    {
        $db = DB::getInstance();
        $req = $db->prepare('INSERT INTO taikhoan(tendangnhap, matkhau, email) VALUES (:tendangnhap, :matkhau, :email)');
        $req->execute(array(
            'tendangnhap' => $this->tendangnhap,
            'matkhau' => $this->matkhau,
            'email' => $this->email
        ));
    }

    // 6. Phương thức update()
    function update()
    {
        $db = DB::getInstance();
        $req = $db->prepare('UPDATE taikhoan SET matkhau = :matkhau, email = :email WHERE tendangnhap = :tendangnhap');
        $req->execute(array(
            'matkhau' => $this->matkhau,
            'email' => $this->email,
            'tendangnhap' => $this->tendangnhap
        ));
    }

    // 7. Phương thức delete()
    // Phương thức static gọi trực tiếp thay vì phải tạo đối tượng
    static function delete($tendangnhap)
    {
        $db = DB::getInstance();
        $req = $db->prepare('DELETE FROM taikhoan WHERE tendangnhap = :tendangnhap');
        $req->execute(array('tendangnhap' => $tendangnhap));
    }
}
?>