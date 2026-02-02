-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2026 at 12:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movieapp_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `rating` decimal(3,1) DEFAULT NULL,
  `release_year` int(4) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `casting` text DEFAULT NULL,
  `poster_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `title`, `genre`, `rating`, `release_year`, `description`, `casting`, `poster_path`, `created_at`) VALUES
(1, 'Inception', 'Sci-Fi', 8.8, NULL, 'A thief who steals corporate secrets through the use of dream-sharing technology.', NULL, 'default_poster.jpg', '2026-01-24 06:49:48'),
(2, 'Zootopia 2', 'Family/Animation', 9.0, NULL, 'It once again follows Judy Hopps and Nick Wilde, this time as they pursue reptile Gary De\'Snake across Zootopia and try to clear their names after being framed.', NULL, '1769239185_zootopia-2.jpg', '2026-01-24 07:19:45'),
(3, 'ChupChupKe', 'Comedy/Romance', 8.0, 2006, 'A debt-ridden young man attempts suicide, but is rescued only to find that his luck is finally turning', 'Shahid Kapoor, Kareena Kapoor, Suniel Shetty, Neha Dhupia, Paresh Rawal, Rajpal Yadav, Shakti Kapoor, Om Puri and Anupam Kher.', 'Chup_Chup_Ke_poster.jpg', '2026-01-24 08:12:52'),
(4, 'Dhurandhar', 'Action/Crime', 9.0, 2025, 'A mysterious traveler slips into the heart of Karachi\'s underbelly and rises through its ranks with lethal precision, only to tear the notorious ISI-Underworld nexus apart from within.', 'Ranveer Singh, Akshaye Khanna, Sanjay Dutt, R. Madhavan, Arjun Rampal, and several other actors', 'Dhurandhar_poster.jpg', '2026-01-25 04:24:47'),
(5, 'Your Name', 'Fantasy/Romance', 7.0, 2016, 'Two teenagers share a profound, magical connection upon discovering they are swapping bodies. Things manage to become even more complicated when the boy and girl decide to meet in person.', 'Ryûnosuke Kamiki, Mone Kamishiraishi, Ryo Narita, Aoi Yûki', 'Your_Name_poster.png', '2026-01-25 07:03:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$qxKTGcNvqC0tujfS.rvArukkhQiHr0/sJIMlvDkaE7j28.oP2ZTaG', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
