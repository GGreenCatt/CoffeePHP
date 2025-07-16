<?php
session_start();

// Chỉ thực hiện nếu có dữ liệu số lượng được gửi lên
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['soluong'])) {

    // Lặp qua mảng số lượng được gửi từ form
    foreach ($_POST['soluong'] as $id_san_pham => $so_luong) {
        $id_san_pham = (int)$id_san_pham;
        $so_luong = (int)$so_luong;

        // Kiểm tra xem sản phẩm có tồn tại trong giỏ hàng không
        if (isset($_SESSION['cart'][$id_san_pham])) {
            if ($so_luong > 0) {
                // Cập nhật số lượng mới
                $_SESSION['cart'][$id_san_pham]['soluong'] = $so_luong;
            } else {
                // Nếu số lượng là 0 hoặc ít hơn, xóa sản phẩm khỏi giỏ hàng
                unset($_SESSION['cart'][$id_san_pham]);
            }
        }
    }
}

// Sau khi xử lý, chuyển hướng người dùng trở lại trang giỏ hàng
header('Location: ../Page/cart.php');
exit();
?>