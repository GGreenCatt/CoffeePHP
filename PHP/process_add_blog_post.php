<?php
session_start();
include_once '../PHP/Connect.php';

$author = $_SESSION['hoten'] ?? 'ADMIN';

if (!isset($_SESSION['loggedin']) || $_SESSION['chucvu'] !== 'Quản lý') {
    header('Location: ../Page/index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $image_url = '';

    $has_validation_error = false;
    $validation_messages = [];

    if (empty($title)) {
        $validation_messages[] = "Tiêu đề bài viết không được để trống.";
        $has_validation_error = true;
    }
    if (empty($content)) {
        $validation_messages[] = "Nội dung bài viết không được để trống.";
        $has_validation_error = true;
    }

    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_name = $_FILES['image_file']['tmp_name'];
        $file_name = $_FILES['image_file']['name'];
        $file_size = $_FILES['image_file']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $max_file_size = 2 * 1024 * 1024;

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
        $validation_messages[] = "Lỗi tải lên file ảnh: " . $_FILES['image_file']['error'];
        $has_validation_error = true;
    }

    if (!$has_validation_error) {
        $sql = "INSERT INTO blog_posts (title, content, image_url, author) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssss", $title, $content, $image_url, $author);
            if ($stmt->execute()) {
                $_SESSION['blog_success'] = "Thêm bài viết mới thành công!";
            } else {
                $_SESSION['blog_error'] = "Lỗi khi thêm bài viết vào CSDL: " . $conn->error;
            }
            $stmt->close();
        } else {
            $_SESSION['blog_error'] = "Lỗi chuẩn bị câu lệnh SQL: " . $conn->error;
        }
    } else {
        $_SESSION['blog_error'] = implode('<br>', $validation_messages);
    }
    
    mysqli_close($conn);
    header('Location: ../Page/admin_blog.php');
    exit();
}
?>
