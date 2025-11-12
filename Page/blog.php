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
    <?php
    include_once '../PHP/Connect.php';
    $sql = "SELECT id, title, image_url, author, created_at, SUBSTRING(content, 1, 150) as content_preview FROM blog_posts ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    $post_count = 0;
    if (mysqli_num_rows($result) > 0) {
        echo '<div class="blogbox">'; // Mở blogbox đầu tiên
        while ($post = mysqli_fetch_assoc($result)) {
            echo '<div class="col">';
            echo '<a href="blog_detail.php?id=' . $post['id'] . '" class="blog-link">';
            echo '<div class="imgbox">';
            echo '<div class="img" style="background-image: url(../Pic/' . htmlspecialchars($post['image_url']) . ');"></div>';
            echo '</div>';
            echo '<div class="text">';
            echo '<p>' . date('F Y', strtotime($post['created_at'])) . ' ' . htmlspecialchars($post['author']) . '</p>';
            echo '<h3>' . htmlspecialchars($post['title']) . '</h3>';
            echo '<p>' . htmlspecialchars($post['content_preview']) . '...</p>';
            echo '</div>';
            echo '</a>';
            echo '</div>';
            $post_count++;
            if ($post_count % 3 == 0) {
                echo '</div><div class="blogbox">'; // Đóng blogbox hiện tại và mở cái mới sau mỗi 3 bài
            }
        }
        echo '</div>'; // Đóng blogbox cuối cùng
    } else {
        echo '<p style="text-align: center; width: 100%; color: #ccc;">Chưa có bài viết nào.</p>';
    }
    mysqli_close($conn);
    ?>

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