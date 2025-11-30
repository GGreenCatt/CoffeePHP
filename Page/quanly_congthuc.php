<?php

session_start();
include_once '../PHP/Connect.php';

// Lấy danh sách sản phẩm và nguyên liệu
$sanphams = $conn->query("SELECT idsanpham, TenSanPham FROM sanpham ORDER BY TenSanPham ASC");
$nguyenlieus = $conn->query("SELECT idNguyenLieu, TenNguyenLieu, DonViTinh FROM nguyenlieu ORDER BY TenNguyenLieu ASC");

$congthuc_hientai = [];
$id_sp_chon = null;
$ten_sp_chon = "";

// Kiểm tra nếu có sản phẩm được chọn
if (isset($_GET['id_sp']) && !empty($_GET['id_sp'])) {
    $id_sp_chon = intval($_GET['id_sp']);

    // Lấy tên sản phẩm đang được chọn
    $stmt_sp = $conn->prepare("SELECT TenSanPham FROM sanpham WHERE idsanpham = ?");
    $stmt_sp->bind_param("i", $id_sp_chon);
    $stmt_sp->execute();
    $sp_result = $stmt_sp->get_result();
    if ($sp_result->num_rows > 0) {
        $ten_sp_chon = $sp_result->fetch_assoc()['TenSanPham'];
    }
    
    // Lấy công thức hiện tại của sản phẩm
    $stmt_congthuc = $conn->prepare("SELECT idNguyenLieu, SoLuongTieuHao FROM congthuc WHERE idSanPham = ?");
    $stmt_congthuc->bind_param("i", $id_sp_chon);
    $stmt_congthuc->execute();
    $result_congthuc = $stmt_congthuc->get_result();
    while ($row = $result_congthuc->fetch_assoc()) {
        $congthuc_hientai[$row['idNguyenLieu']] = $row['SoLuongTieuHao'];
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Công Thức Định Lượng</title>
    <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
    <link rel="stylesheet" href="../Css/css.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php include '../PHP/menu_dashboard.php'; ?>
    <div class="dashboard">
        <div class="main-header">
            <h2>Quản Lý Công Thức Định Lượng</h2>
        </div>
        
        <div class="form-container" style="max-width: 900px; margin-bottom: 30px;">
            <form method="GET" action="quanly_congthuc.php" class="admin-form">
                <div class="form-group">
                    <label for="id_sp">Chọn sản phẩm để xem hoặc chỉnh sửa công thức:</label>
                    <select id="id_sp" name="id_sp" onchange="this.form.submit()">
                        <option value="">-- Chọn một sản phẩm --</option>
                        <?php mysqli_data_seek($sanphams, 0); ?>
                        <?php while ($sp = $sanphams->fetch_assoc()): ?>
                            <option value="<?php echo $sp['idsanpham']; ?>" <?php echo ($id_sp_chon == $sp['idsanpham']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($sp['TenSanPham']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </form>
        </div>

        <?php if ($id_sp_chon): ?>
        <div class="form-container" style="max-width: 900px;">
            <form method="POST" action="../PHP/update_congthuc.php" class="admin-form">
                <input type="hidden" name="id_san_pham" value="<?php echo $id_sp_chon; ?>">
                
                <h3 style="text-align: center; color: goldenrod; margin-bottom: 25px; font-size: 22px;">
                    Công thức cho: "<?php echo htmlspecialchars($ten_sp_chon); ?>"
                </h3>
                
                <table class="tbdonhang modern">
                        <tr>
                            <th>Tên Nguyên Liệu</th>
                            <th style="width: 25%;">Số Lượng Tiêu Hao</th>
                            <th style="width: 15%;">Đơn Vị</th>
                        </tr>
                        <?php mysqli_data_seek($nguyenlieus, 0); ?>
                        <?php while ($nl = $nguyenlieus->fetch_assoc()): 
                            $id_nl = $nl['idNguyenLieu'];
                            $so_luong = $congthuc_hientai[$id_nl] ?? 0;
                        ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($nl['TenNguyenLieu']); ?></strong></td>
                            <td>
                                <input style="background-color: black; color: goldenrod;padding: 5px; border: 1px solid goldenrod; border-radius: 10px;" type="number" step="0.001" min="0" name="nguyen_lieu[<?php echo $id_nl; ?>]" value="<?php echo $so_luong; ?>">
                            </td>
                            <td><?php echo htmlspecialchars($nl['DonViTinh']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                </table>

                <div class="form-group-buttons" style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="confirmDelete(<?php echo $id_sp_chon; ?>)" class="btn-primary" style="background-color: #dc3545;">Xóa Công Thức</button>
                    <button type="submit" class="btn-primary">Lưu Công Thức</button>
                </div>
            </form>
        </div>
        <?php endif; ?>
    </div>

    <script>
    function confirmDelete(id_sp) {
        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: "Bạn muốn xóa toàn bộ công thức cho sản phẩm này?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Vâng, xóa nó!',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '../PHP/delete_congthuc.php?id_sp=' + id_sp;
            }
        })
    }
    </script>

    <?php
    // Hiển thị thông báo thành công nếu có
    if (isset($_SESSION['promo_success'])) {
        echo "<script>Swal.fire({toast: true, position: 'top-end', icon: 'success', title: '" . addslashes($_SESSION['promo_success']) . "', showConfirmButton: false, timer: 2000});</script>";
        unset($_SESSION['promo_success']);
    }
    // Hiển thị thông báo lỗi nếu có
    if (isset($_SESSION['promo_error'])) {
        echo "<script>Swal.fire({icon: 'error', title: 'Lỗi', text: '" . addslashes($_SESSION['promo_error']) . "'});</script>";
        unset($_SESSION['promo_error']);
    }
    ?>
</body>
</html>