<?php
// Bắt đầu session ở đầu tệp để có thể truy cập biến $_SESSION
session_start();
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
  <title>HIGHBUCKS</title>
  <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <?php include '../PHP/menu_dashboard.php' ?>
  <div class="dashboard">

    <h2>Danh sách kho</h2>
    <table class="tbdonhang">
      <tr>
        <th>Ảnh</th>
        <th>Tên sản phẩm</th>
        <th>Phân loại</th>
        <th>Giá cả</th>
        <th>Trạng thái</th>
        <th>Đã bán</th>
        <th>Thao tác</th>
      </tr>
      <tr>
        <td>Ảnh 1</td>
        <td>Cà phê</td>
        <td>Cà phê</td>
        <td>30.000VNĐ</td>
        <td>Hoạt động</td>
        <td>20</td>
        <td></td>
      </tr>
      <tr>
        <td>Ảnh 1</td>
        <td>Cà phê</td>
        <td>Cà phê</td>
        <td>30.000VNĐ</td>
        <td>Hoạt động</td>
        <td>20</td>
        <td></td>
      </tr>
    </table>
  </div>



  <!------------------------------Footer---------------------------------->
    <div class="copyright">Copyright © 2023 Dung. All rights reserved.</div>
<?php
  // Kiểm tra xem có thông báo đặt hàng thành công không
  if (isset($_SESSION['order_success'])) {
      $message = $_SESSION['order_success'];
      
      // Hiển thị thông báo bằng SweetAlert dạng toast (thông báo góc màn hình)
      echo "
      <script>
        const Toast = Swal.mixin({
          toast: true,
          position: 'cencer',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
          }
        });
        Toast.fire({
          icon: 'success',
          title: '" . addslashes($message) . "'
        });
      </script>
      ";
      
      // Xóa thông báo khỏi session để không hiển thị lại khi tải lại trang
      unset($_SESSION['order_success']);
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