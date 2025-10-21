<?php
// Nạp các class cần thiết để làm việc với CSDL và đối tượng TrangBi
require_once('admin/class/database.class.php');
require_once('admin/class/trangbi.class.php');

// 1. Lấy toàn bộ dữ liệu trang bị từ CSDL
$danhsach_trangbi_raw = TrangBi::get_all_with_limit(12);

// 2. Chuẩn bị một mảng mới để chứa dữ liệu có cấu trúc mà JavaScript mong muốn
// (JavaScript đang cần các key là 'name', 'rarity', 'slot', 'img')
$js_equipment_data = [];
foreach ($danhsach_trangbi_raw as $item) {
    $js_equipment_data[] = [
        'name' => $item['tentrangbi'],
        'rarity' => $item['dohiem'],
        'slot' => $item['khetrangbi'],
        
        'img' => 'admin/' . $item['imgtrangbi'] 
    ];
}
// Nạp header của trang web
include_once('headerweb.php');
?>



    <!-- ===== MAIN (NỘI DUNG CHÍNH) ===== -->
    <main>
        <!-- ===== SECTION 1: SLIDER ẢNH ===== -->
        <section id="slider" class="relative w-full h-[60vh] md:h-[80vh] overflow-hidden">
            <div class="slider-container h-full">
                <!-- Slide 1 -->
                <div class="slider-image active h-full">
                    <img src="img/bg1.jpg" alt="Cảnh game 1" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                        <h2 class="text-4xl md:text-6xl font-cinzel text-white text-center drop-shadow-lg">Khám Phá Thế Giới Rộng Lớn</h2>
                    </div>
                </div>
                <!-- Slide 2 -->
                <div class="slider-image h-full">
                    <img src="img/bg2.jpg" alt="Cảnh game 2" class="w-full h-full object-cover">
                     <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                        <h2 class="text-4xl md:text-6xl font-cinzel text-white text-center drop-shadow-lg">Đối Mặt Thử Thách Cam Go</h2>
                    </div>
                </div>
            </div>
            <!-- Nút điều khiển slider -->
            <button id="prev-slide" class="absolute top-1/2 left-4 -translate-y-1/2 bg-white/20 hover:bg-white/40 text-white font-bold text-2xl p-3 rounded-full transition">&lt;</button>
            <button id="next-slide" class="absolute top-1/2 right-4 -translate-y-1/2 bg-white/20 hover:bg-white/40 text-white font-bold text-2xl p-3 rounded-full transition">&gt;</button>
        </section>

        <!-- ===== SECTION 2: CÁC ANH HÙNG ===== -->
        <section id="characters" class="py-16 bg-gray-900">
            <div class="container mx-auto px-6">
                <h2 class="text-4xl font-cinzel text-center mb-10 text-red-400">Các Anh Hùng</h2>
                <!-- Lưới hiển thị các nhân vật -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                    <!-- Thẻ thông tin một nhân vật (Character Card) -->
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg transform hover:-translate-y-2 transition-transform duration-300 flex flex-col">
                        <img src="https://static.dfoneople.com/publish/bbs_data_neople/images/charac_info/27c8563fd4/15/1/0/fighter_m_02_neo.jpg" alt="Chiến Binh Rồng" class="w-full h-64 object-cover">
                        <!-- `flex flex-col flex-grow` giúp nút "Chi tiết" luôn ở cuối thẻ -->
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-2xl font-bold font-cinzel text-white">Kael</h3>
                            <p class="text-red-400 mb-4">Chiến Binh Rồng</p>
                            <a href="#" class="mt-auto block text-center w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">Chi tiết</a>
                        </div>
                    </div>
                    <!-- Các thẻ nhân vật khác tương tự -->
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg transform hover:-translate-y-2 transition-transform duration-300 flex flex-col">
                        <img src="https://static.dfoneople.com/publish/bbs_data_st1_neople/images/charac_info/2a5f21547c/19/1/0/mage_m_02_2.jpg" alt="Pháp Sư Băng Giá" class="w-full h-64 object-cover">
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-2xl font-bold font-cinzel text-white">Lyra</h3>
                            <p class="text-blue-400 mb-4">Pháp Sư Băng Giá</p>
                            <a href="#" class="mt-auto block text-center w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">Chi tiết</a>
                        </div>
                    </div>
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg transform hover:-translate-y-2 transition-transform duration-300 flex flex-col">
                        <img src="https://static.dfoneople.com/publish/bbs_data_neople/images/charac_info/188d18af1c/16/2/0/archer_01_3.jpg" alt="Xạ Thủ Tinh Nghịch" class="w-full h-64 object-cover">
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-2xl font-bold font-cinzel text-white">Fenrir</h3>
                            <p class="text-green-400 mb-4">Xạ Thủ Tinh Nghịch</p>
                            <a href="#" class="mt-auto block text-center w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">Chi tiết</a>
                        </div>
                    </div>
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg transform hover:-translate-y-2 transition-transform duration-300 flex flex-col">
                        <img src="https://static.dfoneople.com/publish/bbs_data_neople/images/charac_info/cb15c5f14a/24/1/0/slayer_f_03_neo.jpg" alt="Thích Khách Bóng Đêm" class="w-full h-64 object-cover">
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-2xl font-bold font-cinzel text-white">Seraphina</h3>
                            <p class="text-yellow-400 mb-4">Thích Khách Bóng Đêm</p>
                            <a href="#" class="mt-auto block text-center w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">Chi tiết</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== SECTION 3: KHO TRANG BỊ ===== -->
        <section id="equipment" class="py-16 bg-gray-800">
            <div class="container mx-auto px-6">
                <h2 class="text-4xl font-cinzel text-center mb-10 text-red-400">Kho Trang Bị</h2>
                
                <!-- Khu vực chứa các nút lọc -->
                <div id="filters" class="flex flex-col md:flex-row gap-4 justify-center mb-8">
                    <!-- Nhóm lọc theo độ hiếm -->
                    <div class="filter-group">
                        <h3 class="font-bold mb-2 text-center">Độ hiếm</h3>
                        <div id="rarity-filters" class="flex flex-wrap justify-center gap-2">
                            <!-- Các nút lọc độ hiếm sẽ được JavaScript chèn vào đây -->
                        </div>
                    </div>
                    <!-- Nhóm lọc theo khe trang bị -->
                    <div class="filter-group">
                        <h3 class="font-bold mb-2 text-center">Khe trang bị</h3>
                        <div id="slot-filters" class="flex flex-wrap justify-center gap-2">
                           <!-- Các nút lọc khe trang bị sẽ được JavaScript chèn vào đây -->
                        </div>
                    </div>
                </div>

                <!-- Lưới hiển thị trang bị -->
                <div id="equipment-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    <!-- Các thẻ trang bị sẽ được JavaScript chèn vào đây -->
                </div>
            </div>
        </section>
        
        <!-- ===== SECTION 4: TIN TỨC & SỰ KIỆN ===== -->
        <section id="news" class="py-16 bg-gray-900">
            <div class="container mx-auto px-6">
                <h2 class="text-4xl font-cinzel text-center mb-10 text-red-400">Tin Tức & Sự Kiện</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Thẻ một bài tin tức -->
                    <div class="bg-gray-800 rounded-lg overflow-hidden group flex flex-col">
                        <div class="overflow-hidden">
                           <img src="https://static.dfoneople.com/publish/bbs_data/images/media_wallpapers/730252f029/6/18/0/thumbnail.jpg" alt="Sự kiện" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <p class="text-sm text-gray-400 mb-2">01/08/2024</p>
                            <h3 class="text-xl font-bold text-white mb-2">Sự Kiện Mùa Hè Bùng Nổ Với Vật Phẩm Độc Quyền</h3>
                            <p class="text-gray-300 mb-4">Tham gia ngay để nhận những trang phục và phần thưởng giới hạn chỉ có trong mùa hè này!</p>
                            <a href="#" class="mt-auto block text-center w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">Đọc thêm</a>
                        </div>
                    </div>
                    <!-- Các thẻ tin tức khác tương tự -->
                     <div class="bg-gray-800 rounded-lg overflow-hidden group flex flex-col">
                        <div class="overflow-hidden">
                           <img src="https://static.dfoneople.com/publish/bbs_data/images/media_wallpapers/1615b1843f/19/17/0/thumbnail.jpg" alt="Cập nhật" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <p class="text-sm text-gray-400 mb-2">25/07/2024</p>
                            <h3 class="text-xl font-bold text-white mb-2">Chi Tiết Bản Cập Nhật 2.5: Cân Bằng Sức Mạnh</h3>
                            <p class="text-gray-300 mb-4">Một loạt các thay đổi về tướng và trang bị để mang lại một meta game cân bằng hơn.</p>
                             <a href="#" class="mt-auto block text-center w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">Đọc thêm</a>
                        </div>
                    </div>
                     <div class="bg-gray-800 rounded-lg overflow-hidden group flex flex-col">
                        <div class="overflow-hidden">
                           <img src="https://static.dfoneople.com/publish/bbs_data/images/media_wallpapers/b6be8b993e/2/17/0/s8a1b_thum.jpg" alt="Giải đấu" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <p class="text-sm text-gray-400 mb-2">15/07/2024</p>
                            <h3 class="text-xl font-bold text-white mb-2">Mở Đăng Ký Giải Đấu Mùa Thu 2024</h3>
                            <p class="text-gray-300 mb-4">Cơ hội để bạn và đồng đội tỏa sáng, giành lấy vinh quang và giải thưởng hàng trăm triệu đồng.</p>
                             <a href="#" class="mt-auto block text-center w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">Đọc thêm</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    
<?php include_once('footerweb.php'); ?>


