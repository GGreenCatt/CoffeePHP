<?php
session_start();

// Initialize response array
$response = [
    'success' => false,
    'tam_tinh' => 0,
    'tong_cong' => 0,
    'item_total' => 0,
    'cart_count' => 0
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['soluong'])) {
    $id_san_pham = intval($_POST['id']);
    $so_luong = intval($_POST['soluong']);

    if (isset($_SESSION['cart'][$id_san_pham])) {
        if ($so_luong > 0) {
            $_SESSION['cart'][$id_san_pham]['soluong'] = $so_luong;
        } else {
            unset($_SESSION['cart'][$id_san_pham]);
        }
        
        // Calculate new totals
        $tam_tinh = 0;
        $phi_ship = 30000;
        $cart_count = 0;
        
        foreach ($_SESSION['cart'] as $item) {
            $tam_tinh += $item['gia'] * $item['soluong'];
            $cart_count += $item['soluong'];
        }

        // Handle promo code discount if applied
        $giam_gia = 0;
        if (isset($_SESSION['promo'])) {
            $loai_giam_gia = $_SESSION['promo']['loai'];
            $gia_tri_giam = $_SESSION['promo']['gia_tri'];
            if ($loai_giam_gia == 'phantram') {
                $giam_gia = $tam_tinh * ($gia_tri_giam / 100);
            } else {
                $giam_gia = $gia_tri_giam;
            }
            // Update discount amount in session just in case
            $_SESSION['promo']['amount'] = $giam_gia;
        }

        $tong_cong = $tam_tinh + $phi_ship - $giam_gia;
        if ($tong_cong < 0) $tong_cong = 0;
        
        $response['success'] = true;
        $response['tam_tinh'] = number_format($tam_tinh, 0, ',', '.'). ' VNĐ';
        $response['tong_cong'] = number_format($tong_cong, 0, ',', '.'). ' VNĐ';
        $response['item_total'] = number_format($_SESSION['cart'][$id_san_pham]['gia'] * $so_luong, 0, ',', '.'). ' VNĐ';
        $response['cart_count'] = $cart_count;
        
        // Return discount info if applicable
        if ($giam_gia > 0) {
            $response['giam_gia'] = number_format($giam_gia, 0, ',', '.') . ' VNĐ';
        }
    }
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>