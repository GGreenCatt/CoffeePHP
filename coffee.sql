-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: coffee
-- ------------------------------------------------------
-- Server version	8.0.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `chitietdonhang`
--

DROP TABLE IF EXISTS `chitietdonhang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chitietdonhang` (
  `idChiTiet` int NOT NULL AUTO_INCREMENT,
  `idDonHang` int DEFAULT NULL,
  `idSanPham` int DEFAULT NULL,
  `SoLuong` int DEFAULT NULL,
  `DonGia` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`idChiTiet`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chitietdonhang`
--

LOCK TABLES `chitietdonhang` WRITE;
/*!40000 ALTER TABLE `chitietdonhang` DISABLE KEYS */;
INSERT INTO `chitietdonhang` VALUES (1,1,4,1,25000),(2,2,3,1,25000),(3,3,3,1,25000),(4,4,3,3,25000),(5,4,4,1,25000),(6,4,1,1,25000),(7,5,2,11,25000),(8,6,1,1,25000),(9,6,17,1,15000),(10,6,18,2,15000),(11,6,10,1,20000),(12,6,26,1,20000);
/*!40000 ALTER TABLE `chitietdonhang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `donhang`
--

DROP TABLE IF EXISTS `donhang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `donhang` (
  `idDonHang` int NOT NULL AUTO_INCREMENT,
  `idTaiKhoan` int DEFAULT NULL,
  `TenNguoiNhan` varchar(255) DEFAULT NULL,
  `SoDienThoaiNhan` varchar(11) DEFAULT NULL,
  `DiaChiNhan` varchar(255) DEFAULT NULL,
  `NgayDat` datetime DEFAULT CURRENT_TIMESTAMP,
  `TongTien` decimal(10,0) DEFAULT NULL,
  `TrangThai` varchar(255) DEFAULT 'Đợi xác nhận',
  PRIMARY KEY (`idDonHang`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `donhang`
--

LOCK TABLES `donhang` WRITE;
/*!40000 ALTER TABLE `donhang` DISABLE KEYS */;
INSERT INTO `donhang` VALUES (1,NULL,'Nguyễn Văn Bảo Long','35253253','2312312312','2025-07-13 18:46:23',55000,'Đợi xác nhận'),(2,NULL,'Lê Mỹ Dung','35253253','adadadad','2025-07-13 18:53:40',55000,'Đợi xác nhận'),(3,NULL,'Lê Mỹ Dung','312312312','1313131','2025-07-13 18:56:39',55000,'Đã hoàn thành'),(4,NULL,'Lê Mỹ Dung','01234567','nhà','2025-07-13 19:13:24',155000,'Đã hoàn thành'),(5,2,'Lê Mỹ Dung','0769226116','aaaaaaaa','2025-07-16 16:32:24',305000,'Đã hủy'),(6,NULL,'Quản lý','01234567','adadadad','2025-07-21 19:27:58',140000,'Đã hoàn thành');
/*!40000 ALTER TABLE `donhang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phanloai`
--

DROP TABLE IF EXISTS `phanloai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `phanloai` (
  `idPhanLoai` int NOT NULL,
  `TenPhanLoai` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idPhanLoai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phanloai`
--

LOCK TABLES `phanloai` WRITE;
/*!40000 ALTER TABLE `phanloai` DISABLE KEYS */;
INSERT INTO `phanloai` VALUES (1,'Cà phê'),(2,'Đồ uống'),(3,'Tráng miệng'),(4,'Đồ ăn vặt');
/*!40000 ALTER TABLE `phanloai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sanpham`
--

DROP TABLE IF EXISTS `sanpham`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sanpham` (
  `idsanpham` int NOT NULL AUTO_INCREMENT,
  `TenSanPham` varchar(255) NOT NULL,
  `SoLuong` float DEFAULT NULL,
  `GiaTien` float NOT NULL,
  `PhanLoai` varchar(255) NOT NULL,
  `TrangThai` varchar(45) NOT NULL,
  PRIMARY KEY (`idsanpham`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sanpham`
--

LOCK TABLES `sanpham` WRITE;
/*!40000 ALTER TABLE `sanpham` DISABLE KEYS */;
INSERT INTO `sanpham` VALUES (1,'Cà phê Capuccino',20,25000,'Cà Phê','Hoạt động'),(2,'Cà phê Espresso',20,25000,'Cà phê','Hoạt động'),(3,'Cà phê sữa đá',20,25000,'Cà phê','Hoạt động'),(4,'Cà phê Latte',20,25000,'Cà phê','Hoạt động'),(5,'Cà phê kem sữa',20,25000,'Cà phê','Hoạt động'),(6,'cà phê trứng',20,25000,'Cà phê','Hoạt động'),(7,'Cà phê muối',20,25000,'Cà phê','Hoạt động'),(8,'Cà phê kem',20,25000,'Cà phê','Hoạt động'),(9,'Nước dâu',20,20000,'Đồ uống','Hoạt động'),(10,'Nước cam',20,20000,'Đồ uống','Hoạt động'),(11,'Nước chanh leo',20,20000,'Đồ uống','Hoạt động'),(12,'Trà lipton',20,20000,'Đồ uống','Hoạt động'),(13,'Nước việt quất',20,20000,'Đồ uống','Hoạt động'),(14,'Trà quế',20,20000,'Đồ uống','Hoạt động'),(15,'Nước chanh',20,20000,'Đồ uống','Hoạt động'),(16,'Trà bạc hà chanh',20,20000,'Đồ uống','Hoạt động'),(17,'Pudding Dâu',20,15000,'Tráng miệng','Hoạt động'),(18,'Bánh chocolate',20,15000,'Tráng miệng','Hoạt động'),(19,'bánh chanh leo',20,15000,'Tráng miệng','Hoạt động'),(20,'bánh waffle dâu',20,15000,'Tráng miệng','Hoạt động'),(21,'Bánh Cupcake',20,15000,'Tráng miệng','Hoạt động'),(22,'bánh waffle mật ong',20,15000,'Tráng miệng','Hoạt động'),(23,'Bánh chocolate kem',20,15000,'Tráng miệng','Hoạt động'),(24,'Bánh chocolate chảy',20,15000,'Tráng miệng','Hoạt động'),(25,'Hạt dẻ',20,10000,'Đồ ăn vặt','Hoạt động'),(26,'Khô gà',20,20000,'Đồ ăn vặt','Hoạt động'),(27,'Cơm cháy',20,20000,'Đồ ăn vặt','Hoạt động'),(28,'Khô heo',20,20000,'Đồ ăn vặt','Hoạt động'),(29,'Bánh tráng',20,15000,'Đồ ăn vặt','Hoạt động'),(30,'Bánh gạo',20,15000,'Đồ ăn vặt','Hoạt động');
/*!40000 ALTER TABLE `sanpham` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taikhoan`
--

DROP TABLE IF EXISTS `taikhoan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `taikhoan` (
  `idTaiKhoan` int NOT NULL AUTO_INCREMENT,
  `HoTen` varchar(255) DEFAULT NULL,
  `sdt` varchar(11) DEFAULT NULL,
  `MatKhau` char(100) DEFAULT NULL,
  `ChucVu` varchar(45) DEFAULT 'Khách hàng',
  PRIMARY KEY (`idTaiKhoan`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taikhoan`
--

LOCK TABLES `taikhoan` WRITE;
/*!40000 ALTER TABLE `taikhoan` DISABLE KEYS */;
INSERT INTO `taikhoan` VALUES (1,'Nguyễn Văn Bảo Long','0917275715','$2y$12$o0DaPc/wcQkE0BmTU.o/SuFcoAVjm5VWKEF9EDwSQw2E1e366AAYm','Khách hàng'),(2,'Lê Mỹ Dung','0769226116','$2y$12$jNj.Hk5zbMCqps87n6z9OOKp24Qu2qAPZNg2CJBvrRBu1hHLXijr.','Khách hàng'),(3,'Quản lý','1234567890','$2y$12$pex6jdTcwiY3KYwV0vJ4duB75yMwSQzhqXXq2VesCkb0EPsZSu/oe','Quản lý');
/*!40000 ALTER TABLE `taikhoan` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-22 12:31:26
