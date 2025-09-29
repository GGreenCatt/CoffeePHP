<?php
session_start();
include_once __DIR__ . '/../PHP/Connect.php';

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
    "SELECT sp.TenSanPham, sp.idSanpham, ct.SoLuong, ct.DonGia 
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet"href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .details-container { display: flex; max-width: 1200px; margin: 40px auto; gap: 30px; }
        .order-info, .shipping-info { flex: 1; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .info-header { border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 20px; }
        .info-header h2 { color: #333; }
        .info-header p { color: #777; }
        .info-line { display: flex; justify-content: space-between; margin-bottom: 10px; align-items: center;}
        .product-list .info-line { align-items: center; }
        .product-list img { width: 50px; height: 50px; border-radius: 4px; margin-right: 15px; object-fit: cover; }
        .product-name { flex-grow: 1; }
        .order-total { border-top: 1px solid #eee; padding-top: 15px; margin-top: 20px; font-weight: bold; font-size: 1.2em; }
        .status-form { margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;display: flex;flex-direction: column; align-items: center; }
        .status-form select { width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc; margin-bottom: 15px; }
        .status-form button { width: 30%;padding: 10px; background-color: goldenrod;color: white;font-weight: bold;font-size: 18px; border: none; border-radius: 15px; }
    </style>
</head>
<body>
    <?php include '../PHP/menu_dashboard.php'; ?>
    <div class="main-header" style="padding:130px 50px 0 50px">
        <h2 style="padding-bottom: 15px;">Chi Tiết Đơn Hàng #<?php echo $order['idDonHang']; ?></h2>
        <a href="orders.php" class="btn btn-secondary">Quay Lại Danh Sách</a>
    </div>

    <div class="details-container">
        <div class="order-info">
            <div class="info-header">
                <h2>Các sản phẩm đã đặt</h2>
            </div>
            <div class="product-list">
                <?php foreach ($items as $item): ?>
                    <div class="info-line">
                        <img src="../Pic/<?php echo htmlspecialchars($item['idSanpham']); ?>.jpg" alt="">
                        <span class="product-name"><?php echo htmlspecialchars($item['TenSanPham']); ?> (x<?php echo $item['SoLuong']; ?>)</span>
                        <span><?php echo number_format($item['DonGia'] * $item['SoLuong'], 0, ',', '.'); ?> VNĐ</span>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="info-line order-total"><!--Thêm phí ship mặc định là 30.000VN-->
                <span>Phí ship:</span>
                <span>30.000 VNĐ</span>
            </div>
            <div class="info-line order-total">
                <span>TỔNG CỘNG</span>
                <span><?php echo number_format($order['TongTien'], 0, ',', '.'); ?> VNĐ</span>
            </div>
        </div>

        <div class="shipping-info">
            <div class="info-header">
                <h2 style="margin-bottom: 10px;">Thông tin giao hàng</h2>
                <p>Ngày đặt: <?php echo date('d/m/Y H:i', strtotime($order['NgayDat'])); ?></p>
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
            
            <form class="status-form" action="../PHP/process_update_order_status.php" method="POST">
                <input type="hidden" name="idDonHang" value="<?php echo $order['idDonHang']; ?>">
                <div class="form-group">
                    <label for="TrangThai"><strong>Trạng thái đơn hàng:</strong></label>
                    <select name="TrangThai" id="TrangThai">
                        <option value="Đang xử lý" <?php if ($order['TrangThai'] == 'Đang xử lý') echo 'selected'; ?>>Đang xử lý</option>
                        <option value="Đang giao" <?php if ($order['TrangThai'] == 'Đang giao') echo 'selected'; ?>>Đang giao</option>
                        <option value="Đã hoàn thành" <?php if ($order['TrangThai'] == 'Đã hoàn thành') echo 'selected'; ?>>Đã hoàn thành</option>
                        <option value="Đã hủy" <?php if ($order['TrangThai'] == 'Đã hủy') echo 'selected'; ?>>Đã hủy</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
            </div>
    </div>

    <?php
    // Hiển thị thông báo nếu có
    if (isset($_SESSION['update_status_success'])) {
        echo "<script>Swal.fire({toast: true, position: 'top-end', icon: 'success', title: '" . addslashes($_SESSION['update_status_success']) . "', showConfirmButton: false, timer: 2000});</script>";
        unset($_SESSION['update_status_success']);
    }
    ?>
</body>
</html>