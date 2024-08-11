-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 11, 2024 at 06:35 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bungasakti`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `idCustomer` varchar(8) NOT NULL,
  `companyName` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contactNumber` varchar(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`idCustomer`, `companyName`, `username`, `password`, `contactNumber`, `email`, `address`, `createdAt`, `updatedAt`, `isActive`) VALUES
('2a5ff0c7', 'Avery and Walls Plc', 'kytotuc', '$2y$10$43P4FCjLDKGv.vtP9iImDOWK0E.3ySI5uSz4.0feKn4', '123', 'bediz@mailinator.com', 'Dukuh Ngelorok, Nglorok, Campurejo, Kec. Boja, Kabupaten Kendal, Jawa Tengah 51381', '2024-07-30 20:18:37', '0000-00-00 00:00:00', 1),
('614bd60b', 'Blackburn and Stanley Co', 'cipomidi', '$2y$10$xTqAWoHIvQWO50UzMwMieOwBUd0ZdlDeKbZbO0fRI6J', '66', 'tarybe@mailinator.com', 'Ut incididunt tempor', '2024-07-30 20:25:17', '2024-07-30 22:30:58', 1),
('8416d803', 'Cameron Garrett Plc', 'jybew', '$2y$10$7YTjTDoLqIo4BBhj1x5xZ.pGny7hzmtmwdS9zF.aNuohLIhlpExVa', '764', 'prionakal@masholdings.com', 'Tempora corrupti ve', '2024-08-04 17:28:53', '0000-00-00 00:00:00', 1),
('c9ab2a8c', 'Shelton and Munoz Trading', 'negeveqyd', '$2y$10$Fps9UmFgqBtIeGnOMGChVeQ82Ah18hNaF4wPa9rK4NK', '620', 'zawicycilu@mailinator.com', 'Quam perspiciatis q', '2024-08-02 19:53:27', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `det_invoice`
--

CREATE TABLE `det_invoice` (
  `idDetInvoice` int(11) NOT NULL,
  `idInvoice` varchar(8) NOT NULL,
  `idDetOrder` int(11) NOT NULL,
  `qtyInvoice` int(11) NOT NULL,
  `remark` text NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `det_master_order`
--

CREATE TABLE `det_master_order` (
  `idDetOrder` int(11) NOT NULL,
  `idMasterOrder` varchar(10) NOT NULL,
  `idBarang` varchar(10) NOT NULL,
  `qtyOrder` int(11) NOT NULL,
  `qtyBalance` int(11) NOT NULL,
  `fixedPrice` int(11) NOT NULL,
  `total` bigint(20) NOT NULL,
  `statusQty` int(2) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `det_master_order`
--

INSERT INTO `det_master_order` (`idDetOrder`, `idMasterOrder`, `idBarang`, `qtyOrder`, `qtyBalance`, `fixedPrice`, `total`, `statusQty`, `createdAt`, `updatedAt`) VALUES
(1, '2f86ebae', 'de17ec85', 2, 2, 68900, 137800, 0, '2024-08-07 22:13:43', '0000-00-00 00:00:00'),
(2, '2f86ebae', 'c08a2705', 6, 6, 166, 996, 0, '2024-08-07 22:13:43', '0000-00-00 00:00:00'),
(3, '2f86ebae', '3d1ec619', 14, 14, 5500, 77000, 0, '2024-08-11 13:22:45', '0000-00-00 00:00:00'),
(4, '2f86ebae', 'c19758e5', 3, 3, 282, 846, 0, '2024-08-11 23:15:16', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `det_master_pembelian`
--

CREATE TABLE `det_master_pembelian` (
  `idDetPembelian` int(11) NOT NULL,
  `idPembelian` varchar(8) NOT NULL,
  `idStock` varchar(8) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `det_master_penjualan`
--

CREATE TABLE `det_master_penjualan` (
  `idDetPenjualan` int(11) NOT NULL,
  `idPenjualan` varchar(10) NOT NULL,
  `idStock` varchar(8) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `det_purchase_request`
--

CREATE TABLE `det_purchase_request` (
  `idDetPR` int(11) NOT NULL,
  `idPR` varchar(8) NOT NULL,
  `idBarang` varchar(10) DEFAULT NULL,
  `qtyOrder` int(11) NOT NULL,
  `descriptionCustom` text DEFAULT NULL,
  `remark` varchar(32) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `det_purchase_request`
--

INSERT INTO `det_purchase_request` (`idDetPR`, `idPR`, `idBarang`, `qtyOrder`, `descriptionCustom`, `remark`, `createdAt`, `updatedAt`) VALUES
(525, '80415fa6', 'de17ec85', 2, NULL, 'Veritatis dolore duc', '2024-08-03 18:05:31', '0000-00-00 00:00:00'),
(530, 'fdfd998a', '6824b145', 11, NULL, 'Oke', '2024-08-04 14:26:50', '2024-08-04 14:26:57'),
(532, '80415fa6', '3d1ec619', 14, 'Molestiae pariatur ', 'Laudantium dolorem ', '2024-08-04 15:07:48', '2024-08-11 13:22:45'),
(533, '80415fa6', 'c08a2705', 6, NULL, '', '2024-08-04 15:07:56', '0000-00-00 00:00:00'),
(534, '87e93e6e', 'c19758e5', 3, NULL, 'Ok', '2024-08-05 16:28:45', '0000-00-00 00:00:00'),
(535, '87e93e6e', NULL, 6, 'APa aja', 'ok', '2024-08-05 16:28:59', '0000-00-00 00:00:00'),
(536, '87e93e6e', NULL, 2, 'Cetak A3', '', '2024-08-05 17:51:57', '0000-00-00 00:00:00'),
(537, 'db67ddee', '127a01c6', 5, NULL, '', '2024-08-06 21:40:11', '0000-00-00 00:00:00'),
(538, 'db67ddee', '6824b145', 2, NULL, '', '2024-08-11 16:42:32', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `master_barang`
--

CREATE TABLE `master_barang` (
  `idBarang` varchar(10) NOT NULL,
  `barcode` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `mcRefrence` varchar(32) NOT NULL,
  `uom` varchar(16) NOT NULL,
  `totalStock` int(11) NOT NULL,
  `type` varchar(32) NOT NULL,
  `basePrice` int(11) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_barang`
--

INSERT INTO `master_barang` (`idBarang`, `barcode`, `description`, `mcRefrence`, `uom`, `totalStock`, `type`, `basePrice`, `createdAt`, `updatedAt`, `isActive`) VALUES
('127a01c6', '', 'Quia repudiandae qua', 'YUHE82', 'Aliquid enim mol', 0, 'READY', 392, '2024-07-31 21:48:32', '2024-08-06 21:39:35', 1),
('3d1ec619', '', 'Molestiae pariatur ', '', 'pcs', 0, 'CUSTOM', 5500, '2024-08-11 13:22:45', '0000-00-00 00:00:00', 1),
('6824b145', 'Molestiae nostrud iu', 'Reprehenderit sit e', 'Quia ad omnis conseq', 'Ut aute et sunt ', 0, 'CUSTOM', 841, '2024-07-31 21:49:02', '0000-00-00 00:00:00', 1),
('c08a2705', '', 'Ullam rerum similiqu', 'M009124', 'Ea voluptatem do', 0, 'READY', 166, '2024-07-31 21:48:17', '2024-08-06 21:39:48', 1),
('c19758e5', '', 'Sed veritatis dolore', '', 'Consequat Except', 0, 'READY', 282, '2024-07-31 21:48:46', '0000-00-00 00:00:00', 1),
('c9fbb68e', '', 'Laboriosam qui plac', '', 'Possimus quibusd', 0, 'CUSTOM', 1000, '2024-07-30 22:54:50', '0000-00-00 00:00:00', 0),
('de17ec85', 'Duis quis laborum E', 'Sit repudiandae dese', 'Debitis quibusdam ne', 'Voluptas ullamco', 0, 'CUSTOM', 68900, '2024-07-30 22:52:12', '2024-07-31 21:26:46', 1);

-- --------------------------------------------------------

--
-- Table structure for table `master_invoice`
--

CREATE TABLE `master_invoice` (
  `idInvoice` varchar(8) NOT NULL,
  `idSuratJalan` varchar(8) NOT NULL,
  `idMasterOrder` varchar(10) NOT NULL,
  `dueDate` date NOT NULL,
  `paymentDate` date NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  `status` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_order`
--

CREATE TABLE `master_order` (
  `idMasterOrder` varchar(10) NOT NULL,
  `idCustomer` varchar(8) NOT NULL,
  `idPR` varchar(8) DEFAULT NULL,
  `poRefrence` varchar(32) DEFAULT NULL,
  `poDate` date DEFAULT NULL,
  `status` varchar(32) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_order`
--

INSERT INTO `master_order` (`idMasterOrder`, `idCustomer`, `idPR`, `poRefrence`, `poDate`, `status`, `createdAt`, `updatedAt`, `isActive`) VALUES
('2f86ebae', '614bd60b', '80415fa6', '5443523', NULL, 'PROSES', '2024-08-07 22:13:43', '2024-08-10 07:27:24', 1);

-- --------------------------------------------------------

--
-- Table structure for table `master_pembelian`
--

CREATE TABLE `master_pembelian` (
  `idPembelian` varchar(8) NOT NULL,
  `issuingDate` date NOT NULL,
  `idUser` varchar(8) NOT NULL,
  `notaRefrence` varchar(50) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_penjualan`
--

CREATE TABLE `master_penjualan` (
  `idPenjualan` varchar(10) NOT NULL,
  `idToko` varchar(8) NOT NULL,
  `issuingDate` datetime NOT NULL,
  `idUser` varchar(8) NOT NULL,
  `customerName` varchar(32) NOT NULL,
  `remark` text NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_toko`
--

CREATE TABLE `master_toko` (
  `idToko` varchar(8) NOT NULL,
  `namaToko` varchar(50) NOT NULL,
  `address` text DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  `lastActive` datetime NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_toko`
--

INSERT INTO `master_toko` (`idToko`, `namaToko`, `address`, `createdAt`, `updatedAt`, `lastActive`, `isActive`) VALUES
('a2a77061', 'Toko Boja', 'Campurejo Semarang', '2024-07-29 22:31:37', '2024-07-29 22:35:14', '0000-00-00 00:00:00', 1),
('decb2bcf', 'Toko Semarang', 'Banyumanik', '2024-07-29 22:47:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
('eaf29525', 'Toko Gading', 'Gading Serpong', '2024-07-29 22:35:30', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_request`
--

CREATE TABLE `purchase_request` (
  `idPR` varchar(8) NOT NULL,
  `datePR` date NOT NULL,
  `idCustomer` varchar(8) NOT NULL,
  `priority` varchar(10) NOT NULL,
  `status` varchar(16) NOT NULL,
  `remark` text NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_request`
--

INSERT INTO `purchase_request` (`idPR`, `datePR`, `idCustomer`, `priority`, `status`, `remark`, `createdAt`, `updatedAt`, `isActive`) VALUES
('80415fa6', '2014-02-08', '614bd60b', 'Normal', 'ORDER', 'Odio tempor laborum', '2024-08-02 21:49:49', '2024-08-07 21:58:36', 1),
('87e93e6e', '2024-08-05', '8416d803', 'Normal', 'SUBMIT', 'PO setelah quotation', '2024-08-05 16:17:44', '2024-08-05 17:53:14', 1),
('db67ddee', '0000-00-00', '8416d803', '', 'PENDING', '', '2024-08-05 17:53:25', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stock_issued`
--

CREATE TABLE `stock_issued` (
  `id` int(11) NOT NULL,
  `idDetOrder` int(11) NOT NULL,
  `idStock` varchar(10) NOT NULL,
  `qtyIssued` int(11) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `toko_stock`
--

CREATE TABLE `toko_stock` (
  `idStock` varchar(8) NOT NULL,
  `idToko` varchar(8) NOT NULL,
  `idBarang` varchar(10) NOT NULL,
  `qtyStock` int(11) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `toko_stock`
--

INSERT INTO `toko_stock` (`idStock`, `idToko`, `idBarang`, `qtyStock`, `createdAt`, `updatedAt`, `isActive`) VALUES
('3fc8911b', 'a2a77061', 'de17ec85', 11, '2024-08-01 20:37:42', '2024-08-01 20:37:51', 1),
('4b9fd428', 'a2a77061', '6824b145', 30, '2024-08-01 20:40:28', '0000-00-00 00:00:00', 1),
('514ebf3a', 'decb2bcf', 'c19758e5', 4, '2024-08-01 20:40:57', '0000-00-00 00:00:00', 1),
('6a5e8924', 'decb2bcf', '6824b145', 15, '2024-08-01 20:40:50', '0000-00-00 00:00:00', 1),
('bef7886b', 'decb2bcf', 'de17ec85', 8, '2024-08-01 20:40:43', '0000-00-00 00:00:00', 1),
('f1edcfa9', 'a2a77061', 'c19758e5', 40, '2024-08-05 17:48:26', '2024-08-05 17:48:36', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `idUser` varchar(8) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `idToko` varchar(8) DEFAULT NULL,
  `level` varchar(10) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1,
  `lastLogin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `name`, `username`, `password`, `idToko`, `level`, `createdAt`, `updatedAt`, `isActive`, `lastLogin`) VALUES
('558ba751', 'Prionaka Luthfi', 'admin', '$2y$10$SIMPtxCPwRRT1K.IhlcXjO/E23qrqxO5kMa3abUTejiQp9F0.8Abm', 'decb2bcf', 'ADMIN', '2024-07-28 23:14:00', '2024-07-29 22:53:10', 1, '2024-08-11 23:14:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`idCustomer`);

--
-- Indexes for table `det_invoice`
--
ALTER TABLE `det_invoice`
  ADD PRIMARY KEY (`idDetInvoice`);

--
-- Indexes for table `det_master_order`
--
ALTER TABLE `det_master_order`
  ADD PRIMARY KEY (`idDetOrder`);

--
-- Indexes for table `det_master_pembelian`
--
ALTER TABLE `det_master_pembelian`
  ADD PRIMARY KEY (`idDetPembelian`);

--
-- Indexes for table `det_master_penjualan`
--
ALTER TABLE `det_master_penjualan`
  ADD PRIMARY KEY (`idDetPenjualan`);

--
-- Indexes for table `det_purchase_request`
--
ALTER TABLE `det_purchase_request`
  ADD PRIMARY KEY (`idDetPR`);

--
-- Indexes for table `master_barang`
--
ALTER TABLE `master_barang`
  ADD PRIMARY KEY (`idBarang`);

--
-- Indexes for table `master_invoice`
--
ALTER TABLE `master_invoice`
  ADD PRIMARY KEY (`idInvoice`);

--
-- Indexes for table `master_order`
--
ALTER TABLE `master_order`
  ADD PRIMARY KEY (`idMasterOrder`);

--
-- Indexes for table `master_pembelian`
--
ALTER TABLE `master_pembelian`
  ADD PRIMARY KEY (`idPembelian`);

--
-- Indexes for table `master_penjualan`
--
ALTER TABLE `master_penjualan`
  ADD PRIMARY KEY (`idPenjualan`);

--
-- Indexes for table `master_toko`
--
ALTER TABLE `master_toko`
  ADD PRIMARY KEY (`idToko`);

--
-- Indexes for table `purchase_request`
--
ALTER TABLE `purchase_request`
  ADD PRIMARY KEY (`idPR`);

--
-- Indexes for table `stock_issued`
--
ALTER TABLE `stock_issued`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `toko_stock`
--
ALTER TABLE `toko_stock`
  ADD PRIMARY KEY (`idStock`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `det_invoice`
--
ALTER TABLE `det_invoice`
  MODIFY `idDetInvoice` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `det_master_order`
--
ALTER TABLE `det_master_order`
  MODIFY `idDetOrder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `det_master_pembelian`
--
ALTER TABLE `det_master_pembelian`
  MODIFY `idDetPembelian` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `det_master_penjualan`
--
ALTER TABLE `det_master_penjualan`
  MODIFY `idDetPenjualan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `det_purchase_request`
--
ALTER TABLE `det_purchase_request`
  MODIFY `idDetPR` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=539;

--
-- AUTO_INCREMENT for table `stock_issued`
--
ALTER TABLE `stock_issued`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
