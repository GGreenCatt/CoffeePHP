<?php
session_start();
include_once __DIR__ . '/Connect.php';

// Kiểm tra xem form đã được gửi đi chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Lấy dữ liệu từ form
    $id_san_pham = $_POST['idsanpham'];
    $ten_san_pham = $_POST['TenSanPham'];
    $gia_tien = $_POST['GiaTien'];
    $phan_loai = $_POST['PhanLoai'];
    $trang_thai = $_POST['TrangThai'];

    // Cập nhật thông tin text vào CSDL trước
    $sql = "UPDATE sanpham SET TenSanPham = ?, GiaTien = ?, PhanLoai = ?, TrangThai = ? WHERE idsanpham = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissi", $ten_san_pham, $gia_tien, $phan_loai, $trang_thai, $id_san_pham);
    
    if (!$stmt->execute()) {
        die("Lỗi khi cập nhật thông tin sản phẩm: " . $stmt->error);
    }
    
    // **Xử lý nếu có ảnh mới được tải lên**
    if (isset($_FILES['Anh']) && $_FILES['Anh']['error'] == 0) {
        $target_dir = "../Pic/";
        $ten_anh_moi = $id_san_pham . '.jpg'; // Tên ảnh vẫn là ID.jpg
        $target_file = $target_dir . $ten_anh_moi;

        // Xóa ảnh cũ nếu nó tồn tại (để đề phòng trường hợp ảnh cũ có đuôi khác)
        // (Phần này có thể bỏ qua nếu bạn chắc chắn 100% ảnh luôn là .jpg)
        // if (file_exists($target_file)) {
        //     unlink($target_file);
        // }

        // Di chuyển file ảnh mới vào, ghi đè lên file cũ
        if (!move_uploaded_file($_FILES["Anh"]["tmp_name"], $target_file)) {
            die("Lỗi khi tải ảnh mới lên.");
        }
    }
    
    // Đặt thông báo thành công và chuyển hướng
    $_SESSION['edit_product_success'] = "Sản phẩm đã được cập nhật thành công!";
    header("Location: ../page/Storage.php");
    exit();
}
?>