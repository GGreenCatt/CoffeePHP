<?php
session_start();
include 'Connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form và làm sạch
    $hoTen = mysqli_real_escape_string($conn, $_POST['HoTen']);
    $sdt = mysqli_real_escape_string($conn, $_POST['sdt']);
    $soNguoi = (int)$_POST['SoNguoi'];
    $ngayDat = mysqli_real_escape_string($conn, $_POST['NgayDat']);
    $gioDat = mysqli_real_escape_string($conn, $_POST['GioDat']);
    $ghiChu = mysqli_real_escape_string($conn, $_POST['GhiChu']);

    // Validate a bit
    if (empty($hoTen) || empty($sdt) || empty($soNguoi) || empty($ngayDat) || empty($gioDat)) {
        echo "Vui lòng điền đầy đủ thông tin bắt buộc.";
        exit();
    }

    // Chuẩn bị câu lệnh SQL
    $sql = "INSERT INTO datban (HoTen, sdt, SoNguoi, NgayDat, GioDat, GhiChu) VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Gán tham số
        mysqli_stmt_bind_param($stmt, "ssisss", $hoTen, $sdt, $soNguoi, $ngayDat, $gioDat, $ghiChu);

        // Thực thi câu lệnh
        if (mysqli_stmt_execute($stmt)) {
            // Đặt bàn thành công
            $_SESSION['booking_success'] = "Bạn đã đặt bàn thành công! Chúng tôi sẽ sớm liên hệ với bạn để xác nhận.";
            header("Location: ../Page/contact.php");
            exit();
        } else {
            // Lỗi khi thực thi
            echo "Lỗi: Không thể thực hiện đặt bàn. " . mysqli_error($conn);
        }

        // Đóng câu lệnh
        mysqli_stmt_close($stmt);
    } else {
        // Lỗi khi chuẩn bị câu lệnh
        echo "Lỗi: Không thể chuẩn bị câu lệnh. " . mysqli_error($conn);
    }

    // Đóng kết nối
    mysqli_close($conn);
} else {
    // Nếu không phải là phương thức POST, chuyển hướng về trang chủ
    header("Location: ../index.php");
    exit();
}
?>
