-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2024 at 12:30 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `student_create`
--

CREATE TABLE `student_create` (
  `Image` blob NOT NULL,
  `Student_Name` varchar(400) NOT NULL,
  `USN` varchar(300) NOT NULL,
  `Course` varchar(100) NOT NULL,
  `Year` int(50) NOT NULL,
  `Date` datetime NOT NULL,
  `Time_In` timestamp NOT NULL DEFAULT current_timestamp(),
  `Time_Out` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_create`
--

INSERT INTO `student_create` (`Image`, `Student_Name`, `USN`, `Course`, `Year`, `Date`, `Time_In`, `Time_Out`) VALUES
('', 'Gworge Charz Corpuz', '0', 'Course', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
('', 'Gworge Charz Corpuz', '0', 'Course', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
('', 'Gworge Charz Corpuz', '2147483647', 'Computer Science', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
('', 'Student01', '2147483647', 'Computer Science', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
('', 'Student01', '3835311603', 'Computer Science', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `USN` int(11) NOT NULL,
  `Username` varchar(500) NOT NULL,
  `Email` varchar(500) NOT NULL,
  `Password` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`USN`, `Username`, `Email`, `Password`) VALUES
(10, 'Yahagi01', 'charls.corpuz20@gmail.com', '$2y$10$401sotTBdWWjqkBgEiK42.1g66JeORIJmIwLsGQ6dHsWJrZ8zre4y'),
(11, 'Dummy 1', 'dummy1@gmail.com', '$2y$10$CrEYzvmVHyE1XK5ARh8L1ec5AWy.pVdAgOJ2LqoBPGs14HRek0cV6'),
(12, 'Dummy 1', 'dummy1@gmail.com', '$2y$10$zKWvVlFn3rtadrc0hSap3eCOPF47gPPmC9Mm6.Ln/1TKzpFJsesGO'),
(13, '', '', '$2y$10$KH6YhdDZE.39C/5U/UcfAu9T77T9qiXxOaO3HyZw8O0V4Un512M2q');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`USN`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `USN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
