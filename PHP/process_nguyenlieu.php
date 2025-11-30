<?php
// File: PHP/process_nguyenlieu.php
session_start();
include_once __DIR__ . '/Connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten = $_POST['TenNguyenLieu'];
    $don_vi = $_POST['DonViTinh'];
    $nguong_thap = $_POST['NguongThap'];

    try {
        if (isset($_POST['idNguyenLieu']) && !empty($_POST['idNguyenLieu'])) {
            // --- CHẾ ĐỘ CẬP NHẬT ---
            $id = $_POST['idNguyenLieu'];
            $sql = "UPDATE nguyenlieu SET TenNguyenLieu = ?, DonViTinh = ?, NguongThap = ? WHERE idNguyenLieu = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdi", $ten, $don_vi, $nguong_thap, $id);
            
            if (!$stmt->execute()) {
                throw new Exception("Lỗi khi cập nhật nguyên liệu: " . $stmt->error);
            }
            $_SESSION['inventory_success'] = "Đã cập nhật nguyên liệu thành công!";
        } else {
            // --- CHẾ ĐỘ THÊM MỚI ---
            $so_luong = $_POST['SoLuongConLai'];
            $sql = "INSERT INTO nguyenlieu (TenNguyenLieu, SoLuongConLai, DonViTinh, NguongThap) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sdsd", $ten, $so_luong, $don_vi, $nguong_thap);
            
            if (!$stmt->execute()) {
                throw new Exception("Lỗi khi thêm nguyên liệu mới: " . $stmt->error);
            }
            $_SESSION['inventory_success'] = "Đã thêm nguyên liệu mới thành công!";
        }
    } catch (Exception $e) {
        $_SESSION['inventory_error'] = "Lỗi: " . $e->getMessage();
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        $conn->close();
    }
    
    header("Location: ../Page/quanly_kho.php");
    exit();
}
?>