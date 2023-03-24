-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2023 at 06:13 AM
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
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`bill_id`, `user_id`, `bill_type`, `bill_amount`, `bill_due_date`, `automatic_payment`, `remarks`, `created_at`) VALUES
(2, 1, '2', 80, '0000-00-00', 'N', 'test', '0000-00-00 00:00:00');

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
  `shared_with_family` varchar(2) NOT NULL
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

--
-- Dumping data for table `family_members`
--

INSERT INTO `family_members` (`member_id`, `user_id`, `username`, `full_name`, `date_of_birth`, `mobile_number`, `privilege_status`, `created_at`, `status`) VALUES
(1, 1, '333', 'test', '2023-03-17', '1737503799', '0', '0000-00-00 00:00:00', 'Y');

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
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pending_debts`
--

INSERT INTO `pending_debts` (`debit_id`, `user_id`, `debit_title`, `debit_amount`, `installment_per_month`, `final_date`, `remarks`, `created_at`) VALUES
(3, 1, 'test2sds', 6000, 60, '2023-03-09', 'test2sd', '2023-03-01 07:18:23');

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
(1, '1677375428612', 1, 88, '2023-02-26 07:37:08', '2023-02-28 21:15:16');

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
  `card_stauts` varchar(2) NOT NULL,
  `password` varchar(20) NOT NULL,
  `user_type` int(11) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'Y',
  `member_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `td_user`
--

INSERT INTO `td_user` (`id`, `user_name`, `full_name`, `dob`, `mobile_no`, `card_stauts`, `password`, `user_type`, `status`, `member_id`) VALUES
(1, 'demo', 'Md. Humayun Kabir', '1991-11-18', '1963691532', 'Y', '111', 1, 'Y', 0),
(2, '333', '333', '2023-03-17', '1737503799', '', '111', 2, 'Y', 0);

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
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `user_id`, `family_member_id`, `transaction_date`, `transaction_type`, `amount`, `description`, `bill_id`, `created_at`) VALUES
(1, 1, 0, '2023-02-28', 'Debit', 12, 'test', 1, '2023-02-28 21:14:09'),
(2, 1, 0, '2023-02-28', 'Debit', 12, 'test', 1, '2023-02-28 21:14:09');

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
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bill_type`
--
ALTER TABLE `bill_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `birthdays`
--
ALTER TABLE `birthdays`
  MODIFY `birthday_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `family_members`
--
ALTER TABLE `family_members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pending_debts`
--
ALTER TABLE `pending_debts`
  MODIFY `debit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `td_account`
--
ALTER TABLE `td_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `td_user`
--
ALTER TABLE `td_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
