-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : jeu. 23 fév. 2023 à 09:19
-- Version du serveur : 5.7.39
-- Version de PHP : 8.2.0

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

CREATE TABLE `events` (
  `ID` int(11) NOT NULL,
  `date` date NOT NULL,
  `place` varchar(250) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `events`
--

INSERT INTO `events` (`ID`, `date`, `place`, `name`) VALUES
(1, '2023-02-24', 'Saint-Martin ballad', 'Dog walk'),
(2, '2023-02-27', 'Montessori room', 'Cats Meet-up'),
(3, '2023-03-09', 'Porte de Versailles', 'Master Dev France');

-- --------------------------------------------------------

--
-- Structure de la table `event_attendees`
--

CREATE TABLE `event_attendees` (
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `event_attendees`
--

INSERT INTO `event_attendees` (`user_id`, `event_id`) VALUES
(4, 1),
(4, 2),
(4, 3),
(6, 2),
(6, 1),
(10, 3),
(5, 2),
(7, 3);

-- --------------------------------------------------------

--
-- Structure de la table `followers`
--

CREATE TABLE `followers` (
  `follower` int(11) NOT NULL,
  `followed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `followers`
--

INSERT INTO `followers` (`follower`, `followed`) VALUES
(3, 1),
(1, 3),
(3, 5),
(7, 3),
(7, 1),
(4, 1),
(6, 1),
(6, 3),
(1, 6),
(10, 1),
(4, 3),
(4, 6),
(9, 6),
(5, 6),
(7, 9);

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

CREATE TABLE `likes` (
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`user_id`, `post_id`) VALUES
(4, 1),
(4, 14),
(10, 3),
(4, 6),
(4, 7),
(4, 13),
(4, 3),
(9, 19),
(10, 21),
(10, 1),
(10, 6),
(10, 18),
(10, 19),
(5, 18),
(7, 18),
(7, 20),
(7, 22);

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `ID` int(11) NOT NULL,
  `photo` varchar(50) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `date` date NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`ID`, `photo`, `description`, `date`, `user_id`) VALUES
(1, '63f486010690b5.07993780.jpg', 'Did you know that I am a movie star ?', '2023-02-20', 1),
(3, '63f48620a841b4.55182163.png', 'I was such a widdle cutie puppy!', '2023-02-21', 1),
(6, '63f48795628ce7.37151080.png', 'Wanna swim?', '2023-02-20', 3),
(7, '63f4878cb97b83.64015646.jpg', 'Look, I am a cat', '2023-02-20', 3),
(18, '63f72d73982ae1.84303152.jpeg', 'sooo cool!', '2023-02-23', 6),
(19, '63f72da5c0a3a8.48851549.jpeg', 'tssssssss', '2023-02-23', 9),
(20, '63f72dd8191672.32322046.jpeg', 'Look at my cousin from Dallas museum :)', '2023-02-23', 8),
(21, '63f72e2a1d19a5.31531237.jpeg', 'I gotta a famous mate! ', '2023-02-23', 10),
(22, '63f72ed88afbe2.40763499.jpeg', 'Always my mentor', '2023-02-23', 5);

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

CREATE TABLE `type` (
  `ID` int(11) NOT NULL,
  `label` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `type_id` int(11) NOT NULL,
  `photo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `event_attendees`
--
ALTER TABLE `event_attendees`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Index pour la table `followers`
--
ALTER TABLE `followers`
  ADD KEY `follower` (`follower`),
  ADD KEY `following` (`followed`);

--
-- Index pour la table `likes`
--
ALTER TABLE `likes`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `type_id` (`type_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `type`
--
ALTER TABLE `type`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
