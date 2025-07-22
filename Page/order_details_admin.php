<?php
session_start();
include_once '../PHP/Connect.php';

if (!isset($_GET['id'])) {
    header('Location: orders.php');
    exit();
}
$id_don_hang = intval($_GET['id']);

// Lấy thông tin chung của đơn hàng
$stmt = $conn->prepare("SELECT * FROM donhang WHERE idDonHang = ?");
$stmt->bind_param("i", $id_don_hang);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$order) {
    die("Đơn hàng không tồn tại.");
}

// Lấy chi tiết các sản phẩm trong đơn hàng
$items = [];
$stmt_items = $conn->prepare(
    "SELECT sp.TenSanPham, ct.SoLuong, ct.DonGia 
     FROM chitietdonhang ct 
     JOIN sanpham sp ON ct.idSanPham = sp.idsanpham 
     WHERE ct.idDonHang = ?"
);
$stmt_items->bind_param("i", $id_don_hang);
$stmt_items->execute();
$result_items = $stmt_items->get_result();
while ($row = $result_items->fetch_assoc()) {
    $items[] = $row;
}
$stmt_items->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi Tiết Đơn Hàng #<?php echo $order['idDonHang']; ?></title>
    <link rel="stylesheet" href="../Css/css.css">
</head>
<body>
    <div class="admin-container">
        <?php include_once __DIR__ . '/../PHP/menu_dashboard.php'; ?>

        <div class="admin-main-content">
             <div class="main-header">
                <h2>Chi Tiết Đơn Hàng #<?php echo $order['idDonHang']; ?></h2>
                <a href="orders.php" class="btn btn-secondary">Quay Lại Danh Sách</a>
            </div>

            <div class="details-container">
                <div class="order-info">
                    <div class="info-header"><h3>Các sản phẩm đã đặt</h3></div>
                    <div class="product-list">
                        <?php foreach ($items as $item): ?>
                            <div class="info-line">
                                <span class="product-name"><?php echo htmlspecialchars($item['TenSanPham']); ?> (x<?php echo $item['SoLuong']; ?>)</span>
                                <span><?php echo number_format($item['DonGia'] * $item['SoLuong'], 0, ',', '.'); ?> VNĐ</span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="info-line order-total">
                        <span>TỔNG CỘNG</span>
                        <span><?php echo number_format($order['TongTien'], 0, ',', '.'); ?> VNĐ</span>
                    </div>
                </div>

                <div class="shipping-info">
                    <div class="info-header"><h3>Thông tin giao hàng</h3></div>
                    <div class="info-line">
                        <span>Ngày đặt:</span>
                        <strong><?php echo date('d/m/Y H:i', strtotime($order['NgayDat'])); ?></strong>
                    </div>
                    <div class="info-line">
                        <span>Người nhận:</span>
                        <strong><?php echo htmlspecialchars($order['TenNguoiNhan']); ?></strong>
                    </div>
                    <div class="info-line">
                        <span>Số điện thoại:</span>
                        <strong><?php echo htmlspecialchars($order['SoDienThoaiNhan']); ?></strong>
                    </div>
                    <div class="info-line">
                        <span>Địa chỉ:</span>
                        <strong><?php echo htmlspecialchars($order['DiaChiNhan']); ?></strong>
                    </div>
                    <div class="info-line">
                        <span>Trạng thái:</span>
                        <strong><?php echo htmlspecialchars($order['TrangThai']); ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>