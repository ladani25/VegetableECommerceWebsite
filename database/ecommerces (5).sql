-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2024 at 11:18 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerces`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin@gmail.com', 'admin123', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `u_id` bigint(20) UNSIGNED NOT NULL,
  `p_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `u_id`, `p_id`, `quantity`, `created_at`, `updated_at`) VALUES
(58, 5, 1, 1, '2024-06-14 05:11:10', '2024-06-14 05:11:10'),
(62, 1, 18, 3, '2024-06-17 01:11:31', '2024-06-17 01:54:37'),
(64, 8, 1, 1, '2024-06-18 01:10:54', '2024-06-18 01:10:54');

-- --------------------------------------------------------

--
-- Table structure for table `categeroy`
--

CREATE TABLE `categeroy` (
  `c_id` bigint(20) UNSIGNED NOT NULL,
  `c_name` varchar(255) NOT NULL,
  `images` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categeroy`
--

INSERT INTO `categeroy` (`c_id`, `c_name`, `images`, `created_at`, `updated_at`) VALUES
(1, 'Fresh Vegetables', '1715838250.jpeg', '2024-05-14 01:07:30', '2024-05-16 00:14:10'),
(2, 'Organic  Vegetables', '1715838365.jpg', '2024-05-14 01:08:17', '2024-05-16 00:16:05');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_code` varchar(255) NOT NULL,
  `type` enum('flat','percentage') NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `coupon_code`, `type`, `amount`, `created_at`, `updated_at`) VALUES
(1, 'sale', 'flat', 20.00, NULL, NULL),
(4, 'discount', 'percentage', 0.20, NULL, NULL),
(5, 'big offer', 'percentage', 3.00, '2024-05-25 09:39:34', '2024-05-25 09:39:34');

-- --------------------------------------------------------

--
-- Table structure for table `demo`
--
-- Error reading structure for table ecommerces.demo: #1932 - Table &#039;ecommerces.demo&#039; doesn&#039;t exist in engine
-- Error reading data for table ecommerces.demo: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `ecommerces`.`demo`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_05_08_070929_create_admins_table', 1),
(8, '2024_05_09_052903_create_categeroy_table', 2),
(9, '2024_05_14_052258_create_user_table', 3),
(10, '2024_05_14_061907_create_products_table', 4),
(11, '2024_05_14_062039_create_user_table', 5),
(12, '2024_05_24_071634_create_coupons_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `u_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `qty`, `amount`, `u_id`, `created_at`, `updated_at`) VALUES
(334, 8, 240, 8, '2024-06-14 23:59:22', '2024-06-14 23:59:22'),
(335, 8, 240, 8, '2024-06-15 00:33:56', '2024-06-15 00:33:56'),
(336, 8, 240, 8, '2024-06-15 00:50:00', '2024-06-15 00:50:00'),
(337, 4, 120, 8, '2024-06-16 22:51:23', '2024-06-16 22:51:23'),
(338, 4, 120, 8, '2024-06-17 23:17:39', '2024-06-17 23:17:39'),
(339, 4, 120, 8, '2024-06-18 01:10:49', '2024-06-18 01:10:49'),
(340, 1, 25, 8, '2024-06-18 01:11:03', '2024-06-18 01:11:03'),
(341, 1, 25, 8, '2024-06-18 01:11:50', '2024-06-18 01:11:50'),
(342, 1, 25, 8, '2024-06-18 01:12:42', '2024-06-18 01:12:42'),
(343, 1, 25, 8, '2024-06-18 01:14:58', '2024-06-18 01:14:58'),
(344, 1, 25, 8, '2024-06-18 01:15:43', '2024-06-18 01:15:43'),
(345, 1, 25, 8, '2024-06-18 01:19:30', '2024-06-18 01:19:30');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` varchar(100) NOT NULL,
  `totalal_amout` int(11) NOT NULL,
  `sub_totale` int(11) NOT NULL,
  `discount` int(100) NOT NULL,
  `payment_type` varchar(11) NOT NULL,
  `payment_status` varchar(11) NOT NULL,
  `order_date` date NOT NULL DEFAULT current_timestamp(),
  `u_id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` varchar(100) DEFAULT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `totalal_amout`, `sub_totale`, `discount`, `payment_type`, `payment_status`, `order_date`, `u_id`, `payment_id`, `address`, `created_at`, `updated_at`) VALUES
(76, '#666A92931C466', 25, 25, 0, 'cheque', 'Unpaid', '2024-06-13', 8, '0', 'xyz, fxyz, 9632587415, sneha@gmail.com, VCBVB, ,lmm b, 852147', '2024-06-13 01:02:51', '2024-06-13 01:02:51'),
(82, '#666ADF14D558F', 35, 35, 0, 'razorpay', 'Paid', '2024-06-13', 5, 'pay_OMEiAk2sUt4z3P', 'sneha, patel, 8521479635, abc@gmail.com, 3,b,hsjhxjncj, dfccx, 852147', '2024-06-13 06:29:16', '2024-06-13 06:29:16'),
(83, '#666C16578EF84', 50, 60, 20, 'cheque', 'Unpaid', '2024-06-14', 5, NULL, 'dfdv, fcvc, 8521479635, abc@gmail.com, PASODARA, surat, 963258741', '2024-06-14 04:37:19', '2024-06-14 04:37:19'),
(84, '#666C33127A251', -20, -10, 20, 'cheque', 'Unpaid', '2024-06-14', 8, NULL, 'wrdf, fcvc, 8521479635, admin@gmail.com, PASODARA, ,lmm b, 963258741', '2024-06-14 06:39:54', '2024-06-14 06:39:54'),
(85, '#667111A050216', 110, 120, 20, 'cheque', 'Unpaid', '2024-06-18', 8, NULL, 'sneha, patel, 8521479635, sneha@gmail.com, varachha, surat, 852147', '2024-06-17 23:18:32', '2024-06-17 23:18:32');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('abc@gmail.com', '$2y$12$23vsl1cIONRRSWBLpvM0W.SRX37vrh4.MXOQkLmTKO0wRlvGHfr5S', '2024-06-18 23:20:28'),
('snehaladani578@gmail.com', '$2y$12$uT8m1iLHme2ifGFOIUGg8.GvOinhVOSnt.uPIDfhU6TaQPhLvntNq', '2024-06-19 01:29:31');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `p_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `images` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `selling_price` int(11) NOT NULL,
  `p_quantity` int(11) NOT NULL,
  `c_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`p_id`, `name`, `images`, `price`, `selling_price`, `p_quantity`, `c_id`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Peas', '1715839769.jpeg', 25, 25, 49, 1, 'This is <u>Fresh Vegatables</u>', '2024-05-10 04:08:28', '2024-06-16 22:47:15'),
(2, 'cabbeage', '1715839867.png', 35, 35, -4, 2, '<b>This is a&nbsp;cabbeage</b>', '2024-05-10 04:41:22', '2024-06-15 01:15:20'),
(18, 'potoas', '1715839922.png', 30, 30, 48, 1, '<h1><b>this is a&nbsp;potoas</b></h1>', '2024-05-15 06:08:10', '2024-06-17 01:54:37'),
(19, 'potoas', '1715840586.jpeg', 35, 35, 50, 2, '<h1><b>this is a&nbsp;potoas</b></h1>', '2024-05-15 06:12:43', '2024-06-13 02:58:08'),
(20, 'onaina', '1715840610.jpeg', 50, 50, 49, 1, '<h1>this is<span style=\"font-weight: normal;\">&nbsp;onaina.</span></h1>', '2024-05-15 06:13:42', '2024-06-14 04:46:00'),
(21, 'cucumber', '1715850091.png', 20, 20, 30, 3, '<h1>this is&nbsp;<span style=\"font-weight: normal;\"><u>cucumber</u></span></h1>', '2024-05-16 03:31:31', '2024-06-17 01:31:59');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `u_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` bigint(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`u_id`, `name`, `email`, `phone_number`, `password`, `created_at`, `updated_at`) VALUES
(1, 'sneha', 'sneha@gmail.com', 9632587412, '$2y$12$kHUbhKBNqgYVBd0W/440ne/YgImxKDLuz6LrA6eFwYvSvuc5geXwy', '2024-05-14 01:25:09', '2024-05-14 01:25:09'),
(5, 'user', 'user@gmail.com', 9632587415, '1202cb962ac59075b964b07152d234b70$2y$12$kHUbhKBNqgYVBd0W/440ne/YgImxKDLuz6LrA6eFwYvSvuc5gefdf', '2024-05-14 03:33:50', '2024-05-14 03:33:50'),
(8, 'abc', 'abc@gmail.com', 8521479635, '$2y$12$olrAJ1Mz3gKsL.iSgreJg.MjkdO5tEg4TYrKWYKV5qyT/RAvM0rS6', '2024-05-14 03:35:41', '2024-05-14 03:35:41'),
(9, 'murli', 'murli@gmail.com', 6353272524, '$2y$12$1yTEIBdBPfylBMwE5owTN.wEnavwDwnTeCqbU3p1CG6B1yg.1OHD2', '2024-05-21 03:08:57', '2024-05-21 03:08:57'),
(10, 'xyz', 'xyz@gmail.com', 8521479632, '$2y$12$juJlMdGGiSgeyrPeQ/1we.PkQ2ANjDSrhaalcKpQgS6Tu0YCFrxYK', '2024-05-22 00:54:22', '2024-05-22 00:54:22'),
(11, 'xyz', 'xyz@gmail.com', 8521479632, '$2y$12$e0u.bMEBRScoZpCkxT1Mm.G3jkA4vLlpXN8tAGYJuQJHsG8Iqj9ay', '2024-05-22 00:55:37', '2024-05-22 00:55:37'),
(12, 'sneha', 'snehaladani578@gmail.com', 7412589635, '$2y$12$OPP/Bfrd3AxPsu/sZ5gXvuwSqGBFlN8Wtj4fMB8yGa1odWU/.IGVG', '2024-06-18 23:43:43', '2024-06-18 23:43:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_orders`
--
-- Error reading structure for table ecommerces.user_orders: #1932 - Table &#039;ecommerces.user_orders&#039; doesn&#039;t exist in engine
-- Error reading data for table ecommerces.user_orders: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `ecommerces`.`user_orders`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `w_id` bigint(20) UNSIGNED NOT NULL,
  `u_id` bigint(20) UNSIGNED NOT NULL,
  `p_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`w_id`, `u_id`, `p_id`, `created_at`, `updated_at`) VALUES
(28, 9, 2, '2024-05-22 02:50:57', '2024-05-22 02:50:57'),
(29, 9, 18, '2024-05-22 02:55:08', '2024-05-22 02:55:08'),
(32, 8, 20, '2024-05-22 09:52:06', '2024-05-22 09:52:06'),
(38, 5, 2, '2024-05-23 03:32:32', '2024-05-23 03:32:32'),
(44, 5, 21, '2024-05-25 05:44:00', '2024-05-25 05:44:00'),
(45, 5, 19, '2024-05-27 23:33:10', '2024-05-27 23:33:10'),
(46, 5, 1, '2024-05-27 23:33:14', '2024-05-27 23:33:14'),
(48, 1, 1, '2024-06-17 01:15:31', '2024-06-17 01:15:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `u_id` (`u_id`),
  ADD KEY `p_id` (`p_id`);

--
-- Indexes for table `categeroy`
--
ALTER TABLE `categeroy`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_coupon_code_unique` (`coupon_code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`w_id`),
  ADD KEY `u_id` (`u_id`),
  ADD KEY `p_id` (`p_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `categeroy`
--
ALTER TABLE `categeroy`
  MODIFY `c_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=346;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `p_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `u_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `w_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`),
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`p_id`) REFERENCES `products` (`p_id`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`);

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`),
  ADD CONSTRAINT `wishlists_ibfk_2` FOREIGN KEY (`p_id`) REFERENCES `products` (`p_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
