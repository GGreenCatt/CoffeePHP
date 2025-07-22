<?php
session_start();
include_once '../PHP/Connect.php';

// Xử lý tìm kiếm
$search_query = "";
$sql = "SELECT idDonHang, TenNguoiNhan, NgayDat, TongTien, TrangThai FROM donhang";

// Nếu có từ khóa tìm kiếm được gửi lên
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = $_GET['search'];
    // Thêm điều kiện WHERE để tìm kiếm theo Tên hoặc SĐT người nhận
    $sql .= " WHERE TenNguoiNhan LIKE ? OR SoDienThoaiNhan LIKE ?";
}

$sql .= " ORDER BY NgayDat DESC";

// Chuẩn bị và thực thi câu lệnh
$stmt = $conn->prepare($sql);

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = "%" . $search_query . "%";
    // Gán 2 lần cho 2 dấu ? (TenNguoiNhan và SoDienThoaiNhan)
    $stmt->bind_param("ss", $search_term, $search_term);
}

$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Đơn Hàng</title>
    <link rel="stylesheet" href="../Css/css.css">
    <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <div class="admin-container">
        <?php include_once __DIR__ . '/../PHP/menu_dashboard.php'; ?>

        <div class="dashboard">
            <div class="main-header">
                <h2>Quản Lý Đơn Hàng</h2>
            </div>
             <div class="search-container">
                <form action="orders.php" method="GET">
                    <input type="text" name="search" placeholder="Tìm theo tên hoặc SĐT người nhận..." value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit">
                        <span class="material-symbols-outlined">search</span>
                    </button>
                </form>
            </div>

            <table class="tbdonhang">
                    <tr>
                        <th>Mã Đơn</th>
                        <th>Tên Người Nhận</th>
                        <th>Ngày Đặt</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái</th>
                        <th>Thao tác</th>
                    </tr>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td>#<?php echo $row['idDonHang']; ?></td>
                                <td><?php echo htmlspecialchars($row['TenNguoiNhan']); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($row['NgayDat'])); ?></td>
                                <td><?php echo number_format($row['TongTien'], 0, ',', '.'); ?> VNĐ</td>
                                <td><?php echo htmlspecialchars($row['TrangThai']); ?></td>
                                <td class="action-links">
                                    <a href="order_details_admin.php?id=<?php echo $row['idDonHang']; ?>" title="Xem chi tiết">
                                        <span class="material-symbols-outlined">visibility</span>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">Chưa có đơn hàng nào.</td>
                        </tr>
                    <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>
<?php mysqli_close($conn); ?>