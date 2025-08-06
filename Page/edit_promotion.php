<?php
session_start();
include_once '../PHP/Connect.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: promotions.php");
    exit();
}
$id_khuyen_mai = intval($_GET['id']);

// Lấy thông tin hiện tại của mã khuyến mãi
$sql = "SELECT * FROM khuyenmai WHERE idKhuyenMai = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_khuyen_mai);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Mã khuyến mãi không tồn tại.");
}
$promo = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập Nhật Mã Khuyến Mãi</title>
    <link rel="stylesheet" href="../Css/css.css">
</head>
<body>
    <div class="admin-container">
        <?php include '../PHP/menu_dashboard.php'; ?>
        <div class="dashboard">
            <div class="main-header">
                <h2 style="margin-bottom: 15px;">Cập Nhật Mã Khuyến Mãi #<?php echo $promo['idKhuyenMai']; ?></h2>
                <a href="promotions.php" class="btn btn-secondary">Quay Lại</a>
            </div>
            
            <div class="form-container">
                <form action="../PHP/process_edit_promotion.php" method="POST" class="admin-form">
                    <input type="hidden" name="idKhuyenMai" value="<?php echo $promo['idKhuyenMai']; ?>">
                    <div class="form-group">
                        <label for="MaCode">Mã Code</label>
                        <input type="text" id="MaCode" name="MaCode" value="<?php echo htmlspecialchars($promo['MaCode']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="LoaiGiamGia">Loại Giảm Giá</label>
                        <select id="LoaiGiamGia" name="LoaiGiamGia" required>
                            <option value="SoTien" <?php echo ($promo['LoaiGiamGia'] == 'SoTien') ? 'selected' : ''; ?>>Giảm theo số tiền (VNĐ)</option>
                            <option value="PhanTram" <?php echo ($promo['LoaiGiamGia'] == 'PhanTram') ? 'selected' : ''; ?>>Giảm theo phần trăm (%)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="GiaTri">Giá trị</label>
                        <input type="number" step="1" id="GiaTri" name="GiaTri" value="<?php echo $promo['GiaTri']; ?>" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="NgayBatDau">Ngày Bắt Đầu</label>
                            <input type="date" id="NgayBatDau" name="NgayBatDau" value="<?php echo date('Y-m-d', strtotime($promo['NgayBatDau'])); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="GioBatDau">Giờ Bắt Đầu</label>
                            <input type="time" id="GioBatDau" name="GioBatDau" value="<?php echo date('H:i', strtotime($promo['NgayBatDau'])); ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="NgayKetThuc">Ngày Kết Thúc</label>
                            <input type="date" id="NgayKetThuc" name="NgayKetThuc" value="<?php echo date('Y-m-d', strtotime($promo['NgayKetThuc'])); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="GioKetThuc">Giờ Kết Thúc</label>
                            <input type="time" id="GioKetThuc" name="GioKetThuc" value="<?php echo date('H:i', strtotime($promo['NgayKetThuc'])); ?>" required>
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="TrangThai">Trạng Thái</label>
                        <select id="TrangThai" name="TrangThai" required>
                            <option value="HoatDong" <?php echo ($promo['TrangThai'] == 'HoatDong') ? 'selected' : ''; ?>>Hoạt động</option>
                            <option value="KhongHoatDong" <?php echo ($promo['TrangThai'] == 'KhongHoatDong') ? 'selected' : ''; ?>>Không hoạt động</option>
                        </select>
                    </div>
                    <div class="form-group-buttons">
                        <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>