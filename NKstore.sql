SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Table `phân quyền`


CREATE TABLE `phan_quyen` (
  `ma_so` int(11) NOT NULL,
  `ten_quyen` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- data for table `phan_quyen`


INSERT INTO `phan_quyen` (`ma_so`, `ten_quyen`) VALUES
(0, 'người dùng'),
(1, 'quản lý');

-- --------------------------------------------------------


-- Table `người dùng`

CREATE TABLE `nguoi_dung` (
  `ma_so` int(11) NOT NULL,
  `ho_nguoi_dung` varchar(255) NOT NULL,
  `ten_nguoi_dung` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `so_dien_thoai` varchar(55) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `dia_chi` varchar(255) NOT NULL,
  `gioi_tinh` tinyint(1) NOT NULL,
  `ngay_sinh` varchar(55),
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ma_quyen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table `thể loại`

CREATE TABLE `the_loai` (
  `ma_so` int(11) NOT NULL,
  `ten_the_loai` varchar(55) NOT NULL,
  `nhom` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table `sản phẩm`

CREATE TABLE `san_pham` (
  `ma_so` int(11) NOT NULL,
  `ten_san_pham` varchar(55) NOT NULL,
  `hinh_anh` varchar(555) NOT NULL,
  `gia` float NOT NULL,
  `muc_giam` int(11) NOT NULL,
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `mo_ta` text,
  `so_luong` int(11) NOT NULL,
  `ma_the_loai` int(11) NOT NULL,
  `trang_thai` bit default 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table `hình ảnh liên quan`

CREATE TABLE `anh_lien_quan` (
  `ma_so` int(11) NOT NULL,
  `ma_san_pham` int(11) NOT NULL,
  `hinh_anh` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table `đơn hàng`

CREATE TABLE `don_hang` (
  `ma_so` int(11) NOT NULL,
  `ma_nguoi_dung` int(11) NOT NULL,
  `ten_nguoi_dung` varchar(255) NOT NULL,
  `so_dien_thoai` int(11) NOT NULL,
  `dia_chi` varchar(255) NOT NULL,
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `trang_thai_thanh_toan` bit(3) default 0,
  `trang_thai_don_hang` int(11) NOT NULL,
  `trang_thai` bit default 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table `chi tiết đơn hàng`

CREATE TABLE `chi_tiet_don_hang` (
  `ma_so` int(11) NOT NULL,
  `ma_don_hang` int(11) NOT NULL,
  `ma_san_pham` int(11) NOT NULL,
  `ma_thuoc_tinh_sp` int(11) NOT NULL,
  `gia` float NOT NULL,
  `so_luong` int(11) NOT NULL,
  `trang_thai` bit default 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table `màu sắc`

CREATE TABLE `mau_sac` (
  `ma_so` int(11) NOT NULL,
  `ten_mau_sac` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table `kích cở`

CREATE TABLE `kich_co` (
  `ma_so` int(11) NOT NULL,
  `ten_kich_co` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table `yêu thích`

CREATE TABLE `yeu_thich` (
  `ma_so` int(11) NOT NULL,
  `ma_nguoi_dung` int(11) NOT NULL,
  `ma_san_pham` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table `thuộc tính sản phẩm`

CREATE TABLE `thuoc_tinh_san_pham` (
  `ma_so` int(11) NOT NULL,
  `ma_san_pham` int(11) NOT NULL,
  `ma_mau_sac` int(11) NOT NULL,
  `ma_kich_co` int(11) NOT NULL,
  `mo_ta_them` text,
  `trang_thai` bit default 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table `xếp hạng`

-- create table `xep_hang` (
--     `ma_so` bigint primary key IDENTITY(0, 1),
-- 	`noi_dung` varchar(MAX),   
-- 	`xep_hang` int(11),
-- 	`ten_nguoi_dung` varchar(255),   
-- 	`ngay_tao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
-- 	`ma_san_pham` int(11) NOT NULL,
-- 	`ma_don_hang` int(11) NOT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- table `phân quyền`
--
ALTER TABLE `phan_quyen`
  ADD PRIMARY KEY (`ma_so`);

-- table `người dùng`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`ma_so`),
  ADD KEY `ma_quyen` (`ma_quyen`);

-- table `thể lọai`
--
ALTER TABLE `the_loai`
  ADD PRIMARY KEY (`ma_so`);

-- table `sản phẩm`
--
ALTER TABLE `san_pham`
  ADD PRIMARY KEY (`ma_so`),
  ADD KEY `ma_the_loai` (`ma_the_loai`);

-- table `ảnh liên quan`
--
ALTER TABLE `anh_lien_quan`
  ADD PRIMARY KEY (`ma_so`),
  ADD KEY `ma_san_pham_alq` (`ma_san_pham`);

-- table `đơn hàng`
--
ALTER TABLE `don_hang`
  ADD PRIMARY KEY (`ma_so`),
  ADD KEY `ma_nguoi_dung_dh` (`ma_nguoi_dung`);

-- table `chi tiết đơn hàng`
--
ALTER TABLE `chi_tiet_don_hang`
  ADD PRIMARY KEY (`ma_so`),
  ADD KEY `ma_don_hang` (`ma_don_hang`),
  ADD KEY `ma_san_pham_ct` (`ma_san_pham`),
  ADD KEY `ma_thuoc_tinh_sp` (`ma_thuoc_tinh_sp`);

-- table `màu sắc`
--
ALTER TABLE `mau_sac`
  ADD PRIMARY KEY (`ma_so`);

-- table `kích cở`
--
ALTER TABLE `kich_co`
  ADD PRIMARY KEY (`ma_so`);

-- table `yêu thích`
--
ALTER TABLE `yeu_thich`
  ADD PRIMARY KEY (`ma_so`),
  ADD KEY `ma_nguoi_dung_yt` (`ma_nguoi_dung`),
  ADD KEY `ma_san_pham_yt` (`ma_san_pham`);

-- table `thuộc tính sản phẩm`
--
ALTER TABLE `thuoc_tinh_san_pham`
  ADD PRIMARY KEY (`ma_so`),
  ADD KEY `ma_san_pham_tt` (`ma_san_pham`),
  ADD KEY `ma_mau_sac` (`ma_mau_sac`),
  ADD KEY `ma_kich_co` (`ma_kich_co`);

-- ---------------------------------------------------------
--
-- AUTO_INCREMENT for table `người dùng`
--
ALTER TABLE `nguoi_dung`
  MODIFY `ma_so` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phân quyền`
--
ALTER TABLE `phan_quyen`
  MODIFY `ma_so` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

-- AUTO_INCREMENT for table `thể loại`
--
ALTER TABLE `the_loai`
  MODIFY `ma_so` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `san phẩm`
--
ALTER TABLE `san_pham`
  MODIFY `ma_so` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `anh liên quan`
--
ALTER TABLE `anh_lien_quan`
  MODIFY `ma_so` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `đơn hàng`
--
ALTER TABLE `don_hang`
  MODIFY `ma_so` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chi tiết đơn hàng`
--
ALTER TABLE `chi_tiet_don_hang`
  MODIFY `ma_so` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `thuộc tính sản phẩm`
--
ALTER TABLE `thuoc_tinh_san_pham`
  MODIFY `ma_so` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `màu sắc`
--
ALTER TABLE `mau_sac`
  MODIFY `ma_so` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kích cở`
--
ALTER TABLE `kich_co`
  MODIFY `ma_so` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yêu thích`
--
ALTER TABLE `yeu_thich`
  MODIFY `ma_so` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

-- --------------------------------------------------------------------

-- Constraints for table `người dùng`
--
ALTER TABLE `nguoi_dung`
  ADD CONSTRAINT `ma_quyen` FOREIGN KEY (`ma_quyen`) REFERENCES `phan_quyen` (`ma_so`);
  
-- Constraints for table `sản phẩm`
--
ALTER TABLE `san_pham`
  ADD CONSTRAINT `ma_the_loai` FOREIGN KEY (`ma_the_loai`) REFERENCES `the_loai` (`ma_so`);

-- Constraints for table `ảnh liên quan`
--
ALTER TABLE `anh_lien_quan`
  ADD CONSTRAINT `ma_san_pham_alq` FOREIGN KEY (`ma_san_pham`) REFERENCES `san_pham` (`ma_so`);

-- Constraints for table `đơn hàng`
--
ALTER TABLE `don_hang`
  ADD CONSTRAINT `ma_nguoi_dung_dh` FOREIGN KEY (`ma_nguoi_dung`) REFERENCES `nguoi_dung` (`ma_so`);

-- Constraints for table `chi tiết đơn hàng`
--
ALTER TABLE `chi_tiet_don_hang`
  ADD CONSTRAINT `ma_don_hang` FOREIGN KEY (`ma_don_hang`) REFERENCES `don_hang` (`ma_so`),
  ADD CONSTRAINT `ma_san_pham_ct` FOREIGN KEY (`ma_san_pham`) REFERENCES `san_pham` (`ma_so`),
  ADD CONSTRAINT `ma_thuoc_tinh_sp` FOREIGN KEY (`ma_thuoc_tinh_sp`) REFERENCES `thuoc_tinh_san_pham` (`ma_so`);

-- Constraints for table `yêu thích`
--
ALTER TABLE `yeu_thich`
  ADD CONSTRAINT `ma_nguoi_dung_yt` FOREIGN KEY (`ma_nguoi_dung`) REFERENCES `nguoi_dung` (`ma_so`),
  ADD CONSTRAINT `ma_san_pham_yt` FOREIGN KEY (`ma_san_pham`) REFERENCES `san_pham` (`ma_so`);

-- Constraints for table `thuộc tính sản phẩm`
--
ALTER TABLE `thuoc_tinh_san_pham`
  ADD CONSTRAINT `ma_san_pham_tt` FOREIGN KEY (`ma_san_pham`) REFERENCES `san_pham` (`ma_so`),
  ADD CONSTRAINT `ma_mau_sac` FOREIGN KEY (`ma_mau_sac`) REFERENCES `mau_sac` (`ma_so`),
  ADD CONSTRAINT `ma_kich_co` FOREIGN KEY (`ma_kich_co`) REFERENCES `kich_co` (`ma_so`);
COMMIT;