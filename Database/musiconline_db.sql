-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2025 at 11:58 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `musiconline_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `vinyl_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`vinyl_id`, `user_id`) VALUES
(3, 2),
(5, 3),
(7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_info`
--

CREATE TABLE `shipping_info` (
  `address1` varchar(120) DEFAULT NULL,
  `address2` varchar(120) DEFAULT NULL,
  `city` varchar(35) DEFAULT NULL,
  `c_state` varchar(35) DEFAULT NULL,
  `zip_code` int(5) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipping_info`
--

INSERT INTO `shipping_info` (`address1`, `address2`, `city`, `c_state`, `zip_code`, `user_id`) VALUES
('Off', 'Jalan Tun Sambanthan 4', 'Brickfields', 'Kuala Lumpur', 50470, 1),
('123 Street', '321 Garden', 'Brickfields', 'Kuala Lumpur', 50470, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_password` varchar(256) NOT NULL,
  `user_email` varchar(254) NOT NULL,
  `user_dob` date NOT NULL,
  `date_joined` date NOT NULL DEFAULT current_timestamp(),
  `retailer_status` tinyint(1) NOT NULL,
  `admin_status` tinyint(1) NOT NULL,
  `phone_no` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`user_id`, `user_name`, `user_password`, `user_email`, `user_dob`, `date_joined`, `retailer_status`, `admin_status`, `phone_no`) VALUES
(1, 'Dominic', '$2y$10$m6D3cRpld7OCBjjkqZZGfeQxNPj763xXwcx8vTiDuF7Snwf1Od.Cq', 'admin@gmail.com', '2025-07-15', '2025-07-28', 1, 1, '013-3557577'),
(2, 'Oscar', '$2y$10$lA6GMIOk59CMHFRRmoUUI.pY42mdjupiBRC1f2nGSJ5B893FKSHg6', 'test2@gmail.com', '2025-07-01', '2025-07-28', 1, 0, '013-3569977'),
(3, 'Bobbers', '$2y$10$R1oX1PdQVKsDdWdHNRmwFuq1kBJ.gc1vGPcQMzjL95vfeCj3P6.8q', 'test@gmail.com', '2025-07-28', '2025-08-01', 1, 0, '013-7895377');

-- --------------------------------------------------------

--
-- Table structure for table `vinyl_info`
--

CREATE TABLE `vinyl_info` (
  `vinyl_id` int(11) NOT NULL,
  `vinyl_name` varchar(300) NOT NULL,
  `uploader_id` int(11) NOT NULL,
  `vinyl_genre` char(20) NOT NULL,
  `vinyl_image` varchar(500) NOT NULL,
  `vinyl_rdate` date NOT NULL,
  `vinyl_price` decimal(10,0) NOT NULL,
  `author` varchar(30) NOT NULL,
  `vinyl_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vinyl_info`
--

INSERT INTO `vinyl_info` (`vinyl_id`, `vinyl_name`, `uploader_id`, `vinyl_genre`, `vinyl_image`, `vinyl_rdate`, `vinyl_price`, `author`, `vinyl_desc`) VALUES
(2, 'All That Jazz', 1, 'jazz', 'https://lightintheattic.net/cdn/shop/files/4995879608555_974x.png?v=1738026981', '2025-07-01', 80, 'Ghibli Jazz', 'You’d be forgiven for not knowing about these Studio Ghibli commissioned jazz reworkings of much-loved classic soundtracks with the three-piece All That Jazz being one of Japan’s best kept secrets until now. Originally put together by the power-house animation studio for a series of jazzed-up covers, the group took off with their simple yet moving set-up of piano, bass and drums, and afterwards went on to do another record of anime classics. Sprinkled with complementary instruments, the project is tied together by the soothing vocals of Yukiko Kuwahara.'),
(3, 'Constant Companions', 1, 'pop', 'https://www.veryokvinyl.com/cdn/shop/files/COVER_186d9dc1-1e9f-45bc-852e-e7aeb2a76fe5_600x.png?v=1750987141', '2016-07-13', 40, 'Jamie Paige', '\"Baby, do you know what you wanna hear?\"\r\n\r\nThis question lies at the center of Jamie Paige\'s fourth album, Constant Companions. First sung in the electrifying, dizzyingly-paced opener Dyad, these lyrics and their associated melody echo throughout the rest of the tracklist, becoming a lodestar for all the disparate lonely hearts being portrayed. Whether a frenetic longing for notoriety on ROT FOR CLOUT, a desperate longing for self-fulfillment on Cadmium Colors, or a cautious longing for the carefree on Liaison - each song finds its own unique tension between two, and ultimately settles on its own answer to that ever-present question.\r\n\r\nHowever, after the album\'s release in October 2024 - amidst the sudden viral success of Machine Love, and calls for Jamie Paige to \"put that shit on vinyl\" - some questions still remained unanswered.'),
(4, 'Ado Best Adobum Vol. 2', 1, 'electronic', 'https://www.veryokvinyl.com/cdn/shop/files/4988031764640_974x_0d529cea-b517-4418-a094-060c9b753f91_600x.png?v=1747751501', '2025-04-08', 90, 'Ado', 'All Hits, No Misses. The 22-year-old utaite Ado marks her 5th anniversary since her explosive major debut with the massive hit song “Usseewa,” released in October 2020! Currently on the largest world tour ever by a Japanese solo artist, “Hibana,” and with two major dome shows set for November at Tokyo Dome and Kyocera Dome, Ado continues to expand her career on a global scale. To celebrate the 5th anniversary of her debut, her very first greatest-hits album “Ado’s Best Adobum,” which was released in April, will now be available as a limited quantity edition vinyl record.\r\n\r\nSplit into “Ado’s Best Adobum Vol.1” and “Ado’s Best Adobum Vol.2,” the vinyl release includes all 40 tracks from the CD version, with 20 songs per volume across four discs.'),
(5, 'Led Zeppelin II', 2, 'pop', 'https://www.sweelee.com.my/cdn/shop/products/products_2FFLS-VINH-AE-081227966409_2FFLS-VINH-AE-081227966409_1594881405080.jpg?v=1594881412&width=2048', '2014-10-21', 85, 'Led Zeppelin', 'This is a vinyl LP pressing, and a digitally remastered edition of Led Zeppelin II, the eponymous second studio album by the English rock quartet.\n\nLed Zeppelin was one of the most innovative and successful groups in modern music and has sold more than 300 million albums worldwide. The band was inducted into the Rock & Roll Hall of Fame in 1995, received a Grammy Lifetime Achievement Award in 2005, and a year later was awarded with the Polar Music Prize in Stockholm.'),
(6, 'Intense Tchaikovsky', 2, 'classical', 'https://victrola.com/cdn/shop/files/4336829-3179522_700x700.jpg?v=1718810400', '2016-02-03', 40, 'Tchaikovsky', 'Tchaikovsky stands as the central figure of 19th-century Russian Romanticism, embodying it\'s widespread and vibrant vitality alongside a profound and sincere depth. This collection seeks to encapsulate the epic and intense qualities inherent in the genius of his compositions.'),
(7, '1000xResist Soundtrack', 2, 'vg', 'https://www.veryokvinyl.com/cdn/shop/files/JacketCover.png?v=1747766877&width=750', '2025-08-04', 90, 'Drew Redman', 'Would the world make sense if you couldn’t trust your memories? Very Ok Vinyl presents the soundtrack for 1000xRESIST, the sci-fi thriller built around this very idea.\r\n\r\nAs Watcher in 1000xRESIST, your function is to sift through the memories of the benevolent ALLMOTHER to understand the history of your clone sisters. The discovery of a dark secret alters your perception of the ALLMOTHER and questions everything you know to be true.\r\n\r\nThis game is visually as surreal as the concepts it presents. The soundtrack is equally thought-provoking. Mesmerizing melodies drift like daydreams, carrying you away from reality to the Orchard where you live with your sisters. Mirroring the experience of the Watcher, this soundtrack moves seamlessly from innocence and curiosity to betrayal and resolve.\r\n\r\nDrift into the dreamlike world of 1000xRESIST, where memory is reality… or is it?'),
(8, 'Guild Wars 2: Janthir Wilds', 3, 'classical', 'https://www.veryokvinyl.com/cdn/shop/files/Screenshot2025-07-29at12.35.19PM.png?v=1753806926&width=750', '2021-01-05', 40, 'Random ', 'Materia Collective proudly presents Guild Wars 2: Janthir Wilds, a deluxe 2xLP vinyl release featuring the evocative original score from the latest chapter in ArenaNet’s acclaimed MMORPG, Guild Wars 2.\r\n\r\nThe music charts a course through the legendary Janthir Isles—a treacherous region, perilous to explore and cloaked in ancient myth. Pressed on heavyweight vinyl and housed in a premium gatefold jacket, this collector’s edition delivers a rich analog experience, drawing listeners into sweeping orchestration and an immersive atmosphere.\r\n\r\nA powerful tribute to one of Tyria’s most storied realms—and an essential piece for any video game music collection.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `vinyl_id` (`vinyl_id`);

--
-- Indexes for table `shipping_info`
--
ALTER TABLE `shipping_info`
  ADD KEY `User's shipping info` (`user_id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `UNIQUE_PHONE` (`phone_no`),
  ADD UNIQUE KEY `UNIQUE_EMAIL` (`user_email`) USING BTREE;

--
-- Indexes for table `vinyl_info`
--
ALTER TABLE `vinyl_info`
  ADD PRIMARY KEY (`vinyl_id`),
  ADD KEY `Author` (`uploader_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vinyl_info`
--
ALTER TABLE `vinyl_info`
  MODIFY `vinyl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`vinyl_id`) REFERENCES `vinyl_info` (`vinyl_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shipping_info`
--
ALTER TABLE `shipping_info`
  ADD CONSTRAINT `User's shipping info` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vinyl_info`
--
ALTER TABLE `vinyl_info`
  ADD CONSTRAINT `Author` FOREIGN KEY (`uploader_id`) REFERENCES `user_info` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
