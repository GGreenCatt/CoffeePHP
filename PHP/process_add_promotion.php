<?php
session_start();
include_once __DIR__ . '/Connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ma_code = $_POST['MaCode'];
    $loai_giam_gia = $_POST['LoaiGiamGia'];
    $gia_tri = $_POST['GiaTri'];
    $ngay_bat_dau = $_POST['NgayBatDau'];
    $ngay_ket_thuc = $_POST['NgayKetThuc'];

    // Validate data (simple validation)
    if (empty($ma_code) || empty($loai_giam_gia) || empty($gia_tri) || empty($ngay_bat_dau) || empty($ngay_ket_thuc)) {
        die("Vui lòng điền đầy đủ thông tin.");
    }
    
    // Chèn vào cơ sở dữ liệu
    $sql = "INSERT INTO khuyenmai (MaCode, LoaiGiamGia, GiaTri, NgayBatDau, NgayKetThuc) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiss", $ma_code, $loai_giam_gia, $gia_tri, $ngay_bat_dau, $ngay_ket_thuc);

    if ($stmt->execute()) {
        $_SESSION['promo_success'] = "Đã thêm mã khuyến mãi thành công!";
        header("Location: ../Page/promotions.php");
        exit();
    } else {
        echo "Lỗi khi thêm mã khuyến mãi: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>