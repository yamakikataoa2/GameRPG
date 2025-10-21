<?php
// Nạp các class cần thiết để làm việc với CSDL
require_once('admin/class/database.class.php');
require_once('admin/class/trangbi.class.php');

// --- BƯỚC 1: LẤY TÊN TRANG BỊ TỪ URL ---
// Kiểm tra xem tham số 'name' có tồn tại trên URL và không rỗng không
if (isset($_GET['name']) && !empty($_GET['name'])) {
    $tentrangbi = $_GET['name'];
} else {
    // Nếu không có tên, hiển thị lỗi và dừng chương trình
    echo "<h1>Không tìm thấy trang bị!</h1>";
    exit(); // Dừng lại
}

// --- BƯỚC 2: TRUY VẤN CSDL ĐỂ LẤY THÔNG TIN CHI TIẾT ---
// Dùng hàm get_byid() đã có trong class TrangBi để lấy thông tin
$trang_bi_chi_tiet = TrangBi::get_byid($tentrangbi);

// Kiểm tra xem có tìm thấy trang bị trong CSDL không
if (!$trang_bi_chi_tiet) {
    echo "<h1>Trang bị không tồn tại!</h1>";
    exit();
}

// Nạp header của trang web để giao diện thống nhất
include_once('headerweb.php'); 
?>

<main class="container mx-auto px-6 py-12 flex-grow">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <div class="md:col-span-1">
            <?php
                // Chuẩn bị class CSS cho độ hiếm (ví dụ: "Thần thoại" -> "rarity-Thần-thoại")
                $rarity_class = 'rarity-' . str_replace(' ', '-', $trang_bi_chi_tiet['dohiem']);
            ?>
            <div class="p-1 rounded-lg border-4 <?php echo htmlspecialchars($rarity_class); ?>">
                <img src="admin/<?php echo htmlspecialchars($trang_bi_chi_tiet['imgtrangbi']); ?>" 
                    alt="<?php echo htmlspecialchars($trang_bi_chi_tiet['tentrangbi']); ?>" 
                    class="w-full h-auto rounded-md shadow-lg object-cover">
            </div>
        </div>

      <div class="md:col-span-2">
            <h1 class="text-4xl font-bold font-cinzel text-white mb-4">
                <?php echo htmlspecialchars($trang_bi_chi_tiet['tentrangbi']); ?>
            </h1>
            
            <div class="mb-6 border-b border-gray-700 pb-4">
                <p class="text-lg">
                    <span class="font-bold text-gray-400">Độ hiếm:</span> 
                    <span class="font-bold rarity-<?php echo str_replace(' ', '-', $trang_bi_chi_tiet['dohiem']); ?>">
                        <?php echo htmlspecialchars($trang_bi_chi_tiet['dohiem']); ?>
                    </span>
                </p>
                <p class="text-lg">
                    <span class="font-bold text-gray-400">Loại:</span> 
                    <?php echo htmlspecialchars($trang_bi_chi_tiet['khetrangbi']); ?>
                </p>
            </div>
            
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold text-red-400">Mô tả</h2>
                
                <a href="index.php#equipment" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 no-underline">
                    &larr; Quay lại danh sách
                </a>
            </div>

            <div class="prose prose-invert max-w-none">
                <p class="text-gray-300">
                    <?php echo nl2br(htmlspecialchars($trang_bi_chi_tiet['motatrangbi'])); ?>
                </p>
            </div>
        </div>
</main>

<?php include_once('footerweb.php'); ?>