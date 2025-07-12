<style>
    /* XÓA hoặc THAY THẾ các đoạn CSS .dropdown-content và .dropdown-content a cũ bằng đoạn này */

/* ==== DROPDOWN STYLES (UPDATED) ==== */

/* Khung chính của dropdown */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #151111;
  min-width: 230px; /* Tăng độ rộng một chút */
  box-shadow: 0px 10px 25px 0px rgba(0, 0, 0, 0.1); /* Hiệu ứng đổ bóng mềm mại hơn */
  z-index: 1;
  border-radius: 8px; /* Bo tròn các góc */
  border: 1px solid #c49a6c   ; /* Đường viền rất nhẹ */
  overflow: hidden; /* Đảm bảo nội dung tuân thủ bo tròn góc */
}

/* Phần hiển thị thông tin người dùng */
.dropdown-user-info {
  padding: 16px 20px;
  color: goldenrod;
  text-align: left; /* Căn lề trái cho dễ đọc tên và sđt */
  border-bottom: 1px solid #c49a6c; /* Đường kẻ ngăn cách */
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
  color: goldenrod; /* Màu chữ tối hơn */
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

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
  <div class="navbar">
    <div class="brand">
      <a href="index.php" class="brand-link">HIGHBUCKS<br>
        <small>COFFEE</small>
      </a>
    </div>

    <div class="navbar-m1">
      <a class="nav-link activemenu" href="index.php">Trang Chủ</a>
      <div class=" nav-link dropdown">
        Thực Đơn<span class="material-symbols-outlined">arrow_drop_down</span>
        <div class="dropdown-content">
          <a href="coffee.php">Cafe</a>
          <a href="drinks.php">Đồ Uống Khác</a>
          <a href="desserts.php">Tráng Miệng</a>
          <a href="snack.php">Đồ Ăn Vặt</a>
        </div>
      </div>
      <a class="nav-link" href="service.php">Dịch Vụ</a>
      <a class="nav-link" href="blog.php">Blog</a>
      <a class="nav-link" href="about.php">Giới Thiệu</a>
      <a class="nav-link" href="contact.php">Liên Hệ</a>

      <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
        <div class="nav-link dropdown">
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
      <a class="nav-link" href="cart2.php">
        <span class="material-symbols-outlined">
          shopping_cart
        </span>
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
      <a class="nav-link activemenu" href="index.php">Trang Chủ</a>
      <div class=" nav-link dropdown">
        Thực Đơn<span class="material-symbols-outlined">arrow_drop_down</span>
        <div class="dropdown-content">
          <a href="coffee.php">Cafe</a>
          <a href="drinks.php">Đồ Uống Khác</a>
          <a href="desserts.php">Tráng Miệng</a>
          <a href="snack.php">Đồ Ăn Vặt</a>
        </div>
      </div>
      <a class="nav-link" href="service.php">Dịch Vụ</a>
      <a class="nav-link" href="blog.php">Blog</a>
      <a class="nav-link" href="about.php">Giới Thiệu</a>
      <a class="nav-link" href="contact.php">Liên Hệ</a>
      
      <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
        <div class="nav-link dropdown">
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
      <a class="nav-link" href="cart2.php">
        <span class="material-symbols-outlined">
          shopping_cart
        </span>
      </a>
    </div>
  </div>