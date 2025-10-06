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
    $phi_ship = 30000;
    $tong_tien = $tam_tinh + $phi_ship;

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
    // === BẮT ĐẦU ĐOẠN CODE MỚI: TRỪ KHO VÀ GHI LỊCH SỬ ===
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
            $tong_sl_tru = $nguyen_lieu['SoLuongTieuHao'] * $so_luong_mua;

            $sql_tru_kho = "UPDATE nguyenlieu SET SoLuongConLai = SoLuongConLai - ? WHERE idNguyenLieu = ?";
            $stmt_tru_kho = $conn->prepare($sql_tru_kho);
            $stmt_tru_kho->bind_param("di", $tong_sl_tru, $id_nguyen_lieu);
            $stmt_tru_kho->execute();

            $sql_get_sl_moi = "SELECT SoLuongConLai FROM nguyenlieu WHERE idNguyenLieu = ?";
            $stmt_get_sl_moi = $conn->prepare($sql_get_sl_moi);
            $stmt_get_sl_moi->bind_param("i", $id_nguyen_lieu);
            $stmt_get_sl_moi->execute();
            $sl_con_lai_moi = $stmt_get_sl_moi->get_result()->fetch_assoc()['SoLuongConLai'];

            $sql_ghi_lichsu = "INSERT INTO lichsu_trukho (idDonHang, idSanPham, idNguyenLieu, SoLuongDaTru, SoLuongConLaiSauKhiTru) VALUES (?, ?, ?, ?, ?)";
            $stmt_ghi_lichsu = $conn->prepare($sql_ghi_lichsu);
            $stmt_ghi_lichsu->bind_param("iiidd", $id_don_hang, $id_san_pham, $id_nguyen_lieu, $tong_sl_tru, $sl_con_lai_moi);
            $stmt_ghi_lichsu->execute();
        }
    }
    // ===================================================================
    // === KẾT THÚC ĐOẠN CODE MỚI ===
    // ===================================================================
    
    $conn->commit();

    unset($_SESSION['cart']);
    $_SESSION['order_success'] = "Đặt hàng thành công!";
    header('Location: ../Page/index.php');
    exit();

} catch (mysqli_sql_exception $exception) {
    $conn->rollback();
    error_log("Lỗi xử lý đơn hàng: " . $exception->getMessage());
    die("Đã xảy ra lỗi trong quá trình xử lý đơn hàng. Vui lòng thử lại sau.");
}
?>