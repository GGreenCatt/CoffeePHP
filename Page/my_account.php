<?php
session_start();
// Nếu chưa đăng nhập, chuyển hướng về trang chủ
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit();
}

include_once '../PHP/Connect.php';

// Lấy thông tin người dùng hiện tại
$id_tai_khoan = $_SESSION['id'];
$sql_user = "SELECT HoTen, sdt, DiaChi FROM taikhoan WHERE idTaiKhoan = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $id_tai_khoan);
$stmt_user->execute();
$user = $stmt_user->get_result()->fetch_assoc();

// Lấy 5 đơn hàng gần nhất
$sql_orders = "SELECT idDonHang, NgayDat, TongTien, TrangThai FROM donhang WHERE idTaiKhoan = ? ORDER BY NgayDat DESC LIMIT 5";
$stmt_orders = $conn->prepare($sql_orders);
$stmt_orders->bind_param("i", $id_tai_khoan);
$stmt_orders->execute();
$recent_orders = $stmt_orders->get_result();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài khoản của tôi - HIGHBUCKS</title>
    <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
    <link rel="stylesheet" href="../Css/cart.css"> <!-- Tận dụng CSS từ trang cart -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        .account-container { padding: 40px 15px; max-width: 1200px; margin: 0 auto; color: #ccc; }
        .account-layout { display: flex; gap: 30px; align-items: flex-start; }
        .account-sidebar { flex: 0 0 280px; background: rgba(37,37,36,255); border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 15px; border: 1px solid #444; }
        .account-main { flex: 1; }
        .profile-card { text-align: center; padding-bottom: 15px; border-bottom: 1px solid #444; margin-bottom: 15px; }
        .profile-card .icon { font-size: 60px; color: #c49a6c; }
        .profile-card h3 { margin: 5px 0; color: #fff; }
        .profile-card p { color: #ccc; }
        .account-nav a { display: block; padding: 12px 15px; text-decoration: none; color: #ccc; border-radius: 5px; margin-bottom: 5px; transition: background-color 0.2s; }
        .account-nav a:hover, .account-nav a.active { background-color: #333; color: #c49a6c; }
        .account-nav a .material-symbols-outlined { vertical-align: middle; margin-right: 10px; }
        .content-box { background: rgba(37,37,36,255); border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 25px; border: 1px solid #444;}
        .content-box h2 { margin-top: 0; padding-bottom: 15px; border-bottom: 1px solid #444; color: #fff; }
        .tbdonhang { width: 100%; border-collapse: collapse; }
        .tbdonhang th, .tbdonhang td { padding: 12px; text-align: left; border-bottom: 1px solid #444; }
        .tbdonhang th { color: #fff; }
        .tbdonhang a { color: #c49a6c; text-decoration: none; font-weight: bold; }
        .tbdonhang a:hover { text-decoration: underline; }
        .view-all-orders { display: block; text-align: right; margin-top: 15px; font-weight: bold; color: #c49a6c; }
    </style>
</head>
<body>
    <?php include '../PHP/Menu.php'; ?>

    <div class="banner">
        <h1>Tài khoản của tôi</h1>
        <p><a href="index.php">Trang chủ</a> / <a href="my_account.php">Tài khoản</a></p>
    </div>

    <div class="account-container">
        <div class="account-layout">
            <aside class="account-sidebar">
                <div class="profile-card">
                    <span class="material-symbols-outlined icon">account_circle</span>
                    <h3><?php echo htmlspecialchars($user['HoTen']); ?></h3>
                    <p><?php echo htmlspecialchars($user['sdt']); ?></p>
                </div>
                <nav class="account-nav">
                    <a href="my_account.php" class="active"><span class="material-symbols-outlined">dashboard</span> Tổng quan</a>
                    <a href="order_history.php"><span class="material-symbols-outlined">receipt_long</span> Lịch sử đơn hàng</a>
                    <a href="update_profile.php"><span class="material-symbols-outlined">edit</span> Cập nhật thông tin</a>
                    <a href="change_password.php"><span class="material-symbols-outlined">lock</span> Đổi mật khẩu</a>
                    <a href="../PHP/Logout.php"><span class="material-symbols-outlined">logout</span> Đăng xuất</a>
                </nav>
            </aside>

            <main class="account-main">
                <div class="content-box">
                    <h2>Đơn hàng gần đây</h2>
                    <?php if ($recent_orders->num_rows > 0): ?>
                        <table class="tbdonhang">
                            <thead>
                                <tr>
                                    <th>Mã ĐH</th>
                                    <th>Ngày Đặt</th>
                                    <th>Tổng Tiền</th>
                                    <th>Trạng Thái</th>
                                    <th>Chi Tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($order = $recent_orders->fetch_assoc()): ?>
                                <tr>
                                    <td>#<?php echo $order['idDonHang']; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($order['NgayDat'])); ?></td>
                                    <td><?php echo number_format($order['TongTien'], 0, ',', '.'); ?> VNĐ</td>
                                    <td><?php echo htmlspecialchars($order['TrangThai']); ?></td>
                                    <td><a href="order_details.php?id=<?php echo $order['idDonHang']; ?>">Xem</a></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        <a href="order_history.php" class="view-all-orders">Xem tất cả đơn hàng →</a>
                    <?php else: ?>
                        <p>Bạn chưa có đơn hàng nào.</p>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

    <?php include '../PHP/Footer.php'; ?>
</body>
</html>
