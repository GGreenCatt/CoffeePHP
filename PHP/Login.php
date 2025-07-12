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
                <form action="">
                    <label for="">Số điện thoại</label>
                    <input type="number" placeholder="Số điện thoại..." maxlength="11">
                    <label for="">Mật khẩu</label>
                    <input type="password"  placeholder="Mật khẩu..."><span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                </form>
                    <button>Đăng nhập</button>
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