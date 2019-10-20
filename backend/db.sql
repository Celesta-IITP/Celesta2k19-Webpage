-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Oct 20, 2019 at 08:52 AM
-- Server version: 5.7.26
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `celesta2k19`
--

-- --------------------------------------------------------

--
-- Table structure for table `accommodation`
--

CREATE TABLE `accommodation` (
  `id` int(11) NOT NULL,
  `celestaid` varchar(8) NOT NULL,
  `names` varchar(109) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `amount_paid` float NOT NULL DEFAULT '0',
  `gender` varchar(1) NOT NULL,
  `booking_date` varchar(100) NOT NULL,
  `checkin` json DEFAULT NULL,
  `checkout` json DEFAULT NULL,
  `no_of_days` int(11) NOT NULL,
  `day1` tinyint(1) NOT NULL DEFAULT '0',
  `day2` tinyint(1) NOT NULL DEFAULT '0',
  `day3` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `accommodation`
--

INSERT INTO `accommodation` (`id`, `celestaid`, `names`, `phone`, `amount_paid`, `gender`, `booking_date`, `checkin`, `checkout`, `no_of_days`, `day1`, `day2`, `day3`, `email`) VALUES
(4, 'CLST2057', 'Amartya Mondal', '8967570983', 500, 'm', '2019-10-20 08:43:21', NULL, NULL, 3, 1, 1, 1, 'dscappsocietyiitp@gmail.com');

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
  `password` varchar(255) NOT NULL DEFAULT '21b8acfc474802e2e0bd25a85f5e924e',
  `access_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `permit`, `email`, `first_name`, `second_name`, `position`, `phone`, `password`, `access_token`) VALUES
(5, 4, 'event@atm1504.in', 'Amartya', 'Mondal', 'Event Organisers', '8967570983', '21b8acfc474802e2e0bd25a85f5e924e', NULL),
(1, 0, 'me@atm1504.in', 'Atreyee', 'Mukherjee', 'Super Admin', '8967570983', '21b8acfc474802e2e0bd25a85f5e924e', 'bf4059d977e15f7628d7dbb106944ec1'),
(4, 3, 'mpr@atm1504.in', 'MPR', 'People', 'MPR', '8967570983', '21b8acfc474802e2e0bd25a85f5e924e', NULL),
(3, 2, 'reg@atm1504.in', 'Amartya', 'Mondal', 'Registration Coordinator', '8967570983', '21b8acfc474802e2e0bd25a85f5e924e', NULL),
(2, 1, 'reg_sub_cord@atm1504.in', 'Amartya', 'Mondal', 'Registration-Sub Coordinator', '8967570983', '21b8acfc474802e2e0bd25a85f5e924e', NULL);

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
(2, 'hayyoulistentome@gmail.com', 'Amartya', 'Mondal', '21b8acfc474802e2e0bd25a85f5e924e', '6378e0140437eae0cea61070f8b9303d', 1, '8967570983', 'IIT Patna', 'CLST1504', 'http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/CLST5652.png', '2019-08-24 13:06:35', 'm', 30, NULL, 100),
(3, '8967570983@gmail.com', 'Amartya', 'Mondal', '21b8acfc474802e2e0bd25a85f5e924e', '13bff630177d1e119024ea72339203b6', 1, '8967570983', 'IIT Patna', 'CLST5523', 'http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/CLST5523.png', '2019-09-01 13:17:06', 'm', 20, NULL, 70),
(4, 'dscappsocietyiitp@gmail.com', 'Amartya', 'Mondal', '21b8acfc474802e2e0bd25a85f5e924e', '4d0cee4a483a3798eef834d34dbf84f2', 0, '8967570983', 'IIT Patna', 'CLST8629', 'https://celesta.org.in/backend/user/assets/qrcodes/CLST1416.png', '2019-10-07 06:28:46', 'm', 0, NULL, 50);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `ev_id` varchar(7) NOT NULL,
  `ev_category` varchar(252) NOT NULL,
  `ev_type` varchar(30) NOT NULL DEFAULT 'College Event',
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
  `ev_prize` varchar(100) DEFAULT NULL,
  `ev_participations` json DEFAULT NULL,
  `ev_venue` varchar(255) DEFAULT NULL,
  `map_url` varchar(255) DEFAULT NULL,
  `ev_amount` float NOT NULL DEFAULT '0',
  `is_team_event` tinyint(1) NOT NULL DEFAULT '0',
  `team_members` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `ev_id`, `ev_category`, `ev_type`, `ev_name`, `ev_description`, `ev_organiser`, `ev_club`, `ev_org_phone`, `ev_poster_url`, `ev_rule_book_url`, `ev_date`, `ev_start_time`, `ev_end_time`, `ev_registrations`, `ev_prize`, `ev_participations`, `ev_venue`, `map_url`, `ev_amount`, `is_team_event`, `team_members`) VALUES
(2, 'ATM3771', 'Events', 'School Event', 'testingwewe', 'ewqew rwew ', 'atm', 'NJACK', '413234567', 'https://celesta.org.in/backend/admin./events/posters/ATM3771_testingwewe.jpg', 'https://celesta.org.in/backend/admin./events/rulebook/ATM3771_testing.jpg', '12/09/2018', '5:00pm', '7:00pm', NULL, '1k', NULL, 'tut block', '', 100, 0, 2),
(3, 'ATM5151', 'Events', 'College Event', 'Abcd', 'this event is for testing', 'ds', 'NJACK', 'sd', 'https://celesta.org.in/backend/admin./events/posters/ATM5151_Abcd.jpg', 'https://celesta.org.in/backend/admin./events/rulebook/ATM5151_Abcd.jpg', '12/09/2018', '5:00pm', '7:00pm', NULL, NULL, NULL, NULL, NULL, 0, 0, 1),
(4, 'ATM4670', 'Workshops', 'School Event', 'Testing atm', 'Just do it', 'atm', 'TREASURE-HUNT', '8967570983', 'https://celesta.org.in/backend/admin./events/posters/ATM4670_Testing atm.jpg', 'https://celesta.org.in/backend/admin./events/rulebook/ATM4670_Testing atm.pdf', '12/09/2018', '5:00pm', '7:00pm', NULL, NULL, NULL, '', '', 0, 0, 1),
(5, 'ATM5986', 'Events', 'College Event', 'Checking dot', 'A dummy event', 'atm', 'ROBOTICS', '8967570983', 'https://celesta.org.in/backend/admin/events/posters/ATM5986_Checking dot.jpg', 'https://celesta.org.in/backend/admin/events/rulebook/ATM5986_Checking dot.pdf', '12/09/2018', '5:00pm', '7:00pm', NULL, NULL, NULL, NULL, NULL, 0, 0, 1),
(6, 'ATM5615', 'Events', 'College Event', 'testing1', 'testing event', 'atm', 'TREASURE-HUNT', '8967570983', 'https://celesta.org.in/backend/admin/events/posters/ATM5615_testing1.jpg', 'https://celesta.org.in/backend/admin/events/rulebook/ATM5615_testing1.pdf', '12/09/2018', '5:00pm', '7:00pm', NULL, NULL, NULL, 'tut block', NULL, 100.5, 0, 1),
(7, 'ATM9933', 'Events', 'College Event', 'Robowars', 'cghfgh', 'ds', 'TECH', '8967570983', 'https://celesta.org.in/backend/admin/events/posters/ATM9933_Abcd.jpg', 'https://celesta.org.in/backend/admin/events/rulebook/ATM9933_Abcd.pdf', '12/09/2018', '5:00pm', '7:00pm', '[{\"time\": \"2019-10-18 14:06:09\", \"amount\": \"110.5\", \"cap_name\": \"Amartya Mondal\", \"cap_email\": \"hayyoulistentome@gmail.com\", \"cap_phone\": \"8967570983\", \"mem1_name\": \"Amartya Mondal\", \"mem2_name\": \"Amartya Mondal\", \"team_name\": \"atm\", \"mem1_email\": \"hayyoulistentome67@gmail.com\", \"mem1_phone\": \"8967570983\", \"mem2_email\": \"dscappsocietyiitp@gmail.com\", \"mem2_phone\": \"8967570983\", \"cap_celestaid\": \"CLST1504\", \"mem1_celestaid\": \"CLST1505\", \"mem2_celestaid\": \"CLST6283\"}]', NULL, NULL, 'tut block', '', 100.5, 1, 5),
(8, 'ATM6932', 'Events', 'College Event', 'ABC1', 'ertty ', ',mn', 'TECH', '8967570983', 'https://celesta.org.in/backend/admin/events/posters/ATM6932_hgfgfhfgh.jpg', 'https://celesta.org.in/backend/admin/events/rulebook/ATM6932_hgfgfhfgh.pdf', '12/09/2018', '10:00AM', '7:00pm', NULL, NULL, NULL, 'tut block', '', 100, 0, 1),
(9, 'ATM7680', 'Events', 'College Event', 'Testing myself', 'Tsting event please ignore', 'ds', 'NON-TECH', '8967570983', 'https://celesta.org.in/backend/admin/events/posters/ATM7680_Testing myself.jpg', 'https://celesta.org.in/backend/admin/events/rulebook/ATM7680_Testing myself.pdf', '12/09/2018', '5:00pm', '7:00pm', NULL, NULL, NULL, 'tut block', '', 100.5, 0, 1),
(10, 'ATM6537', 'Events', 'College Event', 'Abcd', 'The greatest personalities dont just speak, they express.\r\nDo you have the qualities to be the changes maker? Can you be the guiding lamp for the future generations to follow? Is your personality bold enough to express?\r\nThen Celesta gives you the ideal platform to showcase your talent and develop your personality. LogoManiac, the perfect competition for those born to impress and express.\r\nHit the register button below and prove that you are worthy.', 'atm', 'TECH', '8967570983', 'https://celesta.org.in/backend/admin/events/posters/ATM6537_Abcd.jpg', 'https://celesta.org.in/backend/admin/events/rulebook/ATM6537_Abcd.pdf', '12/09/2018', '10:00AM', '7:00pm', NULL, NULL, NULL, 'tut block', '', 100, 0, 1),
(11, 'ATM6805', 'Events', 'College Event', 'we', 'The greatest personalities don\'t just speak, they express.\r\nDo you have the qualities to be the changes maker? Can you be the guiding lamp for the future generations to follow? Is your personality bold enough to express?\r\nThen Celesta gives you the ideal platform to showcase your talent and develop your personality. LogoManiac, the perfect competition for those born to impress and express.\r\nHit the register button below and prove that you are worthy.', 'Manish Prasad', 'TECH', '7059469036', 'https://celesta.org.in/backend/admin/events/posters/ATM6805_we.jpg', 'https://celesta.org.in/backend/admin/events/rulebook/ATM6805_we.pdf', '09/11/19, 10/11/19', '5:00pm', '7:00pm', NULL, NULL, NULL, 'IIT Patna', '', 0, 0, 1),
(12, 'ATM8348', 'Events', 'School Event', 'Abcd', 'testing', 'ds', 'TECH', '8967570983', 'https://celesta.org.in/backend/admin/events/posters/ATM8348_Abcd.jpg', 'https://celesta.org.in/backend/admin/events/rulebook/ATM8348_Abcd.pdf', '12/09/2018', '5:00pm', '7:00pm', NULL, NULL, NULL, 'tut block', '', 100.5, 0, 1),
(13, 'ATM3753', 'Events', 'College Event', 'A123', 'werty asdfgh', 'ds', 'TECH', '8967570983', 'https://celesta.org.in/backend/admin/events/posters/ATM3753_A123.jpg', 'https://celesta.org.in/backend/admin/events/rulebook/ATM3753_A123.pdf', '12/09/2018', '5:00pm', '7:00pm', NULL, NULL, NULL, 'tut block', '', 100.5, 0, 1),
(14, 'ATM5571', 'Events', 'College Event', 'Abcd213', 'Testing', 'Manish Prasad', 'TECH', '8967570983', 'https://celesta.org.in/backend/admin/events/posters/ATM5571_Abcd213.jpg', 'https://celesta.org.in/backend/admin/events/rulebook/ATM5571_Abcd213.pdf', '09/11/19, 10/11/19', '5:00pm', '7:00pm', NULL, '1k', NULL, 'tut block', '', 100, 0, 1);

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
  `registration_desk` tinyint(1) NOT NULL DEFAULT '0',
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
  `tshirt_charge` float NOT NULL DEFAULT '0',
  `events_charge` float NOT NULL DEFAULT '0',
  `accommodation_charge` float NOT NULL DEFAULT '0',
  `total_charge` float NOT NULL DEFAULT '0',
  `amount_paid` float NOT NULL DEFAULT '0',
  `checkin_checkout` json DEFAULT NULL,
  `iit_patna` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `validation_code`, `active`, `registration_desk`, `phone`, `college`, `celestaid`, `qrcode`, `added_by`, `ca_referral`, `date`, `events_registered`, `events_participated`, `gender`, `referral_id`, `access_token`, `registration_charge`, `tshirt_charge`, `events_charge`, `accommodation_charge`, `total_charge`, `amount_paid`, `checkin_checkout`, `iit_patna`) VALUES
(112, 'Amartya', 'Mondal', 'technicalskills17@gmail.com', '21b8acfc474802e2e0bd25a85f5e924e', '0', 1, 1, '8967570983', 'IIT Patna', 'CLST1505', 'http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/CLST5847.png', 'admin', NULL, '2019-08-24 13:59:10', '[{\"ev_id\": \"ATM9933\", \"amount\": \"110.5\", \"ev_name\": \"Robowars\", \"cap_name\": \"Amartya Mondal\", \"team_name\": \"atm\"}]', NULL, 'm', 'CLST1504', 'e34b065ada0626aac4d93b355361a865', 0, 0, 2451.5, 0, 0, 2351.5, NULL, 1),
(117, 'Amartya', 'Mondal', 'hayyoulistentome@gmail.com', '21b8acfc474802e2e0bd25a85f5e924e', 'b203900e765c2c25287dd6d8ba3ddced', 1, 1, '8967570983', 'IIT Patna', 'CLST1504', 'http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/CLST4210.png', 'admin', 'CLST1504', '2019-08-27 19:55:21', '[{\"ev_id\": \"ATM9933\", \"amount\": \"110.5\", \"ev_name\": \"Robowars\", \"cap_name\": \"Amartya Mondal\", \"team_name\": \"atm\"}]', NULL, 'f', 'CLST1504', '2adb8f6388c9aedf545b68743a48ea1f', 100, 900, 1346, 0, 0, 2346, NULL, 1),
(118, 'Amartya', 'Mondal', 'me@atm1504.in', '21b8acfc474802e2e0bd25a85f5e924e', 'c0cdfc5b3e8d40f2f9d6836b982785ba', 1, 0, '8967570983', 'IIT Patna', 'CLST9148', 'http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/CLST9148.png', 'admin', 'CLST1504', '2019-08-31 21:30:42', NULL, NULL, 'm', 'CLST1504', '584a0966c8a2bb57e78f3d8164e2a384', 0, 0, 0, 0, 0, 0, NULL, 0),
(119, 'Amartya', 'Mondal', 'she@atm1504.in', '4297f44b13955235245b2497399d7a93', 'c7d0bd062af8e70e7d105788eba471ed', 0, 0, '8967570983', 'IIT Patna', 'CLST6586', 'http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/CLST6586.png', 'admin', 'CLST1504', '2019-08-31 21:32:59', NULL, NULL, 'f', 'CLST1504', '584a0966c8a2bb57e78f3d8164e2a384', 0, 0, 0, 0, 0, 0, NULL, 0),
(120, 'Amartya', 'Mondal', '8967570983@gmail.com', '21b8acfc474802e2e0bd25a85f5e924e', '13bff630177d1e119024ea72339203b6', 1, 0, '8967570983', 'IIT Patna', 'CLST5523', 'http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/CLST5523.png', 'admin', NULL, '2019-09-01 13:17:06', NULL, NULL, 'm', 'CLST1504', '584a0966c8a2bb57e78f3d8164e2a384', 0, 0, 0, 0, 0, 0, NULL, 0),
(123, 'Ar', 'M', 'hayyoulistentome1@gmail.com', '3fc0a7acf087f549ac2b266baf94b8b1', '0', 1, 0, '8967570983', 'IIT Patna', 'CLST5262', 'http://localhost:8888/Celesta2k19-Webpage/assets/qrcodes/CLST5262.png', '', NULL, '2019-09-13 10:06:17', NULL, NULL, 'm', 'CLST1504', '584a0966c8a2bb57e78f3d8164e2a384', 0, 0, 0, 0, 0, 0, NULL, 0),
(124, 'Ar', 'M', 'ewewf@gmail.com', '3fc0a7acf087f549ac2b266baf94b8b1', '0', 1, 0, '8967570983', 'IIT Patna', 'CLST5229', 'http://localhost:8888/Celesta2k19-Webpage/assets/qrcodes/CLST5229.png', '', NULL, '2019-09-13 10:10:28', NULL, NULL, 'm', 'CLST1504', '584a0966c8a2bb57e78f3d8164e2a384', 0, 0, 0, 0, 0, 0, NULL, 0),
(125, 'Arwewe', 'M', 'wqdee@gmail.com', '3fc0a7acf087f549ac2b266baf94b8b1', '0', 1, 0, '8967570983', 'IIT Patna', 'CLST3396', 'http://localhost:8888/Celesta2k19-Webpage/assets/qrcodes/CLST3396.png', '', NULL, '2019-09-13 10:17:55', NULL, NULL, 'm', 'CLST1504', '584a0966c8a2bb57e78f3d8164e2a384', 0, 0, 0, 0, 0, 0, NULL, 0),
(126, 'Ar', 'M', 'eweswf@gmail.com', '3fc0a7acf087f549ac2b266baf94b8b1', '0', 1, 0, '8967570983', 'IIT Patna', 'CLST1001', 'http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/CLST1001.png', '', NULL, '2019-09-13 10:19:45', NULL, NULL, 'm', 'CLST1504', '584a0966c8a2bb57e78f3d8164e2a384', 0, 0, 0, 0, 0, 0, NULL, 0),
(127, 'Arwewe', 'Mqwer', 'technicalskills18@gmail.com', '21b8acfc474802e2e0bd25a85f5e924e', 'dab5d4e07fc8fd116fb04fc94c1288ce', 1, 0, '8967570983', 'IIT Patna', 'CLST5830', 'http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/CLST5830.png', 'admin', 'CLST1504', '2019-09-13 10:24:51', NULL, NULL, 'm', 'CLST1504', '584a0966c8a2bb57e78f3d8164e2a384', 0, 0, 0, 0, 0, 0, NULL, 0),
(128, 'Amartya', 'Mondal', 'hayyoulistentome123@gmail.com', '25d55ad283aa400af464c76d713c07ad', '4892feb0deaf9417cb1feb44a785616d', 0, 0, '8967570983', 'IIT Patna', 'CLST7451', 'https://celesta.org.in/backend/user/assets/qrcodes/CLST7451.png', 'admin', 'CLST1504', '2019-10-02 07:14:06', NULL, NULL, 'm', 'CLST1504', '584a0966c8a2bb57e78f3d8164e2a384', 0, 0, 0, 0, 0, 0, NULL, 0),
(135, 'Amartya', 'Mondal', 'me123@atm1504.in', '3fc0a7acf087f549ac2b266baf94b8b1', '0', 1, 1, '8967570983', 'IIT Patna', 'CLST7331', 'https://celesta.org.in//backend/user/assets/qrcodes/CLST7331.png', '', NULL, '2019-10-10 19:17:11', NULL, NULL, 'm', 'CLST1504', '584a0966c8a2bb57e78f3d8164e2a384', 100, 600, 0, 0, 300, 700, NULL, 0),
(144, 'Amartya', 'Mondal', 'dscappsocietyiitp@gmail.com', '3fc0a7acf087f549ac2b266baf94b8b1', '0', 1, 1, '8967570983', '3eer', 'CLST2057', 'https://celesta.org.in//backend/user/assets/qrcodes/CLST2057.png', 'me@atm1504.in', NULL, '2019-10-20 08:43:21', '[]', NULL, 'm', 'CLST1504', NULL, 100, 0, 0, 500, 0, 600, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accommodation`
--
ALTER TABLE `accommodation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `celestaid` (`celestaid`);

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
-- AUTO_INCREMENT for table `accommodation`
--
ALTER TABLE `accommodation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ca_users`
--
ALTER TABLE `ca_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;