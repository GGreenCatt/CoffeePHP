<?php
session_start();
include_once '../PHP/Connect.php';

$sql = "SELECT * FROM khuyenmai ORDER BY idKhuyenMai DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Khuyến Mãi</title>
    <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
    <link rel="stylesheet" href="../Css/css.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="admin-container">
        <?php include_once __DIR__ . '/../PHP/menu_dashboard.php'; ?>
        <div class="dashboard">
            <div class="main-header" style="display: flex; justify-content: space-between; align-items: center; ">
                <h2>Quản Lý Khuyến Mãi</h2>
                <a href="add_promotion.php" class="btn btn-primary">
                    Thêm mã mới
                </a>
            </div>
            <table class="tbdonhang modern">
                    <tr>
                        <th>ID</th>
                        <th>Mã Code</th>
                        <th>Loại Giảm Giá</th>
                        <th>Giá Trị</th>
                        <th>Thời Gian Hiệu Lực</th>
                        <th>Trạng Thái</th>
                        <th>Thao tác</th>
                    </tr>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo $row['idKhuyenMai']; ?></td>
                                <td><strong class="promo-code"><?php echo htmlspecialchars($row['MaCode']); ?></strong></td>
                                <td>
                                    <?php 
                                        $loai_class = ($row['LoaiGiamGia'] == 'PhanTram') ? 'phan-tram' : 'so-tien';
                                        $loai_text = ($row['LoaiGiamGia'] == 'PhanTram') ? 'Phần Trăm' : 'Số Tiền';
                                        echo "<span class='status-badge {$loai_class}'>{$loai_text}</span>";
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        if ($row['LoaiGiamGia'] == 'PhanTram') {
                                            echo '<strong>' . htmlspecialchars($row['GiaTri']) . ' %</strong>';
                                        } else {
                                            echo '<strong>' . number_format($row['GiaTri'], 0, ',', '.') . ' VNĐ</strong>';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php echo date('d/m/Y', strtotime($row['NgayBatDau'])); ?> - 
                                    <?php echo date('d/m/Y', strtotime($row['NgayKetThuc'])); ?>
                                </td>
                                <td>
                                     <?php 
                                        $status_class = ($row['TrangThai'] == 'HoatDong') ? 'hoat-dong' : 'khong-hoat-dong';
                                        $status_text = ($row['TrangThai'] == 'HoatDong') ? 'Hoạt động' : 'Không hoạt động';
                                        echo "<span class='status-badge {$status_class}'>{$status_text}</span>";
                                    ?>
                                </td>
                                <td class="action-links">
                                    <a href="edit_promotion.php?id=<?php echo $row['idKhuyenMai']; ?>" title="Sửa"><span class="material-symbols-outlined icon-edit">edit</span></a>
                                    <a href="../PHP/delete_promotion.php?id=<?php echo $row['idKhuyenMai']; ?>" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa mã khuyến mãi này?');"><span class="material-symbols-outlined icon-delete">delete</span></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="8" style="text-align: center;">Chưa có mã khuyến mãi nào.</td></tr>
                    <?php endif; ?>
            </table>
        </div>
    </div>
    <?php
    // Hiển thị các thông báo
    if (isset($_SESSION['promo_success'])) {
        echo "<script>Swal.fire({toast: true, position: 'top-end', icon: 'success', title: '" . addslashes($_SESSION['promo_success']) . "', showConfirmButton: false, timer: 2000});</script>";
        unset($_SESSION['promo_success']);
    }
    ?>
</body>
</html>