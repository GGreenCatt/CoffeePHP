<?php
session_start();
include_once '../PHP/Connect.php';

if (!isset($_GET['id'])) {
    header('Location: customers.php');
    exit();
}
$id_khach_hang = intval($_GET['id']);

// Lấy thông tin tài khoản của khách hàng
$stmt_customer = $conn->prepare("SELECT HoTen, sdt FROM taikhoan WHERE idTaiKhoan = ?");
$stmt_customer->bind_param("i", $id_khach_hang);
$stmt_customer->execute();
$customer = $stmt_customer->get_result()->fetch_assoc();
$stmt_customer->close();

if (!$customer) {
    die("Khách hàng không tồn tại.");
}

// Lấy lịch sử các đơn hàng của khách hàng này
$orders = [];
$stmt_orders = $conn->prepare("SELECT idDonHang, TenNguoiNhan, SoDienThoaiNhan, DiaChiNhan, NgayDat, TongTien, TrangThai FROM donhang WHERE idTaiKhoan = ? ORDER BY NgayDat DESC");
$stmt_orders->bind_param("i", $id_khach_hang);
$stmt_orders->execute();
$result_orders = $stmt_orders->get_result();
while ($row = $result_orders->fetch_assoc()) {
    $orders[] = $row;
}
$stmt_orders->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi Tiết Khách Hàng - <?php echo htmlspecialchars($customer['HoTen']); ?></title>
    <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
    <link rel="stylesheet" href="../Css/css.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <div class="admin-container">
        <?php include_once __DIR__ . '/../PHP/menu_dashboard.php'; ?>

        <div class="dashboard">
             <div class="main-header">
                <h2>Chi Tiết Khách Hàng</h2>
                <a style="color: white;" href="customers.php" class="btn btn-secondary">Quay Lại Danh Sách</a>
            </div>

            <div class="customer-details-layout">
                <div class="customer-profile-card">
                    <div class="profile-header">
                        <span class="material-symbols-outlined profile-icon">account_circle</span>
                        <h3><?php echo htmlspecialchars($customer['HoTen']); ?></h3>
                        <p>ID Khách Hàng: #<?php echo $id_khach_hang; ?></p>
                    </div>
                    <div class="profile-body">
                        <div class="profile-info-line">
                            <span class="material-symbols-outlined">call</span>
                            <span><?php echo htmlspecialchars($customer['sdt']); ?></span>
                        </div>
                        <div class="profile-info-line">
                            <span class="material-symbols-outlined">receipt_long</span>
                            <span>Đã đặt <?php echo count($orders); ?> đơn hàng</span>
                        </div>
                    </div>
                </div>

                <div class="customer-order-history">
                     <h3>Lịch sử đơn hàng</h3>
                     <?php if (!empty($orders)): ?>
                        <table class="tbdonhang">
                            <thead>
                                <tr>
                                    <th>Mã Đơn</th>
                                    <th>Ngày Đặt</th>
                                    <th>Thông Tin Giao Hàng</th>
                                    <th>Tổng Tiền</th>
                                    <th>Trạng Thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td>#<?php echo $order['idDonHang']; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($order['NgayDat'])); ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($order['TenNguoiNhan']); ?></strong><br>
                                            <small style="color: black;"><?php echo htmlspecialchars($order['SoDienThoaiNhan']); ?></small>
                                        </td>
                                        <td><?php echo number_format($order['TongTien'], 0, ',', '.'); ?> VNĐ</td>
                                        <td><?php echo htmlspecialchars($order['TrangThai']); ?></td>
                                        <td class="action-links">
                                            <a href="order_details.php?id=<?php echo $order['idDonHang']; ?>" title="Xem chi tiết đơn hàng">
                                                <span style="color: white;" class="material-symbols-outlined">visibility</span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p style="text-align:center; padding: 20px;">Khách hàng này chưa có đơn hàng nào.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>