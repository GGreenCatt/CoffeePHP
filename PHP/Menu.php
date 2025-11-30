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

// Danh sách các trang thuộc menu "Thực đơn" (bao gồm cả trang chi tiết sản phẩm)
$thuc_don_pages = ['coffee.php', 'drinks.php', 'desserts.php', 'snack.php', 'Product_Detail.php'];
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
      <a href="index.php" class="brand-link">HIGHBUCKS<br>
        <small>COFFEE</small>
      </a>
    </div>

    <div class="navbar-m1">
      <a class="nav-link <?php if ($current_page == 'index.php') echo 'activemenu'; ?>" href="../Page/index.php">Trang Chủ</a>
      <div class=" nav-link dropdown <?php if (in_array($current_page, $thuc_don_pages)) echo 'activemenu'; ?>">
        Thực Đơn<span class="material-symbols-outlined">arrow_drop_down</span>
        <div class="dropdown-content">
          <a href="../Page/coffee.php">Cafe</a>
          <a href="../Page/drinks.php">Đồ Uống Khác</a>
          <a href="../Page/desserts.php">Tráng Miệng</a>
          <a href="../Page/snack.php">Đồ Ăn Vặt</a>
        </div>
      </div>
      <a class="nav-link <?php if ($current_page == 'service.php') echo 'activemenu'; ?>" href="../Page/service.php">Dịch Vụ</a>
      <a class="nav-link <?php if ($current_page == 'blog.php') echo 'activemenu'; ?>" href="../Page/blog.php">Blog</a>
      <a class="nav-link <?php if ($current_page == 'about.php') echo 'activemenu'; ?>" href="../Page/about.php">Giới Thiệu</a>
      <a class="nav-link <?php if ($current_page == 'contact.php') echo 'activemenu'; ?>" href="../Page/contact.php">Liên Hệ</a>
      <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
            <div class=" nav-link dropdown">
                Tài khoản<span class="material-symbols-outlined">arrow_drop_down</span>
                <div class="dropdown-content">
                    <div class="dropdown-user-info">
                        <strong><?php echo htmlspecialchars($_SESSION['hoten']); ?></strong><br>
                        <small><?php echo htmlspecialchars($_SESSION['phone']); ?></small>
                    </div>
                    <?php if (isset($_SESSION['chucvu']) && $_SESSION['chucvu'] == 'Quản lý'): ?>
                        <a href="../Page/dashboard.php">Xem trang quản lý</a>
                    <?php endif; ?>
                    <a href="../Page/my_account.php">Quản lý tài khoản</a>
                    <a href="../PHP/Logout.php">Đăng xuất</a>
                </div>
            </div>
      <?php else: ?>
          <a class="nav-link" href="../PHP/Login.php">Tài khoản</a>
      <?php endif; ?>
      <a class="nav-link" href="../Page/cart.php" id="cart-icon-wrapper">
        <span class="material-symbols-outlined">
          shopping_cart
        </span>
        <span id="cart-item-count" class="cart-count"><?php echo $cart_item_count; ?></span>
      </a>
    </div>
  </div>
  <div id="navbar" class="navbar fixed">
    <div class="brand">
      <a href="index.html" class="brand-link">HIGHBUCKS<br>
        <small>COFFEE</small>
      </a>
    </div>

    <div class="navbar-m1">
      <a class="nav-link <?php if ($current_page == 'index.php') echo 'activemenu'; ?>" href="../Page/index.php">Trang Chủ</a>
      <div class=" nav-link dropdown <?php if (in_array($current_page, $thuc_don_pages)) echo 'activemenu'; ?>">
        Thực Đơn<span class="material-symbols-outlined">arrow_drop_down</span>
        <div class="dropdown-content">
          <a href="../Page/coffee.php">Cafe</a>
          <a href="../Page/drinks.php">Đồ Uống Khác</a>
          <a href="../Page/desserts.php">Tráng Miệng</a>
          <a href="../Page/snack.php">Đồ Ăn Vặt</a>
        </div>
      </div>
      <a class="nav-link <?php if ($current_page == 'service.php') echo 'activemenu'; ?>" href="../Page/service.php">Dịch Vụ</a>
      <a class="nav-link <?php if ($current_page == 'blog.php') echo 'activemenu'; ?>" href="../Page/blog.php">Blog</a>
      <a class="nav-link <?php if ($current_page == 'about.php') echo 'activemenu'; ?>" href="../Page/about.php">Giới Thiệu</a>
      <a class="nav-link <?php if ($current_page == 'contact.php') echo 'activemenu'; ?>" href="../Page/contact.php">Liên Hệ</a>
      <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
             <div class=" nav-link dropdown">
                Tài khoản<span class="material-symbols-outlined">arrow_drop_down</span>
                <div class="dropdown-content">
                    <div class="dropdown-user-info">
                        <strong><?php echo htmlspecialchars($_SESSION['hoten']); ?></strong><br>
                        <small><?php echo htmlspecialchars($_SESSION['phone']); ?></small>
                    </div>
                    <?php if (isset($_SESSION['chucvu']) && $_SESSION['chucvu'] == 'Quản lý'): ?>
                        <a href="../Page/dashboard.php">Xem trang quản lý</a>
                    <?php endif; ?>
                    <a href="../Page/my_account.php">Quản lý tài khoản</a>
                    <a href="../PHP/Logout.php">Đăng xuất</a>
                </div>
            </div>
      <?php else: ?>
          <a class="nav-link" href="../PHP/Login.php">Tài khoản</a>
      <?php endif; ?>
      <a class="nav-link" href="../Page/cart.php" id="cart-icon-wrapper-fixed">
        <span class="material-symbols-outlined">
          shopping_cart
        </span>
        <span id="cart-item-count-fixed" class="cart-count"><?php echo $cart_item_count; ?></span>
      </a>
    </div>
  </div>