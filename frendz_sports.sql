-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2023 at 09:21 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `frendz_sports`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(30) NOT NULL,
  `category_description` text NOT NULL,
  `category_posted` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_description`, `category_posted`) VALUES
(2, 'Jerseys', 'Welcome to the Jerseys section at Frendz Sports, your ultimate destination for top-quality and best value soccer jerseys and apparel! Our Jerseys collection is designed to bring you the latest trends, premium materials, and a wide variety of options to showcase your love for the beautiful game.  At Frendz Sports, we understand the significance of jerseys in the soccer world. They&#039;re not just pieces of clothing; they&#039;re symbols of your loyalty to your favorite teams and players. Whether you&#039;re a passionate supporter of international clubs, national teams, or legendary players, our Jerseys category has something special for every soccer enthusiast.', '2023-08-10 13:11:05'),
(3, 'Sports Sweatpants', 'All the best quality sweatpants/trousers from famous brands could be found here.', '2023-08-10 13:46:27'),
(6, 'Outdoor Soccer Boots', 'All the latest outdoor soccer cleats are available in our store with the best possible price.', '2023-08-11 19:34:01'),
(7, 'Indoor Soccer Turfs', 'All the latest indoor soccer cleats are available in our store with the best possible price.', '2023-08-11 19:44:58'),
(8, 'Jackets', 'Welcome to the Jackets section at Frendz Sports, your ultimate destination for top-quality and best value soccer jackets and apparel! ', '2023-08-11 19:51:18');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_commentername` text NOT NULL,
  `comment` text NOT NULL,
  `comment_view` varchar(10) NOT NULL DEFAULT 'public',
  `comment_disemvowel` varchar(5) NOT NULL DEFAULT 'no',
  `comment_posted` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `product_id`, `user_id`, `user_commentername`, `comment`, `comment_view`, `comment_disemvowel`, `comment_posted`) VALUES
(4, 7, 3, 'Shudipto Podder', 'Excellent Product', 'public', 'no', '2023-08-11 00:54:40'),
(5, 25, 4, 'Ryan Gosling', 'Amazing Boot', 'hide', 'no', '2023-08-11 19:48:55');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `image_id` int(11) NOT NULL,
  `image_filename` varchar(100) NOT NULL,
  `image_description` text NOT NULL DEFAULT 'user did not describe the image.',
  `image_posted` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`image_id`, `image_filename`, `image_description`, `image_posted`) VALUES
(1, 'pexels-saraí-carrasco-17060538.jpg', 'user did not describe the image.', '2023-08-09 21:53:42'),
(2, 'pexels-saraí-carrasco-17060538.jpg', 'user did not describe the image.', '2023-08-09 21:54:12'),
(3, 'pexels-saraí-carrasco-17060538.jpg', 'user did not describe the image.', '2023-08-09 21:55:38'),
(4, 'J1.png', 'user did not describe the image.', '2023-08-10 13:17:38'),
(5, 'j2.png', 'user did not describe the image.', '2023-08-10 13:27:04'),
(6, 'j3.png', 'user did not describe the image.', '2023-08-10 13:28:17'),
(7, 'J4.png', 'user did not describe the image.', '2023-08-10 13:31:18'),
(8, 'j5.png', 'user did not describe the image.', '2023-08-10 13:33:01'),
(9, 'j6.png', 'user did not describe the image.', '2023-08-10 13:37:16'),
(10, 'one.png', 'user did not describe the image.', '2023-08-10 13:41:47'),
(11, 's1.png', 'user did not describe the image.', '2023-08-10 13:49:28'),
(12, 's2.png', 'user did not describe the image.', '2023-08-10 13:50:14'),
(13, 's3.png', 'user did not describe the image.', '2023-08-10 14:00:15'),
(14, 's4.png', 'user did not describe the image.', '2023-08-10 14:15:21'),
(15, 's5.png', 'user did not describe the image.', '2023-08-10 14:17:52'),
(16, 'o1.png', 'user did not describe the image.', '2023-08-11 19:34:30'),
(17, 'o2.png', 'user did not describe the image.', '2023-08-11 19:35:12'),
(18, 'o4.png', 'user did not describe the image.', '2023-08-11 19:35:46'),
(19, 'o5.png', 'user did not describe the image.', '2023-08-11 19:36:27'),
(20, 'o6.png', 'user did not describe the image.', '2023-08-11 19:37:01'),
(21, 'o7.png', 'user did not describe the image.', '2023-08-11 19:37:45'),
(22, 'o8.png', 'user did not describe the image.', '2023-08-11 19:38:16'),
(23, 'i1.png', 'user did not describe the image.', '2023-08-11 19:44:47'),
(24, 'i2.png', 'user did not describe the image.', '2023-08-11 19:45:32'),
(25, 'i3.png', 'user did not describe the image.', '2023-08-11 19:46:08'),
(26, 'i4.png', 'user did not describe the image.', '2023-08-11 19:46:39'),
(27, 'i5.png', 'user did not describe the image.', '2023-08-11 19:47:25'),
(28, 'i6.png', 'user did not describe the image.', '2023-08-11 19:47:51'),
(29, 'i7.png', 'user did not describe the image.', '2023-08-11 19:48:18'),
(30, 'j1.png', 'user did not describe the image.', '2023-08-11 19:53:14'),
(31, 'j2.png', 'user did not describe the image.', '2023-08-11 19:55:33'),
(32, 'ja1.png', 'user did not describe the image.', '2023-08-11 19:56:45'),
(33, 'ja2.png', 'user did not describe the image.', '2023-08-11 19:57:52'),
(34, 'a1.png', 'user did not describe the image.', '2023-08-11 19:59:13'),
(35, 'a2.png', 'user did not describe the image.', '2023-08-11 20:00:42'),
(36, 'a0.png', 'user did not describe the image.', '2023-08-11 20:01:50');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image_id` int(11) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `product_description` text NOT NULL,
  `product_price` decimal(10,0) NOT NULL,
  `product_availability` tinyint(4) NOT NULL,
  `product_posted` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `image_id`, `product_name`, `product_description`, `product_price`, `product_availability`, `product_posted`) VALUES
(6, 2, 4, 'Inter Miami 23-24 Home Jersey (Messi Edition)', 'This is the debut jersey for Messi in Inter Miami and it&#039;s their latest home kit with Messi&#039;s name printed on it.', 89, 1, '2023-08-10 13:17:38'),
(7, 2, 5, 'Manchester City 23-24 Home Jersey', 'This is the latest home jersey of the reigning premier league champions.', 59, 1, '2023-08-10 13:27:04'),
(8, 2, 6, 'Juventus 23-24 Home Jersey', 'The latest jersey of Juventus with an unique design.', 59, 1, '2023-08-10 13:28:17'),
(9, 2, 7, 'PSG 23-24 Home Jersey', 'The latest arrival of PSG&#039;s Home Jersey with a classic look.', 59, 1, '2023-08-10 13:31:18'),
(10, 2, 8, 'Argentina WC 2022 Home Kit', 'Argentina&#039;s world cup champions edition', 75, 1, '2023-08-10 13:33:01'),
(11, 2, 9, 'Barcelona 2010-11 Home Kit', 'This is the champions league winner edition and absolutely a VINTAGE one.', 89, 0, '2023-08-10 13:37:16'),
(12, NULL, 10, 'Nike Zoom Mercurial Superfly 9 Elite FG', 'The Nike Zoom Mercurial Superfly 9 Elite FG cleat features airy comfort, inside cushioning and tri-star studs. One of the many unique features of this cleat is the incorporation of the Zoom technology, which is designed to make the shoe incredibly comfortable. Plus, The lightweight midsole features boosted cushioning that delivers springy responsive energy upon impact and helps propel you forward on the turf&mdash;a soccer player&rsquo;s dream. According to one reviewer, the studs assist to &ldquo;provide multidirectional traction with every step.&rdquo;', 279, 1, '2023-08-11 00:39:28'),
(13, 3, 11, 'Nike Dri-FIT Academy Sweatpants', 'The Nike Dri-FIT Academy Pants are made with sweat-wicking fabric to keep you dry and comfortable&mdash;whether you&#039;re working on your game or keeping it casual while on the go.', 68, 1, '2023-08-10 13:49:28'),
(14, 3, 12, 'Adidas Tiro Pants', 'Take your soccer style beyond the touchline. Thanks to those signature tapered legs, these adidas Tiro pants need no introduction. Born on the training ground, they feature ankle zips for easy on and off and moisture-managing AEROREADY for comfortable movement. Zip pockets offer secure storage for your everyday essentials.', 68, 1, '2023-08-10 13:50:14'),
(15, 3, 13, 'Manchester City Puma DryCELL Team Training Pants - Black', 'Make the most of your next workout or afternoon cheering Manchester City when you choose these training pants. Complete with distinct club graphics, these Puma pants will pair perfectly with your go-to match day tee and cap. Designed with DryCELL technology that wicks moisture away, they&#039;re sure to keep you cool throughout the day.', 80, 1, '2023-08-10 14:00:15'),
(16, 3, 14, 'Juventus Tiro 23 Training Pants', 'When you&#039;ve built up a reputation for sparkling soccer, the time you spend between matches is as important as the time you spend on the pitch. These adidas Tiro 23 pants help Juventus players maintain their high standards at the training ground. Moisture-wicking AEROREADY and a slim, streamlined fit make movement a breeze.', 82, 1, '2023-08-10 14:15:21'),
(17, 3, 15, ' Under Armour Men&#039;s Challenger Training Pants', 'Conquer every challenge in Under Armour Men&#039;s Challenger Training Pants. Using 4-way stretch construction to move better in every direction, the smooth, stretchy fabric is ultra-lightweight and lets you move. The material also wicks sweat and dries fast. Enjoy style and functionality with a tapered leg fit and ankle zips for easy on and off even over cleats. Convenient storage and an adjustable fit are provided by an encased elastic waistband and internal drawcord and secure, hand zip pockets.', 65, 1, '2023-08-10 14:17:52'),
(19, 6, 16, 'adidas Predator Accuracy .4 FxG', 'Gear up for the pitch with these men&#039;s Predator Accuracy .4 FxG football boots from adidas. Coming in a Core Black colourway, these game-ready boots have a soft synthetic upper with a textured finish to help you keep control of the ball. They have a tonal lace fastening with padding around the ankle collar for a locked-in fit, while a tough and versatile with grippy studs delivers traction on mixed grounds. Finished with signature adidas branding.', 250, 1, '2023-08-11 19:34:30'),
(20, 6, 17, 'adidas X Crazyfast .3 FG Junior', 'Finetune your skills in these juniors&#039; X Crazyfast .3 FG football boots from adidas. In a White and Lucid Lemon colourway, these football boots have a lightweight coated textile upper for complete control of the ball. They feature a tonal lace closure and a flat-knit collar for a secure fit, with a grippy studded outsole for essential traction, even at high speeds. Finished with classic adidas branding throughout', 179, 1, '2023-08-11 19:35:12'),
(21, 6, 18, 'Nike Mercurial Vapor Club FG', 'Hit the pitch and put in a big performance with these men&#039;s Mercurial Vapor Club FG football boots from Nike. In a Black, Chrome and Hyper Royal colourway, these boots are cut from durable synthetic in the upper for a lasting wear, with texturing across the top for close control. They feature a lace fastening to lock you in, with a padded collar for support and internal speed cage for a snug, secure fit. Underfoot, they sit on a cushioned insole and have a firm ground stud plate for traction. Finished up with signature Nike branding.', 267, 1, '2023-08-11 19:35:46'),
(22, 6, 19, 'Puma FUTURE Match FG', 'Get total control over your game with these men&#039;s FUTURE Match FG football boots from PUMA. In a Black colourway, these boots have a stretchy knit collar to hug your ankle, while the engineered mesh FUZIONFIT360 upper has 3D textures at key contact zones for a precise touch, pass and shot. They&#039;re sat above a cushioned insole and a lightweight Dynamic Motion System outsole with firm ground-ready studs for standout traction and acceleration when changing directions. Finished with Silver PUMA Cat logos.', 225, 1, '2023-08-11 19:36:27'),
(23, 6, 20, 'adidas Predator Accuracy .2 MG', 'Made to hit the mark, these men&#039;s Predator Accuracy .2 MG football boots from adidas are essetnials. In a White, Black and Lucid Lemon colourway, these boots have a soft and adaptive HybridTouch upper that&#039;s made using at least 50% recycled content. They&#039;re equipped with High Definition Grip rubber elements and a mix of embossed and debossed details to keep you in control. Featuring a secure lace up fastening and a mid-cut knit textile collar, these boots are sat on a versatile outsole that excels on firm ground, hard ground and artificial grass pitches. Finished with the iconic 3-Stripes to the sidewalls', 299, 1, '2023-08-11 19:37:01'),
(24, 6, 21, 'Puma Future Pro FG', 'Gear up for the game in these men&#039;s Future Pro FG football boots from PUMA. In a Fast Yellow colourway, these boots have a durable FUZIONFIT360 dual-mesh upper with PWRTAPE support. They have engineered 3D textures at high-contact spots to help you control the ball, and feature a tonal lace closure with a soft, stretchy knit collar for a locked fit. They have a lightweight Dynamic Motion System outsole with grippy studs for traction on firm ground, and are finished with bold PUMA branding throughout.', 229, 0, '2023-08-11 19:37:45'),
(25, 6, 22, 'Puma Ultra Ultimate FG', 'Put in a game-winning display with these men&#039;s Ultra Ultimate FG football boots from PUMA. In an Electric Peppermint and PUMA White colourway, these boots are cut from light, durable ULTRAWEAVE in the upper, made from at least 20% recycled material. They feature a lace fastening for a secure fit, with a removeable sockliner that uses NanoGrip tech to keep your foot from slipping. They&#039;re built with PWRTAPE AND PWRPRINT for added support and stability, while underfoot, the SPEEDPLATE adds traction and acceleration on firm ground. Finished up with signature PUMA branding.', 275, 1, '2023-08-11 19:38:16'),
(26, 7, 23, 'Puma Future Play TT', 'Gear up for the game in these men&#039;s Future Play TT football boots from PUMA. In a White and Orchid colourway, these boots have a lightweight engineered mesh upper with smooth synthetic overlays for lasting wear. With textured spots to keep control of the ball, they have a secure lace fastening to lock you in. An EVA midsole offers underfoot comfort, while a low-profile studded rubber sole delivers grippy traction on turf. Finished up with classic PUMA branding throughout.', 209, 1, '2023-08-11 19:44:47'),
(27, 7, 24, 'Nike Mercurial Superfly Club TF Junior', 'Show off your skillset with these juniors&#039; Mercurial Superfly Club TF football boots from Nike. In a Black and Dark Smoke Grey colourway, these boots are cut from light, durable synthetic material in the upper, with a textured surface for a better touch. They feature a lace fastening to lock you in, with a padded collar for added support and a cushioned insole for a snug fit. Underfoot, they sit on a grippy rubber outsole for total traction and are finished up with Nike Swoosh branding to the sidewalls.', 149, 1, '2023-08-11 19:45:32'),
(28, 7, 25, 'Puma Ultra Play TT', 'Lace up and get set to play in these men&#039;s Ultra Play TT football boots from PUMA. In a Black colourway, these boots have a lightweight PU upper that&#039;s comfy and durable. They feature a lace up fastening to lock you in, as well as a padded collar for support. With a multi-studded rubber outsole underfoot for use on artificial turf, these football boots are finished up with a Formstrip to the sidewalls and PUMA branding to the tongue.', 200, 1, '2023-08-11 19:46:08'),
(29, 7, 26, 'adidas X Crazyfast .4 TF', 'Take control with these men&#039;s X Crazyfast .4 TF football boots from adidas. In a White colourway, these boots have a light but durable textile upper that&#039;s made with at least 50% recycled materials. They feature coating to the upper that enhances your control, a lace fastening to lock you in and a low-cut padded ankle collar for snugness. Underfoot is an EVA midsole that delivers cushioned comfort as you move and a lugged rubber outsole for traction. Finished with the 3-Stripes to the sides', 233, 0, '2023-08-11 19:46:39'),
(30, 7, 27, 'adidas Predator Accuracy.4 TF', 'Be at your best in these men&#039;s Predator Accuracy.4 TF football boots from adidas. Landing in a White colourway, these boots have a soft but durable synthetic upper that&#039;s made with at least 50% recycled content. They feature a lace fastening to keep you locked in and a low-cut padded ankle collar for a plush feel. With a rubber outsole for essential grip when you&#039;re ballin&#039;, they&#039;re signed off with the 3-Stripes to the sidewalls', 240, 1, '2023-08-11 19:47:25'),
(31, 7, 28, 'adidas Predator Accuracy.4 TF', 'Take control of the game with these men&#039;s Predator Accuracy.4 TF football trainers from adidas. In a Core Black colourway, these indoor and artificial-specific trainers have a textured synthetic upper for added grip and accuracy when passing and shooting. They have a secure lace-up front and a cushioned insole for comfy play. With a lugged rubber outsole for total traction, these trainers are finished up with tonal 3-Stripes to the sidewalls and a Badge of Sport at the heel', 219, 1, '2023-08-11 19:47:51'),
(32, 7, 29, 'adidas X SpeedPortal .4 TF', 'Own your 5-a-side game with these men&#039;s X SpeedPortal .4 TF football boots from adidas. In a Core Black colourway, these boots are cut from light, durable synthetic material in the upper, including at least 50% recycled content, with coated textile for better grip on the ball. They feature a lace fastening to lock you in, with a padded collar for extra support. Underfoot, they sit on a cushioned EVA midsole for a smooth ride, with a lugged, rubber outsole for traction and acceleration on artificial surfaces. Finished up with signature 3-Stripes and Badge of Sport branding', 250, 1, '2023-08-11 19:48:18'),
(33, 8, 30, 'JUVENTUS ICON TOP', 'Show off some &#039;90s vibes. Everything about this Juventus top shouts soccer classic. Based on the iconic adidas Equipment look, it displays signature central team details and oversized 3-Stripes wrapped around its sleeves. Perfect for wearing over your training jersey it also has the baggy, loose fit that became synonymous with the beautiful game during that larger-than-life era.', 100, 1, '2023-08-11 19:53:14'),
(34, 8, 31, 'MANCHESTER UNITED WINDBREAKER', 'Take shelter in an adidas windbreaker inspired by Manchester United&#039;s stadium. Repeating across the woven shell of this jacket, a top-down view of Old Trafford reveals your soccer roots. Once on, its slim fit and tough woven shell will keep you plowing ahead on breezy days. A contrast team badge on the chest adds that important final detail.', 110, 1, '2023-08-11 19:55:33'),
(35, 8, 32, 'JAPAN TIRO 22 TRAVEL JACKET', 'Motivated by a turning point in their soccer journey. The design on this adidas jacket nods to the home shirt Japan wore when they failed to qualify for the sport&#039;s biggest tournament in 1993. But any melancholy memories are left behind by the pride of the team&#039;s progress ever since. A powerful symbol of where determination can take you, it includes moisture-absorbing AEROREADY for comfortable travel.', 108, 0, '2023-08-11 19:56:45'),
(36, 8, 33, 'ITALY 125TH ANNIVERSARY JACKET', 'Toasting the 125th anniversary of the Italian Football Federation. Part of a limited-edition collection inspired by the kit Italy wore during their first match on May 15th, 1910, this adidas jacket will keep you comfortable in smooth plain weave fabric. Standing out from the same crisp white colors the team wore on that day, a special commemorative badge finishes the look in style.', 120, 1, '2023-08-11 19:57:52'),
(37, 8, 34, 'REAL MADRID GRAPHIC WINDBREAKER', 'Take shelter in a windbreaker inspired by Real Madrid&#039;s revamped stadium. Reflecting the arena&#039;s gleaming exterior, an iridescent adidas Badge of Sport and club crest catch the eye over this soccer jacket&#039;s clean white colors. When you pull it on, its slim fit and tough woven shell will keep you plowing on when the elements refuse to play ball.', 110, 1, '2023-08-11 19:59:13'),
(38, 8, 35, 'Arsenal Windbreaker Jacket', 'Take shelter in an adidas windbreaker inspired by Arsenal&#039;s home. The Emirates Stadium&#039;s world-famous profile provided the inspiration for this jacket&#039;s undulating graphics. Slim-fitting, it has a tough woven construction that&#039;ll keep you comfortable when the wind gets up. A crest on the front proves you have a thing for first-class soccer', 100, 0, '2023-08-11 20:00:42'),
(39, 8, 36, 'FC BAYERN ANTHEM REVERSIBLE JACKET', 'Supporting FC Bayern is non-negotiable, but you can choose how you display your devotion. The adidas top players zip up in before standing in the pre-game lineup, this soccer jacket is reversible. Turn it inside out to reveal the bold, &#039;90s-inspired graphic that makes the club&#039;s pre-match jersey stand out. Soft, smooth fabric keeps you comfortable and ready for anything.', 115, 1, '2023-08-11 20:01:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_email` varchar(260) NOT NULL,
  `user_firstname` text NOT NULL,
  `user_lastname` text NOT NULL,
  `user_password` varchar(70) NOT NULL,
  `user_role` text DEFAULT 'user',
  `user_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_firstname`, `user_lastname`, `user_password`, `user_role`, `user_created`) VALUES
(2, 'admin', 'shudiptopodder73@gmail.com', 'SHUDIPTO', 'PODDER', '12121212', 'admin', '2023-08-09 04:34:59'),
(3, 'Podder', 'admin@example.com', 'Shudipto', 'Podder', '$2y$10$FYzpn/pV9.TafqlAtRrI/OXtX6Y7hhpvMZSC6Dvl62UmfjNmTQlPu', 'admin', '2023-08-09 04:38:00'),
(4, 'ryan12', 'ryan@gmail.com', 'Ryan', 'Gosling', '$2y$10$hY4VwDQhZlCSVqCyoCpFM.lvT2igM3wwHCI6KQZvLqOdgMuFH7pXK', 'user', '2023-08-11 19:48:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `image_id` (`image_id`),
  ADD KEY `products_ibfk_3` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `images` (`image_id`),
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
