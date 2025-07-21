-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jul 21, 2025 at 06:40 AM
-- Server version: 11.5.2-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cbms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `aemail` varchar(255) NOT NULL,
  `apassword` varchar(255) DEFAULT NULL
) ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`aemail`, `apassword`) VALUES
('admin@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appoid` int(11) NOT NULL,
  `pid` int(10) DEFAULT NULL,
  `apponum` int(3) DEFAULT NULL,
  `scheduleid` int(10) DEFAULT NULL,
  `appodate` date DEFAULT NULL,
  `status` enum('pending','confirmed','canceled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appoid`, `pid`, `apponum`, `scheduleid`, `appodate`, `status`) VALUES
(2, 3, 2, 1, '2025-06-26', 'confirmed'),
(4, 7, 1, 10, '2025-07-17', 'pending'),
(5, 1, 2, 10, '2025-07-18', 'pending'),
(6, 1, 2, 1, '2025-07-18', 'confirmed'),
(13, 3, 1, 11, '2025-07-19', 'confirmed'),
(20, 3, 1, 12, '2025-07-19', 'pending'),
(28, 3, 1, 13, '2025-07-19', 'confirmed'),
(29, 1, 2, 13, '2025-07-19', 'confirmed'),
(32, 3, 1, 14, '2025-07-19', 'confirmed'),
(36, 4, 1, 15, '2025-07-19', 'pending'),
(37, 4, 2, 14, '2025-07-19', 'pending'),
(38, 4, 3, 13, '2025-07-20', 'pending'),
(39, 5, 3, 14, '2025-07-20', 'pending'),
(40, 6, 4, 14, '2025-07-20', 'pending'),
(41, 6, 1, 16, '2025-07-20', 'pending'),
(42, 3, 2, 15, '2025-07-20', 'pending'),
(46, 3, 1, 17, '2025-07-20', 'confirmed'),
(48, 1, 2, 17, '2025-07-20', 'pending'),
(50, 5, 1, 19, '2025-07-20', 'confirmed'),
(54, 4, 3, 17, '2025-07-20', 'pending'),
(55, 3, 2, 18, '2025-07-20', 'pending'),
(56, 5, 1, 20, '2025-07-20', 'pending'),
(57, 5, 1, 21, '2025-07-20', 'confirmed'),
(59, 4, 2, 21, '2025-07-20', 'pending'),
(63, 4, 2, 18, '2025-07-20', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `pid` int(11) DEFAULT NULL,
  `docid` int(11) DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `appointment_time` time DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `pid`, `docid`, `appointment_date`, `appointment_time`, `status`) VALUES
(1, 1, 1, '2025-07-18', '14:00:00', 'confirmed'),
(2, 2, 1, '2025-07-18', '14:00:00', 'confirmed'),
(3, 3, 1, '2025-07-18', '14:00:00', 'confirmed'),
(4, 2, 2, '2025-07-18', '14:00:00', 'confirmed'),
(5, 4, 2, '2025-07-18', '14:00:00', 'confirmed'),
(6, 5, 1, '2025-07-18', '14:00:00', 'confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `docid` int(11) NOT NULL,
  `docemail` varchar(255) DEFAULT NULL,
  `docname` varchar(255) DEFAULT NULL,
  `docpassword` varchar(255) DEFAULT NULL,
  `docnic` varchar(15) DEFAULT NULL,
  `doctel` varchar(15) DEFAULT NULL,
  `specialties` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`docid`, `docemail`, `docname`, `docpassword`, `docnic`, `doctel`, `specialties`) VALUES
(1, 'doctor@gmail.com', 'Doctor Ye', '12345', '3/tangana(N)545', '09852587854', 1),
(2, 'mgl@gmail.com', 'mingalar', 'mgl12345', 'mgl12345', '0958898987', 24),
(3, 'it@gmail.com', 'Doctor IT', '12345', '3/tanguna(N)458', '0987542458', 34),
(4, 'naing@gmail.com', 'Doctor Naing', '12345', '3/tangana(N)258', '09874587512', 48);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `pid` int(11) NOT NULL,
  `pemail` varchar(255) DEFAULT NULL,
  `pname` varchar(255) DEFAULT NULL,
  `ppassword` varchar(255) DEFAULT NULL,
  `paddress` varchar(255) DEFAULT NULL,
  `pnic` varchar(15) DEFAULT NULL,
  `pdob` date DEFAULT NULL,
  `ptel` varchar(15) DEFAULT NULL,
  `profile_img` varchar(255) DEFAULT '../img/user.png',
  `feeling` varchar(255) DEFAULT NULL,
  `headache` enum('yes','no') DEFAULT NULL,
  `fever` enum('yes','no') DEFAULT NULL,
  `other_symptoms` text DEFAULT NULL,
  `questionnaire_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`pid`, `pemail`, `pname`, `ppassword`, `paddress`, `pnic`, `pdob`, `ptel`, `profile_img`, `feeling`, `headache`, `fever`, `other_symptoms`, `questionnaire_date`) VALUES
(1, 'patient@gmail.com', 'Test Patient', '12345', 'toungoo', '0000000000', '2000-01-01', '0120000000', '../img/user1.png', 'ဟုတ်', 'yes', 'no', 'ညောင်းညာ', '2025-07-16 15:55:48'),
(3, 'mntt@gmail.com', 'minnyi thattant', 'mntt12345', 'street one', 'nic12345', '1998-01-01', '0985554787', '../img/user1.png', 'ညောင်းတယ်', 'no', 'no', 'လေးလံ', '2025-07-16 15:55:48'),
(4, 'hello@gmail.com', 'hello ', '12345', 'hello', '1456987545', '2008-01-03', '0987545852', '../img/user.png', 'feel not well', 'yes', 'no', 'feel tired', '2025-07-16 19:39:45'),
(5, 'inn@gmail.com', 'inn ', '12345', 'inn', '1452658789565', '2016-01-17', '0987542125', '../img/user.png', 'နည်းနည်းညောင်း', 'no', 'no', 'လေးလံထိုင်းမှိုင်း', '2025-07-16 19:45:49'),
(6, 'onn@gmail.com', 'onn ', '12345', 'onnn', '1245878545', '2015-01-17', '0987542147', '../img/user.png', 'a little', 'no', 'no', 'feel', '2025-07-16 19:51:48'),
(7, 'mg@gmail.com', '‌မောင်မောင် ', '12345', '၁-လမ်း', '၇/တကန(နိုင်)157', '2008-01-17', '0945785412', '../img/user.png', 'ခေါင်းမူး', 'yes', 'yes', 'ညောင်းတယ်', '2025-07-17 15:51:04');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `scheduleid` int(11) NOT NULL,
  `docid` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `scheduledate` date DEFAULT NULL,
  `scheduletime` time DEFAULT NULL,
  `nop` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`scheduleid`, `docid`, `title`, `scheduledate`, `scheduletime`, `nop`) VALUES
(18, '4', 'session two', '2025-08-08', '10:17:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `specialties`
--

CREATE TABLE `specialties` (
  `id` int(2) NOT NULL,
  `sname` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `specialties`
--

INSERT INTO `specialties` (`id`, `sname`) VALUES
(1, 'နှလုံးအထူးကု'),
(2, 'အရိုးအထူးကု'),
(3, 'ဦးနှောက်နှင့်အာရုံကြောအထူးကု'),
(4, 'အသည်းအထူးကု'),
(5, 'အစာအိမ်အတူးကု'),
(6, 'ဆီးလမ်းကြောင်းဆိုင်ရာအထူး'),
(7, 'မီးယပ်နှင့် သားဖွားအထူး'),
(8, 'ကလေးအထူး'),
(9, 'မျက်စိအထူးကု'),
(10, 'အရေပြားအထူးကု'),
(11, 'စိတ်ရောဂါအထူးကု'),
(12, 'သွားဘက်ဆိုင်ရာ အထူးကု'),
(13, 'အထွေထွေသမားတော်'),
(14, 'ကင်ဆာအထူးကု'),
(15, 'ဓာတ်မှန်ရောင်ခြည်အထူးကု'),
(16, 'ခြေလက်နှင့် ခြေထောက်အထူးကု'),
(17, 'ပလပ်စတစ်ဆာဂျရီအထူးကု'),
(18, 'အဆုတ်နှင့်ရင်ခေါင်းအထူးကု'),
(19, 'သွေးအထူး'),
(20, 'ကျောက်ကပ်အထူးကု'),
(21, 'ဦးနှောက်နှင့်အာရုံကြောခွဲစိတ်အထူးကု'),
(22, 'နား၊နှခေါင်း၊လည်ချောင်းအထူးကု'),
(23, 'အာဟာရအထူးကု'),
(24, 'ဆေးဘက်ဆိုင်ရာဓာတ်ခွဲကျွမ်းကျင်အထူးကု'),
(25, 'စိတ်ကျန်းမာရေး ပြန်လည်သန်စွမ်းရေးအထူးကု'),
(26, 'နာတာရှည်နာကျင်မှုအထူးကု'),
(27, 'အဆစ်မြစ်ရောင်ရောဂါအထူးကု'),
(28, 'ကူးစက်ရောဂါအထူးကု'),
(29, 'အသည်းအစားထိုးအထူးကု'),
(30, 'သားဖွားမီးယပ်ဆိုင်ရာ အာထရာဆောင်းအထူးကု'),
(31, 'ကလေးဦးနှောအာရုံကြောအထူးကု'),
(32, 'ကလေးကင်ဆာအထူးကု'),
(33, 'အရေးပေါ်နှလုံးအထူးကု'),
(34, 'ဆေးဘက်ဆိုင်ရာ ကုထုံးပညာရှင်'),
(35, 'ဓာတ်မတည့်မှုနှင့် ကိုယ်ခံအားကုသပညာရှင်'),
(36, 'မေ့ဆေးပညာကုသမှုပညာရှင်'),
(37, 'နှလုံးနှင့် ရင်ဘက်ခွဲစိတ်ပညာရှင်'),
(38, 'အာရုံကြောဆိုင်ရာ ပညာရှင်'),
(39, 'ဦးနှောက်နှင့် မျက်စိခွဲစိတ်ပညာရှင်'),
(40, 'ဟော်မုန်းပညာရှင်'),
(41, 'အစာအိမ်နှင့် အူလမ်းကြောင်းဆိုင်ရာ ပညာရှင်'),
(42, 'Plastic surgery ပညာရှင်'),
(43, 'အထွေထွေခွဲစိတ် ပညာရှင်'),
(44, 'သက်ကြီးပညာရှင်'),
(45, 'ရောဂါစစ်ဆေး ဓာတ်မှန်ပညာရှင်'),
(46, 'ပြည်သူ့ကျန်းမာရေးနှင့် ကာကွယ်ရေးဆေးပညာရှင်'),
(47, 'ရောဂါဗေဒ ပညာရှင်'),
(48, 'နျူကလီးယား ဆေးပညာရှင်'),
(49, 'ရောင်ခြည်ကုထုံး ပညာရှင်'),
(50, 'အသက်ရှူလမ်းကြောင်းဆိုင်ရာ ပညာရှင်'),
(51, 'အဆစ်မြစ်ရောင်ကုသ ပညာရှင်'),
(52, 'သွားနှင့်ခံတွင်းဆိုင်ရာ ပညာရှင်'),
(53, 'လိင်မှတစ်ဆင့် ကူးစက်ရောဂါပညာရှင်'),
(54, 'သွေးကြောခွဲစိတ် ပညာရှင်'),
(55, 'ကာယပြန်လည် သန်စွမ်းရေး ပညာရှင်'),
(56, 'ဆေးဘက်မျိုးရိုးဗီဇဆိုင်ရာ ပညာရှင်');

-- --------------------------------------------------------

--
-- Table structure for table `webuser`
--

CREATE TABLE `webuser` (
  `email` varchar(255) NOT NULL,
  `usertype` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `webuser`
--

INSERT INTO `webuser` (`email`, `usertype`) VALUES
('admin@gmail.com', 'a'),
('doctor@gmail.com', 'd'),
('hello@gmail.com', 'p'),
('inn@gmail.com', 'p'),
('it@gmail.com', 'd'),
('mg@gmail.com', 'p'),
('mgl@gmail.com', 'd'),
('mntt@gmail.com', 'p'),
('naing@gmail.com', 'd'),
('onn@gmail.com', 'p'),
('patient@gmail.com', 'p');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`aemail`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appoid`),
  ADD UNIQUE KEY `unique_patient_schedule` (`pid`,`scheduleid`),
  ADD KEY `pid` (`pid`),
  ADD KEY `scheduleid` (`scheduleid`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `p_id` (`pid`),
  ADD KEY `doc_id` (`docid`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`docid`),
  ADD KEY `specialties` (`specialties`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`scheduleid`),
  ADD KEY `docid` (`docid`);

--
-- Indexes for table `specialties`
--
ALTER TABLE `specialties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webuser`
--
ALTER TABLE `webuser`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `docid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `scheduleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `patient` (`pid`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`docid`) REFERENCES `doctor` (`docid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
