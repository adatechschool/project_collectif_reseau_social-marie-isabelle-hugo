-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 20 fév. 2023 à 15:59
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `social_animals`
--

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `place` varchar(250) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ;

-- --------------------------------------------------------

--
-- Structure de la table `event_attendees`
--

DROP TABLE IF EXISTS `event_attendees`;
CREATE TABLE IF NOT EXISTS `event_attendees` (
  `user_id` int NOT NULL,
  `event_id` int NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `event_id` (`event_id`)
) ;

-- --------------------------------------------------------

--
-- Structure de la table `followers`
--

DROP TABLE IF EXISTS `followers`;
CREATE TABLE IF NOT EXISTS `followers` (
  `follower` int NOT NULL,
  `following` int NOT NULL,
  KEY `follower` (`follower`),
  KEY `following` (`following`)
) ;

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `user_id` int NOT NULL,
  `post_id` int NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`)
) ;

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `photo` varchar(50) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `date` date NOT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `user_id` (`user_id`)
) ;

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE IF NOT EXISTS `type` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`ID`, `label`) VALUES
(1, 'cat'),
(2, 'dog'),
(3, 'hamster'),
(4, 'chinchilla'),
(5, 'other-mammal'),
(6, 'bird'),
(7, 'snake'),
(8, 'other-reptile');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `type_id` int NOT NULL,
  `photo` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `type_id` (`type_id`)
) ;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`ID`, `name`, `email`, `password`, `type_id`, `photo`) VALUES
(1, 'Beethoven', 'beethoven@mail.com', 'a188c5792ac20e11b2660c962af94306167645fb99bb720ed5336066ab8c7856', 2, '63f3970bbe5959.53347633.jpg'),
(2, 'Royal Corgi', 'royalcorgi@mail.com', '08656ea35f9615bb3e47b12f25809452832de992014381bc6e4e51ea5eae7678', 2, '63f3974d4e6315.33037854.png'),
(3, 'Capy', 'capy@mail.com', 'a4a194de8888ee539ae670f2241cb86df8c607a3a5dc7554c806dc214fe3587c', 5, '63f39761d900a4.43250967.jpg'),
(4, 'Chinchi', 'chinchi@mail.com', '9aee789a24d3e77ea4fbb61bf943d779b2918dc990f7436ba29bea8f661c41fb', 5, '63f39781ef13d8.96227149.jpg'),
(5, 'Choupette', 'choupette@mail.com', '2d5f5ae8937255c10716a5422c98f6ea332648e058a47ef7ef098c4423173c49', 1, '63f3979ae5b973.01501253.jpg'),
(6, 'Grumpy Cat', 'grumpy@mail.com', '7c0cb64eab5ee04a18830c717bc427b96c61082bf3af9d09ca5d0534112a3587', 1, '63f397cfe48d54.54477257.jpg'),
(7, 'Hamtaro', 'hamtaro@mail.com', '82636422d8b556e39769d182cb418b098fe211fa004312e615a2a335ed4470a9', 5, '63f397f6b61ca1.38137421.png'),
(8, 'Birdie', 'birdie@mail.com', 'fb26e8598ca3bfa4114ebd0b4f689425cebcac6588b458d97103be8c734ec9a0', 6, '63f398279d84f8.76663395.png'),
(9, 'Python', 'python@mail.com', '11a4a60b518bf24989d481468076e5d5982884626aed9faeb35b8576fcd223e1', 7, '63f3984ff1a421.35362877.png'),
(10, 'Dragon', 'dragon@mail.com', 'a9c43be948c5cabd56ef2bacffb77cdaa5eec49dd5eb0cc4129cf3eda5f0e74c', 8, '63f398c50228d5.42039428.png');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
