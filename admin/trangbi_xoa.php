<?php
// Nhúng các file class cần thiết
require_once('./class/database.class.php');
require_once('./class/trangbi.class.php');

// 1. Lấy tên trang bị cần xóa từ URL
$tentrangbi_xoa = isset($_GET['tentrangbi']) ? $_GET['tentrangbi'] : '';

// Kiểm tra xem có tên trang bị không
if (!$tentrangbi_xoa) {
    echo "<script>
            alert('Lỗi: Không tìm thấy trang bị để xóa.');
            window.location.href = 'trangbi.php';
          </script>";
    exit;
}

// 2. Lấy thông tin trang bị để có đường dẫn ảnh
$trangbi_info = TrangBi::get_byid($tentrangbi_xoa);

if (!$trangbi_info) {
    echo "<script>
            alert('Lỗi: Trang bị không tồn tại trong cơ sở dữ liệu.');
            window.location.href = 'trangbi.php';
          </script>";
    exit;
}

$image_path = $trangbi_info['imgtrangbi'];

// 3. Thực hiện xóa trong cơ sở dữ liệu
$result = TrangBi::delete($tentrangbi_xoa);

// 4. Kiểm tra kết quả và xử lý file ảnh
if ($result) {
    // Nếu xóa trong CSDL thành công, thì tiến hành xóa file ảnh
    if (file_exists($image_path)) {
        unlink($image_path); // Hàm unlink() dùng để xóa file
    }

    // Thông báo thành công và chuyển hướng
    echo "<script>
            alert('Xóa trang bị thành công!');
            window.location.href = 'trangbi.php';
          </script>";
} else {
    // Thông báo lỗi và chuyển hướng
    echo "<script>
            alert('Lỗi! Xóa trang bị thất bại.');
            window.location.href = 'trangbi.php';
          </script>";
}
?>