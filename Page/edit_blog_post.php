<?php
session_start();
include_once '../PHP/Connect.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['loggedin']) || $_SESSION['chucvu'] !== 'Quản lý') {
    header('Location: ../Page/index.php');
    exit();
}

$message = '';
$error = false;
$post = null;

$post_id = $_GET['id'] ?? 0;

// Lấy thông tin bài viết để hiển thị vào form
if ($post_id) {
    $sql = "SELECT id, title, content, image_url, author FROM blog_posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
    $stmt->close();

    if (!$post) {
        $message = "Không tìm thấy bài viết.";
        $error = true;
    }
} else {
    $message = "ID bài viết không hợp lệ.";
    $error = true;
}

// Xử lý khi form được gửi đi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $post_id && $post) {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $image_url = $_POST['image_url'] ?? '';
    // Author không thay đổi khi chỉnh sửa

    if (empty($title) || empty($content)) {
        $message = "Tiêu đề và nội dung không được để trống.";
        $error = true;
    } else {
        $sql = "UPDATE blog_posts SET title = ?, content = ?, image_url = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $title, $content, $image_url, $post_id);

        if ($stmt->execute()) {
            $message = "Cập nhật bài viết thành công!";
            $error = false;
            // Cập nhật lại dữ liệu $post để hiển thị thông tin mới nhất
            $post['title'] = $title;
            $post['content'] = $content;
            $post['image_url'] = $image_url;
        } else {
            $message = "Lỗi khi cập nhật bài viết: " . $conn->error;
            $error = true;
        }
        $stmt->close();
    }
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa Bài viết Blog - Admin</title>
    <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
    <link rel="stylesheet" href="../Css/css.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        .dashboard { padding: 150px 100px 0 100px; height: 100%; color: goldenrod; }
        .main-header { margin-bottom: 30px; }
        .main-header h1 { margin: 0; color: #fff; }
        .form-container { background: rgba(37,37,36,255); padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border: 1px solid #444; color: #ccc; max-width: 800px; margin: 20px auto; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: bold; color: goldenrod; }
        .form-group input[type="text"], .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #555;
            border-radius: 5px;
            background-color: #333;
            color: #fff;
            font-size: 16px;
        }
        .form-group textarea { min-height: 200px; resize: vertical; }
        .form-actions { text-align: right; }
        .btn-submit { background-color: goldenrod; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; transition: background-color 0.3s; margin-left: 10px; }
        .btn-submit:hover { background-color: #a07d56; }
        .btn-cancel { background-color: #6c757d; color: white; padding: 10px 20px; border: none; border-radius: 5px; text-decoration: none; font-weight: bold; transition: background-color 0.3s; }
        .btn-cancel:hover { background-color: #5a6268; }
        .message { padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        .message.success { background-color: #2b442e; color: #a7d7b0; border: 1px solid #38573c; }
        .message.error { background-color: #4d2a2d; color: #e8a0a6; border: 1px solid #6e3b40; }
    </style>
</head>
<body>
    <?php include '../PHP/menu_dashboard.php'; ?>

    <div class="dashboard">
        <div class="main-header">
            <h1>Chỉnh sửa Bài viết Blog</h1>
        </div>

        <div class="form-container">
            <?php if ($message): ?>
                <div class="message <?php echo $error ? 'error' : 'success'; ?>"><?php echo $message; ?></div>
            <?php endif; ?>
            
            <?php if ($post): ?>
                <form action="edit_blog_post.php?id=<?php echo $post['id']; ?>" method="POST">
                    <div class="form-group">
                        <label for="title">Tiêu đề bài viết</label>
                        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="image_url">URL Hình ảnh (ví dụ: 1.jpg, 2.jpg)</label>
                        <input type="text" id="image_url" name="image_url" value="<?php echo htmlspecialchars($post['image_url']); ?>" placeholder="Nhập tên file ảnh trong thư mục Pic/">
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung bài viết</label>
                        <textarea id="content" name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea>
                    </div>
                    <div class="form-actions">
                        <a href="admin_blog.php" class="btn-cancel">Hủy</a>
                        <button type="submit" class="btn-submit">Cập nhật Bài viết</button>
                    </div>
                </form>
            <?php else: ?>
                <p>Không thể tải bài viết để chỉnh sửa.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="copyright">Copyright © 2023 Dung. All rights reserved.</div>
</body>
</html>
