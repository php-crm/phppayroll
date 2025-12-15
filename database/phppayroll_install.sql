-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 15, 2025 at 05:17 AM
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
-- Database: `phppayroll_free`
--

-- --------------------------------------------------------

--
-- Table structure for table `phppayroll_attendance`
--

CREATE TABLE `phppayroll_attendance` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `attendance_date` date NOT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `status` enum('present','absent','late','half_day') DEFAULT 'present',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phppayroll_attendance`
--

INSERT INTO `phppayroll_attendance` (`id`, `employee_id`, `attendance_date`, `check_in`, `check_out`, `status`, `created_at`) VALUES
(1, 1, '2024-09-01', '09:05:00', '18:00:00', 'present', '2025-12-14 12:08:14'),
(2, 2, '2024-09-01', '09:30:00', '18:10:00', 'late', '2025-12-14 12:08:14'),
(3, 3, '2024-09-01', NULL, NULL, 'absent', '2025-12-14 12:08:14'),
(4, 4, '2024-09-01', '09:10:00', '13:30:00', 'half_day', '2025-12-14 12:08:14'),
(5, 5, '2024-09-01', '08:55:00', '17:45:00', 'present', '2025-12-14 12:08:14');

-- --------------------------------------------------------

--
-- Table structure for table `phppayroll_employees`
--

CREATE TABLE `phppayroll_employees` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `employee_code` varchar(50) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `department` varchar(200) DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `date_of_joining` date DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phppayroll_employees`
--

INSERT INTO `phppayroll_employees` (`id`, `user_id`, `employee_code`, `first_name`, `last_name`, `phone`, `department`, `designation`, `date_of_joining`, `salary`, `status`, `created_at`) VALUES
(1, 101, 'EMP-001', 'Amit', 'Sharma', '9876543210', 'Human Resources', 'HR Manager', '2022-04-15', 55000.00, 1, '2025-12-14 12:07:27'),
(2, 102, 'EMP-002', 'Priya', 'Verma', '9898989898', 'Accounts', 'Accountant', '2021-11-01', 42000.00, 1, '2025-12-14 12:07:27'),
(3, 103, 'EMP-003', 'Rahul', 'Singh', '9123456789', 'IT', 'Software Developer', '2023-02-10', 65000.00, 1, '2025-12-14 12:07:27'),
(4, 104, 'EMP-004', 'Neha', 'Gupta', '9012345678', 'Sales', 'Sales Executive', '2022-08-20', 38000.00, 1, '2025-12-14 12:07:27'),
(5, 105, 'EMP-005', 'Vikas', 'Mehta', '9345678901', 'Operations', 'Operations Manager', '2020-06-05', 72000.00, 1, '2025-12-14 12:07:27');

-- --------------------------------------------------------

--
-- Table structure for table `phppayroll_leaves`
--

CREATE TABLE `phppayroll_leaves` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `leave_type` enum('casual','sick','paid','unpaid') DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phppayroll_leaves`
--

INSERT INTO `phppayroll_leaves` (`id`, `employee_id`, `leave_type`, `start_date`, `end_date`, `reason`, `status`, `applied_at`) VALUES
(1, 1, 'casual', '2024-09-05', '2024-09-05', 'Personal work', 'approved', '2025-12-14 12:09:11'),
(2, 2, 'sick', '2024-09-10', '2024-09-12', 'Viral fever', 'approved', '2025-12-14 12:09:11'),
(3, 3, 'paid', '2024-09-15', '2024-09-20', 'Family function', 'pending', '2025-12-14 12:09:11'),
(4, 4, 'unpaid', '2024-09-18', '2024-09-19', 'Emergency personal matter', 'approved', '2025-12-14 12:09:11'),
(5, 5, 'casual', '2024-09-25', '2024-09-25', 'Bank work', 'rejected', '2025-12-14 12:09:11');

-- --------------------------------------------------------

--
-- Table structure for table `phppayroll_payroll`
--

CREATE TABLE `phppayroll_payroll` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `salary_month` varchar(20) DEFAULT NULL,
  `basic_salary` decimal(10,2) DEFAULT NULL,
  `allowances` decimal(10,2) DEFAULT 0.00,
  `deductions` decimal(10,2) DEFAULT 0.00,
  `net_salary` decimal(10,2) DEFAULT NULL,
  `generated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phppayroll_payroll`
--

INSERT INTO `phppayroll_payroll` (`id`, `employee_id`, `salary_month`, `basic_salary`, `allowances`, `deductions`, `net_salary`, `generated_at`) VALUES
(1, 1, 'September 2024', 55000.00, 5000.00, 2000.00, 58000.00, '2025-12-14 12:10:11'),
(2, 2, 'September 2024', 42000.00, 3000.00, 1500.00, 43500.00, '2025-12-14 12:10:11'),
(3, 3, 'September 2024', 65000.00, 8000.00, 2500.00, 70500.00, '2025-12-14 12:10:11'),
(4, 4, 'September 2024', 38000.00, 2000.00, 1000.00, 39000.00, '2025-12-14 12:10:11'),
(5, 5, 'September 2024', 72000.00, 10000.00, 3000.00, 79000.00, '2025-12-14 12:10:11');

-- --------------------------------------------------------

--
-- Table structure for table `phppayroll_users`
--

CREATE TABLE `phppayroll_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phppayroll_users`
--

INSERT INTO `phppayroll_users` (`id`, `username`, `email`, `password_hash`, `full_name`, `status`, `created_at`) VALUES
(1, 'admin@phppayroll.com', 'admin@phppayroll.com', '$2y$10$An0BgSTq3JbR/9lKz8maGuqT22sSV8dTZ5CuxFnvVjSq0KCv77RA.', 'Administrator', 1, '2025-11-29 12:19:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `phppayroll_attendance`
--
ALTER TABLE `phppayroll_attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emp_date` (`employee_id`,`attendance_date`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `phppayroll_employees`
--
ALTER TABLE `phppayroll_employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_code` (`employee_code`),
  ADD KEY `department_id` (`department`);

--
-- Indexes for table `phppayroll_leaves`
--
ALTER TABLE `phppayroll_leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `phppayroll_payroll`
--
ALTER TABLE `phppayroll_payroll`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `phppayroll_users`
--
ALTER TABLE `phppayroll_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `phppayroll_attendance`
--
ALTER TABLE `phppayroll_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `phppayroll_employees`
--
ALTER TABLE `phppayroll_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `phppayroll_leaves`
--
ALTER TABLE `phppayroll_leaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `phppayroll_payroll`
--
ALTER TABLE `phppayroll_payroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `phppayroll_users`
--
ALTER TABLE `phppayroll_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
