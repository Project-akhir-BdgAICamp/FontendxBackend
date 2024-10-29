-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2024 at 03:45 PM
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
-- Database: `db_toko`
--

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `metode_pengiriman` enum('Reguler','Ekspres') NOT NULL,
  `metode_pembayaran` enum('Transfer Bank','E-Wallet','Kartu Kredit') NOT NULL,
  `file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checkout`
--

INSERT INTO `checkout` (`id`, `user_id`, `product_id`, `alamat`, `telephone`, `metode_pengiriman`, `metode_pembayaran`, `file`) VALUES
(3, 10, 19, 'Ujung Berung', '08888888', 'Reguler', 'Transfer Bank', NULL),
(4, 10, 4, 'Ujung Berung', '08888888', 'Reguler', 'Transfer Bank', NULL),
(5, 10, 27, 'Ujung Berung', '08888888', 'Reguler', 'Transfer Bank', NULL),
(6, 10, 19, 'Ujung Berung', '08888888', 'Reguler', 'Transfer Bank', NULL),
(7, 10, 4, 'Bandung', '08888888', 'Reguler', 'Transfer Bank', NULL),
(8, 10, 4, 'Bandung', '08888888', 'Reguler', 'Transfer Bank', NULL),
(9, 10, 4, 'Bandung', '08888888', 'Reguler', 'Transfer Bank', NULL),
(10, 10, 4, 'Bandung', '08888888', 'Reguler', 'Transfer Bank', NULL),
(11, 10, 4, 'Bandung', '08888888', 'Reguler', 'E-Wallet', NULL),
(12, 10, 4, 'Ujung Berung Baru', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(13, 10, 4, 'Ujung Berung Baru Lagi', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(14, 10, 4, 'Ujung Berung Baru Lagi Kedua', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(15, 10, 5, 'Ujung Berung Baru Lagi Kedua', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(16, 10, 4, 'Ujung Berung', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(17, 10, 5, 'Ujung Berung', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(18, 10, 4, 'Ujung Berung Baru Lagi', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(19, 10, 5, 'Ujung Berung Baru Lagi', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(20, 10, 4, 'Ujung Berung Baru Lagi', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(21, 10, 5, 'Ujung Berung Baru Lagi', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(22, 10, 4, 'Ujung Berung Baru Lagi', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(26, 10, 4, 'Ujung Berung', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(27, 10, 5, 'Ujung Berung', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(28, 10, 4, 'Ujung Berung Baru Lagi', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(29, 10, 5, 'Ujung Berung Baru Lagi', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(30, 10, 4, 'Ujung Berung Baru Lagi', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(31, 10, 5, 'Ujung Berung Baru Lagi', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(32, 10, 4, 'Ujung Berung', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(33, 10, 5, 'Ujung Berung', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(34, 10, 4, 'Ujung Berung Baru Lagi', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(35, 10, 5, 'Ujung Berung Baru Lagi', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(36, 10, 4, 'Ujung Berung Baru Lagi', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(37, 10, 5, 'Ujung Berung Baru Lagi', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(38, 10, 4, 'Ujung Berung', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(39, 10, 5, 'Ujung Berung', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(40, 10, 4, 'Ujung Berung Lagi Pembeda', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(41, 10, 5, 'Ujung Berung Lagi Pembeda', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(42, 10, 4, 'Ujung Berung Baru Lagi', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(43, 10, 5, 'Ujung Berung Baru Lagi', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(44, 10, 4, 'Bandung', '08888888888', 'Reguler', 'Transfer Bank', NULL),
(45, 10, 5, 'Bandung', '08888888888', 'Reguler', 'Transfer Bank', NULL),
(46, 10, 4, 'Margahayu', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(47, 10, 5, 'Margahayu', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(48, 10, 4, 'Riung Bandung Ujung Berung', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(49, 10, 5, 'Riung Bandung Ujung Berung', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(50, 10, 4, 'Romania Raya', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(51, 10, 5, 'Romania Raya', '085960605942', 'Reguler', 'Transfer Bank', NULL),
(52, 10, NULL, 'Ujung Berung Baru Lagi', '085960605942', 'Reguler', 'Transfer Bank', 'uploads/download (10).jpg'),
(53, 10, NULL, 'Ujung Berung Baru Lagi', '085960605942', 'Reguler', 'Transfer Bank', 'uploads/CHUU memes.jpg'),
(54, 10, NULL, 'Ujung Berung Lagi Pembeda', '085960605942', 'Reguler', 'Transfer Bank', 'uploads/CHUU memes.jpg'),
(55, 10, NULL, 'Ujung Berung', '085960605942', 'Reguler', 'Transfer Bank', 'uploads/^___^.jpg'),
(56, 10, 4, 'Romania Baru', '085960605942', 'Reguler', 'Transfer Bank', 'uploads/^___^.jpg'),
(57, 16, 5, 'uber', '08000000000', 'Reguler', 'Transfer Bank', 'uploads/prasasti jambu 2024-09-23 191320.png'),
(58, 16, 5, 'ujung berung', '08000000000', 'Reguler', 'Transfer Bank', 'uploads/prasasti jambu 2024-09-23 191320.png'),
(59, 16, 5, 'ujung berung', '083101234567', 'Reguler', 'Transfer Bank', 'uploads/prasasti jambu 2024-09-23 191320.png'),
(60, 16, 5, 'ujung berung', '083101234567', 'Reguler', 'Transfer Bank', 'uploads/Screenshot 2024-10-23 190013.png'),
(61, 16, 5, 'ujung berung', '083101234567', 'Reguler', 'Transfer Bank', 'uploads/Screenshot 2024-10-23 190013.png'),
(62, 16, 5, 'ujung berung', '83113171374', 'Reguler', 'Transfer Bank', 'uploads/Screenshot 2024-10-23 190013.png'),
(63, 17, 5, 'ujung berung', '83113171374', 'Reguler', 'Transfer Bank', 'uploads/Screenshot 2024-10-23 190013.png');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(250) NOT NULL,
  `category` enum('tas','sepatu','baju') NOT NULL,
  `description` text DEFAULT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `user_id`, `name`, `category`, `description`, `price`, `stock`, `file`) VALUES
(4, NULL, 'sepatu cewe', 'sepatu', 'sepatu cewe terbagus', 100000, 8, 'sepatucewe.jpg'),
(5, NULL, 'sepatu keren', 'sepatu', 'sepatu keren 2024', 100000, 51, 'sepatu1.jpg'),
(18, 7, 'Sepatu baru', 'sepatu', NULL, 50000, 8, 'adidas Originals Samba OG.jpg'),
(19, 7, 'Tas Hitam', 'tas', NULL, 100000, 18, 'Mallette portable en cuir tanné végétal pour ordinateur Sac en cuir décontracté pour homme - Black.jpg'),
(27, 14, 'Kemeja Rajut Merah', 'baju', NULL, 120000, 18, 'Slim Fit Ribbed Stand Collar Shirt.jpg'),
(28, 14, 'Jaket Wibu', 'baju', NULL, 12000, 12, 'download (8).jpg'),
(29, 14, 'Tas Rohis', 'tas', NULL, 77000, 100, 'TRVLMORE Rugzak - 36L - 17 inch - Laptop Rugtas - Schooltas - Heren en Dames - Laptoptas - Spatwaterdicht - Levenslange Garantie - Grijs.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `review_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`review_id`, `user_id`, `product_id`, `rating`, `review_text`) VALUES
(14, 17, 5, 5, 'mantap'),
(15, 17, 5, 5, 'mantap');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `level`, `created_at`) VALUES
(7, 'admin', 'user@gmail.com', '$2y$10$aCQaAt227VEU2Z1NS5BQTuPucclILBpTQGpq4P1mOCC8pN7GJIQP.', 'admin', '2024-10-08 12:00:45'),
(9, 'user3', 'user3@gmail.com', '$2y$10$73IGAQhlV/wjnINilIWl3.pWP/cha5NicgEmionfj14zfUhLyfVj2', 'user', '2024-10-09 12:25:25'),
(10, 'user1', 'user1@gmail.com', '$2y$10$7CMdHmtf3pYm2TG/pp339ezG/nb7bCqr94T1lXKfeu49olUWoz7vK', 'user', '2024-10-15 02:54:06'),
(14, 'admin baru', 'adminbaru@gmail.com', '$2y$10$h18n0D4uKS2OXr.FsO1Ho.tQD4mbghTmOCX7SwF5ZP2WmKXmo0tDa', 'admin', '2024-10-18 14:56:57'),
(15, 'USER4', 'user4@gmail.com', '$2y$10$OpXPZTdkAk4Rbfb15Bj5eO5vLF1CJK5nExOaqPYLGeZhKTrs3zAmK', 'user', '2024-10-19 06:26:13'),
(16, 'adel', 'adel@gmail.com', '$2y$10$SuEtCV7Z8eF0Dzml4.e1DO8/bfeVsw68QYxUZwJ1QJ9pk1rfdK40.', 'user', '2024-10-23 10:14:05'),
(17, 'fajardoang', 'fajarzzz2007@gmail.com', '$2y$10$1DSjUuxbX19neGKYKOM36OmkL.tpKKQ7sGNET9biHnkgjUSYblogG', 'user', '2024-10-23 13:14:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_produk` (`user_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `checkout_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checkout`
--
ALTER TABLE `checkout`
  ADD CONSTRAINT `checkout_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `checkout_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `produk` (`id`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `checkout` (`id`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `produk` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
