<?php
session_start();
// Kiểm tra quyền admin
if (!isset($_SESSION['loggedin']) || $_SESSION['chucvu'] !== 'Quản lý') {
    header('Location: ../Page/index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Bài viết Blog - Admin</title>
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
    </style>
</head>
<body>
    <?php include '../PHP/menu_dashboard.php'; ?>

    <div class="dashboard">
        <div class="main-header">
            <h1>Thêm Bài viết Blog Mới</h1>
        </div>

        <div class="form-container">
            <form action="../PHP/process_add_blog_post.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Tiêu đề bài viết</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="image_file">Chọn Hình ảnh</label>
                    <input type="file" id="image_file" name="image_file" accept="image/*">
                    <small style="color: #aaa;">Chỉ chấp nhận file ảnh (JPG, PNG, GIF). Kích thước tối đa 2MB.</small>
                </div>
                <div class="form-group">
                    <label for="content">Nội dung bài viết</label>
                    <textarea id="content" name="content" required></textarea>
                </div>
                <div class="form-actions">
                    <a href="admin_blog.php" class="btn-cancel">Hủy</a>
                    <button type="submit" class="btn-submit">Thêm Bài viết</button>
                </div>
            </form>
        </div>
    </div>

    <div class="copyright">Copyright © 2023 Dung. All rights reserved.</div>
</body>
</html>