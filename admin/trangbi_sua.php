<?php
// Nhúng header, class
include('header.php');
require_once('class/trangbi.class.php');

// --- Cấu hình các giá trị cố định cho dropdown ---
$ds_dohiem = ["Thường", "Hơi hiếm", "Hiếm", "Sử thi", "Huyền thoại", "Thần thoại"];
$ds_khetrangbi = ["Mũ", "Áo", "Quần", "Giày", "Vũ khí", "Tay chính", "Tay phụ", "Trang sức"];

// --- 1. LẤY DỮ LIỆU CŨ CỦA TRANG BỊ ---
// Lấy tentrangbi từ URL
$tentrangbi_get = isset($_GET['tentrangbi']) ? $_GET['tentrangbi'] : '';
if (!$tentrangbi_get) {
    // Nếu không có tentrangbi, chuyển hướng về trang danh sách
    header("Location: trangbi.php");
    exit;
}

// Lấy thông tin chi tiết của trang bị để hiển thị ra form
$trangbi_hientai = TrangBi::get_byid($tentrangbi_get);
if (!$trangbi_hientai) {
    echo "Trang bị không tồn tại!";
    exit;
}

$message = '';
// --- 2. XỬ LÝ KHI NGƯỜI DÙNG SUBMIT FORM ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $upload_ok = true;
    $error_message = '';
    $hinh_anh_path = $trangbi_hientai['imgtrangbi']; // Mặc định giữ lại ảnh cũ

    // --- 2.1 XỬ LÝ UPLOAD ẢNH MỚI (NẾU CÓ) ---
    if (isset($_FILES["imgtrangbi_moi"]) && $_FILES["imgtrangbi_moi"]["error"] == 0) {
        $target_dir = "uploads/";
        $file_name = time() . "_" . basename($_FILES["imgtrangbi_moi"]["name"]);
        $target_file = $target_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["imgtrangbi_moi"]["tmp_name"]);
        if ($check === false) {
            $error_message .= "File mới không phải là hình ảnh. ";
            $upload_ok = false;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $error_message .= "Chỉ cho phép upload file ảnh JPG, JPEG, PNG & GIF. ";
            $upload_ok = false;
        }

        if ($upload_ok) {
            if (move_uploaded_file($_FILES["imgtrangbi_moi"]["tmp_name"], $target_file)) {
                // Upload ảnh mới thành công, gán đường dẫn mới
                $hinh_anh_path = $target_file;
                // An toàn hơn: Xóa ảnh cũ sau khi cập nhật CSDL thành công
            } else {
                $error_message .= "Có lỗi khi upload file mới. ";
                $upload_ok = false;
            }
        }
    }

    // --- 2.2 CẬP NHẬT VÀO CSDL ---
    if ($upload_ok) {
        $trangbi_update = new TrangBi();
        // Lấy tentrangbi từ hidden input để đảm bảo đúng
        $trangbi_update->tentrangbi  = $_POST['tentrangbi_hidden']; 
        $trangbi_update->dohiem      = $_POST['dohiem'];
        $trangbi_update->khetrangbi  = $_POST['khetrangbi'];
        $trangbi_update->motatrangbi = $_POST['motatrangbi'];
        $trangbi_update->imgtrangbi  = $hinh_anh_path; // Đường dẫn ảnh mới hoặc ảnh cũ

        $result = $trangbi_update->update();

        if ($result) {
            // Nếu có upload ảnh mới và cập nhật thành công, thì xóa ảnh cũ đi
            if ($hinh_anh_path != $trangbi_hientai['imgtrangbi'] && file_exists($trangbi_hientai['imgtrangbi'])) {
                unlink($trangbi_hientai['imgtrangbi']);
            }
            echo "<script>
                    alert('Cập nhật trang bị thành công!');
                    window.location.href = 'trangbi.php';
                  </script>";
            exit;
        } else {
            $message = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">Có lỗi xảy ra hoặc không có gì thay đổi.</div>';
        }
    } else {
         $message = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">' . $error_message . '</div>';
    }
}
?>


    
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Sửa thông tin Trang bị</h2>
        <a href="trangbi.php" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
            &larr; Quay lại danh sách
        </a>
    </div>

    <?php if (!empty($message)) echo $message; ?>

    <form action="" method="post" enctype="multipart/form-data" novalidate>
        
        <div class="mb-4">
            <label for="tentrangbi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tên trang bị</label>
            <input type="text" id="tentrangbi" name="tentrangbi" class="w-full px-3 py-2 border rounded-md bg-gray-100 dark:bg-slate-700 dark:border-slate-600 dark:text-gray-400 cursor-not-allowed" value="<?php echo htmlspecialchars($trangbi_hientai['tentrangbi']); ?>" disabled>
            <input type="hidden" name="tentrangbi_hidden" value="<?php echo htmlspecialchars($trangbi_hientai['tentrangbi']); ?>">
        </div>
        
        <div class="mb-4">
            <label for="dohiem" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Độ hiếm</label>
            <select id="dohiem" name="dohiem" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-slate-700 dark:border-slate-600 dark:text-gray-200">
                <?php
                    foreach ($ds_dohiem as $dohiem) {
                        // Thêm 'selected' nếu giá trị trùng với dữ liệu cũ
                        $selected = ($dohiem == $trangbi_hientai['dohiem']) ? 'selected' : '';
                        echo "<option value='{$dohiem}' {$selected}>{$dohiem}</option>";
                    }
                ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="khetrangbi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Khe trang bị</label>
            <select id="khetrangbi" name="khetrangbi" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-slate-700 dark:border-slate-600 dark:text-gray-200">
                <?php
                    foreach ($ds_khetrangbi as $khe) {
                        $selected = ($khe == $trangbi_hientai['khetrangbi']) ? 'selected' : '';
                        echo "<option value='{$khe}' {$selected}>{$khe}</option>";
                    }
                ?>
            </select>
        </div>

        <div class="mb-6">
            <label for="motatrangbi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mô tả</label>
            <textarea id="motatrangbi" name="motatrangbi" rows="4" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-slate-700 dark:border-slate-600 dark:text-gray-200"><?php echo htmlspecialchars($trangbi_hientai['motatrangbi']); ?></textarea>
        </div>

        <div class="mb-6">
            <label for="imgtrangbi_moi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tải ảnh mới (để trống nếu không muốn thay đổi)</label>
            <img src="<?php echo htmlspecialchars($trangbi_hientai['imgtrangbi']); ?>" alt="Ảnh hiện tại" class="w-40 h-40 object-cover rounded-md shadow-md mb-4"/>
            <input type="file" id="imgtrangbi" name="imgtrangbi_moi" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-slate-600 dark:file:text-indigo-300 dark:hover:file:bg-slate-500">
            <div class="mt-4">
                <img id="image-preview" src="#" alt="Xem trước ảnh mới" class="hidden w-40 h-40 object-cover rounded-md shadow-md"/>
            </div>
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800">
                Lưu thay đổi
            </button>
        </div>
    </form>


<?php 
include('footer.php'); 
?>