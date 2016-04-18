-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2016 at 06:21 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rega1962`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `userID` int(11) NOT NULL,
  `login` char(25) DEFAULT NULL,
  `firstName` char(25) NOT NULL,
  `lastName` char(25) NOT NULL,
  `password` char(255) NOT NULL,
  `adminLevel` int(11) NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`userID`, `login`, `firstName`, `lastName`, `password`, `adminLevel`) VALUES
(1, 'default', 'Default', 'Admin', 'Nothing!1', 1),
(2, 'David', 'David', 'Regalado', '076de44a836436a86b9ac9b8876e7bb2976a9790fc7618c272ef92eb5d5b2784', 1),
(3, 'Mickey', 'Mickey', 'Mouse', 'Nothing!1', 2),
(4, 'Minni', 'Minnie', 'Mouse', 'Nothing!1', 2);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `custID` int(11) NOT NULL,
  `custFName` char(30) NOT NULL,
  `custLName` char(30) NOT NULL,
  `custAddress` char(30) NOT NULL,
  `custCity` char(30) NOT NULL,
  `custState` char(30) NOT NULL,
  `custZip` char(10) NOT NULL,
  `custPhone` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`custID`, `custFName`, `custLName`, `custAddress`, `custCity`, `custState`, `custZip`, `custPhone`) VALUES
(1, 'Sample', 'Customer', '12345 6th Ave', 'Seattle', 'WA', '98101', '2064561234'),
(2, 'David', 'Regalado', '1672 Doge Ave', 'Detroit', 'MI', '48206', '3130001111'),
(11, 'David', 'Regalado', '1928 i street 2B', 'Lincoln', 'NA', '12345', '1234567890'),
(12, 'David', 'Regalado', '1983 K Street N/A', 'Chicago', 'IL', '09876', '0987654321');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderID` int(11) NOT NULL,
  `dateTimePlaced` date NOT NULL,
  `custID` int(11) NOT NULL,
  `pizzaDesc` char(255) NOT NULL,
  `priceSub` float NOT NULL,
  `tax` float NOT NULL,
  `priceTotal` float NOT NULL,
  `completed` char(1) NOT NULL DEFAULT 'n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderID`, `dateTimePlaced`, `custID`, `pizzaDesc`, `priceSub`, `tax`, `priceTotal`, `completed`) VALUES
(1, '2016-03-05', 1, 'Sample Order 1', 14.24, 1.13, 15.37, 'y'),
(2, '2016-03-06', 2, 'Sample Order2', 24.55, 1.78, 26.33, 'n'),
(18, '2016-03-16', 11, 'Size: large Crust: deep dish Type: Build Your Own Toppings: mushrooms black olives', 11.5, 0.92, 12.42, 'y'),
(19, '2016-03-16', 12, 'Size: small Crust: normal Type: Specialty Toppings: Veggie Lovers: mushrooms, black olives, green peppers, tomatoes, green peppers, onions', 8, 0.64, 8.64, 'n');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userID` (`userID`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`custID`),
  ADD UNIQUE KEY `custID` (`custID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `custID_FK_idx` (`custID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `custID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `custID_FK` FOREIGN KEY (`custID`) REFERENCES `customers` (`custID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
