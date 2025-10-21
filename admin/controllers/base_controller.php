<?php
class BaseController
{
    protected $folder; //Biến có giá trị là thư mục trong thư mục views\tên_module, chứa các file view template của module đang truy cập.

    // Hàm hiển thị kết quả ra cho người dùng. Biến file lưu tên file của view, mảng data lưu thông tin dữ liệu truyền cho view.
    function render($file, $data = array())
    {
        // Kiểm tra file gọi đến có tồn tại hay không?
        $view_file = 'views/' . $this->folder . '/' . $file . '.php';
        if (is_file($view_file)) {
            // Nếu tồn tại file đó thì tạo ra các biến chứa giá trị truyền
            // vào lúc gọi hàm. Các khóa mảng làm tên biến và giá trị là giá trị biến.
            // /$data là một mảng kết hợp (mảng có khóa và giá trị). Khi sử dụng
            // hàm extract sẽ tạo ra các biến mới từ khóa của mảng và giá trị của mảng.
            extract($data);
            
            //Sau đó lưu giá trị trả về khi chạy file view template với
            // các dữ liệu đó vào 1 biến mà chưa hiển thị luôn ra trình duyệt.
            ob_start(); // Tạo bộ đệm đầu ra.
            require_once($view_file);
            $content = ob_get_clean(); // trả về nội dung của bộ đệm
            // đầu ra và sau đó xóa nội dung khỏi bộ đệm.

            // Sau khi có kết quả đã được lưu vào biến $content, gọi
            // ra template chung của hệ thống để hiển thị ra cho người dùng.
            require_once('views/layouts/main.php');
        } else {
            // Nếu file muốn gọi ra không tồn tại thì chuyển hướng đến
            // trang báo lỗi.
            header('Location: index.php?controller=home&action=error');
        }
    }
}