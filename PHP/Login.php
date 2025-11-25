<?php
session_start(); // Bắt đầu phiên làm việc

// Bao gồm tệp kết nối cơ sở dữ liệu
include_once __DIR__ . '/Connect.php';

$message = ''; // Biến để lưu trữ thông báo

// Kiểm tra nếu biểu mẫu đã được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';

    // Ngăn chặn SQL Injection
    $phone = mysqli_real_escape_string($conn, $phone);

    // **CẬP NHẬT TRUY VẤN: Lấy thêm cột ChucVu**
    $sql = "SELECT idTaiKhoan, HoTen, sdt, MatKhau, ChucVu FROM taikhoan WHERE sdt = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Xác minh mật khẩu
        if (password_verify($password, $user['MatKhau'])) {
            // Đăng nhập thành công, thiết lập các biến session
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $user['idTaiKhoan'];
            $_SESSION['phone'] = $user['sdt'];
            $_SESSION['hoten'] = $user['HoTen'];
            $_SESSION['chucvu'] = $user['ChucVu']; // Lưu chức vụ vào session

            // **LOGIC CHUYỂN HƯỚNG THEO CHỨC VỤ**
            if ($user['ChucVu'] == 'Quản lý') {
                // Nếu là Admin, chuyển đến trang Dashboard
                header("location: ../page/Dashboard.php");
            } else {
                // Nếu là khách hàng, chuyển đến trang chủ
                header("location: ../Page/index.php");
            }
            exit; // Luôn exit sau khi chuyển hướng

        } else {
            $message = "Mật khẩu không đúng.";
        }
    } else {
        $message = "Số điện thoại chưa đăng ký.";
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en"  style="background-image:url(../Pic/about.jpg);">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="../Css/css.css">
      <!--Icon-->
    <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet"href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body style="background-image:url(../Pic/about.jpg);">
    <span style="font-size: 50px;" class="material-symbols-outlined close"><a href="../Page/index.php">close</a></span>
    <div class="resgister">
        <div class="form">
            <div class="banner"></div>
            <div class="text">
                <img src="../Pic/Favicon.png" alt="" height="100" width="120">
                <h1>Đăng nhập tài khoản</h1>
                <?php if (!empty($message)): ?>
                    <div class="message"><?php echo $message; ?></div>
                <?php endif; ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <label for="">Số điện thoại</label>
                    <input type="number" name="phone" placeholder="Số điện thoại..." maxlength="11">
                    <label for="">Mật khẩu</label>
                    <div style="position: relative;"><input id="password-field" type="password" name="password" placeholder="Mật khẩu..."><span style="color: black;" toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span></div>
                    <div style="display: flex; justify-content: center;"><button type="submit">Đăng nhập</button></div>
                </form>
                    <h4>Bạn chưa có tài khoản? <a style=" text-decoration: none;" href="Register.php"><b style="font-size: 17px;">Đăng ký</b></a></h4>
            </div>
        </div>
    </div>
<script>
$(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
</script>
</body>
</html>