<?php
// Bắt đầu phiên làm việc để truy cập vào SESSION
session_start();

// Bao gồm tệp kết nối cơ sở dữ liệu
include_once __DIR__ . '/Connect.php';

// --- BƯỚC 1: KIỂM TRA TÍNH HỢP LỆ CỦA YÊU CẦU ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: ../index.php');
    exit();
}

// Bắt đầu một giao dịch để đảm bảo toàn vẹn dữ liệu
$conn->begin_transaction();

try {
    // --- BƯỚC 2: THU THẬP DỮ LIỆU ---
    $ho_ten = $_POST['hoten'];
    $sdt = $_POST['sdt'];
    $dia_chi = $_POST['diachi'];
    $cart = $_SESSION['cart'];
    $id_tai_khoan = $_SESSION['id'] ?? NULL;

    // Tính toán lại tổng tiền ở phía server để đảm bảo an toàn
    $tam_tinh = 0;
    foreach ($cart as $item) {
        $tam_tinh += $item['gia'] * $item['soluong'];
    }
    $phi_ship = 30000;
    $tong_tien = $tam_tinh + $phi_ship;

    // --- BƯỚC 3: LƯU ĐƠN HÀNG VÀO DATABASE ---
    $sql_donhang = "INSERT INTO donhang (idTaiKhoan, TenNguoiNhan, SoDienThoaiNhan, DiaChiNhan, TongTien) VALUES (?, ?, ?, ?, ?)";
    $stmt_donhang = $conn->prepare($sql_donhang);
    $stmt_donhang->bind_param("isssd", $id_tai_khoan, $ho_ten, $sdt, $dia_chi, $tong_tien);
    $stmt_donhang->execute();

    $id_don_hang = $conn->insert_id;

    $sql_chitiet = "INSERT INTO chitietdonhang (idDonHang, idSanPham, SoLuong, DonGia) VALUES (?, ?, ?, ?)";
    $stmt_chitiet = $conn->prepare($sql_chitiet);
    foreach ($cart as $id_san_pham => $item) {
        $so_luong = $item['soluong'];
        $don_gia = $item['gia'];
        $stmt_chitiet->bind_param("iiid", $id_don_hang, $id_san_pham, $so_luong, $don_gia);
        $stmt_chitiet->execute();
    }
    
    $conn->commit();

    // --- BƯỚC 4: DỌN DẸP VÀ CHUYỂN HƯỚNG ---
    // Xóa giỏ hàng
    unset($_SESSION['cart']);

    // **ĐẶT THÔNG BÁO THÀNH CÔNG VÀO SESSION**
    $_SESSION['order_success'] = "Đặt hàng thành công!";
    
    // **CHUYỂN HƯỚNG VỀ TRANG CHỦ**
    header('Location: ../Page/index.php');
    exit();

} catch (mysqli_sql_exception $exception) {
    $conn->rollback();
    // Ghi log lỗi để debug
    error_log("Lỗi xử lý đơn hàng: " . $exception->getMessage());
    // Hiển thị thông báo lỗi chung
    die("Đã xảy ra lỗi trong quá trình xử lý đơn hàng. Vui lòng thử lại sau.");
}
?>