-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- 主机： localhost:3306
-- 生成日期： 2026-10-31 20:57:34
-- 服务器版本： 8.0.46-37
-- PHP 版本： 8.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `staqwjmy_luma_shop`
--

-- --------------------------------------------------------

--
-- 表的结构 `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `url` varchar(256) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(32) NOT NULL,
  `date_create` datetime NOT NULL,
  `date_modify` datetime NOT NULL,
  `description` text NOT NULL,
  `thumbnail` varchar(128) NOT NULL,
  `images` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `products`
--

INSERT INTO `products` (`id`, `name`, `email`, `url`, `price`, `category`, `date_create`, `date_modify`, `description`, `thumbnail`, `images`) VALUES
(1, 'Monstera', 'plant@example.com', 'monstera', 28.00, 'Indoor', '2026-10-31 20:56:03', '2026-10-31 20:56:03', 'A tropical plant with beautiful split leaves.', 'monstera.jpg', 'monstera.jpg'),
(2, 'Snake Plant', 'plant@example.com', 'snake-plant', 24.00, 'Indoor', '2026-10-31 20:56:03', '2026-10-31 20:56:03', 'An easy-care plant with tall upright leaves.', 'snake-plant.jpg', 'snake-plant.jpg'),
(3, 'Golden Pothos', 'plant@example.com', 'golden-pothos', 18.00, 'Hanging', '2026-10-31 20:56:03', '2026-10-31 20:56:03', 'A trailing plant with green and golden leaves.', 'golden-pothos.jpg', 'golden-pothos.jpg'),
(4, 'Peace Lily', 'plant@example.com', 'peace-lily', 32.00, 'Indoor', '2026-10-31 20:56:03', '2026-10-31 20:56:03', 'An elegant plant with glossy leaves and white blooms.', 'peace-lily.jpg', 'peace-lily.jpg'),
(5, 'ZZ Plant', 'plant@example.com', 'zz-plant', 26.00, 'Low Light', '2026-10-31 20:56:03', '2026-10-31 20:56:03', 'A hardy plant with shiny dark green leaves.', 'zz-plant.jpg', 'zz-plant.jpg'),
(6, 'Rubber Plant', 'plant@example.com', 'rubber-plant', 35.00, 'Indoor', '2026-10-31 20:56:03', '2026-10-31 20:56:03', 'A beautiful plant with large glossy leaves.', 'rubber-plant.jpg', 'rubber-plant.jpg'),
(7, 'Fiddle Leaf Fig', 'plant@example.com', 'fiddle-leaf-fig', 48.00, 'Statement', '2026-10-31 20:56:03', '2026-10-31 20:56:03', 'A statement plant with large violin-shaped leaves.', 'fiddle-leaf-fig.jpg', 'fiddle-leaf-fig.jpg'),
(8, 'Spider Plant', 'plant@example.com', 'spider-plant', 19.00, 'Hanging', '2026-10-31 20:56:03', '2026-10-31 20:56:03', 'A cheerful plant with long arching striped leaves.', 'spider-plant.jpg', 'spider-plant.jpg'),
(9, 'Aloe Vera', 'plant@example.com', 'aloe-vera', 16.00, 'Succulent', '2026-10-31 20:56:03', '2026-10-31 20:56:03', 'A succulent with thick fleshy green leaves.', 'aloe-vera.jpg', 'aloe-vera.jpg'),
(10, 'Chinese Money Plant', 'plant@example.com', 'chinese-money-plant', 25.00, 'Indoor', '2026-10-31 20:56:03', '2026-10-31 20:56:03', 'A charming plant with round coin-shaped leaves.', 'chinese-money-plant.jpg', 'chinese-money-plant.jpg'),
(11, 'Bird of Paradise', 'plant@example.com', 'bird-of-paradise', 55.00, 'Statement', '2026-10-31 20:56:03', '2026-10-31 20:56:03', 'A tropical plant with large dramatic foliage.', 'bird-of-paradise.jpg', 'bird-of-paradise.jpg'),
(12, 'Heartleaf Philodendron', 'plant@example.com', 'heartleaf-philodendron', 22.00, 'Hanging', '2026-10-31 20:56:03', '2026-10-31 20:56:03', 'A trailing plant with beautiful heart-shaped leaves.', 'heartleaf-philodendron.jpg', 'heartleaf-philodendron.jpg');

--
-- 转储表的索引
--

--
-- 表的索引 `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
