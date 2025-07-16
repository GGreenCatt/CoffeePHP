<?php
session_start();

// Kiểm tra xem ID sản phẩm có được gửi qua URL không
if (isset($_GET['id'])) {
    $id_san_pham = (int)$_GET['id'];

    // Nếu sản phẩm tồn tại trong giỏ hàng, hãy xóa nó
    if (isset($_SESSION['cart'][$id_san_pham])) {
        unset($_SESSION['cart'][$id_san_pham]);
    }
}

// Chuyển hướng người dùng trở lại trang giỏ hàng
header('Location: ../Page/cart.php');
exit();
?>