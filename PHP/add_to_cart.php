<?php
session_start();
include_once __DIR__ . '/Connect.php';

// Mặc định phản hồi là lỗi
$response = ['success' => false, 'cart_count' => 0];

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id_san_pham = intval($_POST['id']);

    // === THAY ĐỔI QUAN TRỌNG Ở ĐÂY ===
    // Lấy số lượng từ dữ liệu POST, nếu không có thì mặc định là 1.
    $so_luong = isset($_POST['soluong']) ? intval($_POST['soluong']) : 1;

    // Đảm bảo số lượng tối thiểu là 1
    if ($so_luong < 1) {
        $so_luong = 1;
    }
    // =================================

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
    if (isset($_SESSION['cart'][$id_san_pham])) {
        // Nếu đã có, cộng dồn số lượng
        $_SESSION['cart'][$id_san_pham]['soluong'] += $so_luong;
    } else {
        // Nếu chưa có, truy vấn và thêm mới
        $sql = "SELECT TenSanPham, GiaTien, idSanpham FROM sanpham WHERE idsanpham = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_san_pham);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $_SESSION['cart'][$id_san_pham] = [
                "ten" => $product['TenSanPham'],
                "id" => $product['idSanpham'],
                "gia" => $product['GiaTien'],
                "soluong" => $so_luong // Sử dụng số lượng đã nhận được
            ];
        }
    }

    // Tính toán lại tổng số lượng sản phẩm trong giỏ
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