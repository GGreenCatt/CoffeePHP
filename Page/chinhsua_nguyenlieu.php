<?php
session_start();
include_once '../PHP/Connect.php';

$is_edit_mode = false;
$nguyenlieu = [
    'idNguyenLieu' => '',
    'TenNguyenLieu' => '',
    'SoLuongConLai' => 0,
    'DonViTinh' => '',
    'NguongThap' => 0
];

if (isset($_GET['id'])) {
    $is_edit_mode = true;
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM nguyenlieu WHERE idNguyenLieu = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $nguyenlieu = $result->fetch_assoc();
    } else {
        die("Nguyên liệu không tồn tại.");
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo $is_edit_mode ? 'Chỉnh Sửa' : 'Thêm Mới'; ?> Nguyên Liệu</title>
    <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
    <link rel="stylesheet" href="../Css/css.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php include '../PHP/menu_dashboard.php'; ?>
    <div class="dashboard">
        <div class="main-header">
            <h2 style="margin-bottom: 15px;"><?php echo $is_edit_mode ? 'Chỉnh Sửa Nguyên Liệu' : 'Thêm Nguyên Liệu Mới'; ?></h2>
            <a href="quanly_kho.php" class="btn-secondary" style="color:white; text-decoration:none;">Quay Lại</a>
        </div>
        
        <div class="form-container">
            <form action="../PHP/process_nguyenlieu.php" method="POST" class="admin-form">
                <?php if ($is_edit_mode): ?>
                    <input type="hidden" name="idNguyenLieu" value="<?php echo $nguyenlieu['idNguyenLieu']; ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label for="TenNguyenLieu">Tên Nguyên Liệu</label>
                    <input type="text" id="TenNguyenLieu" name="TenNguyenLieu" value="<?php echo htmlspecialchars($nguyenlieu['TenNguyenLieu']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="SoLuongConLai">Số Lượng Ban Đầu (chỉ khi thêm mới)</label>
                    <input type="number" step="0.01" id="SoLuongConLai" name="SoLuongConLai" value="<?php echo htmlspecialchars($nguyenlieu['SoLuongConLai']); ?>" <?php echo $is_edit_mode ? 'readonly' : 'required'; ?>>
                     <?php if ($is_edit_mode): ?>
                        <small style="color: #ccc;">* Để thay đổi số lượng tồn kho, vui lòng dùng chức năng "Nhập/Xuất kho".</small>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="DonViTinh">Đơn Vị Tính (ví dụ: kg, lít, hộp, chai)</label>
                    <input type="text" id="DonViTinh" name="DonViTinh" value="<?php echo htmlspecialchars($nguyenlieu['DonViTinh']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="NguongThap">Ngưỡng Báo Hết</label>
                    <input type="number" step="0.01" id="NguongThap" name="NguongThap" value="<?php echo htmlspecialchars($nguyenlieu['NguongThap']); ?>" required>
                </div>
                <div class="form-group-buttons">
                    <button type="submit" class="btn-primary">Lưu Nguyên Liệu</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>