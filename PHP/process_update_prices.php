<?php
// File: PHP/process_update_prices.php
session_start();
include_once 'Connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id']) || !isset($_POST['gianhap']) || !isset($_POST['giaxuat'])) {
        echo json_encode(['status' => 'error', 'message' => 'Thiếu dữ liệu đầu vào.']);
        exit;
    }

    $id = intval($_POST['id']);
    $giaNhap = floatval($_POST['gianhap']);
    $giaXuat = floatval($_POST['giaxuat']);

    // Validate inputs
    if ($id <= 0 || $giaNhap < 0 || $giaXuat < 0) {
        echo json_encode(['status' => 'error', 'message' => 'Dữ liệu không hợp lệ (Giá phải >= 0).']);
        exit;
    }

    // Use INSERT ... ON DUPLICATE KEY UPDATE to handle both new and existing records
    $sql = "INSERT INTO giatien_nguyenlieu (idNguyenLieu, GiaNhap, GiaXuat) 
            VALUES (?, ?, ?) 
            ON DUPLICATE KEY UPDATE GiaNhap = VALUES(GiaNhap), GiaXuat = VALUES(GiaXuat)";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("idd", $id, $giaNhap, $giaXuat);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Cập nhật thành công.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Lỗi database: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Lỗi chuẩn bị câu lệnh: ' . $conn->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}

$conn->close();
?>
