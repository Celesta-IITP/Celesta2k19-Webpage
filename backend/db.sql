-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Oct 06, 2019 at 08:37 AM
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
  `id` int(11) NOT NULL,
  `permit` int(11) NOT NULL DEFAULT '1',
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `second_name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL DEFAULT '21b8acfc474802e2e0bd25a85f5e924e'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `permit`, `email`, `first_name`, `second_name`, `position`, `phone`, `password`) VALUES
(5, 4, 'event@atm1504.in', 'Amartya', 'Mondal', 'Event Organisers', '8967570983', '21b8acfc474802e2e0bd25a85f5e924e'),
(1, 0, 'me@atm1504.in', 'Atreyee', 'Mukherjee', 'Super Admin', '8967570983', '21b8acfc474802e2e0bd25a85f5e924e'),
(4, 3, 'mpr@atm1504.in', 'MPR', 'People', 'MPR', '8967570983', '21b8acfc474802e2e0bd25a85f5e924e'),
(3, 2, 'reg_cord@atm1504.in', 'Amartya', 'Mondal', 'Registration Coordinator', '8967570983', '21b8acfc474802e2e0bd25a85f5e924e'),
(2, 1, 'reg_sub_cord@atm1504.in', 'Amartya', 'Mondal', 'Registration-Sub Coordinator', '8967570983', '21b8acfc474802e2e0bd25a85f5e924e');

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
(2, 'hayyoulistentome@gmail.com', 'Amartya', 'Mondal', '21b8acfc474802e2e0bd25a85f5e924e', '6378e0140437eae0cea61070f8b9303d', 1, '8967570983', 'IIT Patna', 'CLST1504', 'http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/CLST5652.png', '2019-08-24 13:06:35', 'm', 30, NULL, 115),
(3, '8967570983@gmail.com', 'Amartya', 'Mondal', '21b8acfc474802e2e0bd25a85f5e924e', '13bff630177d1e119024ea72339203b6', 1, '8967570983', 'IIT Patna', 'CLST5523', 'http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/CLST5523.png', '2019-09-01 13:17:06', 'm', 20, NULL, 70);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `ev_id` varchar(7) NOT NULL,
  `ev_category` varchar(252) NOT NULL,
  `ev_name` varchar(255) NOT NULL,
  `ev_description` text NOT NULL,
  `ev_organiser` varchar(255) NOT NULL,
  `ev_club` varchar(252) NOT NULL,
  `ev_org_phone` varchar(100) NOT NULL,
  `ev_poster_url` varchar(255) NOT NULL,
  `ev_rule_book_url` varchar(255) NOT NULL,
  `ev_date` varchar(50) NOT NULL,
  `ev_start_time` varchar(100) NOT NULL,
  `ev_end_time` varchar(100) NOT NULL,
  `ev_registrations` json DEFAULT NULL,
  `ev_participations` json DEFAULT NULL,
  `ev_venue` varchar(255) DEFAULT NULL,
  `ev_amount` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `ev_id`, `ev_category`, `ev_name`, `ev_description`, `ev_organiser`, `ev_club`, `ev_org_phone`, `ev_poster_url`, `ev_rule_book_url`, `ev_date`, `ev_start_time`, `ev_end_time`, `ev_registrations`, `ev_participations`, `ev_venue`, `ev_amount`) VALUES
(2, 'ATM3771', 'Events', 'testingwewe', 'ewqew rwew ', 'atm', 'NJACK', '413234567', 'https://celesta.org.in/backend/admin./events/posters/ATM3771_testingwewe.jpg', 'https://celesta.org.in/backend/admin./events/rulebook/ATM3771_testing.jpg', '12/09/2018', '5:00pm', '7:00pm', NULL, NULL, NULL, 0),
(3, 'ATM5151', 'Events', 'Abcd', 'this event is for testing', 'ds', 'NJACK', 'sd', 'https://celesta.org.in/backend/admin./events/posters/ATM5151_Abcd.jpg', 'https://celesta.org.in/backend/admin./events/rulebook/ATM5151_Abcd.jpg', '12/09/2018', '5:00pm', '7:00pm', NULL, NULL, NULL, 0),
(4, 'ATM4670', 'Workshops', 'Testing atm', 'Just do it', 'atm', 'LOCK-N-LOAD', '8967570983', 'https://celesta.org.in/backend/admin./events/posters/ATM4670_Testing atm.jpg', 'https://celesta.org.in/backend/admin./events/rulebook/ATM4670_Testing atm.pdf', '12/09/2018', '5:00pm', '7:00pm', NULL, NULL, NULL, 0),
(5, 'ATM5986', 'Events', 'Checking dot', 'A dummy event', 'atm', 'ROBOTICS', '8967570983', 'https://celesta.org.in/backend/admin/events/posters/ATM5986_Checking dot.jpg', 'https://celesta.org.in/backend/admin/events/rulebook/ATM5986_Checking dot.pdf', '12/09/2018', '5:00pm', '7:00pm', NULL, NULL, NULL, 0);

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
  `events_charge` float NOT NULL DEFAULT '0',
  `checkin_checkout` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `present_users`
--

INSERT INTO `present_users` (`id`, `celestaid`, `first_name`, `last_name`, `password`, `email`, `phone`, `college`, `date`, `added_by`, `events_registered`, `events_participated`, `qrcode`, `active`, `day1_checkin`, `day1_checkout`, `day2_checkin`, `day2_checkout`, `gender`, `total_charge`, `registration_charge`, `tshirt_charge`, `bandpass_charge`, `events_charge`, `checkin_checkout`) VALUES
(33, 'CLST1001', 'Ar', 'M', '3fc0a7acf087f549ac2b266baf94b8b1', 'eweswf@gmail.com', '8967570983', 'IIT Patna', '2019-09-13 10:19:45', '', NULL, NULL, 'http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/CLST1001.png', 1, NULL, NULL, NULL, NULL, 'm', 100, 100, 0, 0, 0, NULL),
(26, 'CLST1504', 'Amartya', 'Mondal', '21b8acfc474802e2e0bd25a85f5e924e', 'hayyoulistentome@gmail.com', '9475266283', 'IIT Patna', '2019-05-29 07:44:55', 'admin', '[{\"ev_name\":\"Abcd\",\"ev_id\":\"ATM5151\",\"amount\":0}]', '', 'http://localhost:8888/login/assets/qrcodes/CLST1504.png', 1, NULL, NULL, NULL, NULL, 'm', 400, 100, 300, 0, 0, '[[\"checkin\", \"Wed, 29 May 2019, 13:15:24\"], [\"checkout\", \"Wed, 29 May 2019, 13:16:13\"], [\"checkout\", \"Wed, 29 May 2019, 13:18:09\"], [\"checkout\", \"Wed, 29 May 2019, 13:24:15\"], [\"checkout\", \"Wed, 29 May 2019, 13:24:49\"], [\"checkout\", \"Wed, 29 May 2019, 13:25:35\"], [\"checkout\", \"Wed, 29 May 2019, 13:26:24\"], [\"checkout\", \"Wed, 29 May 2019, 13:26:36\"], [\"checkout\", \"Wed, 29 May 2019, 13:29:12\"], [\"checkout\", \"Wed, 29 May 2019, 13:29:54\"], [\"checkout\", \"Wed, 29 May 2019, 13:31:30\"], [\"checkin\", \"Wed, 29 May 2019, 13:32:47\"], [\"checkout\", \"Wed, 29 May 2019, 13:33:37\"], [\"checkin\", \"Wed, 29 May 2019, 13:33:41\"], [\"checkout\", \"Wed, 29 May 2019, 13:33:46\"], [\"checkin\", \"Wed, 29 May 2019, 13:33:49\"], [\"checkout\", \"Wed, 29 May 2019, 13:50:24\"], [\"checkin\", \"Wed, 29 May 2019, 13:50:28\"], [\"checkout\", \"Wed, 29 May 2019, 13:50:34\"], [\"checkin\", \"Wed, 29 May 2019, 13:50:38\"], [\"checkout\", \"Wed, 29 May 2019, 13:50:41\"], [\"checkin\", \"Wed, 29 May 2019, 13:51:06\"], [\"checkout\", \"Wed, 29 May 2019, 13:51:13\"], [\"checkin\", \"Wed, 29 May 2019, 13:52:52\"], [\"checkout\", \"Wed, 29 May 2019, 13:54:02\"], [\"checkin\", \"Wed, 29 May 2019, 13:55:14\"], [\"checkout\", \"Wed, 29 May 2019, 14:00:19\"], [\"checkin\", \"Wed, 29 May 2019, 14:00:25\"], [\"checkout\", \"Wed, 29 May 2019, 14:02:37\"], [\"checkin\", \"Wed, 29 May 2019, 14:22:11\"], [\"checkout\", \"Wed, 29 May 2019, 14:22:31\"], [\"checkin\", \"Wed, 29 May 2019, 14:23:52\"]]'),
(23, 'CLST2124', 'Atreyee', 'Mukherjee', '3fc0a7acf087f549ac2b266baf94b8b1', 'dscappsocietyiitp@gmail.com', '8967570983', 'CMC, Kolkata', '2019-05-23 15:00:22', '', '', '', 'http://localhost:8888/login/assets/qrcodes/CLST2124.png', 1, NULL, NULL, NULL, NULL, 'm', 100, 100, 0, 0, 0, NULL),
(32, 'CLST3396', 'Arwewe', 'M', '3fc0a7acf087f549ac2b266baf94b8b1', 'wqdee@gmail.com', '8967570983', 'IIT Patna', '2019-09-13 10:17:55', '', NULL, NULL, 'http://localhost:8888/Celesta2k19-Webpage/assets/qrcodes/CLST3396.png', 1, NULL, NULL, NULL, NULL, 'm', 400, 100, 300, 0, 0, NULL),
(34, 'CLST4110', 'Amartya', 'Mondal', '21b8acfc474802e2e0bd25a85f5e924e', 'hayyoulistentome12@gmail.com', '8967570983', 'IIT Patna', '2019-10-06 06:20:06', 'admin', '[{\"ev_name\":\"Abcd\",\"ev_id\":\"ATM5151\"}]', '', 'http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/CLST4210.png', 1, NULL, NULL, NULL, NULL, 'f', 100, 100, 0, 0, 0, NULL),
(30, 'CLST5229', 'Ar', 'M', '3fc0a7acf087f549ac2b266baf94b8b1', 'ewewf@gmail.com', '8967570983', 'IIT Patna', '2019-09-13 10:10:28', '', NULL, NULL, 'http://localhost:8888/Celesta2k19-Webpage/assets/qrcodes/CLST5229.png', 1, NULL, NULL, NULL, NULL, 'm', 0, 0, 0, 0, 0, NULL),
(29, 'CLST5262', 'Ar', 'M', '3fc0a7acf087f549ac2b266baf94b8b1', 'hayyoulistentome1@gmail.com', '8967570983', 'IIT Patna', '2019-09-13 10:06:17', '', NULL, NULL, 'http://localhost:8888/Celesta2k19-Webpage/assets/qrcodes/CLST5262.png', 1, NULL, NULL, NULL, NULL, 'm', 0, 0, 0, 0, 0, NULL),
(31, 'CLST6586', 'Amartya', 'Mondal', '4297f44b13955235245b2497399d7a93', 'she@atm1504.in', '8967570983', 'IIT Patna', '2019-09-13 10:14:13', 'admin', '', '', 'http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/CLST6586.png', 1, NULL, NULL, NULL, NULL, 'f', 100, 100, 0, 0, 0, NULL);

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
  `events_registered` json DEFAULT NULL,
  `events_participated` json DEFAULT NULL,
  `gender` varchar(1) NOT NULL,
  `referral_id` varchar(8) DEFAULT 'CLST1504',
  `access_token` varchar(255) DEFAULT NULL,
  `registration_charge` float NOT NULL DEFAULT '0',
  `total_charge` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `validation_code`, `active`, `phone`, `college`, `celestaid`, `qrcode`, `added_by`, `ca_referral`, `date`, `events_registered`, `events_participated`, `gender`, `referral_id`, `access_token`, `registration_charge`, `total_charge`) VALUES
(112, 'Amartya', 'Mondal', 'hayyoulistentome67@gmail.com', '21b8acfc474802e2e0bd25a85f5e924e', '0', 1, '8967570983', 'IIT Patna', 'CLST1505', 'http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/CLST5847.png', 'admin', NULL, '2019-08-24 13:59:10', NULL, NULL, 'm', 'CLST1504', '584a0966c8a2bb57e78f3d8164e2a384', 0, 0),
(117, 'Amartya', 'Mondal', 'hayyoulistentome@gmail.com', '21b8acfc474802e2e0bd25a85f5e924e', 'b203900e765c2c25287dd6d8ba3ddced', 1, '8967570983', 'IIT Patna', 'CLST1504', 'http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/CLST4210.png', 'admin', 'CLST1504', '2019-08-27 19:55:21', NULL, NULL, 'f', 'CLST1504', '584a0966c8a2bb57e78f3d8164e2a384', 0, 0),
(118, 'Amartya', 'Mondal', 'me@atm1504.in', '21b8acfc474802e2e0bd25a85f5e924e', 'c0cdfc5b3e8d40f2f9d6836b982785ba', 0, '8967570983', 'IIT Patna', 'CLST9148', 'http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/CLST9148.png', 'admin', 'CLST1504', '2019-08-31 21:30:42', NULL, NULL, 'm', 'CLST1504', NULL, 0, 0),
(119, 'Amartya', 'Mondal', 'she@atm1504.in', '4297f44b13955235245b2497399d7a93', '182686d2f96f2ed71bca6305093b9718', 0, '8967570983', 'IIT Patna', 'CLST6586', 'http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/CLST6586.png', 'admin', 'CLST1504', '2019-08-31 21:32:59', NULL, NULL, 'f', 'CLST1504', NULL, 0, 0),
(120, 'Amartya', 'Mondal', '8967570983@gmail.com', '21b8acfc474802e2e0bd25a85f5e924e', '13bff630177d1e119024ea72339203b6', 1, '8967570983', 'IIT Patna', 'CLST5523', 'http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/CLST5523.png', 'admin', NULL, '2019-09-01 13:17:06', NULL, NULL, 'm', 'CLST1504', NULL, 0, 0),
(123, 'Ar', 'M', 'hayyoulistentome1@gmail.com', '3fc0a7acf087f549ac2b266baf94b8b1', '0', 1, '8967570983', 'IIT Patna', 'CLST5262', 'http://localhost:8888/Celesta2k19-Webpage/assets/qrcodes/CLST5262.png', '', NULL, '2019-09-13 10:06:17', NULL, NULL, 'm', 'CLST1504', NULL, 0, 0),
(124, 'Ar', 'M', 'ewewf@gmail.com', '3fc0a7acf087f549ac2b266baf94b8b1', '0', 1, '8967570983', 'IIT Patna', 'CLST5229', 'http://localhost:8888/Celesta2k19-Webpage/assets/qrcodes/CLST5229.png', '', NULL, '2019-09-13 10:10:28', NULL, NULL, 'm', 'CLST1504', NULL, 0, 0),
(125, 'Arwewe', 'M', 'wqdee@gmail.com', '3fc0a7acf087f549ac2b266baf94b8b1', '0', 1, '8967570983', 'IIT Patna', 'CLST3396', 'http://localhost:8888/Celesta2k19-Webpage/assets/qrcodes/CLST3396.png', '', NULL, '2019-09-13 10:17:55', NULL, NULL, 'm', 'CLST1504', NULL, 0, 0),
(126, 'Ar', 'M', 'eweswf@gmail.com', '3fc0a7acf087f549ac2b266baf94b8b1', '0', 1, '8967570983', 'IIT Patna', 'CLST1001', 'http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/CLST1001.png', '', NULL, '2019-09-13 10:19:45', NULL, NULL, 'm', 'CLST1504', NULL, 0, 0),
(127, 'Arwewe', 'Mqwer', 'technicalskills17@gmail.com', '21b8acfc474802e2e0bd25a85f5e924e', 'dab5d4e07fc8fd116fb04fc94c1288ce', 1, '8967570983', 'IIT Patna', 'CLST5830', 'http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/CLST5830.png', 'admin', 'CLST1504', '2019-09-13 10:24:51', NULL, NULL, 'm', 'CLST1504', NULL, 0, 0),
(128, 'Amartya', 'Mondal', 'hayyoulistentome123@gmail.com', '25d55ad283aa400af464c76d713c07ad', '4892feb0deaf9417cb1feb44a785616d', 0, '8967570983', 'IIT Patna', 'CLST7451', 'https://celesta.org.in/backend/user/assets/qrcodes/CLST7451.png', 'admin', 'CLST1504', '2019-10-02 07:14:06', NULL, NULL, 'm', 'CLST1504', NULL, 0, 0);

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
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ev_id` (`ev_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ca_users`
--
ALTER TABLE `ca_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `present_users`
--
ALTER TABLE `present_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;
