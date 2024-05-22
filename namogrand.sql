-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2024 at 08:34 AM
-- Server version: 10.11.7-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u654573886_namogrand`
--

-- --------------------------------------------------------

--
-- Table structure for table `hdfc_final_response`
--

CREATE TABLE `hdfc_final_response` (
  `Id` int(11) NOT NULL,
  `result_indicator` varchar(255) NOT NULL,
  `session_version` varchar(255) NOT NULL,
  `req_bill_to_phone` varchar(255) NOT NULL,
  `response` longtext NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `session_id` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hdfc_txn`
--

CREATE TABLE `hdfc_txn` (
  `id` int(11) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `decision` varchar(255) NOT NULL,
  `signed_date_time` varchar(255) NOT NULL,
  `transaction_type` varchar(255) NOT NULL,
  `reference_number` varchar(255) NOT NULL,
  `auth_trans_ref_no` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `locale` varchar(255) NOT NULL,
  `merchant_descriptor` varchar(255) NOT NULL,
  `bill_to_forename` varchar(255) NOT NULL,
  `bill_to_surname` varchar(255) NOT NULL,
  `bill_to_email` varchar(255) NOT NULL,
  `bill_to_phone` varchar(255) NOT NULL,
  `bill_to_address_line1` varchar(255) NOT NULL,
  `bill_to_address_line2` varchar(255) NOT NULL,
  `bill_to_address_city` varchar(255) NOT NULL,
  `bill_to_address_state` varchar(255) NOT NULL,
  `bill_to_address_country` varchar(255) NOT NULL,
  `bill_to_address_postal_code` varchar(255) NOT NULL,
  `customer_ip_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `orderdetails_id` int(11) NOT NULL,
  `organizationcode` varchar(255) NOT NULL,
  `issuer` varchar(100) NOT NULL,
  `version` varchar(20) NOT NULL,
  `bookingnumber` varchar(12) NOT NULL,
  `bookingdate` date NOT NULL,
  `loccode` varchar(20) NOT NULL,
  `custname` varchar(120) NOT NULL,
  `idprooftype` varchar(250) NOT NULL,
  `idproofno` varchar(200) NOT NULL,
  `contactno` varchar(25) NOT NULL,
  `agentcode` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `visitdate` date NOT NULL,
  `online_amount` double NOT NULL,
  `credituse_amount` double NOT NULL,
  `discount_rate` double NOT NULL,
  `scheduleslabhour` int(11) NOT NULL DEFAULT 1,
  `checksum` varchar(500) NOT NULL,
  `payment_status` text NOT NULL,
  `booking_status` text NOT NULL,
  `payment_txndetails_id` text NOT NULL DEFAULT '0',
  `bank_ref_no` text NOT NULL,
  `is_agent` enum('yes','no') NOT NULL,
  `dumpshanku` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `custlocation` varchar(255) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`orderdetails_id`, `organizationcode`, `issuer`, `version`, `bookingnumber`, `bookingdate`, `loccode`, `custname`, `idprooftype`, `idproofno`, `contactno`, `agentcode`, `email`, `visitdate`, `online_amount`, `credituse_amount`, `discount_rate`, `scheduleslabhour`, `checksum`, `payment_status`, `booking_status`, `payment_txndetails_id`, `bank_ref_no`, `is_agent`, `dumpshanku`, `created_on`, `updated_on`, `custlocation`, `barcode`) VALUES
(1, 'KALPATARU', 'KALPATARU', '1.0', '2000000', '2024-04-06', 'NGCP', 'Pradyumna Kusht', '', '', '7506260570', 'NGCP_WEB', 'pradyumna.kushte@kalpataru.com', '2024-04-07', 210, 0, 0, 1, '1988931e884adbbcbaef5295ebef993c', 'Success', 'Success', '313011270131', 'bs4bf8296ffd76', 'no', '', '2024-04-06 06:45:15', '2024-04-06 06:45:39', 'thane', '1039666,1039667,1039668,1039669,1039670'),
(2, 'KALPATARU', 'KALPATARU', '1.0', '2000001', '2024-04-06', 'NGCP', 'Pradyumna Kushte', '', '', '7506260570', 'NGCP_WEB', 'pradyumna.kushte@gmail.com', '2024-04-16', 100, 0, 0, 1, '7d851bd32bb697d4394f6dbfd840461e', 'Success', 'Success', '313011270143', 'bs9c88b7af1916', 'no', '', '2024-04-06 06:49:08', '2024-04-06 06:49:28', 'thane', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_ticket_details`
--

CREATE TABLE `order_ticket_details` (
  `order_ticket_details_id` int(11) NOT NULL,
  `orderdeatils_id` int(11) NOT NULL,
  `pricecardcode` varchar(20) NOT NULL,
  `nooftickets` int(11) NOT NULL,
  `rate` double NOT NULL,
  `amount` double NOT NULL,
  `discount_amount` double NOT NULL,
  `description` varchar(2000) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_ticket_details`
--

INSERT INTO `order_ticket_details` (`order_ticket_details_id`, `orderdeatils_id`, `pricecardcode`, `nooftickets`, `rate`, `amount`, `discount_amount`, `description`, `created_on`, `updated_on`) VALUES
(1, 1, 'AWM', 1, 30, 30, 0, '', '2024-04-06 06:45:15', '2024-04-06 06:45:15'),
(2, 1, 'KU', 1, 0, 0, 0, '', '2024-04-06 06:45:15', '2024-04-06 06:45:15'),
(3, 1, 'KC', 1, 20, 20, 0, '', '2024-04-06 06:45:15', '2024-04-06 06:45:15'),
(4, 1, 'SC', 1, 10, 10, 0, '', '2024-04-06 06:45:15', '2024-04-06 06:45:15'),
(5, 1, 'DSLR', 1, 150, 150, 0, '', '2024-04-06 06:45:15', '2024-04-06 06:45:15'),
(6, 2, 'AT', 5, 20, 100, 0, '', '2024-04-06 06:49:08', '2024-04-06 06:49:08');

-- --------------------------------------------------------

--
-- Table structure for table `otp`
--

CREATE TABLE `otp` (
  `otp_id` int(11) NOT NULL,
  `admin_email` varchar(500) NOT NULL,
  `otp_type` enum('create','forgot','verify') NOT NULL,
  `otp_code` varchar(20) NOT NULL,
  `otp_starttime` datetime NOT NULL,
  `otp_endtime` datetime NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `is_delete` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `session_info`
--

CREATE TABLE `session_info` (
  `Id` int(11) NOT NULL,
  `session_data` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `session_info`
--

INSERT INTO `session_info` (`Id`, `session_data`) VALUES
(1, '{\"cdate\":\"07.04.2024\",\"cdate1\":\"2024-04-07\",\"cpricecard\":[{\"NAME\":\"Adult Ticket_Weekend(MT)\",\"CODE\":\"AWM\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":30,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"ADULT\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Morning Tickets\",\"SUBCLASS_REMARK\":\"6:00 am To 11:00 am\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Kids Upto 15 Years(MT)\",\"CODE\":\"KU\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":0,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"CHILD\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Morning Tickets\",\"SUBCLASS_REMARK\":\"6:00 am To 11:00 am\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Kids With Cycle Upto 12 Years(MT)\",\"CODE\":\"KC\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":20,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"CHILD\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Morning Tickets\",\"SUBCLASS_REMARK\":\"6:00 am To 11:00 am\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Sr.Citizen(MT)\",\"CODE\":\"SC\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":10,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"ADULT\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Morning Tickets\",\"SUBCLASS_REMARK\":\"6:00 am To 11:00 am\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Adult Ticket _Weekend(ET)\",\"CODE\":\"AWE\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":30,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"ADULT\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Evening Tickets\",\"SUBCLASS_REMARK\":\"1:00 pm To 9:00 pm\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Kids Upto 15 Years(ET)\",\"CODE\":\"KUE\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":0,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"CHILD\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Evening Tickets\",\"SUBCLASS_REMARK\":\"1:00 pm To 9:00 pm\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Kids With Cycle Upto 12 Years(ET)\",\"CODE\":\"KCE\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":20,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"CHILD\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Evening Tickets\",\"SUBCLASS_REMARK\":\"1:00 pm To 9:00 pm\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Sr.Citizen(ET)\",\"CODE\":\"SCE\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":10,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"ADULT\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Evening Tickets\",\"SUBCLASS_REMARK\":\"1:00 pm To 9:00 pm\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"DSLR CAMERA\",\"CODE\":\"DSLR\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":150,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"PASS\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"CAMERA\",\"SUBCLASS_REMARK\":\"\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0}],\"ccart\":[{\"name\":\"Adult Ticket_Weekend(MT)\",\"code\":\"AWM\",\"description\":\"\",\"ticketamount\":\"30\",\"quantity\":\"1\",\"totalamount\":30,\"cgstrate\":\"0\",\"cgstamount\":\"0\",\"sgstrate\":\"0\",\"sgstamout\":\"0\",\"category\":\"Entry Ticket\",\"class\":\"PARK\",\"subclass\":\"Morning Tickets\",\"ispriorityticket\":\"0\",\"isprioritypass\":\"0\",\"date\":\"07.04.2024\",\"tickettype\":\"ADULT\",\"morning_evening\":\"Morning Tickets\",\"collapse\":\"1\",\"loccode\":\"MNS\"},{\"name\":\"Kids Upto 15 Years(MT)\",\"code\":\"KU\",\"description\":\"\",\"ticketamount\":\"0\",\"quantity\":\"1\",\"totalamount\":0,\"cgstrate\":\"0\",\"cgstamount\":\"0\",\"sgstrate\":\"0\",\"sgstamout\":\"0\",\"category\":\"Entry Ticket\",\"class\":\"PARK\",\"subclass\":\"Morning Tickets\",\"ispriorityticket\":\"0\",\"isprioritypass\":\"0\",\"tickettype\":\"CHILD\",\"morning_evening\":\"Morning Tickets\",\"date\":\"07.04.2024\",\"loccode\":\"MNS\"},{\"name\":\"Kids With Cycle Upto 12 Years(MT)\",\"code\":\"KC\",\"description\":\"\",\"ticketamount\":\"20\",\"quantity\":\"1\",\"totalamount\":20,\"cgstrate\":\"0\",\"cgstamount\":\"0\",\"sgstrate\":\"0\",\"sgstamout\":\"0\",\"category\":\"Entry Ticket\",\"class\":\"PARK\",\"subclass\":\"Morning Tickets\",\"ispriorityticket\":\"0\",\"isprioritypass\":\"0\",\"tickettype\":\"CHILD\",\"morning_evening\":\"Morning Tickets\",\"date\":\"07.04.2024\",\"loccode\":\"MNS\"},{\"name\":\"Sr.Citizen(MT)\",\"code\":\"SC\",\"description\":\"\",\"ticketamount\":\"10\",\"quantity\":\"1\",\"totalamount\":10,\"cgstrate\":\"0\",\"cgstamount\":\"0\",\"sgstrate\":\"0\",\"sgstamout\":\"0\",\"category\":\"Entry Ticket\",\"class\":\"PARK\",\"subclass\":\"Morning Tickets\",\"ispriorityticket\":\"0\",\"isprioritypass\":\"0\",\"tickettype\":\"ADULT\",\"morning_evening\":\"Morning Tickets\",\"date\":\"07.04.2024\",\"loccode\":\"MNS\"},{\"name\":\"DSLR CAMERA\",\"code\":\"DSLR\",\"description\":\"\",\"ticketamount\":\"150\",\"quantity\":\"1\",\"totalamount\":150,\"cgstrate\":\"0\",\"cgstamount\":\"0\",\"sgstrate\":\"0\",\"sgstamout\":\"0\",\"category\":\"Entry Ticket\",\"class\":\"PARK\",\"subclass\":\"CAMERA\",\"ispriorityticket\":\"0\",\"isprioritypass\":\"0\",\"tickettype\":\"PASS\",\"morning_evening\":\"CAMERA\",\"date\":\"07.04.2024\",\"loccode\":\"MNS\"}],\"ccartamount\":210,\"collapse\":\"3\",\"cuser\":{\"full_name\":\"Pradyumna Kusht\",\"email_id\":\"pradyumna.kushte@kalpataru.com\",\"mobile_no\":\"7506260570\",\"countrycode\":null,\"area_location\":\"thane\"}}'),
(2, '{\"cdate\":\"07.04.2024\",\"cdate1\":\"2024-04-07\",\"cpricecard\":[{\"NAME\":\"Adult Ticket_Weekend(MT)\",\"CODE\":\"AWM\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":30,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"ADULT\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Morning Tickets\",\"SUBCLASS_REMARK\":\"6:00 am To 11:00 am\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Kids Upto 15 Years(MT)\",\"CODE\":\"KU\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":0,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"CHILD\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Morning Tickets\",\"SUBCLASS_REMARK\":\"6:00 am To 11:00 am\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Kids With Cycle Upto 12 Years(MT)\",\"CODE\":\"KC\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":20,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"CHILD\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Morning Tickets\",\"SUBCLASS_REMARK\":\"6:00 am To 11:00 am\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Sr.Citizen(MT)\",\"CODE\":\"SC\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":10,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"ADULT\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Morning Tickets\",\"SUBCLASS_REMARK\":\"6:00 am To 11:00 am\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Adult Ticket _Weekend(ET)\",\"CODE\":\"AWE\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":30,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"ADULT\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Evening Tickets\",\"SUBCLASS_REMARK\":\"1:00 pm To 9:00 pm\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Kids Upto 15 Years(ET)\",\"CODE\":\"KUE\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":0,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"CHILD\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Evening Tickets\",\"SUBCLASS_REMARK\":\"1:00 pm To 9:00 pm\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Kids With Cycle Upto 12 Years(ET)\",\"CODE\":\"KCE\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":20,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"CHILD\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Evening Tickets\",\"SUBCLASS_REMARK\":\"1:00 pm To 9:00 pm\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Sr.Citizen(ET)\",\"CODE\":\"SCE\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":10,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"ADULT\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Evening Tickets\",\"SUBCLASS_REMARK\":\"1:00 pm To 9:00 pm\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"DSLR CAMERA\",\"CODE\":\"DSLR\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":150,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"PASS\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"CAMERA\",\"SUBCLASS_REMARK\":\"\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0}],\"ccart\":[{\"name\":\"Adult Ticket_Weekend(MT)\",\"code\":\"AWM\",\"description\":\"\",\"ticketamount\":\"30\",\"quantity\":\"1\",\"totalamount\":30,\"cgstrate\":\"0\",\"cgstamount\":\"0\",\"sgstrate\":\"0\",\"sgstamout\":\"0\",\"category\":\"Entry Ticket\",\"class\":\"PARK\",\"subclass\":\"Morning Tickets\",\"ispriorityticket\":\"0\",\"isprioritypass\":\"0\",\"date\":\"07.04.2024\",\"tickettype\":\"ADULT\",\"morning_evening\":\"Morning Tickets\",\"collapse\":\"1\",\"loccode\":\"MNS\"},{\"name\":\"Kids Upto 15 Years(MT)\",\"code\":\"KU\",\"description\":\"\",\"ticketamount\":\"0\",\"quantity\":\"1\",\"totalamount\":0,\"cgstrate\":\"0\",\"cgstamount\":\"0\",\"sgstrate\":\"0\",\"sgstamout\":\"0\",\"category\":\"Entry Ticket\",\"class\":\"PARK\",\"subclass\":\"Morning Tickets\",\"ispriorityticket\":\"0\",\"isprioritypass\":\"0\",\"tickettype\":\"CHILD\",\"morning_evening\":\"Morning Tickets\",\"date\":\"07.04.2024\",\"loccode\":\"MNS\"},{\"name\":\"Kids With Cycle Upto 12 Years(MT)\",\"code\":\"KC\",\"description\":\"\",\"ticketamount\":\"20\",\"quantity\":\"1\",\"totalamount\":20,\"cgstrate\":\"0\",\"cgstamount\":\"0\",\"sgstrate\":\"0\",\"sgstamout\":\"0\",\"category\":\"Entry Ticket\",\"class\":\"PARK\",\"subclass\":\"Morning Tickets\",\"ispriorityticket\":\"0\",\"isprioritypass\":\"0\",\"tickettype\":\"CHILD\",\"morning_evening\":\"Morning Tickets\",\"date\":\"07.04.2024\",\"loccode\":\"MNS\"},{\"name\":\"Sr.Citizen(MT)\",\"code\":\"SC\",\"description\":\"\",\"ticketamount\":\"10\",\"quantity\":\"1\",\"totalamount\":10,\"cgstrate\":\"0\",\"cgstamount\":\"0\",\"sgstrate\":\"0\",\"sgstamout\":\"0\",\"category\":\"Entry Ticket\",\"class\":\"PARK\",\"subclass\":\"Morning Tickets\",\"ispriorityticket\":\"0\",\"isprioritypass\":\"0\",\"tickettype\":\"ADULT\",\"morning_evening\":\"Morning Tickets\",\"date\":\"07.04.2024\",\"loccode\":\"MNS\"},{\"name\":\"DSLR CAMERA\",\"code\":\"DSLR\",\"description\":\"\",\"ticketamount\":\"150\",\"quantity\":\"1\",\"totalamount\":150,\"cgstrate\":\"0\",\"cgstamount\":\"0\",\"sgstrate\":\"0\",\"sgstamout\":\"0\",\"category\":\"Entry Ticket\",\"class\":\"PARK\",\"subclass\":\"CAMERA\",\"ispriorityticket\":\"0\",\"isprioritypass\":\"0\",\"tickettype\":\"PASS\",\"morning_evening\":\"CAMERA\",\"date\":\"07.04.2024\",\"loccode\":\"MNS\"}],\"ccartamount\":210,\"collapse\":\"3\",\"cuser\":{\"full_name\":\"Pradyumna Kusht\",\"email_id\":\"pradyumna.kushte@kalpataru.com\",\"mobile_no\":\"7506260570\",\"countrycode\":null,\"area_location\":\"thane\"}}'),
(3, '{\"cdate\":\"16.04.2024\",\"cdate1\":\"2024-04-07\",\"cpricecard\":[{\"NAME\":\"Adult_Weekday(MT)\",\"CODE\":\"AT\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":20,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"ADULT\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Morning Tickets\",\"SUBCLASS_REMARK\":\"6:00 am To 11:00 am\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Kids Upto 15 Years(MT)\",\"CODE\":\"KU\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":0,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"CHILD\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Morning Tickets\",\"SUBCLASS_REMARK\":\"6:00 am To 11:00 am\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Kids With Cycle Upto 12 Years(MT)\",\"CODE\":\"KC\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":20,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"CHILD\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Morning Tickets\",\"SUBCLASS_REMARK\":\"6:00 am To 11:00 am\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Sr.Citizen(MT)\",\"CODE\":\"SC\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":10,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"ADULT\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Morning Tickets\",\"SUBCLASS_REMARK\":\"6:00 am To 11:00 am\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Adult Ticket_Weekday(ET)\",\"CODE\":\"ATE\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":20,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"ADULT\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Evening Tickets\",\"SUBCLASS_REMARK\":\"1:00 pm To 9:00 pm\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Kids Upto 15 Years(ET)\",\"CODE\":\"KUE\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":0,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"CHILD\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Evening Tickets\",\"SUBCLASS_REMARK\":\"1:00 pm To 9:00 pm\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Kids With Cycle Upto 12 Years(ET)\",\"CODE\":\"KCE\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":20,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"CHILD\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Evening Tickets\",\"SUBCLASS_REMARK\":\"1:00 pm To 9:00 pm\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Sr.Citizen(ET)\",\"CODE\":\"SCE\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":10,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"ADULT\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Evening Tickets\",\"SUBCLASS_REMARK\":\"1:00 pm To 9:00 pm\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"DSLR CAMERA\",\"CODE\":\"DSLR\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":150,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"PASS\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"CAMERA\",\"SUBCLASS_REMARK\":\"\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0}],\"ccart\":[{\"name\":\"Adult_Weekday(MT)\",\"code\":\"AT\",\"description\":\"\",\"ticketamount\":\"20\",\"quantity\":\"5\",\"totalamount\":100,\"cgstrate\":\"0\",\"cgstamount\":\"0\",\"sgstrate\":\"0\",\"sgstamout\":\"0\",\"category\":\"Entry Ticket\",\"class\":\"PARK\",\"subclass\":\"Morning Tickets\",\"ispriorityticket\":\"0\",\"isprioritypass\":\"0\",\"date\":\"16.04.2024\",\"tickettype\":\"ADULT\",\"morning_evening\":\"Morning Tickets\",\"collapse\":\"1\",\"loccode\":\"MNS\"}],\"ccartamount\":\"100\",\"collapse\":\"1\",\"cuser\":{\"full_name\":\"Pradyumna Kushte\",\"email_id\":\"pradyumna.kushte@gmail.com\",\"mobile_no\":\"7506260570\",\"countrycode\":null,\"area_location\":\"thane\"}}'),
(4, '{\"cdate\":\"16.04.2024\",\"cdate1\":\"2024-04-07\",\"cpricecard\":[{\"NAME\":\"Adult_Weekday(MT)\",\"CODE\":\"AT\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":20,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"ADULT\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Morning Tickets\",\"SUBCLASS_REMARK\":\"6:00 am To 11:00 am\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Kids Upto 15 Years(MT)\",\"CODE\":\"KU\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":0,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"CHILD\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Morning Tickets\",\"SUBCLASS_REMARK\":\"6:00 am To 11:00 am\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Kids With Cycle Upto 12 Years(MT)\",\"CODE\":\"KC\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":20,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"CHILD\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Morning Tickets\",\"SUBCLASS_REMARK\":\"6:00 am To 11:00 am\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Sr.Citizen(MT)\",\"CODE\":\"SC\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":10,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"ADULT\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Morning Tickets\",\"SUBCLASS_REMARK\":\"6:00 am To 11:00 am\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Adult Ticket_Weekday(ET)\",\"CODE\":\"ATE\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":20,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"ADULT\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Evening Tickets\",\"SUBCLASS_REMARK\":\"1:00 pm To 9:00 pm\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Kids Upto 15 Years(ET)\",\"CODE\":\"KUE\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":0,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"CHILD\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Evening Tickets\",\"SUBCLASS_REMARK\":\"1:00 pm To 9:00 pm\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Kids With Cycle Upto 12 Years(ET)\",\"CODE\":\"KCE\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":20,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"CHILD\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Evening Tickets\",\"SUBCLASS_REMARK\":\"1:00 pm To 9:00 pm\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"Sr.Citizen(ET)\",\"CODE\":\"SCE\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":10,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"ADULT\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"Evening Tickets\",\"SUBCLASS_REMARK\":\"1:00 pm To 9:00 pm\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0},{\"NAME\":\"DSLR CAMERA\",\"CODE\":\"DSLR\",\"DESCRIPTION\":\"\",\"TICKETAMOUNT\":150,\"CGST_RATE\":0,\"SGST_RATE\":0,\"TICKETTYPE\":\"PASS\",\"CATEGORY\":\"Entry Ticket\",\"CLASS\":\"PARK\",\"SUBCLASS\":\"CAMERA\",\"SUBCLASS_REMARK\":\"\",\"ISPRIORITYTICKET\":0,\"ISPRIORITYPASS\":0}],\"ccart\":[{\"name\":\"Adult_Weekday(MT)\",\"code\":\"AT\",\"description\":\"\",\"ticketamount\":\"20\",\"quantity\":\"5\",\"totalamount\":100,\"cgstrate\":\"0\",\"cgstamount\":\"0\",\"sgstrate\":\"0\",\"sgstamout\":\"0\",\"category\":\"Entry Ticket\",\"class\":\"PARK\",\"subclass\":\"Morning Tickets\",\"ispriorityticket\":\"0\",\"isprioritypass\":\"0\",\"date\":\"16.04.2024\",\"tickettype\":\"ADULT\",\"morning_evening\":\"Morning Tickets\",\"collapse\":\"1\",\"loccode\":\"MNS\"}],\"ccartamount\":\"100\",\"collapse\":\"1\",\"cuser\":{\"full_name\":\"Pradyumna Kushte\",\"email_id\":\"pradyumna.kushte@gmail.com\",\"mobile_no\":\"7506260570\",\"countrycode\":null,\"area_location\":\"thane\"}}');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hdfc_final_response`
--
ALTER TABLE `hdfc_final_response`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `hdfc_txn`
--
ALTER TABLE `hdfc_txn`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`orderdetails_id`);

--
-- Indexes for table `order_ticket_details`
--
ALTER TABLE `order_ticket_details`
  ADD PRIMARY KEY (`order_ticket_details_id`);

--
-- Indexes for table `otp`
--
ALTER TABLE `otp`
  ADD PRIMARY KEY (`otp_id`);

--
-- Indexes for table `session_info`
--
ALTER TABLE `session_info`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hdfc_final_response`
--
ALTER TABLE `hdfc_final_response`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hdfc_txn`
--
ALTER TABLE `hdfc_txn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `orderdetails_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_ticket_details`
--
ALTER TABLE `order_ticket_details`
  MODIFY `order_ticket_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `otp`
--
ALTER TABLE `otp`
  MODIFY `otp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `session_info`
--
ALTER TABLE `session_info`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
