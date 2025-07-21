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
  <link rel="stylesheet" href="../Css/blog.css">
</head>

<body>
  <?php include '../PHP/Menu.php' ?>
  <!--Banner-->
  <div class="banner">
    <h1>BLOG</h1>
    <p>
      <a href="../index.html">Trang chủ</a>
      <a href="blog.html" style="color: gray;">BLOG</a>
    </p>
  </div>
  <!--Blog-->
  <div class="blog">
    <div class="blogbox">
      <div class="col">
        <div class="imgbox">
          <div class="img" style="background-image: url(../Pic/image_1.jpg);"></div>
        </div>
        <div class="text">
          <p>Tháng 2, 2023 ADMIN</p>
          <h3>Trải nghiệm về quán cafe</h3>
          <p>Đây là một BLOG trải nghiệm về quán và ghi chép các thông tin liên quan.</p>
        </div>
      </div>

      <div class="col">
        <div class="imgbox">
          <div class="img" style="background-image: url(../Pic/image_2.jpg);"></div>
        </div>
        <div class="text">
          <p>Tháng 2, 2023 ADMIN</p>
          <h3>Trải nghiệm về quán cafe </h3>
          <p>Đây là một BLOG trải nghiệm về quán và ghi chép các thông tin liên quan.</p>
        </div>
      </div>

      <div class="col">
        <div class="imgbox">
          <div class="img" style="background-image: url(../Pic/image_3.jpg);"></div>
        </div>
        <div class="text">
          <p>Tháng 2, 2023 ADMIN</p>
          <h3>Trải nghiệm về quán cafe</h3>
          <p>Đây là một BLOG trải nghiệm về quán và ghi chép các thông tin liên quan.</p>
        </div>
      </div>
    </div>

    <div class="blogbox">
      <div class="col">
        <div class="imgbox">
          <div class="img" style="background-image: url(../Pic/image_4.jpg);"></div>
        </div>
        <div class="text">
          <p>Tháng 2, 2023 ADMIN</p>
          <h3>Trải nghiệm về quán cafe</h3>
          <p>Đây là một BLOG trải nghiệm về quán và ghi chép các thông tin liên quan.</p>
        </div>
      </div>

      <div class="col">
        <div class="imgbox">
          <div class="img" style="background-image: url(../Pic/image_5.jpg);"></div>
        </div>
        <div class="text">
          <p>Tháng 2, 2023 ADMIN</p>
          <h3>Trải nghiệm về quán cafe</h3>
          <p>Đây là một BLOG trải nghiệm về quán và ghi chép các thông tin liên quan.</p>
        </div>
      </div>

      <div class="col">
        <div class="imgbox">
          <div class="img" style="background-image: url(../Pic/image_6.jpg);"></div>
        </div>
        <div class="text">
          <p>Tháng 2, 2023 ADMIN</p>
          <h3>Trải nghiệm về quán cafe</h3>
          <p>Đây là một BLOG trải nghiệm về quán và ghi chép các thông tin liên quan.</p>
        </div>
      </div>
    </div>

    <div class="pagination">
      <a href="#">&laquo;</a>
      <a href="#" class="active">1</a>
      <a href="#">2</a>
      <a href="#">3</a>
      <a href="#">4</a>
      <a href="#">5</a>
      <a href="#">6</a>
      <a href="#">&raquo;</a>
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