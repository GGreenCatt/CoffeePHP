<?php
session_start();
include_once __DIR__ . '/Connect.php';

header('Content-Type: application/json');

// Dữ liệu trả về mặc định
$response = [
    'success' => false,
    'message' => 'Đã có lỗi xảy ra.'
];

// Kiểm tra giỏ hàng và mã code
if (!isset($_SESSION['cart']) || empty($_SESSION['cart']) || !isset($_POST['promo_code'])) {
    $response['message'] = 'Giỏ hàng trống hoặc không có mã.';
    echo json_encode($response);
    exit();
}

$promo_code = trim($_POST['promo_code']);
$cart = $_SESSION['cart'];

// Tính tạm tính
$tam_tinh = 0;
foreach ($cart as $item) {
    $tam_tinh += $item['gia'] * $item['soluong'];
}

// Tìm mã trong CSDL
$now = date('Y-m-d H:i:s');
$sql = "SELECT * FROM khuyenmai WHERE MaCode = ? AND TrangThai = 'HoatDong' AND NgayBatDau <= ? AND NgayKetThuc >= ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $promo_code, $now, $now);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $promo = $result->fetch_assoc();
    $giam_gia = 0;

    // Tính toán số tiền giảm
    if ($promo['LoaiGiamGia'] == 'PhanTram') {
        $giam_gia = $tam_tinh * ($promo['GiaTri'] / 100);
    } else { // 'SoTien'
        $giam_gia = $promo['GiaTri'];
    }

    // Đảm bảo không giảm giá nhiều hơn giá trị đơn hàng
    if ($giam_gia > $tam_tinh) {
        $giam_gia = $tam_tinh;
    }

    // Lưu thông tin giảm giá vào session
    $_SESSION['promo'] = [
        'code' => $promo['MaCode'],
        'loai' => strtolower($promo['LoaiGiamGia']), // Chuyển thành chữ thường 'phantram' hoặc 'sotien'
        'gia_tri' => $promo['GiaTri'],
        'giam_gia' => $giam_gia // Lưu số tiền giảm cụ thể để dùng ngay nếu cần
    ];

    $response['success'] = true;
    $response['message'] = 'Áp dụng mã thành công!';
    $response['giam_gia'] = number_format($giam_gia, 0, ',', '.') . ' VNĐ';
    $response['tong_cong'] = number_format($tam_tinh + 30000 - $giam_gia, 0, ',', '.') . ' VNĐ'; // 30000 là phí ship
} else {
    // Nếu mã không hợp lệ, xóa session cũ nếu có
    unset($_SESSION['promo']);
    $response['message'] = 'Mã giảm giá không hợp lệ hoặc đã hết hạn!';
}

echo json_encode($response);
$stmt->close();
$conn->close();
?>