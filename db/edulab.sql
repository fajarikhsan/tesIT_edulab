-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 18, 2021 at 01:19 AM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `edulab`
--

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `token` varchar(1000) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `order_id`, `token`, `student_id`) VALUES
(10, '9945-5169-A001', '121abb6a-a1ec-490f-92d4-a882873685cc', 1),
(16, '2985-6111-A007', 'e8169e11-480b-4fcf-8ad8-3dc287dfadd2', 7),
(17, '1234-5678-A009', '24e90237-d858-49fe-8f53-5aeecd10a997', 9);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `user_id` char(4) NOT NULL,
  `cabang_belajar` char(1) NOT NULL,
  `total_biaya` int(11) DEFAULT '0',
  `potongan` int(11) DEFAULT '0',
  `dp` int(11) DEFAULT '0',
  `angsuran_1` int(11) DEFAULT '0',
  `angsuran_2` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `cabang_belajar`, `total_biaya`, `potongan`, `dp`, `angsuran_1`, `angsuran_2`) VALUES
(1, 'A001', 'A', 9000000, 3000000, 1000000, 0, 0),
(2, 'A002', 'A', 9000000, 2500000, 1000000, 0, 0),
(3, 'A003', 'B', 9000000, 1500000, 1000000, 1000000, 0),
(4, 'A004', 'C', 9000000, 1500000, 7500000, 0, 0),
(5, 'A005', 'A', 9000000, 2500000, 6500000, 0, 0),
(6, 'A006', 'A', 9000000, 2500000, 2000000, 0, 0),
(7, 'A007', 'C', 9000000, 2500000, 2000000, 0, 0),
(8, 'A008', 'A', 9000000, 2500000, 2500000, 0, 0),
(9, 'A009', 'B', 15000000, 6500000, 1500000, 1000000, 0),
(10, 'A010', 'A', 9000000, 2500000, 6500000, 0, 0),
(11, 'A011', 'A', 15000000, 4000000, 2000000, 1000000, 0),
(12, 'A012', 'C', 9000000, 1500000, 2000000, 500000, 1500000),
(13, 'A013', 'D', 9000000, 2500000, 1000000, 1000000, 1000000),
(14, 'A014', 'D', 9000000, 2500000, 1500000, 1000000, 1000000),
(15, 'A015', 'D', 15000000, 5000000, 10000000, 0, 0),
(16, 'A016', 'A', 9000000, 2000000, 1000000, 1000000, 0),
(17, 'A017', 'D', 9000000, 2500000, 2000000, 0, 1000000),
(18, 'A018', 'D', 9000000, 2500000, 1000000, 1000000, 1000000),
(19, 'A019', 'A', 9000000, 3000000, 1000000, 1000000, 0),
(20, 'A020', 'D', 9000000, 1500000, 2000000, 1000000, 1000000),
(21, 'A021', 'A', 9000000, 2500000, 1300000, 800000, 1000000),
(22, 'A022', 'A', 9000000, 2500000, 1300000, 800000, 1000000),
(23, 'A023', 'D', 9000000, 2500000, 1300000, 2000000, 800000),
(24, 'A024', 'D', 9000000, 2500000, 3800000, 0, 0),
(25, 'A025', 'D', 9000000, 2300000, 1000000, 1000000, 0),
(26, 'A026', 'A', 9000000, 3000000, 3000000, 0, 1000000),
(27, 'A027', 'A', 9000000, 3000000, 3000000, 0, 0),
(28, 'A028', 'A', 9000000, 2500000, 2000000, 1500000, 0),
(29, 'A029', 'A', 4500000, 0, 4500000, 0, 0),
(30, 'A030', 'A', 4800000, 0, 1000000, 0, 0),
(31, 'A031', 'C', 4500000, 0, 4500000, 0, 0),
(32, 'A032', 'C', 4500000, 0, 2000000, 0, 0),
(33, 'A033', 'C', 4500000, 0, 2000000, 0, 0),
(34, 'A034', 'B', 9000000, 3500000, 1500000, 0, 0),
(35, 'A035', 'B', 4500000, 1500000, 1500000, 0, 0),
(36, 'A036', 'B', 4500000, 0, 4500000, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
