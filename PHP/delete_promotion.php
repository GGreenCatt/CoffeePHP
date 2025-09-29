<?php
session_start();
include_once __DIR__ . '/Connect.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ../Page/promotions.php");
    exit();
}

$id_khuyen_mai = intval($_GET['id']);

// Xóa mã khuyến mãi khỏi cơ sở dữ liệu
$sql = "DELETE FROM khuyenmai WHERE idKhuyenMai = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_khuyen_mai);

if ($stmt->execute()) {
    $_SESSION['promo_success'] = "Đã xóa mã khuyến mãi thành công!";
} else {
    $_SESSION['promo_error'] = "Lỗi khi xóa mã khuyến mãi."; // Bạn có thể thêm logic hiển thị lỗi nếu muốn
}

header("Location: ../Page/promotions.php");
exit();
?>