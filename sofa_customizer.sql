-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2026 at 02:06 PM
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
-- Database: `sofa_customizer`
--

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `material_name` varchar(50) DEFAULT NULL,
  `extra_cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `material_name`, `extra_cost`) VALUES
(1, 'Linen', 0.00),
(2, 'Velvet', 2000.00),
(3, 'Leather', 5000.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `color` text NOT NULL,
  `texture` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `total_price` decimal(10,2) DEFAULT 0.00,
  `delivery_address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT 'Pending',
  `custom_image` varchar(255) DEFAULT NULL,
  `sofa_color` varchar(50) DEFAULT NULL,
  `sofa_texture` varchar(50) DEFAULT NULL,
  `pillow_color` varchar(50) DEFAULT NULL,
  `pillow_texture` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `color`, `texture`, `date`, `status`, `total_price`, `delivery_address`, `phone`, `payment_method`, `payment_status`, `custom_image`, `sofa_color`, `sofa_texture`, `pillow_color`, `pillow_texture`) VALUES
(1, 1, 5, 'default', 'default', '2026-06-05', 'Delivered', 0.00, NULL, NULL, NULL, 'Pending', NULL, NULL, NULL, NULL, NULL),
(2, 2, 3, 'default', 'velvet', '2026-06-09', 'Pending', 0.00, NULL, NULL, NULL, 'Pending', NULL, NULL, NULL, NULL, NULL),
(3, 2, 3, 'green', 'leather', '2026-06-09', 'Delivered', 0.00, NULL, NULL, NULL, 'Pending', NULL, NULL, NULL, NULL, NULL),
(4, 2, 3, 'blue', 'leather', '2026-06-16', 'Pending', 0.00, NULL, NULL, NULL, 'Pending', NULL, NULL, NULL, NULL, NULL),
(5, 2, 2, 'green', 'linen', '2026-06-16', 'Cancelled', 0.00, NULL, NULL, NULL, 'Pending', NULL, NULL, NULL, NULL, NULL),
(6, 2, 2, 'default', 'default', '2026-06-16', 'Cancelled', 0.00, NULL, NULL, NULL, 'Pending', NULL, NULL, NULL, NULL, NULL),
(7, 2, 5, 'green', 'leather', '2026-06-16', 'Delivered', 0.00, NULL, NULL, NULL, 'Pending', NULL, NULL, NULL, NULL, NULL),
(8, 1, 2, 'default', 'default', '2026-06-16', 'Pending', 0.00, NULL, NULL, NULL, 'Pending', NULL, NULL, NULL, NULL, NULL),
(9, 2, 3, 'default', 'default', '2026-06-19', 'Pending', 0.00, NULL, NULL, NULL, 'Pending', NULL, NULL, NULL, NULL, NULL),
(10, 1, 3, 'blue', 'default', '2026-06-19', 'Pending', 30000.00, '', '', '', 'Pending', NULL, NULL, NULL, NULL, NULL),
(11, 2, 3, '#1e4fb8', 'leather', '2026-06-30', 'Pending', 35000.00, 'Ruiru', '0712345678', 'M-Pesa', 'Pending', NULL, NULL, NULL, NULL, NULL),
(12, 6, 1, '#1e4fb8', 'leather', '2026-06-30', 'Processing', 30000.00, 'Ruai sunsrise apartment', '07987654321', 'M-Pesa', 'Pending', NULL, NULL, NULL, NULL, NULL),
(13, 1, 2, '#1e4fb8', 'leather', '2026-07-05', 'Pending', 30000.00, '3RD SUNRISE  AVENUE', '0712345678', 'M-Pesa', 'Pending', NULL, NULL, NULL, NULL, NULL),
(14, 2, 2, '#1e4fb8', 'leather', '2026-07-07', 'Delivered', 30000.00, '2ND SUNSRISE APARTMENT', '0787654321', 'M-Pesa', 'Pending', NULL, NULL, NULL, NULL, NULL),
(15, 2, 2, '#1e4fb8', 'leather', '2026-07-08', 'Delivered', 30000.00, '2nd sunsrise', '0712345678', 'M-Pesa', 'Pending', NULL, NULL, NULL, NULL, NULL),
(16, 2, 2, '#1e4fb8', 'velvet', '2026-07-11', 'Cancelled', 27000.00, 'ruai', '07987654321', 'M-Pesa', 'Pending', NULL, NULL, NULL, NULL, NULL),
(17, 1, 2, '#b22222', 'velvet', '2026-07-12', 'Pending', 27000.00, 'Kimbo', '0754234098', 'M-Pesa', 'Pending', NULL, NULL, NULL, NULL, NULL),
(18, 1, 2, '#b22222', 'velvet', '2026-07-12', 'Pending', 27000.00, 'Kimbo', '0754234098', 'M-Pesa', 'Pending', '', NULL, NULL, NULL, NULL),
(19, 1, 2, '#b22222', 'velvet', '2026-07-12', 'Pending', 27000.00, 'Kimbo', '0754234098', 'M-Pesa', 'Pending', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAjAAAAHfCAYAAABOC+KlAAAQAElEQVR4Aey9B6BlR3HnXX3uvS9NHmmUNUpkEOtd29hrMNhmvd/alne93oXv2zUsXjI2EsGIZJNMtgk2WQIlhEgCTBASCJQAoTQjCYFEFEJhNKMw0uT3bjinv9+/+pz77psZoTia1GdOnaquqq7urk51+9z7prB8ZQ9kD2QPZA9kD2QPZA/sZh7IA', NULL, NULL, NULL, NULL),
(20, 1, 2, '#2d2d2d', 'linen', '2026-07-12', 'Pending', 25000.00, 'Rongai', '0754234098', 'M-Pesa', 'Pending', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAjAAAAHfCAYAAABOC+KlAAAQAElEQVR4Aez9B8AlV3HnDVed0933yTOjhBKKIKJYrwP2GoddY/vbXcvv5/UuvLvrnMCY4ATY2JhgTLBNxhgkQGCSMSInmWQEBkSQQDnngNCEJ4cbOry//7nPI0QWQhqNZs6dW093n1Cn6n/qVFWfvvdOsPzKCGQEvhkB/+aiXJIRyAhkBDIC+w4CO', NULL, NULL, NULL, NULL),
(21, 1, 2, '#2d2d2d', 'velvet', '2026-07-12', 'Pending', 27000.00, 'Kiambu', '07987654321', 'M-Pesa', 'Pending', 'uploads/customized_sofas/sofa_1783811503.png', NULL, NULL, NULL, NULL),
(22, 1, 2, '#b22222', 'velvet', '2026-07-12', 'Pending', 27000.00, 'Ku', '0712345678', 'M-Pesa', 'Pending', 'uploads/customized_sofas/sofa_1783812435.png', NULL, NULL, NULL, NULL),
(23, 1, 2, '', '', '2026-07-12', 'Pending', 27000.00, 'huouij', '07987654321', 'M-Pesa', 'Pending', 'uploads/customized_sofas/sofa_1783815551.png', '#1e4fb8', 'leather', '', ''),
(24, 1, 2, '', '', '2026-07-12', 'Pending', 27000.00, 'huouij', '07987654321', 'M-Pesa', 'Pending', 'uploads/customized_sofas/sofa_1783815551.png', '#1e4fb8', 'leather', '', ''),
(25, 1, 2, '', '', '2026-07-12', 'Cancelled', 25000.00, 'huouij', '07987654321', 'M-Pesa', 'Pending', 'uploads/customized_sofas/sofa_1783816624.png', '#555555', 'linen', '#555555', 'linen'),
(26, 2, 2, '', '', '2026-07-12', 'Pending', 30000.00, 'Tsavo Apartments', '0734765234', 'Bank Transfer', 'Pending', 'uploads/customized_sofas/sofa_1783861845.png', '#2d2d2d', 'linen', '#1e4fb8', 'leather'),
(27, 1, 2, '', '', '2026-07-12', 'Payment Confirmed', 30000.00, 'Tsavo Apartments', '0734765234', 'Bank Transfer', 'Paid', 'uploads/customized_sofas/sofa_1783862423.png', '#2d2d2d', 'linen', '#1e4fb8', 'leather'),
(28, 1, 2, '', '', '2026-07-12', 'Cancelled', 25000.00, 'Tsavo Apartments', '0734765234', 'Bank Transfer', 'Pending', 'uploads/customized_sofas/sofa_1783866455.png', '#555555', 'linen', '#555555', 'linen'),
(29, 1, 8, '', '', '2026-07-12', 'Pending', 57000.00, 'Kimbo', '0712345678', 'M-Pesa', 'Pending', '', '', '', '', ''),
(30, 1, 2, '', '', '2026-07-12', 'Payment Confirmed', 30000.00, 'Luthiru', '0734765234', 'Bank Transfer', 'Paid', 'uploads/customized_sofas/sofa_1783867118.png', '#1e4fb8', 'linen', '#2d2d2d', 'leather'),
(31, 1, 2, '', '', '2026-07-12', 'Payment Confirmed', 27000.00, 'Ruiru Corpus Christi', '0741009502', 'M-Pesa', 'Pending Payment', 'uploads/customized_sofas/sofa_1783886915.png', '#2d2d2d', 'leather', '#555555', 'velvet'),
(32, 2, 2, '', '', '2026-07-13', 'Pending Payment', 30000.00, 'lhfgl', '0787654321', 'Bank Transfer', 'Pending Payment', 'uploads/customized_sofas/sofa_1783941929.png', '#555555', 'velvet', '#1e4fb8', 'leather'),
(33, 1, 2, '', '', '2026-07-13', 'Pending Payment', 27000.00, 'Embakasi', '0712345678', 'M-Pesa', 'Pending Payment', 'uploads/customized_sofas/sofa_1783957921.png', '#1e4fb8', 'leather', '#b22222', 'velvet'),
(34, 2, 2, '', '', '2026-07-17', 'Delivered', 27000.00, 'Embakai estate', '0712345678', 'M-Pesa', 'Pending Payment', 'uploads/customized_sofas/sofa_1784283923.png', '#555555', 'leather', '#1e4fb8', 'velvet'),
(35, 1, 2, '', '', '2026-07-17', 'Processing', 30000.00, 'Embakasi', '0712345678', 'Cash On Delivery', 'Pending Payment', 'uploads/customized_sofas/sofa_1784284570.png', '#b22222', 'velvet', '#1f7a4d', 'leather'),
(36, 7, 2, '', '', '2026-07-21', 'Pending Payment', 25000.00, 'Corpus', '0724033999', 'M-Pesa', 'Pending Payment', 'uploads/customized_sofas/sofa_1784632604.png', '#2d2d2d', 'leather', '#1e4fb8', 'linen');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` int(50) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`) VALUES
(2, 'Modern Sofa', 'Comfortable modern sofa', 25000, 'sofa.png'),
(8, 'Good Looking Sofa', 'Here is where you can even sleep and be comfortable.', 57000, 'sweet.png'),
(9, 'Cool sofa', 'Very Comfortable Cushions', 29993, 'kiti.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Admin', 'admin@gmail.com', '12345', 'admin'),
(2, 'Enock', 'user@gmail.com', '12345', 'customer'),
(3, 'Enock', 'user@gmail.com', '1234', 'customer'),
(4, 'Enock', 'user@gmail.com', '1234', 'customer'),
(5, 'Emmanuel Oseko', 'emmanuel@gmail.com', '12345', 'customer'),
(6, 'Kamau Kimani', 'Kimani@gmail.com', '12345', 'customer'),
(7, 'John Doe', 'johndoe@gmail.com', 'John123', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
