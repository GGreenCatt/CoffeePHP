<?php
// File: PHP/process_nguyenlieu.php
session_start();
include_once __DIR__ . '/Connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten = $_POST['TenNguyenLieu'];
    $don_vi = $_POST['DonViTinh'];
    $nguong_thap = $_POST['NguongThap'];

    if (isset($_POST['idNguyenLieu']) && !empty($_POST['idNguyenLieu'])) {
        // --- CHẾ ĐỘ CẬP NHẬT ---
        $id = $_POST['idNguyenLieu'];
        $sql = "UPDATE nguyenlieu SET TenNguyenLieu = ?, DonViTinh = ?, NguongThap = ? WHERE idNguyenLieu = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdi", $ten, $don_vi, $nguong_thap, $id);
        $_SESSION['update_status_success'] = "Đã cập nhật nguyên liệu thành công!";
    } else {
        // --- CHẾ ĐỘ THÊM MỚI ---
        $so_luong = $_POST['SoLuongConLai'];
        $sql = "INSERT INTO nguyenlieu (TenNguyenLieu, SoLuongConLai, DonViTinh, NguongThap) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdsd", $ten, $so_luong, $don_vi, $nguong_thap);
        $_SESSION['update_status_success'] = "Đã thêm nguyên liệu mới thành công!";
    }

    if (!$stmt->execute()) {
        die("Lỗi: " . $stmt->error);
    }
    
    $stmt->close();
    $conn->close();
    header("Location: ../Page/quanly_kho.php");
    exit();
}
?>