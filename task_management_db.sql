-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 28, 2024 at 05:12 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `task_management_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `reset_token` varchar(255) NOT NULL,
  `reset_expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_password_resets`
--

INSERT INTO `admin_password_resets` (`id`, `email`, `reset_token`, `reset_expires`) VALUES
(1, 'g.support@patmactech.co.uk', 'f10c7b67b7c8a0495edebe0aca837556c2b9a04e1e0e734956c12c9e492e594c68e425ef3d566d8450d8dbd42b6845a50054', '2024-12-23 07:49:17'),
(3, 'sundeffellefrancis@gmail.com', '6953b9e340ef07686decf95a042988c73064e643f0f6e7ea38dce3acc460dc1ed5b5ac74d33076923047090daa92662f030a', '2024-12-23 08:21:00'),
(4, 'sundeffellefrancis@gmail.com', '24bef2add16a343ad6b3c25f9c7fcf208267e7f6863985e1557c31463ec505733641a6f7c21bed1ccae1990c1f9fb15e5a99', '2024-12-23 08:24:00'),
(5, 'sundeffellefrancis@gmail.com', 'f3d737c29d83e99f1b63705bdb0e3a761ff9e71509944dc815d8774e0a59ba27ab93944fc3843ca99151ba9cd926c1edb5dc', '2024-12-23 08:59:26'),
(6, 'sundeffellefrancis@gmail.com', '517c10a4926f6d2966561123a57fb92b734057615d714f45be1409625396e83bf9b9498385d3a3b8df505115ab247077b335', '2024-12-23 09:32:34'),
(7, 'sundeffellefrancis@gmail.com', '88ddb25ea772944159fd4e7ab53cba5500286ea66d1bd1f4a80ca6fbfa45923e855a3717d3210c8a40eff6b63081366825f0', '2024-12-23 09:32:51'),
(8, 'sundeffellefrancis@gmail.com', 'e57462dfa61b48846ce501c0948becfd75b5c68de983670aa26d1ab7483e5083e0913b0cb6089d0d8b6a2f5e46b6e6de647d', '2024-12-23 09:36:38'),
(9, 'sundeffellefrancis@gmail.com', 'c3ab3692d904732840549050e1c8d40167519a03fadf2c3eb631750876e30d3e788b4cc017b58beba50beecdda87e160011e', '2024-12-23 09:39:10'),
(10, 'sundeffellefrancis@gmail.com', '7b57942de3ee12ab3d3e241247e091bbdd0b638ed937f63915bd1982ff612569b61f6a8428920168d335f07d3bb20ad7148e', '2024-12-23 09:40:12'),
(11, 'sundeffellefrancis@gmail.com', '047b4d27752c4466b6bdccc7576a94bbb5a2bfecb1951a8760929ec5bca64afbcf80fdf3d1b3c7350613f11d39c6061d5d2f', '2024-12-23 09:40:25');

-- --------------------------------------------------------

--
-- Table structure for table `allowances`
--

CREATE TABLE `allowances` (
  `allowance_id` int(11) NOT NULL,
  `payroll_id` int(11) NOT NULL,
  `allowance_type` varchar(50) NOT NULL,
  `allowance_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `allowances`
--

INSERT INTO `allowances` (`allowance_id`, `payroll_id`, `allowance_type`, `allowance_amount`) VALUES
(1, 13, '56', 45.00),
(2, 1, '560', 28.00),
(3, 1, 'Tax', 56.00),
(4, 1, 'Tax', 34.00),
(5, 3, 'Fuel allowance', 300.00),
(6, 6, 'Tax', 78.00),
(7, 3, 'Tax', 560.00);

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `company_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `industry` varchar(100) NOT NULL,
  `company_size` varchar(50) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `registration_date` datetime DEFAULT current_timestamp(),
  `role` enum('admin','company') DEFAULT 'company'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`company_id`, `company_name`, `company_email`, `password`, `industry`, `company_size`, `contact_email`, `contact_phone`, `address`, `registration_date`, `role`) VALUES
(1, 'Franphis Tech', 'francis.tettey000@gmail.com', '', 'Tech', 'Large', 'admin@mail.com', '0987655323', 'En-165-1402', '2024-11-30 02:07:38', 'company'),
(3, 'GhaTech', 'techmail@gmail.com', '', 'Tech', 'Large', 'sundeffelle@gmail.com', '0987655323', 'En-165-1402', '2024-12-01 19:18:23', 'company'),
(4, 'Franphis Tech', 'f.tettey@patmactech.co.uk', '$2y$10$RREeZc32dfJhsWzJcvBdO.lYJmdoHTEs.v5kd6MUu2Xj9wWVn7MRO', 'Health', 'Medium', 'sundeffellet@gamil.com', '0203148689', 'En-165-1402', '2024-12-01 20:02:59', 'company'),
(5, 'GhaTech', 's.support@patmactech.co.uk', '$2y$10$c3De4TlfVFABHMkBQuiv3O553ri1YudTZVbOtTionTcYBW6yj5tHG', 'Health', 'Medium', 'lord@gmail.com', '0987655323', 'En-165-1402\r\n', '2024-12-03 15:40:26', 'company'),
(6, 'SolutionTech', 's.tech123@gmail.com', '$2y$10$18U3gJh6M5VtzgkYZbJBQ.gh5skbo3NmuwwI9Y4ZSW2OaioQ9vutm', 'Premier', 'Small', 'solution@gmail.com', '0987655323', 'En-165-1402\r\nEn-017-1807', '2024-12-05 07:10:06', 'company'),
(7, 'SolutionTech', 'customsupport@patmactech.co.uk', '$2y$10$yWnASX0qdUKFVn.G107r3ebAf/HT9WjSfjuYlZPkbWeXbVKATLxtO', 'Premier', 'Medium', 'customsupport@patmactech.co.uk', '0987655323', 'Homw', '2024-12-18 04:08:44', 'company'),
(8, 'PatMacTec', 'g.support@patmactech.co.uk', '$2y$10$IrP0xFp56cCQWn4iiPX4TukbGeZSVJXWXl3OC1Nox7AHniujbAXQu', 'Technology', 'Large', 'customsupport@patmactech.co.uk', '0203148689', '\r\nEn-017-1807', '2024-12-21 01:26:41', 'company'),
(9, 'Nice  Boy', 'nice.boy@777.com', '$2y$10$ZO2wZVI5oJs6bTEe5yjD7urgk1vuHw4acQVEmXDIDfN4hT/a1K1Mu', 'Tech', 'Large', 'sundeffellet@gamil.com', '0987655323', 'En-165-1402', '2024-12-28 04:04:08', 'company');

-- --------------------------------------------------------

--
-- Table structure for table `company_password_resets`
--

CREATE TABLE `company_password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `reset_token` varchar(255) NOT NULL,
  `reset_expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company_password_resets`
--

INSERT INTO `company_password_resets` (`id`, `email`, `reset_token`, `reset_expires`) VALUES
(1, 'g.support@patmactech.co.uk', '40fd1e04ee141d5d7cd403fe6007eeda912144f372ce019fdd1246de29934224331e60ed5f26ea547514e29923fd433ac645', '2024-12-24 19:16:31'),
(2, 'f.tettey@patmactech.co.uk', '3ab5c33d24c68e57637b8e3b9882516b8a8df52d4814c8278a6dfdb7210d07386a710066025efab7e288fa6d1ea2811e0d3f', '2024-12-24 19:17:16'),
(3, 'francis.tettey000@gmail.com', '8498fb6fb128bccaba9f8eb65c6f32f2e4ff90f6a30a19f4debacd54d28feaab27fe8b5319b92c4aa10cf5b934b40c1a8190', '2024-12-24 19:17:58'),
(4, 'f.tettey@patmactech.co.uk', 'fea29d4f3c1bb785b5cf7401257085ec742a3e09e3f9b5ef16043ad4f79ef9fe6382f09602acde0e4b6cffaac611101f7844', '2024-12-24 19:18:04'),
(6, 'g.support@patmactech.co.uk', 'd82d37292879476f072f3d0895363a158bc62ec9849a8af5a7d9ae8e94f7ca75f3fdc67f6a03e51e8ba702e3feb81f1e59b3', '2024-12-24 19:44:05'),
(7, 'g.support@patmactech.co.uk', '6528f2e5dd2584ee5953e88d9035aaf45b0726a3f9fbff496d6445fd8212862cc22670f7dbb239a79dacad26d4381ead2c01', '2024-12-24 20:10:28'),
(8, 'g.support@patmactech.co.uk', '1d6027f8cc78f1e39a10a0f2b4135537d1cc2a56106e1218ec85bfc1597bb5b4f282de3e6b774de33ef1c50d1219ee88133d', '2024-12-24 20:10:37'),
(9, 'g.support@patmactech.co.uk', '031446d43b9c92ae8a0f87bab776dc79c65404198bc554d778dcf50a7e9a0545975434bed21096eea82a0833b4e87290500b', '2024-12-24 20:10:56'),
(10, 'g.support@patmactech.co.uk', '1ad733220101949583136ba322e6c81d517da7723cb747ce1bc877835f70b4d3abad0dd0f36ce201d054322b50aaba811196', '2024-12-24 20:14:13'),
(13, 'f.tettey@patmactech.co.uk', 'd74d9ec03f96744ca5c93f7e8a7bcf80832717fd9b575b02480b61c0eebbaa9fbf43e6c0766012fb036b10ea6428b974b53d', '2024-12-24 20:19:47'),
(15, 'f.tettey@patmactech.co.uk', '77042da50070e01917b87c1445f86136ad7edb87544302d0f4df8b98079eaffee3883c3f77eb1bd5435a8edeaa4506bb98ba', '2024-12-27 09:39:54'),
(16, 'g.support@patmactech.co.uk', '775454ae1d7a2416afe149cc3bb709d499dbe17f7a02615c92426f2126a045e84e74312f46346dd740d34c77f393ace2b1a7', '2024-12-28 05:59:18');

-- --------------------------------------------------------

--
-- Table structure for table `custom_requests`
--

CREATE TABLE `custom_requests` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` int(50) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `custom_requests`
--

INSERT INTO `custom_requests` (`id`, `full_name`, `email`, `contact`, `subject`, `message`, `created_at`) VALUES
(1, 'John Smith', 'francis.tettey000@gmail.com', 0, 'Dear Company Please Find Attach to this documents', 'I want Software  that has an HR Flow Just like Yours  To Manage  but My own must be integrated with a finance analytics dashboard.', '2024-12-14 02:01:14'),
(2, 'FRANCIS TETTEY', 'f.tettey@patmactech.co.uk', 0, 'Dear Company Please Find Attach to this documents', 'I Want analytical software', '2024-12-18 20:03:36'),
(3, 'Loed Tennyson', 'francis.tettey000@gmail.com', 547903281, 'Dear Company Please Find Attach to this documents', 'I want Finance analytic Software. I should be destop application', '2024-12-20 02:32:02'),
(4, 'FRANCIS TETTEY', 'francis.tettey000@gmail.com', 547903281, 'Dear Company Please Find Attach to this documents', 'hello', '2024-12-25 12:23:35');

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE `deductions` (
  `deduction_id` int(11) NOT NULL,
  `payroll_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deductions`
--

INSERT INTO `deductions` (`deduction_id`, `payroll_id`, `type`, `amount`) VALUES
(4, 1, 'Tax', 45.00);

-- --------------------------------------------------------

--
-- Table structure for table `employee_password_resets`
--

CREATE TABLE `employee_password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `reset_token` varchar(255) NOT NULL,
  `reset_expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_task_hours`
--

CREATE TABLE `employee_task_hours` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `hours_worked` decimal(5,2) DEFAULT NULL,
  `work_date` date GENERATED ALWAYS AS (cast(`start_time` as date)) VIRTUAL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_task_hours`
--

INSERT INTO `employee_task_hours` (`id`, `task_id`, `employee_id`, `start_time`, `end_time`, `hours_worked`) VALUES
(2, 28, 9, '2024-12-20 15:40:59', '2024-12-21 01:13:58', 9.53),
(3, 28, 9, '2024-12-24 19:33:38', '2024-12-24 19:34:23', 0.00),
(4, 28, 9, '2024-12-27 08:13:24', '2024-12-27 08:13:46', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `kpis`
--

CREATE TABLE `kpis` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `kpi_name` varchar(255) DEFAULT NULL,
  `target_value` decimal(10,2) DEFAULT NULL,
  `current_value` decimal(10,2) DEFAULT NULL,
  `evaluation_period` date DEFAULT NULL,
  `status` enum('on_track','at_risk','behind_schedule') DEFAULT 'on_track',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `performance_score` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kpis`
--

INSERT INTO `kpis` (`id`, `employee_id`, `kpi_name`, `target_value`, `current_value`, `evaluation_period`, `status`, `created_at`, `updated_at`, `performance_score`) VALUES
(1, 9, 'Your Game', 70.00, 20.00, '2024-10-30', 'behind_schedule', '2024-10-31 06:40:28', '2024-10-31 06:40:28', 0.00),
(2, 9, 'Your Game', 70.00, 20.00, '2024-10-30', 'behind_schedule', '2024-10-31 06:40:45', '2024-10-31 06:40:45', 0.00),
(3, 9, 'Your Game', 70.00, 20.00, '2024-10-30', 'behind_schedule', '2024-10-31 06:48:55', '2024-10-31 06:48:55', 0.00),
(4, 13, 'Your Game', 45.00, 78.00, '2024-10-24', 'on_track', '2024-10-31 06:58:22', '2024-10-31 06:58:22', 0.00),
(5, 11, 'System application', 80.00, 80.00, '2024-11-03', 'on_track', '2024-11-03 02:46:41', '2024-11-03 02:46:41', 0.00),
(6, 2, 'Data Science', 90.00, 87.00, '2024-11-03', 'on_track', '2024-11-03 03:20:50', '2024-11-03 03:20:50', NULL),
(7, 10, 'Sample', 100.00, 100.00, '2024-11-04', 'on_track', '2024-11-03 03:27:10', '2024-11-03 03:27:10', NULL),
(8, 14, 'Sample', 80.00, 50.00, '2024-11-03', 'at_risk', '2024-11-03 04:16:17', '2024-11-03 04:16:17', NULL),
(9, 8, 'System application', 68.00, 25.00, '2024-11-11', 'on_track', '2024-11-03 12:11:36', '2024-11-03 12:11:36', NULL),
(10, 15, 'Monthly evaluation', 59.00, 67.00, '2024-11-05', 'on_track', '2024-11-05 03:04:44', '2024-11-05 03:04:44', NULL),
(11, 9, 'Data Science', 78.00, 90.00, '2024-11-23', 'behind_schedule', '2024-11-23 12:48:22', '2024-11-23 12:48:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `leave_type` varchar(50) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`id`, `employee_id`, `leave_type`, `start_date`, `end_date`, `reason`, `status`) VALUES
(1, 9, 'maternity', '2024-10-10', '2024-10-18', 'How manay books', 'pending'),
(2, 9, 'maternity', '2024-10-12', '2024-10-14', 'Home Sweet home', 'approved'),
(6, 9, 'vacation', '2024-10-10', '2024-10-17', 'home', 'pending'),
(7, 9, 'vacation', '2024-10-14', '2024-10-16', 'I miss home', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `recipient` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `recipient`, `type`, `date`, `is_read`) VALUES
(1, '\'Customer Feedback Survey Analysis\' has been assigned to you. Please review and start working on it.', 7, 'New Task Assigned', '2024-09-05', 1),
(2, '\'test task\' has been assigned to you. Please review and start working on it', 7, 'New Task Assigned', '0000-00-00', 1),
(3, '\'Example task 2\' has been assigned to you. Please review and start working on it', 2, 'New Task Assigned', '2006-09-24', 1),
(4, '\'test\' has been assigned to you. Please review and start working on it', 8, 'New Task Assigned', '2009-06-24', 0),
(5, '\'test task 3\' has been assigned to you. Please review and start working on it', 7, 'New Task Assigned', '2024-09-06', 1),
(6, '\'Prepare monthly sales report\' has been assigned to you. Please review and start working on it', 7, 'New Task Assigned', '2024-09-06', 1),
(7, '\'Update client database\' has been assigned to you. Please review and start working on it', 7, 'New Task Assigned', '2024-09-06', 1),
(8, '\'Fix server downtime issue\' has been assigned to you. Please review and start working on it', 2, 'New Task Assigned', '2024-09-06', 0),
(9, '\'Plan annual marketing strategy\' has been assigned to you. Please review and start working on it', 2, 'New Task Assigned', '2024-09-06', 0),
(10, '\'Onboard new employees\' has been assigned to you. Please review and start working on it', 7, 'New Task Assigned', '2024-09-06', 0),
(11, '\'Design new company website\' has been assigned to you. Please review and start working on it', 2, 'New Task Assigned', '2024-09-06', 0),
(12, '\'Conduct software testing\' has been assigned to you. Please review and start working on it', 7, 'New Task Assigned', '2024-09-06', 0),
(13, '\'Schedule team meeting\' has been assigned to you. Please review and start working on it', 2, 'New Task Assigned', '2024-09-06', 0),
(14, '\'Prepare budget for Q4\' has been assigned to you. Please review and start working on it', 7, 'New Task Assigned', '2024-09-06', 0),
(15, '\'Write blog post on industry trend\' has been assigned to you. Please review and start working on it', 7, 'New Task Assigned', '2024-09-06', 0),
(16, '\'Renew software license\' has been assigned to you. Please review and start working on it', 2, 'New Task Assigned', '2024-09-06', 0),
(17, '\'System\' has been assigned to you. Please review and start working on it', 9, 'New Task Assigned', '2024-10-10', 0),
(18, '\'Python\' has been assigned to you. Please review and start working on it', 11, 'New Task Assigned', '2024-10-13', 0),
(19, '\'E-commerce Database\' has been assigned to you. Please review and start working on it', 11, 'New Task Assigned', '2024-10-29', 0),
(20, '\'Software\' has been assigned to you. Please review and start working on it', 15, 'New Task Assigned', '2024-11-04', 0);

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `payroll_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pay_date` date NOT NULL DEFAULT curdate(),
  `gross_salary` decimal(10,2) NOT NULL,
  `total_allowances` decimal(10,2) DEFAULT 0.00,
  `net_salary` decimal(10,2) DEFAULT NULL,
  `total_deductions` decimal(10,2) NOT NULL,
  `status` enum('processed','pending') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payroll`
--

INSERT INTO `payroll` (`payroll_id`, `user_id`, `pay_date`, `gross_salary`, `total_allowances`, `net_salary`, `total_deductions`, `status`, `created_at`) VALUES
(1, 9, '2024-11-10', 30000.00, 1000.00, 30697.00, 303.00, 'pending', '2024-11-10 10:25:06'),
(2, 9, '2024-11-10', 1400.00, 100.00, 1480.00, 20.00, 'pending', '2024-11-10 10:25:06'),
(3, 1, '2024-11-10', 1400.00, 200.00, 1580.00, 20.00, 'pending', '2024-11-10 10:26:10'),
(4, 1, '2024-11-10', 78000.00, 200.00, 78180.00, 20.00, 'pending', '2024-11-10 10:26:10'),
(6, 8, '2024-11-11', 4000.00, 140.00, 4090.00, 50.00, 'pending', '2024-11-10 16:47:22'),
(7, 8, '2024-11-11', 4000.00, 140.00, 4090.00, 50.00, 'pending', '2024-11-10 16:47:27'),
(8, 8, '2024-11-11', 4000.00, 140.00, 4090.00, 50.00, 'pending', '2024-11-10 16:50:13'),
(11, 1, '2024-11-11', 1400.00, 200.00, 1580.00, 20.00, 'pending', '2024-11-10 18:49:40'),
(12, 1, '2024-11-11', 1400.00, 200.00, 1580.00, 20.00, 'pending', '2024-11-10 18:50:39'),
(13, 2, '2024-11-19', 10000.00, 1000.00, 10900.00, 100.00, 'pending', '2024-11-10 19:13:47');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `plan` enum('Testing','StarterFlow','GrowthFlow','PowerFlow','CustomFlow') NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('pending','active','cancelled','expired') NOT NULL DEFAULT 'pending',
  `payment_method` enum('Paystack','Stripe','Free') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `company_id`, `plan`, `start_date`, `end_date`, `status`, `payment_method`) VALUES
(5, 5, 'Testing', '2024-12-05', '2024-12-12', 'active', 'Free'),
(6, 5, 'Testing', '2024-12-05', '2024-12-12', 'active', 'Free'),
(8, 5, 'Testing', '2024-12-05', '2024-12-12', 'active', 'Free'),
(9, 5, 'Testing', '2024-12-05', '2024-12-12', 'active', 'Free'),
(10, 5, 'Testing', '2024-12-05', '2024-12-12', 'active', 'Free'),
(11, 5, 'Testing', '2024-12-05', '2024-12-12', 'active', 'Free'),
(12, 5, 'Testing', '2024-12-05', '2024-12-12', 'active', 'Free'),
(13, 5, 'Testing', '2024-12-05', '2024-12-12', 'active', 'Free'),
(14, 5, 'Testing', '2024-12-05', '2024-12-12', 'active', 'Free'),
(15, 5, 'Testing', '2024-12-05', '2024-12-12', 'active', 'Free'),
(16, 5, 'Testing', '2024-12-05', '2024-12-12', 'active', 'Free'),
(24, 5, 'StarterFlow', '2024-12-05', '2024-12-12', 'pending', 'Paystack'),
(25, 4, 'StarterFlow', '2024-12-06', '2024-12-26', 'pending', 'Paystack'),
(27, 5, 'StarterFlow', '2024-12-08', '2024-12-09', 'pending', 'Stripe'),
(28, 4, 'StarterFlow', '2024-12-08', '2024-12-20', 'pending', 'Stripe'),
(29, 4, 'StarterFlow', '2024-12-08', '2024-12-24', 'pending', 'Stripe'),
(30, 4, 'StarterFlow', '2024-12-08', '2024-12-10', 'pending', 'Stripe'),
(31, 4, 'StarterFlow', '2024-12-09', '2024-12-13', 'pending', 'Paystack'),
(32, 4, 'StarterFlow', '2024-12-09', '2024-12-13', 'pending', 'Stripe'),
(33, 4, 'StarterFlow', '2024-12-08', '2024-12-30', 'pending', 'Stripe'),
(34, 5, 'StarterFlow', '2024-12-08', '2025-01-07', 'pending', 'Stripe'),
(35, 5, 'StarterFlow', '2024-12-08', '2025-01-11', 'pending', 'Stripe'),
(36, 5, 'Testing', '2024-12-08', '2024-12-15', 'active', 'Free'),
(37, 5, 'Testing', '2024-12-08', '2024-12-15', 'active', 'Free'),
(39, 4, 'StarterFlow', '2024-12-08', '2024-12-18', 'pending', 'Paystack'),
(40, 4, 'StarterFlow', '2024-12-08', '2025-01-11', 'pending', 'Stripe'),
(41, 4, 'StarterFlow', '2024-12-09', '2024-12-09', 'pending', 'Paystack'),
(42, 5, 'StarterFlow', '2024-12-09', '2024-12-28', 'pending', 'Paystack'),
(43, 5, 'StarterFlow', '2024-12-09', '2024-12-28', 'pending', 'Stripe'),
(44, 5, 'StarterFlow', '2024-12-09', '2024-12-28', 'pending', 'Stripe'),
(45, 5, 'StarterFlow', '2024-12-09', '2024-12-28', 'pending', 'Paystack'),
(46, 5, 'StarterFlow', '2024-12-09', '2025-01-11', 'pending', 'Paystack'),
(47, 5, 'Testing', '2024-12-09', '2024-12-16', 'active', 'Free'),
(52, 5, 'Testing', '2024-12-09', '2024-12-16', 'active', 'Free'),
(54, 4, 'StarterFlow', '2024-12-09', '2025-01-08', 'pending', 'Stripe'),
(55, 5, 'StarterFlow', '2024-12-10', '2025-01-09', 'pending', 'Stripe'),
(59, 5, 'Testing', '2024-12-18', '2024-12-25', 'active', 'Free'),
(60, 5, 'Testing', '2024-12-11', '2024-12-18', 'active', 'Free'),
(62, 5, 'StarterFlow', '2024-12-18', '2025-01-17', 'pending', 'Stripe'),
(63, 5, 'StarterFlow', '2024-12-23', '2025-01-22', 'pending', 'Stripe'),
(64, 5, 'StarterFlow', '2024-12-24', '2025-01-23', 'pending', 'Stripe'),
(65, 5, 'StarterFlow', '2024-12-24', '2025-01-23', 'pending', 'Stripe'),
(66, 4, 'StarterFlow', '2024-12-24', '2025-01-23', 'pending', 'Stripe'),
(67, 5, 'StarterFlow', '2024-12-25', '2025-01-24', 'pending', 'Paystack'),
(68, 5, 'StarterFlow', '2024-12-26', '2025-01-25', 'pending', 'Stripe'),
(69, 5, 'StarterFlow', '2024-12-26', '2025-01-25', 'pending', 'Stripe'),
(70, 5, 'StarterFlow', '2024-12-26', '2025-01-25', 'pending', 'Stripe'),
(71, 5, 'Testing', '2024-12-26', '2025-01-02', 'active', 'Free'),
(72, 5, 'StarterFlow', '2024-12-27', '2025-01-26', 'pending', 'Stripe'),
(73, 5, 'StarterFlow', '2024-12-27', '2025-01-26', 'pending', 'Stripe');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` enum('pending','in_progress','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `assigned_to`, `due_date`, `status`, `created_at`) VALUES
(1, 'Task 1', 'Task Description', 7, NULL, 'completed', '2024-08-29 16:47:37'),
(4, 'Monthly Financial Report Preparation', 'Prepare and review the monthly financial report, including profit and loss statements, balance sheets, and cash flow analysis.', 7, '2024-09-01', 'completed', '2024-08-31 10:50:20'),
(5, 'Customer Feedback Survey Analysis', 'Collect and analyze data from the latest customer feedback survey to identify areas for improvement in customer service.', 7, '2024-09-03', 'in_progress', '2024-08-31 10:50:47'),
(6, 'Website Maintenance and Update', 'Perform regular maintenance on the company website, update content, and ensure all security patches are applied.', 7, '2024-09-03', 'pending', '2024-08-31 10:51:12'),
(7, 'Quarterly Inventory Audit', 'Conduct a thorough audit of inventory levels across all warehouses and update the inventory management system accordingly.', 2, '2024-09-03', 'completed', '2024-08-31 10:51:45'),
(8, 'Employee Training Program Development', 'Develop and implement a new training program focused on enhancing employee skills in project management and teamwork.', 2, '2024-09-01', 'pending', '2024-08-31 10:52:11'),
(17, 'Prepare monthly sales report', 'Compile and analyze sales data for the previous month', 7, '2024-09-06', 'pending', '2024-09-06 08:01:48'),
(18, 'Update client database', 'Ensure all client information is current and complete', 7, '2024-09-07', 'pending', '2024-09-06 08:02:27'),
(19, 'Fix server downtime issue', 'Investigate and resolve the cause of recent server downtimes', 2, '2024-09-07', 'pending', '2024-09-06 08:02:59'),
(20, 'Plan annual marketing strategy', 'Develop a comprehensive marketing strategy for the next year', 2, '2024-09-04', 'pending', '2024-09-06 08:03:21'),
(21, 'Onboard new employees', 'Complete HR onboarding tasks for the new hires', 7, '2024-09-07', 'pending', '2024-09-06 08:03:44'),
(22, 'Design new company website', 'Create wireframes and mockups for the new website design', 2, '2024-09-06', 'pending', '2024-09-06 08:04:20'),
(23, 'Conduct software testing', 'Run tests on the latest software release to identify bugs', 7, '2024-09-07', 'pending', '2024-09-06 08:04:39'),
(24, 'Schedule team meeting', 'Organize a meeting to discuss project updates', 2, '2024-09-07', 'pending', '2024-09-06 08:04:57'),
(25, 'Prepare budget for Q4', 'Create and review the budget for the upcoming quarter', 7, '2024-09-07', 'pending', '2024-09-06 08:05:21'),
(26, 'Write blog post on industry trend', 'Draft and publish a blog post about current industry trend', 7, '2024-09-07', 'pending', '2024-09-06 08:10:50'),
(28, 'System', 'create analytics Software for Data Analyses', 9, '2024-10-11', 'completed', '2024-10-11 03:37:00'),
(29, 'Python', 'Create python Software to analyse All Hr Processes', 11, '2024-10-13', 'completed', '2024-10-13 14:34:51'),
(30, 'E-commerce Database', 'Create an E-commerce database to manage all online sales', 11, '2024-10-29', 'pending', '2024-10-30 02:39:23'),
(31, 'Software', 'create A database management software', 15, '2024-11-05', 'completed', '2024-11-04 16:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL DEFAULT 'Admin',
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','employee','evaluator') NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `department` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `dob` date NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `marital_status` enum('single','married','divorced','widowed') NOT NULL,
  `nationality` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `emergency_contact` text NOT NULL,
  `work_location` varchar(100) NOT NULL,
  `employment_type` enum('full-time','part-time','contractual','intern') NOT NULL,
  `account_number` varchar(50) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `ifsc_code` varchar(50) NOT NULL,
  `tin` varchar(50) NOT NULL,
  `insurance_number` varchar(50) NOT NULL,
  `is_suspended` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `email`, `profile_image`, `password`, `role`, `salary`, `department`, `created_at`, `dob`, `gender`, `marital_status`, `nationality`, `phone_number`, `address`, `emergency_contact`, `work_location`, `employment_type`, `account_number`, `bank_name`, `ifsc_code`, `tin`, `insurance_number`, `is_suspended`) VALUES
(1, 'Oliver', 'admin', 'oliver123@gmail.com', NULL, '$2y$10$oSs7uuXYp83ppisbZAzdTubnek3gRj7mBIJNiOYy77mo0A1ARjt5.', 'admin', 0.00, 'Network Office', '2024-08-28 07:10:04', '0000-00-00', 'male', 'single', '', '', '', '', '', 'full-time', '', '', '', '', '', 0),
(2, 'Elias A.', 'elias', 'elias122@gmail.com', NULL, '$2y$10$8xpI.hVCVd/GKUzcYTxLUO7ICSqlxX5GstSv7WoOYfXuYOO/SZAZ2', 'employee', 0.00, 'Developers team', '2024-08-28 07:10:40', '0000-00-00', 'male', 'single', '', '', '', '', '', 'full-time', '', '', '', '', '', 0),
(7, 'John', 'john', 'john333@gmail.com', NULL, '$2y$10$CiV/f.jO5vIsSi0Fp1Xe7ubWG9v8uKfC.VfzQr/sjb5/gypWNdlBW', 'employee', 0.00, 'Marketing', '2024-08-29 17:11:21', '0000-00-00', 'male', 'single', '', '', '', '', '', 'full-time', '', '', '', '', '', 0),
(8, 'Oliver', 'oliver', 'olee232@gmail.com', NULL, '$2y$10$E9Xx8UCsFcw44lfXxiq/5OJtloW381YJnu5lkn6q6uzIPdL5yH3PO', 'employee', 0.00, 'Payroll', '2024-08-29 17:11:34', '0000-00-00', 'male', 'single', '', '', '', '', '', 'full-time', '', '', '', '', '', 0),
(9, 'Tettey Francis', 'Francis', 'francis.tettey000@gmail.com', 'profile_676ab9524f1db5.05330769.jpeg', '$2y$10$.ds5KuPV5zeWhEsmh7lwhuJo9v8c2aiFGwBjYrOsvtpzQcSVGp5ii', 'employee', 0.00, 'Human Resource', '2024-10-11 02:03:21', '0000-00-00', 'male', 'single', '', '0547903281', 'En-165-1402', '', '', 'full-time', '', '', '', '', '', 0),
(10, 'Timothy Francis', 'Timoth', 'timothy676@gmail.com', NULL, '$2y$10$zE/veXtGys9FPnTVJARbT.4SdpwW9YHZAciAu9PMBrDniBV0FBdle', 'employee', 0.00, 'Quality Assusrance', '2024-10-13 14:30:58', '0000-00-00', 'male', 'single', '', '', '', '', '', 'full-time', '', '', '', '', '', 0),
(11, 'Patrick Kpodji', 'Patrick', 'p.mactech567@gmail.com', NULL, '$2y$10$ndhgviio0jcZTVdxXqtBfOjirZbCzEShYwCnV/lLrlE1vfgXSAw1m', 'employee', 0.00, 'IT Department', '2024-10-13 14:31:57', '0000-00-00', 'male', 'single', '', '', '', '', '', 'full-time', '', '', '', '', '', 0),
(12, 'Martey Francis', 'Tennyson', 'admin@gmail.com', NULL, '$2y$10$16S91b7M8Zup7.37wGYo7.xjtVRa5xrWI7ei.uPvLC0PbUQZqJwku', 'admin', 5000.00, 'Evaluation Office', '2024-10-27 16:38:47', '0000-00-00', 'male', 'single', '', '', '', '', '', 'full-time', '', '', '', '', '', 0),
(13, 'Rgina', 'Man', 'regina.man@gamil.com', NULL, '$2y$10$BB5P.aHbTFtewSaJT6MF/un.wqfQ9/Wc78rfSQkUenbKy/sLk6r7a', 'employee', 10.00, 'Computer Science', '2024-10-30 02:42:31', '0000-00-00', 'male', 'single', '', '', '', '', '', 'full-time', '', '', '', '', '', 0),
(14, 'Scott  Ofei', 'Scott', 'scott.ofei123@gamil.com', NULL, '$2y$10$EVSTfXG1pHFcIDc2u7Xp2.t6q3llVwlJx//XV8bLsNGgfgsulj/HW', 'employee', 4000.00, 'Computer Network', '2024-10-30 03:16:42', '0000-00-00', 'male', 'single', '', '', '', '', '', 'full-time', '', '', '', '', '', 0),
(15, 'Samuel Oware', 'Samuel', 'samuel.oware@gmail.com', NULL, '$2y$10$LtFr10H6ypx1oaEgNKYNwOydz2lvZr83ApHHdw0Hfc8jSE7xUWrMC', 'employee', 1400.00, 'Computer Science', '2024-11-04 15:56:08', '0000-00-00', 'male', 'single', '', '', '', '', '', 'full-time', '', '', '', '', '', 0),
(16, 'Nancy Nartey', 'Nancy', 'nanacy123@gmail.com', NULL, '', 'employee', 34003.00, 'Sales', '2024-11-19 10:19:59', '0000-00-00', 'male', 'single', '', '', '', '', '', 'full-time', '', '', '', '', '', 0),
(17, 'Sundeffelle Francis', 'Sundeffelle', 'sundaacne345@gmail.com', '../uploads/profile_images/1732019856_WhatsApp Image 2024-03-20 at 8.48.00 AM (2).jpeg', '', 'employee', 345000.00, 'Software Team', '2024-11-19 12:37:36', '0000-00-00', 'male', 'single', '', '', '', '', '', 'full-time', '', '', '', '', '', 0),
(18, 'John Tetteh', 'Tetteh', 'john419@gmail.com', '1732161159_john.jpeg', '$2y$10$edMcPmwXHjGJGa/jQG.dj.krRwTwmfks0hHlvvahjZPSCzgJ1BYFW', 'employee', 4500.00, 'Software Team', '2024-11-21 03:52:39', '0000-00-00', 'male', 'single', '', '', '', '', '', 'full-time', '', '', '', '', '', 0),
(19, 'Tettey Francis', 'Sundeacne', 'sundeffelle@gmail.com', NULL, '$2y$10$hBb4FEqTfx/Q8nUrNccBVuQgporRoh2R9dj0Vn3xyMmxb.Tnx0lBO', 'employee', 34000.00, 'Sales', '2024-11-21 05:16:01', '0000-00-00', 'male', 'single', '', '', '', '', '', 'full-time', '', '', '', '', '', 0),
(20, 'Lord Tee', 'Tee', 'lordtennyson777@gmail.com', '1732244915_john.jpeg', '$2y$10$BzMP6pMQa/fnXzd5qKIHbuR2BF8/aGF0KLgg55rO.O0ofkLTJC4Na', 'employee', 4500.00, 'Computer Network', '2024-11-22 03:08:36', '0000-00-00', 'male', 'single', '', '', '', '', '', 'full-time', '', '', '', '', '', 0),
(22, 'Patrick Kpodji', 'wisdomkuzgbe@gmail.com', 'patrick.kpodji123@gmail.com', '1732263973_patrick.jpeg', '$2y$10$waNk.MZHcUd2VOL/iv.NYeXwflTYc8RceLMwEJA9Lnaf2Pm0b2Bai', 'employee', 34567000.00, 'Director', '2024-11-22 08:26:13', '2024-11-22', 'male', 'married', 'Ghanaian', '0547903281', 'En-165-1402', '0547903281', 'Uk-North', 'full-time', '1400345465767788', 'Fidelity', '4343', '3456', '6269900021', 0),
(23, 'Essien Michael', 'Michael', 's.support@patmactech.co.uk', '1734486402_patrick.jpeg', '$2y$10$oESJNoIRp0SBB/Q9FG4b2OXH0dLVuiQZ2HAPigHgXhhS71kgKQT42', 'employee', 56000.00, 'Quality Assurance', '2024-12-18 01:46:42', '2024-12-18', 'male', 'single', 'Ghanaian', '+44678909898', 'En-165-1402', '0989876545', 'Uk-North', 'full-time', '1400345465767788', 'Calbank', '4343', 'GHA-72065444324', '09876543212345', 0),
(24, 'Tetteh Patrick', 'Mr. Patrick', 'customsupport@patmactech.co.uk', '1734492888_patrick.jpeg', '$2y$10$oSVPSYYTS1z4knpNhg7ff.9Vb3CzcPkjnPB3Sew1xyJYbW48wYwAe', 'admin', 4500.00, 'Quality Assurance', '2024-12-18 03:34:48', '2024-12-18', 'male', 'single', 'Ghanaian', '0547903281', 'En-165-1402', '09878765454', 'Uk-North', 'full-time', '1400345465767788', 'Fidelity', '4343', 'GHA-72065444324', 'GHA-5643324689', 0),
(25, 'Mr. Patrick Kpodji', 'Mr. Kpodji', 'g.support@patmactech.co.uk', '1734540347_patmacyechlogo.jpeg', '$2y$10$O12HHdCO5IbdMKRiMaPLIOkN556ggil7aGJyMP8AptaQwGPHasv/O', 'admin', 56000.00, 'Quality Assurance', '2024-12-18 16:45:47', '2024-12-18', 'male', 'married', 'Ghanaian', '+44678909898', 'En-165-1402', '0547890765', 'Uk-North', 'full-time', '1400345465767788', 'Fidelity', '4343', 'GHA-72065444324', '09876543212345', 0),
(27, 'Tettey Francis', 'Tettey', 'sundeffellefrancis@gmail.com', '1734934768_WhatsAppImage2024-03-20at8.48.00AM2.jpeg', '$2y$10$HeJnex6jcCaetvqb1yzHAOlHGsOm1zt1K05ehHeS.j.wklO9FOcAW', 'admin', 567000.00, 'Software Team', '2024-12-23 06:19:28', '2024-12-23', 'male', 'single', 'Ghanaian', '0547903281', 'En-165-1402', '0203148689', 'Koforidua-Ghana', 'full-time', '1400345465767788', 'Calbank', '9000', 'GHA-72065444324', 'GHA-5643324689', 0),
(28, 'Rose Tetteh', 'Rose', 'rose.tetteh333@gamil.com', '1735326656_WhatsAppImage2024-03-20at8.48.00AM2.jpeg', '$2y$10$oQiKS5ETJsseEBPrPtCuCehgEU.MPEp9aeiQeCoPeCeNVeLFmOOBG', 'employee', 5600.00, 'Computer Science', '2024-12-27 19:10:56', '2024-12-27', 'female', 'single', 'Ghanaian', '0547903281', 'En-165-1402', '0989876542', 'Accra-Ghana', 'full-time', '1400345465767788', 'Fidelity', '4343', '3456', 'GHA-5643324689', 0),
(29, 'Alfred Tenn', 'Alfred', 'teen.afred123@gmail.com', '1735355176_WhatsAppImage2024-03-20at8.48.06AM.jpeg', '$2y$10$dOLC.U6wWE2cCHyCoNPy8OrzlWLp7TuVU3.Wydq5SzgNlnHln5a.q', 'employee', 567.00, 'Computer Science', '2024-12-28 03:06:16', '2024-12-28', 'male', 'single', 'Ghanaian', '0547903281', 'En-165-1402', '0989876545', '678543324', 'full-time', '754342', '342167', '765432', '4356', 'GHA-5643324689', 0),
(30, 'XiuXian Xanchung', 'Xiuxian', 'xiuxian123@gmail.com', '1735355519_WhatsAppImage2024-03-20at8.47.58AM3.jpeg', '$2y$10$CFv6obEjye0kSXTmR0VexuNVCrU9qoaV1.obbK3Go6RuF7y3oPXbS', 'admin', 7809000.00, 'Quality Assurance', '2024-12-28 03:11:59', '2024-12-28', 'male', 'single', 'Ghanaian', '+44678909898', 'En-165-1402', '8790007656', '7658009822', 'full-time', '1400345465767788', 'Calbank', '9000', 'GHA-72065444324', 'GHA-5643324689', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `allowances`
--
ALTER TABLE `allowances`
  ADD PRIMARY KEY (`allowance_id`),
  ADD KEY `payroll_id` (`payroll_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`company_id`),
  ADD UNIQUE KEY `company_email` (`company_email`);

--
-- Indexes for table `company_password_resets`
--
ALTER TABLE `company_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_requests`
--
ALTER TABLE `custom_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`deduction_id`),
  ADD KEY `payroll_id` (`payroll_id`);

--
-- Indexes for table `employee_password_resets`
--
ALTER TABLE `employee_password_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `employee_task_hours`
--
ALTER TABLE `employee_task_hours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `kpis`
--
ALTER TABLE `kpis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`payroll_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `allowances`
--
ALTER TABLE `allowances`
  MODIFY `allowance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `company_password_resets`
--
ALTER TABLE `company_password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `custom_requests`
--
ALTER TABLE `custom_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `deduction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employee_password_resets`
--
ALTER TABLE `employee_password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `employee_task_hours`
--
ALTER TABLE `employee_task_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kpis`
--
ALTER TABLE `kpis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `payroll_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `allowances`
--
ALTER TABLE `allowances`
  ADD CONSTRAINT `allowances_ibfk_1` FOREIGN KEY (`payroll_id`) REFERENCES `payroll` (`payroll_id`);

--
-- Constraints for table `deductions`
--
ALTER TABLE `deductions`
  ADD CONSTRAINT `deductions_ibfk_1` FOREIGN KEY (`payroll_id`) REFERENCES `payroll` (`payroll_id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_task_hours`
--
ALTER TABLE `employee_task_hours`
  ADD CONSTRAINT `employee_task_hours_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_task_hours_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kpis`
--
ALTER TABLE `kpis`
  ADD CONSTRAINT `kpis_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `leaves`
--
ALTER TABLE `leaves`
  ADD CONSTRAINT `leaves_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `payroll`
--
ALTER TABLE `payroll`
  ADD CONSTRAINT `payroll_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
