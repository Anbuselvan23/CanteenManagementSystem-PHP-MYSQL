-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql201.epizy.com
-- Generation Time: May 16, 2023 at 09:53 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `canteen_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` varchar(10) NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `number` int(10) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `password` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `number`, `gender`, `password`) VALUES
('admin#1111', 'anbu selvan', 834236754, 'male', 12345);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `user_id` int(100) NOT NULL,
  `id` int(10) NOT NULL,
  `name` varchar(225) NOT NULL,
  `price` varchar(225) NOT NULL,
  `quantity` int(225) NOT NULL,
  `category` varchar(225) NOT NULL,
  `stocks` int(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`user_id`, `id`, `name`, `price`, `quantity`, `category`, `stocks`) VALUES
(69, 241, 'chicken nugget', '20', 1, 'non-veg', 30);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `date` date NOT NULL DEFAULT current_timestamp(),
  `time` time NOT NULL DEFAULT current_timestamp(),
  `order_id` int(10) NOT NULL,
  `user_id` int(100) NOT NULL,
  `user_name` varchar(225) NOT NULL,
  `number` varchar(10) NOT NULL,
  `department` varchar(225) NOT NULL,
  `total_products` varchar(300) NOT NULL,
  `total_price` int(50) NOT NULL,
  `payment_mode` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`date`, `time`, `order_id`, `user_id`, `user_name`, `number`, `department`, `total_products`, `total_price`, `payment_mode`) VALUES
('2023-05-08', '01:10:32', 65, 143, 'ramesh', '2147483647', 'csc', 'briyani (1) ', 150, 'paypal'),
('2023-05-08', '02:01:03', 66, 143, 'ramesh', '2147483647', 'csc', 'samosa (1) ', 10, 'cash on delivery'),
('2023-05-10', '14:19:45', 67, 143, 'ramesh', '2147483647', 'csc', 'chicken 65 (2) , chicken noodles (1) , briyani (1) ', 350, 'cash on delivery');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(225) NOT NULL,
  `name` varchar(225) NOT NULL,
  `price` varchar(225) NOT NULL,
  `stocks` varchar(225) NOT NULL,
  `image` varchar(225) NOT NULL,
  `category` varchar(225) NOT NULL,
  `visibility` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `stocks`, `image`, `category`, `visibility`) VALUES
(231, 'briyani', '150', '50', '6422858bbde2a.jpg', 'non-veg', 0),
(232, 'chicken fired rice', '100', '80', '64328219724df.jpg', 'non-veg', 1),
(235, 'dosa', '40', '40', 'dosa.jpg', 'veg', 1),
(236, 'Sambar Rice', '50', '50', 'sambar rice.jpg', 'veg', 1),
(238, 'samosa', '10', '35', 'samosa.jpg', 'veg', 1),
(239, 'chicken noodles', '90', '30', 'chicken noodles.jpg', 'non-veg', 1),
(240, 'chicken 65', '55', '25', 'chicken 65.jpg', 'non-veg', 1),
(241, 'chicken nugget', '20', '30', 'chicken nugget.jpg', 'non-veg', 1),
(243, 'poori masala', '30', '50', 'poori.jpg', 'veg', 1),
(244, 'veg meals', '60', '50', 'veg meals.jpg', 'veg', 1),
(246, 'kurkure (orange)', '10', '60', 'kurkure (orange).jpg', 'snacks', 0),
(247, 'kurkure (green) ', '10', '50', 'kurkure (green).jpg', 'snacks', 1),
(248, 'lays (blue)', '10', '40', '64327ebd45f90.jpg', 'snacks', 1),
(249, 'lays (green)', '10', '30', 'lays (green).jpg', 'snacks', 1),
(250, 'choki choki (1pc)', '2', '50', 'choki choki.jpg', 'snacks', 1),
(251, 'cappuccino', '40', '70', 'cappuccino.jpg', 'beverages', 1),
(252, 'coffee', '15', '50', 'coffee.jpg', 'beverages', 1),
(253, 'Green tea', '20', '30', 'GREEN TEA.jpg', 'beverages', 1),
(254, 'Dairy Milk ', '20', '40', 'dairy milk.jpg', 'snacks', 1),
(256, 'tea', '10', '60', 'TEA.jpg', 'beverages', 1),
(257, 'frooti', '10', '40', 'frooti.jpg', 'beverages', 1),
(258, 'CHOCOLATE MILKSHAKE', '35', '40', 'cavin milkshake (chocolate).jpg', 'beverages', 1),
(259, 'sting 250ml', '20', '80', 'sting 250 ml.jpg', 'beverages', 1),
(260, 'sprite tin 300ml', '40', '30', 'sprite tin 300l ml.jpg', 'beverages', 1),
(261, 'snickers', '20', '30', 'snickers.jpg', 'snacks', 1),
(262, '5 star', '10', '30', '5 star.jpg', 'snacks', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(10) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `number` int(10) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `department` varchar(100) NOT NULL,
  `password` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `number`, `gender`, `department`, `password`) VALUES
(0, 'HACKER GOKUL', 2147483647, 'female', 'cyber crime', 123456),
(67, 'User67', 2147483647, 'male', 'Bsc cs', 67),
(69, 'jhonny', 2147483647, 'other', 'food', 0),
(100, 'logan', 2147483647, 'male', 'Bsc cs', 0),
(143, 'ramesh', 2147483647, 'male', 'csc', 143),
(1987, 'Arun', 732569128, 'male', 'None', 0),
(2012, '<h6>bingbot</h6>', 964578931, 'male', 'Mech', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(225) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=304;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
