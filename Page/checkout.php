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

// Kiểm tra và áp dụng giảm giá nếu có trong session
if (isset($_SESSION['promo']) && is_array($_SESSION['promo'])) {
    if (isset($_SESSION['promo']['loai']) && isset($_SESSION['promo']['gia_tri'])) {
        $loai_giam_gia = $_SESSION['promo']['loai'];
        $gia_tri_giam = $_SESSION['promo']['gia_tri'];

        if ($loai_giam_gia == 'phantram') {
            $giam_gia = $tam_tinh * ($gia_tri_giam / 100);
        } else {
            $giam_gia = $gia_tri_giam;
        }
    }
}

$tong_cong = $tam_tinh + $phi_ship - $giam_gia;
if ($tong_cong < 0) $tong_cong = 0;

/* ====== Cấu hình QR chuyển khoản (bạn sửa cho phù hợp) ====== */
// Hàm tính CRC16 cho VietQR (CCITT-FALSE)
if (!function_exists('crc16_ccitt_false')) {
    function crc16_ccitt_false($str) {
        $crc = 0xFFFF;
        for ($c = 0; $c < strlen($str); $c++) {
            $crc ^= (ord($str[$c]) << 8);
            for ($i = 0; $i < 8; $i++) {
                if ($crc & 0x8000) {
                    $crc = ($crc << 1) ^ 0x1021;
                } else {
                    $crc = $crc << 1;
                }
            }
        }
        return $crc & 0xFFFF;
    }
}

// Tạo chuỗi VietQR động
$payload_prefix = "00020101021238540010A00000072701240006970436011010280774230208QRIBFTTA5303704";
$amount_str = (string)$tong_cong;
$amount_tag = "54" . sprintf("%02d", strlen($amount_str)) . $amount_str;
$payload_suffix = "5802VN62210817Thanh toan ca phe"; // Nội dung cố định
$full_str_no_crc = $payload_prefix . $amount_tag . $payload_suffix . "6304";
$crc_val = strtoupper(sprintf("%04x", crc16_ccitt_false($full_str_no_crc)));
$qr_content = $full_str_no_crc . $crc_val;

// Gọi API QuickChart
$qr_image_path   = 'https://quickchart.io/qr?text=' . urlencode($qr_content) . '&size=300';
$qr_bank_label   = 'Quét mã QR để chuyển khoản';
$qr_owner_name   = 'LE MY DUNG';
$qr_note_hint    = 'Nội dung chuyển khoản: Thanh toan ca phe';
/* ============================================================ */
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
  <style>
    /* Bổ sung nhẹ cho phần QR */
    .payment-method { border: 1px solid #eee; border-radius: 8px; padding: 12px; margin-bottom: 12px; }
    .payment-title { display:flex; align-items:center; gap:8px; font-weight:600; }
    .qr-wrap { display:none; margin-top:10px; border-top:1px dashed #ddd; padding-top:12px; }
    .qr-flex { display:flex; gap:16px; align-items:flex-start; flex-wrap:wrap; }
    .qr-img { width:220px; max-width:100%; border:1px solid #eee; border-radius:8px; }
    .qr-info p { margin:6px 0; }
    .hint { color:#666; font-size: 0.95rem; }
    .req { color:#e74c3c; }
    .inline { display:inline-block; margin-left:6px; }
    .mt-8 { margin-top:8px; }
    .mt-12 { margin-top:12px; }
    .mt-16 { margin-top:16px; }
    .muted { color:#666; font-size:0.9rem; }
    .price { float:right; }
    @media (max-width: 600px) {
      .qr-flex { flex-direction:column; }
      .qr-img { width:100%; }
    }
  </style>
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
            <form action="../PHP/process_checkout.php" method="POST" id="checkoutForm">

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

                  <!-- COD -->
                  <div class="payment-method">
                    <div class="payment-title">
                      <input type="radio" id="cod" name="payment_method" value="cod" checked>
                      <label for="cod">Thanh toán khi nhận hàng (COD)</label>
                    </div>
                    <p class="muted">Bạn sẽ thanh toán bằng tiền mặt cho nhân viên giao hàng khi nhận được sản phẩm.</p>
                  </div>

                  <!-- QR chuyển khoản -->
                  <div class="payment-method">
                    <div class="payment-title">
                      <input type="radio" id="qr" name="payment_method" value="qr">
                      <label for="qr">QR chuyển khoản</label>
                    </div>

                    <div id="qrWrap" class="qr-wrap">
                      <div class="qr-flex">
                        <img class="qr-img" src="<?php echo htmlspecialchars($qr_image_path); ?>" alt="QR thanh toán">
                        <div class="qr-info">
                          <p><strong><?php echo htmlspecialchars($qr_bank_label); ?></strong></p>
                          <p>Chủ tài khoản: <strong><?php echo htmlspecialchars($qr_owner_name); ?></strong></p>
                          <p class="hint"><?php echo htmlspecialchars($qr_note_hint); ?></p>
                          <p class="mt-8">
                            Số tiền cần chuyển: <strong><?php echo number_format($tong_cong, 0, ',', '.'); ?> VNĐ</strong>
                          </p>

                          <label for="transfer_code" class="mt-12">Mã giao dịch / Ảnh xác nhận (tuỳ chọn)</label>
                          <input type="text" id="transfer_code" name="transfer_code" placeholder="Nhập mã giao dịch (nếu có)">

                          <label class="mt-12">
                            <input type="checkbox" id="confirm_transfer" name="confirm_transfer">
                            Tôi xác nhận đã chuyển khoản đúng số tiền <span class="inline"><strong><?php echo number_format($tong_cong, 0, ',', '.'); ?> VNĐ</strong></span>.
                          </label>
                          <p class="hint mt-8">* Đơn sẽ được xử lý sau khi shop xác nhận thanh toán.</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> <!-- /col-50 (payment) -->

              </div> <!-- /row -->
              
              <!-- Tổng tiền gửi lên server để đối chiếu (cũng tính lại ở server) -->
              <input type="hidden" name="order_total" value="<?php echo (int)$tong_cong; ?>">

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
            <?php if ($giam_gia > 0): ?>
              <p>Giảm giá <span class="price">- <?php echo number_format($giam_gia, 0, ',', '.'); ?> VNĐ</span></p>
            <?php endif; ?>
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

    // Toggle hiển thị QR khi chọn phương thức
    const codRadio = document.getElementById('cod');
    const qrRadio  = document.getElementById('qr');
    const qrWrap   = document.getElementById('qrWrap');
    const form     = document.getElementById('checkoutForm');

    function updatePaymentUI() {
      qrWrap.style.display = qrRadio.checked ? 'block' : 'none';
    }
    codRadio.addEventListener('change', updatePaymentUI);
    qrRadio.addEventListener('change', updatePaymentUI);
    updatePaymentUI();

    // (Tuỳ chọn) Yêu cầu xác nhận đã chuyển khoản khi chọn QR
    form.addEventListener('submit', function(e) {
      if (qrRadio.checked) {
        const confirmCb = document.getElementById('confirm_transfer');
        if (!confirmCb.checked) {
          e.preventDefault();
          alert('Vui lòng tích “Tôi xác nhận đã chuyển khoản” khi chọn thanh toán bằng QR.');
        }
      }
    });
  </script>
</body>
</html>
