-- --------------------------------------------------------
-- Máy chủ:                      127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Phiên bản:           12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table coffee.blog_posts
CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `author` varchar(100) NOT NULL DEFAULT 'ADMIN',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table coffee.blog_posts: ~8 rows (approximately)
INSERT INTO `blog_posts` (`id`, `title`, `content`, `image_url`, `author`, `created_at`) VALUES
	(1, 'Hành Trình Từ Hạt Cà Phê Đến Tách Cà Phê Đậm Đà', 'Mỗi tách cà phê bạn thưởng thức tại HIGHBUCKS đều bắt đầu từ một hành trình dài và kỳ công. Chúng tôi lựa chọn những hạt cà phê Arabica và Robusta chất lượng nhất từ những vùng cao nguyên trứ danh của Việt Nam. Hạt cà phê được hái chín, lựa chọn cẩn thận và sơ chế theo quy trình nghiêm ngặt để giữ lại hương vị nguyên bản.\n\nTại xưởng rang của chúng tôi, những người thợ rang tài hoa sẽ biến những hạt cà phê xanh thành những hạt nâu bóng, tỏa hương thơm nồng nàn. Quá trình rang được kiểm soát nhiệt độ và thời gian một cách chính xác để phát triển tối đa tiềm năng hương vị của từng loại hạt. Cuối cùng, các barista chuyên nghiệp của chúng tôi sẽ xay và pha chế để tạo ra những tách cà phê đậm đà, đánh thức mọi giác quan của bạn.', '1.jpg', 'ADMIN', '2025-11-12 14:02:12'),
	(2, 'Nghệ Thuật Pha Chế: Bí Quyết Đằng Sau Ly Espresso Hoàn Hảo', 'Espresso được mệnh danh là \'linh hồn\' của mọi loại cà phê. Để tạo ra một ly espresso hoàn hảo, không chỉ cần hạt cà phê ngon mà còn đòi hỏi kỹ thuật và sự chính xác tuyệt đối. Barista của chúng tôi phải điều chỉnh độ mịn của bột cà phê, lực nén, nhiệt độ nước và áp suất máy pha một cách hoàn hảo.\n\nMột shot espresso chuẩn phải có lớp crema màu caramel dày mịn ở trên, vị đắng đậm nhưng không gắt, xen lẫn vị chua thanh và hậu vị ngọt ngào. Đó là kết quả của sự cân bằng giữa khoa học và nghệ thuật, một niềm đam mê mà chúng tôi luôn theo đuổi mỗi ngày.', '2.jpg', 'ADMIN', '2025-11-12 14:02:12'),
	(3, 'Không Gian HIGHBUCKS: Nơi Gặp Gỡ Và Khơi Nguồn Sáng Tạo', 'Chúng tôi tin rằng một quán cà phê không chỉ là nơi để uống. Đó là một không gian để gặp gỡ bạn bè, làm việc, đọc sách hay đơn giản là tìm một góc yên tĩnh cho riêng mình. HIGHBUCKS được thiết kế với không gian ấm cúng, ánh sáng dịu nhẹ và những bản nhạc du dương, tạo nên một bầu không khí lý tưởng để bạn thư giãn và khơi nguồn sáng tạo.\n\nHãy đến với chúng tôi, chọn một góc yêu thích, gọi một tách cà phê quen thuộc và để thời gian trôi chậm lại. HIGHBUCKS luôn sẵn sàng chào đón bạn.', '3.jpg', 'ADMIN', '2025-11-12 14:02:12'),
	(4, 'Cách Nhận Biết Cà Phê Sạch Và Nguyên Chất', 'Làm thế nào để phân biệt cà phê thật và cà phê pha tạp? Cùng HIGHBUCKS tìm hiểu một vài mẹo nhỏ. Cà phê nguyên chất thường có mùi thơm dịu, không quá nồng. Bột cà phê sạch có độ xốp, nhẹ và không bị vón cục. Khi pha, nước cà phê có màu nâu cánh gián, không phải màu đen kịt. Hãy là người tiêu dùng thông thái để bảo vệ sức khỏe của bạn.', '4.jpg', 'ADMIN', '2025-11-12 14:02:12'),
	(5, 'Thế Giới Bánh Ngọt Tại HIGHBUCKS', 'Khám phá thực đơn bánh ngọt đa dạng, được làm thủ công mỗi ngày từ những nguyên liệu tươi ngon nhất. Từ chiếc bánh Tiramisu mềm mịn, béo ngậy đến những chiếc Mousse chanh leo chua dịu, mỗi loại bánh đều mang một câu chuyện riêng. Bánh ngọt tại HIGHBUCKS là sự kết hợp hoàn hảo cùng với ly cà phê của bạn.', '5.jpg', 'ADMIN', '2025-11-12 14:02:12'),
	(6, 'Món Ăn Vặt Hoàn Hảo Cho Buổi Chiều', 'Từ khô gà lá chanh đến cơm cháy giòn rụm, đâu là món ăn vặt được yêu thích nhất tại quán? Thực đơn đồ ăn vặt của chúng tôi được lựa chọn kỹ lưỡng để phù hợp với khẩu vị của nhiều người, là những món \'nhâm nhi\' tuyệt vời bên cạnh câu chuyện cùng bạn bè và người thân. Hãy thử và cảm nhận nhé!', '6.jpg', 'ADMIN', '2025-11-12 14:02:12'),
	(7, 'Bài viết 1', 'Bài viết 1Bài viết 1Bài viết 1Bài viết 1Bài viết 1Bài viết 1Bài viết 1Bài viết 1Bài viết 1Bài viết 1Bài viết 1', 'blog_img_69143b754713f0.95063969.jpg', 'Quản lý', '2025-11-12 14:47:01'),
	(8, 'Lỗi nội bộ: Câu lệnh SQL trống.', 'Lỗi nội bộ: Câu lệnh SQL trống.', 'blog_img_69143b7e037819.56634914.jpg', 'Quản lý', '2025-11-12 14:47:10');

-- Dumping structure for table coffee.chitietdonhang
CREATE TABLE IF NOT EXISTS `chitietdonhang` (
  `idChiTiet` int NOT NULL AUTO_INCREMENT,
  `idDonHang` int DEFAULT NULL,
  `idSanPham` int DEFAULT NULL,
  `SoLuong` int DEFAULT NULL,
  `DonGia` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`idChiTiet`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table coffee.chitietdonhang: ~15 rows (approximately)
INSERT INTO `chitietdonhang` (`idChiTiet`, `idDonHang`, `idSanPham`, `SoLuong`, `DonGia`) VALUES
	(1, 1, 4, 1, 25000),
	(2, 2, 3, 1, 25000),
	(3, 3, 3, 1, 25000),
	(4, 4, 3, 3, 25000),
	(5, 4, 4, 1, 25000),
	(6, 4, 1, 1, 25000),
	(7, 5, 2, 11, 25000),
	(8, 6, 1, 1, 25000),
	(9, 6, 17, 1, 15000),
	(10, 6, 18, 2, 15000),
	(11, 6, 10, 1, 20000),
	(12, 6, 26, 1, 20000),
	(25, 13, 3, 2, 25000),
	(26, 13, 2, 2, 25000),
	(27, 14, 2, 1, 25000);

-- Dumping structure for table coffee.datban
CREATE TABLE IF NOT EXISTS `datban` (
  `id` int NOT NULL AUTO_INCREMENT,
  `HoTen` varchar(255) NOT NULL,
  `sdt` varchar(11) NOT NULL,
  `SoNguoi` int NOT NULL,
  `NgayDat` date NOT NULL,
  `GioDat` time NOT NULL,
  `GhiChu` text,
  `TrangThai` varchar(255) DEFAULT 'Đợi xác nhận',
  `ThoiGianTao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table coffee.datban: ~0 rows (approximately)
INSERT INTO `datban` (`id`, `HoTen`, `sdt`, `SoNguoi`, `NgayDat`, `GioDat`, `GhiChu`, `TrangThai`, `ThoiGianTao`) VALUES
	(1, 'Long', '123456789', 2, '2025-12-11', '21:00:00', '', 'Đợi xác nhận', '2025-11-13 10:41:30');

-- Dumping structure for table coffee.donhang
CREATE TABLE IF NOT EXISTS `donhang` (
  `idDonHang` int NOT NULL AUTO_INCREMENT,
  `idTaiKhoan` int DEFAULT NULL,
  `TenNguoiNhan` varchar(255) DEFAULT NULL,
  `SoDienThoaiNhan` varchar(11) DEFAULT NULL,
  `DiaChiNhan` varchar(255) DEFAULT NULL,
  `NgayDat` datetime DEFAULT CURRENT_TIMESTAMP,
  `TongTien` decimal(10,0) DEFAULT NULL,
  `TrangThai` varchar(255) DEFAULT 'Đợi xác nhận',
  PRIMARY KEY (`idDonHang`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table coffee.donhang: ~8 rows (approximately)
INSERT INTO `donhang` (`idDonHang`, `idTaiKhoan`, `TenNguoiNhan`, `SoDienThoaiNhan`, `DiaChiNhan`, `NgayDat`, `TongTien`, `TrangThai`) VALUES
	(1, NULL, 'Nguyễn Văn Bảo Long', '35253253', '2312312312', '2025-07-13 18:46:23', 55000, 'Đợi xác nhận'),
	(2, NULL, 'Lê Mỹ Dung', '35253253', 'adadadad', '2025-07-13 18:53:40', 55000, 'Đợi xác nhận'),
	(3, NULL, 'Lê Mỹ Dung', '312312312', '1313131', '2025-07-13 18:56:39', 55000, 'Đã hoàn thành'),
	(4, NULL, 'Lê Mỹ Dung', '01234567', 'nhà', '2025-07-13 19:13:24', 155000, 'Đã hoàn thành'),
	(5, 2, 'Lê Mỹ Dung', '0769226116', 'aaaaaaaa', '2025-07-16 16:32:24', 305000, 'Đã hoàn thành'),
	(6, NULL, 'Quản lý', '01234567', 'adadadad', '2025-07-21 19:27:58', 140000, 'Đã hoàn thành'),
	(13, NULL, 'Lê Mỹ Dung', '01234567', 'aaaaaaaa', '2025-11-13 15:50:45', 130000, 'Chờ thanh toán QR'),
	(14, NULL, 'ădawda', 'adad', 'ưdadad', '2025-11-13 15:57:53', 55000, 'Chờ thanh toán QR');

-- Dumping structure for table coffee.khuyenmai
CREATE TABLE IF NOT EXISTS `khuyenmai` (
  `idKhuyenMai` int NOT NULL AUTO_INCREMENT,
  `MaCode` varchar(50) NOT NULL,
  `LoaiGiamGia` enum('PhanTram','SoTien') NOT NULL,
  `GiaTri` decimal(10,2) NOT NULL,
  `NgayBatDau` datetime NOT NULL,
  `NgayKetThuc` datetime NOT NULL,
  `TrangThai` enum('HoatDong','KhongHoatDong') NOT NULL DEFAULT 'HoatDong',
  PRIMARY KEY (`idKhuyenMai`),
  UNIQUE KEY `MaCode` (`MaCode`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table coffee.khuyenmai: ~0 rows (approximately)
INSERT INTO `khuyenmai` (`idKhuyenMai`, `MaCode`, `LoaiGiamGia`, `GiaTri`, `NgayBatDau`, `NgayKetThuc`, `TrangThai`) VALUES
	(1, 'hello50', 'SoTien', 50000.00, '2025-11-12 13:59:00', '2025-11-13 13:59:00', 'HoatDong');

-- Dumping structure for table coffee.phanloai
CREATE TABLE IF NOT EXISTS `phanloai` (
  `idPhanLoai` int NOT NULL,
  `TenPhanLoai` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idPhanLoai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table coffee.phanloai: ~4 rows (approximately)
INSERT INTO `phanloai` (`idPhanLoai`, `TenPhanLoai`) VALUES
	(1, 'Cà phê'),
	(2, 'Đồ uống'),
	(3, 'Tráng miệng'),
	(4, 'Đồ ăn vặt');

-- Dumping structure for table coffee.sanpham
CREATE TABLE IF NOT EXISTS `sanpham` (
  `idsanpham` int NOT NULL AUTO_INCREMENT,
  `TenSanPham` varchar(255) NOT NULL,
  `SoLuong` float DEFAULT NULL,
  `GiaTien` float NOT NULL,
  `PhanLoai` varchar(255) NOT NULL,
  `TrangThai` varchar(45) NOT NULL,
  PRIMARY KEY (`idsanpham`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table coffee.sanpham: ~30 rows (approximately)
INSERT INTO `sanpham` (`idsanpham`, `TenSanPham`, `SoLuong`, `GiaTien`, `PhanLoai`, `TrangThai`) VALUES
	(1, 'Cà phê Capuccino', 20, 25000, 'Cà Phê', 'Hoạt động'),
	(2, 'Cà phê Espresso', 20, 25000, 'Cà phê', 'Hoạt động'),
	(3, 'Cà phê sữa đá', 20, 25000, 'Cà phê', 'Hoạt động'),
	(4, 'Cà phê Latte', 20, 25000, 'Cà phê', 'Hoạt động'),
	(5, 'Cà phê kem sữa', 20, 25000, 'Cà phê', 'Hoạt động'),
	(6, 'cà phê trứng', 20, 25000, 'Cà phê', 'Hoạt động'),
	(7, 'Cà phê muối', 20, 25000, 'Cà phê', 'Hoạt động'),
	(8, 'Cà phê kem', 20, 25000, 'Cà phê', 'Hoạt động'),
	(9, 'Nước dâu', 20, 20000, 'Đồ uống', 'Hoạt động'),
	(10, 'Nước cam', 20, 20000, 'Đồ uống', 'Hoạt động'),
	(11, 'Nước chanh leo', 20, 20000, 'Đồ uống', 'Hoạt động'),
	(12, 'Trà lipton', 20, 20000, 'Đồ uống', 'Hoạt động'),
	(13, 'Nước việt quất', 20, 20000, 'Đồ uống', 'Hoạt động'),
	(14, 'Trà quế', 20, 20000, 'Đồ uống', 'Hoạt động'),
	(15, 'Nước chanh', 20, 20000, 'Đồ uống', 'Hoạt động'),
	(16, 'Trà bạc hà chanh', 20, 20000, 'Đồ uống', 'Hoạt động'),
	(17, 'Pudding Dâu', 20, 15000, 'Tráng miệng', 'Hoạt động'),
	(18, 'Bánh chocolate', 20, 15000, 'Tráng miệng', 'Hoạt động'),
	(19, 'bánh chanh leo', 20, 15000, 'Tráng miệng', 'Hoạt động'),
	(20, 'bánh waffle dâu', 20, 15000, 'Tráng miệng', 'Hoạt động'),
	(21, 'Bánh Cupcake', 20, 15000, 'Tráng miệng', 'Hoạt động'),
	(22, 'bánh waffle mật ong', 20, 15000, 'Tráng miệng', 'Hoạt động'),
	(23, 'Bánh chocolate kem', 20, 15000, 'Tráng miệng', 'Hoạt động'),
	(24, 'Bánh chocolate chảy', 20, 15000, 'Tráng miệng', 'Hoạt động'),
	(25, 'Hạt dẻ', 20, 10000, 'Đồ ăn vặt', 'Hoạt động'),
	(26, 'Khô gà', 20, 20000, 'Đồ ăn vặt', 'Hoạt động'),
	(27, 'Cơm cháy', 20, 20000, 'Đồ ăn vặt', 'Hoạt động'),
	(28, 'Khô heo', 20, 20000, 'Đồ ăn vặt', 'Hoạt động'),
	(29, 'Bánh tráng', 20, 15000, 'Đồ ăn vặt', 'Hoạt động'),
	(30, 'Bánh gạo', 20, 15000, 'Đồ ăn vặt', 'Hoạt động');

-- Dumping structure for table coffee.taikhoan
CREATE TABLE IF NOT EXISTS `taikhoan` (
  `idTaiKhoan` int NOT NULL AUTO_INCREMENT,
  `HoTen` varchar(255) DEFAULT NULL,
  `sdt` varchar(11) DEFAULT NULL,
  `MatKhau` char(100) DEFAULT NULL,
  `DiaChi` varchar(255) DEFAULT NULL,
  `ChucVu` varchar(45) DEFAULT 'Khách hàng',
  PRIMARY KEY (`idTaiKhoan`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table coffee.taikhoan: ~3 rows (approximately)
INSERT INTO `taikhoan` (`idTaiKhoan`, `HoTen`, `sdt`, `MatKhau`, `DiaChi`, `ChucVu`) VALUES
	(1, 'Nguyễn Văn Bảo Long', '0917275715', '$2y$12$o0DaPc/wcQkE0BmTU.o/SuFcoAVjm5VWKEF9EDwSQw2E1e366AAYm', NULL, 'Khách hàng'),
	(2, 'Lê Mỹ Dung', '0769226116', '$2y$12$jNj.Hk5zbMCqps87n6z9OOKp24Qu2qAPZNg2CJBvrRBu1hHLXijr.', NULL, 'Khách hàng'),
	(3, 'Quản lý', '1234567890', '$2y$12$pex6jdTcwiY3KYwV0vJ4duB75yMwSQzhqXXq2VesCkb0EPsZSu/oe', NULL, 'Quản lý');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
