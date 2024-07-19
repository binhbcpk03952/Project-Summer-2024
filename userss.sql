-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2024 at 03:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project-sum2024`
--

-- --------------------------------------------------------

--
-- Table structure for table `userss`
--

CREATE TABLE `userss` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `IdUser` int(11) NOT NULL,
  `phone` int(10) NOT NULL,
  `picture` text NOT NULL,
  `token` int(250) NOT NULL,
  `otpCreated` datetime DEFAULT NULL,
  `otp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userss`
--

INSERT INTO `userss` (`username`, `password`, `role`, `email`, `name`, `IdUser`, `phone`, `picture`, `token`, `otpCreated`, `otp`) VALUES
('binhbc', '123123', 1, 'binhbcpk03952@gmail.com', 'bui chi binh', 1, 0, '', 0, '2024-07-17 15:41:38', 773837),
('admin', '123456', 0, '', '', 2, 0, '', 0, NULL, 0),
('binhbc', '123123', 1, 'binhbcpk03952@gmail.com', 'bui chi binh', 3, 0, '', 0, '2024-07-17 15:41:38', 773837),
('tienphat', '123123', 0, 'phat123@gmail.com', 'tran tien phat', 5, 847701203, '', 0, '2024-07-17 15:25:51', 703540),
('cuong', '123123', 0, 'cuong123@gmail.com', 'nguyen manh cuong', 6, 912129114, '', 0, '2024-07-17 00:56:05', 111037),
('vantien', '123456', 0, 'vantien@gmail.com', 'nguyen van tien', 7, 792106734, '', 0, '2024-07-17 15:41:00', 106338),
('', '123123', 0, 'ntdad2005@gmail.com', 'Đạt Nguyễn Tiến', 8, 0, 'https://lh3.googleusercontent.com/a/ACg8ocLvSr9hyJBagFY-p4ZcpMAuVmsxbCovzni8MNL7WXTDo0X1eA=s96-c', 2147483647, '2024-07-17 15:54:38', 762536),
('', '', 0, 'datntpk2005@gmail.com', 'Tiến Đạt Nguyễn', 9, 0, 'https://lh3.googleusercontent.com/a/ACg8ocI3fZ2Ym48-MhVFP9jC-yZwNE8yGu29FtYka9zivQifLfBmpQ=s96-c', 2147483647, NULL, 0),
('', '', 0, 'datntpk03697@gmail.com', 'Tiến Đạt Nguyễn', 16, 0, 'https://lh3.googleusercontent.com/a/ACg8ocLtMDzBbsDybZrD7Zk4008DX0IUcoW4GeyB4-EDCgb5YlHHWQ=s96-c', 2147483647, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `userss`
--
ALTER TABLE `userss`
  ADD PRIMARY KEY (`IdUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `userss`
--
ALTER TABLE `userss`
  MODIFY `IdUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
