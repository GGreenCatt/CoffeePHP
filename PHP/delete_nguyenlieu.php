<?php
session_start();
include_once '../PHP/Connect.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ../Page/quanly_kho.php");
    exit();
}

$id_nguyen_lieu = intval($_GET['id']);

$conn->begin_transaction();
try {
    // Xóa nguyên liệu khỏi bảng congthuc trước (nếu chưa có CASCADE)
    $sql_congthuc = "DELETE FROM congthuc WHERE idNguyenLieu = ?";
    $stmt_congthuc = $conn->prepare($sql_congthuc);
    $stmt_congthuc->bind_param("i", $id_nguyen_lieu);
    $stmt_congthuc->execute();

    // Xóa nguyên liệu
    $sql_nguyenlieu = "DELETE FROM nguyenlieu WHERE idNguyenLieu = ?";
    $stmt_nguyenlieu = $conn->prepare($sql_nguyenlieu);
    $stmt_nguyenlieu->bind_param("i", $id_nguyen_lieu);
    
    if (!$stmt_nguyenlieu->execute()) {
        throw new Exception("Lỗi khi xóa nguyên liệu.");
    }
    
    $conn->commit();
    $_SESSION['inventory_success'] = "Đã xóa nguyên liệu thành công!";
} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['inventory_error'] = "Lỗi: " . $e->getMessage();
}

header("Location: ../Page/quanly_kho.php");
exit();
?>
