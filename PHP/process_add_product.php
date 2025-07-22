<?php
// Luôn bắt đầu session ở đầu tệp
session_start();
include_once __DIR__ . '/Connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn->begin_transaction();

    try {
        // Lấy thông tin từ form
        $ten_san_pham = $_POST['TenSanPham'];
        $gia_tien = $_POST['GiaTien'];
        $phan_loai = $_POST['PhanLoai'];
        $trang_thai = $_POST['TrangThai'];

        // Chèn thông tin vào CSDL
        $sql_insert = "INSERT INTO sanpham (TenSanPham, GiaTien, PhanLoai, TrangThai) VALUES (?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("siss", $ten_san_pham, $gia_tien, $phan_loai, $trang_thai);
        $stmt_insert->execute();
        
        $new_product_id = $conn->insert_id;
        if ($new_product_id == 0) {
            throw new Exception("Không thể tạo ID cho sản phẩm mới.");
        }

        // Xử lý file ảnh
        if (isset($_FILES['Anh']) && $_FILES['Anh']['error'] == 0) {
            $target_dir = "../Pic/";
            $ten_anh_moi = $new_product_id . '.jpg';
            $target_file = $target_dir . $ten_anh_moi;

            if (!move_uploaded_file($_FILES["Anh"]["tmp_name"], $target_file)) {
                throw new Exception("Lỗi khi tải ảnh lên.");
            }
        } else {
            throw new Exception("Vui lòng chọn một file ảnh hợp lệ.");
        }
        
        $conn->commit();
        
        // **THÊM DÒNG NÀY: Đặt thông báo thành công vào session**
        $_SESSION['add_product_success'] = "Sản phẩm đã được thêm thành công!";

        // Chuyển hướng về trang quản lý
        header("Location: ../page/Storage.php");
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        die("Đã xảy ra lỗi: " . $e->getMessage());
    }
}
?>