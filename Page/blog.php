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
      <a href="index.php">Trang chủ</a>
      <a href="blog.php" style="color: gray;">BLOG</a>
    </p>
  </div>
  <!--Blog-->
  <div class="blog">
    <div class="blogbox">
      <div class="col">
        <a href="blog_detail.php?id=1" class="blog-link">
          <div class="imgbox">
            <div class="img" style="background-image: url(../Pic/1.jpg);"></div>
          </div>
          <div class="text">
            <p>Tháng 2, 2023 ADMIN</p>
            <h3>Hành Trình Từ Hạt Cà Phê Đến Tách Cà Phê Đậm Đà</h3>
            <p>Mỗi tách cà phê bạn thưởng thức tại HIGHBUCKS đều bắt đầu từ một hành trình dài và kỳ công...</p>
          </div>
        </a>
      </div>

      <div class="col">
        <a href="blog_detail.php?id=2" class="blog-link">
          <div class="imgbox">
            <div class="img" style="background-image: url(../Pic/2.jpg);"></div>
          </div>
          <div class="text">
            <p>Tháng 2, 2023 ADMIN</p>
            <h3>Nghệ Thuật Pha Chế: Bí Quyết Đằng Sau Ly Espresso Hoàn Hảo</h3>
            <p>Espresso được mệnh danh là 'linh hồn' của mọi loại cà phê. Để tạo ra một ly espresso hoàn hảo...</p>
          </div>
        </a>
      </div>

      <div class="col">
        <a href="blog_detail.php?id=3" class="blog-link">
          <div class="imgbox">
            <div class="img" style="background-image: url(../Pic/3.jpg);"></div>
          </div>
          <div class="text">
            <p>Tháng 2, 2023 ADMIN</p>
            <h3>Không Gian HIGHBUCKS: Nơi Gặp Gỡ Và Khơi Nguồn Sáng Tạo</h3>
            <p>Chúng tôi tin rằng một quán cà phê không chỉ là nơi để uống. Đó là một không gian để gặp gỡ bạn bè...</p>
          </div>
        </a>
      </div>
    </div>

    <div class="blogbox">
      <div class="col">
        <a href="blog_detail.php?id=4" class="blog-link">
          <div class="imgbox">
            <div class="img" style="background-image: url(../Pic/4.jpg);"></div>
          </div>
          <div class="text">
            <p>Tháng 3, 2023 ADMIN</p>
            <h3>Cách Nhận Biết Cà Phê Sạch Và Nguyên Chất</h3>
            <p>Làm thế nào để phân biệt cà phê thật và cà phê pha tạp? Cùng HIGHBUCKS tìm hiểu một vài mẹo nhỏ...</p>
          </div>
        </a>
      </div>

      <div class="col">
        <a href="blog_detail.php?id=5" class="blog-link">
          <div class="imgbox">
            <div class="img" style="background-image: url(../Pic/5.jpg);"></div>
          </div>
          <div class="text">
            <p>Tháng 3, 2023 ADMIN</p>
            <h3>Thế Giới Bánh Ngọt Tại HIGHBUCKS</h3>
            <p>Khám phá thực đơn bánh ngọt đa dạng, được làm thủ công mỗi ngày từ những nguyên liệu tươi ngon nhất...</p>
          </div>
        </a>
      </div>

      <div class="col">
        <a href="blog_detail.php?id=6" class="blog-link">
          <div class="imgbox">
            <div class="img" style="background-image: url(../Pic/6.jpg);"></div>
          </div>
          <div class="text">
            <p>Tháng 4, 2023 ADMIN</p>
            <h3>Món Ăn Vặt Hoàn Hảo Cho Buổi Chiều</h3>
            <p>Từ khô gà lá chanh đến cơm cháy giòn rụm, đâu là món ăn vặt được yêu thích nhất tại quán?...</p>
          </div>
        </a>
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