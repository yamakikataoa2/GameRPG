<?php require_once('header.php'); ?>


<?php 
    require_once('models/taikhoan_model.php'); 

    $obj = new TaiKhoan(); //tạo đối tượng
    $results = $obj->get_all(); //Lấy dữ liệu của bảng
?>
<!-- Bảng Quản lí tài khoản -->
<div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-md mt-6">
    
    <!-- Dòng tiêu đề và nút Thêm -->
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Quản lí tài khoản</h3>
        <a href="taikhoan_them.php" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg text-sm transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-circle"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M12 8v8"/></svg>
            Thêm tài khoản
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-slate-700 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3">ID</th>
                    <th scope="col" class="px-6 py-3">Tên đăng nhập</th>
                    <th scope="col" class="px-6 py-3">Mật khẩu</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dữ liệu mẫu -->
                <?php foreach ($results as $row) { ?>
                <tr class="bg-white border-b dark:bg-slate-800 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600">
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                        <?php static $idtk = 1; echo $idtk++; ?>
                    </td>
                    <td class="px-6 py-4"><?php echo $row['tendangnhap']; ?></td>
                    <td class="px-6 py-4"><?php echo $row['matkhau']; ?></td>
                    <td class="px-6 py-4"><?php echo $row['email']; ?></td>
                     <td class="px-6 py-4">
                        <a href="taikhoan_sua.php?tendangnhap=<?php echo $row['tendangnhap']; ?>" class="font-medium text-indigo-600 dark:text-indigo-400 hover:underline">Sửa</a>
                        <a href="taikhoan_xoa.php?tendangnhap=<?php echo $row['tendangnhap']; ?>" class="font-medium text-red-600 dark:text-red-400 hover:underline ml-4">Xóa</a>
                    </td>
                </tr>
                <?php } ?>   
                <!-- Thêm các dòng khác ở đây -->
            </tbody>
        </table>
    </div>
</div>



<?php require_once('footer.php'); ?>