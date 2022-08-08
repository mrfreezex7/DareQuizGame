-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql208.byetcluster.com
-- Generation Time: Aug 07, 2022 at 10:29 PM
-- Server version: 10.3.27-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epiz_32334631_dare_quiz_game`
--

-- --------------------------------------------------------

--
-- Table structure for table `dares`
--

CREATE TABLE `dares` (
  `id` int(255) NOT NULL,
  `UniqueDareUrl` varchar(255) NOT NULL,
  `Nickname` varchar(255) NOT NULL,
  `DareQuestions` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `q4f1`
--

CREATE TABLE `q4f1` (
  `id` int(255) NOT NULL,
  `UniqueUserID` int(255) NOT NULL,
  `UniqueQuizUrl` varchar(255) NOT NULL,
  `Nickname` varchar(255) NOT NULL,
  `QnA` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `q4f1lb`
--

CREATE TABLE `q4f1lb` (
  `id` int(255) NOT NULL,
  `UniqueUserID` int(255) NOT NULL,
  `UniqueQuizUrl` varchar(255) NOT NULL,
  `Nickname` varchar(255) NOT NULL,
  `Points` int(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dares`
--
ALTER TABLE `dares`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `q4f1`
--
ALTER TABLE `q4f1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `q4f1lb`
--
ALTER TABLE `q4f1lb`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dares`
--
ALTER TABLE `dares`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `q4f1`
--
ALTER TABLE `q4f1`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `q4f1lb`
--
ALTER TABLE `q4f1lb`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
