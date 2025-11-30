<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit();
}

include_once '../PHP/Connect.php';

$id_tai_khoan = $_SESSION['id'];
$message = '';

// Xử lý khi form được gửi đi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ho_ten = $_POST['hoten'] ?? '';
    $dia_chi = $_POST['diachi'] ?? '';

    $sql = "UPDATE taikhoan SET HoTen = ?, DiaChi = ? WHERE idTaiKhoan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $ho_ten, $dia_chi, $id_tai_khoan);
    
    if ($stmt->execute()) {
        // Cập nhật lại session
        $_SESSION['hoten'] = $ho_ten;
        $message = "Cập nhật thông tin thành công!";
    } else {
        $message = "Có lỗi xảy ra. Vui lòng thử lại.";
    }
    $stmt->close();
}

// Lấy thông tin mới nhất của người dùng để hiển thị
$sql_user = "SELECT HoTen, sdt, DiaChi FROM taikhoan WHERE idTaiKhoan = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $id_tai_khoan);
$stmt_user->execute();
$user = $stmt_user->get_result()->fetch_assoc();
$stmt_user->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật thông tin - HIGHBUCKS</title>
    <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
    <link rel="stylesheet" href="../Css/cart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- Sử dụng lại style từ trang my_account.php -->
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
        .content-box { background: rgba(37,37,36,255); border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 25px; border: 1px solid #444; }
        .content-box h2 { margin-top: 0; padding-bottom: 15px; border-bottom: 1px solid #444; color: #fff; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: bold; color: #c49a6c; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #555; border-radius: 5px; background-color: #333; color: #fff; }
        .form-group input[readonly] { background-color: #222; cursor: not-allowed; }
        .btn-submit { background-color: #c49a6c; color: white; padding: 12px 25px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; transition: background-color 0.2s; }
        .btn-submit:hover { background-color: #a07d56; }
        .message { padding: 10px; background-color: #2b442e; color: #a7d7b0; border: 1px solid #38573c; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <?php include '../PHP/Menu.php'; ?>

    <div class="banner">
        <h1>Cập nhật thông tin</h1>
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
                    <a href="my_account.php"><span class="material-symbols-outlined">dashboard</span> Tổng quan</a>
                    <a href="update_profile.php" class="active"><span class="material-symbols-outlined">edit</span> Cập nhật thông tin</a>
                    <a href="change_password.php"><span class="material-symbols-outlined">lock</span> Đổi mật khẩu</a>
                    <a href="../PHP/Logout.php"><span class="material-symbols-outlined">logout</span> Đăng xuất</a>
                </nav>
            </aside>

            <main class="account-main">
                <div class="content-box">
                    <h2>Thông tin cá nhân</h2>
                    <?php if ($message): ?>
                        <div class="message"><?php echo $message; ?></div>
                    <?php endif; ?>
                    <form action="update_profile.php" method="POST">
                        <div class="form-group">
                            <label for="sdt">Số điện thoại</label>
                            <input type="text" id="sdt" name="sdt" value="<?php echo htmlspecialchars($user['sdt']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="hoten">Họ và tên</label>
                            <input type="text" id="hoten" name="hoten" value="<?php echo htmlspecialchars($user['HoTen']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="diachi">Địa chỉ giao hàng mặc định</label>
                            <input type="text" id="diachi" name="diachi" value="<?php echo htmlspecialchars($user['DiaChi'] ?? ''); ?>" placeholder="Vd: 123 Đường ABC, Phường XYZ, Quận 1, TP.HCM">
                        </div>
                        <button type="submit" class="btn-submit">Lưu thay đổi</button>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <?php include '../PHP/Footer.php'; ?>
</body>
</html>
