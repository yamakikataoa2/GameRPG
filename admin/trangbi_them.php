<?php
// Nhúng header để có layout chung
include('header.php');
require_once('class/trangbi.class.php');

// --- Cấu hình các giá trị cố định cho dropdown ---
$ds_dohiem = ["Thường", "Hơi hiếm", "Hiếm", "Sử thi", "Huyền thoại", "Thần thoại"];
$ds_khetrangbi = ["Mũ", "Áo", "Quần", "Giày", "Vũ khí", "Tay chính", "Tay phụ", "Trang sức"];

// Biến để lưu thông báo lỗi hoặc thành công
$message = '';

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $upload_ok = true;
    $error_message = '';

    // --- 1. XỬ LÝ UPLOAD HÌNH ẢNH ---
    $hinh_anh_path = '';
    if (isset($_FILES["imgtrangbi"]) && $_FILES["imgtrangbi"]["error"] == 0) {
        $target_dir = "uploads/"; // Thư mục bạn đã tạo
        $file_name = time() . "_" . basename($_FILES["imgtrangbi"]["name"]);
        $target_file = $target_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["imgtrangbi"]["tmp_name"]);
        if ($check === false) {
            $error_message .= "File được chọn không phải là hình ảnh. ";
            $upload_ok = false;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $error_message .= "Chỉ cho phép upload file ảnh JPG, JPEG, PNG & GIF. ";
            $upload_ok = false;
        }

        if ($upload_ok) {
            if (move_uploaded_file($_FILES["imgtrangbi"]["tmp_name"], $target_file)) {
                $hinh_anh_path = $target_file;
            } else {
                $error_message .= "Đã có lỗi xảy ra khi upload file. ";
                $upload_ok = false;
            }
        }
    } else {
        $error_message .= "Vui lòng chọn một hình ảnh cho trang bị. ";
        $upload_ok = false;
    }

    // --- 2. LƯU THÔNG TIN VÀO CSDL ---
    if ($upload_ok) {
        $new_trangbi = new TrangBi();
        $new_trangbi->tentrangbi  = $_POST['tentrangbi'];
        $new_trangbi->dohiem      = $_POST['dohiem'];
        $new_trangbi->khetrangbi  = $_POST['khetrangbi'];
        $new_trangbi->motatrangbi = $_POST['motatrangbi'];
        $new_trangbi->imgtrangbi  = $hinh_anh_path;

        $result = $new_trangbi->insert();

        if ($result) {
            echo "<script>
                    alert('Thêm trang bị thành công!');
                    window.location.href = 'trangbi.php';
                  </script>";
            exit;
        } else {
            $message = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">Có lỗi xảy ra khi lưu vào CSDL. Tên trang bị có thể đã tồn tại.</div>';
        }
    } else {
         $message = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">' . $error_message . '</div>';
    }
}
?>


    
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Thêm trang bị mới</h2>
        <a href="trangbi.php" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
            &larr; Quay lại danh sách
        </a>
    </div>

    <?php if (!empty($message)) echo $message; ?>

    <form action="" method="post" enctype="multipart/form-data" novalidate>
        
        <div class="mb-4">
            <label for="tentrangbi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tên trang bị</label>
            <input type="text" id="tentrangbi" name="tentrangbi" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-slate-700 dark:border-slate-600 dark:text-gray-200" required>
        </div>
        
        <div class="mb-4">
            <label for="dohiem" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Độ hiếm</label>
            <select id="dohiem" name="dohiem" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-slate-700 dark:border-slate-600 dark:text-gray-200">
                <?php
                    foreach ($ds_dohiem as $dohiem) {
                        echo "<option value='{$dohiem}'>{$dohiem}</option>";
                    }
                ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="khetrangbi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Khe trang bị</label>
            <select id="khetrangbi" name="khetrangbi" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-slate-700 dark:border-slate-600 dark:text-gray-200">
                <?php
                    foreach ($ds_khetrangbi as $khe) {
                        echo "<option value='{$khe}'>{$khe}</option>";
                    }
                ?>
            </select>
        </div>

        <div class="mb-6">
            <label for="motatrangbi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mô tả</label>
            <textarea id="motatrangbi" name="motatrangbi" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-slate-700 dark:border-slate-600 dark:text-gray-200"></textarea>
        </div>

        <div class="mb-6">
            <label for="imgtrangbi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Hình ảnh</label>
            <input type="file" id="imgtrangbi" name="imgtrangbi" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-slate-600 dark:file:text-indigo-300 dark:hover:file:bg-slate-500" required>
            <div class="mt-4">
                <img id="image-preview" src="#" alt="Xem trước ảnh" class="hidden w-40 h-40 object-cover rounded-md shadow-md"/>
            </div>
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800">
                Lưu lại
            </button>
        </div>
    </form>


<?php 
// Nhúng footer để đóng layout
include('footer.php'); 
?>