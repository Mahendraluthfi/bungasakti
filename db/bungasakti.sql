-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 26, 2024 at 03:01 PM
-- Server version: 8.0.30
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `password` varchar(50) NOT NULL,
  `contactNumber` varchar(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  `isActive` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `det_invoice`
--

CREATE TABLE `det_invoice` (
  `idDetInvoice` int NOT NULL,
  `idInvoice` varchar(8) NOT NULL,
  `idDetOrder` int NOT NULL,
  `qtyInvoice` int NOT NULL,
  `remark` text NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `det_master_order`
--

CREATE TABLE `det_master_order` (
  `idDetOrder` int NOT NULL,
  `idMasterOrder` varchar(10) NOT NULL,
  `idBarang` varchar(10) NOT NULL,
  `qtyOrder` int NOT NULL,
  `qtyBalance` int NOT NULL,
  `fixedPrice` int NOT NULL,
  `total` bigint NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `det_master_pembelian`
--

CREATE TABLE `det_master_pembelian` (
  `idDetPembelian` int NOT NULL,
  `idPembelian` varchar(8) NOT NULL,
  `idStock` varchar(8) NOT NULL,
  `qty` int NOT NULL,
  `price` int NOT NULL,
  `total` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `det_master_penjualan`
--

CREATE TABLE `det_master_penjualan` (
  `idDetPenjualan` int NOT NULL,
  `idPenjualan` varchar(10) NOT NULL,
  `idStock` varchar(8) NOT NULL,
  `qty` int NOT NULL,
  `total` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `det_purchase_request`
--

CREATE TABLE `det_purchase_request` (
  `idDetPR` int NOT NULL,
  `idPR` varchar(8) NOT NULL,
  `idBarang` varchar(10) NOT NULL,
  `qtyOrder` int NOT NULL,
  `descriptionCustom` text,
  `status` varchar(32) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `totalStock` int NOT NULL,
  `type` varchar(32) NOT NULL,
  `basePrice` int NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  `isActive` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `isActive` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `master_pembelian`
--

CREATE TABLE `master_pembelian` (
  `idPembelian` varchar(8) NOT NULL,
  `issuingDate` date NOT NULL,
  `idUser` varchar(8) NOT NULL,
  `notaRefrence` varchar(50) DEFAULT NULL,
  `remark` text,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `master_toko`
--

CREATE TABLE `master_toko` (
  `idToko` varchar(8) NOT NULL,
  `namaToko` varchar(50) NOT NULL,
  `address` text,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  `isActive` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_request`
--

CREATE TABLE `purchase_request` (
  `idPR` varchar(8) NOT NULL,
  `idCustomer` varchar(8) NOT NULL,
  `status` varchar(16) NOT NULL,
  `remark` text NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  `isActive` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `toko_stock`
--

CREATE TABLE `toko_stock` (
  `idStock` varchar(8) NOT NULL,
  `idToko` varchar(8) NOT NULL,
  `idBarang` varchar(10) NOT NULL,
  `qtyStock` int NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  `isActive` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `idUser` varchar(8) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `idToko` varchar(8) NOT NULL,
  `level` varchar(10) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  `isActive` int NOT NULL DEFAULT '1',
  `lastLogin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  MODIFY `idDetInvoice` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `det_master_order`
--
ALTER TABLE `det_master_order`
  MODIFY `idDetOrder` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `det_master_pembelian`
--
ALTER TABLE `det_master_pembelian`
  MODIFY `idDetPembelian` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `det_master_penjualan`
--
ALTER TABLE `det_master_penjualan`
  MODIFY `idDetPenjualan` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `det_purchase_request`
--
ALTER TABLE `det_purchase_request`
  MODIFY `idDetPR` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
