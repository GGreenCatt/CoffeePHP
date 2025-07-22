<?php
// Bắt đầu session và kết nối CSDL
session_start();
include_once '../PHP/Connect.php';

// --- LOGIC PHÂN TRANG ---
$results_per_page = 10; // Số sản phẩm mỗi trang

// Xác định trang hiện tại
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = (int)$_GET['page'];
}
$this_page_first_result = ($page - 1) * $results_per_page;

// --- LOGIC TÌM KIẾM ---
$search_query = "";
$base_sql = "FROM sanpham";
$params = [];
$types = "";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = $_GET['search'];
    $base_sql .= " WHERE TenSanPham LIKE ?";
    $search_term = "%" . $search_query . "%";
    $params[] = &$search_term;
    $types .= "s";
}

// Đếm tổng số sản phẩm (để tính số trang)
$count_sql = "SELECT COUNT(idsanpham) " . $base_sql;
$stmt_count = $conn->prepare($count_sql);
if (!empty($params)) {
    $stmt_count->bind_param($types, ...$params);
}
$stmt_count->execute();
$count_result = $stmt_count->get_result();
$total_results = $count_result->fetch_row()[0];
$number_of_pages = ceil($total_results / $results_per_page);

// Lấy dữ liệu cho trang hiện tại
$sql = "SELECT idsanpham, TenSanPham, GiaTien, PhanLoai, TrangThai " . $base_sql . " ORDER BY idsanpham LIMIT ?, ?";
$stmt = $conn->prepare($sql);

// Gắn tham số cho LIMIT
$params[] = &$this_page_first_result;
$params[] = &$results_per_page;
$types .= "ii";

if (!empty($search_query)) {
    $stmt->bind_param($types, $search_term, $this_page_first_result, $results_per_page);
} else {
    $stmt->bind_param($types, $this_page_first_result, $results_per_page);
}

$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!--Font-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
  <!-------->
  <!--Icon-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <!-------->
  <link rel="stylesheet" href="../Css/css.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kho</title>
  <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <?php include '../PHP/menu_dashboard.php' ?>
  <div class="dashboard">
    <div style="display: flex; justify-content: space-between;align-items: center;">
      <h2 style="display: inline;">Danh sách kho</h2>
      <a href="add_product.php" class="add_product_header">Thêm Sản Phẩm Mới</a>
    </div>
    <div class="search-container">
            <form action="Storage.php" method="GET">
                <input type="text" name="search" placeholder="Tìm kiếm theo tên sản phẩm..." value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit">
                    <span class="material-symbols-outlined">search</span>
                </button>
            </form>
    </div>

    <table class="tbdonhang">
      <tr>
        <th>ID</th>
        <th>Ảnh</th>
        <th>Tên sản phẩm</th>
        <th>Phân loại</th>
        <th>Giá cả</th>
        <th>Trạng thái</th>
        <th>Thao tác</th>
      </tr>
      <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?> 
                            <tr>
                                <td><?php echo $row['idsanpham']; ?></td>
                                <td><img src="../Pic/<?php echo $row['idsanpham']; ?>.jpg" alt="" width="100px" height="100px"></td>
                                <td><?php echo htmlspecialchars($row['TenSanPham']); ?></td>
                                <td><?php echo htmlspecialchars($row['PhanLoai']); ?></td>
                                <td><?php echo number_format($row['GiaTien'], 0, ',', '.'); ?> VNĐ</td>
                                <td><?php echo htmlspecialchars($row['TrangThai']); ?></td>
                                <td class="action-links">
                                <a href="edit_product.php?id=<?php echo $row['idsanpham']; ?>" title="Sửa sản phẩm">
                                    <span class="material-symbols-outlined icon-edit">edit</span>
                                </a>
                                <a href="../PHP/delete_product.php?id=<?php echo $row['idsanpham']; ?>" title="Xóa sản phẩm" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                    <span class="material-symbols-outlined icon-delete">delete</span>
                                </a>
                            </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">Chưa có sản phẩm nào.</td>
                        </tr>
                    <?php endif; ?>
    </table>
     <div class="pagination">
            <?php
            // Hiển thị các nút phân trang
            for ($i = 1; $i <= $number_of_pages; $i++) {
                // Thêm tham số tìm kiếm vào link phân trang nếu có
                $search_param = !empty($search_query) ? '&search=' . urlencode($search_query) : '';
                // Đánh dấu trang hiện tại là active
                $active_class = ($i == $page) ? 'active' : '';
                echo '<a href="Storage.php?page=' . $i . $search_param . '" class="' . $active_class . '">' . $i . '</a> ';
            }
            ?>
      </div>
  </div>



  <!------------------------------Footer---------------------------------->
    <div class="copyright">Copyright © 2023 Dung. All rights reserved.</div>
 <?php
    // Kiểm tra xem có thông báo thêm sản phẩm thành công không
    if (isset($_SESSION['add_product_success'])) {
        $message = $_SESSION['add_product_success'];
        
        // Hiển thị thông báo bằng SweetAlert
        echo "
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '" . addslashes($message) . "',
                showConfirmButton: false,
                timer: 2000, // Thông báo tự tắt sau 2 giây
                toast: true
            });
        </script>
        ";
        
        // Xóa thông báo khỏi session để không hiển thị lại
        unset($_SESSION['add_product_success']);
    }
    if (isset($_SESSION['delete_product_success'])) {
        echo "<script>Swal.fire({toast: true, position: 'top-end', icon: 'success', title: '" . addslashes($_SESSION['delete_product_success']) . "', showConfirmButton: false, timer: 2000});</script>";
        unset($_SESSION['delete_product_success']);
    }
        // **Kiểm tra và hiển thị thông báo SỬA**
    if (isset($_SESSION['edit_product_success'])) {
        echo "<script>Swal.fire({toast: true, position: 'top-end', icon: 'success', title: '" . addslashes($_SESSION['edit_product_success']) . "', showConfirmButton: false, timer: 2000});</script>";
        unset($_SESSION['edit_product_success']);
    }
    ?>
  <script>
    /*Hiệu ứng chuyển ảnh Banner tự động*/
    let slideIndex = 0;
    showSlides();
    function showSlides() {
      let i;
      let slides = document.getElementsByClassName("mySlides");
      let dots = document.getElementsByClassName("dot");
      for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
      }
      slideIndex++;
      if (slideIndex > slides.length) { slideIndex = 1 }
      for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex - 1].style.display = "block";
      dots[slideIndex - 1].className += " active";
      setTimeout(showSlides, 3000);
    }
    /*Hiệu ứng hiện thanh Menu khi lăn chuột xuống*/
    window.onscroll = function () { scrollFunction() };
    function scrollFunction() {
      if (document.body.scrollTop > 150 || document.documentElement.scrollTop > 150) {
        document.getElementById("navbar").style.top = "0";
      } else {
        document.getElementById("navbar").style.top = "-100px";
      }
    }
  </script>
</body>

</html>