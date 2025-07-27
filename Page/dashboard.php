<?php
// Bắt đầu session và kết nối CSDL
session_start();
include_once '../PHP/Connect.php';

// --- TRUY VẤN DỮ LIỆU THỐNG KÊ ---

// 1. Thống kê chung (giữ nguyên)
$sql_revenue = "SELECT SUM(TongTien) as total_revenue FROM donhang WHERE TrangThai = 'Đã hoàn thành'";
$total_revenue = mysqli_fetch_assoc(mysqli_query($conn, $sql_revenue))['total_revenue'] ?? 0;
$sql_orders = "SELECT COUNT(idDonHang) as total_orders FROM donhang";
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, $sql_orders))['total_orders'] ?? 0;
$sql_products = "SELECT COUNT(idsanpham) as total_products FROM sanpham";
$total_products = mysqli_fetch_assoc(mysqli_query($conn, $sql_products))['total_products'] ?? 0;
$sql_customers = "SELECT COUNT(idTaiKhoan) as total_customers FROM taikhoan";
$total_customers = mysqli_fetch_assoc(mysqli_query($conn, $sql_customers))['total_customers'] ?? 0;

// --- DỮ LIỆU CHO BIỂU ĐỒ ---

// 2. **THAY ĐỔI**: Doanh thu theo ngày trong tuần
$day_of_week_revenue_sql = "
    SELECT 
        DAYOFWEEK(NgayDat) AS day_index, 
        SUM(TongTien) AS revenue
    FROM donhang
    WHERE TrangThai = 'Đã hoàn thành'
    GROUP BY DAYOFWEEK(NgayDat)
    ORDER BY day_index ASC
";
$day_of_week_result = mysqli_query($conn, $day_of_week_revenue_sql);

// Khởi tạo mảng 7 ngày trong tuần với doanh thu bằng 0
$days_vietnamese = ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'];
$revenue_by_day_data = array_fill(0, 7, 0);

while ($row = mysqli_fetch_assoc($day_of_week_result)) {
    // Cập nhật doanh thu cho ngày tương ứng (MySQL: 1=CN, 2=T2, ...)
    $day_index = $row['day_index'] - 1; // Chuyển về index của mảng (0-6)
    $revenue_by_day_data[$day_index] = $row['revenue'];
}

// 3. Top 5 sản phẩm bán chạy nhất (giữ nguyên)
$top_products_sql = "
    SELECT sp.TenSanPham, SUM(ct.SoLuong) AS total_sold
    FROM chitietdonhang ct
    JOIN sanpham sp ON ct.idSanPham = sp.idsanpham
    GROUP BY sp.TenSanPham
    ORDER BY total_sold DESC
    LIMIT 5
";
$top_products_result = mysqli_query($conn, $top_products_sql);

// 4. Tỷ lệ các danh mục sản phẩm (giữ nguyên)
$category_sales_sql = "
    SELECT sp.PhanLoai, SUM(ct.SoLuong) AS total_sold
    FROM chitietdonhang ct
    JOIN sanpham sp ON ct.idSanPham = sp.idsanpham
    GROUP BY sp.PhanLoai
    ORDER BY total_sold DESC
";
$category_sales_result = mysqli_query($conn, $category_sales_sql);
$category_labels = [];
$category_data = [];
while ($row = mysqli_fetch_assoc($category_sales_result)) {
    $category_labels[] = $row['PhanLoai'];
    $category_data[] = $row['total_sold'];
}

// 5. Lấy 5 đơn hàng gần đây nhất (giữ nguyên)
$sql_recent_orders = "SELECT idDonHang, TenNguoiNhan, NgayDat, TrangThai, TongTien FROM donhang ORDER BY NgayDat DESC LIMIT 5";
$recent_orders_result = mysqli_query($conn, $sql_recent_orders);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - HIGHBUCKS</title>
    <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../Css/css.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php include '../PHP/menu_dashboard.php' ?>
    <div class="dashboard">
        <h1>Chào mừng trở lại !</h1>
        <hr style="border: none; height: 1px; background-color: goldenrod;">
        
        <div class="box">
            <div class="card">
                <h1><?php echo number_format($total_revenue, 0, ',', '.'); ?></h1>
                <h3>Doanh thu (VNĐ)</h3>
                <span class="material-symbols-outlined dashboard_icon">sell</span>
            </div>
            <div class="card">
                <h1><?php echo $total_orders; ?></h1>
                <h3>Số đơn đã đặt</h3>
                <span class="material-symbols-outlined dashboard_icon">shopping_cart</span>
            </div>
            <div class="card">
                <h1><?php echo $total_products; ?></h1>
                <h3>Sản phẩm trong kho</h3>
                <span class="material-symbols-outlined dashboard_icon">inventory_2</span>
            </div>
            <div class="card">
                <h1><?php echo $total_customers; ?></h1>
                <h3>Số lượng khách hàng</h3>
                <span class="material-symbols-outlined dashboard_icon">person</span>
            </div>
        </div>

        <h2>Thống kê</h2>
        <div class="charts-row">
            <div class="chart-card">
                <h3>Doanh thu theo ngày trong tuần</h3>
                <canvas id="revenueChart"></canvas>
            </div>
            
            <div class="chart-card">
                <h3>Top 5 sản phẩm bán chạy</h3>
                <table class="tbdonhang compact">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đã bán</th>
                        </tr>
                        <?php mysqli_data_seek($top_products_result, 0); ?>
                        <?php while($row = mysqli_fetch_assoc($top_products_result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['TenSanPham']); ?></td>
                            <td><?php echo $row['total_sold']; ?></td>
                        </tr>
                        <?php endwhile; ?>
                </table>
            </div>

            <div class="chart-card">
                <h3>Tỷ lệ danh mục</h3>
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

        <h2>Các đơn đặt gần đây</h2>
        <table class="tbdonhang">

                <tr>
                    <th>Họ tên</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                    <th>Đơn giá</th>
                    <th></th>
                </tr>
                <?php if (mysqli_num_rows($recent_orders_result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($recent_orders_result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['TenNguoiNhan']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($row['NgayDat'])); ?></td>
                            <td><?php echo htmlspecialchars($row['TrangThai']); ?></td>
                            <td><?php echo number_format($row['TongTien'], 0, ',', '.'); ?> VNĐ</td>
                            <td class="action-links">
                                <a href="order_details_admin.php?id=<?php echo $row['idDonHang']; ?>">
                                    <span class="material-symbols-outlined">visibility</span>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">Chưa có đơn hàng nào.</td>
                    </tr>
                <?php endif; ?>
        </table>
    </div>

    <div class="copyright">Copyright © 2023 Dung. All rights reserved.</div>

    <script>
        // Dữ liệu từ PHP
        const revenueLabels = <?php echo json_encode($days_vietnamese); ?>;
        const revenueData = <?php echo json_encode($revenue_by_day_data); ?>;
        const categoryLabels = <?php echo json_encode($category_labels); ?>;
        const categoryData = <?php echo json_encode($category_data); ?>;

        // Biểu đồ Doanh thu (Bar chart)
        new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: {
                labels: revenueLabels,
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: revenueData,
                    backgroundColor: 'rgba(196, 154, 108, 0.7)'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#ffffff' } // **Chữ trục Y màu trắng**
                    },
                    x: {
                        ticks: { color: '#ffffff' } // **Chữ trục X màu trắng**
                    }
                },
                plugins: {
                    legend: {
                        labels: { color: '#ffffff' } // **Chữ chú thích màu trắng**
                    }
                }
            }
        });

        // Biểu đồ Tỷ lệ danh mục (Doughnut chart)
        new Chart(document.getElementById('categoryChart'), {
            type: 'doughnut',
            data: {
                labels: categoryLabels,
                datasets: [{
                    data: categoryData,
                    backgroundColor: ['#c49a6c', '#7f8c8d', '#a07d56', '#95a5a6', '#d35400'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: { color: '#ffffff' } // **Chữ chú thích màu trắng**
                    }
                }
            }
        });
    </script>
</body>
</html>