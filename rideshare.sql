-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 03, 2020 at 10:10 AM
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
-- Database: `rideshare`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `source` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `departure` datetime NOT NULL,
  `vehicle` text NOT NULL,
  `seats` int(255) NOT NULL,
  `contact` int(10) NOT NULL,
  `vehicle_id` varchar(255) NOT NULL,
  `selected` text DEFAULT NULL,
  `available` tinyint(4) NOT NULL DEFAULT 1,
  `posted_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `source`, `destination`, `departure`, `vehicle`, `seats`, `contact`, `vehicle_id`, `selected`, `available`, `posted_at`) VALUES
(3, 9, 'biratnagar', 'butwal', '2019-12-18 07:07:07', 'Bike', 1, 1234567890, 'ba 1 pa 1234', '[11,11]', 1, '2019-12-30 20:08:43'),
(4, 8, 'janakpur', 'bhaktapur', '2020-01-15 13:05:00', 'car', 3, 1234567890, 'ba 1 pa 1234', '[14,14]', 1, '2019-12-30 22:11:27'),
(5, 10, 'dharan', 'urlabari', '2019-12-31 22:55:00', 'Bike', 1, 1234567890, 'ba 1 pa 1234', '[11,11,14,14]', 1, '2019-12-30 22:31:52'),
(12, 14, 'bkt', 'pok', '2020-01-08 00:34:00', 'jeep', 2, 1234567890, 'ba 1 pa 1234', '[11,11,11,11]', 1, '2020-01-01 23:27:11'),
(14, 11, 'ktm', 'bkt', '2020-01-22 20:00:00', 'tank', 12, 1234567876, 'ba 1 pa 1276', NULL, 1, '2020-01-03 12:11:42'),
(15, 11, 'brt', 'okr', '2020-01-16 22:07:00', 'apacge', 187235, 123654, 'ba 1 pa 4567', NULL, 0, '2020-01-03 13:40:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`) VALUES
(8, 'Avash G', 'avash@gmail.com', '$2y$10$mvuQ5kkaFGFBQLl0WI.XfeRZK/BR/bW7NEhtiQ.FIpR8MMnUeOOpy'),
(9, 'john doe', 'jd@gmail.com', '$2y$10$0/c1sic8EfN7w8msBzX/YOXVwotOuJHRlOR43o8oqsV2OO83VcbrW'),
(10, 'David Gilmour', 'dave@gmail.com', '$2y$10$bZF/Bvl4ihp4rPCZ3G0EMephjTfra0VyMlNnT3esUEa5bt7SAXDAe'),
(11, 'apple', 'apple@ball.com', '$2y$10$WPR8Hqdg7wah6YJ/onqAcu83DGhpG7FWdjk/hwuGK248j2Y/kef42'),
(12, 'appleball', 'apple@123.com', '$2y$10$SolW/1LISOgTIYdVocP8t.QrlyD6k8FwDUFM.LkTieSl5.AbSmrmu'),
(14, 'cat', 'cat@dog.com', '$2y$10$keMQigIPil88P6FIw3hvFulAOmXe2b3RyU6avCfFQZJ8gx6rG9DOO'),
(15, 'avash', 'avash@avash.com', '$2y$10$ONwa2e5wrJ3ybx37.3htUuxdIIX5UGInuRoUuRCK1gmPtNhelwWUO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `available` (`available`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
