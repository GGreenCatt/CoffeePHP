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
  <?php include '../PHP/Menu.php' ?>
  <!------------------------------Banner galley---------------------------------->
  <div class="slideshow-container">
    <div class="mySlides"
      style="background-image: linear-gradient(rgba(0, 0, 0, 0.25), rgba(0, 0, 0, 0.25)),url(../Pic/bg_1.jpg);">
      <span class="welcomtxt">Chào Mừng</span>
      <h1>HIGHBUCKS COFFEE sẵn sàng & phục vụ</h1>
      <p>Khám phá hương vị mới mẻ tại quán cafe của chúng tôi, nơi mỗi giọt
        cà phê là một chuyến phiêu lưu đầy sáng tạo!</p>
      <span class="menu-buttom">
        <button class="buttom a">
          Đặt Hàng Ngay
        </button>
        <button class="buttom b">
          Xem Thực Đơn
        </button>
      </span>
    </div>

    <div class="mySlides"
      style="background-image: linear-gradient(rgba(0, 0, 0, 0.25), rgba(0, 0, 0, 0.25)),url(../Pic/bg_2.jpg);">
      <span class="welcomtxt">Chào Mừng</span>
      <h1>Hương Vị Tuyệt Vời & Vị Trí Đẹp</h1>
      <p>Khám phá hương vị mới mẻ tại quán cafe của chúng tôi, nơi mỗi giọt cà phê là một chuyến phiêu lưu đầy sáng tạo!
      </p>
      <span class="menu-buttom">
        <button class="buttom a">
          Đặt Hàng Ngay
        </button>
        <button class="buttom b">
          Xem Thực Đơn
        </button>
      </span>
    </div>

    <div class="mySlides"
      style="background-image: linear-gradient(rgba(0, 0, 0, 0.25), rgba(0, 0, 0, 0.25)),url(../Pic/bg_3.jpg);">
      <span class="welcomtxt">Chào Mừng</span>
      <h1>HIGHBUCKS COFFEE sẵn sàng & phục vụ</h1>
      <p>Khám phá hương vị mới mẻ tại quán cafe của chúng tôi, nơi mỗi giọt cà phê là một chuyến phiêu lưu đầy sáng tạo!
      </p>
      <span class="menu-buttom">
        <button class="buttom a">
          Đặt Hàng Ngay
        </button>
        <button class="buttom b">
          Xem Thực Đơn
        </button>
      </span>
    </div>

    <div class="dotcenter">
      <div style="text-align:center">
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
      </div>
    </div>
    <!------------------------------Banner Footer---------------------------------->
    <div class="banner-footer">
      <div class="info"><!--Thông tin-->
        <div class="box">
          <div class="content">
            <div class="icon">
              <span class="material-symbols-outlined">
                call
              </span>
            </div>
            <div class="text">
              <h3>+84 092 4482 940</h3>
              <p>Liên hệ với chúng tôi qua đường dây nóng</p>
            </div>
          </div>

          <div class="content">
            <div class="icon">
              <span class="material-symbols-outlined">
                my_location
              </span>
            </div>
            <div class="text">
              <h3>68 Nguyễn Chí Thanh</h3>
              <p></p>68 Nguyễn Chí Thanh,Láng Thượng,Đống Đa,Hà Nội
            </div>
          </div>

          <div class="content">
            <div class="icon">
              <span class="material-symbols-outlined">
                schedule
              </span>
            </div>
            <div class="text">
              <h3>Mở Cửa Từ Thứ Hai Đến Thứ Sáu</h3>
              <p>8 giờ sáng - 10 giờ tối</p>
            </div>
          </div>
        </div>
      </div>

      <div class="book"><!--Đặt lịch-->
        <h3>Đặt Bàn</h3>
        <form action="#">
          <div class="box">
            <div class="form">
              <input type="text" class="control" placeholder="Tên">
            </div>

            <div class="form m1">
              <input type="text" class="control" placeholder="Họ">
            </div>
          </div>

          <div class="box">
            <div class="form">
              <div class="inputwarp">
                <div class="icon">
                  <span class="material-symbols-outlined">event</span>
                </div>
                <input type="text" class="control" placeholder="Ngày">
              </div>
            </div>

            <div class="form m1">
              <div class="inputwarp">
                <div class="icon">
                  <span class="material-symbols-outlined">
                    schedule
                  </span>
                </div>
                <input type="text" class="control" placeholder="Thời Gian" autocomplete="off">
              </div>
            </div>

            <div class="form m1">
              <input type="text" class="control" placeholder="Số điện thoại">
            </div>
          </div>

          <div class="box">
            <div class="form">
              <textarea name="" id="" cols="30" rows="2" class="control" placeholder="Lời nhắn"></textarea>
            </div>

            <div class="form m1">
              <button class="submit"><a href="Page/contact.html">Đặt bàn</a></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!------------------------------Phần Câu chuyện---------------------------------->
  <div class="story">
    <div class="halfimg"></div>
    <div class="half">
      <div class="about">
        <span class="welcome">Khám Phá</span>
        <h2>Câu chuyện của chúng tôi</h2>
        <p>'Trong một góc phố yên bình, quán cà phê "Highbucks Coffee" tỏa ra một bức tranh
          thanh bình giữa cuộc
          sống hối hả. Bàn ghế gỗ nhẹ nhàng, tách cà phê nồng nàn, và âm nhạc nhẹ nhàng tạo nên không khí thư giãn.
          Tại đây, mỗi buổi sáng,khi chủ tiệm mở cửa đón khách. Câu chuyện của họ bắt đầu từ những ngày mưa, khi cô
          gái lạ mặt bước vào để tránh cơn mưa và trở thành khách hàng thường xuyên nhất.Chính trong "Góc Nhỏ," cô
          gái đó tìm thấy niềm vui trong từng trang sách và hương cà phê. Quán trở thành nơi quen thuộc, nơi những
          cuộc gặp gỡ giản đơn trở thành những khoảnh khắc đẹp nhất trong cuộc sống nhỏ bé của họ..'</p>
      </div>
    </div>
  </div>
  <!------------------------------Dịch vụ---------------------------------->
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
  <!------------------------------Menu của chúng tôi---------------------------------->
  <div class="service" style="background-color: transparent ;">
    <div class="box">
      <div class="row center">
        <div class="columleft">
          <div class="text">
            <span class="welcome">Xem Thêm</span>
            <h2>Thực đơn của chúng tôi</h2>
            <p>Quán cafe chúng tôi tự hào giới thiệu thực đơn đa dạng và phong phú, đem đến
              cho khách
              hàng trải nghiệm thưởng thức đặc sắc. Đối với người yêu cà phê, chúng tôi có các lựa chọn hương vị
              đa dạng từ cappuccino truyền thống đến espresso mạnh mẽ. Đồng thời, thực đơn của chúng tôi còn
              bao gồm nhiều đồ ăn và đồ uống đặc biệt để phục vụ khách hàng một cách chu đáo nhất </p>
            <p><a href="Page/coffee.html">Xem thực đơn</a></p>
          </div>
        </div>

        <div class="columright">
          <div class="rowright">
            <div class="colum">
              <div class="galley">
                <span class="img" style="background-image: url(../Pic/1.jpg);">
                </span>
              </div>
            </div>
            <div class="colum">
              <div class="galley">
                <span class="img mt-4" style="background-image: url(../Pic/2.jpg);">
                </span>
              </div>
            </div>
            <div class="colum">
              <div class="galley">
                <span class="img" style="background-image: url(../Pic/3.jpg);">
                </span>
              </div>
            </div>
            <div class="colum">
              <div class="galley">
                <span class="img mt-4" style="background-image: url(../Pic/4.jpg);">
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!------------------------------Đánh giá---------------------------------->
  <div class="rate">
    <div class="blackscreen"></div>
    <div class="contaner">
      <div class="flex">
        <div class="box">
          <div class="contentbox">
            <span class="material-symbols-outlined icon">
              star
            </span>
            <span class="animationbox"></span>
          </div>
          <div class="text">
            <h3><b>100</b></h3>
            <p>Chi nhánh</p>
          </div>
        </div>

        <div class="box">
          <div class="contentbox">
            <span class="material-symbols-outlined icon">
              star
            </span>
            <span class="animationbox"></span>
          </div>
          <div class="text">
            <h3><b>85</b></h3>
            <p>Số Giải Thưởng</p>
          </div>
        </div>

        <div class="box">
          <div class="contentbox">
            <span class="material-symbols-outlined icon">
              star
            </span>
            <span class="animationbox"></span>
          </div>
          <div class="text">
            <h3><b>10,567</b></h3>
            <p>Khách Hàng Vui Vẻ</p>
          </div>
        </div>

        <div class="box">
          <div class="contentbox">
            <span class="material-symbols-outlined icon">
              star
            </span>
            <span class="animationbox"></span>
          </div>
          <div class="text">
            <h3><b>900</b></h3>
            <p>Nhân Viên</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!------------------------------Best seller---------------------------------->
  <div class="seller">
    <div class="textbox">
      <div class="text">
        <span class="welcome">Khám phá</span>
        <h2>SẢN PHẨM BÁN CHẠY</h2>
        <p>Khám phá hương vị mới mẻ tại quán cafe của chúng tôi, nơi mỗi giọt cà phê là một chuyến phiêu lưu đầy sáng
          tạo!</p>
      </div>
    </div>
    <div class="foodbox">
      <div class="col">
        <div class="imgbox">
          <div class="img" style="background-image: url(../Pic/1.jpg);"></div>
        </div>
        <div class="text">
          <h3>Cà phê Capuccino</h3>
          <p>Mỗi tách cà phê được làm ra bởi các barista chuyên nghiệp</p>
          <p class="price">25.000 VNĐ</p>
          <p><a href="Page/cart.html" class="addcart">Đặt Mua Hàng</a></p>
        </div>
      </div>

      <div class="col">
        <div class="imgbox">
          <div class="img" style="background-image: url(../Pic/2.jpg);"></div>
        </div>
        <div class="text">
          <h3>Cà phê Espresso</h3>
          <p>Mỗi tách cà phê được làm ra bởi các barista chuyên nghiệp</p>
          <p class="price">25.000 VNĐ</p>
          <p><a href="Page/cart.html" class="addcart">Đặt Mua Hàng</a></p>
        </div>
      </div>

      <div class="col">
        <div class="imgbox">
          <div class="img" style="background-image: url(../Pic/3.jpg);"></div>
        </div>
        <div class="text">
          <h3>Cà phê sữa đá</h3>
          <p>Mỗi tách cà phê được làm ra bởi các barista chuyên nghiệp</p>
          <p class="price">25.000 VNĐ</p>
          <p><a href="Page/cart.html" class="addcart">Đặt Mua Hàng</a></p>
        </div>
      </div>

      <div class="col">
        <div class="imgbox">
          <div class="img" style="background-image: url(../Pic/4.jpg);"></div>
        </div>
        <div class="text">
          <h3>Cà phê Latte</h3>
          <p>Mỗi tách cà phê được làm ra bởi các barista chuyên nghiệp</p>
          <p class="price">25.000 VNĐ</p>
          <p><a href="Page/cart.html" class="addcart">Đặt Mua Hàng</a></p>
        </div>
      </div>
    </div>
  </div>

  <!------------------------------Footer---------------------------------->
  <?php include_once("../PHP/Footer.php") ?>
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