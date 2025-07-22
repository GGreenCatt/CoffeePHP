<?php
session_start();
include_once '../PHP/Connect.php';

// Xử lý tìm kiếm
$search_query = "";
$sql = "SELECT idTaiKhoan, HoTen, sdt FROM taikhoan";

// Nếu có từ khóa tìm kiếm được gửi lên
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = $_GET['search'];
    // Thêm điều kiện WHERE để tìm kiếm theo Họ Tên hoặc SĐT
    $sql .= " WHERE HoTen LIKE ? OR sdt LIKE ?";
}

$sql .= " ORDER BY idTaiKhoan DESC";

// Chuẩn bị và thực thi câu lệnh
$stmt = $conn->prepare($sql);

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = "%" . $search_query . "%";
    // Gán 2 lần cho 2 dấu ? (HoTen và sdt)
    $stmt->bind_param("ss", $search_term, $search_term);
}

$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Khách Hàng</title>
    <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
    <link rel="stylesheet" href="../Css/css.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <div class="admin-container">
        <?php include_once __DIR__ . '/../PHP/menu_dashboard.php'; ?>

        <div class="dashboard">
            <div class="main-header">
                <h2>Quản Lý Khách Hàng</h2>
            </div>

            <div class="search-container">
                <form action="customers.php" method="GET">
                    <input type="text" name="search" placeholder="Tìm theo tên hoặc SĐT khách hàng..." value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit">
                        <span class="material-symbols-outlined">search</span>
                    </button>
                </form>
            </div>
            
            <table class="tbdonhang">
                    <tr>
                        <th>ID Khách Hàng</th>
                        <th>Họ Tên</th>
                        <th>Số Điện Thoại Đăng Ký</th>
                        <th>Thao tác</th>
                    </tr>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo $row['idTaiKhoan']; ?></td>
                                <td><?php echo htmlspecialchars($row['HoTen']); ?></td>
                                <td><?php echo htmlspecialchars($row['sdt']); ?></td>
                                <td class="action-links">
                                    <a href="customer_details.php?id=<?php echo $row['idTaiKhoan']; ?>" title="Xem chi tiết khách hàng">
                                        <span class="material-symbols-outlined">visibility</span>
                                    </a>
                                    <a href="#" title="Xóa tài khoản" onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng này?');">
                                        <span class="material-symbols-outlined icon-delete">delete</span>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center;">Chưa có khách hàng nào đăng ký.</td>
                        </tr>
                    <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>
<?php mysqli_close($conn); ?>