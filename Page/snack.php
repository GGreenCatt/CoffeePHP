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
  <link rel="stylesheet" href="../Css/snack.css">
</head>

<body>
  <!--Menu-->
  <?php include_once '../PHP/Connect.php'?>
  <?php 
    include '../PHP/Menu.php';
    $sql = "SELECT idsanpham, TenSanPham, GiaTien FROM sanpham WHERE PhanLoai = 'Đồ ăn vặt'";
    $result = mysqli_query($conn, $sql);
  ?>
  <!--Banner-->
  <div class="banner">
    <h1>đồ ăn vặt của chúng tôi</h1>
    <p>
      <a href="../index.html">Trang chủ</a>
      <a href="snack.html" style="color: gray;">đồ ăn vặt</a>
    </p>
  </div>
  <!--snack-->
  <div class="seller">
    <div class="textbox">
      <div class="text">
        <span class="welcome">Khám Phá</span>
        <h2>Đồ ăn vặt</h2>
        <p>Với những món ăn vặt của chúng tôi bạn có thể vừa nhâm nhi cà phê và thưởng thức những món ăn vặt</p>
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
            "<p>Đồ ăn vặt thơm ngon chất lượng với nhiều hương vị</p>".
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
</body>

</html>