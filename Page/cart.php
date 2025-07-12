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
    <h1>Thanh toán</h1>
    <p>
      <a href="../index.html">Trang chủ</a>
      <a href="cart.html" style="color: gray;">Thanh toán</a>
    </p>
  </div>
  <!--Checkout-->
  <div class="checkout">
    <div class="row">
      <div class="col-75">
        <div class="container">
          <form action="">

            <div class="row">
              <div class="col-50">
                <h3>Thông tin thanh toán</h3>
                <label for="fname"><i class="fa fa-user"></i> Họ tên</label>
                <input type="text" id="fname" name="firstname">
                <label for="email"><i class="fa fa-envelope"></i> Email</label>
                <input type="text" id="email" name="email">
                <label for="adr"><i class="fa fa-address-card-o"></i> Địa chỉ</label>
                <input type="text" id="adr" name="address">
                <label for="city"><i class="fa fa-institution"></i> Thành phố</label>
                <input type="text" id="city" name="city">

                <div class="row">
                  <div class="col-50">
                    <label for="state">Quốc gia</label>
                    <input type="text" id="state" name="state">
                  </div>
                  <div class="col-50">
                    <label for="zip">Mã số thuế</label>
                    <input type="text" id="zip" name="zip">
                  </div>
                </div>
              </div>

              <div class="col-50">
                <h3>Thanh toán</h3>

                <label for="cname">Tên chủ thẻ</label>
                <input type="text" id="cname" name="cardname">
                <label for="ccnum">Mã thẻ</label>
                <input type="text" id="ccnum" name="cardnumber">
                <label for="expmonth">Tháng hết hạn</label>
                <input type="text" id="expmonth" name="expmonth">
                <div class="row">
                  <div class="col-50">
                    <label for="expyear">Năm hết hạn</label>
                    <input type="text" id="expyear" name="expyear">
                  </div>
                  <div class="col-50">
                    <label for="cvv">Mã CVV</label>
                    <input type="text" id="cvv" name="cvv">
                  </div>
                </div>
              </div>

            </div>
            <label>
              <input type="checkbox" checked="checked" name="sameadr"> Giao hàng theo địa chỉ hóa đơn
            </label>
            <input type="submit" value="Hoàn tất thanh toán" class="btn">
          </form>
        </div>
      </div>
      <div class="col-25">
        <div class="container">
          <h4>Giỏ hàng <span class="price" style="color:black"><i class="fa fa-shopping-cart" style="color: white;"></i>
              <b>4</b></span></h4>
          <p><a href="#">Cà Phê CAPUCCINO</a> <span class="price">20.000 VNĐ</span></p>
          <p><a href="#">Thịt Bò KOBE</a> <span class="price">100.000 VNĐ</span></p>
          <p><a href="#">Nước Cam</a> <span class="price">20.000 VNĐ</span></p>
          <p><a href="#">Nước Chanh Leo</a> <span class="price">20.000 VNĐ</span></p>
          <p><a href="#">Bánh Chocolate</a> <span class="price">15.000 VNĐ</span></p>
          <p><a href="#">Hạt Hướng Dương</a> <span class="price">10.000 VNĐ</span></p>
          <hr>
          <p>Total <span class="price" style="color:black"><b>185.000 VNĐ</b></span></p>
        </div>
      </div>
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