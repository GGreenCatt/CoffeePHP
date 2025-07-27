<?php
// Bắt đầu phiên làm việc để truy cập giỏ hàng và thông tin người dùng
session_start();

// Lấy giỏ hàng từ session. Nếu giỏ hàng trống, chuyển hướng về trang giỏ hàng.
$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    header('Location: cart.php');
    exit();
}

// Khởi tạo các biến tính toán
$total_quantity = 0;
$tam_tinh = 0;
$phi_ship = 30000; // Phí ship cố định
$giam_gia = 0;     // Chưa có giảm giá

// Tính toán tổng tiền và số lượng
foreach ($cart as $item) {
    $total_quantity += $item['soluong'];
    $tam_tinh += $item['gia'] * $item['soluong'];
}
$tong_cong = $tam_tinh + $phi_ship - $giam_gia;
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet"href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thanh Toán - HIGHBUCKS</title>
  <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
  <link rel="stylesheet" href="../Css/cart.css">
</head>

<body>
    <?php include '../PHP/Menu.php' ?>

    <div class="banner">
    <h1>Thanh toán</h1>
    <p>
      <a href="index.php">Trang chủ</a>
      <a href="checkout.php" style="color: gray;">Thanh toán</a>
    </p>
  </div>

    <div class="checkout">
    <div class="row">
      <div class="col-75">
        <div class="container">
                    <form action="../PHP/process_checkout.php" method="POST">

            <div class="row">
              <div class="col-50">
                <h3>Thông tin giao hàng</h3>
                <?php 
                  // Tự động điền thông tin nếu người dùng đã đăng nhập
                  $ho_ten = $_SESSION['hoten'] ?? '';
                  $sdt = $_SESSION['phone'] ?? '';
                ?>
                <label for="hoten"><i class="fa fa-user"></i> Họ tên người nhận</label>
                <input type="text" id="hoten" name="hoten" value="<?php echo htmlspecialchars($ho_ten); ?>" required>
                
                <label for="sdt"><i class="fa fa-phone"></i> Số điện thoại</label>
                <input type="text" id="sdt" name="sdt" value="<?php echo htmlspecialchars($sdt); ?>" required>
                
                <label for="diachi"><i class="fa fa-address-card-o"></i> Địa chỉ nhận hàng</label>
                <input type="text" id="diachi" name="diachi" placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố" required>
              </div>

              <div class="col-50">
                <h3>Phương thức thanh toán</h3>
                <div class="payment-method">
                    <input type="radio" id="cod" name="payment_method" value="cod" checked>
                    <label for="cod">Thanh toán khi nhận hàng (COD)</label>
                    <p>Bạn sẽ thanh toán bằng tiền mặt cho nhân viên giao hàng khi nhận được sản phẩm.</p>
                </div>
              </div>

            </div>
            <input type="submit" value="Hoàn tất đặt hàng" class="btn">
          </form>
        </div>
      </div>
      
            <div class="col-25">
        <div class="container">
                    <h4>Đơn hàng của bạn 
            <span class="price" style="color:black">
              <i class="fa fa-shopping-cart"></i>
              <b><?php echo $total_quantity; ?></b>
            </span>
          </h4>
          
          <?php foreach ($cart as $item): ?>
            <p>
              <span><?php echo htmlspecialchars($item['ten']); ?> <small>(x<?php echo $item['soluong']; ?>)</small></span> 
              <span class="price"><?php echo number_format($item['gia'] * $item['soluong'], 0, ',', '.'); ?> VNĐ</span>
            </p>
          <?php endforeach; ?>
          <hr>
          
          <p>Tạm tính <span class="price"><?php echo number_format($tam_tinh, 0, ',', '.'); ?> VNĐ</span></p>
          <p>Phí vận chuyển <span class="price"><?php echo number_format($phi_ship, 0, ',', '.'); ?> VNĐ</span></p>
          <hr>
          <p>Tổng cộng <span class="price" style="color:black"><b><?php echo number_format($tong_cong, 0, ',', '.'); ?> VNĐ</b></span></p>
        </div>
      </div>
    </div>
  </div>

    <?php include '../PHP/Footer.php'; ?>

  <script>
    /*menu scroll*/
    window.onscroll = function () { scrollFunction() };
    function scrollFunction() {
      if (document.body.scrollTop > 150 || document.documentElement.scrollTop > 150) {
        document.getElementById("navbar").style.top = "0";
      } else {
        document.getElementById("navbar").style.top = "-100px";
      }
    }
  </script>
</body>
</html>