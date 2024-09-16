-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2024 at 05:32 PM
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
-- Database: `notepad`
--

-- --------------------------------------------------------

--
-- Table structure for table `archive`
--

CREATE TABLE `archive` (
  `archive_id` int(111) NOT NULL,
  `note_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archive`
--

INSERT INTO `archive` (`archive_id`, `note_id`) VALUES
(91, 58),
(97, 62),
(92, 77),
(77, 78),
(105, 82);

-- --------------------------------------------------------

--
-- Table structure for table `deletenotes`
--

CREATE TABLE `deletenotes` (
  `delete_id` int(11) NOT NULL,
  `note_id` int(11) NOT NULL,
  `delete_at` datetime NOT NULL,
  `schedperm_delete` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--

CREATE TABLE `favorite` (
  `favorite_id` int(11) NOT NULL,
  `note_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorite`
--

INSERT INTO `favorite` (`favorite_id`, `note_id`) VALUES
(80, 67),
(79, 70);

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE `note` (
  `note_id` int(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `note`
--

INSERT INTO `note` (`note_id`, `user_id`, `title`, `description`, `create_date`, `update_at`) VALUES
(57, 25, 'Ako ni ', 'qweqweqweqwe', '2024-04-04 10:36:33', '2024-04-04 10:36:33'),
(58, 26, '2nd try', 'mao na ba kaha ni ', '2024-04-04 11:57:08', '2024-04-04 11:57:08'),
(59, 26, '3rd try', 'qweqweqweqwe', '2024-04-04 12:02:39', '2024-04-04 12:02:39'),
(60, 25, 'qweqw', 'eqweqwe', '2024-04-04 12:10:09', '2024-04-04 12:10:09'),
(61, 25, 'asdasdasd', 'asdasd', '2024-04-04 12:10:15', '2024-04-04 12:10:15'),
(62, 27, 'poyaeyyzxczxc', 'qweqweasdasdaasdasdasdsdasdzxczczcxxxxxxzxczxczxcxxxxxxzxczcz laban lang ta', '2024-04-04 12:14:31', '2024-04-05 04:54:23'),
(63, 27, 'kapoya', 'na fix dyud diay\r\nxxxxzxczczxczxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxzxczczc', '2024-04-04 12:17:24', '2024-04-05 04:54:07'),
(64, 25, 'Labanlang dyud ta diri', 'qweqadasdasdasd', '2024-04-04 14:18:51', '2024-04-04 14:18:51'),
(65, 25, 'asdasd', 'asdasdas', '2024-04-04 14:19:18', '2024-04-04 14:19:18'),
(66, 25, 'qweqwe', 'qweqweqwe', '2024-04-04 14:22:05', '2024-04-04 14:22:05'),
(67, 27, 'zxczxc', 'zxczxczczxzczczc', '2024-04-04 15:14:01', '2024-04-05 04:54:10'),
(68, 27, 'sadasdasdasdasd', 'mailisan ba nako asdasdasdang oras', '2024-04-04 15:21:45', '2024-04-05 04:54:14'),
(69, 27, 'dxzxczxc', 'zxczxcc', '2024-04-04 15:53:12', '2024-04-04 15:53:12'),
(70, 27, 'try and try', 'aszxczczxcqweqweqwe', '2024-04-05 01:49:28', '2024-04-05 06:52:12'),
(71, 27, 'asdasd', 'asdasd', '2024-04-05 04:54:44', '2024-04-05 04:54:44'),
(72, 28, 'Athena', 'Hi i am athena Siton Grant', '2024-04-05 04:56:05', '2024-04-05 04:56:15'),
(76, 26, 'qweqwe', 'qweqwe', '2024-04-05 05:15:41', '2024-04-05 05:15:41'),
(77, 26, 'xzcz', 'czxczc', '2024-04-05 05:17:19', '2024-04-05 05:17:19'),
(78, 26, 'zxczx', 'czczc', '2024-04-05 05:17:23', '2024-04-05 05:17:23'),
(79, 27, 'qweqw', 'eqweqwe', '2024-04-05 05:17:39', '2024-04-05 05:17:39'),
(80, 27, 'qwe', 'qweqwe', '2024-04-05 11:51:59', '2024-04-05 11:51:59'),
(81, 27, 'archive', 'mao na ba ni ?', '2024-04-05 11:54:03', '2024-04-05 11:54:03'),
(82, 29, 'Poya ani eyy', 'KapoyKapoy ey', '2024-04-05 11:56:15', '2024-04-05 12:40:33'),
(83, 29, 'Gi Pamaolan na akong utok', 'Tinuod dyud', '2024-04-05 11:56:29', '2024-04-05 11:56:29'),
(84, 29, 'asdasd', 'asdasdasd', '2024-04-05 14:14:30', '2024-04-05 14:14:30'),
(85, 26, 'favorite', 'k', '2024-04-05 14:33:02', '2024-04-05 14:33:02');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `fullname`, `email`, `username`, `password`) VALUES
(25, 'daniel', 'daniel@gmail.com', 'daniel', '$2y$10$AXi/xHFOolqdmdpwdrRXh.mxmeHvrhePz0KWBbbaBUjMpR23MBbT6'),
(26, 'edgardo', 'edgardo@gmail.com', 'edgardo', '$2y$10$5LfOjloyOSoBNvyK7tFIyezppcynbaiyX6C.6z7sSvHTt9ctC94pi'),
(27, 'sweet', 'sweet@gmail.com', 'sweet', '$2y$10$LNIZVs60vxoDvjiIHnpEzux1RyG6KztiZl.zkWbM7oz7WL/U.J.Gq'),
(28, 'Athena', 'athena@gmail.com', 'athena', '$2y$10$vJNgYTwI5Q9URgfgHnbFFeGVCIx.YK6N9g3.mTtmEy0PEG1LjkuIS'),
(29, 'aeron', 'aeron', 'aeron', '$2y$10$5GwGjdPQRL.u.0UOsVsxeu0VisD/I64ZAjl80J4C94XDwOSykPpG2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archive`
--
ALTER TABLE `archive`
  ADD PRIMARY KEY (`archive_id`),
  ADD KEY `note_id` (`note_id`);

--
-- Indexes for table `deletenotes`
--
ALTER TABLE `deletenotes`
  ADD PRIMARY KEY (`delete_id`),
  ADD KEY `note_id` (`note_id`);

--
-- Indexes for table `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`favorite_id`),
  ADD KEY `note_id` (`note_id`);

--
-- Indexes for table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`note_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archive`
--
ALTER TABLE `archive`
  MODIFY `archive_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `deletenotes`
--
ALTER TABLE `deletenotes`
  MODIFY `delete_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorite`
--
ALTER TABLE `favorite`
  MODIFY `favorite_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `note`
--
ALTER TABLE `note`
  MODIFY `note_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `archive`
--
ALTER TABLE `archive`
  ADD CONSTRAINT `note_id` FOREIGN KEY (`note_id`) REFERENCES `note` (`note_id`) ON DELETE CASCADE;

--
-- Constraints for table `deletenotes`
--
ALTER TABLE `deletenotes`
  ADD CONSTRAINT `deletenotes_ibfk_1` FOREIGN KEY (`note_id`) REFERENCES `note` (`note_id`);

--
-- Constraints for table `favorite`
--
ALTER TABLE `favorite`
  ADD CONSTRAINT `favorite_ibfk_1` FOREIGN KEY (`note_id`) REFERENCES `note` (`note_id`);

--
-- Constraints for table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `note_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
