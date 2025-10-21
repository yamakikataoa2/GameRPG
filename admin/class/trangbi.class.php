<?php
class TrangBi
{
    // Khai báo các thuộc tính tương ứng với các cột trong bảng
    public $tentrangbi;
    public $dohiem;
    public $khetrangbi;
    public $motatrangbi;
    public $imgtrangbi;

    // Phương thức khởi tạo
    function __construct()
    {
    }

    /**
     * Lấy toàn bộ dữ liệu trang bị
     * @return array Mảng chứa tất cả các trang bị
     */
    public static function get_all()
    {
        $db = DB::getInstance();
        $req = $db->query('SELECT * FROM trangbi');
        return $req->fetchAll();
    }

    /**
     * Lấy thông tin 1 trang bị theo tên
     * @param string $tentrangbi Tên của trang bị cần tìm
     * @return object Đối tượng chứa thông tin trang bị
     */
    public static function get_byid($tentrangbi)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT * FROM trangbi WHERE tentrangbi = :tentrangbi');
        $req->execute(array('tentrangbi' => $tentrangbi));
        return $req->fetch();
    }

    /**
     * Thêm trang bị mới vào CSDL
     * @return bool True nếu thêm thành công, False nếu thất bại
     */
    function insert()
    {
        $db = DB::getInstance();
        $sql = "INSERT INTO trangbi(tentrangbi, dohiem, khetrangbi, motatrangbi, imgtrangbi)
                VALUES (?, ?, ?, ?, ?)";
        try {
            $stmt = $db->prepare($sql);
            // Gán các giá trị từ thuộc tính của đối tượng vào câu lệnh
            return $stmt->execute([
                $this->tentrangbi,
                $this->dohiem,
                $this->khetrangbi,
                $this->motatrangbi,
                $this->imgtrangbi
            ]);
        } catch (PDOException $ex) {
            // Xử lý lỗi nếu có
            error_log("Lỗi khi thêm trang bị: " . $ex->getMessage());
            return false;
        }
    }

    /**
     * Cập nhật thông tin trang bị
     * @return bool True nếu cập nhật thành công, False nếu thất bại
     */
    function update()
    {
        $db = DB::getInstance();
        $sql = "UPDATE trangbi SET
                dohiem = ?,
                khetrangbi = ?,
                motatrangbi = ?,
                imgtrangbi = ?
                WHERE tentrangbi = ?";
        try {
            $stmt = $db->prepare($sql);
            // Gán các giá trị từ thuộc tính của đối tượng vào câu lệnh
            return $stmt->execute([
                $this->dohiem,
                $this->khetrangbi,
                $this->motatrangbi,
                $this->imgtrangbi,
                $this->tentrangbi // tentrangbi cho điều kiện WHERE ở cuối
            ]);
        } catch (PDOException $ex) {
            error_log("Lỗi khi cập nhật trang bị: " . $ex->getMessage());
            return false;
        }
    }

    /**
     * Xóa trang bị khỏi CSDL
     * @param string $tentrangbi Tên của trang bị cần xóa
     * @return bool True nếu xóa thành công, False nếu thất bại
     */
    public static function delete($tentrangbi)
    {
        $db = DB::getInstance();
        $sql = "DELETE FROM trangbi WHERE tentrangbi = ?";
        try {
            $stmt = $db->prepare($sql);
            return $stmt->execute([$tentrangbi]);
        } catch (PDOException $ex) {
            error_log("Lỗi khi xóa trang bị: " . $ex->getMessage());
            return false;
        }
    }

    public static function get_all_with_limit($limit)
    {
        $db = DB::getInstance();
        // 1. Thêm "ORDER BY RAND() LIMIT :limit" vào câu SQL
        $sql = "SELECT * FROM trangbi ORDER BY RAND() LIMIT :limit";

        try {
            // 2. Dùng prepare() để chuẩn bị câu lệnh, giúp an toàn hơn
            $stmt = $db->prepare($sql);

            // 3. Gán giá trị của biến $limit vào câu lệnh một cách an toàn
            // (int) đảm bảo giá trị là một số, PDO::PARAM_INT là quy tắc cần có cho LIMIT
            $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);

            // 4. Thực thi câu lệnh
            $stmt->execute();
            return $stmt->fetchAll();
            
        } catch (PDOException $ex) {
            error_log("Lỗi khi lấy trang bị có giới hạn: " . $ex->getMessage());
            return [];
        }
    }

    
}
?>