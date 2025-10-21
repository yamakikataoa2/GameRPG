<?php include_once('header.php'); ?>
<?php

if (isset($_POST['add'])) {
    // Nhúng file class DB và class TaiKhoan
    require_once('class/taikhoan.class.php');

    // Tạo đối tượng của lớp TaiKhoan
    $obj = new TaiKhoan();

    // Gán giá trị cho các thuộc tính
    $obj->tendangnhap = isset($_POST['tendangnhap']) ? $_POST['tendangnhap'] : '';
    $obj->matkhau     = isset($_POST['matkhau']) ? ($_POST['matkhau']) : '';
    $obj->email       = isset($_POST['email']) ? $_POST['email'] : '';

    // Gọi hàm insert để thêm dữ liệu
    $results = $obj->insert();

    // Kiểm tra kết quả thực hiện và đặt thông báo
    if ($results) {
        echo "<script> alert('Thêm mới thành công.') </script>";   
        echo "<script> window.location.href='taikhoan.php' </script>"; 
    } else {
        echo "<script> alert('Lỗi!') </script>";  
        echo "<script> history.go(-1) </script>";   
    }
}

?>

<!-- Nội dung chính của trang -->

        
        <!-- Dòng tiêu đề và nút Quay lại -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Thêm tài khoản mới</h2>
            <a href="index.php" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
                &larr; Quay lại danh sách
            </a>
        </div>
        

        <form action="" method="post">
            <div class="space-y-6">
                <!-- Tên đăng nhập -->
                <div>
                    <label for="tendangnhap" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Tên đăng nhập</label>
                    <input type="text" id="tendangnhap" name="tendangnhap" class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-700 dark:border-slate-600 dark:text-white" placeholder="ví dụ: admin" required>
                </div>

                <!-- Mật khẩu -->
                <div>
                    <label for="matkhau" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Mật khẩu</label>
                    <input type="password" id="matkhau" name="matkhau" class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-700 dark:border-slate-600 dark:text-white" required autocomplete="new-password">    
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Địa chỉ email</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-700 dark:border-slate-600 dark:text-white" placeholder="email@example.com" required>
                </div>
            </div>

            <!-- Nút hành động -->
            <div class="mt-8 flex justify-end">
                <button type="submit" name="add" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-lg text-sm transition-colors">
                    Thêm
                </button>
            </div>
        </form>


<?php include('footer.php'); ?>
