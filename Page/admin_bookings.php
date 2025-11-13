<?php
session_start();
include_once '../PHP/Connect.php';

// Check if user is admin
if (!isset($_SESSION['id']) || $_SESSION['chucvu'] !== 'Quản lý') {
    header("Location: ../index.php");
    exit();
}

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['TrangThai'])) {
    $id = (int)$_POST['id'];
    $trangThai = $_POST['TrangThai'];
    
    $update_sql = "UPDATE datban SET TrangThai = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $trangThai, $id);
    $update_stmt->execute();
    
    // Redirect to avoid form resubmission
    header("Location: admin_bookings.php");
    exit();
}


$sql = "SELECT id, HoTen, sdt, SoNguoi, NgayDat, GioDat, GhiChu, TrangThai, ThoiGianTao FROM datban ORDER BY ThoiGianTao DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Đặt Bàn</title>
    <link rel="stylesheet" href="../Css/css.css">
    <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <div class="admin-container">
        <?php include_once __DIR__ . '/../PHP/menu_dashboard.php'; ?>

        <div class="dashboard">
            <div class="main-header">
                <h2>Quản Lý Đặt Bàn</h2>
            </div>

            <table class="tbdonhang">
                    <tr>
                        <th>ID</th>
                        <th>Tên Khách Hàng</th>
                        <th>Số Điện Thoại</th>
                        <th>Số Người</th>
                        <th>Ngày Đặt</th>
                        <th>Giờ Đặt</th>
                        <th>Ghi Chú</th>
                        <th>Trạng Thái</th>
                        <th>Thao tác</th>
                    </tr>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td>#<?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['HoTen']); ?></td>
                                <td><?php echo htmlspecialchars($row['sdt']); ?></td>
                                <td><?php echo $row['SoNguoi']; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($row['NgayDat'])); ?></td>
                                <td><?php echo date('H:i', strtotime($row['GioDat'])); ?></td>
                                <td><?php echo htmlspecialchars($row['GhiChu']); ?></td>
                                <td>
                                    <form action="admin_bookings.php" method="POST" class="status-form">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <select name="TrangThai" onchange="this.form.submit()">
                                            <option value="Đợi xác nhận" <?php echo $row['TrangThai'] == 'Đợi xác nhận' ? 'selected' : ''; ?>>Đợi xác nhận</option>
                                            <option value="Đã xác nhận" <?php echo $row['TrangThai'] == 'Đã xác nhận' ? 'selected' : ''; ?>>Đã xác nhận</option>
                                            <option value="Đã hủy" <?php echo $row['TrangThai'] == 'Đã hủy' ? 'selected' : ''; ?>>Đã hủy</option>
                                             <option value="Đã hoàn thành" <?php echo $row['TrangThai'] == 'Đã hoàn thành' ? 'selected' : ''; ?>>Đã hoàn thành</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="action-links">
                                    <a href="tel:<?php echo htmlspecialchars($row['sdt']); ?>" title="Gọi điện">
                                        <span class="material-symbols-outlined">call</span>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" style="text-align: center;">Chưa có lượt đặt bàn nào.</td>
                        </tr>
                    <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>
