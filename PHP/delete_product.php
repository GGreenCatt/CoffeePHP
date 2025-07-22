<?php
// Luôn bắt đầu session ở đầu tệp
session_start();

// Kiểm tra xem ID sản phẩm có được gửi đến không
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Nếu không có ID, chuyển hướng về trang quản lý
    header("Location: Storage.php");
    exit();
}

include_once '../PHP/Connect.php';

$id_san_pham = intval($_GET['id']);

// Bắt đầu một "giao dịch", nếu có lỗi sẽ hoàn tác
$conn->begin_transaction();

try {
    // **Bước 1: Xóa file ảnh vật lý**
    // Tạo tên file ảnh dựa trên ID (giả định là file .jpg)
    $image_path = "../Pic/" . $id_san_pham . ".jpg";

    // Kiểm tra xem file có tồn tại không và tiến hành xóa
    if (file_exists($image_path)) {
        if (!unlink($image_path)) {
            // Nếu không thể xóa file, ném ra một lỗi
            throw new Exception("Không thể xóa file ảnh.");
        }
    }

    // **Bước 2: Xóa sản phẩm khỏi cơ sở dữ liệu**
    $sql = "DELETE FROM sanpham WHERE idsanpham = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_san_pham);
    
    if (!$stmt->execute()) {
        // Nếu không thể xóa khỏi CSDL, ném ra một lỗi
        throw new Exception("Lỗi khi xóa sản phẩm khỏi cơ sở dữ liệu.");
    }
    
    // Nếu không có lỗi nào xảy ra, xác nhận giao dịch
    $conn->commit();

    // **Bước 3: Đặt thông báo thành công và chuyển hướng**
    $_SESSION['delete_product_success'] = "Sản phẩm đã được xóa thành công!";
    header("Location: ../page/Storage.php");
    exit();

} catch (Exception $e) {
    // Nếu có bất kỳ lỗi nào, hoàn tác tất cả thay đổi
    $conn->rollback();
    // Bạn có thể ghi lại lỗi để debug nếu muốn
    // error_log($e->getMessage());
    die("Đã xảy ra lỗi trong quá trình xóa sản phẩm. Vui lòng thử lại.");
}
?>