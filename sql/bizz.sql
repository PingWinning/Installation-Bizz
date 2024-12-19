-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : jeu. 19 déc. 2024 à 19:13
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bizz`
--

-- --------------------------------------------------------

--
-- Structure de la table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `request` text NOT NULL,
  `status` enum('pending','in-progress','completed') DEFAULT 'pending',
  `submission_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tickets`
--

INSERT INTO `tickets` (`id`, `name`, `phone`, `email`, `request`, `status`, `submission_date`) VALUES
(21, 'John Doe', '+1 514-555-0123', 'john.doe@example.com', 'Need assistance with my account settings.', 'completed', '2024-08-10'),
(22, 'Jane Smith', '+1 438-555-0456', 'jane.smith@example.com', 'Issue with payment processing.', 'completed', '2024-08-09'),
(23, 'David Lee', '+1 450-555-0789', 'david.lee@example.com', 'Requesting a refund for my last purchase.', 'completed', '2024-08-08'),
(24, 'Emily Johnson', '+1 514-555-0912', 'emily.johnson@example.com', 'How do I change my password?', 'completed', '2024-08-07'),
(25, 'Michael Brown', '+1 450-555-0234', 'michael.brown@example.com', 'Unable to access my account.', 'completed', '2024-08-06'),
(26, 'Sarah Davis', '+1 514-555-0567', 'sarah.davis@example.com', 'Error in billing.', 'completed', '2024-08-05'),
(27, 'James Wilson', '+1 438-555-0890', 'james.wilson@example.com', 'I need help with subscription.', 'completed', '2024-08-04'),
(29, 'Robert Martinez', '+1 514-555-0456', 'robert.martinez@example.com', 'Request for a feature update.', 'completed', '2024-08-02'),
(30, 'Linda Hernandez', '+1 438-555-0789', 'linda.hernandez@example.com', 'Account suspension issue.', 'completed', '2024-08-01'),
(31, 'Charles Clark', '+1 450-555-0912', 'charles.clark@example.com', 'Refund not received.', 'completed', '2024-07-31'),
(32, 'Mary Lewis', '+1 514-555-0145', 'mary.lewis@example.com', 'Problem with two-factor authentication.', 'completed', '2024-07-30'),
(33, 'Christopher Lee', '+1 438-555-0678', 'christopher.lee@example.com', 'Account login issues.', 'completed', '2024-07-29'),
(34, 'Barbara Walker', '+1 450-555-0890', 'barbara.walker@example.com', 'Need help with password recovery.', 'completed', '2024-07-28'),
(35, 'Thomas Hall', '+1 514-555-0234', 'thomas.hall@example.com', 'Subscription plan question.', 'pending', '2024-07-27'),
(36, 'Susan Young', '+1 438-555-0567', 'susan.young@example.com', 'Need to update my payment method.', 'pending', '2024-07-26'),
(37, 'Daniel King', '+1 450-555-0456', 'daniel.king@example.com', 'Issue with account verification.', 'pending', '2024-07-25'),
(38, 'Karen Harris', '+1 514-555-0789', 'karen.harris@example.com', 'Cannot find my purchase history.', 'pending', '2024-07-24');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `otp` varchar(6) DEFAULT NULL COMMENT 'Stores the OTP for login verification',
  `otp_expiry` datetime DEFAULT NULL COMMENT 'Stores the expiration time of the OTP',
  `phone` varchar(15) NOT NULL COMMENT 'Stores the phone number for OTP delivery'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `salt`, `otp`, `otp_expiry`, `phone`) VALUES
(1, 'Boss007', '0d6cb9e6d4519877d82be0de088927336b7e1ff2fa1bab8e5e7dde346063c672', '37f71c029df79022b4a287e2dc48cd76', '882870', '2024-12-19 18:41:51', '+15141231234');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
