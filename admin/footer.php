            </div>
        </main>
    </div>

    <script>
        $(document).ready(function() {
            // Xử lý đóng/mở sidebar trên mobile
            $('#menu-button').on('click', function() {
                $('#sidebar').toggleClass('-translate-x-full');
                $('#sidebar-overlay').toggleClass('hidden');
                $('body').toggleClass('overflow-hidden');
            });

            $('#sidebar-overlay').on('click', function() {
                $('#sidebar').addClass('-translate-x-full');
                $('#sidebar-overlay').addClass('hidden');
                $('body').removeClass('overflow-hidden');
            });
            
            // Xử lý dropdown hồ sơ
            $('#profile-button').on('click', function(event) {
                event.stopPropagation();
                $('#profile-dropdown').toggleClass('hidden');
            });

            // Đóng dropdown khi click ra ngoài
            $(document).on('click', function(event) {
                if (!$(event.target).closest('#profile-button, #profile-dropdown').length) {
                    $('#profile-dropdown').addClass('hidden');
                }
            });

            // Xử lý chuyển đổi chế độ Sáng/Tối (Dark Mode)
            const darkModeToggle = $('#dark-mode-toggle');
            const html = $('html');

            // Kiểm tra và áp dụng theme đã lưu
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                html.addClass('dark');
            } else {
                html.removeClass('dark');
            }

            darkModeToggle.on('click', function() {
                html.toggleClass('dark');
                if (html.hasClass('dark')) {
                    localStorage.setItem('theme', 'dark');
                } else {
                    localStorage.setItem('theme', 'light');
                }
            });            
            
            //sử lý hình ảnh 
            const fileInput = document.getElementById('imgtrangbi');
            const imagePreview = document.getElementById('image-preview');

            if (fileInput && imagePreview) {
                fileInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreview.src = e.target.result;
                            imagePreview.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    }
             });
            }
        });
    </script>
</body>
</html>