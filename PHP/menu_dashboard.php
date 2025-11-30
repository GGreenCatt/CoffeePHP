<?php
// File: PHP/menu_dashboard.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$current_page = basename($_SERVER['PHP_SELF']);

// *** CẬP NHẬT MẢNG NÀY: Đã xóa 'capnhat_tonkho.php' ***
$storage_pages = ['storage.php', 'add_product.php', 'edit_product.php', 'quanly_kho.php', 'quanly_congthuc.php', 'chinhsua_nguyenlieu.php', 'lichsu_nhapxuat.php']; 
$order_pages = ['orders.php', 'order_details_admin.php'];
$customer_pages = ['customers.php', 'customer_details.php'];
?>
  <style> 
    .dropdown-content { display: none; position: absolute; background-color: black; min-width: 230px; box-shadow: 0px 10px 25px 0px rgba(0, 0, 0, 0.1); z-index: 1001; border-radius: 8px; border: 1px solid #f0f0f0; overflow: hidden; }
    .dropdown-user-info { padding: 16px 20px; color: goldenrod; text-align: left; border-bottom: 1px solid #f0f0f0; line-height: 1.4; }
    .dropdown-user-info strong { font-size: 16px; color: goldenrod; }
    .dropdown-user-info small { font-size: 14px; color: goldenrod; }
    .dropdown-content a { color: white; padding: 14px 20px; text-decoration: none; display: block; text-align: left; font-size: 15px; transition: all 0.2s ease; }
    .dropdown-content a:hover { background-color: #f7f7f7; color: #c49a6c; padding-left: 25px; }
    .dropdown:hover .dropdown-content { display: block; }
  </style>
  <div class="navbar">
    <div class="brand">
      <a href="../Page/dashboard.php" class="brand-link">HIGHBUCKS<br>
        <small>COFFEE</small>
      </a>
    </div>
    <div class="navbar-m1">
      <a class="nav-link <?php if ($current_page == 'dashboard.php') echo 'activemenu'; ?>" href="../Page/dashboard.php">Thống kê</a>
      
      <div class="nav-link dropdown <?php if (in_array($current_page, $storage_pages)) echo 'activemenu'; ?>">
          Kho<span class="material-symbols-outlined">arrow_drop_down</span>
          <div class="dropdown-content">
              <a href="../Page/storage.php">Quản Lý Sản Phẩm</a>
              <a href="../Page/quanly_kho.php">Tồn Kho Nguyên Liệu</a>
              <a href="../Page/quanly_congthuc.php">Quản Lý Công Thức</a>
              <a href="../Page/lichsu_nhapxuat.php">Lịch Sử Nhập/Xuất</a>
          </div>
      </div>

      <a class="nav-link <?php if (in_array($current_page, $order_pages)) echo 'activemenu'; ?>" href="../Page/orders.php">Đơn đặt</a>
      <a class="nav-link <?php if ($current_page == 'admin_bookings.php') echo 'activemenu'; ?>" href="../Page/admin_bookings.php">Quản lý đặt bàn</a>
      <a class="nav-link <?php if (in_array($current_page, $customer_pages)) echo 'activemenu'; ?>" href="../Page/customers.php">Khách hàng</a>
      <a class="nav-link <?php if (in_array($current_page, ['promotions.php', 'add_promotion.php'])) echo 'activemenu'; ?>" href="../Page/promotions.php">Khuyến mãi</a>
      <a class="nav-link <?php if (in_array($current_page, ['admin_blog.php', 'add_blog_post.php', 'edit_blog_post.php'])) echo 'activemenu'; ?>" href="../Page/admin_blog.php">Blog</a>
      <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
            <div class=" nav-link dropdown">
                Tài khoản<span class="material-symbols-outlined">arrow_drop_down</span>
                <div class="dropdown-content">
                    <div class="dropdown-user-info">
                        <strong><?php echo htmlspecialchars($_SESSION['hoten']); ?></strong><br>
                        <small><?php echo htmlspecialchars($_SESSION['phone']); ?></small>
                    </div>
                    <a href="../Page/index.php">Xem trang khách</a>
                    <a href="../Page/update_profile.php">Cập nhật thông tin</a>
                    <a href="../PHP/Logout.php">Đăng xuất</a>
                </div>
            </div>
      <?php else: ?>
          <a class="nav-link" href="../PHP/Login.php">Tài khoản</a>
      <?php endif; ?>
    </div>
  </div>