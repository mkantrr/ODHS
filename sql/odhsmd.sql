-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 25, 2023 at 05:39 PM
-- Server version: 5.7.39-42-log
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db3dpzjdij5qds`
--

-- --------------------------------------------------------

--
-- Table structure for table `dbEventMedia`
--

CREATE TABLE `dbEventMedia` (
  `id` int(11) NOT NULL,
  `eventID` int(11) NOT NULL,
  `url` text NOT NULL,
  `type` text NOT NULL,
  `format` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `dbEvents`
--

CREATE TABLE `dbEvents` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `abbrevName` text NOT NULL,
  `date` char(10) NOT NULL,
  `startTime` char(5) NOT NULL,
  `endTime` char(5) NOT NULL,
  `description` text NOT NULL,
  `locationID` int NOT NULL,
  `capacity` int(11) NOT NULL,
  `animalID` int(11) NOT NULL,
  `completed` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `dbEventVolunteers`
--

CREATE TABLE `dbEventVolunteers` (
  `eventID` int(11) NOT NULL,
  `userID` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `dbMessages`
--

CREATE TABLE `dbMessages` (
  `id` int(11) NOT NULL,
  `senderID` varchar(256) NOT NULL,
  `recipientID` varchar(256) NOT NULL,
  `title` varchar(256) NOT NULL,
  `body` text NOT NULL,
  `time` varchar(16) NOT NULL,
  `wasRead` tinyint(1) NOT NULL DEFAULT '0',
  `prioritylevel` tinyint(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `dbPersons`
--

CREATE TABLE `dbPersons` (
  `id` varchar(256) CHARACTER SET utf8mb4 NOT NULL,
  `start_date` text,
  `venue` text,
  `first_name` text NOT NULL,
  `last_name` text,
  `address` text,
  `city` text,
  `state` varchar(2) DEFAULT NULL,
  `zip` text,
  `phone1` varchar(12) NOT NULL,
  `phone1type` text,
  `phone2` varchar(12) DEFAULT NULL,
  `phone2type` text,
  `birthday` text,
  `email` text,
  `shirt_size` varchar(3) DEFAULT NULL,
  `computer` varchar(3) DEFAULT NULL,
  `camera` varchar(3) NOT NULL,
  `transportation` varchar(3) NOT NULL,
  `contact_name` text NOT NULL,
  `contact_num` varchar(12) NOT NULL,
  `relation` text NOT NULL,
  `contact_time` text NOT NULL,
  `cMethod` text,
  `position` text,
  `credithours` text,
  `howdidyouhear` text,
  `commitment` text,
  `motivation` text,
  `specialties` text,
  `convictions` text,
  `type` text,
  `status` text,
  `availability` text,
  `schedule` text,
  `hours` text,
  `notes` text,
  `password` text,
  `sundays_start` char(5) DEFAULT NULL,
  `sundays_end` char(5) DEFAULT NULL,
  `mondays_start` char(5) DEFAULT NULL,
  `mondays_end` char(5) DEFAULT NULL,
  `tuesdays_start` char(5) DEFAULT NULL,
  `tuesdays_end` char(5) DEFAULT NULL,
  `wednesdays_start` char(5) DEFAULT NULL,
  `wednesdays_end` char(5) DEFAULT NULL,
  `thursdays_start` char(5) DEFAULT NULL,
  `thursdays_end` char(5) DEFAULT NULL,
  `fridays_start` char(5) DEFAULT NULL,
  `fridays_end` char(5) DEFAULT NULL,
  `saturdays_start` char(5) DEFAULT NULL,
  `saturdays_end` char(5) DEFAULT NULL,
  `profile_pic` text NOT NULL,
  `force_password_change` tinyint(1) NOT NULL,
  `gender` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for 'dbAnimals'
--

-- note that odhs_id is just the id assigned and used by ODHS, not the primary key for the table.
CREATE TABLE `dbAnimals` (
  `id` int(11) NOT NULL,
  `odhs_id` varchar(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `breed` varchar(256),
  `age` int(5) NOT NULL,
  `gender` varchar(6),
  `notes` text,
  `spay_neuter_done` varchar(3) NOT NULL,
  `spay_neuter_date` date,
  `rabies_given_date` date NOT NULL,
  `rabies_due_date` date,
  `heartworm_given_date` date NOT NULL,
  `heartworm_due_date` date,
  `distemper1_given_date` date NOT NULL,
  `distemper1_due_date` date,
  `distemper2_given_date` date NOT NULL,
  `distemper2_due_date` date,
  `distemper3_given_date` date NOT NULL,
  `distemper3_due_date` date,
  `microchip_done` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -------------------------------------------------------
--
-- Table structure for table `dbLocations`
--

CREATE TABLE `dbLocations` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `address` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -------------------------------------------------------
--
-- Table structure for table `dbServices`
--

CREATE TABLE `dbServices` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `type` varchar(256) NOT NULL,
  `duration_years` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -------------------------------------------------------
--
-- Table structure for junction table `dbLocationsServices`
--

CREATE TABLE `dbLocationsServices` (
  `locationID` int(11) NOT NULL,
  `serviceID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -------------------------------------------------------
--
-- Table structure for junction table `dbEventsServices`
--

CREATE TABLE `dbEventsServices` (
  `eventID` int(11) NOT NULL,
  `serviceID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dbPersons`
--

INSERT INTO `dbPersons` (`id`, `start_date`, `venue`, `first_name`, `last_name`, `address`, `city`, `state`, `zip`, `phone1`, `phone1type`, `phone2`, `phone2type`, `birthday`, `email`, `contact_name`, `contact_num`, `relation`, `contact_time`, `cMethod`, `type`, `status`, `hours`, `notes`, `password`, `force_password_change`, `gender`) VALUES
('admin1@admin1.com', '2024-04-18', 'portland', 'admin1', 'admin1', 'admin1', 'admin1', 'VA', '44445', '3333333333', 'work', '', '', '2011-11-11', 'admin1@admin1.com', 'a1', '2222227777', 'Friend', 'Days', 'text', 'admin', 'Active', '', '', '$2y$10$avCY70FHBAq6yc4Lw7KzA.FPCMBkwGa8LScj6/IY3Ik0MXhZRkAdu', 0, 'Female'),
('adoption1@adoption1.com', '2024-04-18', 'portland', 'adoption1', 'adoption1', 'adoption1', 'adoption1', 'VA', '12345', '2222222222', 'work', '', '', '1992-11-22', 'adoption1@adoption1.com', 'adopt1', '2222222220', 'Friend', 'Days', 'text', 'adoption center', 'Active', '', '', '$2y$10$wpD0dVikow97nF.mWaX8aewLx.lyBcFrx/Du/IKW/zqUSKsVq4NIW', 0, 'Male'),
('brianna@gmail.com', '2024-01-22', 'portland', 'Brianna', 'Wahl', '212 Latham Road', 'Mineola', 'VA', '11501', '1234567890', 'cellphone', '', '', '2004-04-04', 'brianna@gmail.com', 'Mom', '1234567890', 'Mother', 'Days', 'text', 'admin', 'Active', '', '', '$2y$10$jNbMmZwq.1r/5/oy61IRkOSX4PY6sxpYEdWfu9tLRZA6m1NgsxD6m', 0, 'Female'),
('bum@gmail.com', '2024-01-24', 'portland', 'bum', 'bum', '1345 Strattford St.', 'Mineola', 'VA', '22401', '1234567890', 'home', '', '', '1111-11-11', 'bum@gmail.com', 'Mom', '1234567890', 'Mom', 'Mornings', 'text', 'admin', 'Active', '', '', '$2y$10$Ps8FnZXT7d4uiU/R5YFnRecIRbRakyVtbXP9TVqp7vVpuB3yTXFIO', 0, 'Male'),
('email@email.com', '2024-04-14', 'portland', 'Niko', 'Toro', '123 Address Street', 'Fredericksburg', 'VA', '22405', '1111111111', 'cellphone', '', '', '2002-01-03', 'email@email.com', 'Gus', '2222222222', 'Gus', 'Evening', 'text', 'volunteer', 'Active', '', '', '$2y$10$XQA5/cvF5FLCjUtg1GuiA.4a9hUIeBGSC9eXQlXylv.W.qpbJ0Z.e', 0, 'Male'),
('main1@main1.com', '2024-04-18', 'portland', 'main1', 'main1', 'main1', 'main1', 'VA', '44444', '4444444444', 'cellphone', '', '', '2012-12-12', 'main1@main1.com', 'm1', '4444444444', 'Friend', 'Days', 'text', 'main', 'Active', '', '', '$2y$10$QyY.AtZqZP0ZbZc49stWa.AebdveU8ZCjyTAjdKlUHMDVg.45mzUC', 0, 'Male'),
('mattkanter1@outlook.com', '2024-04-15', 'portland', 'Matthew', 'Test', '2256 Souverain Lane', 'Virginia Beach', 'VA', '23454', '7576211258', 'cellphone', '', '', '2002-06-30', 'mattkanter1@outlook.com', 'Laura', '7576215005', 'Mother', 'Evenings', 'text', 'admin', 'Active', '', '', '$2y$10$EmBkpa3.9WwIQ./Z/ELXWOY.KbqCcoXaZBLwQnV/HwpvhAWfqdPUO', 0, 'Male'),
('mom@gmail.com', '2024-01-22', 'portland', 'Lorraine', 'Egan', '212 Latham Road', 'Mineola', 'NY', '11501', '5167423832', 'home', '', '', '1910-10-10', 'mom@gmail.com', 'Mom', '5167423832', 'Dead', 'Never', 'phone', 'admin', 'Active', '', '', '$2y$10$of1CkoNXZwyhAMS5GQ.aYuAW1SHptF6z31ONahnF2qK4Y/W9Ty2h2', 0, 'Male'),
('oliver@gmail.com', '2024-01-22', 'portland', 'Oliver', 'Wahl', '1345 Strattford St.', 'Fredericksburg', 'VA', '22401', '1234567890', 'home', '', '', '2011-11-11', 'oliver@gmail.com', 'Mom', '1234567890', 'Mother', 'Middle of the Night', 'text', 'admin', 'Active', '', '', '$2y$10$tgIjMkXhPzdmgGhUgbfPRuXLJVZHLiC0pWQQwOYKx8p8H8XY3eHw6', 0, 'Other'),
('peter@gmail.com', '2024-01-22', 'portland', 'Peter', 'Polack', '1345 Strattford St.', 'Mineola', 'VA', '12345', '1234567890', 'cellphone', '', '', '1968-09-09', 'peter@gmail.com', 'Mom', '1234567890', 'Mom', 'Don&amp;amp;#039;t Call or Text or Email', 'email', 'admin', 'Active', '', '', '$2y$10$j5xJ6GWaBhnb45aktS.kruk05u./TsAhEoCI3VRlNs0SRGrIqz.B6', 0, 'Male'),
('polack@um.edu', '2024-01-22', 'portland', 'Jennifer', 'Polack', '15 Wallace Farms Lane', 'Fredericksburg', 'VA', '22406', '1234567890', 'cellphone', '', '', '1970-05-01', 'polack@um.edu', 'Mom', '1234567890', 'Mom', 'Days', 'email', 'admin', 'Active', '', '', '$2y$10$mp18j4WqhlQo7MTeS/9kt.i08n7nbt0YMuRoAxtAy52BlinqPUE4C', 0, 'Female'),
('test@email.com', '2024-04-15', 'portland', 'Niko', 'Toro', '123 Address Street', 'Fredericksburg', 'VA', '22405', '1111111111', 'cellphone', '', '', '2002-01-03', 'test@email.com', 'Gus', '2222222222', 'Gus', 'Evening', 'text', 'volunteer', 'Active', '', '', '$2y$10$4JqWcanNbAhf7RlHAauJe.jKQRFwfpjhCI9yW9go99uw6QB0MpjsS', 0, 'Male'),
('test@gmail.com', '2024-03-12', 'portland', 'test', 'test', '222 street st', 'Glen Allen', 'VA', '23060', '8049722694', 'home', '', '', '2002-02-02', 'test@gmail.com', 'test', '5555555555', 'mother', 'Evenings', 'email', 'admin', 'Active', '', '', '$2y$10$YGwdc9O9oTmudu9/XpVmoudB/.GH4HswC2pKycPcX6RyprReNYLs2', 0, 'Male'),
('test@odhs.vms', '2024-04-01', 'portland', 'test', 'test', '1701 College Avenue', 'Fredericksburg', 'VA', '22401', '5555555555', 'cellphone', '', '', '2001-01-01', 'test@odhs.vms', 'test', '5555555555', 'Friend', 'Evenings', 'phone', 'main', 'Active', '', '', '$2y$10$M9HO4wJmq808TQiagd8sueNzWXYFwzjej8sdeQpZWTBlkHmsU4YSi', 0, 'Male'),
('tom@gmail.com', '2024-01-22', 'portland', 'tom', 'tom', '1345 Strattford St.', 'Mineola', 'NY', '12345', '1234567890', 'home', '', '', '1920-02-02', 'tom@gmail.com', 'Dad', '9876543210', 'Father', 'Mornings', 'phone', 'admin', 'Active', '', '', '$2y$10$1Zcj7n/prdkNxZjxTK1zUOF7391byZvsXkJcN8S8aZL57sz/OfxP.', 0, 'Male'),
('v1@v1.com', '2024-04-14', 'portland', 'v1', 'v1', 'v1', 'v1', 'VA', '12345', '1231231234', 'cellphone', '', '', '1991-11-11', 'v1@v1.com', 'a', '1231231233', 'Friend', 'Days', 'phone', 'volunteer', 'Active', '', '', '$2y$10$BU.8ezWJPJyCR3FzOQTpl.9LLM0kTGXIe8F0ApU.AwBdO7y9U69Ym', 0, 'Male'),
('vmsroot', 'N/A', 'portland', 'vmsroot', '', 'N/A', 'N/A', 'VA', 'N/A', '', 'N/A', 'N/A', 'N/A', 'N/A', 'vmsroot', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', 'N/A', 'N/A', 'N/A', '$2y$10$.3p8xvmUqmxNztEzMJQRBesLDwdiRU3xnt/HOcJtsglwsbUk88VTO', 0, ''),
('volunteer@gmail.com', '2024-04-18', 'portland', 'volunteer', 'test', '1 Street St', 'Fredericksburg', 'VA', '22401', '8049722694', 'cellphone', '', '', '2002-04-18', 'volunteer@gmail.com', 'John D Leitch', '8049722694', 'Me', 'Evenings', 'text', 'volunteer', 'Active', '', '', '$2y$10$Ej1OXPwuZ99dApYlBif5tuffNbeQ9qfxgCuO8HMJuBsdHGNoERxPu', 0, 'Male');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dbEventMedia`
--
ALTER TABLE `dbEventMedia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKeventID2` (`eventID`);

--
-- Indexes for table `dbEvents`
--
ALTER TABLE `dbEvents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKanimalID` (`animalID`),
  ADD KEY `FKlocationID` (`locationID`);

--
-- Indexes for table `dbLocations`
--
ALTER TABLE `dbLocations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbServices`
--
ALTER TABLE `dbServices`
  ADD PRIMARY KEY (`id`);


--
-- Indexes for table `dbEventVolunteers`
--
ALTER TABLE `dbEventVolunteers`
  ADD KEY `FKeventID` (`eventID`),
  ADD KEY `FKpersonID` (`userID`);

--
-- Indexes for table `dbMessages`
--
ALTER TABLE `dbMessages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbPersons`
--
ALTER TABLE `dbPersons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbAnimals`
--
ALTER TABLE `dbAnimals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbLocationsServices`
--
ALTER TABLE `dbLocationsServices`
  ADD PRIMARY KEY (`locationID`, `serviceID`);

--
-- Indexes for table `dbEventsServices`
--
ALTER TABLE `dbEventsServices`
  ADD PRIMARY KEY (`eventID`, `serviceID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dbEventMedia`
--
ALTER TABLE `dbEventMedia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbLocations`
--
ALTER TABLE `dbLocations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbServices`
--
ALTER TABLE `dbServices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbEvents`
--
ALTER TABLE `dbEvents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbMessages`
--
ALTER TABLE `dbMessages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbAnimals`
--
ALTER TABLE `dbAnimals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dbEventMedia`
--
ALTER TABLE `dbEventMedia`
  ADD CONSTRAINT `FKeventID2` FOREIGN KEY (`eventID`) REFERENCES `dbEvents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dbEvents`
--
ALTER TABLE `dbEvents`
  ADD CONSTRAINT `FKanimalID` FOREIGN KEY (`animalID`) REFERENCES `dbAnimals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FKlocationID` FOREIGN KEY (`locationID`) REFERENCES `dbLocations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dbLocationsServices`
--
ALTER TABLE `dbLocationsServices`
  ADD CONSTRAINT `FKlocationID2` FOREIGN KEY (`locationID`) REFERENCES `dbLocations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FKserviceID2` FOREIGN KEY (`serviceID`) REFERENCES `dbServices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dbEventsServices`
--
ALTER TABLE `dbEventsServices`
  ADD CONSTRAINT `FKEventID3` FOREIGN KEY (`eventID`) REFERENCES `dbEvents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FKserviceID3` FOREIGN KEY (`serviceID`) REFERENCES `dbServices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dbEventVolunteers`
--
ALTER TABLE `dbEventVolunteers`
  ADD CONSTRAINT `FKeventID` FOREIGN KEY (`eventID`) REFERENCES `dbEvents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FKpersonID` FOREIGN KEY (`userID`) REFERENCES `dbPersons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
