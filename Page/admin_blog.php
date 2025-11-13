<?php
session_start();
include_once '../PHP/Connect.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['loggedin']) || $_SESSION['chucvu'] !== 'Quản lý') {
    header('Location: ../Page/index.php');
    exit();
}

// Lấy danh sách bài viết từ CSDL
$sql = "SELECT id, title, author, created_at FROM blog_posts ORDER BY created_at";
$result = mysqli_query($conn, $sql);
$posts = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Blog - Admin</title>
    <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
    <link rel="stylesheet" href="../Css/css.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .dashboard { padding: 150px 100px 0 100px; height: 100%; color: goldenrod; }
        .main-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .main-header h1 { margin: 0; color: #fff; }
        .main-header .btn-primary { background-color: goldenrod; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold; transition: background-color 0.3s; }
        .main-header .btn-primary:hover { background-color: #a07d56; }
        .tbdonhang { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .tbdonhang th, .tbdonhang td { padding: 12px; text-align: left; border-bottom: 1px solid #444; color: #ccc; }
        .tbdonhang th { background-color: rgba(196,154,98,255); color: white; }
        .tbdonhang tr:hover { background-color: rgba(50,50,50,0.5); }
        .action-links a { color: goldenrod; text-decoration: none; margin-right: 10px; }
        .action-links a:hover { text-decoration: underline; }
        .no-posts { text-align: center; padding: 30px; color: #ccc; }
    </style>
</head>
<body>
    <?php include '../PHP/menu_dashboard.php'; ?>

    <div class="dashboard">
        <div class="main-header">
            <h1>Quản lý Bài viết Blog</h1>
            <a href="add_blog_post.php" class="btn-primary">Thêm Bài viết Mới</a>
        </div>

        <?php if (!empty($posts)): ?>
            <table class="tbdonhang">
                    <tr>
                        <th>ID</th>
                        <th>Tiêu đề</th>
                        <th>Tác giả</th>
                        <th>Ngày đăng</th>
                        <th>Hành động</th>
                    </tr>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($post['id']); ?></td>
                            <td><?php echo htmlspecialchars($post['title']); ?></td>
                            <td><?php echo htmlspecialchars($post['author']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($post['created_at'])); ?></td>
                            <td class="action-links">
                                <a href="blog_detail.php?id=<?php echo $post['id']; ?>" target="_blank">Xem</a>
                                <a href="edit_blog_post.php?id=<?php echo $post['id']; ?>">Sửa</a>
                                <a href="#" onclick="confirmDelete(<?php echo $post['id']; ?>)">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p class="no-posts">Chưa có bài viết nào. Hãy thêm bài viết đầu tiên của bạn!</p>
        <?php endif; ?>
    </div>

    <div class="copyright">Copyright © 2023 Dung. All rights reserved.</div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa bài viết này?',
                text: "Hành động này không thể hoàn tác!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Vâng, xóa nó!',
                cancelButtonText: 'Hủy bỏ'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../PHP/process_delete_blog_post.php?id=' + id;
                }
            })
        }
    </script>
</body>
</html>
