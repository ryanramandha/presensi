-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 24, 2024 at 08:10 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `presensi_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int NOT NULL,
  `tanggal` date NOT NULL,
  `id_pegawai` int NOT NULL,
  `keterangan` enum('Off','Alfa','Sakit','Izin','Cuti') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `tanggal`, `id_pegawai`, `keterangan`) VALUES
(2, '2024-02-05', 2, 'Cuti'),
(3, '2024-02-06', 2, 'Cuti'),
(4, '2024-02-06', 3, 'Off'),
(6, '2024-02-07', 5, 'Off'),
(7, '2024-05-21', 2, 'Off');

-- --------------------------------------------------------

--
-- Table structure for table `libur`
--

CREATE TABLE `libur` (
  `id_libur` int NOT NULL,
  `tgl_libur` date NOT NULL,
  `nama_libur` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `libur`
--

INSERT INTO `libur` (`id_libur`, `tgl_libur`, `nama_libur`) VALUES
(1, '2024-02-08', 'Outing Kantor'),
(2, '2024-05-23', 'Waisak');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id_pegawai` int NOT NULL,
  `kode_pegawai` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_pegawai` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `no_hp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jabatan` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_pengguna` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `kode_pegawai`, `nama_pegawai`, `alamat`, `no_hp`, `jabatan`, `id_pengguna`) VALUES
(2, 'P001', 'Icha', 'Jakarta Timur', '085223949111', 'Admin', 6),
(3, 'P002', 'Adel', 'Jakarta Timur', '085123456789', 'Admin', 7),
(4, 'P003', 'Yanti', 'Jakarta Timur', '085123456789', 'Admin', 8),
(5, 'P004', 'Jisung', 'Jakarta Timur', '085123456789', 'Operator Gudang', 9),
(6, 'P005', 'Rahul', 'Jakarta Timur', '085123456789', 'Kurir', 10),
(7, 'P006', 'Ezi', 'Jakarta Timur', '085123456789', 'Kurir', 11),
(8, 'P007', 'Lihan', 'Jakarta Timur', '085123456789', 'Staff Gudang', 12),
(9, 'P008', 'Ridho', 'Jakarta Timur', '085123456789', 'Staff Gudang', 13);

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id_pengaturan` int NOT NULL,
  `nama` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `isi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`id_pengaturan`, `nama`, `isi`) VALUES
(1, 'jatah_cuti', '12');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int NOT NULL,
  `nama_lengkap` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `level` enum('Admin','Pegawai','Kepala Cabang') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama_lengkap`, `username`, `password`, `level`) VALUES
(1, 'Administrator', 'admin', '$2y$10$JRPmBNdGI1afdZet3GAS4eSepkuhaxbBqBqmrTbpyWrVlZ0.bvBA.', 'Admin'),
(6, 'Icha', 'icha', '$2y$10$lHP03vhjvFzSvGEYBfR1eeO2pXT9aLxXvq5e9jzF.MZeoDEchGwi6', 'Pegawai'),
(7, 'Adel', 'adel', '$2y$10$.6fWS1031NywfflLe/h8w.cLAUyJFcirWtAif7P0FBaaA2TSmVqf2', 'Pegawai'),
(8, 'Yanti', 'yanti', '$2y$10$cG1NE/QKj2oq5HbSldCAY.LKi6cqA5rAOCh/xSX40pglF.p5YbcTG', 'Pegawai'),
(9, 'Jisung', 'jisung', '$2y$10$JM.8TDRWMLshACdOwof6nuECJ6yXh9AgwJSi8rynLnyYbC499/kDa', 'Pegawai'),
(10, 'Rahul', 'rahul', '$2y$10$NUqIiPw3KdswASI7OBPz1uS/MtIaU0SJKjRNdJkMMK3Hp3DtxPrxi', 'Pegawai'),
(11, 'Ezi', 'ezi', '$2y$10$tG.YmdUubBV061xM2L5qvelc99wYaQPLo/Ci1jlLrEAJgnSSpqF2e', 'Pegawai'),
(12, 'Lihan', 'lihan', '$2y$10$xyChqtwjmmszOxUFedlXpuGq6gWkkvA2HdGKpeJz9eeZLvQkzKHRy', 'Pegawai'),
(13, 'Ridho', 'ridho', '$2y$10$sx3Cs42fudsctSox0oSy0ucrELTCp8ezhxf2R6Ow5oorhXPyKDxUq', 'Pegawai'),
(15, 'Jajang Mulyana', 'jajang', '$2y$10$XsUvzOJ5jHbr4WBxy7VY5.2K4TE7ZwpJTvf1UbESM2mmIXEJbNlAa', 'Kepala Cabang');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan`
--

CREATE TABLE `permintaan` (
  `id_permintaan` int NOT NULL,
  `id_pegawai` int NOT NULL,
  `tgl_permintaan` date NOT NULL,
  `jenis` enum('Off','Cuti','Izin') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pesan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Menunggu','Diterima','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permintaan`
--

INSERT INTO `permintaan` (`id_permintaan`, `id_pegawai`, `tgl_permintaan`, `jenis`, `pesan`, `status`, `keterangan`) VALUES
(1, 2, '2024-02-09', 'Izin', 'Ada acara keluarga', 'Ditolak', 'Gak bisa, lagi overload'),
(2, 3, '2024-02-12', 'Off', 'Mau istirahat', 'Diterima', ''),
(3, 2, '2024-05-22', 'Izin', 'Mau liburan', 'Diterima', 'Selamat liburan');

-- --------------------------------------------------------

--
-- Table structure for table `presensi`
--

CREATE TABLE `presensi` (
  `id_presensi` int NOT NULL,
  `tanggal` date NOT NULL,
  `id_pegawai` int NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_pulang` time DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `foto` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `presensi`
--

INSERT INTO `presensi` (`id_presensi`, `tanggal`, `id_pegawai`, `jam_masuk`, `jam_pulang`, `status`, `foto`) VALUES
(2, '2023-12-31', 2, '08:10:15', '16:10:44', 1, NULL),
(3, '2023-12-31', 3, '08:16:13', '16:17:03', 1, NULL),
(6, '2024-01-01', 2, '08:38:34', '16:38:52', 1, NULL),
(7, '2024-01-01', 3, '08:56:59', '16:57:13', 1, NULL),
(8, '2024-01-01', 4, '08:29:08', '16:29:38', 1, NULL),
(9, '2024-01-01', 5, '08:43:10', '16:43:32', 1, NULL),
(10, '2024-01-01', 6, '08:53:43', '16:54:13', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indexes for table `libur`
--
ALTER TABLE `libur`
  ADD PRIMARY KEY (`id_libur`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id_pengaturan`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indexes for table `permintaan`
--
ALTER TABLE `permintaan`
  ADD PRIMARY KEY (`id_permintaan`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indexes for table `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id_presensi`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `libur`
--
ALTER TABLE `libur`
  MODIFY `id_libur` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id_pegawai` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id_pengaturan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `permintaan`
--
ALTER TABLE `permintaan`
  MODIFY `id_permintaan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id_presensi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permintaan`
--
ALTER TABLE `permintaan`
  ADD CONSTRAINT `permintaan_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `presensi`
--
ALTER TABLE `presensi`
  ADD CONSTRAINT `presensi_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
