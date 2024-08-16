-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2024 at 07:51 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qlcuahang`
--

-- --------------------------------------------------------

--
-- Table structure for table `chitietdonhang`
--

CREATE TABLE `chitietdonhang` (
  `MaChiTietDonHang` int(11) NOT NULL,
  `MaDon` int(11) NOT NULL,
  `MaSanPham` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `Gia` decimal(11,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `chitietdonhang`
--

INSERT INTO `chitietdonhang` (`MaChiTietDonHang`, `MaDon`, `MaSanPham`, `SoLuong`, `Gia`) VALUES
(31, 42, 'SP002', 1, 50000),
(32, 42, 'SP004', 1, 48000),
(33, 43, 'SP001', 1, 45000),
(34, 43, 'SP003', 1, 50000),
(35, 43, 'SP006', 1, 130000),
(36, 44, 'SP006', 1, 130000),
(37, 44, 'SP002', 1, 50000),
(38, 44, 'SP007', 1, 120000),
(39, 44, 'SP004', 1, 48000),
(40, 47, 'SP002', 1, 50000),
(41, 47, 'SP034', 1, 40000),
(42, 47, 'SP032', 1, 50000),
(43, 48, 'SP002', 1, 50000),
(44, 48, 'SP003', 1, 50000),
(45, 49, 'SP003', 3, 150000);

-- --------------------------------------------------------

--
-- Table structure for table `donhang`
--

CREATE TABLE `donhang` (
  `MaDon` int(11) NOT NULL,
  `MaKH` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `TenKhachHang` varchar(50) NOT NULL,
  `SoDienThoai` varchar(10) NOT NULL,
  `DiaChi` varchar(100) NOT NULL,
  `PhuongThucThanhToan` varchar(100) NOT NULL,
  `ThoiGianTaoDon` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `donhang`
--

INSERT INTO `donhang` (`MaDon`, `MaKH`, `TenKhachHang`, `SoDienThoai`, `DiaChi`, `PhuongThucThanhToan`, `ThoiGianTaoDon`) VALUES
(42, 'ND002', 'Cao Văn Lượng', '0929474424', 'Tân Phú', 'COD', '2024-05-26 01:20:28'),
(43, 'ND002', 'Cao Văn Lượng', '0929474424', 'Tân Bình', 'COD', '2024-05-26 19:27:57'),
(44, 'ND002', 'Cao Văn Lượng', '0929474424', 'Tân Bình', 'COD', '2024-05-26 19:30:20'),
(47, 'ND002', 'Cao Văn Lượng', '0929474424', 'Tân Phú', 'COD', '2024-05-26 20:10:17'),
(48, 'ND003', 'Cao Lượng', '0929474422', 'Tiền Giang', 'COD', '2024-05-27 00:27:20'),
(49, 'ND003', 'Cao Lượng ', '0929474422', 'Tiền Giang', 'COD', '2024-05-27 00:48:33');

-- --------------------------------------------------------

--
-- Table structure for table `giohang`
--

CREATE TABLE `giohang` (
  `MaGioHang` int(11) NOT NULL,
  `MaNguoiDung` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `MaSanPham` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `SoLuong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loaisanpham`
--

CREATE TABLE `loaisanpham` (
  `MaLoai` varchar(20) NOT NULL,
  `TenLoai` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loaisanpham`
--

INSERT INTO `loaisanpham` (`MaLoai`, `TenLoai`) VALUES
('001', 'Hamburger'),
('002', 'Pizza'),
('003', 'Bánh mì'),
('004', 'Gà rán'),
('005', 'Cơm gà'),
('006', 'Nước uống'),
('007', 'Salad'),
('008', 'Khoai tây chiên');

-- --------------------------------------------------------

--
-- Table structure for table `nguoidung`
--

CREATE TABLE `nguoidung` (
  `MaNguoiDung` varchar(20) NOT NULL,
  `TenDangNhap` varchar(30) NOT NULL,
  `MatKhau` text NOT NULL,
  `Email` varchar(50) NOT NULL,
  `HoTen` varchar(30) NOT NULL,
  `DiaChi` varchar(50) NOT NULL,
  `SoDienThoai` varchar(15) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nguoidung`
--

INSERT INTO `nguoidung` (`MaNguoiDung`, `TenDangNhap`, `MatKhau`, `Email`, `HoTen`, `DiaChi`, `SoDienThoai`, `role`) VALUES
('AD001', 'admin', '$2y$10$zutQm0dqOao99musvBeRw.O8rpTmtoaNsPGOe5irjJq8LrW6A2faW', 'duongtugiaucuong@gmail.com', 'Nguyễn Thị Thùy Dương', '69/14 Bùi Xuân Phái', '0369041478', 'admin'),
('ND001', 'duong', '$2y$10$JUSTsaq6dDBZLOvCJry/GuAFvfwXgJ8ibldlDyigTd/vfvkJAHarW', 'duongtugiaucuong@gmail.com', 'Nguyễn Thị Thùy Dương', '69/14 Bùi Xuân Phái', '0369041478', 'user'),
('ND002', 'luongdz', '$2y$10$rGkFKvoNFgT5ezXTEo/ODOuJEvlZ3Qbgmo01R6.aOcUecnwXxMHO6', 'cvluong91lh@gmail.com', 'Cao Văn Lượng', 'Tân Phú', '0929474424', 'user'),
('ND003', 'LuongCao', '$2y$10$YTawiSRnqaxoIx4AvVMq/uSwJQLC7Q6/ZLtTgPBhdqJ3gSOMRjfqO', 'cvluong91lh@gmail.com', 'Cao Lượng', 'Tiền Giang', '0929474422', 'user');

--
-- Triggers `nguoidung`
--
DELIMITER $$
CREATE TRIGGER `tr_generate_MaNguoiDung` BEFORE INSERT ON `nguoidung` FOR EACH ROW BEGIN
  DECLARE prefix VARCHAR(2);
  DECLARE role_count INT;

  IF NEW.role = 'user' THEN
    SET prefix = 'ND';
  ELSEIF NEW.role = 'admin' THEN
    SET prefix = 'AD';
  ELSE
    SET prefix = '';
  END IF;

  SELECT COUNT(*) INTO role_count FROM nguoidung WHERE role = NEW.role;
  SET NEW.MaNguoiDung = CONCAT(prefix, LPAD(role_count + 1, 3, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `phanhoi`
--

CREATE TABLE `phanhoi` (
  `MaPhanHoi` varchar(20) NOT NULL,
  `MaNguoiDung` varchar(20) DEFAULT NULL,
  `MaSanPham` varchar(20) NOT NULL,
  `NoiDung` text NOT NULL,
  `NgayGui` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phanhoi`
--

INSERT INTO `phanhoi` (`MaPhanHoi`, `MaNguoiDung`, `MaSanPham`, `NoiDung`, `NgayGui`) VALUES
('CM001', 'ND002', 'SP001', 'Ngon gía cả phải chăng', '2024-05-26'),
('CM002', 'ND002', 'SP001', 'ngon', '2024-05-26'),
('CM003', 'ND002', 'SP001', 'ngon2', '2024-05-26'),
('CM004', 'ND002', 'SP001', 'Quá ngon', '2024-05-26'),
('CM005', 'ND002', 'SP006', 'ngon kinh khủng', '2024-05-26');

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

CREATE TABLE `sanpham` (
  `MaSanPham` varchar(20) NOT NULL,
  `TenSanPham` text NOT NULL,
  `MoTa` text NOT NULL,
  `Gia` decimal(10,0) NOT NULL,
  `TinhTrang` text NOT NULL,
  `URLHinhAnh` text NOT NULL,
  `MaLoai` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sanpham`
--

INSERT INTO `sanpham` (`MaSanPham`, `TenSanPham`, `MoTa`, `Gia`, `TinhTrang`, `URLHinhAnh`, `MaLoai`) VALUES
('SP001', 'Hamburger gà', 'Hamburger gà tươi ngon', 45000, 'Còn hàng', 'SP001.webp', '001'),
('SP002', 'Hamburger bò', 'Hamburger bò thơm ngon', 50000, 'Còn hàng', 'SP002.jpg', '001'),
('SP003', 'Hamburger cá hồi', 'Hamburger cá hồi tươi ngon', 50000, 'Còn hàng', 'SP003.jpg', '001'),
('SP004', 'Hamburger gà quay', 'Hamburger gà quay tươi ngon', 48000, 'Còn hàng', 'SP004.jpg', '001'),
('SP005', 'Hamburger bò mỹ', 'Hamburger bò mỹ thơm ngon', 70000, 'Còn hàng', 'SP005.jpg', '001'),
('SP006', 'Pizza hải sản', 'Pizza hải sản tươi ngon', 130000, 'Còn hàng', 'SP006.jpg', '002'),
('SP007', 'Pizza gà', 'Pizza gà thơm ngon', 120000, 'Còn hàng', 'SP007.jpg', '002'),
('SP008', 'Pizza bò', 'Pizza bò thơm ngon', 140000, 'Còn hàng', 'SP008.jpg', '002'),
('SP009', 'Pizza xúc xích', 'Pizza xúc xích thơm ngon', 110000, 'Còn hàng', 'SP009.jpg', '002'),
('SP010', 'Pizza hành tây', 'Pizza hành tây thơm ngon', 110000, 'Còn hàng', 'SP010.jpg', '002'),
('SP011', 'Bánh mỳ tỏi', 'Bánh mỳ tỏi giòn ngon', 110000, 'Còn hàng', 'SP011.jpg', '003'),
('SP012', 'Bánh mỳ thịt', 'Bánh mỳ thịt nguội ngon', 30000, 'Còn hàng', 'SP012.jpg', '003'),
('SP013', 'Bánh mỳ pate', 'Bánh mỳ pate thơm ngon', 25000, 'Còn hàng', 'SP013.jpg', '003'),
('SP014', 'Bánh mỳ cá ngừ', 'Bánh mỳ cá ngừ ngon', 35000, 'Còn hàng', 'SP014.jpg', '003'),
('SP015', 'Bánh mỳ trứng muối', 'Bánh mỳ trứng muối thơm ngon', 35000, 'Còn hàng', 'SP015.jpg', '003'),
('SP016', 'Gà rán cay nóng', 'Gà rán cay nóng ngon', 115000, 'Còn hàng', 'SP016.jpg', '004'),
('SP017', 'Gà rán mắm tôm', 'Gà rán mắm tôm ngon', 130000, 'Còn hàng', 'SP017.jpg', '004'),
('SP018', 'Gà rn mật ong', 'Gà rán mật ong thơm ngon', 130000, 'Còn hàng', 'SP018.jpg', '004'),
('SP019', 'Gà rán bơ tỏi', 'Gà rán bơ tỏi thơm ngon', 130000, 'Còn hàng', 'SP019.jpg', '004'),
('SP020', 'Gà rán hành phi', 'Gà rán hành phi thơm ngon', 130000, 'Còn hàng', 'SP020.jpg', '004'),
('SP021', 'Cơm gà xối mỡ', 'Cơm gà xối mỡ ngon', 45000, 'Còn hàng', 'SP021.jpg', '005'),
('SP022', 'Cơm sườn bì chả', 'Cơm sườn bì chả ngon', 45000, 'Còn hàng', 'SP022.jpg', '005'),
('SP023', 'Cơm gà quay', 'Cơm gà quay ngon', 45000, 'Còn hàng', 'SP023.jpg', '005'),
('SP024', 'Cơm thịt kho tàu', 'Cơm thịt kho tàu ngon', 45000, 'Còn hàng', 'SP024.jpg', '005'),
('SP025', 'Cơm cá kho tộ', 'Cơm cá kho tộ ngon', 50000, 'Còn hàng', 'SP025.jpg', '005'),
('SP026', 'Mirinda Cam', 'Nước giải khát', 20000, 'Còn hàng', 'SP026.jpg', '006'),
('SP027', 'Mirinda soda kem', 'Nước giải khát', 20000, 'Còn hàng', 'SP027.jpg', '006'),
('SP028', 'Pepsi', 'Nước giải khát', 20000, 'Còn hàng', 'SP028.jpg', '006'),
('SP029', '7up chanh', 'Nước giải khát', 20000, 'Còn hàng', 'SP029.jpg', '006'),
('SP030', 'Coca cola', 'Nước giải khát', 20000, 'Còn hàng', 'SP030.jpg', '006'),
('SP031', 'Sprite', 'Nước giải khát', 20000, 'Còn hàng', 'SP031.jpg', '006'),
('SP032', 'Salad gà', 'Salad gà ngon', 50000, 'Còn hàng', 'SP032.jpg', '007'),
('SP033', 'Salad bò', 'Salad bò ngon', 60000, 'Còn hàng', 'SP033.jpg', '007'),
('SP034', 'Salad rau củ', 'Salad trộn ngon', 40000, 'Còn hàng', 'SP034.jpg', '007'),
('SP035', 'Salad trứng', 'Salad rau củ ngon', 40000, 'Còn hàng', 'SP035.jpg', '007'),
('SP039', 'Khoai tây chiên thường', 'Khoai tây chiên ', 65000, 'Còn hàng', 'SP036.jpg', '008'),
('SP041', 'Khoai tây chiên phomai', 'Khoai tây chiên lớn', 75000, 'Còn hàng', 'SP037.jpg', '008'),
('SP042', 'Khoai tây chiên tỏi ớt', 'Khoai tây chiên phô mai', 75000, 'Còn hàng', 'SP038.jpg', '008'),
('SP043', 'Khoai tây chiên mật ong', 'Khoai tây chiên mật ong', 75000, 'Còn hàng', 'SP039.jpg', '008');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD PRIMARY KEY (`MaChiTietDonHang`),
  ADD KEY `fk_donhang_chitietdonhang` (`MaDon`),
  ADD KEY `fk_ctdh_sanpham` (`MaSanPham`);

--
-- Indexes for table `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`MaDon`),
  ADD KEY `fk_donhang_khachhang` (`MaKH`);

--
-- Indexes for table `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`MaGioHang`),
  ADD KEY `fk_mand_nd` (`MaNguoiDung`),
  ADD KEY `fk_masp_sp` (`MaSanPham`);

--
-- Indexes for table `loaisanpham`
--
ALTER TABLE `loaisanpham`
  ADD PRIMARY KEY (`MaLoai`);

--
-- Indexes for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`MaNguoiDung`);

--
-- Indexes for table `phanhoi`
--
ALTER TABLE `phanhoi`
  ADD PRIMARY KEY (`MaPhanHoi`),
  ADD KEY `fk_phanhoi_nguoidung` (`MaNguoiDung`),
  ADD KEY `fk_sanpham_phanhoi` (`MaSanPham`);

--
-- Indexes for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MaSanPham`),
  ADD KEY `fk_sanpham_loaisanpham` (`MaLoai`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  MODIFY `MaChiTietDonHang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `donhang`
--
ALTER TABLE `donhang`
  MODIFY `MaDon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `giohang`
--
ALTER TABLE `giohang`
  MODIFY `MaGioHang` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD CONSTRAINT `fk_ctdh_sanpham` FOREIGN KEY (`MaSanPham`) REFERENCES `sanpham` (`MaSanPham`),
  ADD CONSTRAINT `fk_donhang_chitietdonhang` FOREIGN KEY (`MaDon`) REFERENCES `donhang` (`MaDon`);

--
-- Constraints for table `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `fk_donhang_khachhang` FOREIGN KEY (`MaKH`) REFERENCES `nguoidung` (`MaNguoiDung`);

--
-- Constraints for table `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `fk_mand_nd` FOREIGN KEY (`MaNguoiDung`) REFERENCES `nguoidung` (`MaNguoiDung`),
  ADD CONSTRAINT `fk_masp_sp` FOREIGN KEY (`MaSanPham`) REFERENCES `sanpham` (`MaSanPham`);

--
-- Constraints for table `phanhoi`
--
ALTER TABLE `phanhoi`
  ADD CONSTRAINT `fk_phanhoi_nguoidung` FOREIGN KEY (`MaNguoiDung`) REFERENCES `nguoidung` (`MaNguoiDung`),
  ADD CONSTRAINT `fk_sanpham_phanhoi` FOREIGN KEY (`MaSanPham`) REFERENCES `sanpham` (`MaSanPham`);

--
-- Constraints for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `fk_sanpham_loaisanpham` FOREIGN KEY (`MaLoai`) REFERENCES `loaisanpham` (`MaLoai`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
