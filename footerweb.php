    <!-- ===== FOOTER (CHÂN TRANG) ===== -->
    <footer class="bg-gray-800 border-t border-gray-700 py-8">
        <div class="container mx-auto px-6 text-center text-gray-400">
            <p>&copy; 2024 Mythos Game Studio. Mọi quyền được bảo lưu.</p>
            <div class="flex justify-center space-x-4 mt-4">
                <a href="#" class="hover:text-white">Facebook</a>
                <a href="#" class="hover:text-white">Twitter</a>
                <a href="#" class="hover:text-white">Discord</a>
            </div>
        </div>
    </footer>

<!-- ===== JAVASCRIPT ===== -->
<script>
// Chờ cho toàn bộ nội dung HTML được tải xong rồi mới chạy mã JavaScript
document.addEventListener('DOMContentLoaded', function() {
    
    // --- LOGIC CHO MENU DI ĐỘNG ---
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    // Khi nhấn nút menu, thêm hoặc xóa lớp 'hidden' để ẩn/hiện menu
    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    // --- LOGIC CHO SLIDER ẢNH ---
    const slides = document.querySelectorAll('.slider-image');
    const prevButton = document.getElementById('prev-slide');
    const nextButton = document.getElementById('next-slide');
    let currentSlide = 0; // Biến theo dõi slide hiện tại
    let slideInterval; // Biến để lưu trữ bộ đếm thời gian tự động chuyển slide

    // Hàm hiển thị một slide cụ thể và ẩn các slide khác
    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.remove('active'); // Xóa lớp 'active' khỏi tất cả
            if (i === index) {
                slide.classList.add('active'); // Thêm lớp 'active' cho slide cần hiển thị
            }
        });
    }

    // Hàm chuyển đến slide tiếp theo
    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length; // Quay vòng lại slide đầu nếu đang ở cuối
        showSlide(currentSlide);
    }
    
    // Hàm quay lại slide trước đó
    function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length; // Quay vòng lại slide cuối nếu đang ở đầu
        showSlide(currentSlide);
    }

    // Hàm bắt đầu tự động chuyển slide
    function startSlideShow() {
        slideInterval = setInterval(nextSlide, 5000); // Chuyển slide sau mỗi 5 giây
    }
    
    // Hàm dừng tự động chuyển slide
    function stopSlideShow() {
        clearInterval(slideInterval);
    }

    // Khởi tạo slider
    if (prevButton && nextButton && slides.length > 0) {
        // Gắn sự kiện click cho nút "Previous" và "Next"
        prevButton.addEventListener('click', () => {
            prevSlide();
            stopSlideShow(); // Dừng và bắt đầu lại để reset bộ đếm thời gian
            startSlideShow();
        });
        nextButton.addEventListener('click', () => {
            nextSlide();
            stopSlideShow();
            startSlideShow();
        });
        // Bắt đầu tự động chuyển slide khi trang tải xong
        startSlideShow();
    }


    // --- LOGIC LỌC TRANG BỊ ---
    
    // Mảng chứa các tùy chọn lọc
    const rarities = ["Tất cả", "Thường", "Hơi hiếm", "Hiếm", "Sử thi", "Huyền thoại", "Thần thoại"];
    const slots = ["Tất cả", "Mũ", "Áo", "Quần", "Giày", "Vũ khí", "Tay chính", "Tay phụ", "Trang sức"];

    // Mảng chứa dữ liệu của tất cả trang bị (DỮ LIỆU ĐƯỢC LẤY TỪ PHP)
    const equipmentData = <?php echo json_encode($js_equipment_data); ?>;

    // Lấy các element vùng chứa nút lọc và lưới trang bị từ HTML
    const rarityFiltersContainer = document.getElementById('rarity-filters');
    const slotFiltersContainer = document.getElementById('slot-filters');
    const equipmentGrid = document.getElementById('equipment-grid');

    // Biến lưu trạng thái lọc hiện tại
    let currentRarity = 'Tất cả';
    let currentSlot = 'Tất cả';

    // Hàm để tự động tạo các nút lọc từ một mảng dữ liệu
    function createFilterButtons(container, items, type) {
        items.forEach(item => {
            const button = document.createElement('button');
            const normalizedItem = item.replace(/\s+/g, '-'); // Thay thế khoảng trắng để dùng trong class CSS
            button.className = `filter-btn border-2 border-gray-500 text-gray-300 py-1 px-3 rounded-md hover:bg-red-500 hover:border-red-500 transition rarity-${normalizedItem}`;
            button.textContent = item;
            button.dataset.filter = item; // Lưu giá trị lọc vào data attribute
            button.dataset.type = type;   // Lưu loại lọc (rarity/slot) vào data attribute
            if (item === 'Tất cả') {
                button.classList.add('active'); // Đặt nút "Tất cả" làm mặc định
            }
            container.appendChild(button);
        });
    }

    // Hàm chính để hiển thị các trang bị lên lưới
    function renderEquipment() {
        equipmentGrid.innerHTML = ''; // Xóa sạch lưới trước khi hiển thị lại
        
        // Lọc mảng `equipmentData` dựa trên `currentRarity` và `currentSlot`
        const filteredItems = equipmentData.filter(item => {
            const rarityMatch = currentRarity === 'Tất cả' || item.rarity === currentRarity;
            const slotMatch = currentSlot === 'Tất cả' || item.slot === currentSlot;
            return rarityMatch && slotMatch;
        });

        // Tạo HTML cho mỗi trang bị đã được lọc và thêm vào lưới
        filteredItems.forEach((item, index) => { // Phải có (item, index)
            const rarityClass = 'rarity-' + item.rarity.replace(/\s+/g, '-');
            const itemElement = document.createElement('a');

            // Thêm class 'item-card' và các class hiệu ứng hover
            itemElement.className = `item-card block bg-gray-700 rounded-lg border-2 ${rarityClass} flex flex-col text-center overflow-hidden h-full transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-xl hover:z-10`;

            // Thêm độ trễ cho animation để tạo hiệu ứng nối đuôi
            itemElement.style.animationDelay = `${index * 50}ms`; // Mỗi item xuất hiện sau 50ms

            // Dựng link và nội dung HTML
            itemElement.href = `trangbichitiet.php?name=${encodeURIComponent(item.name)}`;
            itemElement.innerHTML = `
                <div class="bg-gray-700 rounded-lg border-2 ${rarityClass} flex flex-col text-center overflow-hidden h-full 
                        transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-xl hover:z-10">
                    <img src="${item.img}" alt="${item.name}" class="w-full h-40 object-cover">
                    <div class="p-2 flex flex-col flex-grow items-center justify-center">
                        <h4 class="font-bold text-sm text-white">${item.name}</h4>
                        <p class="text-xs">${item.rarity}</p>
                    </div>
                </div>
            `;
            equipmentGrid.appendChild(itemElement);
        });
    }

    // Hàm xử lý sự kiện khi người dùng nhấn vào một nút lọc
    function handleFilterClick(e) {
        // Chỉ xử lý nếu đối tượng được click là một nút lọc
        if (!e.target.matches('.filter-btn')) return;

        const filter = e.target.dataset.filter;
        const type = e.target.dataset.type;

        // Cập nhật trạng thái lọc dựa trên nút được nhấn
        if (type === 'rarity') {
            currentRarity = filter;
            // Bỏ active ở tất cả các nút độ hiếm
            document.querySelectorAll('#rarity-filters .filter-btn').forEach(btn => btn.classList.remove('active'));
        } else if (type === 'slot') {
            currentSlot = filter;
            // Bỏ active ở tất cả các nút khe trang bị
            document.querySelectorAll('#slot-filters .filter-btn').forEach(btn => btn.classList.remove('active'));
        }
        
        // Thêm lớp 'active' cho nút vừa được nhấn
        e.target.classList.add('active');
        // Gọi lại hàm render để cập nhật lưới trang bị
        renderEquipment();
    }

    // Khởi tạo khu vực lọc trang bị
    if (rarityFiltersContainer && slotFiltersContainer && equipmentGrid) {
        createFilterButtons(rarityFiltersContainer, rarities, 'rarity'); // Tạo nút lọc độ hiếm
        createFilterButtons(slotFiltersContainer, slots, 'slot');       // Tạo nút lọc khe trang bị
        renderEquipment(); // Hiển thị trang bị lần đầu tiên
        // Gắn một bộ lắng nghe sự kiện duy nhất cho toàn bộ khu vực lọc
        document.getElementById('filters').addEventListener('click', handleFilterClick);
    }
});
</script>

</body>
</html>