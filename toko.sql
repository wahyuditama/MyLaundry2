-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2024 at 04:21 PM
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
-- Database: `toko`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(12) NOT NULL,
  `id_kategori` int(12) NOT NULL,
  `inv_barang` varchar(100) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `satuan` varchar(100) NOT NULL,
  `qty` int(100) NOT NULL,
  `harga` int(100) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `note` varchar(100) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `id_kategori`, `inv_barang`, `nama_barang`, `satuan`, `qty`, `harga`, `judul`, `deskripsi`, `note`, `foto`, `create_at`, `update_at`) VALUES
(26, 2, 'TRB-20241214021121', 'Le Mineral', 'Pcs', 9, 3000, 'css', 'lorem ipsum dolor site amet. powerfull agist overta magis furire osrete girada', 'lorem ipsum dolor site amet', 'le-inerale.jpg', '2024-12-12 05:53:01', '2024-12-15 16:14:23'),
(27, 1, 'TRB-20241214021141', 'Oreo', 'Pcs', 16, 50000, 'CSS', 'Powerful, extensible, and feature-packed frontend toolkit. Build and customize with Sass, utilize pr', 'lorem ipsum dolor site amet', 'oreo.jpg', '2024-12-12 05:54:06', '2024-12-15 16:13:31'),
(30, 1, 'TRB-20241214021225', 'Tanggo  Wafer', 'Pcs', 12, 6000, 'CSS', 'Powerful, extensible, and feature-packed frontend toolkit. ', 'lorem ipsum dolor site amet', 'tanggo-wafer.jpg', '2024-12-12 12:49:15', '2024-12-15 16:36:29'),
(31, 2, 'TRB-20241214021245', 'Teh Pucuk', 'Pcs', 12, 5000, 'CSS', 'Powerful, extensible, and feature-packed frontend toolkit. ', 'lorem ipsum dolor site amet', 'teh-pucuk.jpg', '2024-12-12 17:48:26', '2024-12-15 17:04:44'),
(34, 1, 'TRB-20241220025621', 'Sari Roti', 'Pcs', 21, 5000, 'CSS', 'Powerful, extensible, and feature-packed frontend toolkit. Build and customize with Sass, utilize pr', 'lorem ipsum dolor site amet', 'Sari Roti.png', '2024-12-15 14:54:12', '2024-12-20 13:57:56'),
(35, 1, 'TRB-20241220025825', 'Roma Malkis', 'Pcs', 16, 10000, 'CSS', 'Powerful, extensible, and feature-packed frontend toolkit. Build and customize with Sass, utilize pr', 'lorem ipsum dolor site amet', 'Roma-Malkis.jpg', '2024-12-15 16:09:03', '2024-12-20 13:59:08');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(12) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `no_telepon` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `nama_lengkap`, `no_telepon`, `alamat`, `create_at`, `update_at`) VALUES
(0, 'Arya Wiraguna', '566556', 'bandung', '2024-11-30 13:00:02', '2024-11-30 13:00:02'),
(0, 'ibnu ibrahim', '566556', 'jakarta', '2024-11-30 13:10:43', '2024-11-30 13:10:43');

-- --------------------------------------------------------

--
-- Table structure for table `detail_paket`
--

CREATE TABLE `detail_paket` (
  `id` int(12) NOT NULL,
  `id_penjualan` int(12) NOT NULL,
  `id_barang` int(12) NOT NULL,
  `jumlah` int(100) NOT NULL,
  `harga` double(10,2) NOT NULL,
  `total_harga` double(10,2) NOT NULL,
  `sub_total` double(10,2) NOT NULL,
  `nominal_bayar` double(10,2) NOT NULL,
  `kembalian` double(10,2) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_paket`
--

INSERT INTO `detail_paket` (`id`, `id_penjualan`, `id_barang`, `jumlah`, `harga`, `total_harga`, `sub_total`, `nominal_bayar`, `kembalian`, `create_at`, `update_at`) VALUES
(38, 39, 26, 1, 3000.00, 3000.00, 3000.00, 4000.00, 1000.00, '2024-12-14 19:10:07', '2024-12-14 19:10:07'),
(39, 40, 30, 2, 6000.00, 12000.00, 12000.00, 12000.00, 0.00, '2024-12-15 16:36:29', '2024-12-15 16:36:29');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_barang`
--

CREATE TABLE `kategori_barang` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_barang`
--

INSERT INTO `kategori_barang` (`id`, `nama_kategori`, `create_at`, `update_at`) VALUES
(1, 'Makanan', '2024-12-12 05:02:51', '2024-12-12 05:02:51'),
(2, 'Minuman', '2024-12-12 05:02:51', '2024-12-12 05:02:51'),
(3, 'Baju', '2024-12-12 05:03:03', '2024-12-12 05:03:03'),
(4, 'Celana', '2024-12-12 05:03:03', '2024-12-12 05:03:03');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` int(12) NOT NULL,
  `nama_level` varchar(100) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `nama_level`, `create_at`, `update_at`) VALUES
(1, 'admistrator', '2024-11-30 09:59:26', '2024-11-30 10:14:35'),
(2, 'pimpinan', '2024-11-30 10:24:28', '2024-11-30 10:24:28'),
(3, 'admin web', '2024-11-30 10:24:36', '2024-11-30 10:24:36'),
(5, 'Pengunjung', '2024-11-30 16:06:28', '2024-11-30 16:06:28');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id` int(12) NOT NULL,
  `id_user` int(11) NOT NULL,
  `kode_transaksi` varchar(100) DEFAULT NULL,
  `nama_pengguna` varchar(100) NOT NULL,
  `email_pengguna` varchar(100) NOT NULL,
  `telepon_pengguna` int(100) NOT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id`, `id_user`, `kode_transaksi`, `nama_pengguna`, `email_pengguna`, `telepon_pengguna`, `status`, `create_at`, `update_at`) VALUES
(35, 1, 'TR-20241214023158', 'admin', 'admin@gmail.com', 566556, 1, '2024-12-14 13:32:23', '2024-12-14 18:20:53'),
(37, 2, 'TR-20241214073855', 'admin', 'admin@gmail.com', 566556, 1, '2024-12-14 18:39:16', '2024-12-14 18:42:42'),
(38, 2, 'TR-20241214074446', 'admin', 'admin@gmail.com', 566556, 1, '2024-12-14 18:45:00', '2024-12-14 18:48:12'),
(39, 6, 'TR-20241214080944', 'yono', 'yono@gmail.com', 56655666, 1, '2024-12-14 19:10:07', '2024-12-14 19:11:07'),
(40, 2, 'TR-20241215053612', 'admin', 'admin@gmail.com', 566556, 0, '2024-12-15 16:36:29', '2024-12-15 16:36:29');

-- --------------------------------------------------------

--
-- Table structure for table `suggestion`
--

CREATE TABLE `suggestion` (
  `id` int(12) NOT NULL,
  `id_user` int(12) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `catatan` varchar(100) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suggestion`
--

INSERT INTO `suggestion` (`id`, `id_user`, `deskripsi`, `catatan`, `foto`, `create_at`, `update_at`) VALUES
(1, 1, 'ipsum dolor', 'lorem', '5.jpg', '2024-12-17 14:15:06', '2024-12-18 08:37:51'),
(38, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vitae tellus augue. Fusce gravida cu', 'lorm', '3.jpg', '2024-12-17 16:05:38', '2024-12-18 08:37:56'),
(42, 3, ' Morbi ut nisi fringilla nunc egestas venenatis at a nibh. Aenean in elit nec sapien ullamcorper rho', 'Anton Bastian', '19.jpg', '2024-12-17 16:14:33', '2024-12-18 08:38:01'),
(43, 1, ' Donec vel eros id metus bibendum eleifend in ut quam. Nam vehicula id orci et convallis.Agregos avi', 'lorem', '1.jpg', '2024-12-17 16:15:06', '2024-12-18 08:43:33'),
(44, 5, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vitae tellus augue. Fusce gravida cu', 'lorem', '', '2024-12-18 08:19:41', '2024-12-18 08:38:11');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(12) NOT NULL,
  `id_level` int(12) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telepon` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `id_level`, `nama_lengkap`, `email`, `no_telepon`, `alamat`, `password`, `foto`, `create_at`, `update_at`) VALUES
(1, 1, 'admin', 'admin@gmail.com', '566556', 'jakarta', '123', '', '2024-11-30 10:18:59', '2024-12-18 08:37:13'),
(2, 2, 'ibnu ibrahim', 'pimpinan@gmail.com', '566556', 'bandung', '123', '', '2024-11-30 14:28:41', '2024-12-18 08:37:20'),
(3, 3, 'yoimia', 'adminAPK@gmail.com', '566556', 'jakarta', '123', '', '2024-11-30 16:05:54', '2024-12-18 08:37:24'),
(4, 5, 'yono', 'yono@gmail.com', '56655666', 'jakarta', '123', '', '2024-11-30 16:06:58', '2024-12-18 08:37:28'),
(5, 5, 'budi aryanto', 'budiiskander@gmail.com', '88003084747', 'Uhledar', '123', '', '2024-12-14 20:30:01', '2024-12-18 08:37:33'),
(6, 5, 'ryo ibrahim', 'ryo@gmail.com', '7939393', 'Bogor', '123', '', '2024-12-14 20:59:05', '2024-12-18 08:37:38'),
(7, 5, 'yohan2', 'yohan@gmail.com', '566556', 'sukabumi', '123', '5.jpg', '2024-12-15 17:54:19', '2024-12-18 08:37:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `detail_paket`
--
ALTER TABLE `detail_paket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_paket_ibfk_2` (`id_barang`),
  ADD KEY `detail_paket_ibfk_3` (`id_penjualan`);

--
-- Indexes for table `kategori_barang`
--
ALTER TABLE `kategori_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suggestion`
--
ALTER TABLE `suggestion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_ibfk_1` (`id_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `detail_paket`
--
ALTER TABLE `detail_paket`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `kategori_barang`
--
ALTER TABLE `kategori_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `suggestion`
--
ALTER TABLE `suggestion`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_paket`
--
ALTER TABLE `detail_paket`
  ADD CONSTRAINT `detail_paket_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_paket_ibfk_3` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `suggestion`
--
ALTER TABLE `suggestion`
  ADD CONSTRAINT `suggestion_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_level`) REFERENCES `level` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
