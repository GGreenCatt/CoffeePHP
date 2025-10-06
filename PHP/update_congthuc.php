<?php
// File: PHP/update_congthuc.php
session_start();
include_once __DIR__ . '/Connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../Page/dashboard.php');
    exit();
}

$id_san_pham = (int)$_POST['id_san_pham'];
$nguyen_lieu_list = $_POST['nguyen_lieu'];

$conn->begin_transaction();
try {
    $sql_delete = "DELETE FROM congthuc WHERE idSanPham = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id_san_pham);
    $stmt_delete->execute();

    $sql_insert = "INSERT INTO congthuc (idSanPham, idNguyenLieu, SoLuongTieuHao) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    
    foreach ($nguyen_lieu_list as $id_nl => $so_luong) {
        $so_luong = (float)$so_luong;
        if ($so_luong > 0) {
            $stmt_insert->bind_param("iid", $id_san_pham, $id_nl, $so_luong);
            $stmt_insert->execute();
        }
    }
    
    $conn->commit();
    $_SESSION['promo_success'] = "Cập nhật công thức thành công!";
} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['promo_error'] = "Lỗi khi cập nhật: " . $e->getMessage();
}

header("Location: ../Page/quanly_congthuc.php?id_sp=" . $id_san_pham);
exit();
?>