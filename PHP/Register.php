<?php
session_start(); // Bắt đầu phiên làm việc (tùy chọn, nhưng tốt cho tính nhất quán)

// Bao gồm tệp kết nối cơ sở dữ liệu
include_once '../PHP/Connect.php'; // Đảm bảo đường dẫn này chính xác

$message = ''; // Biến để lưu trữ thông báo lỗi hoặc thành công

// Kiểm tra nếu biểu mẫu đã được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['hoten'] ?? '';
    $phone = $_POST['phone'] ??'';
    $password = $_POST['password'] ?? '';
    

    // Kiểm tra xem các trường có trống không
    if (empty($username) || empty($password) || empty($phone)) {
        $message = "Vui lòng điền đầy đủ tất cả các trường.";
    } else {
        // Ngăn chặn SQL Injection bằng cách thoát chuỗi
        $username = mysqli_real_escape_string($conn, $username);

        // Kiểm tra xem tên người dùng đã tồn tại chưa
        $check_sql = "SELECT idTaiKhoan FROM TaiKhoan WHERE sdt = '$phone'";
        $check_result = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            $message = "Tên người dùng đã tồn tại. Vui lòng chọn tên khác.";
        } else {
            // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Chèn người dùng mới vào cơ sở dữ liệu
            $sql = "INSERT INTO TaiKhoan (HoTen, sdt, Matkhau) VALUES ('$username', '$phone', '$hashed_password')";

            if (mysqli_query($conn, $sql)) {
                $message = "Đăng ký thành công! Bạn có thể <a href='login.php'>đăng nhập</a> ngay bây giờ.";
            } else {
                $message = "Lỗi khi đăng ký: " . mysqli_error($conn);
            }
        }
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
                <h1>Đăng ký tài khoản</h1>
                <?php if (!empty($message)): ?>
                <div class="message <?php echo (strpos($message, 'Lỗi') !== false || strpos($message, 'không khớp') !== false || strpos($message, 'tồn tại') !== false) ? 'error' : ''; ?>">
                    <?php echo $message; ?>
                </div>
                <?php endif; ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <label for="">Họ và tên</label>
                    <input type="text" name="hoten" placeholder="Họ và tên...">
                    <label for="">Số điện thoại</label>
                    <input type="number" name="phone" placeholder="Số điện thoại..." maxlength="11">
                    <label for="">Mật khẩu</label>
                    <div style="position: relative;"><input type="password" name="password" placeholder="Mật khẩu..."><span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span></div>
                    <div style="display: flex; justify-items: center;"><button type="submit">Đăng ký</button></div>
                </form>
                    
                    <h4>Bạn đã có tài khoản? <a style=" text-decoration: none;" href="Login.php"><b style="font-size: 17px;">Đăng nhập</b></a></h4>
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