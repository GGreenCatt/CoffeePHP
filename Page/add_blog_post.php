<?php
session_start();
include_once '../PHP/Connect.php';

// Đảm bảo $author luôn có giá trị
$author = $_SESSION['hoten'] ?? 'ADMIN';

// Kiểm tra quyền admin
if (!isset($_SESSION['loggedin']) || $_SESSION['chucvu'] !== 'Quản lý') {
    header('Location: ../Page/index.php');
    exit();
}

$message = '';
$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $image_url = ''; // Mặc định là rỗng

    $has_validation_error = false; // Biến tổng thể để theo dõi lỗi
    $validation_messages = []; // Mảng để thu thập các thông báo lỗi

    // 1. Validate title and content
    if (empty($title)) {
        $validation_messages[] = "Tiêu đề bài viết không được để trống.";
        $has_validation_error = true;
    }
    if (empty($content)) {
        $validation_messages[] = "Nội dung bài viết không được để trống.";
        $has_validation_error = true;
    }

    // 2. Handle file upload
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_name = $_FILES['image_file']['tmp_name'];
        $file_name = $_FILES['image_file']['name'];
        $file_size = $_FILES['image_file']['size'];
        $file_type = $_FILES['image_file']['type'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $max_file_size = 2 * 1024 * 1024; // 2MB

        if (!in_array($file_ext, $allowed_extensions) || $file_size > $max_file_size) {
            $validation_messages[] = "File ảnh không hợp lệ (chỉ JPG, PNG, GIF, tối đa 2MB).";
            $has_validation_error = true;
        } else {
            $new_file_name = uniqid('blog_img_', true) . '.' . $file_ext;
            $upload_path = '../Pic/' . $new_file_name;

            if (move_uploaded_file($file_tmp_name, $upload_path)) {
                $image_url = $new_file_name;
            } else {
                $validation_messages[] = "Lỗi khi di chuyển file ảnh.";
                $has_validation_error = true;
            }
        }
    } elseif (isset($_FILES['image_file']) && $_FILES['image_file']['error'] !== UPLOAD_ERR_NO_FILE) {
        // Handle other upload errors (e.g., UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE)
        $validation_messages[] = "Lỗi tải lên file ảnh: " . $_FILES['image_file']['error'];
        $has_validation_error = true;
    }

    // 3. If no validation errors, proceed with database insertion
    if (!$has_validation_error) {
        $sql = "INSERT INTO blog_posts (title, content, image_url, author) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssss", $title, $content, $image_url, $author);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Thêm bài viết mới thành công!"; // Sử dụng session cho thông báo sau redirect
                header('Location: admin_blog.php');
                exit();
            } else {
                $message = "Lỗi khi thêm bài viết vào CSDL: " . $conn->error;
                $error = true; // Set local $error for display on current page
            }
            $stmt->close();
        } else {
            $message = "Lỗi chuẩn bị câu lệnh SQL: " . $conn->error;
            $error = true;
        }
    } else {
        // If there are validation errors, combine them into a single message for display
        $message = implode('<br>', $validation_messages);
        $error = true;
    }
}
mysqli_close($conn);
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
        .message { padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        .message.success { background-color: #2b442e; color: #a7d7b0; border: 1px solid #38573c; }
        .message.error { background-color: #4d2a2d; color: #e8a0a6; border: 1px solid #6e3b40; }
    </style>
</head>
<body>
    <?php include '../PHP/menu_dashboard.php'; ?>

    <div class="dashboard">
        <div class="main-header">
            <h1>Thêm Bài viết Blog Mới</h1>
        </div>

        <div class="form-container">
            <?php if ($message): ?>
                <div class="message <?php echo $error ? 'error' : 'success'; ?>"><?php echo $message; ?></div>
            <?php endif; ?>
            <form action="add_blog_post.php" method="POST" enctype="multipart/form-data">
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
