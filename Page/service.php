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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HIGHBUCKS</title>
  <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
  <link rel="stylesheet" href="../Css/service.css">
</head>

<body>
  <!--Menu-->
  <?php include '../PHP/Menu.php' ?>
  <!--Banner-->
  <div class="banner">
    <h1>DỊCH VỤ</h1>
    <p>
      <a href="index.php">TRANG CHỦ</a>
      <a href="service.php" style="color: gray;">DỊCH VỤ</a>
    </p>
  </div>
  <!--Service-->
  <div class="service">
    <div class="box">
      <div class="row">
        <div class="content">
          <div class="contentbox">
            <div class="icon">
              <span class="material-symbols-outlined size">
                list_alt
              </span>
            </div>
            <div class="text">
              <h3>Dễ ràng đặt hàng</h3>
              <p>Bạn có thể đặt hàng một cách nhanh chóng không mất thời gian cả trực tiếp lẫn trực tuyến.</p>
            </div>
          </div>
        </div>

        <div class="content">
          <div class="contentbox">
            <div class="icon">
              <span class="material-symbols-outlined size">
                local_shipping
              </span>
            </div>
            <div class="text">
              <h3>Giao hàng nhanh</h3>
              <p>Đơn vị vận chuyển của chúng tôi sẽ cố gắng giao hàng nhanh nhất cho khách hàng.</p>
            </div>
          </div>
        </div>

        <div class="content">
          <div class="contentbox">
            <div class="icon">
              <span class="material-symbols-outlined size">
                emoji_food_beverage
              </span>
            </div>
            <div class="text">
              <h3>Cafe chất lượng</h3>
              <p>Bạn sẽ được thưởng thức những ly cafe chất lượng và các món khác trong thực đơn .
              </p>
            </div>
          </div>
        </div>
      </div>
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
  </script>
</body>

</html>