<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Mã Khuyến Mãi</title>
    <link rel="stylesheet" href="../Css/css.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <div class="admin-container">
        <?php include '../PHP/menu_dashboard.php'; ?>
        <div class="dashboard">
            <div class="main-header">
                <h2 style="margin-bottom: 10px;">Thêm Mã Khuyến Mãi Mới</h2>
                <a href="promotions.php" class="btn btn-secondary">Quay Lại</a>
            </div>
            
            <div class="form-container">
                <form action="../PHP/process_add_promotion.php" method="POST" class="admin-form">
                    <div class="form-group">
                        <label for="MaCode">Mã Code</label>
                        <input type="text" id="MaCode" name="MaCode" placeholder="Nhập mã không dấu, viết liền..." required>
                    </div>
                    <div class="form-group">
                        <label for="LoaiGiamGia">Loại Giảm Giá</label>
                        <select id="LoaiGiamGia" name="LoaiGiamGia" required>
                            <option value="SoTien">Giảm theo số tiền (VNĐ)</option>
                            <option value="PhanTram">Giảm theo phần trăm (%)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="GiaTri">Giá trị</label>
                        <input type="number" step="1" id="GiaTri" name="GiaTri" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="NgayBatDau">Thời Gian Bắt Đầu</label>
                        <input type="datetime-local" id="NgayBatDau" name="NgayBatDau" required >
                    </div>
                    <div class="form-group">
                        <label for="NgayKetThuc">Thời Gian Kết Thúc</label>
                        <input type="datetime-local" id="NgayKetThuc" name="NgayKetThuc" required>
                    </div>
                    <div class="form-group-buttons">
                        <button type="submit" class="btn btn-primary">Lưu Mã</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>