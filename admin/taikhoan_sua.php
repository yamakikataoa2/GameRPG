<?php include('header.php'); ?>

<?php
// Nhúng các file cần thiết

require_once('class/taikhoan.class.php');

// Lấy tendangnhap từ URL để biết cần sửa tài khoản nào
$tendangnhap = isset($_GET['tendangnhap']) ? $_GET['tendangnhap'] : '';

// Tạo đối tượng và lấy thông tin tài khoản hiện tại để hiển thị ra form
$obj = new taikhoan();
$row = $obj->get_byid($tendangnhap);

// Xử lý khi người dùng nhấn nút "Sửa" để cập nhật thông tin
if (isset($_POST['edit'])) {
    // Gán giá trị mới từ form cho các thuộc tính của đối tượng
    // tendangnhap được lấy từ hidden field vì ô input ở trên bị disabled
    $obj->tendangnhap = isset($_POST['tendangnhap']) ? $_POST['tendangnhap'] : '';
    $obj->matkhau     = isset($_POST['matkhau']) ? ($_POST['matkhau']) : '';
    $obj->email       = isset($_POST['email']) ? $_POST['email'] : '';

    // Gọi hàm update để cập nhật vào CSDL
    $results = $obj->update();

    // Hiển thị thông báo kết quả
    if ($results) {
        echo "<script> alert('Sửa thành công.'); window.location.href='taikhoan.php' </script>";
    } else {
        echo "<script> alert('Lỗi!'); history.go(-1) </script>";
    }
}
?>

<div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Sửa thông tin tài khoản</h2>
            <a href="taikhoan.php" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
                &larr; Quay lại danh sách
            </a>
        </div>
    
    <form action="" method="post" novalidate>
        
        <div class="mb-4">
            <label for="tendangnhap" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tên đăng nhập</label>
            <input type="text" id="tendangnhap" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 dark:bg-slate-700 dark:border-slate-600 dark:text-gray-400 cursor-not-allowed" value="<?php echo htmlspecialchars($row['tendangnhap']); ?>" disabled>
        </div>
        
        <div class="mb-4">
            <label for="matkhau" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mật khẩu mới</label>
            <input type="text" id="matkhau" name="matkhau" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-slate-700 dark:border-slate-600 dark:text-gray-200" value="<?php echo htmlspecialchars($row['matkhau']); ?>" placeholder="Nhập mật khẩu mới">
        </div>

        <div class="mb-6">
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
            <input type="email" id="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-slate-700 dark:border-slate-600 dark:text-gray-200" value="<?php echo htmlspecialchars($row['email']); ?>">
        </div>
        
        <input type="hidden" name="tendangnhap" value="<?php echo htmlspecialchars($row['tendangnhap']); ?>">
        
        <div class="flex justify-end">
            <button type="submit" name="edit" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800">
                Lưu thay đổi
            </button>
        </div>

    </form>

<?php include('footer.php'); ?>