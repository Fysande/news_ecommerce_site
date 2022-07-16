-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2022 at 10:35 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `customer_subscription_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `email`, `password`, `created_at`) VALUES
(4, 'Fyson Sande', 'admin@email.com', '$2y$04$CR7Ilbqo.BBOGp7LKZlPUezhMDCNpByXk8pQogMIdIbtsL8If5NFK', '2022-07-16');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `location` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `created_at` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `firstname`, `lastname`, `username`, `email`, `location`, `password`, `created_at`) VALUES
(38, 'Penjani', 'Kabambe', 'Penjani', 'penja@email.com', 'Zomba', '$2y$04$ZRLjvHr1BWFEdOKJH2PKZeitqSHSgmKX76arpY9c.MQ7bNYwzw9Ga', '2022-07-16');

-- --------------------------------------------------------

--
-- Table structure for table `digital_news`
--

CREATE TABLE `digital_news` (
  `news_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `company` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `news_date` date NOT NULL,
  `date_added` date NOT NULL,
  `requests` int(11) NOT NULL,
  `image` text NOT NULL,
  `pdf` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `digital_news`
--

INSERT INTO `digital_news` (`news_id`, `title`, `company`, `description`, `news_date`, `date_added`, `requests`, `image`, `pdf`) VALUES
(28, 'Daily NewsPaper', 'Timati Newspaper', 'This is news from Timati Movement. It contains stories about polits, sports and Entertainment', '2022-07-15', '2022-07-16', 0, 'download.jpg', ''),
(29, 'Weekly Times', 'Timati Movement', 'This is news from Timati Movement. It contains stories about polits, sports and Entertainment', '2022-07-17', '2022-07-16', 0, 'business-newspaper-on-wooden-background-260nw-381840133.jpg', ''),
(30, 'Sunday News', 'Timati Movement', 'This is news from Timati Movement. It contains stories about polits, sports and Entertainment', '2022-07-09', '2022-07-16', 0, 'download.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `date_paid` date NOT NULL,
  `expire_date` date NOT NULL,
  `package_name` varchar(25) NOT NULL,
  `mode` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `customer_id`, `amount`, `date_paid`, `expire_date`, `package_name`, `mode`) VALUES
(14, 2, 8, '2022-05-01', '2021-11-01', '6 Months', 'paypal'),
(15, 2, 5, '2022-05-01', '2020-08-01', '3 Months', 'paypal'),
(16, 2, 5, '2022-05-01', '2022-08-01', '3 Months', 'paypal'),
(17, 10, 8, '2022-05-04', '2022-11-04', '6 Months', 'paypal'),
(18, 11, 5, '2022-05-04', '2022-08-04', '3 Months', 'paypal'),
(19, 12, 5, '2022-05-04', '2022-08-04', '3 Months', 'paypal'),
(20, 13, 8, '2022-05-04', '2022-11-04', '6 Months', 'paypal'),
(21, 14, 8, '2022-05-04', '2022-11-04', '6 Months', 'paypal'),
(22, 15, 5, '2022-05-04', '2022-08-04', '3 Months', 'paypal'),
(23, 16, 8, '2022-05-05', '2022-11-05', '6 Months', 'paypal'),
(24, 18, 2.5, '2022-05-05', '2022-06-05', '1 Month', 'paypal'),
(27, 34, 8, '2022-05-12', '2022-11-12', '6 Months', 'paypal'),
(28, 1, 5000, '2022-06-01', '2022-06-16', '1 Month', 'paypal');

-- --------------------------------------------------------

--
-- Table structure for table `price`
--

CREATE TABLE `price` (
  `price_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `price`
--

INSERT INTO `price` (`price_id`, `date`, `price`) VALUES
(1, '2022-06-14', 900);

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `report_id` int(11) NOT NULL,
  `report_date` date NOT NULL,
  `subscriptions` int(11) NOT NULL,
  `requests` int(11) NOT NULL,
  `sales` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`report_id`, `report_date`, `subscriptions`, `requests`, `sales`) VALUES
(2, '2022-06-14', 4, 2, 5),
(3, '2022-05-10', 0, 9, 0),
(4, '2022-05-09', 5, 5, 7),
(5, '2022-05-08', 3, 3, 4),
(6, '2022-05-06', 7, 10, 8),
(7, '2022-05-05', 7, 11, 8),
(8, '2022-05-04', 1, 12, 5),
(9, '2022-05-12', 2, 11, 0),
(10, '2022-05-17', 4, 5, 4),
(11, '2022-05-18', 5, 8, 12),
(12, '2022-05-19', 7, 9, 12),
(13, '2022-05-20', 0, 0, 9),
(14, '2022-05-21', 0, 0, 12),
(15, '2022-05-22', 14, 19, 4),
(16, '2022-06-10', 0, 3, 0),
(18, '2022-06-15', 0, 5, 10),
(19, '2022-07-16', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `request_id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `request_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`request_id`, `news_id`, `customer_id`, `request_date`) VALUES
(1, 2, 34, '2022-05-12'),
(2, 1, 34, '2022-05-12'),
(3, 1, 1, '2022-05-05'),
(4, 2, 1, '2022-05-06'),
(5, 1, 1, '2022-05-07'),
(6, 1, 1, '2022-05-08'),
(7, 1, 1, '2022-05-09'),
(8, 1, 1, '2022-05-10'),
(9, 1, 1, '2022-05-11'),
(10, 1, 1, '2022-05-12'),
(11, 1, 1, '2022-05-12'),
(12, 1, 1, '2022-05-06'),
(13, 3, 34, '2022-05-12'),
(14, 3, 34, '2022-05-12'),
(15, 3, 34, '2022-05-12'),
(16, 3, 34, '2022-05-12'),
(17, 2, 34, '2022-05-12'),
(18, 1, 34, '2022-05-12'),
(19, 2, 34, '2022-05-12'),
(20, 2, 34, '2022-06-10'),
(21, 2, 34, '2022-06-10'),
(22, 3, 34, '2022-06-10'),
(23, 27, 34, '2022-06-15'),
(24, 27, 34, '2022-06-15'),
(25, 27, 34, '2022-06-15'),
(26, 27, 34, '2022-06-15'),
(27, 27, 34, '2022-06-15'),
(28, 1, 34, '2022-07-16');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `sales_date` date NOT NULL,
  `news_sold` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_id`, `vendor_id`, `sales_date`, `news_sold`) VALUES
(1, 1, '2022-05-02', 0),
(2, 1, '2022-05-03', 0),
(3, 1, '2022-05-04', 0),
(4, 1, '2022-05-05', 0),
(5, 1, '2022-05-07', 0),
(6, 1, '2022-05-08', 0),
(7, 1, '2022-05-08', 0),
(8, 1, '2022-05-09', 0),
(9, 1, '2022-05-11', 0),
(10, 1, '2022-05-11', 0),
(11, 1, '2022-05-12', 0),
(12, 1, '2022-05-05', 0),
(13, 6, '2022-05-25', 2),
(14, 6, '2022-06-01', 5),
(21, 9, '2022-06-02', 150),
(22, 9, '2022-06-02', 30),
(23, 9, '2022-06-02', 8),
(24, 9, '2022-06-02', 2),
(25, 9, '2022-06-02', 5),
(26, 9, '2022-06-02', 5),
(27, 9, '2022-06-02', 5),
(28, 9, '2022-06-02', 6),
(29, 9, '2022-06-02', 6),
(30, 9, '2022-06-02', 6),
(31, 9, '2022-06-14', 5),
(32, 9, '2022-06-14', 5),
(33, 9, '2022-06-14', 5),
(34, 9, '2022-06-14', 1),
(35, 9, '2022-06-14', 1),
(36, 9, '2022-06-14', 40),
(37, 9, '2022-06-14', 5),
(38, 9, '2022-06-14', 2),
(39, 9, '2022-06-14', 2),
(40, 9, '2022-06-14', 1),
(41, 9, '2022-06-14', 12),
(42, 9, '2022-06-14', 12),
(43, 9, '2022-06-14', 2),
(44, 9, '2022-06-14', 2),
(45, 9, '2022-06-14', 2),
(46, 9, '2022-06-14', 2),
(47, 9, '2022-06-14', 106),
(48, 9, '2022-06-15', 12),
(49, 9, '2022-06-15', 10),
(50, 9, '2022-06-15', 10);

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendor_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `location` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`vendor_id`, `name`, `email`, `location`, `password`, `created_at`) VALUES
(1, 'DanLu Fan', 'danlu@gmail.com', 'Kubangwe@bt', '$2y$04$HD6flLng1Qqn2ORF0RK8/OfxDtro6yLVLf9ZRfv5u7w.z6TtWfWia', '2022-05-12'),
(2, 'Saint Yamikani', 'saint@mw.com', 'Blantyre', '$2y$04$41C2eJM2mgWchJYoGvmHOu022598MWRqkNs7OaG4xn0DISH4jZfKW', '2022-05-12'),
(3, 'DanLu Fan', 'ale@ale.ale', 'Blantyre', '$2y$04$6HpY7l9TUqZtbQvus3OHFeTKFiv8S3NGEDHDq7g22Nv0NtaozP5vy', '2022-05-12'),
(4, 'DanLu Fan', 'ale@ale.alem', 'Blantyre', '$2y$04$btZozx9EvTdn4ef7FiwjxOzRP3Twxv3LgswfPp1a/AomzUC.M9BZS', '2022-05-12'),
(5, 'Kaya Ndani', 'danlu@gmail.comm', 'Kasungu', '$2y$04$5ny7RD5npNZGMbQDRKOeEeYzgfcBqJS.E/6Mg/akGve4oTmQxqaw6', '2022-05-12'),
(6, 'Sonyezo Matenda', 'sonye@gmail.com', 'Lilongwe', '$2y$04$/H8ipix0caz/mQm1bbfm6u4wmkDAos6SH893Bo/M3h0CWKftfDjKi', '2022-05-24'),
(7, 'Looking Good', 'badman@gmail.com', 'Mzimba', '$2y$04$0hN4mWQ8tE.58WQr00Z55uOiCBaoxA7tEu0i/CMkSkBxejQsmNT3W', '2022-05-29'),
(8, 'Theo Thomson', 'do@gmail.com', 'Zomba', '$2y$04$Kd4JeF0rfqeiHO6E3HFpKOR6q43iihLNzojr8qBw2z489pXxMTXq.', '2022-05-29'),
(9, 'Esau Kanyenda', 'esau@gmail.com', 'Lilongwe', '$2y$04$nkag7QizmJpNu2BNnJS2bOEwxb0kTVF6XVUUWFPrXsPURNLcCe76C', '2022-06-02');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_news`
--

CREATE TABLE `vendor_news` (
  `news_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `date_supplied` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vendor_news`
--

INSERT INTO `vendor_news` (`news_id`, `quantity`, `vendor_id`, `date_supplied`) VALUES
(1, 100, 1, '0000-00-00'),
(2, 100, 1, '0000-00-00'),
(3, 100, 1, '0000-00-00'),
(4, 100, 1, '0000-00-00'),
(5, 100, 1, '2022-05-12'),
(6, 3, 2, '2022-05-16'),
(7, 4, 2, '2022-05-02'),
(8, 2, 6, '2022-05-25'),
(9, 50, 9, '2022-06-02'),
(10, 100, 9, '2022-06-02'),
(11, 20, 9, '2022-06-02'),
(12, 20, 9, '2022-06-02'),
(13, 50, 9, '2022-06-02'),
(14, 50, 9, '2022-06-14'),
(15, 1000000000, 9, '2022-06-14');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_sales`
--

CREATE TABLE `vendor_sales` (
  `sales_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `sales` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vendor_sales`
--

INSERT INTO `vendor_sales` (`sales_id`, `date`, `vendor_id`, `sales`, `price`) VALUES
(1, '2022-06-14', 9, 24, 0),
(2, '2022-06-13', 9, 30, 0),
(3, '2022-06-12', 9, 45, 0),
(4, '2022-06-11', 9, 43, 0),
(5, '2022-06-10', 9, 49, 0),
(6, '2022-06-09', 9, 45, 0),
(7, '2022-06-08', 9, 40, 0),
(8, '2022-06-07', 9, 39, 0),
(11, '2022-06-14', 9, 40, 800),
(12, '2022-06-14', 9, 5, 900),
(13, '2022-06-14', 9, 2, 900),
(14, '2022-06-14', 9, 2, 900),
(15, '2022-06-14', 9, 1, 900),
(16, '2022-06-14', 9, 12, 900),
(17, '2022-06-14', 9, 12, 900),
(18, '2022-06-14', 9, 2, 900),
(19, '2022-06-14', 9, 2, 900),
(20, '2022-06-14', 9, 2, 900),
(21, '2022-06-14', 9, 2, 900),
(22, '2022-06-14', 9, 106, 900),
(23, '2022-06-15', 9, 12, 900),
(24, '2022-06-15', 9, 10, 900),
(25, '2022-06-15', 9, 10, 900);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `digital_news`
--
ALTER TABLE `digital_news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `price`
--
ALTER TABLE `price`
  ADD PRIMARY KEY (`price_id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sales_id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendor_id`);

--
-- Indexes for table `vendor_news`
--
ALTER TABLE `vendor_news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `vendor_sales`
--
ALTER TABLE `vendor_sales`
  ADD PRIMARY KEY (`sales_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `digital_news`
--
ALTER TABLE `digital_news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `price`
--
ALTER TABLE `price`
  MODIFY `price_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `vendor_news`
--
ALTER TABLE `vendor_news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `vendor_sales`
--
ALTER TABLE `vendor_sales`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
