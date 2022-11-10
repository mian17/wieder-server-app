-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 10, 2022 at 02:04 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wieder_ db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_item`
--

CREATE TABLE `cart_item` (
  `id` int(11) NOT NULL,
  `user_uuid` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `img_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `img_url`, `parent_category_id`, `created_at`, `updated_at`) VALUES
(1, 'Trái cây', '/img/categories/0-category-fruits.jpg', NULL, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(2, 'Thịt, trứng', '/img/categories/1-category-meat.jpg', NULL, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(3, 'Cá, thủy hải sản', '/img/categories/2-category-seafood.jpg', NULL, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(4, 'Rau củ quả', '/img/categories/3-category-vegetable.jpg', NULL, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(5, 'Thực phẩm Việt', '/img/categories/4-category-vietnamese-food.jpg', NULL, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(6, 'Sữa, Bơ, Phô Mai', '/img/categories/5-category-dairy.jpg', NULL, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(7, 'Đông lạnh, mát', '/img/categories/6-category-frozen-food.jpg', NULL, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(8, 'Dầu ăn, gia vị', '/img/categories/7-category-cooking-oil-spice.jpg', NULL, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(9, 'Gạo, Mì, Nông sản', '/img/categories/8-category-rice-noodle-agriculture-products.jpg', NULL, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(10, 'Đồ hộp, Đóng gói', '/img/categories/9-category-canned-foods.jpg', NULL, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(11, 'Bia, Đồ uống', '/img/categories/10-category-beer-drinks.jpg', NULL, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(12, 'Thực phẩm chay', '/img/categories/11-category-vegetarian-food.jpg', NULL, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(13, 'Dành cho trẻ em', '/img/categories/12-category-things-for-kids.jpg', NULL, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(14, 'Bánh kẹo, Giỏ quà', '/img/categories/13-category-sweets-snacks-gifts.jpg', NULL, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(15, 'Thức ăn, Đồ thú cưng', '/img/categories/14-category-food-things-for-pets.jpg', NULL, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(16, 'Chăm sóc cá nhân', '/img/categories/15-category-self-care.jpg', NULL, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(17, 'Chăm sóc nhà cửa', '/img/categories/16-category-home-appliance.jpg', NULL, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(18, 'Trái cây nội địa', '/img/categories/trai-cay-noi-dia.jpg', 1, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(19, 'Trái cây nhập khẩu', '/img/categories/trai-cay-nhap-khau.jpg', 1, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(20, 'Thịt heo, lợn', '/img/categories/thit-heo-lon.jpg', 2, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(21, 'Thịt bò, bê', '/img/categories/thit-bo-be.jpg', 2, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(22, 'Thịt gà, vịt, chim', '/img/categories/thit-ga-vit-chim.jpg', 2, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(23, 'Thịt đông lạnh', '/img/categories/thit-dong-lanh.jpg', 2, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(24, 'Các loại thịt khác', '/img/categories/cac-loai-thit-khac.jpg', 2, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(25, 'Trứng gà, vịt, cút', '/img/categories/trung-ga-vit-cut.jpg', 2, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(26, 'Cá, hải sản đông lạnh', '/img/categories/ca-hai-san-dong-lanh.jpg', 3, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(27, 'Củ, quả, măng tươi', '/img/categories/cu-qua-mang-tuoi.jpg', 4, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(28, 'Gạo, nếp, đậu', '/img/categories/gao-nep-dau.jpg', 9, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(29, 'Bột gạo, mì, bột chiên', '/img/categories/bot-gao-mi-bot-chien.jpg', 9, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(30, 'Trà khô, trà đóng chai', '/img/categories/tra-kho-tra-dong-chai.jpg', 11, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(31, 'Cà phê hạt, đóng chai', '/img/categories/ca-phe-hat-dong-chai.jpg', 11, '2022-11-10 12:26:54', '2022-11-10 12:26:54');

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `desc` text COLLATE utf8_unicode_ci NOT NULL,
  `total_money_condition` int(11) NOT NULL,
  `discount_percent` decimal(10,0) NOT NULL,
  `expiration_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `discount`
--

INSERT INTO `discount` (`id`, `name`, `desc`, `total_money_condition`, `discount_percent`, `expiration_date`, `created_at`, `updated_at`) VALUES
(1, 'QUIA47', 'Porro cumque exercitationem ex animi quisquam.', 146410, '64', '2022-12-04 12:26:55', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(2, 'SIT93', 'Magnam quis accusantium sequi explicabo nobis eaque.', 333498, '26', '2023-01-12 12:26:55', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(3, 'REPUDIANDAE20', 'Consequatur dolores voluptatum et optio.', 165426, '71', '2023-01-16 12:26:55', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(4, 'AUT17', 'Ipsum quas et sunt modi aperiam.', 916453, '30', '2022-12-31 12:26:55', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(5, 'ITAQUE88', 'Et illo facere soluta et minus esse.', 681440, '49', '2023-01-09 12:26:55', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(6, 'VELIT88', 'Sit ullam rerum repellat qui.', 461120, '38', '2022-08-19 12:26:55', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(7, 'MOLLITIA13', 'Suscipit eum possimus quis aperiam dignissimos rem dignissimos.', 683517, '30', '2022-10-24 12:26:55', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(8, 'NUMQUAM25', 'Voluptas ea pariatur suscipit aut.', 432303, '74', '2022-11-01 12:26:55', '2022-11-10 12:26:55', '2022-11-10 12:26:55');

-- --------------------------------------------------------

--
-- Table structure for table `discount_user`
--

CREATE TABLE `discount_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_uuid` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `discount_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `discount_user`
--

INSERT INTO `discount_user` (`id`, `user_uuid`, `discount_id`) VALUES
(1, 'e23b34a8-f383-4ccd-a7a7-1de03981409b', 1);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `model_id` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `model_id`, `url`, `created_at`, `updated_at`) VALUES
(1, 1, '/img/product/dua-hau-product-1.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(2, 1, '/img/product/dua-hau-product-2.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(3, 1, '/img/product/dua-hau-product-3.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(4, 1, '/img/product/dua-hau-product-4.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(5, 1, '/img/product/dua-hau-product-5.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(6, 1, '/img/product/dua-hau-product-6.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(7, 1, '/img/product/dua-hau-product-7.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(8, 1, '/img/product/dua-hau-product-8.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(9, 1, '/img/product/dua-hau-product-9.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(10, 1, '/img/product/dua-hau-product-10.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(11, 2, '/img/product/dau-tay-product-1.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(12, 2, '/img/product/dau-tay-product-2.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(13, 2, '/img/product/dau-tay-product-3.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(14, 2, '/img/product/dau-tay-product-4.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(15, 2, '/img/product/dau-tay-product-5.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(16, 2, '/img/product/dau-tay-product-6.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(17, 2, '/img/product/dau-tay-product-7.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(18, 2, '/img/product/dau-tay-product-8.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(19, 2, '/img/product/dau-tay-product-9.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(20, 2, '/img/product/dau-tay-product-10.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(21, 3, '/img/product/mang-cut-product-1.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(22, 3, '/img/product/mang-cut-product-2.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(23, 3, '/img/product/mang-cut-product-3.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(24, 4, '/img/product/chanh-nhap-khau-product-1.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(25, 4, '/img/product/chanh-nhap-khau-product-2.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(26, 4, '/img/product/chanh-nhap-khau-product-3.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(27, 4, '/img/product/chanh-nhap-khau-product-4.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(28, 4, '/img/product/chanh-nhap-khau-product-5.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(29, 4, '/img/product/chanh-nhap-khau-product-6.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(30, 4, '/img/product/chanh-nhap-khau-product-7.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(31, 4, '/img/product/chanh-nhap-khau-product-8.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(32, 4, '/img/product/chanh-nhap-khau-product-9.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(33, 4, '/img/product/chanh-nhap-khau-product-10.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(34, 5, '/img/product/thanh-long-product-1.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(35, 5, '/img/product/thanh-long-product-2.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(36, 5, '/img/product/thanh-long-product-3.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(37, 5, '/img/product/thanh-long-product-4.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(38, 5, '/img/product/thanh-long-product-5.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(39, 6, '/img/product/tao-do-product-1.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(40, 6, '/img/product/tao-do-product-2.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(41, 6, '/img/product/tao-do-product-3.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(42, 6, '/img/product/tao-do-product-4.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(43, 6, '/img/product/tao-do-product-5.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(44, 6, '/img/product/tao-do-product-6.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(45, 7, '/img/product/tao-xanh-product-1.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(46, 7, '/img/product/tao-xanh-product-2.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(47, 7, '/img/product/tao-xanh-product-3.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(48, 7, '/img/product/tao-xanh-product-4.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(49, 7, '/img/product/tao-xanh-product-5.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(50, 7, '/img/product/tao-xanh-product-6.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(51, 8, '/img/product/thit-bo-product-1.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(52, 8, '/img/product/thit-bo-product-2.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(53, 8, '/img/product/thit-bo-product-3.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(54, 8, '/img/product/thit-bo-product-4.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(55, 8, '/img/product/thit-bo-product-5.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(56, 8, '/img/product/thit-bo-product-6.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(57, 9, '/img/product/trung-ga-product-1.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(58, 9, '/img/product/trung-ga-product-2.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(59, 9, '/img/product/trung-ga-product-3.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(60, 9, '/img/product/trung-ga-product-4.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(61, 9, '/img/product/trung-ga-product-5.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(62, 9, '/img/product/trung-ga-product-6.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(63, 9, '/img/product/trung-ga-product-7.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(64, 10, '/img/product/ca-hoi-product-1.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(65, 10, '/img/product/ca-hoi-product-2.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(66, 10, '/img/product/ca-hoi-product-3.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(67, 10, '/img/product/ca-hoi-product-4.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(68, 10, '/img/product/ca-hoi-product-5.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(69, 10, '/img/product/ca-hoi-product-6.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(70, 11, '/img/product/gao-product-1.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(71, 11, '/img/product/gao-product-2.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(72, 11, '/img/product/gao-product-3.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(73, 11, '/img/product/gao-product-4.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(74, 11, '/img/product/gao-product-5.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(75, 11, '/img/product/gao-product-6.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(76, 12, '/img/product/dua-leo-product-1.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(77, 12, '/img/product/dua-leo-product-2.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(78, 12, '/img/product/dua-leo-product-3.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(79, 12, '/img/product/dua-leo-product-4.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(80, 12, '/img/product/dua-leo-product-5.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(81, 12, '/img/product/dua-leo-product-6.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(82, 13, '/img/product/mi-y-cong-dai-product-1.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(83, 13, '/img/product/mi-y-cong-dai-product-2.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(84, 13, '/img/product/mi-y-cong-dai-product-3.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(85, 13, '/img/product/mi-y-cong-dai-product-4.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(86, 13, '/img/product/mi-y-cong-dai-product-5.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(87, 13, '/img/product/mi-y-cong-dai-product-6.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(88, 14, '/img/product/mi-y-cong-ngan-product-1.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(89, 14, '/img/product/mi-y-cong-ngan-product-2.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(90, 14, '/img/product/mi-y-cong-ngan-product-3.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(91, 14, '/img/product/mi-y-cong-ngan-product-4.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(92, 14, '/img/product/mi-y-cong-ngan-product-5.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(93, 14, '/img/product/mi-y-cong-ngan-product-6.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(94, 15, '/img/product/tra-matcha-dong-chai-product-1.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(95, 15, '/img/product/tra-matcha-dong-chai-product-2.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(96, 15, '/img/product/tra-matcha-dong-chai-product-3.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(97, 15, '/img/product/tra-matcha-dong-chai-product-4.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(98, 15, '/img/product/tra-matcha-dong-chai-product-5.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(99, 15, '/img/product/tra-matcha-dong-chai-product-6.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(100, 16, '/img/product/ca-phe-dang-hat-arabica-product-1.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(101, 16, '/img/product/ca-phe-dang-hat-arabica-product-2.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(102, 16, '/img/product/ca-phe-dang-hat-arabica-product-3.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(103, 16, '/img/product/ca-phe-dang-hat-arabica-product-4.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(104, 16, '/img/product/ca-phe-dang-hat-arabica-product-5.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(105, 16, '/img/product/ca-phe-dang-hat-arabica-product-6.jpg', '2022-11-10 12:26:55', '2022-11-10 12:26:55');

-- --------------------------------------------------------

--
-- Table structure for table `merchant`
--

CREATE TABLE `merchant` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `merchant`
--

INSERT INTO `merchant` (`id`, `name`, `address`, `phone_number`, `email`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'Wieder_ Official Store', '68 Nguyễn Thị Minh Khai, Quận 1, TP. HCM', '0586801768', 'alibis_intron.0x@icloud.com', NULL, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(2, 'Đinh, Trang and Đinh', '2410 Phố Thiều Miên Nhàn', '026 307 2836', 'phi.phi@vien.gov.vn', NULL, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(3, 'Ca and Sons', '4571 Phố Từ', '84-510-305-3058', 'binh.bang@trung.org', NULL, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(4, 'Khổng-Lại', '1 Phố Đàm Phương Lân', '(072)160-0882', 'vien40@dong.com', NULL, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(5, 'Ngô Ltd', '6474 Phố Phó', '(0128) 192 5139', 'lien.lac@ch.net', NULL, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(6, 'Cát-Bế', '2 Phố Hạnh', '84-126-645-5103', 'vien.trung@bu.com', NULL, '2022-11-10 12:26:54', '2022-11-10 12:26:54'),
(7, 'Nhà bán test đổi tên', 'địa chỉ nhà bán test', '013998134719', 'example@example.com', 1, '2022-11-10 12:51:55', '2022-11-10 12:52:32');

-- --------------------------------------------------------

--
-- Table structure for table `merchant_product`
--

CREATE TABLE `merchant_product` (
  `id` bigint(20) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `merchant_product`
--

INSERT INTO `merchant_product` (`id`, `merchant_id`, `product_id`) VALUES
(1, 5, 1),
(2, 3, 2),
(3, 4, 3),
(4, 3, 4),
(5, 2, 5),
(6, 5, 6),
(7, 6, 7),
(8, 3, 8),
(9, 5, 9),
(10, 1, 10),
(11, 6, 11),
(12, 1, 12),
(13, 3, 13),
(14, 5, 14);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2022_08_18_170004_create_cart_item_table', 1),
(5, '2022_08_18_170004_create_category_table', 1),
(6, '2022_08_18_170004_create_discount_table', 1),
(7, '2022_08_18_170004_create_merchant_product_table', 1),
(8, '2022_08_18_170004_create_merchant_table', 1),
(9, '2022_08_18_170004_create_model_table', 1),
(10, '2022_08_18_170004_create_order_item_table', 1),
(11, '2022_08_18_170004_create_order_table', 1),
(12, '2022_08_18_170004_create_payment_details_table', 1),
(13, '2022_08_18_170004_create_payment_method_table', 1),
(14, '2022_08_18_170004_create_product_table', 1),
(15, '2022_08_18_170004_create_status_table', 1),
(16, '2022_08_18_170004_create_user_role_table', 1),
(17, '2022_08_18_170004_create_user_role_user_table', 1),
(18, '2022_08_18_170004_create_user_table', 1),
(19, '2022_08_18_170004_create_warehouse_table', 1),
(20, '2022_08_18_170005_add_foreign_keys_to_cart_item_table', 1),
(21, '2022_08_18_170005_add_foreign_keys_to_category_table', 1),
(22, '2022_08_18_170005_add_foreign_keys_to_merchant_product_table', 1),
(23, '2022_08_18_170005_add_foreign_keys_to_model_table', 1),
(24, '2022_08_18_170005_add_foreign_keys_to_order_item_table', 1),
(25, '2022_08_18_170005_add_foreign_keys_to_order_table', 1),
(26, '2022_08_18_170005_add_foreign_keys_to_payment_details_table', 1),
(27, '2022_08_18_170005_add_foreign_keys_to_payment_method_table', 1),
(28, '2022_08_18_170005_add_foreign_keys_to_product_table', 1),
(29, '2022_08_18_170005_add_foreign_keys_to_user_role_table', 1),
(30, '2022_08_18_170005_add_foreign_keys_to_user_role_user_table', 1),
(31, '2022_08_26_140131_create_warehouse_product_table', 1),
(32, '2022_09_01_122752_create_image_table', 1),
(33, '2022_09_06_131402_create_discount_user_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model`
--

CREATE TABLE `model` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `hex_color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `model`
--

INSERT INTO `model` (`id`, `name`, `image_1`, `image_2`, `quantity`, `hex_color`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 'Dưa hấu', '/img/product/dua-hau-1.jpg', '/img/product/dua-hau-2.jpg', 2614, '#fa5252', 1, '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(2, 'Dâu tây', '/img/product/dau-tay-1.jpg', '/img/product/dau-tay-2.jpg', 712, '#fa5252', 2, '2022-11-10 12:26:55', '2022-11-10 12:34:48'),
(3, 'Măng cụt', '/img/product/mang-cut-1.jpg', '/img/product/mang-cut-2.jpg', 3386, '#ced4da', 3, '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(4, 'Chanh nhập khẩu', '/img/product/chanh-1.jpg', '/img/product/chanh-2.jpg', 2938, '#ffd43b', 4, '2022-11-10 12:26:55', '2022-11-10 12:34:48'),
(5, 'Thanh long', '/img/product/thanh-long-1.jpg', '/img/product/thanh-long-2.jpg', 4311, '#ff6b6b', 5, '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(6, 'Táo đỏ', '/img/product/tao-do-1.jpg', '/img/product/tao-do-2.jpg', 1908, '#ff8787', 6, '2022-11-10 12:26:55', '2022-11-10 12:29:27'),
(7, 'Táo xanh', '/img/product/tao-xanh-1.jpg', '/img/product/tao-xanh-2.jpg', 1695, '#51cf66', 6, '2022-11-10 12:26:55', '2022-11-10 12:29:27'),
(8, 'Thịt bò', '/img/product/thit-bo-1.jpg', '/img/product/thit-bo-2.jpg', 271, '#ff8787', 7, '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(9, 'Trứng gà', '/img/product/trung-ga-1.jpg', '/img/product/trung-ga-2.jpg', 4768, '#ff6b6b', 8, '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(10, 'Cá hồi', '/img/product/ca-hoi-1.jpg', '/img/product/ca-hoi-1.jpg', 1264, '#ffa94d', 9, '2022-11-10 12:26:55', '2022-11-10 12:34:48'),
(11, 'Gạo 5kg', '/img/product/gao-1.jpg', '/img/product/gao-2.jpg', 4645, '#ced4da', 10, '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(12, 'Dưa leo', '/img/product/dua-leo-1.jpg', '/img/product/dua-leo-2.jpg', 4679, '#82c91e', 11, '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(13, 'Mì ý cọng dài', '/img/product/mi-y-cong-dai-1.jpg', '/img/product/mi-y-cong-dai-2.jpg', 1882, '#ffe066', 12, '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(14, 'Mì ý cọng ngắn', '/img/product/mi-y-cong-ngan-1.jpg', '/img/product/mi-y-cong-ngan-2.jpg', 4678, '#f08c00', 12, '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(15, 'Trà matcha đóng chai', '/img/product/tra-matcha-dang-nuoc-1.jpg', '/img/product/tra-matcha-dang-nuoc-1.jpg', 1133, '#82c91e', 13, '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(16, 'Cà phê dạng hạt Arabica', '/img/product/ca-phe-dang-hat-arabica-1.jpg', '/img/product/ca-phe-dang-hat-arabica-2.jpg', 4686, '#e67700', 14, '2022-11-10 12:26:55', '2022-11-10 12:26:55');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `uuid` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `user_uuid` char(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `receiver_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `receiver_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `receiver_phone_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `receiver_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total` int(11) NOT NULL,
  `status_id` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`uuid`, `user_uuid`, `receiver_name`, `receiver_email`, `receiver_phone_number`, `receiver_address`, `total`, `status_id`, `created_at`, `updated_at`) VALUES
('737936e0-cb18-47aa-8dad-9082e9045679', 'e23b34a8-f383-4ccd-a7a7-1de03981409b', 'Lê Thế Vinh', 'alibis_intron.0x@icloud.com', '0586801768', '68 Nguyễn Thị Minh Khai, Quận 1, TP. HCM', 720000, 1, '2022-11-10 12:31:56', '2022-11-10 12:31:56'),
('e639bb9b-73e1-41df-8f40-ebbadd5a370f', 'e23b34a8-f383-4ccd-a7a7-1de03981409b', 'Lê Thế Tí', 'alibis_intron.0x@icloud.com', '0586801768', '68 Nguyễn Thị Minh Khai, Quận 1, TP. HCM', 500000, 5, '2022-11-10 12:34:02', '2022-11-10 12:34:48');

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `id` int(11) NOT NULL,
  `order_uuid` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`id`, `order_uuid`, `product_id`, `model_id`, `price`, `quantity`, `created_at`, `updated_at`) VALUES
(5, '737936e0-cb18-47aa-8dad-9082e9045679', 4, 4, 200000, 10, '2022-11-10 12:31:56', '2022-11-10 12:31:56'),
(6, 'e639bb9b-73e1-41df-8f40-ebbadd5a370f', 2, 2, 120000, 1, '2022-11-10 12:34:02', '2022-11-10 12:34:02'),
(7, 'e639bb9b-73e1-41df-8f40-ebbadd5a370f', 4, 4, 200000, 1, '2022-11-10 12:34:02', '2022-11-10 12:34:02'),
(8, 'e639bb9b-73e1-41df-8f40-ebbadd5a370f', 9, 10, 180000, 1, '2022-11-10 12:34:02', '2022-11-10 12:34:02');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

CREATE TABLE `payment_details` (
  `uuid` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payment_details`
--

INSERT INTO `payment_details` (`uuid`, `payment_method_id`, `amount`, `status`, `created_at`, `updated_at`) VALUES
('737936e0-cb18-47aa-8dad-9082e9045679', 1, 2000000, 'Chưa thanh toán', '2022-11-10 12:31:56', '2022-11-10 12:31:56'),
('e639bb9b-73e1-41df-8f40-ebbadd5a370f', 1, 500000, 'Chưa thanh toán', '2022-11-10 12:34:02', '2022-11-10 12:34:02');

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

CREATE TABLE `payment_method` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Thanh toán tiền mặt', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(2, 'Ví MoMo', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(3, 'Ví ZaloPay', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(4, 'Ví Moca|Grab', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(5, 'VNPAY', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(6, 'Thẻ tín dụng/Ghi nợ', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(7, 'Thẻ ATM', '2022-11-10 12:26:55', '2022-11-10 12:26:55');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tokenable_id` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(6, 'App\\Models\\User', '9ce3405e-9101-4955-8281-dd4c4a1fcb33', 'user-token', 'bdb870a7df9105b8d51362d17995744cbb4c35d06e00fc246467263d2095a64e', '[\"customer\"]', '2022-11-10 12:56:17', NULL, '2022-11-10 12:54:02', '2022-11-10 12:56:17'),
(7, 'App\\Models\\User', '0001599b-2d7d-407e-85ac-af2d8cf413d7', 'user-token', '48145c39d89d4cc68b8145835e9f1601dbda9a36736bf578588552e7cf47640d', '[\"customer\"]', '2022-11-10 12:55:57', NULL, '2022-11-10 12:54:39', '2022-11-10 12:55:57');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `brand` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `summary` text COLLATE utf8_unicode_ci NOT NULL,
  `desc` text COLLATE utf8_unicode_ci NOT NULL,
  `detail_info` text COLLATE utf8_unicode_ci NOT NULL,
  `SKU` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mass` int(11) NOT NULL,
  `cost_price` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `unit` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `name`, `brand`, `summary`, `desc`, `detail_info`, `SKU`, `mass`, `cost_price`, `price`, `unit`, `status`, `created_at`, `updated_at`) VALUES
(1, 18, 'Dưa hấu', 'New Zealand WholeFood', 'Ut ut ut expedita enim. Et illo nam sint. Inventore quia debitis est aut id tempore omnis. Rerum eum esse nihil optio est. Quisquam nemo tenetur eum et.', 'Architecto id facilis impedit voluptates. Nam laudantium et sapiente distinctio. Vel magni vel maxime in. Qui autem maxime totam.', 'Quas consequuntur cum distinctio veritatis doloribus vitae eius quas. Accusantium velit voluptas et vitae accusamus voluptas voluptatem odio. Soluta cum accusantium debitis iusto aut nostrum. Enim vitae rem sunt quos.', '2712463072', 1000, 100000, 50000, 'g', 'Hiển thị', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(2, 19, 'Dâu tây', 'New Zealand WholeFood', 'Delectus soluta nihil harum. Ea ut consequatur debitis similique aut et et provident. Cupiditate et sunt est delectus sit architecto.', 'Doloremque aut illum qui earum est. Sit saepe nisi et perferendis ratione. Aut et eligendi vel quos aut. Ut voluptas est sequi voluptatem fuga accusamus.', 'Nemo dolores provident minus incidunt. Eos ab architecto cupiditate harum dignissimos. Qui eum porro non quia recusandae ut. Omnis dolor autem consequuntur.', '1888508051', 100, 140000, 120000, 'kg', 'Hiển thị', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(3, 18, 'Măng cụt', 'New Zealand WholeFood', 'Est perferendis distinctio omnis quia et. Eveniet ut ad dicta delectus dicta. Commodi nulla ipsa ad. Voluptatem vero quia est.', 'Saepe voluptatem dolor sit iusto harum dignissimos repellat. Corrupti voluptatem expedita aut sapiente autem vitae ut cupiditate. Earum soluta ut maxime eius sunt. Aut sed debitis eos voluptas fuga.', 'Vel consequuntur ipsum enim qui tempora quaerat nihil voluptatem. Iure enim quia id eos. Qui excepturi error libero iste qui. Debitis iste fugit reprehenderit quia voluptatem accusamus rerum.', '4325809570', 100, 80000, 60000, 'kg', 'Hiển thị', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(4, 19, 'Chanh nhập khẩu', 'New Zealand WholeFood', 'Est esse incidunt sit nostrum velit tempore omnis. Ut quidem modi maiores ab laboriosam eligendi tenetur. Qui alias voluptas ut ipsum et sapiente. Est et et facilis architecto placeat qui et.', 'Voluptates voluptatem quis sunt recusandae magnam minus. Voluptate dolorum mollitia nobis. Et aperiam occaecati ea rerum reiciendis illo ut deleniti.', 'Modi sint qui et harum. Eius nihil aut sed aliquam qui sit qui fugit. Consequatur illum perspiciatis ullam qui recusandae ab assumenda ut. Qui nam accusantium animi ipsam est cupiditate.', '917680626X', 100, 200000, 200000, 'kg', 'Hiển thị', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(5, 18, 'Thanh long', 'New Zealand WholeFood', 'Consequatur ut maxime vero ut sint quam quis. Esse et rerum beatae sint. Omnis aut suscipit libero et assumenda.', 'Debitis sapiente perferendis nam ut rerum itaque quidem. Consequatur porro quasi dolore ut corrupti. Aut nihil sit autem impedit deleniti omnis. Sed eveniet dolor ex dignissimos voluptatem deleniti voluptatem enim. Sunt et quisquam distinctio deserunt velit molestias rerum.', 'Totam velit ad consequatur quo consequatur aliquid. Quis ut doloribus et cum aperiam.', '3677442338', 100, 30000, 20000, 'kg', 'Hiển thị', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(6, 19, 'Táo', 'New Zealand WholeFood', 'Maxime repellendus natus quasi. Itaque voluptatem suscipit hic officia tempore rem quia. Sed beatae repellendus perspiciatis eaque. Ipsa odio ut accusantium laboriosam.', 'Commodi unde dolor ea quia veniam. Numquam ut eos aperiam. Dolor ut iste voluptatibus inventore molestiae sit.', 'Accusantium rerum voluptatem tempore officia ipsa. Voluptatem incidunt eius dignissimos quasi dolore blanditiis vel. Inventore odit vero nulla perspiciatis.', '6610826277', 100, 150000, 120000, 'kg', 'Hiển thị', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(7, 21, 'Thịt bò', 'New Zealand WholeFood', 'Et odio ad quia ullam perspiciatis delectus et cum. Incidunt nisi quis ex nostrum. Nihil aut et velit laudantium error.', 'Et nobis aut soluta tempore dolor officiis. Vel architecto similique iste sit sint aut ea facere.', 'Numquam quo blanditiis veritatis cum. Quis et cum rerum vel aliquid. Id inventore nulla repellendus et repudiandae impedit voluptas.', '4892280127', 100, 96000, 57000, 'kg', 'Hiển thị', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(8, 25, 'Trứng gà', 'New Zealand WholeFood', 'Dolores quasi consequatur deleniti voluptas aut nihil. Nobis id qui dolor voluptatem quisquam laborum. Ut odio odit cumque iure. Nihil architecto vel temporibus.', 'Atque est nulla aut accusamus ipsa molestias. Inventore aut et qui eos ea. Nulla eaque temporibus cupiditate in odit officia. Rerum voluptatibus inventore eos molestias.', 'Deserunt repudiandae minus quas. Reiciendis aut velit et alias. Distinctio blanditiis enim exercitationem fuga temporibus consequatur doloribus.', '905319519X', 100, 20000, 20000, 'kg', 'Hiển thị', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(9, 26, 'Cá hồi', 'New Zealand WholeFood', 'Rerum non deleniti quia ducimus autem. Aut optio sunt quisquam sit.', 'Consequatur non alias qui veniam quam. Voluptatem quia sint in adipisci velit earum. Tenetur et eum voluptatum esse iure et. Et atque debitis quis dolor.', 'In occaecati sed aut sunt repellendus vero omnis. Qui quis nisi ut libero vitae. Dolorem deleniti ad pariatur provident excepturi.', '2836773677', 100, 240000, 180000, 'kg', 'Hiển thị', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(10, 28, 'Gạo 5kg', 'New Zealand WholeFood', 'Mollitia voluptatem qui magni velit voluptatum nihil. Vel sunt dicta vero.', 'Excepturi eaque inventore deserunt iusto earum veniam modi. Corrupti est cumque aut reiciendis sapiente eveniet ipsa. Ea architecto omnis dolores harum. Velit neque veniam ut quis.', 'Repellat deleniti quia eum sed. Quod omnis ipsum nemo optio. Iste ut dolor cum ipsa.', '8343571185', 5000, 28000, 14000, 'kg', 'Hiển thị', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(11, 27, 'Dưa leo', 'New Zealand WholeFood', 'Omnis quia odio accusamus vel. Doloremque saepe et deserunt. Deserunt perferendis sed quibusdam est sed et fugiat.', 'Sint ea esse molestias et. Est quam placeat sed aut et. Earum at rem quia at.', 'Qui cum rerum magnam. Sequi doloremque culpa non fugiat. Ullam dolor quae quis ratione magni sunt culpa. Tempora modi esse distinctio ut eum officiis.', '2562814967', 1000, 18000, 14000, 'kg', 'Hiển thị', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(12, 29, 'Mì ý', 'New Zealand WholeFood', 'Eligendi et nostrum eum ut occaecati omnis beatae. Rerum quis aperiam sint perferendis in. Nam inventore sunt eum iste dolor est similique.', 'Culpa facere quis est ad. Autem ea dolorum debitis atque facere est omnis. Voluptatem reiciendis sunt esse eum officia qui voluptates et.', 'Omnis aspernatur molestiae consectetur est. Laudantium iste et quas a qui odit blanditiis iure. Eaque voluptate est ut debitis totam facilis facere.', '7830085676', 500, 28000, 14000, 'Hộp', 'Hiển thị', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(13, 30, 'Trà matcha đóng chai', 'New Zealand WholeFood', 'Omnis voluptatum aut asperiores sint qui. Qui odio sint fuga omnis. Consectetur dolor molestiae tempora voluptas.', 'Ut facere architecto facere. Perspiciatis quam tempore qui culpa vel. Minus a voluptatibus dignissimos.', 'Suscipit recusandae amet occaecati debitis minus. Eum hic quos et dolor suscipit nobis. Quis aliquid non provident sed quas in. Quod eveniet rem ut ad aut ratione.', '0774368187', 500, 48000, 30000, 'Chai', 'Hiển thị', '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(14, 31, 'Cà phê dạng hạt Arabica', 'New Zealand WholeFood', 'Est ea maiores reiciendis rem sit quos. Et reprehenderit perspiciatis pariatur est. Qui repellat est ut laborum deserunt.', 'Velit et tempore vel provident placeat aut vel. Consequatur amet consequatur sed dignissimos molestiae. Deleniti dolorem dolorem deserunt et harum. Explicabo dolorum nisi reprehenderit ipsa.', 'Quisquam cum facilis officia neque et est aut. Non minima et blanditiis quia. Labore commodi natus a molestiae.', '6722879615', 1000, 48000, 30000, 'kg', 'Hiển thị', '2022-11-10 12:26:55', '2022-11-10 12:26:55');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` tinyint(4) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'Chờ xác nhận'),
(2, 'Chờ lấy hàng'),
(3, 'Đang giao'),
(4, 'Đã giao'),
(5, 'Đã hủy'),
(6, 'Yêu cầu đổi trả, hoàn tiền');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `uuid` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  `gender` tinyint(4) NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reward_points` int(11) NOT NULL DEFAULT 0,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '/img/avatar/default-avatar.png',
  `deleted` tinyint(1) DEFAULT NULL,
  `last_sign_in` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uuid`, `username`, `password`, `email`, `phone_number`, `name`, `birth_date`, `gender`, `address`, `reward_points`, `avatar`, `deleted`, `last_sign_in`, `created_at`, `updated_at`, `remember_token`, `email_verified_at`) VALUES
('0001599b-2d7d-407e-85ac-af2d8cf413d7', 'bang.dung', '$2y$10$7ZZqmfxeXGpfPkEncgko6.6XCVLY/9DyzNTgXX9VX0K1u59VfXqGa', 'xthieu@example.net', '030-412-1222', 'Chế Yên Giang', '1976-04-07', 0, '87 Phố Nhiệm Đạo Hương', 1626, '/img/avatar/default-avatar.png', NULL, '2022-11-10 12:26:56', '2022-11-10 12:26:56', '2022-11-10 12:26:56', NULL, '2022-11-10 00:26:55'),
('15d27e7f-455d-4d55-b8ac-0f1ee089029a', 'kien88', '$2y$10$56QOEidbiA88IX3vaFZLNeBA/Nc3u3NgF9OVPX0X8pAUoxI4aHCBG', 'nguyet.lo@example.org', '+84-241-900-6828', 'Cụ. Tăng Lâm', '1990-06-19', 1, '9 Phố Giao Đạt Quyền', 3220, '/img/avatar/default-avatar.png', NULL, '2022-11-10 12:26:56', '2022-11-10 12:26:56', '2022-11-10 12:26:56', NULL, '2022-11-10 00:26:56'),
('3830d460-30a2-4a7e-b475-67f749135b5a', 'trinh.sa', '$2y$10$MleOuCxWCjXPInRaN3ldouVrD77uqlxcYhZyW19dPIbrdUT0RQCD2', 'ong.du@example.org', '(08) 3993 4544', 'Từ Hằng', '1986-12-09', 2, '49 Phố La Trọng Sỹ', 4295, '/img/avatar/default-avatar.png', 1, '2022-11-10 12:49:49', '2022-11-10 12:26:56', '2022-11-10 12:49:49', NULL, '2022-11-10 00:26:55'),
('42d1e7e6-f0f6-42fd-99a3-bcc092d36d98', 'khue.mang', '$2y$10$ZPHWV5E7SyUnA87ADs/YDOltWi0K1XjN8yMaZxJAvQ5GXeyFPaInm', 'lac.han@example.net', '(076)628-2398', 'Em. Cung Giang', '2004-08-17', 1, '9933 Phố Ân', 506, '/img/avatar/default-avatar.png', NULL, '2022-11-10 12:26:56', '2022-11-10 12:26:56', '2022-11-10 12:26:56', NULL, '2022-11-10 00:26:55'),
('8cf04c09-809b-47b6-a5b1-62dc88331ef6', 'nghia79', '$2y$10$I.uoTNYiQPA11LqvACPRIus/Jwa8NagZ7dI7BS1XrX0ESUdYtDYBa', 'dao63@example.net', '0711 268 1765', 'Tông Kim Tráng', '1982-09-07', 0, '22 Phố Sử Vỹ Hải', 7767, '/img/avatar/default-avatar.png', NULL, '2022-11-10 12:26:56', '2022-11-10 12:26:56', '2022-11-10 12:26:56', NULL, '2022-11-10 00:26:56'),
('9ce3405e-9101-4955-8281-dd4c4a1fcb33', 'jla', '$2y$10$jKHVYYh1ZXczuRyNhz7JUeT7ELCjrlPSg2fCjPGvTZ9EGGU3SHbE6', 'echu@example.com', '(84)(651)021-3452', 'Cấn Dã Hòa', '2001-06-09', 2, '322 Phố Lê', 8641, '/img/avatar/default-avatar.png', NULL, '2022-11-10 12:26:56', '2022-11-10 12:26:56', '2022-11-10 12:26:56', NULL, '2022-11-10 00:26:55'),
('afdb9d64-d857-4e9f-8c61-891a76102f56', 'c.le', '$2y$10$5ECxjgkuImW59BnPkOMYa.dAsBW3axyyqUTTi1wE1v7IQnjFvQevm', 'tien.ho@example.com', '+84-125-814-3229', 'Bà. Trình Ngân Thu', '1995-06-05', 2, '9443 Phố Dã Quân Lộ', 8869, '/img/avatar/default-avatar.png', NULL, '2022-11-10 12:26:56', '2022-11-10 12:26:56', '2022-11-10 12:26:56', NULL, '2022-11-10 00:26:56'),
('b519b658-8442-4226-ad3d-02398016b919', 'm61', '$2y$10$UmSgMWq0wXDPT.HfIZ2D7.BcEuIB498afUaL.hqSHzxSr8xnDJQSy', 'thao.cung@example.net', '025-130-0736', 'Quản Đinh Ngọc', '1971-08-05', 0, '5682 Phố Thái Hiếu Duyên', 2698, '/img/avatar/default-avatar.png', NULL, '2022-11-10 12:26:56', '2022-11-10 12:26:56', '2022-11-10 12:26:56', NULL, '2022-11-10 00:26:55'),
('ba043a13-5adf-4203-95bf-f624501f63c8', 'yen.lc', '$2y$10$qxJg6U3.7YCW/yNonDJIneUN6kbou9Twl6S.QqEAEUKVfjh5CAJM2', 'anh.pham@example.com', '(84)(68)650-4222', 'Em. Bạch Đông Lâm', '2007-11-05', 1, '57 Phố Lý Khải Vy', 4520, '/img/avatar/default-avatar.png', NULL, '2022-11-10 12:26:56', '2022-11-10 12:26:56', '2022-11-10 12:26:56', NULL, '2022-11-10 00:26:55'),
('be97b263-3111-42b7-830b-168982c4439e', 'cong', '$2y$10$jpvjhMnSuezP7kJjhQNb3.xD/2PAF7HV/oYaD2beMd624dFNIPv6O', 'bu.linh@example.org', '037-249-4722', 'Em. Tạ Hồ Thiên', '2002-12-21', 0, '7 Phố Ngụy Nhàn Vinh', 9126, '/img/avatar/default-avatar.png', NULL, '2022-11-10 12:26:56', '2022-11-10 12:26:56', '2022-11-10 12:26:56', NULL, '2022-11-10 00:26:56'),
('ccbeae3c-b7d4-4276-a2ca-94a399121851', 'test123456', '$2y$10$1h2pch1wW2mMWMXXkJTjBeviy0V2I8QkoytTedq9kixMeTtFkvKQy', 'nightknight011@gmail.com', '019238915871', 'Lê Thế Vinh', '1997-01-22', 0, 'địa chỉ test lần cuối 2', 0, '/img/avatar/default-avatar.png', NULL, '2022-11-10 12:36:35', '2022-11-10 12:36:04', '2022-11-10 12:36:35', NULL, '2022-11-10 12:36:35'),
('e23b34a8-f383-4ccd-a7a7-1de03981409b', 'admin', '$2y$10$OkhxP3xt0fXcqQQLhXtdKOzqlxSRMowOj5dPkh3rOOdeB5QIqqTkq', 'alibis_intron.0x@icloud.com', '0586801768', 'Lê Thế Tí', '1997-01-22', 0, '68 Nguyễn Thị Minh Khai, Quận 1, TP. HCM', 0, '/img/avatar/0.18752200 1668083573-thit-bo-product-1.jpg', NULL, '2022-11-10 12:33:35', '2022-11-10 12:26:55', '2022-11-10 12:33:35', NULL, '2022-11-10 12:26:55');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` tinyint(4) NOT NULL,
  `role_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `upper_role_id` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role_name`, `upper_role_id`) VALUES
(1, 'admin', NULL),
(2, 'moderator', 1),
(3, 'customer', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_role_user`
--

CREATE TABLE `user_role_user` (
  `id` bigint(20) NOT NULL,
  `user_uuid` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `user_role_id` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_role_user`
--

INSERT INTO `user_role_user` (`id`, `user_uuid`, `user_role_id`) VALUES
(1, 'e23b34a8-f383-4ccd-a7a7-1de03981409b', 1),
(5, '15d27e7f-455d-4d55-b8ac-0f1ee089029a', 2),
(7, '42d1e7e6-f0f6-42fd-99a3-bcc092d36d98', 2),
(8, '8cf04c09-809b-47b6-a5b1-62dc88331ef6', 2),
(10, 'afdb9d64-d857-4e9f-8c61-891a76102f56', 2),
(11, 'b519b658-8442-4226-ad3d-02398016b919', 2),
(12, 'ba043a13-5adf-4203-95bf-f624501f63c8', 2),
(13, 'be97b263-3111-42b7-830b-168982c4439e', 2),
(2, 'e23b34a8-f383-4ccd-a7a7-1de03981409b', 2),
(4, '0001599b-2d7d-407e-85ac-af2d8cf413d7', 3),
(6, '3830d460-30a2-4a7e-b475-67f749135b5a', 3),
(9, '9ce3405e-9101-4955-8281-dd4c4a1fcb33', 3),
(14, 'ccbeae3c-b7d4-4276-a2ca-94a399121851', 3),
(3, 'e23b34a8-f383-4ccd-a7a7-1de03981409b', 3);

-- --------------------------------------------------------

--
-- Table structure for table `warehouse`
--

CREATE TABLE `warehouse` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `warehouse`
--

INSERT INTO `warehouse` (`id`, `name`, `address`, `phone_number`, `email`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'Thôi-Lưu', '90 Phố Vương', '84-79-617-9261', 'fcam@nham.ac.vn', NULL, '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(2, 'Tiếp, Ngân and Khúc', '826 Phố Cát', '(84)(163)346-0757', 'vng59@mang.com', NULL, '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(3, 'Điền-Đôn', '9 Phố Hường', '(092) 612 5632', 'ha.triet@u.ac.vn', NULL, '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(4, 'Bùi Ltd', '4577 Phố Trần Dao Diệp', '+84-53-200-4702', 'nghiem.chuong@cam.biz.vn', NULL, '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(5, 'Lý-Đậu', '1247 Phố Bạch', '038-141-0883', 'hai.kha@tao.int.vn', NULL, '2022-11-10 12:26:55', '2022-11-10 12:26:55'),
(6, 'Tên nhà kho test đổi tên', 'địa chỉ nhà kho test', '091823197419', 'example@example.com', 1, '2022-11-10 12:50:50', '2022-11-10 12:51:21');

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_product`
--

CREATE TABLE `warehouse_product` (
  `id` bigint(20) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `warehouse_product`
--

INSERT INTO `warehouse_product` (`id`, `warehouse_id`, `product_id`) VALUES
(1, 5, 1),
(2, 3, 2),
(3, 1, 3),
(4, 4, 4),
(5, 3, 5),
(6, 3, 6),
(7, 2, 7),
(8, 2, 8),
(9, 3, 9),
(10, 5, 10),
(11, 4, 11),
(12, 4, 12),
(13, 5, 13),
(14, 2, 14);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_uuid` (`user_uuid`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `model_id` (`model_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `parent_category_id` (`parent_category_id`);

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discount_user`
--
ALTER TABLE `discount_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_uuid` (`user_uuid`),
  ADD KEY `discount_id` (`discount_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `model_id` (`model_id`);

--
-- Indexes for table `merchant`
--
ALTER TABLE `merchant`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `address` (`address`),
  ADD UNIQUE KEY `phone_number` (`phone_number`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `merchant_product`
--
ALTER TABLE `merchant_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `merchant_id` (`merchant_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model`
--
ALTER TABLE `model`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `user_uuid` (`user_uuid`),
  ADD KEY `order_ibfk_2` (`status_id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_uuid` (`order_uuid`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `model_id` (`model_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `payment_method_id` (`payment_method_id`);

--
-- Indexes for table `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `SKU` (`SKU`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `user_email_unique` (`email`),
  ADD UNIQUE KEY `user_phone_number_unique` (`phone_number`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `upper_role_id` (`upper_role_id`);

--
-- Indexes for table `user_role_user`
--
ALTER TABLE `user_role_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_role_user_user_role_id_user_uuid_unique` (`user_role_id`,`user_uuid`),
  ADD KEY `user_uuid` (`user_uuid`),
  ADD KEY `user_role_id` (`user_role_id`);

--
-- Indexes for table `warehouse`
--
ALTER TABLE `warehouse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warehouse_product`
--
ALTER TABLE `warehouse_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warehouse_id` (`warehouse_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `discount_user`
--
ALTER TABLE `discount_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `merchant`
--
ALTER TABLE `merchant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `merchant_product`
--
ALTER TABLE `merchant_product`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `model`
--
ALTER TABLE `model`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_role_user`
--
ALTER TABLE `user_role_user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `warehouse`
--
ALTER TABLE `warehouse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `warehouse_product`
--
ALTER TABLE `warehouse_product`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD CONSTRAINT `cart_item_ibfk_1` FOREIGN KEY (`user_uuid`) REFERENCES `user` (`uuid`),
  ADD CONSTRAINT `cart_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `cart_item_ibfk_3` FOREIGN KEY (`model_id`) REFERENCES `model` (`id`);

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`parent_category_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `discount_user`
--
ALTER TABLE `discount_user`
  ADD CONSTRAINT `discount_user_ibfk_1` FOREIGN KEY (`user_uuid`) REFERENCES `user` (`uuid`),
  ADD CONSTRAINT `discount_user_ibfk_2` FOREIGN KEY (`discount_id`) REFERENCES `discount` (`id`);

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`model_id`) REFERENCES `model` (`id`);

--
-- Constraints for table `merchant_product`
--
ALTER TABLE `merchant_product`
  ADD CONSTRAINT `merchant_product_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`id`),
  ADD CONSTRAINT `merchant_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `model`
--
ALTER TABLE `model`
  ADD CONSTRAINT `model_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_uuid`) REFERENCES `user` (`uuid`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`order_uuid`) REFERENCES `order` (`uuid`),
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `order_item_ibfk_3` FOREIGN KEY (`model_id`) REFERENCES `model` (`id`);

--
-- Constraints for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD CONSTRAINT `payment_details_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `order` (`uuid`),
  ADD CONSTRAINT `payment_details_ibfk_2` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_method` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`upper_role_id`) REFERENCES `user_role` (`id`);

--
-- Constraints for table `user_role_user`
--
ALTER TABLE `user_role_user`
  ADD CONSTRAINT `user_role_user_ibfk_1` FOREIGN KEY (`user_uuid`) REFERENCES `user` (`uuid`),
  ADD CONSTRAINT `user_role_user_ibfk_2` FOREIGN KEY (`user_role_id`) REFERENCES `user_role` (`id`);

--
-- Constraints for table `warehouse_product`
--
ALTER TABLE `warehouse_product`
  ADD CONSTRAINT `warehouse_product_ibfk_1` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouse` (`id`),
  ADD CONSTRAINT `warehouse_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
