-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Sep 03, 2019 at 05:55 PM
-- Server version: 5.7.26
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `celesta2k19`
--

-- --------------------------------------------------------

--
-- Table structure for table `ca_users`
--

CREATE TABLE `ca_users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `validation_code` text NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `phone` varchar(15) NOT NULL,
  `college` varchar(100) NOT NULL,
  `celestaid` varchar(8) NOT NULL,
  `qrcode` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `gender` varchar(1) NOT NULL,
  `gravitons` bigint(20) NOT NULL DEFAULT '0',
  `candidates` json DEFAULT NULL,
  `excitons` bigint(20) NOT NULL DEFAULT '50'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ca_users`
--

INSERT INTO `ca_users` (`id`, `email`, `first_name`, `last_name`, `password`, `validation_code`, `active`, `phone`, `college`, `celestaid`, `qrcode`, `date`, `gender`, `gravitons`, `candidates`, `excitons`) VALUES
(2, 'hayyoulistentome@gmail.com', 'Amartya', 'Mondal', '21b8acfc474802e2e0bd25a85f5e924e', '6378e0140437eae0cea61070f8b9303d', 1, '8967570983', 'IIT Patna', 'CLST1504', 'http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/CLST5652.png', '2019-08-24 13:06:35', 'm', 30, NULL, 105),
(3, '8967570983@gmail.com', 'Amartya', 'Mondal', '21b8acfc474802e2e0bd25a85f5e924e', '13bff630177d1e119024ea72339203b6', 1, '8967570983', 'IIT Patna', 'CLST5523', 'http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/CLST5523.png', '2019-09-01 13:17:06', 'm', 20, NULL, 70);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ca_users`
--
ALTER TABLE `ca_users`
  ADD PRIMARY KEY (`id`,`email`),
  ADD UNIQUE KEY `celestaid` (`celestaid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ca_users`
--
ALTER TABLE `ca_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
