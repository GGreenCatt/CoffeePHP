<?php
session_start();
include_once __DIR__ . '/Connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_khuyen_mai = $_POST['idKhuyenMai'];
    $ma_code = $_POST['MaCode'];
    $loai_giam_gia = $_POST['LoaiGiamGia'];
    $gia_tri = $_POST['GiaTri'];
    $trang_thai = $_POST['TrangThai'];
    
    // Ghép ngày và giờ lại
    $ngay_bat_dau = $_POST['NgayBatDau'] . ' ' . $_POST['GioBatDau'] . ':00';
    $ngay_ket_thuc = $_POST['NgayKetThuc'] . ' ' . $_POST['GioKetThuc'] . ':00';

    // Cập nhật vào cơ sở dữ liệu
    $sql = "UPDATE khuyenmai SET MaCode = ?, LoaiGiamGia = ?, GiaTri = ?, NgayBatDau = ?, NgayKetThuc = ?, TrangThai = ? WHERE idKhuyenMai = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisssi", $ma_code, $loai_giam_gia, $gia_tri, $ngay_bat_dau, $ngay_ket_thuc, $trang_thai, $id_khuyen_mai);

    if ($stmt->execute()) {
        $_SESSION['promo_success'] = "Đã cập nhật mã khuyến mãi thành công!";
        header("Location: ../Admin/promotions.php");
        exit();
    } else {
        echo "Lỗi khi cập nhật mã khuyến mãi: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>