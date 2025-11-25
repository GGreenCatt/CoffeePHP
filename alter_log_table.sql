ALTER TABLE `lichsu_tonkho`
ADD COLUMN `idDonHang` INT NULL AFTER `id`,
ADD COLUMN `idSanPham` INT NULL AFTER `idDonHang`,
ADD CONSTRAINT `fk_lichsu_donhang` FOREIGN KEY (`idDonHang`) REFERENCES `donhang`(`idDonHang`) ON DELETE SET NULL,
ADD CONSTRAINT `fk_lichsu_sanpham` FOREIGN KEY (`idSanPham`) REFERENCES `sanpham`(`idsanpham`) ON DELETE SET NULL;
