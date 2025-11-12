<?php
session_start();

// Dữ liệu blog mẫu (thay thế cho CSDL)
$posts = [
    1 => [
        'title' => 'Hành Trình Từ Hạt Cà Phê Đến Tách Cà Phê Đậm Đà',
        'image' => '1.jpg',
        'date' => 'Tháng 2, 2023',
        'author' => 'ADMIN',
        'content' => "Mỗi tách cà phê bạn thưởng thức tại HIGHBUCKS đều bắt đầu từ một hành trình dài và kỳ công. Chúng tôi lựa chọn những hạt cà phê Arabica và Robusta chất lượng nhất từ những vùng cao nguyên trứ danh của Việt Nam. Hạt cà phê được hái chín, lựa chọn cẩn thận và sơ chế theo quy trình nghiêm ngặt để giữ lại hương vị nguyên bản.\n\nTại xưởng rang của chúng tôi, những người thợ rang tài hoa sẽ biến những hạt cà phê xanh thành những hạt nâu bóng, tỏa hương thơm nồng nàn. Quá trình rang được kiểm soát nhiệt độ và thời gian một cách chính xác để phát triển tối đa tiềm năng hương vị của từng loại hạt. Cuối cùng, các barista chuyên nghiệp của chúng tôi sẽ xay và pha chế để tạo ra những tách cà phê đậm đà, đánh thức mọi giác quan của bạn."
    ],
    2 => [
        'title' => 'Nghệ Thuật Pha Chế: Bí Quyết Đằng Sau Ly Espresso Hoàn Hảo',
        'image' => '2.jpg',
        'date' => 'Tháng 2, 2023',
        'author' => 'ADMIN',
        'content' => "Espresso được mệnh danh là 'linh hồn' của mọi loại cà phê. Để tạo ra một ly espresso hoàn hảo, không chỉ cần hạt cà phê ngon mà còn đòi hỏi kỹ thuật và sự chính xác tuyệt đối. Barista của chúng tôi phải điều chỉnh độ mịn của bột cà phê, lực nén, nhiệt độ nước và áp suất máy pha một cách hoàn hảo.\n\nMột shot espresso chuẩn phải có lớp crema màu caramel dày mịn ở trên, vị đắng đậm nhưng không gắt, xen lẫn vị chua thanh và hậu vị ngọt ngào. Đó là kết quả của sự cân bằng giữa khoa học và nghệ thuật, một niềm đam mê mà chúng tôi luôn theo đuổi mỗi ngày."
    ],
    3 => [
        'title' => 'Không Gian HIGHBUCKS: Nơi Gặp Gỡ Và Khơi Nguồn Sáng Tạo',
        'image' => '3.jpg',
        'date' => 'Tháng 2, 2023',
        'author' => 'ADMIN',
        'content' => "Chúng tôi tin rằng một quán cà phê không chỉ là nơi để uống. Đó là một không gian để gặp gỡ bạn bè, làm việc, đọc sách hay đơn giản là tìm một góc yên tĩnh cho riêng mình. HIGHBUCKS được thiết kế với không gian ấm cúng, ánh sáng dịu nhẹ và những bản nhạc du dương, tạo nên một bầu không khí lý tưởng để bạn thư giãn và khơi nguồn sáng tạo.\n\nHãy đến với chúng tôi, chọn một góc yêu thích, gọi một tách cà phê quen thuộc và để thời gian trôi chậm lại. HIGHBUCKS luôn sẵn sàng chào đón bạn."
    ],
    4 => [
        'title' => 'Cách Nhận Biết Cà Phê Sạch Và Nguyên Chất',
        'image' => '4.jpg',
        'date' => 'Tháng 3, 2023',
        'author' => 'ADMIN',
        'content' => "Làm thế nào để phân biệt cà phê thật và cà phê pha tạp? Cùng HIGHBUCKS tìm hiểu một vài mẹo nhỏ. Cà phê nguyên chất thường có mùi thơm dịu, không quá nồng. Bột cà phê sạch có độ xốp, nhẹ và không bị vón cục. Khi pha, nước cà phê có màu nâu cánh gián, không phải màu đen kịt. Hãy là người tiêu dùng thông thái để bảo vệ sức khỏe của bạn."
    ],
    5 => [
        'title' => 'Thế Giới Bánh Ngọt Tại HIGHBUCKS',
        'image' => '5.jpg',
        'date' => 'Tháng 3, 2023',
        'author' => 'ADMIN',
        'content' => "Khám phá thực đơn bánh ngọt đa dạng, được làm thủ công mỗi ngày từ những nguyên liệu tươi ngon nhất. Từ chiếc bánh Tiramisu mềm mịn, béo ngậy đến những chiếc Mousse chanh leo chua dịu, mỗi loại bánh đều mang một câu chuyện riêng. Bánh ngọt tại HIGHBUCKS là sự kết hợp hoàn hảo cùng với ly cà phê của bạn."
    ],
    6 => [
        'title' => 'Món Ăn Vặt Hoàn Hảo Cho Buổi Chiều',
        'image' => '6.jpg',
        'date' => 'Tháng 4, 2023',
        'author' => 'ADMIN',
        'content' => "Từ khô gà lá chanh đến cơm cháy giòn rụm, đâu là món ăn vặt được yêu thích nhất tại quán? Thực đơn đồ ăn vặt của chúng tôi được lựa chọn kỹ lưỡng để phù hợp với khẩu vị của nhiều người, là những món 'nhâm nhi' tuyệt vời bên cạnh câu chuyện cùng bạn bè và người thân. Hãy thử và cảm nhận nhé!"
    ],
];

// Lấy ID bài viết từ URL và tìm bài viết tương ứng
$post_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$post = $posts[$post_id] ?? null;

// Nếu không tìm thấy bài viết, hiển thị thông báo
if (!$post) {
    $page_title = "Không tìm thấy bài viết";
} else {
    $page_title = $post['title'];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?> - HIGHBUCKS</title>
    <link rel="icon" type="image/x-icon" href="../Pic/Favicon.png">
    <link rel="stylesheet" href="../Css/blog.css">
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
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
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
                <img src="../Pic/<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                <h1><?php echo htmlspecialchars($post['title']); ?></h1>
                <p class="blog-meta">
                    Đăng vào <?php echo htmlspecialchars($post['date']); ?> bởi <?php echo htmlspecialchars($post['author']); ?>
                </p>
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
