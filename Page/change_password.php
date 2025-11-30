<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit();
}

include_once '../PHP/Connect.php';

$id_tai_khoan = $_SESSION['id'];
$message = '';
$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Lấy mật khẩu đã hash từ CSDL
    $sql = "SELECT MatKhau, HoTen, sdt FROM taikhoan WHERE idTaiKhoan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_tai_khoan);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // 1. Xác thực mật khẩu hiện tại
    if (password_verify($current_password, $user['MatKhau'])) {
        // 2. Kiểm tra mật khẩu mới có khớp không
        if ($new_password === $confirm_password) {
            // 3. Hash và cập nhật mật khẩu mới
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE taikhoan SET MatKhau = ? WHERE idTaiKhoan = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("si", $hashed_password, $id_tai_khoan);
            
            if ($update_stmt->execute()) {
                $message = "Đổi mật khẩu thành công!";
                $error = false;
            } else {
                $message = "Có lỗi xảy ra, không thể cập nhật mật khẩu.";
                $error = true;
            }
        } else {
            $message = "Mật khẩu mới không khớp. Vui lòng nhập lại.";
            $error = true;
        }
    } else {
        $message = "Mật khẩu hiện tại không đúng.";
        $error = true;
    }
} else {
    // Lấy thông tin người dùng để hiển thị ở sidebar
    $sql = "SELECT HoTen, sdt FROM taikhoan WHERE idTaiKhoan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_tai_khoan);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi mật khẩu - HIGHBUCKS</title>
    <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
    <link rel="stylesheet" href="../Css/cart.css">
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
        .content-box { background: rgba(37,37,36,255); border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 25px; border: 1px solid #444; }
        .content-box h2 { margin-top: 0; padding-bottom: 15px; border-bottom: 1px solid #444; color: #fff; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: bold; color: #c49a6c; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #555; border-radius: 5px; background-color: #333; color: #fff; }
        .btn-submit { background-color: #c49a6c; color: white; padding: 12px 25px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; transition: background-color 0.2s; }
        .btn-submit:hover { background-color: #a07d56; }
        .message { padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        .message.success { background-color: #2b442e; color: #a7d7b0; border: 1px solid #38573c; }
        .message.error { background-color: #4d2a2d; color: #e8a0a6; border: 1px solid #6e3b40; }
    </style>
</head>
<body>
    <?php include '../PHP/Menu.php'; ?>

    <div class="banner">
        <h1>Đổi mật khẩu</h1>
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
                    <a href="update_profile.php"><span class="material-symbols-outlined">edit</span> Cập nhật thông tin</a>
                    <a href="change_password.php" class="active"><span class="material-symbols-outlined">lock</span> Đổi mật khẩu</a>
                    <a href="../PHP/Logout.php"><span class="material-symbols-outlined">logout</span> Đăng xuất</a>
                </nav>
            </aside>

            <main class="account-main">
                <div class="content-box">
                    <h2>Thay đổi mật khẩu</h2>
                    <?php if ($message): ?>
                        <div class="message <?php echo $error ? 'error' : 'success'; ?>"><?php echo $message; ?></div>
                    <?php endif; ?>
                    <form action="change_password.php" method="POST">
                        <div class="form-group">
                            <label for="current_password">Mật khẩu hiện tại</label>
                            <input type="password" id="current_password" name="current_password" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password">Mật khẩu mới</label>
                            <input type="password" id="new_password" name="new_password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Xác nhận mật khẩu mới</label>
                            <input type="password" id="confirm_password" name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn-submit">Đổi mật khẩu</button>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <?php include '../PHP/Footer.php'; ?>
</body>
</html>
