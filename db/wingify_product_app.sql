-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 27, 2017 at 07:30 PM
-- Server version: 5.7.17
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wingify_product_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent_id`, `created`, `modified`) VALUES
(1, 'Electronics', 0, NULL, NULL),
(2, 'Toys & Games', 0, NULL, NULL),
(3, 'Camera', 1, NULL, NULL),
(4, 'Security', 1, NULL, NULL),
(5, 'Games', 2, NULL, NULL),
(6, 'Puzzles', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(20) NOT NULL,
  `category_id` int(20) DEFAULT NULL,
  `product_title` varchar(255) DEFAULT NULL,
  `sku_code` varchar(50) DEFAULT NULL,
  `unit_price` float(8,2) DEFAULT NULL,
  `image_1` varchar(255) DEFAULT NULL,
  `image_2` varchar(255) DEFAULT NULL,
  `image_3` varchar(255) DEFAULT NULL,
  `description` text,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `product_title`, `sku_code`, `unit_price`, `image_1`, `image_2`, `image_3`, `description`, `status`, `created`, `modified`) VALUES
(2, 1, 'hello', 'HELLO11345', 20.00, 'acs', 'asdsa', 'asds', 'assadsadsamfnavmadvcad', 1, NULL, NULL),
(3, NULL, 'Test Product 1', '123456', 200.00, 'acs', 'asdsa', 'asds', 'assadsadsamfnavmadvcad', 1, NULL, NULL),
(5, NULL, 'Test Product 1', '444', 444.00, 'acs', 'asdsa', 'asds', 'assadsadsamfnavmadvcad', 1, NULL, NULL),
(6, NULL, 'Test Product 1', 'fwf', 444.00, 'acs', 'asdsa', 'asds', 'assadsadsamfnavmadvcad', 1, NULL, NULL),
(8, NULL, 'Test Product 1', '123', 2000.00, 'acs', 'asdsa', 'asds', 'assadsadsamfnavmadvcad', 1, NULL, NULL),
(9, 1, 'dwdw', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-04-28 00:59:17', '2017-04-28 00:59:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(20) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `role` varchar(10) DEFAULT NULL,
  `api_token` varchar(100) DEFAULT NULL,
  `expire_time` int(20) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `role`, `api_token`, `expire_time`, `created`, `modified`) VALUES
(12, 'blmeena1991@gmail.com', 'blmeena1991', 'admin', 'dfc87245814c3e4f9de0831216e732e3e0843b9a0f249dae9e88fa6bbe6bac16', 1501096894, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `variations`
--

CREATE TABLE `variations` (
  `id` int(20) NOT NULL,
  `product_id` int(20) DEFAULT NULL,
  `variation_name` varchar(50) DEFAULT NULL,
  `variation_value` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `variations`
--

INSERT INTO `variations` (`id`, `product_id`, `variation_name`, `variation_value`, `created`, `modified`) VALUES
(6, 2, 'color', 'whilte', NULL, NULL),
(7, 3, 'size', 'SL', NULL, NULL),
(9, 5, 'size', 'SL', NULL, NULL),
(10, 6, 'size', 'SL', NULL, NULL),
(22, 8, 'size', 'SL', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name_idx` (`name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sku_code_idx` (`sku_code`),
  ADD KEY `product_title` (`product_title`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `username_idx` (`username`);

--
-- Indexes for table `variations`
--
ALTER TABLE `variations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `variations`
--
ALTER TABLE `variations`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
