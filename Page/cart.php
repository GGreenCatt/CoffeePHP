<?php
// Bắt đầu phiên làm việc để truy cập giỏ hàng
session_start();

// Lấy giỏ hàng từ session, hoặc tạo mảng rỗng nếu chưa có
$cart = $_SESSION['cart'] ?? [];

// Khởi tạo các biến tính toán
$tam_tinh = 0;
$phi_ship = 30000; // Phí ship cố định, bạn có thể thay đổi
$giam_gia = 0;     // Tạm thời chưa có giảm giá, bạn có thể phát triển thêm

// Tính tổng tiền các sản phẩm trong giỏ
if (!empty($cart)) {
    foreach ($cart as $item) {
        $tam_tinh += $item['gia'] * $item['soluong'];
    }
}
// Tính tổng tiền cuối cùng
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
 <link rel="stylesheet"
  href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Giỏ Hàng - HIGHBUCKS</title>
 <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
 <link rel="stylesheet" href="../Css/cart.css">
</head>

<body>
 <?php include '../PHP/Menu.php' ?>

 <div class="banner">
 <h1>Giỏ hàng</h1>
 <p>
 <a href="index.php">Trang chủ</a>
 <a href="cart.php" style="color: gray;">Giỏ hàng</a>
 </p>
 </div>

 <div class="cart">
    <?php if (!empty($cart)): ?>
    <form action="../PHP/update_cart.php" method="POST">
        <div class="cart_list">
            <table>
                <tr>
                    <th style="width: 9%;">Xóa</th>
                    <th style="width: 19%;">Ảnh</th>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th style="width: 15%;">Thành tiền</th>
                </tr>
                
                <?php foreach ($cart as $id => $item): ?>
                <tr>
                    <td>
                        <a style="text-decoration: none;" href="../PHP/remove_from_cart.php?id=<?php echo $id; ?>" class="remove-icon" title="Xóa sản phẩm">X</a>
                    </td>
                    <td>
                        <img src="../Pic/<?php echo htmlspecialchars($item['id']); ?>.jpg" alt="<?php echo htmlspecialchars($item['ten']); ?>" class="cart-item-image">
                    </td>
                    <td><?php echo htmlspecialchars($item['ten']); ?></td>
                    <td><?php echo number_format($item['gia'], 0, ',', '.'); ?> VNĐ</td>
                    <td>
                        <input type="number" name="soluong[<?php echo $id; ?>]" value="<?php echo $item['soluong']; ?>" min="1" class="quantity-input">
                    </td>
                    <td><?php echo number_format($item['gia'] * $item['soluong'], 0, ',', '.'); ?> VNĐ</td>
                </tr>
                <?php endforeach; ?>
                </table>
        </div>

        <div class="cart_total">
            <div class="box">
                <h2 style="color: white;">Tổng tiền</h2>
                <table>
                    <tr>
                        <td>Tạm tính:</td>
                        <td><?php echo number_format($tam_tinh, 0, ',', '.'); ?> VNĐ</td>
                    </tr>
                    <tr>
                        <td>Phí ship:</td>
                        <td><?php echo number_format($phi_ship, 0, ',', '.'); ?> VNĐ</td>
                    </tr>
                    <tr>
                        <td>Giảm giá:</td>
                        <td><?php echo number_format($giam_gia, 0, ',', '.'); ?> VNĐ</td>
                    </tr>
                    <tr>
                        <td style="border-top: 1px solid gray;">Tổng cộng:</td>
                        <td style="border-top: 1px solid gray; color: goldenrod;"><?php echo number_format($tong_cong, 0, ',', '.'); ?> VNĐ</td>
                    </tr>
                </table>
            </div>
            
            <button><a  style="text-decoration: none; color: black;"href="checkout.php" class="checkout-btn">Tiến hành thanh toán</a></button>
        </div>
    </form>
    <?php else: ?>
        <div class="empty-cart-message">
            <p>Giỏ hàng của bạn đang trống.</p>
            <a href="coffee.php">Quay lại cửa hàng</a>
        </div>
    <?php endif; ?>
 </div>

  <!--Footer-->
  <?php include_once("../PHP/Footer.php") ?>
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