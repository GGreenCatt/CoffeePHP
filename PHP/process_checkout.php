<?php
// File: PHP/process_checkout.php (Đã cập nhật)
session_start();
include_once __DIR__ . '/Connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: ../index.php');
    exit();
}

$conn->begin_transaction();

try {
    $ho_ten = $_POST['hoten'];
    $sdt = $_POST['sdt'];
    $dia_chi = $_POST['diachi'];
    $cart = $_SESSION['cart'];
    $id_tai_khoan = $_SESSION['id'] ?? NULL;

    $tam_tinh = 0;
    foreach ($cart as $item) {
        $tam_tinh += $item['gia'] * $item['soluong'];
    }

    $giam_gia = 0;
    if (isset($_SESSION['promo']) && is_array($_SESSION['promo'])) {
        if (isset($_SESSION['promo']['loai']) && isset($_SESSION['promo']['gia_tri'])) {
            $loai = $_SESSION['promo']['loai'];
            $gia_tri = $_SESSION['promo']['gia_tri'];
            
            if ($loai == 'phantram') {
                $giam_gia = $tam_tinh * ($gia_tri / 100);
            } else {
                $giam_gia = $gia_tri;
            }
        }
    }

    $phi_ship = 30000;
    $tong_tien = $tam_tinh + $phi_ship - $giam_gia;
    if ($tong_tien < 0) $tong_tien = 0;

    $sql_donhang = "INSERT INTO donhang (idTaiKhoan, TenNguoiNhan, SoDienThoaiNhan, DiaChiNhan, TongTien) VALUES (?, ?, ?, ?, ?)";
    $stmt_donhang = $conn->prepare($sql_donhang);
    $stmt_donhang->bind_param("isssd", $id_tai_khoan, $ho_ten, $sdt, $dia_chi, $tong_tien);
    $stmt_donhang->execute();

    $id_don_hang = $conn->insert_id;

    $sql_chitiet = "INSERT INTO chitietdonhang (idDonHang, idSanPham, SoLuong, DonGia) VALUES (?, ?, ?, ?)";
    $stmt_chitiet = $conn->prepare($sql_chitiet);
    foreach ($cart as $id_san_pham => $item) {
        $so_luong = $item['soluong'];
        $don_gia = $item['gia'];
        $stmt_chitiet->bind_param("iiid", $id_don_hang, $id_san_pham, $so_luong, $don_gia);
        $stmt_chitiet->execute();
    }

    // ===================================================================
    // === BẮT ĐẦU ĐOẠN CODE MỚI: TRỪ KHO VÀ GHI LỊCH SỬ HỢP NHẤT ===
    // ===================================================================
    foreach ($cart as $id_san_pham => $item) {
        $so_luong_mua = $item['soluong'];
        $sql_get_congthuc = "SELECT idNguyenLieu, SoLuongTieuHao FROM congthuc WHERE idSanPham = ?";
        $stmt_get_congthuc = $conn->prepare($sql_get_congthuc);
        $stmt_get_congthuc->bind_param("i", $id_san_pham);
        $stmt_get_congthuc->execute();
        $result_congthuc = $stmt_get_congthuc->get_result();

        while ($nguyen_lieu = $result_congthuc->fetch_assoc()) {
            $id_nguyen_lieu = $nguyen_lieu['idNguyenLieu'];
            $so_luong_tieu_hao = $nguyen_lieu['SoLuongTieuHao'] * $so_luong_mua;

            // Lấy số lượng trước khi cập nhật
            $stmt_get_before = $conn->prepare("SELECT SoLuongConLai FROM nguyenlieu WHERE idNguyenLieu = ? FOR UPDATE");
            $stmt_get_before->bind_param("i", $id_nguyen_lieu);
            $stmt_get_before->execute();
            $so_luong_truoc = $stmt_get_before->get_result()->fetch_assoc()['SoLuongConLai'];
            $stmt_get_before->close();

            // Cập nhật kho
            $sql_update = "UPDATE nguyenlieu SET SoLuongConLai = SoLuongConLai - ? WHERE idNguyenLieu = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("di", $so_luong_tieu_hao, $id_nguyen_lieu);
            $stmt_update->execute();
            $stmt_update->close();

            // Ghi vào lịch sử hợp nhất
            $so_luong_sau = $so_luong_truoc - $so_luong_tieu_hao;
            $hanh_dong_text = 'Xuất kho (Bán hàng)';
            $ly_do = "Đơn hàng #" . $id_don_hang;

            $sql_log = "INSERT INTO lichsu_tonkho (idDonHang, idSanPham, idNguyenLieu, idNguoiThucHien, HanhDong, SoLuong, SoLuongTruoc, SoLuongSau, LyDo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_log = $conn->prepare($sql_log);
            // idNguoiThucHien ở đây là id khách hàng, có thể là NULL
            $stmt_log->bind_param("iiiisddds", $id_don_hang, $id_san_pham, $id_nguyen_lieu, $id_tai_khoan, $hanh_dong_text, $so_luong_tieu_hao, $so_luong_truoc, $so_luong_sau, $ly_do);
            $stmt_log->execute();
            $stmt_log->close();
        }
        $stmt_get_congthuc->close();
    }
    // ===================================================================
    // === KẾT THÚC ĐOẠN CODE MỚI ===
    // ===================================================================
    
    $conn->commit();

    unset($_SESSION['cart']);
    unset($_SESSION['promo']); // Xóa thông tin giảm giá sau khi đặt hàng thành công
    $_SESSION['order_success'] = "Đặt hàng thành công!";
    header('Location: ../Page/index.php');
    exit();

} catch (mysqli_sql_exception $exception) {
    $conn->rollback();
    error_log("Lỗi xử lý đơn hàng: " . $exception->getMessage());
    die("Đã xảy ra lỗi trong quá trình xử lý đơn hàng. Vui lòng thử lại sau.");
}
?>