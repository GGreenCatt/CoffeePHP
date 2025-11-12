<?php
session_start();
include_once '../PHP/Connect.php';

$post = null;
$page_title = "Blog";

// Lấy ID bài viết từ URL
$post_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($post_id) {
    $sql = "SELECT id, title, content, image_url, author, created_at FROM blog_posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
    $stmt->close();

    if ($post) {
        $page_title = $post['title'];
    } else {
        $page_title = "Không tìm thấy bài viết";
    }
} else {
    $page_title = "Không tìm thấy bài viết";
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?> - HIGHBUCKS</title>
    <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
    <link rel="stylesheet" href="../Css/blog.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        .blog-detail-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(0,0,0,0.7);
            border-radius: 8px;
            color: #ccc;
        }
        .blog-detail-header img {
            width: 70%;
            height: auto;
            border-radius: 8px;
            margin: 20px auto; /* Center the image and add top/bottom margin */
            display: block; /* Make it a block element to apply margin: auto */
        }
        .blog-detail-header h1 {
            font-size: 2.5em;
            color: #fff;
            margin-bottom: 10px;
        }
        .blog-meta {
            font-size: 0.9em;
            color: #c49a6c;
            margin-bottom: 30px;
        }
        .blog-content {
            font-family: 'Playfair Display', serif;
            font-size: 1.2em;
            line-height: 1.8;
            white-space: pre-wrap; /* Giữ lại các xuống dòng */
        }
    </style>
</head>
<body>
    <?php include '../PHP/Menu.php'; ?>

    <div class="banner">
        <h1>BLOG</h1>
        <p>
            <a href="index.php">Trang chủ</a> / 
            <a href="blog.php">Blog</a> / 
            <span style="color: gray;"><?php echo htmlspecialchars($page_title); ?></span>
        </p>
    </div>

    <div class="blog-detail-container">
        <?php if ($post): ?>
            <div class="blog-detail-header">
                <h1><?php echo htmlspecialchars($post['title'] ?? ''); ?></h1>
                <p class="blog-meta">
                    Đăng vào <?php echo date('F Y', strtotime($post['created_at'] ?? '')); ?> bởi <?php echo htmlspecialchars($post['author'] ?? ''); ?>
                </p>
                <img src="../Pic/<?php echo htmlspecialchars($post['image_url'] ?? 'placeholder.jpg'); ?>" alt="<?php echo htmlspecialchars($post['title'] ?? ''); ?>">
            </div>
            <div class="blog-content">
                <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
            </div>
        <?php else: ?>
            <h1>Không tìm thấy bài viết</h1>
            <p>Bài viết bạn đang tìm kiếm không tồn tại hoặc đã bị xóa. Vui lòng <a href="blog.php">quay lại trang blog</a>.</p>
        <?php endif; ?>
    </div>

    <?php include_once("../PHP/Footer.php"); ?>
</body>
</html>
