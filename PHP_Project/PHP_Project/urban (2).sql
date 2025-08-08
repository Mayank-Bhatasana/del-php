-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 26, 2025 at 08:05 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `urban`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `id` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `additional_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`id`, `image`, `title`, `subtitle`, `content`, `additional_content`) VALUES
(1, 'about-img.jpg', 'Welcome to our shop', 'We make your home more astonishing', 'Established in 1991 out of a desire to bring a unique customer-oriented approach to the contract marketplace, we design durable, elegant furniture that excels at meeting all core requirements. Combined with a huge array of options, choices, price points, and scales, our customers can specify the best possible solution.', 'We are recognized as a market leader in the quality, design, and engineering of contract furniture products...');

-- --------------------------------------------------------

--
-- Table structure for table `about_ad`
--

CREATE TABLE `about_ad` (
  `id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `content` text,
  `additional_content` text,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;

--
-- Dumping data for table `about_ad`
--

INSERT INTO `about_ad` (`id`, `title`, `subtitle`, `content`, `additional_content`, `image`) VALUES
(1, 'Welcome to our shop', 'We make your home more astonishing', 'Established in 1991 out of a desire to bring a unique customer-oriented approach to the contract marketplace, we design durable, elegant furniture that excels at meeting all core requirements. Combined with a huge array of options, choices, price points, and scales, our customers can specify the best possible solution.', 'We are recognized as a market leader in the quality, design, and engineering of contract furniture products...', 'about-img.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `profile_picture` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `firstname`, `lastname`, `email`, `profile_picture`) VALUES
(1, 'Tanmay', 'Raval', 'TanmayPawar@gmail.com', '1742283480_team-2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `discount` varchar(50) NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `image`, `title`, `discount`, `link`) VALUES
(1, 'img/banner-1.jpg', 'Limited Offer', 'upto 50% off', 'shop.php'),
(2, 'img/banner-2.jpg', 'Limited Offer', 'upto 50% off', 'shop.php'),
(3, 'img/banner-3.jpg', 'Limited Offer', 'upto 50% off', 'shop.php');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `link` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `author` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `image`, `title`, `description`, `link`, `date`, `author`) VALUES
(1, 'blog-1.jpg', 'Elegant Outdoor Comfort', 'A Perfect Blend of Wood & Modern Design from Urban Furniture.', '#', '2023-05-21', 'admin'),
(2, 'blog-3.jpg', 'Luxury in Simplicity', 'A Modern Freestanding Bathtub with Elegant Circular Mirrors.', '#', '2023-05-21', 'admin'),
(3, 'blog-4.jpg', 'Modern Elegance', 'A Stylish Living Room Setup with a Sleek TV Unit and Cozy Seating.', '#', '2023-05-21', 'admin'),
(4, 'blog-5.jpg', 'Relax in Style', 'Handcrafted Wooden Lounge Chair for a Perfect Outdoor Escape.', '#', '2023-05-21', 'admin'),
(5, 'blog-6.jpg', 'Elegant Minimalist Sofa', 'A Perfect Blend of Comfort and Modern Aesthetics.', '#', '2023-05-21', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  `discount` int NOT NULL,
  `rating` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `image`, `product_id`, `product_name`, `price`, `quantity`, `discount`, `rating`) VALUES
(1, 'product-1.png', '56051', 'Chair', 80.00, 20, 10, 4.5),
(2, 'product-5.png', '56052', 'Sofa', 180.00, 12, 25, 5),
(3, 'product-3.png', '56053', 'Corner Table', 820.00, 23, 15, 4),
(4, 'product-7.png', '56054', 'Working Table', 500.00, 20, 10, 4.2),
(5, 'product-9.png', '56055', 'Wardrobe', 300.00, 5, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image_path`, `link`) VALUES
(1, 'House Sofa', 'img/icon-1.png', 'category.php?cat=house-sofa'),
(2, 'Working Table', 'img/icon-2.png', 'category.php?cat=working-table'),
(3, 'Corner Table', 'img/icon-3.png', 'category.php?cat=corner-table'),
(4, 'Chair', 'img/icon-4.png', 'category.php?cat=office-chair'),
(5, 'New Wardrobe', 'img/icon-5.png', 'category.php?cat=new-wardrobe');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `phone`, `email`, `message`, `submitted_at`) VALUES
(1, 'Akshar', '8153031595', 'AksharKhunt@gmail.com', 'Hi,\r\nI am Akshar', '2025-03-19 13:04:41'),
(2, 'Pranshu', '8153031594', 'pranshubabariya@gmail.com', 'Hi,\r\nI am Pranshu', '2025-03-19 13:05:22');

-- --------------------------------------------------------

--
-- Table structure for table `dropd`
--

CREATE TABLE `dropd` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `link` varchar(50) NOT NULL,
  `order_no` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;

--
-- Dumping data for table `dropd`
--

INSERT INTO `dropd` (`id`, `name`, `link`, `order_no`) VALUES
(1, 'My Profile', 'profile.php', 1),
(2, 'My Orders', 'order.php', 2),
(3, 'Wishlist', 'wish.php', 3),
(4, 'Change Password', 'change.php', 4),
(5, 'Logout', '../login.php', 5);

-- --------------------------------------------------------

--
-- Table structure for table `furniture`
--

CREATE TABLE `furniture` (
  `id` varchar(250) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `Status` varchar(250) NOT NULL DEFAULT 'Active',
  `role` char(10) NOT NULL DEFAULT 'User',
  `profile_pic` varchar(255) NOT NULL,
  `lastname` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;

--
-- Dumping data for table `furniture`
--

INSERT INTO `furniture` (`id`, `firstname`, `email`, `password`, `Status`, `role`, `profile_pic`, `lastname`) VALUES
('1', 'Tanmay', 'Tanmaypawar@gmail.com', 'Tanmay@123', 'Active', 'Admin', 'team-2.jpg', 'Pawar'),
('2', 'Akshar', 'akhunt016@rku.ac.in', 'Akshar@123', 'Active', 'User', 'team-2.jpg', 'Patel'),
('3', 'Pranshu', 'pranshubabariya@gmail.com', 'Pranshu@123', 'Active', 'User', 'team-2.jpg', 'Babariya'),
('4', 'Jigar', 'jsarvaiya788@rku.ac.in', 'Jigar@789', 'Active', 'User', 'team-4.jpg', 'Sarvaiya');

-- --------------------------------------------------------

--
-- Table structure for table `navigation`
--

CREATE TABLE `navigation` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `order_no` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;

--
-- Dumping data for table `navigation`
--

INSERT INTO `navigation` (`id`, `name`, `link`, `order_no`) VALUES
(1, 'Home', 'home.php', 1),
(2, 'Shop', 'shop.php', 2),
(3, 'About Us', 'about.php', 3),
(5, 'Blog', 'blog.php', 5),
(6, 'Contact Us', 'contact.php', 6);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `order_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `customer` varchar(255) NOT NULL,
  `status` enum('Pending','Delivered','Cancelled') NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `product_name`, `product_id`, `quantity`, `price`, `order_time`, `customer`, `status`, `image`) VALUES
(4, 'Sofa', '123', 5, 5520.00, '2025-03-14 17:45:00', 'Akshar P Khunt', 'Cancelled', 'uploads/1742634707_blog-2.jpg'),
(5, 'Chair', '123', 55, 5520.00, '2025-03-20 18:50:00', 'Akshar P Khunt', 'Pending', 'uploads/1742634997_home-img-2.png'),
(6, 'Table', '1234', 5, 5000.00, '2025-03-19 20:00:00', 'Pranshu V Babariya', 'Cancelled', 'uploads/1742635635_about-img.jpg'),
(7, 'Sofa', '123', 22, 12000.00, '2025-03-19 16:55:00', 'Tanmay J Pawar', 'Cancelled', 'uploads/1742887406_product-1.png');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `rating` int NOT NULL DEFAULT '5',
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `category`, `rating`, `description`) VALUES
(1, 'Modern Chair', 140.00, 'product-1.png', 'Chair', 5, 'A stylish and comfortable modern chair.'),
(2, 'Modern Chair', 140.00, 'product-2.png', 'Chair', 5, 'A stylish and comfortable modern chair.'),
(3, 'Corner Table', 140.00, 'product-3.png', 'Corner Table', 5, 'A sleek and modern table.'),
(4, 'Corner Table', 140.00, 'product-4.png', 'Corner Table', 5, 'Perfect for work and study.'),
(5, 'Modern Sofa', 140.00, 'product-5.png', 'Sofa', 5, 'A comfortable modern sofa.'),
(6, 'Modern Sofa', 140.00, 'product-6.png', 'Sofa', 5, 'Luxury comfort for your home.'),
(7, 'Working Table', 140.00, 'product-7.png', 'Working Table', 5, 'A sturdy and modern working table.'),
(8, 'Working Table', 140.00, 'product-8.png', 'Working Table', 5, 'Ideal for home offices.'),
(9, 'Wardrobe', 140.00, 'product-9.png', 'Wardrobe', 5, 'A spacious wardrobe for storage.'),
(10, 'Wardrobe', 140.00, 'product-10.png', 'Wardrobe', 5, 'Elegant and modern wardrobe.');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `image`, `title`, `description`, `link`) VALUES
(1, 'serv-1.png', 'Product Selling', 'We sell good products at cheap rates. Anyone can buy our products.', '#'),
(2, 'serv-2.png', 'Product Designing', 'We design high-quality products at affordable rates, ensuring usability for everyone.', '#'),
(3, 'serv-3.png', '24 / 7 Support', 'We offer 24/7 support. You can contact us via mail or phone.', '#');

-- --------------------------------------------------------

--
-- Table structure for table `services_ad`
--

CREATE TABLE `services_ad` (
  `id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `new_AV` varchar(255) NOT NULL,
  `dis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `name`, `image_path`, `new_AV`, `dis`) VALUES
(1, 'New Arrival', 'img/home-img-1.png', 'New Arrivals', 'Discover our latest and greatest products');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `profile_pic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `profile_pic`) VALUES
(1, 'Akshar', 'Khunt', 'aksharKhunt016@gmail.com', 'team-6.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount` int DEFAULT '0',
  `rating` decimal(3,1) DEFAULT '0.0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `product_id`, `product_name`, `image`, `price`, `discount`, `rating`) VALUES
(13, 3, 'Corner Table', 'product-3.png', 140.00, 0, 5.0),
(14, 4, 'Corner Table', 'product-4.png', 140.00, 0, 5.0),
(15, 9, 'Wardrobe', 'product-9.png', 140.00, 0, 5.0),
(16, 5, 'Modern Sofa', 'product-5.png', 140.00, 0, 5.0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `about_ad`
--
ALTER TABLE `about_ad`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dropd`
--
ALTER TABLE `dropd`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `furniture`
--
ALTER TABLE `furniture`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `navigation`
--
ALTER TABLE `navigation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services_ad`
--
ALTER TABLE `services_ad`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about`
--
ALTER TABLE `about`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `about_ad`
--
ALTER TABLE `about_ad`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dropd`
--
ALTER TABLE `dropd`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `navigation`
--
ALTER TABLE `navigation`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `services_ad`
--
ALTER TABLE `services_ad`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- Table structure for table `services_ad`
--

DROP TABLE IF EXISTS `services_ad`;

CREATE TABLE `services_ad` (
  `id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;



-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

DROP TABLE IF EXISTS `slider`;

CREATE TABLE `slider` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `new_AV` varchar(255) NOT NULL,
  `dis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;



--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `name`, `image_path`, `new_AV`, `dis`) VALUES
(1, 'New Arrival', 'img/home-img-1.png', 'New Arrivals', 'Discover our latest and greatest products');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `profile_pic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;



--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `profile_pic`) VALUES
(1, 'Akshar', 'Khunt', 'aksharKhunt016@gmail.com', 'team-6.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE IF NOT EXISTS `wishlist` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount` int DEFAULT '0',
  `rating` decimal(3,1) DEFAULT '0.0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;



--
-- Dumping data for table `wishlist`
--

REPLACE INTO `wishlist` (`id`, `product_id`, `product_name`, `image`, `price`, `discount`, `rating`) VALUES
(13, 3, 'Corner Table', 'product-3.png', 140.00, 0, 5.0),
(14, 4, 'Corner Table', 'product-4.png', 140.00, 0, 5.0),
(15, 9, 'Wardrobe', 'product-9.png', 140.00, 0, 5.0),
(16, 5, 'Modern Sofa', 'product-5.png', 140.00, 0, 5.0);


--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about` ADD PRIMARY KEY (`id`);


--
-- Indexes for table `about_ad`
--
ALTER TABLE `about` DROP PRIMARY KEY;

ALTER TABLE `about` ADD PRIMARY KEY (`id`);


--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dropd`
--
ALTER TABLE `dropd`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `furniture`
--
ALTER TABLE `furniture`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `navigation`
--
ALTER TABLE `navigation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services_ad`
--
ALTER TABLE `services_ad`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about`
--
ALTER TABLE `about`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `about_ad`
--
ALTER TABLE `about_ad`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dropd`
--
ALTER TABLE `dropd`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `navigation`
--
ALTER TABLE `navigation`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


--
-- AUTO_INCREMENT for table `services_ad`
--
ALTER TABLE `services_ad`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
