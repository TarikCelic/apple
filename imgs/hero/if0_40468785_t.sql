-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql110.infinityfree.com
-- Generation Time: Nov 24, 2025 at 02:26 AM
-- Server version: 11.4.7-MariaDB
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
-- Database: `if0_40468785_t`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `answer` text NOT NULL,
  `answered` varchar(255) NOT NULL,
  `seen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`, `user_id`, `answer`, `answered`, `seen`) VALUES
(9, 'Miss Celic', 'ajna.bilkan2008@gmail.com', 'Slusaj ti bolan', 'Ostavi taj racunar imas curu ako nisi znao vise racunar gledas nego nju', '2025-11-23 17:12:28', 18, 'Slusaj ti BOLAN! Ja ovo radim da tebee impresioniraaaaaam !!! <3', '16', 0),
(10, 'Sanela', 'sanela1234@gmail.com', 'Poruka', 'Desi', '2025-11-23 17:19:29', 21, 'Evo me u kuci,pijem nes', '16', 0),
(11, 'Miss Celic', 'ajna.bilkan2008@gmail.com', 'Äeees bolaaaan slatkisuuuu', 'Kad cemoo na veceruðŸ˜ðŸ˜‰', '2025-11-23 17:56:21', 18, 'Kad pare pokazess', '16', 0),
(12, 'Miss Celic', 'ajna.bilkan2008@gmail.com', 'Momak bolan', 'Ideemooo odmaaa sutraaaaa', '2025-11-23 19:42:00', 18, 'Idemooooooo ondaaaa', '16', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `permission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `permission`) VALUES
(16, 'Tarik Celic', 'tarikcelic5@gmail.com', '$2y$10$KrR8ujjswUNEuJOBP/fE7./Rp.Ep.joLPCLUmDDglmND20xX9u89S', 3),
(18, 'ðŸ˜Ž', 'ajna.bilkan2008@gmail.com', '$2y$10$l2Kh59WlnCYA.ndiP5XSwOEYusnAn2pr7ZhKKKrJF..VXHuJvBhIu', 0),
(19, 'Sanela Celic', 'sanela123@gmail.com', '$2y$10$pWsOGxAJ6LVPRL//aW0Ww.4a6OpnIUMnJTq8Di0CWYSDJoPSZPrX6', 0),
(20, 'Anela', 'anela28celic@gmail.com', '$2y$10$x4yxSyAPXP.K24Nf4MenNOe5zgfssds.dBZ.wzW9cvOSn7QPfvLk6', 0),
(21, 'Sanela Celic', 'sanela1234@gmail.com', '$2y$10$jmCZ48dzAw01Z2UnIYBF9O3DlmZTI1HZVtubteZMSyJ9pyyrmK3He', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_imgs`
--

CREATE TABLE `user_imgs` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_imgs`
--

INSERT INTO `user_imgs` (`id`, `path`, `user_id`) VALUES
(5, 'imgs_users/user-692236cb97d47-1763849931.gif', 16),
(6, 'imgs_users/user-69234a8712c76-1763920519.jpg', 18),
(0, 'imgs_users/user-69223d21e19cb-1763851553.gif', 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
