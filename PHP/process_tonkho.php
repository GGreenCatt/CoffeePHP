<?php
// File: PHP/process_tonkho.php
session_start();
include_once __DIR__ . '/Connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_nguyen_lieu = (int)$_POST['idNguyenLieu'];
    $action = $_POST['hanhDong'];
    $quantity = (float)$_POST['soLuong'];
    $reason = $_POST['lyDo'];
    $id_user = $_SESSION['id'] ?? NULL; // Lấy ID người dùng đang đăng nhập

    $conn->begin_transaction();
    try {
        // 1. Lấy số lượng tồn kho hiện tại (trước khi thay đổi)
        $stmt_get_before = $conn->prepare("SELECT SoLuongConLai FROM nguyenlieu WHERE idNguyenLieu = ? FOR UPDATE");
        $stmt_get_before->bind_param("i", $id_nguyen_lieu);
        $stmt_get_before->execute();
        $result_before = $stmt_get_before->get_result();
        if ($result_before->num_rows === 0) {
            throw new Exception("Nguyên liệu không tồn tại.");
        }
        $so_luong_truoc = $result_before->fetch_assoc()['SoLuongConLai'];
        
        // 2. Cập nhật tồn kho
        $so_luong_sau = 0;
        if ($action == 'nhap') {
            $sql_update = "UPDATE nguyenlieu SET SoLuongConLai = SoLuongConLai + ? WHERE idNguyenLieu = ?";
            $so_luong_sau = $so_luong_truoc + $quantity;
        } elseif ($action == 'xuat') {
            if ($so_luong_truoc < $quantity) {
                throw new Exception("Số lượng xuất kho không thể lớn hơn tồn kho hiện tại.");
            }
            $sql_update = "UPDATE nguyenlieu SET SoLuongConLai = SoLuongConLai - ? WHERE idNguyenLieu = ?";
            $so_luong_sau = $so_luong_truoc - $quantity;
        } else {
            throw new Exception("Hành động không hợp lệ.");
        }
        
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("di", $quantity, $id_nguyen_lieu);
        $stmt_update->execute();

        // 3. Ghi lại lịch sử
        $hanh_dong_text = ($action == 'nhap') ? 'Nhập kho' : 'Xuất kho';
        $sql_log = "INSERT INTO lichsu_tonkho (idNguyenLieu, idNguoiThucHien, HanhDong, SoLuong, SoLuongTruoc, SoLuongSau, LyDo) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_log = $conn->prepare($sql_log);
        $stmt_log->bind_param("iisddds", $id_nguyen_lieu, $id_user, $hanh_dong_text, $quantity, $so_luong_truoc, $so_luong_sau, $reason);
        $stmt_log->execute();
        
        $conn->commit();
        $_SESSION['inventory_success'] = "Đã cập nhật tồn kho thành công!";

    } catch (Exception $e) {
        $conn->rollback();
        // Lưu lỗi vào session để hiển thị trên trang trước đó
        $_SESSION['inventory_error'] = "Lỗi: " . $e->getMessage();
    }

    header("Location: ../Page/quanly_kho.php");
    exit();
}
?>