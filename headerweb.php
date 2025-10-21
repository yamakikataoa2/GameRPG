<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thế Giới Giả Tưởng - Trang Chủ Game</title>
    <!-- Tải thư viện Tailwind CSS từ CDN để tạo giao diện nhanh chóng -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Tải phông chữ từ Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://css.gg/css?family=Roboto:wght@400;700&family=Cinzel+Decorative:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Khu vực CSS tùy chỉnh -->
    <style>
        /* --- Cài đặt cơ bản cho toàn trang --- */
        body {
            font-family: 'Roboto', sans-serif; /* Phông chữ mặc định */
            background-color: #121212; /* Màu nền tối */
            color: #e0e0e0; /* Màu chữ sáng */
        }
        /* Lớp tùy chỉnh để sử dụng phông chữ Cinzel Decorative cho tiêu đề */
        .font-cinzel {
            font-family: 'Cinzel Decorative', cursive;
        }

        /* --- CSS cho Slider Ảnh --- */
        .slider-image {
            display: none; /* Mặc định ẩn tất cả các ảnh */
            animation: fade 1.5s ease-in-out; /* Thêm hiệu ứng mờ dần khi xuất hiện */
        }
        .slider-image.active {
            display: block; /* Chỉ hiển thị ảnh có lớp 'active' */
        }
        /* Định nghĩa hiệu ứng 'fade' */
        @keyframes fade {
            from { opacity: .4 }
            to { opacity: 1 }
        }

        /* --- CSS cho màu sắc viền và chữ theo độ hiếm của trang bị --- */
        /* Các lớp này sẽ được thêm vào thẻ trang bị để thể hiện độ hiếm qua màu sắc */
        .rarity-Thường { border-color: #9ca3af; color: #9ca3af; }
        .rarity-Hơi-hiếm { border-color: #6ee7b7; color: #6ee7b7; }
        .rarity-Hiếm { border-color: #60a5fa; color: #60a5fa; }
        .rarity-Sử-thi { border-color: #c084fc; color: #c084fc; }
        .rarity-Huyền-thoại { border-color: #facc15; color: #facc15; }
        .rarity-Thần-thoại { border-color: #f87171; color: #f87171; }

        /* --- CSS cho nút lọc khi được chọn (active) --- */
        .filter-btn.active {
            background-color: #f87171; /* Đổi màu nền */
            color: #121212; /* Đổi màu chữ */
            border-color: #f87171; /* Đổi màu viền */
        }
        /* --- CSS cho hiệu ứng xuất hiện của vật phẩm --- */
        @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px); /* Bắt đầu từ vị trí thấp hơn 20px */
        }
        to {
            opacity: 1;
            transform: translateY(0); /* Di chuyển về vị trí ban đầu */
        }
        }

        .item-card {
            /* Mặc định ẩn đi để chuẩn bị cho animation */
            opacity: 0; 
            /* Áp dụng animation, forwards để giữ lại trạng thái cuối cùng */
            animation: fadeInUp 0.5s ease-out forwards;
        }

    </style>
</head>

<body class="bg-gray-900 text-gray-200 flex flex-col min-h-screen">

    <!-- ===== HEADER (ĐẦU TRANG) ===== -->
    <!-- `sticky top-0 z-50` giữ cho header luôn ở trên cùng màn hình khi cuộn trang -->
    <header class="bg-gray-900/80 backdrop-blur-sm sticky top-0 z-50 shadow-lg shadow-red-900/20">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Logo/Tên Game -->
            <a href="index.php" class="text-3xl font-bold font-cinzel text-white">MYTHOS</a>
            <!-- Menu cho máy tính bảng và máy tính lớn (`hidden md:flex` ẩn trên di động, hiện trên màn hình lớn) -->
            <div class="hidden md:flex space-x-8 items-center">
                <a href="#characters" class="hover:text-red-400 transition duration-300">Nhân Vật</a>
                <a href="#equipment" class="hover:text-red-400 transition duration-300">Trang Bị</a>
                <a href="#news" class="hover:text-red-400 transition duration-300">Tin Tức</a>
                <a href="#" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">Chơi Ngay</a>
            </div>
            <!-- Nút menu cho di động (`md:hidden` chỉ hiện trên di động) -->
            <button id="mobile-menu-button" class="md:hidden text-2xl">☰</button>
        </nav>
        <!-- Menu xổ xuống cho di động (mặc định ẩn) -->
        <div id="mobile-menu" class="hidden md:hidden px-6 pb-4">
            <a href="#characters" class="block py-2 hover:text-red-400">Nhân Vật</a>
            <a href="#equipment" class="block py-2 hover:text-red-400">Trang Bị</a>
            <a href="#news" class="block py-2 hover:text-red-400">Tin Tức</a>
            <a href="#" class="block mt-2 bg-red-600 hover:bg-red-700 text-white text-center font-bold py-2 px-4 rounded-lg">Chơi Ngay</a>
        </div>
    </header>