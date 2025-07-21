<?php
session_start();
include_once("../PHP/Connect.php");

// Kiểm tra xem ID sản phẩm có được truyền qua URL không
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Nếu không có ID, chuyển hướng về trang chủ
    header('Location: index.php');
    exit();
}

$id_san_pham = intval($_GET['id']);

// Truy vấn cơ sở dữ liệu để lấy thông tin chi tiết của sản phẩm
$sql = "SELECT idSanpham, TenSanPham, GiaTien FROM sanpham WHERE idsanpham = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_san_pham);
$stmt->execute();
$result = $stmt->get_result();

// Kiểm tra xem sản phẩm có tồn tại không
if ($result->num_rows === 0) {
    // Nếu sản phẩm không tồn tại, hiển thị thông báo lỗi
    echo "Sản phẩm không tồn tại.";
    exit();
}

$product = $result->fetch_assoc();
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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HIGHBUCKS</title>
  <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
  <link rel="stylesheet" href="../Css/service.css">
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <!--Menu-->
  <?php include '../PHP/Menu.php' ?>
  <!--Banner-->
  <div class="banner">
    <h1>Chi tiết sản phẩm</h1>
    <p>
      <a href="../index.html">TRANG CHỦ</a>
      <a href="service.html" style="color: gray;">CHI TIẾT SẢN PHẨM</a>
    </p>
  </div>
  <!--Service-->
  <div class="product_detail">
    <div class="box">
        <div class="col">
            <img src="../Pic/<?php echo $product["idSanpham"]; ?>.jpg" alt="" width="543px" height="538px">
        </div>
        <div class="col">
            <h1><?php echo $product["TenSanPham"] ?></h1>
            <h2 style="color: goldenrod;"><?php echo number_format($product['GiaTien'], 0, ',', '.'); ?> VNĐ</h2>
            <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.

On her way she met a copy. The copy warned the Little Blind Text, that where it came from it would have been rewritten a thousand times and everything that was left from its origin would be the word "and" and the Little Blind Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until a few insidious Copy Writers ambushed her, made her drunk with Longe and Parole and dragged her into their agency, where they abused her for their.</p>
            <label for="">Kích thước</label>
            <select name="kích thước" id="">
                <option value="Size S"> S</option>
                <option value=""> M</option>
                <option value=""> L</option>
            </select>
            <label for="">Số lượng</label>
            <input type="number" value="1" id="quantity" name="soluong" min="1">
            <button type="button" class="addcart" data-id="<?php echo $id_san_pham; ?>">Thêm vào giỏ hàng</button>
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
  <script>
    // Script AJAX để thêm vào giỏ hàng (tương tự trang coffee.php)
    document.querySelector('.addcart').addEventListener('click', function(event) {
        event.preventDefault();
        const productId = this.dataset.id;
        const quantity = document.getElementById('quantity').value;

        // Tạo form data để gửi cả id và số lượng
        const formData = new FormData();
        formData.append('id', productId);
        formData.append('soluong', quantity);

        fetch('../PHP/add_to_cart.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('cart-item-count').textContent = data.cart_count;
                document.getElementById('cart-item-count-fixed').textContent = data.cart_count;
                Swal.fire({
                    toast: true,
                    position: 'bottom-end',
                    icon: 'success',
                    title: 'Đã thêm vào giỏ hàng!',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    });
    </script>
</body>

</html>