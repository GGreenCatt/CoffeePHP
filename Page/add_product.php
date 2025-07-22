<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản Phẩm Mới</title>
    <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../Css/css.css">
    <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
</head>
<body>
    <?php include '../PHP/menu_dashboard.php' ?>

    <div class="dashboard">
        <h2 style="margin-bottom: 10px;">Thêm Sản Phẩm Mới</h2>
        <form action="../PHP/process_add_product.php" method="POST" enctype="multipart/form-data">
            <div class="add_product">
                <div class="col">
                    <h1>Hình ảnh sản phẩm</h1>
                    <div class="image-preview-container" style="display: flex;justify-content: center;">
                        <img id="image-preview" src="../Pic/placeholder.jpg" width="400px" height="100%">
                    </div>
                </div>
                <div class="col">
                    <h1 style="text-align: center;">Thông tin sản phẩm</h1>
                    <div class="add_product_form">
                       <div class="form-group">
                           <label for="TenSanPham">Tên Sản Phẩm:</label>
                           <input type="text" id="TenSanPham" name="TenSanPham" required>
                       </div>
                       <div class="form-group">
                           <label for="GiaTien">Giá Tiền (VNĐ):</label>
                           <input type="number" id="GiaTien" name="GiaTien" required>
                       </div>
                       <div class="form-group">
                           <label for="PhanLoai">Phân Loại:</label>
                           <select id="PhanLoai" name="PhanLoai" required>
                               <option value="Cà Phê">Cà Phê</option>
                               <option value="Món Chính">Món Chính</option>
                               <option value="Đồ Uống Khác">Đồ Uống Khác</option>
                               <option value="Tráng Miệng">Tráng Miệng</option>
                               <option value="Đồ Ăn Vặt">Đồ Ăn Vặt</option>
                           </select>
                       </div>
                        <div class="form-group">
                           <label for="TrangThai">Trạng Thái:</label>
                           <select id="TrangThai" name="TrangThai" required>
                               <option value="Còn hàng">Hoạt động</option>
                               <option value="Hết hàng">Tạm dừng</option>
                           </select>
                       </div>
                       <div class="form-group">
                           <label for="Anh">Chọn Ảnh Sản Phẩm:</label>
                           <input type="file" id="Anh" name="Anh" accept="image/*" required onchange="previewImage(event)">
                       </div>
                       <div class="form-group">
                           <button type="submit" class="btn btn-primary">Lưu Sản Phẩm</button>
                           <a href="Storage.php" class="button" style="text-decoration: none;">Hủy</a>
                       </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="copyright">Copyright © 2023 Dung. All rights reserved.</div>

    <script>
        const previewImage = (event) => {
            // Lấy thẻ img để hiển thị ảnh xem trước
            const imagePreview = document.getElementById('image-preview');
            
            // Lấy file người dùng đã chọn
            const file = event.target.files[0];
            
            if (file) {
                // Tạo một URL tạm thời cho file ảnh và gán vào thẻ img
                imagePreview.src = URL.createObjectURL(file);
                
                // Thu hồi URL cũ để giải phóng bộ nhớ khi ảnh thay đổi
                imagePreview.onload = () => {
                    URL.revokeObjectURL(imagePreview.src);
                }
            }
        };
    </script>
</body>
</html>