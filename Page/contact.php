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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="../Css/contact.css">
</head>

<body>
  <!--Menu-->
  <?php include '../PHP/Menu.php' ?>
  <!--Banner-->
  <div class="banner">
    <h1>Liên hệ</h1>
    <p>
      <a href="index.php">TRANG CHỦ</a>
      <a href="contact.php" style="color: gray;">LIÊN HỆ</a>
    </p>
  </div>
  <!--Contact-->
  <div class="contact">
    <div class="container">
      <div class="box">
        <div class="row">
          <div class="col-01">
            <h2>THÔNG TIN LIÊN HỆ</h2>
          </div>
          <div class="col-01">
            <p>
              <span>Địa chỉ: </span>68 Nguyễn Chí Thanh,Láng Thượng,Đống Đa,Hà Nội
            </p>
          </div>
          <div class="col-01">
            <p>
              <span>Điện thoại: </span><a>+84 092 4482 940</a>
            </p>
          </div>
          <div class="col-01">
            <p>
              <span>Email: </span><a>highbucks@gmail.com</a>
            </p>
          </div>
          <div class="col-01">
            <p>
              <span>Website: </span><a>highbucks.com</a>
            </p>
          </div>
        </div>
      </div>

      <div class="box">
        <div class="book">
          <h3>Đặt bàn</h3>
          <form action="../PHP/process_booking.php" method="POST">
            <div class="box">
              <div class="form">
                <input type="text" class="control" name="HoTen" placeholder="Họ và Tên" required>
              </div>

              <div class="form m1">
                <input type="text" class="control" name="sdt" placeholder="Số điện thoại" required>
              </div>
            </div>

            <div class="box">
              <div class="form">
                <div class="inputwarp">
                  <div class="icon">
                    <span class="material-symbols-outlined">event</span>
                  </div>
                  <input type="text" id="ngaydat-picker" class="control" name="NgayDat" placeholder="Chọn ngày..." required>
                </div>
              </div>

              <div class="form m1">
                <div class="inputwarp">
                  <div class="icon">
                    <span class="material-symbols-outlined">
                      schedule
                    </span>
                  </div>
                  <input type="text" id="giodat-picker" class="control" name="GioDat" placeholder="Chọn giờ..." required>
                </div>
              </div>

              <div class="form m1">
                <input type="number" class="control" name="SoNguoi" placeholder="Số người" required min="1">
              </div>
            </div>

            <div class="box">
              <div class="form">
                <textarea name="GhiChu" id="" cols="30" rows="2" class="control" placeholder="Ghi chú"></textarea>
              </div>

              <div class="form m1">
                <input type="submit" value="Hoàn tất" class="submit">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!--Footer-->
  <?php include_once("../PHP/Footer.php") ?>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <?php
  if (isset($_SESSION['booking_success'])) {
      echo "<script>
              Swal.fire({
                  title: 'Thành công!',
                  text: '" . addslashes($_SESSION['booking_success']) . "',
                  icon: 'success',
                  confirmButtonText: 'OK'
              });
            </script>";
      unset($_SESSION['booking_success']);
  }
  ?>

  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    flatpickr("#ngaydat-picker", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "d/m/Y",
        minDate: "today"
    });
    flatpickr("#giodat-picker", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });
  </script>

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