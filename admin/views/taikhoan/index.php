<h4 class="text-primary font-weight-bold">Quản lý tài khoản</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th></th>
            <th>Tên đăng nhập</th>
            <th>Mật khẩu</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($taikhoans as $taikhoan) { ?>
        <tr>
            <td>
                <a href="index.php?controller=taikhoan&action=edit&id=<?= $taikhoan->tendangnhap ?>">Sửa</a> |
                <a href="index.php?controller=taikhoan&action=del&id=<?= $taikhoan->tendangnhap ?>" onclick="return confirm('Bạn chắc chắn muốn xóa?');">Xóa</a>
            </td>
            <td>
                <a href="index.php?controller=taikhoan&action=detail&id=<?= $taikhoan->tendangnhap ?>"><?= $taikhoan->tendangnhap ?></a>
            </td>
            <td><?= $taikhoan->matkhau ?></td>
            <td><?= $taikhoan->email ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>