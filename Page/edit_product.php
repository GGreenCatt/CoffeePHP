<?php
session_start();
include_once '../PHP/Connect.php';

// Kiểm tra xem ID có được gửi đến không
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: Storage.php");
    exit();
}

$id_san_pham = intval($_GET['id']);

// Truy vấn để lấy thông tin sản phẩm hiện tại
$sql = "SELECT * FROM sanpham WHERE idsanpham = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_san_pham);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Sản phẩm không tồn tại.");
}

// Lấy dữ liệu sản phẩm để điền vào form
$product = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập Nhật Sản Phẩm</title>
    <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../Css/css.css">
</head>
<body>
    <?php include '../PHP/menu_dashboard.php' ?>

    <div class="dashboard">
        <h2 style="padding-bottom: 10px;">Cập Nhật Sản Phẩm #<?php echo $product['idsanpham']; ?></h2>
        <form action="../PHP/process_edit_product.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="idsanpham" value="<?php echo $product['idsanpham']; ?>">
            
            <div class="add_product">
                <div class="col">
                    <h1>Hình ảnh sản phẩm</h1>
                    <div class="image-preview-container" style="display:flex; justify-content: center;">
                        <img id="image-preview" src="../Pic/<?php echo $product['idsanpham']; ?>.jpg" alt="Ảnh sản phẩm" width="400px" height="100%">
                    </div>
                </div>
                <div class="col">
                    <h1 style="text-align: center;">Thông tin sản phẩm</h1>
                    <div class="add_product_form">
                       <div class="form-group">
                           <label for="TenSanPham">Tên Sản Phẩm:</label>
                           <input type="text" id="TenSanPham" name="TenSanPham" value="<?php echo htmlspecialchars($product['TenSanPham']); ?>" required>
                       </div>
                       <div class="form-group">
                           <label for="GiaTien">Giá Tiền (VNĐ):</label>
                           <input type="number" id="GiaTien" name="GiaTien" value="<?php echo $product['GiaTien']; ?>" required>
                       </div>
                       <div class="form-group">
                           <label for="PhanLoai">Phân Loại:</label>
                           <select id="PhanLoai" name="PhanLoai" required>
                               <option value="Cà Phê" <?php echo ($product['PhanLoai'] == 'Cà Phê') ? 'selected' : ''; ?>>Cà Phê</option>
                               <option value="Món Chính" <?php echo ($product['PhanLoai'] == 'Món Chính') ? 'selected' : ''; ?>>Món Chính</option>
                               <option value="Đồ Uống Khác" <?php echo ($product['PhanLoai'] == 'Đồ Uống Khác') ? 'selected' : ''; ?>>Đồ Uống Khác</option>
                               <option value="Tráng Miệng" <?php echo ($product['PhanLoai'] == 'Tráng Miệng') ? 'selected' : ''; ?>>Tráng Miệng</option>
                               <option value="Đồ Ăn Vặt" <?php echo ($product['PhanLoai'] == 'Đồ Ăn Vặt') ? 'selected' : ''; ?>>Đồ Ăn Vặt</option>
                           </select>
                       </div>
                        <div class="form-group">
                           <label for="TrangThai">Trạng Thái:</label>
                           <select id="TrangThai" name="TrangThai" required>
                               <option value="Hoạt động" <?php echo ($product['TrangThai'] == 'Hoạt động') ? 'selected' : ''; ?>>Hoạt động</option>
                               <option value="Tạm dừng" <?php echo ($product['TrangThai'] == 'Tạm dừng') ? 'selected' : ''; ?>>Tạm dừng</option>
                           </select>
                       </div>
                       <div class="form-group">
                           <label for="Anh">Chọn Ảnh Mới (nếu muốn thay đổi):</label>
                           <input type="file" id="Anh" name="Anh" accept="image/*" onchange="previewImage(event)">
                       </div>
                       <div class="form-group">
                           <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
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
            const imagePreview = document.getElementById('image-preview');
            const file = event.target.files[0];
            if (file) {
                imagePreview.src = URL.createObjectURL(file);
                imagePreview.onload = () => { URL.revokeObjectURL(imagePreview.src); }
            }
        };
    </script>
</body>
</html>