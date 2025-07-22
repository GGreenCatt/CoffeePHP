<?php
session_start();
include_once __DIR__ . '/../PHP/Connect.php';
$orders = []; // Khởi tạo mảng chứa đơn hàng
$error_message = '';
$is_user_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;

// Nếu người dùng đã đăng nhập
if ($is_user_logged_in) {
    $id_tai_khoan = $_SESSION['id'];
    $stmt = $conn->prepare("SELECT idDonHang, NgayDat, TongTien, TrangThai, TenNguoiNhan FROM donhang WHERE idTaiKhoan = ? ORDER BY NgayDat DESC");
    $stmt->bind_param("i", $id_tai_khoan);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    $stmt->close();
}
// Nếu người dùng là khách và gửi form tra cứu bằng SĐT
elseif (isset($_POST['sdt_lookup'])) {
    $sdt = $_POST['sdt_lookup'];
    if (!empty($sdt)) {
        // Truy vấn các đơn hàng của khách (idTaiKhoan IS NULL) theo SĐT
        $stmt = $conn->prepare("SELECT idDonHang, NgayDat, TongTien, TrangThai, TenNguoiNhan FROM donhang WHERE SoDienThoaiNhan = ? AND idTaiKhoan IS NULL ORDER BY NgayDat DESC");
        $stmt->bind_param("s", $sdt);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        if (empty($orders)) {
            $error_message = "Không tìm thấy đơn hàng nào với số điện thoại này hoặc đơn hàng thuộc về một tài khoản đã đăng ký.";
        }
        $stmt->close();
    } else {
        $error_message = "Vui lòng nhập số điện thoại để tra cứu.";
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch Sử Đặt Hàng</title>
    <link rel="stylesheet" href="../Css/css.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet"href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" /> 
    <style>
        .history-container { max-width: 1200px; margin: 40px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .history-container h1 { text-align: center; color: #c49a6c; margin-bottom: 30px; }
        .lookup-form { text-align: center; margin-bottom: 30px; padding: 20px; background: #f9f9f9; border-radius: 8px; }
        .lookup-form input[type="text"] { padding: 10px; width: 300px; border: 1px solid #ddd; border-radius: 4px; }
        .lookup-form button { padding: 10px 20px; background-color: #c49a6c; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .order-table { width: 100%; border-collapse: collapse; }
        .order-table th, .order-table td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        .order-table th { background-color: #f8f8f8; }
        .order-table .view-details { color: #c49a6c; text-decoration: none; font-weight: bold; }
        .no-orders { text-align: center; padding: 40px; color: #777; }
        .error-msg { text-align: center; color: red; margin-bottom: 20px; }
    </style>
</head>
<body>
    <?php include '../PHP/Menu.php'; ?>

    <div class="banner">
        <h1>Lịch Sử Đặt Hàng</h1>
    </div>

    <div class="history-container">
        <?php if (!$is_user_logged_in): // Hiển thị form tra cứu nếu là khách ?>
            <div class="lookup-form">
                <h2>Tra cứu đơn hàng của bạn</h2>
                <p>Nhập số điện thoại bạn đã dùng để đặt hàng (dành cho khách không đăng nhập).</p>
                <form action="order_history.php" method="POST">
                    <input type="text" name="sdt_lookup" placeholder="Nhập số điện thoại..." value="<?php echo isset($_POST['sdt_lookup']) ? htmlspecialchars($_POST['sdt_lookup']) : ''; ?>">
                    <button type="submit">Tra Cứu</button>
                </form>
            </div>
        <?php endif; ?>

        <?php if (!empty($error_message)): ?>
            <p class="error-msg"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <?php if (!empty($orders)): ?>
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Mã Đơn</th>
                        <th>Người Nhận</th>
                        <th>Ngày Đặt</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái</th>
                        <th>Chi Tiết</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?php echo $order['idDonHang']; ?></td>
                            <td><?php echo htmlspecialchars($order['TenNguoiNhan']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($order['NgayDat'])); ?></td>
                            <td><?php echo number_format($order['TongTien'], 0, ',', '.'); ?> VNĐ</td>
                            <td><?php echo htmlspecialchars($order['TrangThai']); ?></td>
                            <td><a href="order_details.php?id=<?php echo $order['idDonHang']; ?>" class="view-details">Xem</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif(isset($_POST['sdt_lookup']) || $is_user_logged_in): ?>
            <p class="no-orders">Bạn chưa có đơn hàng nào.</p>
        <?php endif; ?>
    </div>

    <?php include '../PHP/Footer.php'; ?>
</body>
</html>