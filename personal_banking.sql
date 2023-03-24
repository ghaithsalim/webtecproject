-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2023 at 07:18 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `personal_banking`
--

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `bill_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bill_type` varchar(50) NOT NULL,
  `bill_amount` double NOT NULL,
  `bill_due_date` date NOT NULL,
  `automatic_payment` varchar(2) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `payment_status` varchar(2) NOT NULL DEFAULT 'N',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bill_type`
--

CREATE TABLE `bill_type` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill_type`
--

INSERT INTO `bill_type` (`id`, `name`) VALUES
(1, 'Gas'),
(2, 'Water'),
(3, 'Electricity'),
(4, 'Internet');

-- --------------------------------------------------------

--
-- Table structure for table `birthdays`
--

CREATE TABLE `birthdays` (
  `birthday_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `birthday_date` date NOT NULL,
  `created_at` datetime NOT NULL,
  `sending_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chatbot`
--

CREATE TABLE `chatbot` (
  `id` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chatbot`
--

INSERT INTO `chatbot` (`id`, `text`, `action`) VALUES
(1, 'tell me today expense?', 'SELECT ifnull(sum(`amount`),0) as t_amnt FROM `transactions` WHERE `transaction_type`=\'debit\' AND `transaction_date`=curdate() AND `user_id`='),
(2, 'tell me available balance', 'SELECT `balance` FROM `td_account` WHERE `user_id`='),
(3, 'show me my past transactions', 'http://localhost/personal_banking/transaction_report.php'),
(4, 'i’d like to add a family member to my account', 'http://localhost/personal_banking/add_family_member.php');

-- --------------------------------------------------------

--
-- Table structure for table `credit_cards`
--

CREATE TABLE `credit_cards` (
  `card_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `card_number` varchar(16) NOT NULL,
  `card_expiry_date` date NOT NULL,
  `card_cvv` varchar(3) NOT NULL,
  `created_at` datetime NOT NULL,
  `credit_limit` double NOT NULL,
  `available_balance` double NOT NULL,
  `shared_with_family` varchar(2) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `family_members`
--

CREATE TABLE `family_members` (
  `member_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `mobile_number` varchar(20) NOT NULL,
  `privilege_status` varchar(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pending_debts`
--

CREATE TABLE `pending_debts` (
  `debit_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `debit_title` varchar(255) NOT NULL,
  `debit_amount` double NOT NULL,
  `installment_per_month` double NOT NULL,
  `final_date` date NOT NULL,
  `remarks` text NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'automatic',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `td_account`
--

CREATE TABLE `td_account` (
  `id` int(11) NOT NULL,
  `account_no` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `balance` double NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `td_account`
--

INSERT INTO `td_account` (`id`, `account_no`, `user_id`, `balance`, `created_date`, `updated_date`) VALUES
(1, '1678178632736', 1, 0, '2023-03-07 14:43:52', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `td_user`
--

CREATE TABLE `td_user` (
  `id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `mobile_no` varchar(20) NOT NULL,
  `card_stauts` varchar(2) NOT NULL DEFAULT 'Y',
  `password` varchar(20) NOT NULL,
  `user_type` int(11) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'Y',
  `member_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `td_user`
--

INSERT INTO `td_user` (`id`, `user_name`, `full_name`, `dob`, `mobile_no`, `card_stauts`, `password`, `user_type`, `status`, `member_id`) VALUES
(1, 'demo', 'Md Humayun Kabir', '2023-03-07', '1963691532', 'Y', '111', 1, 'Y', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `family_member_id` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `transaction_type` varchar(100) NOT NULL,
  `amount` double NOT NULL,
  `description` varchar(255) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `transactions`
--
DELIMITER $$
CREATE TRIGGER `update_amount` AFTER INSERT ON `transactions` FOR EACH ROW BEGIN
IF (NEW.transaction_type = 'Debit') THEN
            UPDATE `td_account` SET `balance`= `balance` - NEW.amount WHERE `user_id`=NEW.user_id;
      ELSE
            UPDATE `td_account` SET `balance`= `balance` + NEW.amount WHERE `user_id`=NEW.user_id;
      END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `type`) VALUES
(1, 'Account Holder'),
(2, 'Guest User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`bill_id`);

--
-- Indexes for table `bill_type`
--
ALTER TABLE `bill_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `birthdays`
--
ALTER TABLE `birthdays`
  ADD PRIMARY KEY (`birthday_id`);

--
-- Indexes for table `chatbot`
--
ALTER TABLE `chatbot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `family_members`
--
ALTER TABLE `family_members`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `pending_debts`
--
ALTER TABLE `pending_debts`
  ADD PRIMARY KEY (`debit_id`);

--
-- Indexes for table `td_account`
--
ALTER TABLE `td_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `td_user`
--
ALTER TABLE `td_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bill_type`
--
ALTER TABLE `bill_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `birthdays`
--
ALTER TABLE `birthdays`
  MODIFY `birthday_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chatbot`
--
ALTER TABLE `chatbot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `family_members`
--
ALTER TABLE `family_members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pending_debts`
--
ALTER TABLE `pending_debts`
  MODIFY `debit_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `td_account`
--
ALTER TABLE `td_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `td_user`
--
ALTER TABLE `td_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `process_debts` ON SCHEDULE EVERY 1 DAY STARTS '2023-03-06 11:34:36' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
INSERT INTO `transactions`( `user_id`, `transaction_date`, `transaction_type`, `amount`, `description`) SELECT `user_id`,curdate(), 'debit' as t_type, `installment_per_month`, `remarks` FROM `pending_debts` WHERE `payment_status`='automatic' and final_date = curdate();

END$$

CREATE DEFINER=`root`@`localhost` EVENT `process_bills` ON SCHEDULE EVERY 1 DAY STARTS '2023-03-06 00:01:00' ON COMPLETION NOT PRESERVE ENABLE DO Begin

INSERT INTO `transactions`( `user_id`, `transaction_date`, `transaction_type`, `amount`, `description`, `bill_id`) 
SELECT `user_id`, curdate(), 'debit' as t_type, `bill_amount`, `remarks`, `bill_type` FROM `bills` WHERE `bill_due_date` = curdate() and  `automatic_payment`='Y';

END$$

CREATE DEFINER=`root`@`localhost` EVENT `process_birthday` ON SCHEDULE EVERY 1 DAY STARTS '2023-03-06 00:01:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
INSERT INTO `transactions`( `user_id`, `family_member_id`, `transaction_date`, `transaction_type`, `amount`, `description`, `bill_id`, `created_at`) 

SELECT `user_id`, `member_id`, curdate(), 'Debit' as t_type, `amount`, 'Birthday gift process from system' FROM `birthdays` WHERE `sending_type`='Automatic' AND (SELECT concat(Year(curdate()),"-",MONTH(`birthday_date`),"-",DAY(birthday_date)) as date FROM `birthdays` WHERE 1)=curdate();


END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
