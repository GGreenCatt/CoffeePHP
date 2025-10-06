<?php
session_start();
include_once '../PHP/Connect.php';
$nguyenlieus = $conn->query("SELECT idNguyenLieu, TenNguyenLieu, DonViTinh FROM nguyenlieu ORDER BY TenNguyenLieu ASC");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Nhập/Xuất Kho</title>
    <link rel="stylesheet" href="../Css/css.css">
    <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php include '../PHP/menu_dashboard.php'; ?>
    <div class="dashboard">
        <div class="main-header">
            <h2 style="margin-bottom: 15px;">Cập Nhật Tồn Kho</h2>
            <a href="quanly_kho.php" class="btn-secondary" style="color:white; text-decoration:none;">Quay Lại</a>
        </div>
        
        <div class="form-container">
            <form action="../PHP/process_tonkho.php" method="POST" class="admin-form">
                <div class="form-group">
                    <label for="idNguyenLieu">Chọn Nguyên Liệu</label>
                    <select id="idNguyenLieu" name="idNguyenLieu" required>
                        <option value="">-- Vui lòng chọn --</option>
                        <?php while($row = $nguyenlieus->fetch_assoc()): ?>
                            <option value="<?php echo $row['idNguyenLieu']; ?>">
                                <?php echo htmlspecialchars($row['TenNguyenLieu']) . " (" . htmlspecialchars($row['DonViTinh']) . ")"; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="hanhDong">Hành Động</label>
                    <select id="hanhDong" name="hanhDong" required>
                        <option value="nhap">Nhập kho (Cộng thêm)</option>
                        <option value="xuat">Xuất kho (Trừ đi)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="soLuong">Số Lượng</label>
                    <input type="number" step="0.01" id="soLuong" name="soLuong" placeholder="Nhập số lượng cần thay đổi" required>
                </div>
                 <div class="form-group">
                    <label for="lyDo">Lý Do (không bắt buộc)</label>
                    <input type="text" id="lyDo" name="lyDo" placeholder="Ví dụ: Nhập hàng từ nhà cung cấp A, Hủy do hỏng">
                </div>
                <div class="form-group-buttons">
                    <button type="submit" class="btn-primary">Xác Nhận</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>