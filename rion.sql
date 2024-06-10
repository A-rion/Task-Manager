-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2024 at 02:59 PM
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
-- Database: `rion`
--

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `application_id` int(11) NOT NULL,
  `date` varchar(20) NOT NULL,
  `close_date` varchar(20) DEFAULT NULL,
  `close_by` varchar(10) DEFAULT NULL,
  `applicant` varchar(10) NOT NULL,
  `lco_type` text NOT NULL,
  `lco_email` varchar(20) NOT NULL,
  `company_name` text NOT NULL,
  `lco_name` text NOT NULL,
  `lco_contact` varchar(10) NOT NULL,
  `lco_address` varchar(50) NOT NULL,
  `lco_area` varchar(20) NOT NULL,
  `lco_pincode` varchar(20) NOT NULL,
  `lco_residence_address` varchar(50) NOT NULL,
  `lco_residence_area` varchar(20) NOT NULL,
  `lco_residence_pincode` varchar(10) NOT NULL,
  `lco_aadhar` varchar(20) NOT NULL,
  `lco_pan` varchar(20) NOT NULL,
  `isp_signal` varchar(30) NOT NULL,
  `customar_num` varchar(20) NOT NULL,
  `multi_feed` text NOT NULL,
  `amount` varchar(10) NOT NULL,
  `nearest_hub` varchar(30) NOT NULL,
  `compliance` text NOT NULL,
  `document` varchar(30) NOT NULL,
  `lco_status` text NOT NULL,
  `flag` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`application_id`, `date`, `close_date`, `close_by`, `applicant`, `lco_type`, `lco_email`, `company_name`, `lco_name`, `lco_contact`, `lco_address`, `lco_area`, `lco_pincode`, `lco_residence_address`, `lco_residence_area`, `lco_residence_pincode`, `lco_aadhar`, `lco_pan`, `isp_signal`, `customar_num`, `multi_feed`, `amount`, `nearest_hub`, `compliance`, `document`, `lco_status`, `flag`) VALUES
(1, '02-Mar-24', '27-Mar-24', 'admin_1', 'e_1', 'new', 'new@gmail.com', 'Multicon', 'Srijan', '9876543219', '64 rahim ostagar road kolkata 45', 'baghajatin', '700012', '15, shyama road, rajarhat, kolkata', 'rajarhat', '700034', '111122221111', '12354312', '1234', '200', 'yes', '500', 'ballygaunge', 'Digital Agreement (On Email)', 'cs_2022.pdf', 'Interested', 0);

-- --------------------------------------------------------

--
-- Table structure for table `assistant`
--

CREATE TABLE `assistant` (
  `assistant_id` int(11) NOT NULL,
  `assign_id` varchar(10) NOT NULL,
  `company_id` int(11) NOT NULL,
  `manager_id` int(11) NOT NULL,
  `assistant_name` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `password` text NOT NULL,
  `assistant_pimage` varchar(50) NOT NULL,
  `assistant_status` int(1) NOT NULL,
  `flag` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `assistant`
--

INSERT INTO `assistant` (`assistant_id`, `assign_id`, `company_id`, `manager_id`, `assistant_name`, `email`, `phone`, `password`, `assistant_pimage`, `assistant_status`, `flag`) VALUES
(1, 'as_1', 1, 1, 'Akash Das', '', '8976543219', '', '', 0, 0),
(2, 'as_2', 1, 1, 'John Doe', 'john@gmail.com', '9087654321', '$2y$10$PiFjo.vS53mstK7kba7wSeaAtItoIjQLqYzACaqnogElFvJg4htFi', 'OIP (2).jpg', 1, 1),
(3, 'as_3', 1, 2, 'Priscilla Sam', 'psam@gmail.com', '8456790121', '$2y$10$JxMF0Ml4rX9C9RmDX.3KmePE22GsiU5lz5lu8qEI8LNuG0Vg.plla', 'OIP (1) (1).jpg', 1, 1),
(4, 'as_4', 1, 1, 'Tuhin Dutta', 'tuhin@gmail.com', '9292929292', '$2y$10$NjN6w9xsPBujtzxB3tuKbe9mE8NPd5GpaCw/unoASta0XD/AKG14a', 'OIP (2).jpg', 1, 1),
(5, 'as_5', 1, 2, 'Prabas Mondol', 'prabas@gmail.com', '8017458729', '$2y$10$z7pJivAeRmzMJZc6uKGvJewP96mTUevh4zzeWxWutHJEjWwxIYn7W', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `a_id` int(11) NOT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `assistant_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `a_time` varchar(20) NOT NULL,
  `time_lat` varchar(150) DEFAULT NULL,
  `time_long` varchar(150) DEFAULT NULL,
  `a_timeout` varchar(20) NOT NULL,
  `timeout_lat` varchar(150) DEFAULT NULL,
  `timeout_long` varchar(150) DEFAULT NULL,
  `a_date` varchar(20) NOT NULL,
  `a_status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`a_id`, `manager_id`, `assistant_id`, `employee_id`, `a_time`, `time_lat`, `time_long`, `a_timeout`, `timeout_lat`, `timeout_long`, `a_date`, `a_status`) VALUES
(1, 1, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '01-Mar-24', 'Absent'),
(2, 2, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '01-Mar-24', 'Absent'),
(4, 1, NULL, NULL, '11:56:00 AM', NULL, NULL, '5:10:00 PM', NULL, NULL, '02-Mar-24', 'Present'),
(5, NULL, 2, NULL, '', NULL, NULL, '', NULL, NULL, '01-Mar-24', 'Absent'),
(6, NULL, 3, NULL, '', NULL, NULL, '', NULL, NULL, '01-Mar-24', 'Absent'),
(7, NULL, 4, NULL, '', NULL, NULL, '', NULL, NULL, '01-Mar-24', 'Absent'),
(8, NULL, 3, NULL, '11:31:01 PM', NULL, NULL, '7:40:04 PM', NULL, NULL, '02-Mar-24', 'Present'),
(31, 1, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '03-Mar-24', 'Absent'),
(32, 2, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '03-Mar-24', 'Absent'),
(34, 1, NULL, NULL, '12:11:33 PM', NULL, NULL, '12:12:18 PM', NULL, NULL, '04-Mar-24', 'Present'),
(35, NULL, NULL, 1, '', NULL, NULL, '', NULL, NULL, '05-Mar-24', 'Absent'),
(36, NULL, NULL, 1, '11:13:30 AM', NULL, NULL, '7:13:41 PM', NULL, NULL, '06-Mar-24', 'Present'),
(37, NULL, 2, NULL, '', NULL, NULL, '', NULL, NULL, '07-Mar-24', 'Absent'),
(38, NULL, 3, NULL, '', NULL, NULL, '', NULL, NULL, '07-Mar-24', 'Absent'),
(39, NULL, 4, NULL, '', NULL, NULL, '', NULL, NULL, '07-Mar-24', 'Absent'),
(40, NULL, 5, NULL, '', NULL, NULL, '', NULL, NULL, '07-Mar-24', 'Absent'),
(44, NULL, 2, NULL, '12:16:37 PM', NULL, NULL, '7:16:39 PM', NULL, NULL, '08-Mar-24', 'Present'),
(45, NULL, 2, NULL, '', NULL, NULL, '', NULL, NULL, '10-Mar-24', 'Leave'),
(46, NULL, 3, NULL, '', NULL, NULL, '', NULL, NULL, '10-Mar-24', 'Absent'),
(47, NULL, 4, NULL, '', NULL, NULL, '', NULL, NULL, '10-Mar-24', 'Absent'),
(48, NULL, 5, NULL, '', NULL, NULL, '', NULL, NULL, '10-Mar-24', 'Absent'),
(52, NULL, 2, NULL, '12:42:28 PM', NULL, NULL, '12:42:35 PM', NULL, NULL, '11-Mar-24', 'Present'),
(53, 1, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '10-Mar-24', 'Absent'),
(54, 2, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '10-Mar-24', 'Absent'),
(56, 1, NULL, NULL, '12:50:24 PM', NULL, NULL, '12:50:28 PM', NULL, NULL, '11-Mar-24', 'Present'),
(57, 1, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '11-Mar-24', 'Absent'),
(58, 2, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '11-Mar-24', 'Absent'),
(60, 1, NULL, NULL, '03:11:58 PM', NULL, NULL, '03:12:01 PM', NULL, NULL, '12-Mar-24', 'Present'),
(61, 1, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '12-Mar-24', 'Absent'),
(62, 2, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '12-Mar-24', 'Absent'),
(64, 1, NULL, NULL, '12:27:09 PM', NULL, NULL, '12:27:25 PM', NULL, NULL, '13-Mar-24', 'Present'),
(65, NULL, 2, NULL, '', NULL, NULL, '', NULL, NULL, '12-Mar-24', 'Absent'),
(66, NULL, 3, NULL, '', NULL, NULL, '', NULL, NULL, '12-Mar-24', 'Absent'),
(67, NULL, 4, NULL, '11:00:00 AM', NULL, NULL, '7:05:00 PM', NULL, NULL, '12-Mar-24', 'Present'),
(68, NULL, 5, NULL, '', NULL, NULL, '', NULL, NULL, '12-Mar-24', 'Absent'),
(72, NULL, 3, NULL, '10:42:51 AM', NULL, NULL, '6:42:53 PM', NULL, NULL, '13-Mar-24', 'Present'),
(73, 1, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '14-Mar-24', 'Absent'),
(74, 2, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '14-Mar-24', 'Absent'),
(76, 1, NULL, NULL, '11:06:10 AM', NULL, NULL, '11:06:20 AM', NULL, NULL, '15-Mar-24', 'Present'),
(77, NULL, 2, NULL, '', NULL, NULL, '', NULL, NULL, '14-Mar-24', 'Absent'),
(78, NULL, 3, NULL, '', NULL, NULL, '', NULL, NULL, '14-Mar-24', 'Absent'),
(79, NULL, 4, NULL, '', NULL, NULL, '', NULL, NULL, '14-Mar-24', 'Absent'),
(80, NULL, 5, NULL, '', NULL, NULL, '', NULL, NULL, '14-Mar-24', 'Absent'),
(84, NULL, 3, NULL, '11:55:17 AM', NULL, NULL, '11:55:24 AM', NULL, NULL, '15-Mar-24', 'Present'),
(85, NULL, 2, NULL, '', NULL, NULL, '', NULL, NULL, '14-Mar-24', 'Absent'),
(86, NULL, 3, NULL, '', NULL, NULL, '', NULL, NULL, '14-Mar-24', 'Absent'),
(87, NULL, 4, NULL, '', NULL, NULL, '', NULL, NULL, '14-Mar-24', 'Absent'),
(88, NULL, 5, NULL, '', NULL, NULL, '', NULL, NULL, '14-Mar-24', 'Absent'),
(92, NULL, 2, NULL, '12:40:48 PM', NULL, NULL, '12:40:55 PM', NULL, NULL, '15-Mar-24', 'Present'),
(93, NULL, 4, NULL, '03:34:35 PM', NULL, NULL, '03:40:32 PM', NULL, NULL, '15-Mar-24', 'Present'),
(94, NULL, 2, NULL, '', NULL, NULL, '', NULL, NULL, '17-Mar-24', 'Absent'),
(95, NULL, 3, NULL, '', NULL, NULL, '', NULL, NULL, '17-Mar-24', 'Absent'),
(96, NULL, 4, NULL, '', NULL, NULL, '', NULL, NULL, '17-Mar-24', 'Absent'),
(97, NULL, 5, NULL, '', NULL, NULL, '', NULL, NULL, '17-Mar-24', 'Absent'),
(101, NULL, 4, NULL, '11:18:05 AM', NULL, NULL, '11:27:29 AM', NULL, NULL, '18-Mar-24', 'Present'),
(102, NULL, 2, NULL, '', NULL, NULL, '', NULL, NULL, '17-Mar-24', 'Absent'),
(103, NULL, 3, NULL, '', NULL, NULL, '', NULL, NULL, '17-Mar-24', 'Absent'),
(104, NULL, 4, NULL, '', NULL, NULL, '', NULL, NULL, '17-Mar-24', 'Absent'),
(105, NULL, 5, NULL, '', NULL, NULL, '', NULL, NULL, '17-Mar-24', 'Absent'),
(109, NULL, 4, NULL, '11:18:23 AM', NULL, NULL, '11:27:29 AM', NULL, NULL, '18-Mar-24', 'Present'),
(110, NULL, 4, NULL, '11:20:06 AM', NULL, NULL, '11:27:29 AM', NULL, NULL, '18-Mar-24', 'Present'),
(111, NULL, 2, NULL, '', NULL, NULL, '', NULL, NULL, '17-Mar-24', 'Absent'),
(112, NULL, 3, NULL, '', NULL, NULL, '', NULL, NULL, '17-Mar-24', 'Absent'),
(113, NULL, 4, NULL, '', NULL, NULL, '', NULL, NULL, '17-Mar-24', 'Absent'),
(114, NULL, 5, NULL, '', NULL, NULL, '', NULL, NULL, '17-Mar-24', 'Absent'),
(118, NULL, 4, NULL, '11:27:27 AM', NULL, NULL, '11:27:29 AM', NULL, NULL, '18-Mar-24', 'Present'),
(119, NULL, 2, NULL, '', NULL, NULL, '', NULL, NULL, '17-Mar-24', 'Absent'),
(120, NULL, 3, NULL, '', NULL, NULL, '', NULL, NULL, '17-Mar-24', 'Absent'),
(121, NULL, 4, NULL, '', NULL, NULL, '', NULL, NULL, '17-Mar-24', 'Absent'),
(122, NULL, 5, NULL, '', NULL, NULL, '', NULL, NULL, '17-Mar-24', 'Absent'),
(126, NULL, 4, NULL, '11:31:49 AM', NULL, NULL, '', NULL, NULL, '18-Mar-24', 'Present'),
(127, 1, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '17-Mar-24', 'Absent'),
(128, 2, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '17-Mar-24', 'Absent'),
(130, 1, NULL, NULL, '11:42:14 AM', NULL, NULL, '11:57:03 AM', NULL, NULL, '18-Mar-24', 'Present'),
(133, NULL, 2, NULL, '12:00:28 PM', NULL, NULL, '12:00:31 PM', NULL, NULL, '18-Mar-24', 'Present'),
(134, 1, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '18-Mar-24', 'Holiday'),
(135, 2, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '18-Mar-24', 'Holiday'),
(136, NULL, 2, NULL, '', NULL, NULL, '', NULL, NULL, '18-Mar-24', 'Holiday'),
(137, NULL, 3, NULL, '', NULL, NULL, '', NULL, NULL, '18-Mar-24', 'Holiday'),
(138, NULL, 4, NULL, '', NULL, NULL, '', NULL, NULL, '18-Mar-24', 'Holiday'),
(139, NULL, 5, NULL, '', NULL, NULL, '', NULL, NULL, '18-Mar-24', 'Holiday'),
(140, NULL, NULL, 1, '', NULL, NULL, '', NULL, NULL, '18-Mar-24', 'Holiday'),
(141, NULL, NULL, 4, '', NULL, NULL, '', NULL, NULL, '18-Mar-24', 'Holiday'),
(149, 1, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '19-Mar-24', 'Holiday'),
(150, 2, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '19-Mar-24', 'Holiday'),
(151, NULL, 2, NULL, '', NULL, NULL, '', NULL, NULL, '19-Mar-24', 'Holiday'),
(152, NULL, 3, NULL, '', NULL, NULL, '', NULL, NULL, '19-Mar-24', 'Holiday'),
(153, NULL, 4, NULL, '', NULL, NULL, '', NULL, NULL, '19-Mar-24', 'Holiday'),
(154, NULL, 5, NULL, '', NULL, NULL, '', NULL, NULL, '19-Mar-24', 'Holiday'),
(155, NULL, NULL, 1, '', NULL, NULL, '', NULL, NULL, '19-Mar-24', 'Holiday'),
(156, NULL, NULL, 4, '', NULL, NULL, '', NULL, NULL, '19-Mar-24', 'Holiday'),
(164, 1, NULL, NULL, '10:41:49 AM', NULL, NULL, '6:41:56 PM', NULL, NULL, '19-Mar-24', 'Present'),
(165, NULL, 2, NULL, '10:59:44 AM', NULL, NULL, '10:59:53 AM', NULL, NULL, '19-Mar-24', 'Present'),
(166, 1, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '25-Mar-24', 'Absent'),
(167, 2, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '25-Mar-24', 'Absent'),
(169, 1, NULL, NULL, '12:28 PM', NULL, NULL, '7:50 PM', NULL, NULL, '26-Mar-24', 'Present'),
(170, NULL, 2, NULL, '', NULL, NULL, '', NULL, NULL, '25-Mar-24', 'Absent'),
(171, NULL, 3, NULL, '', NULL, NULL, '', NULL, NULL, '25-Mar-24', 'Absent'),
(172, NULL, 4, NULL, '', NULL, NULL, '', NULL, NULL, '25-Mar-24', 'Absent'),
(173, NULL, 5, NULL, '', NULL, NULL, '', NULL, NULL, '25-Mar-24', 'Absent'),
(177, NULL, 3, NULL, '12:33:28 PM', NULL, NULL, '12:33:49 PM', NULL, NULL, '26-Mar-24', 'Present'),
(178, 2, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '26-Mar-24', 'Absent'),
(179, 1, NULL, NULL, '11:09 AM', NULL, NULL, '7:30 PM', NULL, NULL, '27-Mar-24', 'Present'),
(180, NULL, 2, NULL, '', NULL, NULL, '', NULL, NULL, '26-Mar-24', 'Absent'),
(181, NULL, 4, NULL, '', NULL, NULL, '', NULL, NULL, '26-Mar-24', 'Absent'),
(182, NULL, 5, NULL, '', NULL, NULL, '', NULL, NULL, '26-Mar-24', 'Absent'),
(183, NULL, 3, NULL, '12:06:01 PM', NULL, NULL, '12:06:05 PM', NULL, NULL, '27-Mar-24', 'Present'),
(184, 1, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '29-Mar-24', 'Absent'),
(185, 2, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '29-Mar-24', 'Absent'),
(187, 1, NULL, NULL, '10:58:41 AM', NULL, NULL, '10:58:45 AM', NULL, NULL, '30-Mar-24', 'Present'),
(188, NULL, 2, NULL, '', NULL, NULL, '', NULL, NULL, '29-Mar-24', 'Absent'),
(189, NULL, 3, NULL, '', NULL, NULL, '', NULL, NULL, '29-Mar-24', 'Absent'),
(190, NULL, 4, NULL, '', NULL, NULL, '', NULL, NULL, '29-Mar-24', 'Absent'),
(191, NULL, 5, NULL, '', NULL, NULL, '', NULL, NULL, '29-Mar-24', 'Absent'),
(195, NULL, 3, NULL, '12:14:23 PM', NULL, NULL, '12:14:25 PM', NULL, NULL, '30-Mar-24', 'Present'),
(196, 1, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '31-Mar-24', 'Absent'),
(197, 2, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '31-Mar-24', 'Absent'),
(199, 1, NULL, NULL, '10:52 AM', NULL, NULL, '7:00 PM', NULL, NULL, '01-Apr-24', 'Present'),
(200, 2, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '01-Apr-24', 'Absent'),
(201, 1, NULL, NULL, '10:58:38 AM', NULL, NULL, '10:58:41 AM', NULL, NULL, '02-Apr-24', 'Present'),
(202, NULL, 2, NULL, '', NULL, NULL, '', NULL, NULL, '01-Apr-24', 'Absent'),
(203, NULL, 3, NULL, '', NULL, NULL, '', NULL, NULL, '01-Apr-24', 'Absent'),
(204, NULL, 4, NULL, '', NULL, NULL, '', NULL, NULL, '01-Apr-24', 'Absent'),
(205, NULL, 5, NULL, '', NULL, NULL, '', NULL, NULL, '01-Apr-24', 'Absent'),
(209, NULL, 3, NULL, '11:47:21 AM', NULL, NULL, '11:47:25 AM', NULL, NULL, '02-Apr-24', 'Present'),
(210, 2, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '02-Apr-24', 'Absent'),
(211, 1, NULL, NULL, '01:09:00 PM', NULL, NULL, '01:09:04 PM', NULL, NULL, '03-Apr-24', 'Present'),
(212, 1, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '07-Apr-24', 'Absent'),
(213, 2, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '07-Apr-24', 'Absent'),
(215, 1, NULL, NULL, '12:10:51 PM', NULL, NULL, '12:10:57 PM', NULL, NULL, '08-Apr-24', 'Present'),
(216, NULL, 2, NULL, '', NULL, NULL, '', NULL, NULL, '07-Apr-24', 'Absent'),
(217, NULL, 3, NULL, '', NULL, NULL, '', NULL, NULL, '07-Apr-24', 'Absent'),
(218, NULL, 4, NULL, '', NULL, NULL, '', NULL, NULL, '07-Apr-24', 'Absent'),
(219, NULL, 5, NULL, '', NULL, NULL, '', NULL, NULL, '07-Apr-24', 'Absent'),
(223, NULL, 3, NULL, '12:19:02 PM', NULL, NULL, '12:19:09 PM', NULL, NULL, '08-Apr-24', 'Present'),
(224, 2, NULL, NULL, '', NULL, NULL, '', NULL, NULL, '08-Apr-24', 'Absent'),
(225, 1, NULL, NULL, '11:46:50 AM', NULL, NULL, '11:47:46 AM', NULL, NULL, '09-Apr-24', 'Present'),
(226, NULL, 2, NULL, '', NULL, NULL, '', NULL, NULL, '08-Apr-24', 'Absent'),
(227, NULL, 4, NULL, '', NULL, NULL, '', NULL, NULL, '08-Apr-24', 'Absent'),
(228, NULL, 5, NULL, '', NULL, NULL, '', NULL, NULL, '08-Apr-24', 'Absent'),
(229, NULL, 3, NULL, '10:51 AM', '22.541031833632193', '88.35450537059452', '6:51 PM', '22.541031833632193', '88.35450537059452', '09-Apr-24', 'Present'),
(230, NULL, 2, NULL, '02:56:59 PM', '22.541045342732705', '88.35448207960067', '02:59:56 PM', '22.541060491030773', '88.35453723070732', '09-Apr-24', 'Present'),
(231, NULL, 4, NULL, '03:03:17 PM', '22.541045494544715', '88.35452582672004', '03:03:25 PM', '22.541045494544715', '88.35452582672004', '09-Apr-24', 'Present'),
(232, NULL, NULL, 1, '', NULL, NULL, '', NULL, NULL, '08-Apr-24', 'Absent'),
(233, NULL, NULL, 4, '', NULL, NULL, '', NULL, NULL, '08-Apr-24', 'Absent'),
(235, NULL, NULL, 4, '03:28:46 PM', '22.541042032001062', '88.35452305379867', '03:29:13 PM', '22.541042032001062', '88.35452305379867', '09-Apr-24', 'Present'),
(236, NULL, NULL, 1, '06:27:26 PM', '22.541033059507757', '88.35445254578696', '06:28:24 PM', '22.541033059507757', '88.35445254578696', '09-Apr-24', 'Present');

-- --------------------------------------------------------

--
-- Table structure for table `bucket`
--

CREATE TABLE `bucket` (
  `b_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `b_fname` text NOT NULL,
  `bucket_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bucket`
--

INSERT INTO `bucket` (`b_id`, `company_id`, `b_fname`, `bucket_name`) VALUES
(1, 1, 'Rion Das', 'LCO'),
(2, 1, 'Rion Das', 'Docket'),
(4, 1, 'Rion Das', 'Broadband');

-- --------------------------------------------------------

--
-- Table structure for table `company_master`
--

CREATE TABLE `company_master` (
  `company_id` int(11) NOT NULL,
  `company_name` text NOT NULL,
  `c_email` varchar(100) NOT NULL,
  `c_phone` varchar(20) NOT NULL,
  `c_website` varchar(100) NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `company_master`
--

INSERT INTO `company_master` (`company_id`, `company_name`, `c_email`, `c_phone`, `c_website`, `admin_id`) VALUES
(1, 'MULTIREACH BROADBAND PVT.LTD.', '', '', '', 1),
(2, 'MULTIREACH MEDIA PVT.LTD.', '', '', '', 1),
(3, 'METROCAST SSY NETWORK PVT.LTD.', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employee_id` int(11) NOT NULL,
  `assign_id` varchar(10) NOT NULL,
  `company_id` int(11) NOT NULL,
  `assistant_id` int(11) NOT NULL,
  `employee_name` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `password` text NOT NULL,
  `employee_pimage` varchar(50) NOT NULL,
  `employee_status` int(1) NOT NULL,
  `flag` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `assign_id`, `company_id`, `assistant_id`, `employee_name`, `email`, `phone`, `password`, `employee_pimage`, `employee_status`, `flag`) VALUES
(1, 'e_1', 1, 2, 'Shreya Das', 'sdas123@hotmail.com', '9213456798', '$2y$10$bhtHa5ITMA2I8aGKYqMbfuVDOiC7s6QPHzEJT8yENXYplhXJ9auQ2', 'OIP (1).jpg', 1, 1),
(2, 'e_2', 1, 3, 'Tuhin Dutta', '', '9292929292', '', '', 0, 0),
(3, 'e_3', 1, 4, 'Prabas Mondol', '', '8017458729', '', '', 0, 0),
(4, 'e_4', 1, 3, 'Amal Saha', 'amal@gmail.com', '9876543212', '$2y$10$u8AIppsV0.bO0o2x6RNIyenNLIHJPUavqLX5Qu111AksW7aofkn9a', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `holiday_list`
--

CREATE TABLE `holiday_list` (
  `holiday_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `holiday_date` varchar(10) NOT NULL,
  `holiday_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `holiday_list`
--

INSERT INTO `holiday_list` (`holiday_id`, `company_id`, `admin_id`, `holiday_date`, `holiday_name`) VALUES
(2, 1, 1, '18-Mar-24', 'Holy'),
(3, 1, 1, '19-Mar-24', 'personal');

-- --------------------------------------------------------

--
-- Table structure for table `issue`
--

CREATE TABLE `issue` (
  `issue_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `docket_num` varchar(20) NOT NULL,
  `reason` text NOT NULL,
  `about` varchar(200) NOT NULL,
  `issue_date` varchar(20) NOT NULL,
  `file` varchar(30) NOT NULL,
  `close_by` varchar(10) DEFAULT NULL,
  `closed_in` varchar(20) DEFAULT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `issue`
--

INSERT INTO `issue` (`issue_id`, `employee_id`, `docket_num`, `reason`, `about`, `issue_date`, `file`, `close_by`, `closed_in`, `status`) VALUES
(1, 1, '123456789', 'Switch Issue', 'ubiuyuvu', '01-Mar-24', 'OIP (1) (1).jpg', 'admin_1', '14-Mar-24', 0),
(2, 1, '1234567890987654', 'Plan Change', 'bfdbdfbfxbf', '02-Mar-24', 'cs_2022.pdf', 'm_1', '14-Mar-24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `company_id` int(11) NOT NULL,
  `manager_id` int(11) NOT NULL,
  `assign_id` varchar(10) NOT NULL,
  `manager_name` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `manager_pimage` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `manager_status` int(1) NOT NULL,
  `flag` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`company_id`, `manager_id`, `assign_id`, `manager_name`, `email`, `phone`, `manager_pimage`, `password`, `manager_status`, `flag`) VALUES
(1, 1, 'm_1', 'Krishnendu Jana', 'krishnendu.jana@multireach.net', '8902281400', '-social media profile picture-3.jpg', '$2y$10$kl4zGcdT0MOntYLMcU1z6e0XxYCqvjR6uhOxtZpK9NySuoJTzduWS', 1, 1),
(1, 2, 'm_2', 'Akash Das', 'akash@hotmail.com', '8976543219', '', '$2y$10$qZBTw.oN5UFPP9Wp9WTh/.W6aN89AonTuDQbkD.S1WWQW3dIs9TpW', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `myleave`
--

CREATE TABLE `myleave` (
  `leave_id` int(11) NOT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `assistant_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `apply_date` varchar(20) NOT NULL,
  `form_date` varchar(20) NOT NULL,
  `to_date` varchar(20) NOT NULL,
  `request_to` varchar(10) NOT NULL,
  `cc` varchar(50) NOT NULL,
  `reason` varchar(200) NOT NULL,
  `l_status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `myleave`
--

INSERT INTO `myleave` (`leave_id`, `manager_id`, `assistant_id`, `employee_id`, `apply_date`, `form_date`, `to_date`, `request_to`, `cc`, `reason`, `l_status`) VALUES
(1, 1, NULL, NULL, '05-Mar-24', '06-Mar-24', '06-Mar-24', 'admin_1', 'm_2', 'sddgdxgrdz', 'Approved'),
(2, NULL, NULL, 1, '06-Mar-24', '25-Mar-24', '25-Mar-24', 'as_2', 'm_1,admin_1', 'hvhvjkuvvuktf', 'Pending'),
(3, NULL, 3, NULL, '14-Mar-24', '15-Mar-24', '16-Mar-24', 'admin_1', 'm_1,m_2', 'Personal Reasons.', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `reg`
--

CREATE TABLE `reg` (
  `admin_id` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `admin_name` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `pimage` varchar(50) NOT NULL,
  `assign_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reg`
--

INSERT INTO `reg` (`admin_id`, `phone`, `admin_name`, `email`, `password`, `pimage`, `assign_id`) VALUES
(1, '8017458729', 'Rion Das', 'rionds123@hotmail.com', '$2y$10$eMmtY3lDg/UQStQhq09CH.uSmltyTVmRNSXLvRJfbA2oW2aablGvS', 'IMG_20231122_122644.jpg', 'admin_1');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `task_id` int(11) NOT NULL,
  `t_bucket` int(11) NOT NULL,
  `assign_by` varchar(20) NOT NULL,
  `assign_to` varchar(20) NOT NULL,
  `assign_date` varchar(20) NOT NULL,
  `due_date` varchar(20) NOT NULL,
  `close_by` varchar(10) DEFAULT NULL,
  `close_date` varchar(10) DEFAULT NULL,
  `t_priority` text NOT NULL,
  `t_file` varchar(30) NOT NULL,
  `t_about` varchar(300) NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `t_bucket`, `assign_by`, `assign_to`, `assign_date`, `due_date`, `close_by`, `close_date`, `t_priority`, `t_file`, `t_about`, `status`) VALUES
(1, 4, 'admin_1', 'admin_1', '02-Mar-24', '06-Mar-24', 'admin_1', '02-Apr-24', 'medium', 'cs_2022.pdf', 'sdfdzgdgdz', 'close'),
(2, 1, 'admin_1', 'm_1', '02-Mar-24', '02-Mar-24', 'admin_1', '05-Mar-24', 'high', 'cs_2022.pdf', 'tyfugvjhbjkh', 'close'),
(3, 2, 'm_1', 'm_1', '02-Mar-24', '04-Mar-24', NULL, NULL, 'medium', 'cs_2022.pdf', 'fvcfbcbgbgb', 'open'),
(4, 4, 'as_2', 'as_2', '08-Mar-24', '09-Mar-24', 'm_1', '11-Mar-24', 'high', 'cs_2022.pdf', 'sgdzgdh', 'close'),
(5, 2, 'admin_1', 'm_1', '15-Mar-24', '23-Mar-24', 'm_1', '02-Apr-24', 'medium', 'Rion_Resume_856.pdf', 'Job interview.', 'close');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`application_id`);

--
-- Indexes for table `assistant`
--
ALTER TABLE `assistant`
  ADD PRIMARY KEY (`assistant_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `bucket`
--
ALTER TABLE `bucket`
  ADD PRIMARY KEY (`b_id`);

--
-- Indexes for table `company_master`
--
ALTER TABLE `company_master`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `holiday_list`
--
ALTER TABLE `holiday_list`
  ADD PRIMARY KEY (`holiday_id`);

--
-- Indexes for table `issue`
--
ALTER TABLE `issue`
  ADD PRIMARY KEY (`issue_id`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`manager_id`);

--
-- Indexes for table `myleave`
--
ALTER TABLE `myleave`
  ADD PRIMARY KEY (`leave_id`);

--
-- Indexes for table `reg`
--
ALTER TABLE `reg`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assistant`
--
ALTER TABLE `assistant`
  MODIFY `assistant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=237;

--
-- AUTO_INCREMENT for table `bucket`
--
ALTER TABLE `bucket`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `company_master`
--
ALTER TABLE `company_master`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `holiday_list`
--
ALTER TABLE `holiday_list`
  MODIFY `holiday_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `issue`
--
ALTER TABLE `issue`
  MODIFY `issue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `manager`
--
ALTER TABLE `manager`
  MODIFY `manager_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `myleave`
--
ALTER TABLE `myleave`
  MODIFY `leave_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reg`
--
ALTER TABLE `reg`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
