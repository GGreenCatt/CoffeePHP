<?php
session_start();
include_once '../PHP/Connect.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['loggedin']) || $_SESSION['chucvu'] !== 'Quản lý') {
    header('Location: ../Page/index.php');
    exit();
}

if (isset($_GET['id'])) {
    $post_id = (int)$_GET['id'];

    $sql = "DELETE FROM blog_posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Bài viết đã được xóa thành công!";
    } else {
        $_SESSION['error'] = "Lỗi khi xóa bài viết: " . $conn->error;
    }
    $stmt->close();
}

mysqli_close($conn);

header('Location: ../Page/admin_blog.php');
exit();
?>
