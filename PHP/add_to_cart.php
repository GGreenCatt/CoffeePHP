<?php
session_start();
include_once __DIR__ . '/Connect.php';

// Mặc định phản hồi là lỗi
$response = ['success' => false, 'cart_count' => 0];

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id_san_pham = intval($_POST['id']);

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $so_luong = 1;

    if (isset($_SESSION['cart'][$id_san_pham])) {
        $_SESSION['cart'][$id_san_pham]['soluong'] += $so_luong;
    } else {
        $sql = "SELECT idSanPham, TenSanPham, GiaTien FROM sanpham WHERE idsanpham = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_san_pham);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $_SESSION['cart'][$id_san_pham] = [
                "ten" => $product['TenSanPham'],
                "id" => $product['idSanPham'],
                "gia" => $product['GiaTien'],
                "soluong" => $so_luong
            ];
        }
    }

    // Tính toán lại tổng số lượng
    $total_items = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_items += $item['soluong'];
    }

    // Cập nhật phản hồi thành công
    $response['success'] = true;
    $response['cart_count'] = $total_items;
}

// Thiết lập header và trả về dữ liệu JSON
header('Content-Type: application/json');
echo json_encode($response);
exit();
?>