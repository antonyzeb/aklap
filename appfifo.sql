-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Nov 29, 2022 at 01:12 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appfifo`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `kobar` varchar(4) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `hargajual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`kobar`, `nama_barang`, `hargajual`) VALUES
('B001', 'Ayam Boiler', 25000),
('B002', 'Roti Sari Rasa', 0),
('B003', 'Keju Batang', 15000),
('B004', 'Pudding', 0),
('B005', 'Susu segar', 0),
('B006', 'Voucer telkomsel', 0);

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id_keluar` varchar(11) NOT NULL,
  `tgl_keluar` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_keluar`
--

INSERT INTO `barang_keluar` (`id_keluar`, `tgl_keluar`) VALUES
('BK221128001', '2022-11-28 22:44:12'),
('BK221129001', '2022-11-28 23:12:55'),
('BK221130001', '2022-11-29 23:56:42');

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_masuk` varchar(11) NOT NULL,
  `tgl_masuk` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `suplier_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_masuk`
--

INSERT INTO `barang_masuk` (`id_masuk`, `tgl_masuk`, `suplier_id`) VALUES
('BM221128001', '2022-11-27 15:40:42', 1),
('BM221128002', '2022-11-28 15:41:57', 1),
('BM221129001', '2022-11-28 23:55:35', 1),
('BM221129002', '2022-11-28 23:56:13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `detail_barang_keluar`
--

CREATE TABLE `detail_barang_keluar` (
  `id` bigint(20) NOT NULL,
  `id_keluar` varchar(11) NOT NULL,
  `kobar` varchar(4) NOT NULL,
  `qty` int(3) NOT NULL,
  `id_masuk` varchar(11) NOT NULL,
  `hjual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_barang_keluar`
--

INSERT INTO `detail_barang_keluar` (`id`, `id_keluar`, `kobar`, `qty`, `id_masuk`, `hjual`) VALUES
(19, 'BK221128001', 'b001', 3, 'BM221128001', 25000),
(20, 'BK221129001', 'b001', 2, 'BM221128001', 25000),
(21, 'BK221130001', 'b003', 7, 'BM221129001', 15000);

-- --------------------------------------------------------

--
-- Table structure for table `detail_barang_masuk`
--

CREATE TABLE `detail_barang_masuk` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_masuk` varchar(11) NOT NULL,
  `kobar` varchar(20) NOT NULL,
  `qty` int(11) NOT NULL,
  `sisa` int(11) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_barang_masuk`
--

INSERT INTO `detail_barang_masuk` (`id`, `id_masuk`, `kobar`, `qty`, `sisa`, `harga`) VALUES
(18, 'BM221128001', 'b001', 5, 0, 20000),
(19, 'BM221128002', 'b001', 10, 10, 20000),
(20, 'BM221129001', 'B003', 10, 3, 10000),
(21, 'BM221129002', 'b003', 3, 3, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `suplier`
--

CREATE TABLE `suplier` (
  `idsup` int(11) NOT NULL,
  `namasup` varchar(191) NOT NULL,
  `hpsup` varchar(15) NOT NULL,
  `alamatsup` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `suplier`
--

INSERT INTO `suplier` (`idsup`, `namasup`, `hpsup`, `alamatsup`) VALUES
(1, 'PT ALJONO x', '098888551', 'jl kebagusan raya no 88 Jaksel x');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stok`
--

CREATE TABLE `tbl_stok` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stok` int(11) NOT NULL,
  `trxid` varchar(90) NOT NULL,
  `type` varchar(90) NOT NULL,
  `kobar` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_stok`
--

INSERT INTO `tbl_stok` (`id`, `stok`, `trxid`, `type`, `kobar`) VALUES
(1, 0, 'BM221128001', 'masuk', 'b001'),
(2, 5, 'BM221128002', 'masuk', 'b001'),
(3, 15, 'BK221128001', 'keluar', 'b001'),
(4, 12, 'BK221129001', 'keluar', 'b001'),
(5, 0, 'BM221129001', 'masuk', 'B003'),
(6, 10, 'BM221129002', 'masuk', 'b003'),
(7, 13, 'BK221130001', 'keluar', 'b003');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `def_pass` varchar(250) NOT NULL,
  `email` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `name`, `username`, `password`, `def_pass`, `email`, `details`, `image`) VALUES
(1, 'Mas Admin', 'admin', '$2y$10$e54aCJAR2CL9TvD1pdqa8eZcP4cnXblyM6WTj15NdN54fo7kHtUc2', 'admin', 'fauzimuhammad1605@gmail.com', 'holaaa', 'e414a85bbc.jpg'),
(4, 'sujono', 'sujono', '$2y$10$ty6jfo693T9Wu9TyAywNNu3WhTdVjqdIygcR2nk8e93XeIM8paG0q', 'jono', 'sujoco@gmail.com', 'sujono', '9d20b375f4.jpg'),
(9, 'jodi', 'jodi', '$2y$10$f/UlmpJyIKZ90qMQuJXYA.pmrRvP2l6Wq1ZLgPS941lOar9Qo18.O', 'jodi', 'jodi@gmail.com', 'saya jodi ', '59a258695c.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kobar`);

--
-- Indexes for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id_keluar`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_masuk`),
  ADD KEY `suplier_id` (`suplier_id`);

--
-- Indexes for table `detail_barang_keluar`
--
ALTER TABLE `detail_barang_keluar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_keluar` (`id_keluar`),
  ADD KEY `kobar` (`kobar`),
  ADD KEY `id_masuk` (`id_masuk`);

--
-- Indexes for table `detail_barang_masuk`
--
ALTER TABLE `detail_barang_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_masuk` (`id_masuk`),
  ADD KEY `kobar` (`kobar`);

--
-- Indexes for table `suplier`
--
ALTER TABLE `suplier`
  ADD PRIMARY KEY (`idsup`);

--
-- Indexes for table `tbl_stok`
--
ALTER TABLE `tbl_stok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trxid` (`trxid`),
  ADD KEY `type` (`type`),
  ADD KEY `kobar` (`kobar`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_barang_keluar`
--
ALTER TABLE `detail_barang_keluar`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `detail_barang_masuk`
--
ALTER TABLE `detail_barang_masuk`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `suplier`
--
ALTER TABLE `suplier`
  MODIFY `idsup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_stok`
--
ALTER TABLE `tbl_stok`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
