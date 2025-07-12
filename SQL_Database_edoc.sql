SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `appodate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appoid`, `pid`, `apponum`, `scheduleid`, `appodate`) VALUES
(1, 1, 1, 1, '2025-06-03'),
(2, 3, 2, 1, '2025-06-26'),
(3, 3, 1, 9, '2025-06-26');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`docid`, `docemail`, `docname`, `docpassword`, `docnic`, `doctel`, `specialties`) VALUES
(1, 'doctor@gmial.com', 'Test Doctor', '123', '000000000', '0110000000', 1),
(2, 'mgl@gmail.com', 'mingalar', 'mgl12345', 'mgl12345', '0958898987', 24);

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
  `profile_img` varchar(255) DEFAULT '../img/user.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`pid`, `pemail`, `pname`, `ppassword`, `paddress`, `pnic`, `pdob`, `ptel`, `profile_img`) VALUES
(1, 'patient@gmail.com', 'Test Patient', '12345', 'toungoo', '0000000000', '2000-01-01', '0120000000', '../img/user1.png'),
(3, 'mntt@gmail.com', 'minnyi thattant', 'mntt12345', 'street one', 'nic12345', '1998-01-01', '0985554787', '../img/user1.png');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`scheduleid`, `docid`, `title`, `scheduledate`, `scheduletime`, `nop`) VALUES
(1, '1', 'Test Session', '2050-01-01', '18:00:00', 50),
(2, '1', '1', '2025-06-10', '20:36:00', 1),
(3, '1', '12', '2025-06-10', '20:33:00', 1),
(4, '1', '1', '2025-06-10', '12:32:00', 1),
(5, '1', '1', '2025-06-10', '20:35:00', 1),
(6, '1', '12', '2025-06-10', '20:35:00', 1),
(7, '1', '1', '2025-06-24', '20:36:00', 1),
(8, '1', '12', '2025-06-10', '13:33:00', 1),
(9, '2', 'laboratory', '2025-06-28', '13:15:00', 9);

-- --------------------------------------------------------

--
-- Table structure for table `specialties`
--

CREATE TABLE `specialties` (
  `id` int(2) NOT NULL,
  `sname` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `webuser`
--

INSERT INTO `webuser` (`email`, `usertype`) VALUES
('admin@gmail.com', 'a'),
('doctor@gmail.com', 'd'),
('patient@gmail.com', 'p'),
('mntt@gmail.com', 'p'),
('mgl@gmail.com', 'd');

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
  ADD KEY `pid` (`pid`),
  ADD KEY `scheduleid` (`scheduleid`);

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
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `docid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `scheduleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;
