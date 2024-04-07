-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2024 at 02:30 AM
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
-- Database: `mememoir`
--

-- --------------------------------------------------------

--
-- Table structure for table `aktoil`
--

CREATE TABLE `aktoil` (
  `id` int(11) NOT NULL,
  `subworker` varchar(50) NOT NULL,
  `subworkergroup` varchar(50) NOT NULL,
  `subworkersecondarygroup` varchar(50) NOT NULL,
  `subworkermsgroupbd` varchar(50) NOT NULL,
  `subworkersecondarymsggroupbd` varchar(50) NOT NULL,
  `subworkercompanyname` varchar(50) NOT NULL,
  `subworkerEmail` varchar(50) NOT NULL,
  `subworkerPassword` varchar(50) NOT NULL,
  `subworkerJobTitle` varchar(50) NOT NULL,
  `subworkersalery` varchar(50) NOT NULL,
  `subworkerPhoneNumber` varchar(50) NOT NULL,
  `subworkerId` varchar(50) NOT NULL,
  `subworkerbadj` varchar(50) NOT NULL,
  `subworkersubbadj` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aktoil`
--

INSERT INTO `aktoil` (`id`, `subworker`, `subworkergroup`, `subworkersecondarygroup`, `subworkermsgroupbd`, `subworkersecondarymsggroupbd`, `subworkercompanyname`, `subworkerEmail`, `subworkerPassword`, `subworkerJobTitle`, `subworkersalery`, `subworkerPhoneNumber`, `subworkerId`, `subworkerbadj`, `subworkersubbadj`) VALUES
(12, 'akram', 'السنةالأولى', 'none', 'subworkermsgroupbd', 'subworkersecondarymsggroupbd', 'AKTOIL', 'akram@gmail.com', 'akramakram', 'frontend developer', '', '0551331388', 'not yet', 'Leader', 'worker'),
(13, 'djamel', 'السنةالأولى', 'none', 'subworkermsgroupbd', 'subworkersecondarymsggroupbd', 'AKTOIL', 'akrama@gmail.com', 'akramakram', 'frontend stupid', '', '0551331388', 'not yet', 'worker', 'worker');

-- --------------------------------------------------------

--
-- Table structure for table `aktoilallgroup`
--

CREATE TABLE `aktoilallgroup` (
  `id` int(11) NOT NULL,
  `date` varchar(250) NOT NULL,
  `GroupName` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aktoilallgroup`
--

INSERT INTO `aktoilallgroup` (`id`, `date`, `GroupName`) VALUES
(4, '2024-03-27', 'السنةالأولى'),
(5, '2024-03-27', 'قسمالسنةالثانية');

-- --------------------------------------------------------

--
-- Table structure for table `aktoilgroupالسنةالأولى`
--

CREATE TABLE `aktoilgroupالسنةالأولى` (
  `id` int(11) NOT NULL,
  `date` varchar(250) NOT NULL,
  `GroupName` varchar(250) NOT NULL,
  `Groupin` varchar(250) NOT NULL,
  `Groupout` varchar(250) NOT NULL,
  `Groupbadg` varchar(250) NOT NULL,
  `Groupcolor` varchar(250) NOT NULL,
  `workerName` varchar(250) NOT NULL,
  `workerEmail` varchar(250) NOT NULL,
  `workerjobTitle` varchar(250) NOT NULL,
  `workerTimeIn` varchar(250) NOT NULL,
  `workerTimeout` varchar(250) NOT NULL,
  `workerState` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aktoilgroupالسنةالأولى`
--

INSERT INTO `aktoilgroupالسنةالأولى` (`id`, `date`, `GroupName`, `Groupin`, `Groupout`, `Groupbadg`, `Groupcolor`, `workerName`, `workerEmail`, `workerjobTitle`, `workerTimeIn`, `workerTimeout`, `workerState`) VALUES
(1, '2024-03-27', 'السنةالأولى', '1', '1', 'circl', 'red', '', '', '', '', '', ''),
(2, '2024-03-27', '', '', '', '', '', 'akram', 'akram@gmail.com', 'frontend developer', '2024-03-27 04:42:10', '2024-03-27 04:42:39', 'Present');

-- --------------------------------------------------------

--
-- Table structure for table `aktoilgroupقسمالسنةالثانية`
--

CREATE TABLE `aktoilgroupقسمالسنةالثانية` (
  `id` int(11) NOT NULL,
  `date` varchar(250) NOT NULL,
  `GroupName` varchar(250) NOT NULL,
  `Groupin` varchar(250) NOT NULL,
  `Groupout` varchar(250) NOT NULL,
  `Groupbadg` varchar(250) NOT NULL,
  `Groupcolor` varchar(250) NOT NULL,
  `workerName` varchar(250) NOT NULL,
  `workerEmail` varchar(250) NOT NULL,
  `workerjobTitle` varchar(250) NOT NULL,
  `workerTimeIn` varchar(250) NOT NULL,
  `workerTimeout` varchar(250) NOT NULL,
  `workerState` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aktoilgroupقسمالسنةالثانية`
--

INSERT INTO `aktoilgroupقسمالسنةالثانية` (`id`, `date`, `GroupName`, `Groupin`, `Groupout`, `Groupbadg`, `Groupcolor`, `workerName`, `workerEmail`, `workerjobTitle`, `workerTimeIn`, `workerTimeout`, `workerState`) VALUES
(1, '2024-03-27', 'قسمالسنةالثانية', '1', '1', 'circl', 'red', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `aktoilmsgsgroupالسنةالأولى`
--

CREATE TABLE `aktoilmsgsgroupالسنةالأولى` (
  `id` int(11) NOT NULL,
  `date` varchar(250) NOT NULL,
  `sendername` varchar(250) NOT NULL,
  `sendermsg` varchar(250) NOT NULL,
  `sendertime` varchar(250) NOT NULL,
  `senderemail` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aktoilmsgsgroupالسنةالأولى`
--

INSERT INTO `aktoilmsgsgroupالسنةالأولى` (`id`, `date`, `sendername`, `sendermsg`, `sendertime`, `senderemail`) VALUES
(1, '2024-03-27', 'Akram', 'azf', '04:36:06', 'akram@gmail.com'),
(2, '2024-03-27', 'Akram', 'azf azlndflazd azndaz', '04:39:05', 'akram@gmail.com'),
(3, '2024-03-27', 'akram', 'hi  i am oumar from the main group', '04:41:13', 'akram@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `aktoilmsgsgroupقسمالسنةالثانية`
--

CREATE TABLE `aktoilmsgsgroupقسمالسنةالثانية` (
  `id` int(11) NOT NULL,
  `date` varchar(250) NOT NULL,
  `sendername` varchar(250) NOT NULL,
  `sendermsg` varchar(250) NOT NULL,
  `sendertime` varchar(250) NOT NULL,
  `senderemail` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `aktoiltasks`
--

CREATE TABLE `aktoiltasks` (
  `id` int(11) NOT NULL,
  `date` varchar(250) NOT NULL,
  `TaskName` varchar(250) NOT NULL,
  `TaskDis` varchar(250) NOT NULL,
  `TaskGroup` varchar(250) NOT NULL,
  `TaskState` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aktoiltasks`
--

INSERT INTO `aktoiltasks` (`id`, `date`, `TaskName`, `TaskDis`, `TaskGroup`, `TaskState`) VALUES
(1, '2023-12-25', 'website', 'app for me', 'developers', 'done'),
(8, '2024-01-01', 'website', 'app for me', 'developers', 'done'),
(9, '2024-01-02', 'website', 'app for me', 'developers', 'done'),
(10, '2024-03-27', 'تمرين رقم', 'app for me', 'السنةالأولى', 'done'),
(11, '2024-03-27', 'website', 'app for me', 'السنةالأولى', 'done');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `companyName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `companyName`) VALUES
(2, 'Akram', 'akram@gmail.com', '$2y$10$DKSsgM3jcqLk51B067ybe.VsBa53R8ty/kIrAlYr9zFwb/mz.pJAy', 'AKTOIL');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aktoil`
--
ALTER TABLE `aktoil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aktoilallgroup`
--
ALTER TABLE `aktoilallgroup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aktoilgroupالسنةالأولى`
--
ALTER TABLE `aktoilgroupالسنةالأولى`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aktoilgroupقسمالسنةالثانية`
--
ALTER TABLE `aktoilgroupقسمالسنةالثانية`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aktoilmsgsgroupالسنةالأولى`
--
ALTER TABLE `aktoilmsgsgroupالسنةالأولى`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aktoilmsgsgroupقسمالسنةالثانية`
--
ALTER TABLE `aktoilmsgsgroupقسمالسنةالثانية`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aktoiltasks`
--
ALTER TABLE `aktoiltasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aktoil`
--
ALTER TABLE `aktoil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `aktoilallgroup`
--
ALTER TABLE `aktoilallgroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `aktoilgroupالسنةالأولى`
--
ALTER TABLE `aktoilgroupالسنةالأولى`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `aktoilgroupقسمالسنةالثانية`
--
ALTER TABLE `aktoilgroupقسمالسنةالثانية`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `aktoilmsgsgroupالسنةالأولى`
--
ALTER TABLE `aktoilmsgsgroupالسنةالأولى`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `aktoilmsgsgroupقسمالسنةالثانية`
--
ALTER TABLE `aktoilmsgsgroupقسمالسنةالثانية`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `aktoiltasks`
--
ALTER TABLE `aktoiltasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
