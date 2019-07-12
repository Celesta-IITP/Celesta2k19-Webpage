-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jul 12, 2019 at 12:14 PM
-- Server version: 5.7.25
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `celesta2k19`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `second_name` varchar(255) NOT NULL,
  `permit` int(11) NOT NULL DEFAULT '1',
  `id` int(11) NOT NULL,
  `position` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL DEFAULT '21b8acfc474802e2e0bd25a85f5e924e'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`email`, `first_name`, `second_name`, `permit`, `id`, `position`, `phone`, `password`) VALUES
('hayyoulistentome@gmail.com', 'Amartya', 'Mondal', 2, 3, 'Registration Coordinator', '8967570983', '7f6ffaa6bb0b408017b62254211691b5'),
('me@atm1504.in', 'Atreyee', 'Mukherjee', 1, 1, 'Registration-Sub Coordinator', '8967570983', '21b8acfc474802e2e0bd25a85f5e924e'),
('you@atm1504.in', 'Amartya', 'Mondal', 1, 2, 'Registration-Sub Coordinator', '8967570983', '21b8acfc474802e2e0bd25a85f5e924e');

-- --------------------------------------------------------

--
-- Table structure for table `present_users`
--

CREATE TABLE `present_users` (
  `id` int(11) NOT NULL,
  `celestaid` varchar(10) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `college` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` varchar(100) NOT NULL,
  `events_registered` varchar(255) DEFAULT NULL,
  `events_participated` varchar(255) DEFAULT NULL,
  `qrcode` varchar(255) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `day1_checkin` datetime DEFAULT NULL,
  `day1_checkout` datetime DEFAULT NULL,
  `day2_checkin` datetime DEFAULT NULL,
  `day2_checkout` datetime DEFAULT NULL,
  `gender` varchar(1) NOT NULL,
  `total_charge` int(11) NOT NULL DEFAULT '0',
  `registration_charge` int(11) NOT NULL DEFAULT '0',
  `tshirt_charge` int(11) NOT NULL DEFAULT '0',
  `bandpass_charge` int(11) NOT NULL DEFAULT '0',
  `checkin_checkout` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `present_users`
--

INSERT INTO `present_users` (`id`, `celestaid`, `first_name`, `last_name`, `password`, `email`, `phone`, `college`, `date`, `added_by`, `events_registered`, `events_participated`, `qrcode`, `active`, `day1_checkin`, `day1_checkout`, `day2_checkin`, `day2_checkout`, `gender`, `total_charge`, `registration_charge`, `tshirt_charge`, `bandpass_charge`, `checkin_checkout`) VALUES
(26, 'CLST1504', 'Amartya', 'Mondal', '21b8acfc474802e2e0bd25a85f5e924e', 'hayyoulistentome@gmail.com', '9475266283', 'IIT Patna', '2019-05-29 07:44:55', 'admin', '', '', 'http://localhost:8888/login/assets/qrcodes/CLST1504.png', 1, NULL, NULL, NULL, NULL, 'm', 100, 100, 0, 0, '[[\"checkin\", \"Wed, 29 May 2019, 13:15:24\"], [\"checkout\", \"Wed, 29 May 2019, 13:16:13\"], [\"checkout\", \"Wed, 29 May 2019, 13:18:09\"], [\"checkout\", \"Wed, 29 May 2019, 13:24:15\"], [\"checkout\", \"Wed, 29 May 2019, 13:24:49\"], [\"checkout\", \"Wed, 29 May 2019, 13:25:35\"], [\"checkout\", \"Wed, 29 May 2019, 13:26:24\"], [\"checkout\", \"Wed, 29 May 2019, 13:26:36\"], [\"checkout\", \"Wed, 29 May 2019, 13:29:12\"], [\"checkout\", \"Wed, 29 May 2019, 13:29:54\"], [\"checkout\", \"Wed, 29 May 2019, 13:31:30\"], [\"checkin\", \"Wed, 29 May 2019, 13:32:47\"], [\"checkout\", \"Wed, 29 May 2019, 13:33:37\"], [\"checkin\", \"Wed, 29 May 2019, 13:33:41\"], [\"checkout\", \"Wed, 29 May 2019, 13:33:46\"], [\"checkin\", \"Wed, 29 May 2019, 13:33:49\"], [\"checkout\", \"Wed, 29 May 2019, 13:50:24\"], [\"checkin\", \"Wed, 29 May 2019, 13:50:28\"], [\"checkout\", \"Wed, 29 May 2019, 13:50:34\"], [\"checkin\", \"Wed, 29 May 2019, 13:50:38\"], [\"checkout\", \"Wed, 29 May 2019, 13:50:41\"], [\"checkin\", \"Wed, 29 May 2019, 13:51:06\"], [\"checkout\", \"Wed, 29 May 2019, 13:51:13\"], [\"checkin\", \"Wed, 29 May 2019, 13:52:52\"], [\"checkout\", \"Wed, 29 May 2019, 13:54:02\"], [\"checkin\", \"Wed, 29 May 2019, 13:55:14\"], [\"checkout\", \"Wed, 29 May 2019, 14:00:19\"], [\"checkin\", \"Wed, 29 May 2019, 14:00:25\"], [\"checkout\", \"Wed, 29 May 2019, 14:02:37\"], [\"checkin\", \"Wed, 29 May 2019, 14:22:11\"], [\"checkout\", \"Wed, 29 May 2019, 14:22:31\"], [\"checkin\", \"Wed, 29 May 2019, 14:23:52\"]]'),
(23, 'CLST2124', 'Atreyee', 'Mukherjee', '3fc0a7acf087f549ac2b266baf94b8b1', 'dscappsocietyiitp@gmail.com', '8967570983', 'CMC, Kolkata', '2019-05-23 15:00:22', '', '', '', 'http://localhost:8888/login/assets/qrcodes/CLST2124.png', 1, NULL, NULL, NULL, NULL, 'm', 100, 100, 0, 0, NULL),
(24, 'CLST6557', 'Atreyee', 'Mukherjee', '21b8acfc474802e2e0bd25a85f5e924e', 'hayyoulistentome1@gmail.com', '9475266283', 'CMC, Kolkata', '2019-05-23 15:43:55', 'hayyoulistentome@gmail.com', NULL, NULL, 'http://localhost:8888/login/assets/qrcodes/CLST6557.png', 1, NULL, NULL, NULL, NULL, 'f', 500, 100, 300, 200, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `validation_code` text NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `phone` varchar(15) NOT NULL,
  `college` varchar(255) NOT NULL,
  `celestaid` varchar(8) NOT NULL,
  `qrcode` varchar(255) NOT NULL,
  `added_by` varchar(255) NOT NULL DEFAULT 'admin',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `events_registered` varchar(255) DEFAULT NULL,
  `events_participated` varchar(255) DEFAULT NULL,
  `gender` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `validation_code`, `active`, `phone`, `college`, `celestaid`, `qrcode`, `added_by`, `date`, `events_registered`, `events_participated`, `gender`) VALUES
(80, 'Amartya', 'Mondal', 'hayyoulistentome@gmail.com', '21b8acfc474802e2e0bd25a85f5e924e', '0', 1, '9475266283', 'IIT Patna', 'CLST1504', 'http://localhost:8888/login/assets/qrcodes/CLST1504.png', 'admin', '2019-05-22 21:37:14', NULL, NULL, 'm'),
(90, 'Atreyee', 'Mukherjee', 'dscappsocietyiitp@gmail.com', '3fc0a7acf087f549ac2b266baf94b8b1', '0', 1, '8967570983', 'CMC, Kolkata', 'CLST2124', 'http://localhost:8888/login/assets/qrcodes/CLST2124.png', '', '2019-05-23 14:48:06', NULL, NULL, 'm'),
(100, 'atm', 'mondal', 'hayyoulistentome1@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '84598', 0, '8967570983', 'cmc', 'CLST3055', 'http://192.168.0.100:8888/login/assets/qrcodes/CLST3055.png', 'admin', '2019-05-28 09:53:09', NULL, NULL, 'f'),
(101, 'atm', 'mondal', 'hayyoulistentome2@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '52123', 0, '8967570983', 'cmc', 'CLST2737', 'http://192.168.0.100:8888/login/assets/qrcodes/CLST2737.png', 'admin', '2019-05-28 09:55:46', NULL, NULL, 'f'),
(102, 'atm', 'mondal', 'hayyoulistentome34@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '58981', 0, '8967570983', 'cmc', 'CLST3177', 'http://192.168.0.100:8888/login/assets/qrcodes/CLST3177.png', 'admin', '2019-05-28 09:56:18', NULL, NULL, 'f');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`email`,`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `present_users`
--
ALTER TABLE `present_users`
  ADD PRIMARY KEY (`celestaid`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `id` (`id`,`email`),
  ADD UNIQUE KEY `celestaid` (`celestaid`),
  ADD UNIQUE KEY `qrcode` (`qrcode`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `present_users`
--
ALTER TABLE `present_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;
