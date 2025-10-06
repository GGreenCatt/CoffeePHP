<?php
session_start();
include_once '../PHP/Connect.php';

$sql = "SELECT 
            ls.ThoiGian, 
            nl.TenNguyenLieu,
            tk.HoTen AS NguoiThucHien,
            ls.HanhDong,
            ls.SoLuong,
            ls.SoLuongTruoc,
            ls.SoLuongSau,
            ls.LyDo
        FROM lichsu_tonkho ls
        JOIN nguyenlieu nl ON ls.idNguyenLieu = nl.idNguyenLieu
        LEFT JOIN taikhoan tk ON ls.idNguoiThucHien = tk.idTaiKhoan
        ORDER BY ls.ThoiGian DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch Sử Nhập/Xuất Kho</title>
    <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
    <link rel="stylesheet" href="../Css/css.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>    <style>
        .tbdonhang.modern .hanh-dong-nhap { color: #28a745; font-weight: bold; }
        .tbdonhang.modern .hanh-dong-xuat { color: #d9534f; font-weight: bold; }
    </style>
</head>
<body>
    <?php include '../PHP/menu_dashboard.php'; ?>
    <div class="dashboard">
        <div class="main-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Lịch Sử Nhập/Xuất Kho</h2>
            <a href="quanly_kho.php" class="btn-secondary" style="color:white; text-decoration:none;">Quay lại Kho</a>
        </div>

        <table class="tbdonhang modern">
                <tr>
                    <th>Thời Gian</th>
                    <th>Nguyên Liệu</th>
                    <th>Hành Động</th>
                    <th>Số Lượng</th>
                    <th>Tồn Kho (Trước -> Sau)</th>
                    <th>Lý Do</th>
                    <th>Người Thực Hiện</th>
                </tr>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <?php
                            $action_class = ($row['HanhDong'] == 'Nhập kho') ? 'hanh-dong-nhap' : 'hanh-dong-xuat';
                            $action_prefix = ($row['HanhDong'] == 'Nhập kho') ? '+' : '-';
                        ?>
                        <tr>
                            <td><?php echo date('d/m/Y H:i', strtotime($row['ThoiGian'])); ?></td>
                            <td><strong><?php echo htmlspecialchars($row['TenNguyenLieu']); ?></strong></td>
                            <td class="<?php echo $action_class; ?>"><?php echo htmlspecialchars($row['HanhDong']); ?></td>
                            <td class="<?php echo $action_class; ?>"><?php echo $action_prefix . number_format($row['SoLuong'], 2); ?></td>
                            <td><?php echo number_format($row['SoLuongTruoc'], 2) . " -> " . number_format($row['SoLuongSau'], 2); ?></td>
                            <td><?php echo htmlspecialchars($row['LyDo']); ?></td>
                            <td><?php echo htmlspecialchars($row['NguoiThucHien'] ?? 'N/A'); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" style="text-align: center;">Chưa có lịch sử nhập/xuất kho.</td></tr>
                <?php endif; ?>
        </table>
    </div>
</body>
</html>