-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Aug 24, 2019 at 07:10 AM
-- Server version: 5.7.26
-- PHP Version: 7.3.7

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
('hayyoulistentome@gmail.com', 'Amartya', 'Mondal', 2, 3, 'Registration Coordinator', '8967570983', '21b8acfc474802e2e0bd25a85f5e924e'),
('me@atm1504.in', 'Atreyee', 'Mukherjee', 2, 1, 'Registration-Sub Coordinator', '8967570983', '21b8acfc474802e2e0bd25a85f5e924e'),
('you@atm1504.in', 'Amartya', 'Mondal', 1, 2, 'Registration-Sub Coordinator', '8967570983', '21b8acfc474802e2e0bd25a85f5e924e');

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
  `points` bigint(20) NOT NULL DEFAULT '0',
  `candidates` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ca_users`
--

INSERT INTO `ca_users` (`id`, `email`, `first_name`, `last_name`, `password`, `validation_code`, `active`, `phone`, `college`, `celestaid`, `qrcode`, `date`, `gender`, `points`, `candidates`) VALUES
(1, 'hayyoulistentome@gmail.com', 'Amartya', 'Mondal', '21b8acfc474802e2e0bd25a85f5e924e', '0', 1, '8967570983', 'IIT Patna', 'CLST4249', 'http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/CLST4249.png', '2019-08-24 06:24:40', 'm', 0, NULL);

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
  `ca_referral` varchar(8) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `events_registered` varchar(255) DEFAULT NULL,
  `events_participated` varchar(255) DEFAULT NULL,
  `gender` varchar(1) NOT NULL,
  `referral_id` varchar(8) DEFAULT 'CLST1504'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `validation_code`, `active`, `phone`, `college`, `celestaid`, `qrcode`, `added_by`, `ca_referral`, `date`, `events_registered`, `events_participated`, `gender`, `referral_id`) VALUES
(109, 'Amartya', 'Mondal', 'hayyoulistentome@gmail.com', '21b8acfc474802e2e0bd25a85f5e924e', '0', 1, '8967570983', 'IIT Patna', 'CLST4249', 'http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/CLST4249.png', 'admin', NULL, '2019-08-24 06:24:40', NULL, NULL, 'm', 'CLST1504');

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
-- Indexes for table `ca_users`
--
ALTER TABLE `ca_users`
  ADD PRIMARY KEY (`id`,`email`),
  ADD UNIQUE KEY `celestaid` (`celestaid`);

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
-- AUTO_INCREMENT for table `ca_users`
--
ALTER TABLE `ca_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `present_users`
--
ALTER TABLE `present_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;
