<?php
session_start();
include_once '../PHP/Connect.php';

$search_query = "";
$sql = "SELECT * FROM nguyenlieu";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = $_GET['search'];
    $sql .= " WHERE TenNguyenLieu LIKE ?";
}
$sql .= " ORDER BY idNguyenLieu ASC";

$stmt = $conn->prepare($sql);
if (!empty($search_query)) {
    $search_term = "%" . $search_query . "%";
    $stmt->bind_param("s", $search_term);
}
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Kho Nguyên Liệu</title>
    <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
    <link rel="stylesheet" href="../Css/css.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .status-badge { padding: 5px 12px; border-radius: 15px; font-size: 13px; font-weight: 600; color: white; text-align: center; display: inline-block; }
        .status-badge.on-dinh { background-color: #28a745; }
        .status-badge.sap-het { background-color: #f0ad4e; }
        .status-badge.het-hang { background-color: #d9534f; }
        .tbdonhang.modern strong { color: white;}
    </style>
</head>
<body>
    <?php include '../PHP/menu_dashboard.php'; ?>
    <div class="dashboard">
        <div class="main-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Tồn Kho Nguyên Liệu</h2>
            <div>
                 <a href="capnhat_tonkho.php" class="btn-primary" style="text-decoration: none; padding: 12px 20px;">Nhập/Xuất Kho</a>
                 <a href="chinhsua_nguyenlieu.php" class="btn-primary" style="text-decoration: none; padding: 12px 20px; margin-left: 10px;">Thêm Nguyên Liệu Mới</a>
            </div>
        </div>

        <div class="search-container">
            <form action="quanly_kho.php" method="GET">
                <input type="text" name="search" placeholder="Tìm kiếm theo tên nguyên liệu..." value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit">
                    <span class="material-symbols-outlined">search</span>
                </button>
            </form>
        </div>

        <table class="tbdonhang modern">
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th>Tên Nguyên Liệu</th>
                    <th style="width: 15%;">Số Lượng Còn Lại</th>
                    <th style="width: 15%;">Tình Trạng</th>
                    <th style="width: 10%;">Đơn Vị</th>
                    <th style="width: 10%;">Thao tác</th>
                </tr>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <?php
                            $status_text = 'Ổn định';
                            $status_class = 'on-dinh';
                            if ($row['SoLuongConLai'] <= 0) {
                                $status_text = 'Hết hàng';
                                $status_class = 'het-hang';
                            } elseif ($row['NguongThap'] > 0 && $row['SoLuongConLai'] < $row['NguongThap']) {
                                $status_text = 'Sắp hết';
                                $status_class = 'sap-het';
                            }
                        ?>
                        <tr>
                            <td><?php echo $row['idNguyenLieu']; ?></td>
                            <td><strong><?php echo htmlspecialchars($row['TenNguyenLieu']); ?></strong></td>
                            <td><?php echo number_format($row['SoLuongConLai'], 2); ?></td>
                            <td>
                                <span class="status-badge <?php echo $status_class; ?>">
                                    <?php echo $status_text; ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($row['DonViTinh']); ?></td>
                            <td class="action-links">
                                <a href="chinhsua_nguyenlieu.php?id=<?php echo $row['idNguyenLieu']; ?>" title="Sửa">
                                    <span class="material-symbols-outlined icon-edit">edit</span>
                                </a>
                                <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['idNguyenLieu']; ?>)" title="Xóa">
                                    <span class="material-symbols-outlined icon-delete">delete</span>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" style="text-align: center;">Không tìm thấy nguyên liệu nào.</td></tr>
                <?php endif; ?>
        </table>
    </div>
    
    <script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: "Bạn muốn xóa vĩnh viễn nguyên liệu này? Mọi công thức liên quan cũng sẽ bị ảnh hưởng.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Vâng, xóa nó!',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '../PHP/delete_nguyenlieu.php?id=' + id;
            }
        })
    }
    </script>

    <?php
    // Hiển thị thông báo thành công
    if (isset($_SESSION['inventory_success'])) {
        echo "<script>Swal.fire({toast: true, position: 'top-end', icon: 'success', title: '" . addslashes($_SESSION['inventory_success']) . "', showConfirmButton: false, timer: 2000});</script>";
        unset($_SESSION['inventory_success']);
    }
    // Hiển thị thông báo lỗi
    if (isset($_SESSION['inventory_error'])) {
        echo "<script>Swal.fire({icon: 'error', title: 'Lỗi', text: '" . addslashes($_SESSION['inventory_error']) . "'});</script>";
        unset($_SESSION['inventory_error']);
    }
    ?>
</body>
</html>