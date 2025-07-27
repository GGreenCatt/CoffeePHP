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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HIGHBUCKS</title>
  <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
  <link rel="stylesheet" href="../Css/desserts.css">
</head>

<body>
  <!--Menu-->
  <?php include_once '../PHP/Connect.php'?>
  <?php 
    include '../PHP/Menu.php';
    $sql = "SELECT idsanpham, TenSanPham, GiaTien FROM sanpham WHERE PhanLoai = 'Tráng miệng'";
    $result = mysqli_query($conn, $sql);
  ?>
  <!--Banner-->
  <div class="banner">
    <h1>Tráng miệng</h1>
    <p>
      <a href="index.php">Trang chủ</a>
      <a href="desserts.php" style="color: gray;">Tráng miệng</a>
    </p>
  </div>
  <!--Coffee-->
  <div class="seller">
    <div class="textbox">
      <div class="text">
        <span class="welcome">Khám Phá</span>
        <h2>Tráng miệng</h2>
        <p>Khám phá những món tráng miệng đầy màu sắc và hương vị của Highbucks coffee</p>
      </div>
    </div>
    <div class="foodbox">
      <?php
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo
          "<div class='col'>".
          "<div class='imgbox'>".
            "<div class='img' style='background-image: url(../Pic/".$row["idsanpham"].".jpg);'></div>".
          "</div>".
          "<div class='text'>".
            "<h3><a href='Product_Detail.php?id=".$row['idsanpham']."'>".$row["TenSanPham"]."</a></h3>".
            "<p>Những chiếc bánh ngọt ngào thích mắt với đẩy đủ hương vị</p>".
            "<p class='price'>".$row["GiaTien"]." VNĐ</p>".
            "<p><button class='addcart' data-id=".$row['idsanpham'].">Đặt Mua Hàng</button></p>".
          "</div>".
        "</div>";
        }
      }
      ?>

    </div>
  </div>
  <!--Footer-->
  <?php include_once("../PHP/Footer.php") ?>
  <script>
    /*menu scroll*/
    window.onscroll = function () { scrollFunction() };
    function scrollFunction() {
      if (document.body.scrollTop > 150 || document.documentElement.scrollTop > 150) {
        document.getElementById("navbar").style.top = "0";
      } else {
        document.getElementById("navbar").style.top = "-100px";
      }
    }
    /*Food galley*/
    $(document).ready(function () {
      $('#list').click(function (event) { event.preventDefault(); $('#products .item').addClass('list-group-item'); });
      $('#grid').click(function (event) { event.preventDefault(); $('#products .item').removeClass('list-group-item'); $('#products .item').addClass('grid-group-item'); });
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const addToCartButtons = document.querySelectorAll('.addcart');

        addToCartButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                const productId = this.dataset.id;

                // Gửi yêu cầu AJAX
                fetch('../PHP/add_to_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id=' + productId
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Cập nhật số lượng trên icon giỏ hàng
                        document.getElementById('cart-item-count').textContent = data.cart_count;
                        document.getElementById('cart-item-count-fixed').textContent = data.cart_count;

                        // Hiển thị thông báo thành công
                        Swal.fire({
                            toast: true,
                            position: 'bottom-end',
                            icon: 'success',
                            title: 'Đã thêm vào giỏ hàng!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        // Hiển thị thông báo lỗi
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'Thêm thất bại!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    });
    </script>
</body>

</html>