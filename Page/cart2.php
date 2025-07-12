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
  <link rel="stylesheet" href="../Css/cart.css">
</head>

<body>
  <!--Menu-->
  <div class="navbar">
    <div class="brand">
      <a href="../index.html" class="brand-link">HIGHBUCKS<br>
        <small>COFFEE</small>
      </a>
    </div>

    <div class="navbar-m1">
      <a class="nav-link " href="../index.html">trang chủ</a>
      <div class=" nav-link dropdown ">
        thực đơn<span class="material-symbols-outlined">arrow_drop_down</span>
        <div class="dropdown-content">
          <a href="coffee.html">cafe</a>
          <a href="main-dish.html">món chính</a>
          <a href="drinks.html">đồ uống khác</a>
          <a href="desserts.html">tráng miệng</a>
          <a href="snack.html">đồ ăn vặt</a>
        </div>
      </div>
      <a class="nav-link" href="service.html">dịch vụ</a>
      <a class="nav-link" href="blog.html">blog</a>
      <a class="nav-link" href="about.html">giới thiệu</a>
      <a class="nav-link" href="contact.html">liên hệ</a>
      <a class="nav-link activemenu" href="cart.html">
        <span class="material-symbols-outlined">
          shopping_cart
        </span>
      </a>
    </div>
  </div>
  <!--Menu fixed-->
  <div id="navbar" class="navbar fixed">
    <div class="brand">
      <a href="../index.html" class="brand-link">HIGHBUCKS<br>
        <small>COFFEE</small>
      </a>
    </div>

    <div class="navbar-m1">
      <a class="nav-link " href="../index.html">trang chủ</a>
      <div class=" nav-link dropdown">
        thực đơn<span class="material-symbols-outlined">arrow_drop_down</span>
        <div class="dropdown-content">
          <a href="coffee.html">cafe</a>
          <a href="main-dish.html">món chính</a>
          <a href="drinks.html">đồ uống khác</a>
          <a href="desserts.html">tráng miệng</a>
          <a href="snack.html">đồ ăn vặt</a>
        </div>
      </div>
      <a class="nav-link" href="service.html">dịch vụ</a>
      <a class="nav-link" href="blog.html">blog</a>
      <a class="nav-link" href="about.html">giới thiệu</a>
      <a class="nav-link" href="contact.html">liên hệ</a>
      <a class="nav-link activemenu" href="cart.html">
        <span class="material-symbols-outlined">
          shopping_cart
        </span>
      </a>
    </div>
  </div>
  <!--Banner-->
  <div class="banner">
    <h1>Giỏ hàng</h1>
    <p>
      <a href="../index.html">Trang chủ</a>
      <a href="cart.html" style="color: gray;">Giỏ hàng</a>
    </p>
  </div>
  <!--Cart-->
  <div class="cart">
    <div class="cart_list">
        <table>
            <tr>
                <th style="width: 9%;">&nbsp</th>
                <th style="width: 19%;">&nbsp</th>
                <th>Sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th style="width: 15%;">Thành tiền</th>
            </tr>
            <tr>
                <td>X</td>
                <td>Anh</td>
                <td>aoihfoawhfoiiawawdaw</td>
                <td>50K</td>
                <td style="color: goldenrod;"> 1 </td>
                <td>50K</td>
            </tr>
        </table>
    </div>
        <div class="cart_total">
            <div class="box">
            <h2 style="color: white;">Tổng tiền</h2>
            <table>
                <tr>
                    <td>Tạm tính:</td>
                    <td>50.000VNĐ</td>
                </tr>
                <tr>
                    <td>Phí ship:</td>
                    <td>30.000VNĐ</td>
                </tr>
                <tr>
                    <td>Giảm giá:</td>
                    <td>10.000VNĐ</td>
                </tr>
                <tr>
                    <td style="border-top: 1px solid gray;">Tổng cộng:</td>
                    <td style="border-top: 1px solid gray; color: goldenrod;">70.000VNĐ</td>
                </tr>
            </table>
            </div>

            <button> Tiến hành thanh toán</button>
        </div>
  </div>
  <!--Footer-->
  <div class="footer">
    <div class="contaner">
      <div class="row">
        <div class="content">
          <div class="text">
            <h2>về chúng tôi</h2>
            <p>Highbucks Coffee, với sứ mệnh tạo ra những tách cà phê đầy nhiệt huyết bởi các barista, giúp người uống
              thưởng thức được tinh hoa của cà phê</p>
          </div>
          <audio src="../Audio/chill.mp3" loop autoplay controls></audio>
          <a href="https://www.facebook.com" class="fa fa-facebook"></a>
          <a href="https://www.youtube.com" class="fa fa-youtube"></a>
          <a href="https://www.instagram.com" class="fa fa-instagram"></a>
        </div>

        <div class="content">
          <div class="text">
            <h2>blog gần đây</h2>
            <div class="block-01">
              <a class="block-img" style="background-image: url(../Pic/image_1.jpg);"></a>
              <div class="block-text">
                Cách pha một tách cà phê chuẩn barista
              </div>
            </div>

            <div class="block-01">
              <a class="block-img" style="background-image: url(../Pic/image_2.jpg);"></a>
              <div class="block-text">
                Giá trị tinh hoa của cà phê là gì?
              </div>
            </div>
          </div>
        </div>

        <div class="content">
          <div class="text">
            <h2>Dịch vụ</h2>
            <div class="p-01">
              <p>Nấu</p>
              <p>Vận chuyển</p>
              <p>Chất lượng</p>
              <p>Trộn</p>
            </div>
          </div>
        </div>

        <div class="content">
          <div class="text">
            <h2>Thông tin liên hệ</h2>
            <div class="block-02">
              <ul>
                <li><span class="icon material-symbols-outlined">pin_drop</span>
                  <span class="text">68 Nguyễn Chí Thanh,Láng Thượng,Đống Đa,Hà Nội</span>
                </li>

                <li><span class="icon material-symbols-outlined">
                    call
                  </span>
                  <span class="text">+84 092 4482 940</span>
                </li>

                <li><span class="icon material-symbols-outlined">mail</span>
                  <span class="text">highbucks@gmail.com</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="copyright">Copyright © 2023 Dung. All rights reserved.</div>
  </div>

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