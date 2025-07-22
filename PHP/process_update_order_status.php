<?php
session_start();
include_once __DIR__ . '/Connect.php';

// Kiểm tra xem form đã được gửi đi chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Lấy dữ liệu từ form
    $id_don_hang = $_POST['idDonHang'];
    $trang_thai_moi = $_POST['TrangThai'];

    // Kiểm tra dữ liệu đầu vào
    if (empty($id_don_hang) || empty($trang_thai_moi)) {
        die("Dữ liệu không hợp lệ.");
    }

    // Chuẩn bị câu lệnh SQL để cập nhật trạng thái
    $sql = "UPDATE donhang SET TrangThai = ? WHERE idDonHang = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $trang_thai_moi, $id_don_hang);
    
    // Thực thi câu lệnh và kiểm tra kết quả
    if ($stmt->execute()) {
        // Nếu thành công, đặt thông báo và chuyển hướng người dùng trở lại trang chi tiết
        $_SESSION['update_status_success'] = "Đã cập nhật trạng thái đơn hàng!";
        header("Location: ../page/order_details_admin.php?id=" . $id_don_hang);
        exit();
    } else {
        // Nếu thất bại, thông báo lỗi
        die("Lỗi khi cập nhật trạng thái: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();

} else {
    // Nếu không phải là request POST, chuyển hướng về trang quản lý đơn hàng
    header("Location: ../page/orders.php");
    exit();
}
?>