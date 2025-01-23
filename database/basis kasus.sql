-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Agu 2024 pada 08.48
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ikan_air_tawar`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `datasave`
--

CREATE TABLE `datasave` (
  `id` int(11) NOT NULL,
  `jenis_ikan` varchar(255) NOT NULL,
  `suhu_air_min` decimal(4,2) NOT NULL,
  `suhu_air_max` decimal(4,2) NOT NULL,
  `pH_min` decimal(3,1) NOT NULL,
  `pH_max` decimal(3,1) NOT NULL,
  `DO_min` decimal(4,2) NOT NULL,
  `DO_max` decimal(4,2) NOT NULL,
  `amonia_min` decimal(5,3) NOT NULL,
  `amonia_max` decimal(5,3) NOT NULL,
  `TDS_min` int(11) NOT NULL,
  `TDS_max` int(11) NOT NULL,
  `ketinggian_min` int(11) NOT NULL,
  `ketinggian_max` int(11) NOT NULL,
  `suhu_udara_min` decimal(4,2) NOT NULL,
  `suhu_udara_max` decimal(4,2) NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ikan`
--

CREATE TABLE `ikan` (
  `id` int(11) NOT NULL,
  `jenis_ikan` varchar(255) NOT NULL,
  `suhu_air_min` decimal(4,2) NOT NULL,
  `suhu_air_max` decimal(4,2) NOT NULL,
  `pH_min` decimal(3,1) NOT NULL,
  `pH_max` decimal(3,1) NOT NULL,
  `DO_min` decimal(4,2) NOT NULL,
  `DO_max` decimal(4,2) NOT NULL,
  `amonia_min` decimal(5,3) NOT NULL,
  `amonia_max` decimal(5,3) NOT NULL,
  `TDS_min` int(11) NOT NULL,
  `TDS_max` int(11) NOT NULL,
  `ketinggian_min` int(11) NOT NULL,
  `ketinggian_max` int(11) NOT NULL,
  `suhu_udara_min` decimal(4,2) NOT NULL,
  `suhu_udara_max` decimal(4,2) NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ikan`
--

INSERT INTO `ikan` (`id`, `jenis_ikan`, `suhu_air_min`, `suhu_air_max`, `pH_min`, `pH_max`, `DO_min`, `DO_max`, `amonia_min`, `amonia_max`, `TDS_min`, `TDS_max`, `ketinggian_min`, `ketinggian_max`, `suhu_udara_min`, `suhu_udara_max`, `gambar`) VALUES
(1, 'Ikan Bawal', 26.00, 28.00, 7.0, 7.5, 4.10, 5.00, 0.000, 0.500, 0, 50, 151, 200, 26.00, 28.00, 'bawal.jpg'),
(2, 'Ikan Bawal', 29.00, 31.00, 7.6, 8.0, 5.10, 6.00, 0.600, 1.000, 51, 100, 201, 250, 29.00, 31.00, 'bawal.jpg'),
(3, 'Ikan Bawal', 32.00, 33.00, 7.6, 8.0, 5.10, 6.00, 0.600, 1.000, 51, 100, 251, 300, 32.00, 35.00, 'bawal.jpg'),
(4, 'Ikan Lele', 26.00, 28.00, 6.5, 7.0, 3.00, 4.00, 0.000, 0.500, 0, 50, 0, 50, 29.00, 31.00, 'lele.jpg'),
(5, 'Ikan Lele', 29.00, 31.00, 7.1, 7.5, 3.00, 4.00, 0.000, 0.500, 0, 50, 51, 100, 29.00, 31.00, 'lele.jpg'),
(6, 'Ikan Lele', 32.00, 33.00, 7.6, 8.0, 3.00, 4.00, 0.600, 1.000, 51, 100, 51, 100, 29.00, 31.00, 'lele.jpg'),
(7, 'Ikan Lele', 32.00, 33.00, 8.1, 8.5, 3.00, 4.00, 0.600, 1.000, 51, 100, 101, 150, 32.00, 35.00, 'lele.jpg'),
(8, 'Ikan  Lele', 32.00, 33.00, 8.6, 9.0, 3.00, 4.00, 0.600, 1.000, 51, 100, 101, 150, 32.00, 35.00, 'lele.jpg'),
(9, 'Ikan Gabus', 26.00, 28.00, 6.5, 7.0, 3.00, 4.00, 0.000, 0.050, 0, 50, 151, 200, 26.00, 28.00, 'gabus.jpg'),
(10, 'Ikan Gabus', 29.00, 31.00, 7.1, 7.5, 3.00, 4.00, 0.000, 0.050, 51, 100, 151, 200, 26.00, 28.00, 'gabus.jpg'),
(11, 'Ikan Gabus', 32.00, 33.00, 7.6, 8.0, 4.00, 4.00, 0.000, 0.050, 101, 150, 251, 300, 29.00, 31.00, 'gabus.jpg'),
(12, 'Ikan Gabus', 32.00, 33.00, 8.1, 8.5, 3.00, 4.00, 0.060, 0.090, 151, 200, 201, 250, 29.00, 31.00, 'gabus.jpg'),
(13, 'Ikan Gabus', 32.00, 33.00, 8.6, 9.0, 3.00, 4.00, 0.060, 0.090, 201, 250, 251, 300, 32.00, 35.00, 'gabus.jpg'),
(14, 'Ikan Gabus', 32.00, 33.00, 8.6, 9.0, 3.00, 4.00, 0.060, 0.090, 251, 300, 251, 300, 32.00, 35.00, 'gabus.jpg'),
(15, 'Ikan Gurami', 26.00, 28.00, 6.5, 7.0, 3.00, 4.00, 0.000, 0.050, 0, 50, 0, 50, 26.00, 28.00, 'gurami.jpg'),
(16, 'Ikan Gurami', 29.00, 31.00, 7.1, 7.5, 3.00, 4.00, 0.060, 1.000, 0, 50, 0, 50, 29.00, 31.00, 'gurami.jpg'),
(17, 'Ikan Gurami', 32.00, 33.00, 7.6, 8.0, 3.00, 4.00, 0.060, 1.000, 51, 100, 51, 100, 29.00, 31.00, 'gurami.jpg'),
(18, 'Ikan Gurami', 32.00, 33.00, 8.1, 8.5, 3.00, 4.00, 0.200, 0.500, 51, 100, 51, 100, 32.00, 35.00, 'gurami.jpg'),
(19, 'Ikan Gurami', 32.00, 33.00, 8.6, 9.0, 3.00, 4.00, 0.200, 0.500, 51, 100, 51, 100, 32.00, 35.00, 'gurami.jpg'),
(20, 'Ikan Mas', 20.00, 22.00, 7.1, 7.5, 5.10, 6.00, 0.000, 0.050, 0, 50, 151, 200, 20.00, 22.00, 'mas.jpg'),
(21, 'Ikan Mas', 23.00, 25.00, 7.6, 8.0, 5.10, 6.00, 0.060, 0.090, 51, 100, 251, 300, 23.00, 25.00, 'mas.jpg'),
(22, 'Ikan Mas', 23.00, 25.00, 7.6, 8.0, 5.10, 6.00, 0.060, 0.090, 51, 100, 251, 300, 23.00, 25.00, 'mas.jpg'),
(23, 'Ikan Mas', 23.00, 25.00, 7.6, 8.0, 5.10, 6.00, 0.060, 0.090, 51, 100, 251, 300, 23.00, 25.00, 'mas.jpg'),
(24, 'Ikan Mujair', 26.00, 28.00, 7.0, 7.5, 5.10, 6.00, 0.000, 0.500, 0, 50, 151, 200, 26.00, 28.00, 'mujair.jpg'),
(25, 'Ikan Mujair', 29.00, 31.00, 7.6, 8.0, 5.10, 6.00, 0.000, 0.500, 0, 50, 151, 200, 29.00, 31.00, 'mujair.jpg'),
(26, 'Ikan Mujair', 32.00, 33.00, 8.1, 8.5, 5.10, 6.00, 0.600, 1.000, 51, 100, 251, 300, 32.00, 35.00, 'mujair.jpg'),
(27, 'Ikan Mujair', 32.00, 33.00, 8.6, 9.0, 5.10, 6.00, 0.600, 1.000, 51, 100, 251, 300, 32.00, 35.00, 'mujair.jpg'),
(28, 'Ikan Patin', 26.00, 28.00, 8.1, 8.5, 5.10, 6.00, 0.000, 0.500, 0, 50, 0, 50, 26.00, 28.00, 'patin.jpg'),
(29, 'Ikan Patin', 29.00, 31.00, 8.1, 8.5, 5.10, 6.00, 0.000, 0.500, 0, 50, 51, 100, 29.00, 31.00, 'patin.jpg'),
(30, 'Ikan Patin', 32.00, 33.00, 8.6, 9.0, 6.10, 7.00, 0.600, 1.000, 51, 100, 101, 150, 32.00, 35.00, 'patin.jpg'),
(31, 'Ikan Patin', 32.00, 33.00, 8.6, 9.0, 6.10, 7.00, 0.600, 1.000, 51, 100, 101, 150, 32.00, 35.00, 'patin.jpg'),
(32, 'Ikan Nilem', 26.00, 28.00, 7.1, 7.5, 5.10, 6.00, 0.000, 0.050, 0, 50, 301, 350, 26.00, 28.00, 'nilem.jpg'),
(33, 'Ikan Nilem', 26.00, 28.00, 7.1, 7.5, 5.10, 6.00, 0.000, 0.050, 51, 100, 351, 400, 26.00, 28.00, 'nilem.jpg'),
(34, 'Ikan Nilem', 29.00, 31.00, 7.6, 8.0, 5.10, 6.00, 0.600, 1.000, 101, 150, 401, 450, 29.00, 31.00, 'nilem.jpg'),
(35, 'Ikan Nilem', 29.00, 31.00, 7.6, 8.0, 5.10, 6.00, 0.600, 1.000, 151, 200, 401, 450, 29.00, 31.00, 'nilem.jpg'),
(36, 'Ikan Nilem', 32.00, 33.00, 7.6, 8.0, 5.10, 6.00, 0.200, 0.500, 201, 250, 451, 500, 32.00, 35.00, 'nilem.jpg'),
(37, 'Ikan Nilem', 32.00, 33.00, 7.6, 8.0, 5.10, 6.00, 0.200, 0.500, 251, 300, 451, 500, 32.00, 35.00, 'nilem.jpg'),
(38, 'Ikan Nila', 26.00, 28.00, 7.1, 7.5, 5.10, 6.00, 0.000, 0.050, 0, 50, 0, 50, 26.00, 28.00, 'nila.jpg'),
(39, 'Ikan Nila', 29.00, 31.00, 7.6, 8.0, 5.10, 6.00, 0.060, 0.100, 0, 50, 51, 100, 26.00, 28.00, 'nila.jpg'),
(40, 'Ikan Nila', 29.00, 31.00, 8.1, 8.5, 5.10, 6.00, 0.060, 0.100, 51, 100, 51, 100, 29.00, 31.00, 'nila.jpg'),
(41, 'Ikan Nila', 32.00, 33.00, 8.6, 9.0, 5.10, 6.00, 0.200, 0.500, 51, 100, 101, 150, 32.00, 35.00, 'nila.jpg'),
(42, 'Ikan Nila', 32.00, 33.00, 8.1, 8.5, 5.10, 6.00, 0.200, 0.500, 51, 100, 101, 150, 32.00, 35.00, 'nila.jpg'),
(43, 'Ikan Tawes', 26.00, 28.00, 6.5, 7.0, 5.10, 6.00, 0.000, 0.050, 0, 50, 0, 50, 26.00, 28.00, 'tawes.jpg'),
(44, 'Ikan Tawes', 29.00, 31.00, 7.1, 7.5, 5.10, 6.00, 0.000, 0.050, 51, 100, 51, 100, 26.00, 28.00, 'tawes.jpg'),
(45, 'Ikan Tawes', 29.00, 31.00, 7.6, 8.0, 5.10, 6.00, 0.000, 0.050, 101, 150, 51, 100, 29.00, 31.00, 'tawes.jpg'),
(46, 'Ikan Tawes', 32.00, 33.00, 8.1, 8.5, 5.10, 6.00, 0.060, 0.100, 151, 200, 101, 150, 32.00, 35.00, 'tawes.jpg'),
(47, 'Ikan Tawes', 32.00, 33.00, 8.6, 9.0, 5.10, 6.00, 0.060, 0.100, 151, 200, 101, 150, 32.00, 35.00, 'tawes.jpg'),
(48, 'Ikan Wader', 26.00, 28.00, 6.5, 7.0, 6.50, 7.00, 0.000, 0.050, 0, 50, 301, 350, 26.00, 28.00, 'wader.jpg'),
(49, 'Ikan Wader', 26.00, 28.00, 6.5, 7.0, 6.50, 7.00, 0.060, 0.100, 51, 100, 351, 400, 26.00, 28.00, 'wader.jpg'),
(50, 'Ikan Wader', 29.00, 31.00, 7.1, 7.5, 6.50, 7.00, 0.060, 0.100, 101, 150, 401, 450, 29.00, 31.00, 'wader.jpg'),
(51, 'Ikan Wader', 29.00, 31.00, 7.6, 8.0, 6.50, 7.00, 0.200, 0.500, 151, 200, 401, 450, 29.00, 31.00, 'wader.jpg'),
(52, 'Ikan Wader', 31.00, 32.00, 7.6, 8.0, 6.50, 7.00, 0.200, 0.500, 201, 250, 451, 500, 32.00, 35.00, 'wader.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `input_pengguna`
--

CREATE TABLE `input_pengguna` (
  `id` int(11) NOT NULL,
  `suhu_air` decimal(4,2) NOT NULL,
  `ph` decimal(3,1) NOT NULL,
  `do` decimal(4,2) NOT NULL,
  `amonia` decimal(5,3) DEFAULT NULL,
  `tds` int(11) NOT NULL,
  `ketinggian` int(11) NOT NULL,
  `suhu_udara` decimal(4,2) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp(),
  `similarity` float DEFAULT NULL,
  `jenis_ikan` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `saved` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `datasave`
--
ALTER TABLE `datasave`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ikan`
--
ALTER TABLE `ikan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `input_pengguna`
--
ALTER TABLE `input_pengguna`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `datasave`
--
ALTER TABLE `datasave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `ikan`
--
ALTER TABLE `ikan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT untuk tabel `input_pengguna`
--
ALTER TABLE `input_pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=842;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
