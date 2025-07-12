<?php
session_start(); // Bắt đầu phiên làm việc

// Bao gồm tệp kết nối cơ sở dữ liệu
include_once '../PHP/Connect.php'; // Đảm bảo đường dẫn này chính xác

$message = ''; // Biến để lưu trữ thông báo lỗi hoặc thành công

// Kiểm tra nếu biểu mẫu đã được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';

    // Ngăn chặn SQL Injection bằng cách thoát chuỗi
    $username = mysqli_real_escape_string($conn, $phone);

    // Truy vấn cơ sở dữ liệu để lấy thông tin người dùng
    $sql = "SELECT idTaiKhoan, HoTen, sdt, MatKhau FROM taikhoan WHERE sdt = '$phone'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        // Xác minh mật khẩu đã hash
        if (password_verify($password, $row['MatKhau'])) {
            // Đăng nhập thành công, thiết lập biến phiên
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $row['idTaiKhoan'];
            $_SESSION['phone'] = $row['sdt'];
            $_SESSION['hoten'] = $row['HoTen'];

            // Chuyển hướng người dùng đến trang chính hoặc trang chào mừng
            header("location: ../index.html"); // Chuyển hướng về trang chủ
            exit;
        } else {
            $message = "Mật khẩu không đúng.";
        }
    } else {
        $message = "Số điện thoại chưa đăng ký.";
    }
}
?>
<!DOCTYPE html>
<html lang="en"  style="background-image:url(../Pic/about.jpg);">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Css/css.css">
      <!--Icon-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
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
                    <div style="position: relative;"><input type="password" name="password" placeholder="Mật khẩu..."><span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span></div>
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