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
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Css/css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet"href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<style>
        .details-container { display: flex; max-width: 1200px; margin: 40px auto; gap: 30px; }
        .order-info, .shipping-info { flex: 1; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .info-header { border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 20px; }
        .info-header h2 { color: #333; }
        .info-header p { color: #777; }
        .info-line { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .product-list .info-line { align-items: center; }
        .product-list img { width: 50px; height: 50px; border-radius: 4px; margin-right: 15px; }
        .product-name { flex-grow: 1; }
        .order-total { border-top: 1px solid #eee; padding-top: 15px; margin-top: 20px; font-weight: bold; font-size: 1.2em; }
</style>
</head>
<body>
    <div class="admin-container">
        <?php include_once __DIR__ . '/../PHP/menu_dashboard.php'; ?>

        <div class="admin-main-content" style="padding: 130px 50px 0 50px;">
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