-- phpMyAdmin SQL Dump
-- version 4.6.5.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 21, 2018 at 08:17 PM
-- Server version: 5.5.53-0ubuntu0.14.04.1
-- PHP Version: 7.0.30-1+ubuntu14.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test1`
--

-- --------------------------------------------------------

--
-- Table structure for table `prizes`
--

CREATE TABLE `prizes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('money','points','goods') NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `prizes`
--

INSERT INTO `prizes` (`id`, `name`, `type`, `date`) VALUES
(1, 'Money prize', 'money', '2018-05-19 10:51:52'),
(2, 'Bonus points', 'points', '2018-05-19 10:51:57'),
(3, 'Goods prize', 'goods', '2018-05-19 10:52:25');

-- --------------------------------------------------------

--
-- Table structure for table `prizes_goods`
--

CREATE TABLE `prizes_goods` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `added_amount` int(10) UNSIGNED NOT NULL,
  `holded_amount` int(11) UNSIGNED NOT NULL,
  `spent_amount` int(10) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `prizes_goods`
--

INSERT INTO `prizes_goods` (`id`, `name`, `added_amount`, `holded_amount`, `spent_amount`, `date`) VALUES
(1, 'SmartPhone', 3, 0, 0, '2018-05-21 18:16:35'),
(2, 'Football Ticket', 5, 0, 0, '2018-05-21 17:34:39'),
(3, 'T-shirt with our logo', 10, 0, 0, '2018-05-21 17:34:42');

-- --------------------------------------------------------

--
-- Table structure for table `prizes_money`
--

CREATE TABLE `prizes_money` (
  `id` int(11) NOT NULL,
  `added_amount` decimal(10,0) UNSIGNED NOT NULL,
  `holded_amount` decimal(10,0) UNSIGNED NOT NULL,
  `spent_amount` decimal(10,0) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `prizes_money`
--

INSERT INTO `prizes_money` (`id`, `added_amount`, `holded_amount`, `spent_amount`, `date`) VALUES
(1, '1000000', '0', '0', '2018-05-21 18:16:44');

-- --------------------------------------------------------

--
-- Table structure for table `prizes_transactions`
--

CREATE TABLE `prizes_transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `prizes_id` int(11) NOT NULL,
  `prizes_item_id` int(11) DEFAULT NULL,
  `amount` decimal(11,0) UNSIGNED DEFAULT NULL,
  `goods` int(11) DEFAULT NULL,
  `status` enum('new','processed','returned') NOT NULL DEFAULT 'new',
  `processed_type` enum('bank','points','delivery') DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `points` int(11) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `points`, `date`) VALUES
(8, 'zzz', 'f3abb86bd34cf4d52698f14c0da1dc60', 2628061, '2018-05-21 17:37:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `prizes`
--
ALTER TABLE `prizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prizes_goods`
--
ALTER TABLE `prizes_goods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prizes_money`
--
ALTER TABLE `prizes_money`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prizes_transactions`
--
ALTER TABLE `prizes_transactions`
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
-- AUTO_INCREMENT for table `prizes`
--
ALTER TABLE `prizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `prizes_goods`
--
ALTER TABLE `prizes_goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `prizes_money`
--
ALTER TABLE `prizes_money`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `prizes_transactions`
--
ALTER TABLE `prizes_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
