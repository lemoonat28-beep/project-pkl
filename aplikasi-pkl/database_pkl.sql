-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2026 at 08:57 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database_pkl`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_admin` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `nama_admin`) VALUES
(1, 'admin', '$2y$10$45z0AevJ1uT540f353B9lO2jG0vA./2354a3s21245643a5323a', 'admin-ubl'),
(2, 'admin12', 'admin123', 'admin-ubl');

-- --------------------------------------------------------

--
-- Table structure for table `pekerja`
--

CREATE TABLE `pekerja` (
  `id` int(11) NOT NULL,
  `nama_pendek` varchar(50) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_telp` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `foto` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pekerja`
--

INSERT INTO `pekerja` (`id`, `nama_pendek`, `nama_lengkap`, `role`, `alamat`, `email`, `password`, `no_telp`, `status`, `foto`, `created_at`) VALUES
(1, 'gufron', 'agus suryani', 'karyawan', 'Kotagajah', 'gugugaga@gmail.com', '$2y$10$4aMDg6P9mF8Hd.bakD3jDuGBabxEFTZOAxdTidyUzUsK0xUoFgwS.', '083112324321', 'Pekerja Tetap', 'uploads/1786704451_6a7ef2436781d.png', '2026-08-14 10:47:31'),
(2, 'ijen', 'zeantristyan', 'IT Support', 'Tangerang Kota', 'juju@gmail.com', '$2y$10$WvAS0ZTMEfsrYo1PFajTe.S0NtuUJiI6TVClAl3..uQPaO2DiedWq', '083112324322', 'Pekerja Tetap', 'uploads/1786704606_6a7ef2de91433.jpeg', '2026-08-14 10:50:06'),
(3, 'danz', 'akhdan', 'kepala divisi', 'lampung', 'danz@gmail.com', '$2y$10$ubwQ6NmrQd4uguqqCJcVYeckIbywzig0xE8RrNdTuxxY/jossYCF6', '088286894573', 'Magang', 'uploads/1787881721_6a90e8f9cfb49.png', '2026-08-17 15:26:49'),
(4, 'wang', 'wangsun', 'gubaba', 'jabar', 'wang@gmail.com', '$2y$10$c3PK7PwNAHNCxo.3YQfIMu0oudLz4gQ72XUWdtBHKK7csIWP8F9.2', '088286894573', 'Kontrak', 'uploads/1787881709_6a90e8ed0c1b8.png', '2026-08-17 16:02:22'),
(5, 'iput padang', 'iputrirorojongrang', 'manager', 'padang', 'iputpadang@gmail.com', '$2y$10$cU3sdiKH3n0hWcLQ1oZPQeatAnIfzdvT1ZmF/L.GMVLC74wBMhNse', '084531678039', 'Pekerja Tetap', 'uploads/1787881981_6a90e9fd36f53.png', '2026-08-28 01:53:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `pekerja`
--
ALTER TABLE `pekerja`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pekerja`
--
ALTER TABLE `pekerja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
