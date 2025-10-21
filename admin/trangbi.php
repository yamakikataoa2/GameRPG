<?php 
include_once('header.php'); 
require_once('class/trangbi.class.php'); 

$ds_trangbi = TrangBi::get_all(); 
?>

<div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-md mt-6">
    
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Quản lí Trang bị</h3>
        <a href="trangbi_them.php" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg text-sm transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-circle"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M12 8v8"/></svg>
            Thêm trang bị
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-slate-700 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3">ID</th>
                    <th scope="col" class="px-6 py-3">Hình ảnh</th>
                    <th scope="col" class="px-6 py-3">Tên trang bị</th>
                    <th scope="col" class="px-6 py-3">Độ hiếm</th>
                    <th scope="col" class="px-6 py-3">Khe trang bị</th>
                    <th scope="col" class="px-6 py-3">Mô tả</th>
                    <th scope="col" class="px-6 py-3 text-right">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($ds_trangbi as $item) { 
                ?>
                <tr class="bg-white border-b dark:bg-slate-800 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600">
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                        <?php static $idtb = 1; echo $idtb++; ?>
                    </td>
                    <td class="px-6 py-4">
                        <img src="<?php echo htmlspecialchars($item['imgtrangbi']); ?>" alt="<?php echo htmlspecialchars($item['tentrangbi']); ?>" class="h-12 w-12 object-cover rounded-md">
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                        <?php echo htmlspecialchars($item['tentrangbi']); ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo htmlspecialchars($item['dohiem']); ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo htmlspecialchars($item['khetrangbi']); ?>
                    </td>
                    <td class="px-6 py-4 max-w-xs truncate" title="<?php echo htmlspecialchars($item['motatrangbi']); ?>">
                        <?php echo htmlspecialchars($item['motatrangbi']); ?>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="trangbi_sua.php?tentrangbi=<?php echo urlencode($item['tentrangbi']); ?>" class="font-medium text-indigo-600 dark:text-indigo-400 hover:underline">Sửa</a>
                        <a href="trangbi_xoa.php?tentrangbi=<?php echo urlencode($item['tentrangbi']); ?>" class="font-medium text-red-600 dark:text-red-400 hover:underline ml-4" onclick="return confirm('Bạn có chắc chắn muốn xóa trang bị này?');">Xóa</a>
                    </td>
                </tr>
                <?php } ?> 
            </tbody>
        </table>
    </div>
</div>

<?php include_once('footer.php'); ?>