<?php
session_start();
include_once '../PHP/Connect.php';

if (!isset($_GET['id_sp']) || empty($_GET['id_sp'])) {
    header("Location: ../Page/quanly_congthuc.php");
    exit();
}

$id_san_pham = intval($_GET['id_sp']);

$conn->begin_transaction();
try {
    $sql = "DELETE FROM congthuc WHERE idSanPham = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_san_pham);
    
    if (!$stmt->execute()) {
        throw new Exception("Lỗi khi xóa công thức.");
    }
    
    $conn->commit();
    $_SESSION['promo_success'] = "Đã xóa công thức thành công!";
} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['promo_error'] = "Lỗi: " . $e->getMessage();
}

header("Location: ../Page/quanly_congthuc.php?id_sp=" . $id_san_pham);
exit();
?>
