<?php
session_start();
include_once '../PHP/Connect.php';

$search_query = "";
$sql = "SELECT n.idNguyenLieu, n.TenNguyenLieu, n.DonViTinh, g.GiaNhap, g.GiaXuat 
        FROM nguyenlieu n 
        LEFT JOIN giatien_nguyenlieu g ON n.idNguyenLieu = g.idNguyenLieu";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = $_GET['search'];
    $sql .= " WHERE n.TenNguyenLieu LIKE ?";
}
$sql .= " ORDER BY n.idNguyenLieu ASC";

$stmt = $conn->prepare($sql);
if (!empty($search_query)) {
    $search_term = "%" . $search_query . "%";
    $stmt->bind_param("s", $search_term);
}
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Giá Tiền Nguyên Liệu</title>
    <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
    <link rel="stylesheet" href="../Css/css.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .price-input {
            width: 120px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: right;
        }
        .btn-update {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn-update:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include '../PHP/menu_dashboard.php'; ?>
    <div class="dashboard">
        <div class="main-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Quản Lý Giá Tiền Nguyên Liệu</h2>
            <div>
                 <!-- Placeholder for future buttons -->
            </div>
        </div>

        <div class="search-container">
            <form action="quanly_giatien.php" method="GET">
                <input type="text" name="search" placeholder="Tìm kiếm theo tên nguyên liệu..." value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit">
                    <span class="material-symbols-outlined">search</span>
                </button>
            </form>
        </div>

        <table class="tbdonhang modern">
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 25%;">Tên Nguyên Liệu</th>
                    <th style="width: 10%;">Đơn Vị</th>
                    <th style="width: 20%;">Giá Nhập (VNĐ)</th>
                    <th style="width: 20%;">Giá Xuất (VNĐ)</th>
                    <th style="width: 20%;">Thao tác</th>
                </tr>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['idNguyenLieu']; ?></td>
                            <td><strong><?php echo htmlspecialchars($row['TenNguyenLieu']); ?></strong></td>
                            <td><?php echo htmlspecialchars($row['DonViTinh']); ?></td>
                            <td>
                                <input type="number" class="price-input" id="gianhap_<?php echo $row['idNguyenLieu']; ?>" value="<?php echo intval($row['GiaNhap']); ?>" min="0" step="100">
                            </td>
                            <td>
                                <input type="number" class="price-input" id="giaxuat_<?php echo $row['idNguyenLieu']; ?>" value="<?php echo intval($row['GiaXuat']); ?>" min="0" step="100">
                            </td>
                            <td class="action-links">
                                <button class="btn-update" onclick="updatePrice(<?php echo $row['idNguyenLieu']; ?>)">
                                    <span class="material-symbols-outlined" style="font-size: 18px; vertical-align: middle;">save</span> Lưu
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" style="text-align: center;">Không tìm thấy nguyên liệu nào.</td></tr>
                <?php endif; ?>
        </table>
    </div>
    
    <script>
    function updatePrice(id) {
        const giaNhap = document.getElementById('gianhap_' + id).value;
        const giaXuat = document.getElementById('giaxuat_' + id).value;

        fetch('../PHP/process_update_prices.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + id + '&gianhap=' + giaNhap + '&giaxuat=' + giaXuat
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Cập nhật thành công!',
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: data.message
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Lỗi hệ thống',
                text: 'Không thể kết nối đến server.'
            });
        });
    }
    </script>
</body>
</html>