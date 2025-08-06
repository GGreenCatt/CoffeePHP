<?php
// Bắt đầu session nếu chưa có
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Tính tổng số lượng sản phẩm trong giỏ hàng
$cart_item_count = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cart_item_count += $item['soluong'];
    }
}

// Lấy tên file của trang hiện tại
$current_page = basename($_SERVER['PHP_SELF']);

// Nhóm các trang liên quan để làm nổi bật menu
$storage_pages = ['storage.php', 'add_product.php', 'edit_product.php'];
$order_pages = ['orders.php', 'order_details_admin.php'];
$customer_pages = ['customers.php', 'customer_details.php'];

?>
  <style> 
  .dropdown-content {
  display: none;
  position: absolute;
  background-color: black; /* Nền trắng sạch sẽ */
  min-width: 230px; /* Tăng độ rộng một chút */
  box-shadow: 0px 10px 25px 0px rgba(0, 0, 0, 0.1); /* Hiệu ứng đổ bóng mềm mại hơn */
  z-index: 1;
  border-radius: 8px; /* Bo tròn các góc */
  border: 1px solid #f0f0f0; /* Đường viền rất nhẹ */
  overflow: hidden; /* Đảm bảo nội dung tuân thủ bo tròn góc */
}

/* Phần hiển thị thông tin người dùng */
.dropdown-user-info {
  padding: 16px 20px;
  color: goldenrod;
  text-align: left; /* Căn lề trái cho dễ đọc tên và sđt */
  border-bottom: 1px solid #f0f0f0; /* Đường kẻ ngăn cách */
  line-height: 1.4;
}

.dropdown-user-info strong {
    font-size: 16px;
    color: goldenrod;
}

.dropdown-user-info small {
    font-size: 14px;
    color: goldenrod;
}

/* Các liên kết trong dropdown */
.dropdown-content a {
  color: white; /* Màu chữ tối hơn */
  padding: 14px 20px;
  text-decoration: none;
  display: block;
  text-align: left; /* Căn lề trái cho đồng bộ */
  font-size: 15px;
  transition: all 0.2s ease; /* Hiệu ứng chuyển động mượt mà */
}

/* Thay đổi màu khi di chuột vào liên kết */
.dropdown-content a:hover {
  background-color: #f7f7f7; /* Màu nền khi hover */
  color: #c49a6c; /* Màu chữ thương hiệu khi hover */
  padding-left: 25px; /* Di chuyển chữ sang phải một chút khi hover */
}

/* Hiển thị dropdown khi hover vào mục menu */
.dropdown:hover .dropdown-content {
  display: block;
}
  </style>
  <div class="navbar">
    <div class="brand">
      <a href="../Page/dashboard.php" class="brand-link">HIGHBUCKS<br>
        <small>COFFEE</small>
      </a>
    </div>

    <div class="navbar-m1">
      <a class="nav-link <?php if ($current_page == 'dashboard.php') echo 'activemenu'; ?>" href="../Page/dashboard.php">Thống kê</a>
      <a class="nav-link <?php if (in_array($current_page, $storage_pages)) echo 'activemenu'; ?>" href="../Page/storage.php">Kho</a>
      <a class="nav-link <?php if (in_array($current_page, $order_pages)) echo 'activemenu'; ?>" href="../Page/orders.php">Đơn đặt</a>
      <a class="nav-link <?php if (in_array($current_page, $customer_pages)) echo 'activemenu'; ?>" href="../Page/customers.php">Khách hàng</a>
      <a class="nav-link <?php if (in_array($current_page, ['promotions.php', 'add_promotion.php'])) echo 'activemenu'; ?>" href="../Page/promotions.php">Khuyến mãi</a>
      <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
            <div class=" nav-link dropdown">
                Tài khoản<span class="material-symbols-outlined">arrow_drop_down</span>
                <div class="dropdown-content">
                    <div class="dropdown-user-info">
                        <strong><?php echo htmlspecialchars($_SESSION['hoten']); ?></strong><br>
                        <small><?php echo htmlspecialchars($_SESSION['phone']); ?></small>
                    </div>
                    <a href="../Page/update_profile.php">Cập nhật thông tin</a>
                    <a href="../PHP/Logout.php">Đăng xuất</a>
                </div>
            </div>
      <?php else: ?>
          <a class="nav-link" href="../PHP/Login.php">Tài khoản</a>
      <?php endif; ?>
      </a>
    </div>
  </div>