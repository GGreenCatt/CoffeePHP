<?php
session_start();
include_once '/Connect.php';

// Kiểm tra xem id sản phẩm có được gửi đến không
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_san_pham = intval($_GET['id']);

    // Khởi tạo giỏ hàng nếu nó chưa tồn tại trong session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Lấy số lượng từ form (mặc định là 1 nếu không có)
    $so_luong = isset($_POST['soluong']) ? intval($_POST['soluong']) : 1;

    // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
    if (isset($_SESSION['cart'][$id_san_pham])) {
        // Nếu đã có, chỉ cần tăng số lượng lên
        $_SESSION['cart'][$id_san_pham]['soluong'] += $so_luong;
    } else {
        // Nếu chưa có, truy vấn CSDL để lấy thông tin sản phẩm
        $sql = "SELECT idSanPham, TenSanPham, GiaTien FROM sanpham WHERE idsanpham = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_san_pham);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            // Thêm sản phẩm mới vào giỏ hàng
            $_SESSION['cart'][$id_san_pham] = [
                "ten" => $product['TenSanPham'],
                "id" => $product['idSanPham'],
                "gia" => $product['GiaTien'],
                "soluong" => $so_luong
            ];
        }
    }
}

// Sau khi xử lý xong, chuyển hướng người dùng đến trang giỏ hàng
header('Location: ../Page/cart.php');
exit();
?>