-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2024 at 03:33 PM
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
-- Database: `farha`
--

-- --------------------------------------------------------

--
-- Table structure for table `billet`
--

CREATE TABLE `billet` (
  `codeBillet` char(5) NOT NULL,
  `typeBillet` char(20) DEFAULT NULL,
  `numPlace` int(11) NOT NULL,
  `idFacture` char(8) NOT NULL
) ;

--
-- Dumping data for table `billet`
--

INSERT INTO `billet` (`codeBillet`, `typeBillet`, `numPlace`, `idFacture`) VALUES
('19707', 'normal', 2, '3b975'),
('22354', 'réduit', 3, '3b975'),
('b6144', 'normal', 1, '3b975');

-- --------------------------------------------------------

--
-- Table structure for table `evenement`
--

CREATE TABLE `evenement` (
  `idEvenement` int(11) NOT NULL,
  `titre` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `categorie` varchar(50) DEFAULT NULL,
  `tarifnormal` decimal(6,2) DEFAULT NULL,
  `tarifReduit` decimal(6,2) DEFAULT NULL,
  `image` char(100) DEFAULT NULL
) ;

--
-- Dumping data for table `evenement`
--

INSERT INTO `evenement` (`idEvenement`, `titre`, `description`, `categorie`, `tarifnormal`, `tarifReduit`, `image`) VALUES
(1, 'Live Concert', 'Immerse yourself in the enchanting world of live music with a diverse range of talented artists from various genres. Experience a night filled with soulful melodies and electrifying performances.', 'Musique', 150.00, 100.00, 'eventMusic1'),
(2, 'Film Festival', 'Embark on a cinematic journey at the International Film Festival, featuring a curated selection of thought-provoking and visually stunning films from around the globe. Explore the art of storytelling through the lens of visionary filmmakers.', 'Cinema', 80.00, 35.00, 'eventCinema1'),
(3, 'Theatre Performance', 'Indulge in the world of drama with a captivating Theatre Performance. Immerse yourself in a spellbinding showcase of emotions and storytelling that promises to leave a lasting impression.', 'Théatre', 90.00, 35.00, 'eventTheatre1'),
(4, 'Art Exhibition', 'Dive into the realm of contemporary art at the Art Exhibition, where creativity knows no bounds. Marvel at the unique expressions and interpretations of today’s artists in a visually stunning showcase.', 'Musique', 120.00, 80.00, 'eventMusic2'),
(5, 'Conference', 'Engage with industry experts and thought leaders at the Conference. Gain valuable insights into the latest trends and innovations shaping various fields, fostering knowledge exchange and networking.', 'Musique', 60.00, 50.00, 'eventMusic3'),
(6, 'Dance Performance', 'Be mesmerized by the grace and energy of modern dance in the Dance Performance. Experience a visually stunning display of movement and expression that transcends conventional boundaries.', 'Théatre', 95.00, 40.00, 'eventTheatre2'),
(7, 'Comedy Show', 'Laugh your heart out at the Stand-up Comedy Night, featuring hilarious comedians who will tickle your funny bone with their wit and humor. Prepare for a night of non-stop laughter and entertainment.', 'Musique', 135.00, 100.00, 'eventMusic4'),
(8, 'Magic Show', 'Step into the world of illusion and magic tricks in the Magic Show. Prepare to be mystified and amazed by mind-bending performances that defy the laws of reality.', 'Théatre', 50.00, 20.00, 'eventTheatre3'),
(9, 'Children\'s Play', 'Treat your little ones to an enchanting play designed just for them. The Children\'s Play promises a magical experience filled with entertainment, sparking creativity and imagination.', 'Théatre', 150.00, 90.00, 'eventTheatre4'),
(10, 'Sports Event', 'Cheer for your favorite teams at the Football Championship, a thrilling sports event that promises intense competition and memorable moments on the field.', 'Musique', 55.00, 45.00, 'eventMusic5'),
(11, 'Tech Expo', 'Explore the latest in technology at the Technology Exhibition. From cutting-edge gadgets to innovative solutions, the Tech Expo is a glimpse into the future of tech.', 'Cinema', 90.00, 55.00, 'eventCinema2'),
(12, 'Food Festival', 'Savor the culinary delights at the Food Festival, a gastronomic journey featuring delectable dishes and flavors from around the world. Indulge your taste buds in a paradise for food enthusiasts!', 'Musique', 130.00, 75.00, 'eventMusic6'),
(13, 'Fashion Show', 'Witness the glamour and style of the runway in the Fashion Show. Experience the latest trends and designs as models strut down the catwalk in a celebration of creativity and fashion.', 'Théatre', 50.00, 45.00, 'eventTheatre5'),
(14, 'Health Seminar', 'Prioritize your well-being at the Wellness and Health Workshop. Join experts as they share insights on maintaining a healthy lifestyle and explore holistic approaches to wellness.', 'Cinema', 75.00, 40.00, 'eventCinema3'),
(15, 'Literary Event', 'Immerse yourself in the world of literature at the Book Reading and Discussion. Engage with authors, discover new literary gems, and participate in thought-provoking discussions on this literary journey.', 'Musique', 60.00, 35.00, 'eventMusic7');

-- --------------------------------------------------------

--
-- Table structure for table `facture`
--

CREATE TABLE `facture` (
  `idFacture` char(8) NOT NULL,
  `dateFacture` datetime DEFAULT NULL,
  `id_utilisateur` int(11) DEFAULT NULL,
  `numVersion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facture`
--

INSERT INTO `facture` (`idFacture`, `dateFacture`, `id_utilisateur`, `numVersion`) VALUES
('3b975', '2024-03-19 18:13:55', 16, 3);

-- --------------------------------------------------------

--
-- Table structure for table `salle`
--

CREATE TABLE `salle` (
  `numSalle` int(11) NOT NULL,
  `capacite` int(11) DEFAULT NULL,
  `descriptionSalle` text DEFAULT NULL
) ;

--
-- Dumping data for table `salle`
--

INSERT INTO `salle` (`numSalle`, `capacite`, `descriptionSalle`) VALUES
(1, 100, 'Large Hall'),
(2, 150, 'Medium Hall'),
(3, 60, 'Small Hall'),
(4, 200, 'Grand Hall'),
(5, 80, 'Conference Room');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `idUtilisateur` int(11) NOT NULL,
  `nom` char(50) NOT NULL,
  `prenom` char(50) NOT NULL,
  `email` char(100) DEFAULT NULL,
  `motPasse` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`idUtilisateur`, `nom`, `prenom`, `email`, `motPasse`) VALUES
(16, 'tribak', 'ayoub', 'tribak@gmail.com', '$2y$10$OtYXMII7bQok/49TsEr/yOcqlAQimVsZ9qA270s2fkwOCdMdUVRU.'),
(17, 'tribak', 'ayoub', 'test@gmail.com', '$2y$10$.0mQhSTIfVEGQ3.JtDBzD.U1LnH54MWL0DIBB2NXamxc6cdihLVzm'),
(18, 'tribak', 'ayoub', 'ayoub@gmail.com', '$2y$10$XWMkYPF3xRVwaAH5a3Iowe7bawfxwDcDCw7SuxlX3W0FIVxkXD2hO');

-- --------------------------------------------------------

--
-- Table structure for table `version`
--

CREATE TABLE `version` (
  `numVersion` int(11) NOT NULL,
  `dateEvenement` datetime DEFAULT NULL,
  `numSalle` int(11) DEFAULT NULL,
  `idEvenement` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `version`
--

INSERT INTO `version` (`numVersion`, `dateEvenement`, `numSalle`, `idEvenement`) VALUES
(1, '2024-07-01 19:00:00', 1, 1),
(2, '2024-08-02 15:30:00', 2, 2),
(3, '2024-09-09 20:00:00', 3, 3),
(4, '2024-10-04 18:45:00', 4, 4),
(5, '2024-12-05 14:00:00', 5, 5),
(6, '2025-11-06 17:30:00', 1, 6),
(7, '2025-10-07 21:15:00', 2, 7),
(8, '2025-08-08 19:45:00', 3, 8),
(9, '2025-05-09 16:30:00', 4, 9),
(10, '2025-05-10 22:00:00', 5, 10),
(11, '2025-06-11 14:45:00', 1, 11),
(12, '2025-06-12 18:30:00', 2, 12),
(13, '2025-06-13 20:30:00', 3, 13),
(14, '2025-07-14 16:15:00', 4, 14),
(15, '2025-08-15 19:00:00', 5, 15);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billet`
--
ALTER TABLE `billet`
  ADD PRIMARY KEY (`codeBillet`),
  ADD KEY `idFacture` (`idFacture`);

--
-- Indexes for table `evenement`
--
ALTER TABLE `evenement`
  ADD PRIMARY KEY (`idEvenement`),
  ADD UNIQUE KEY `titre` (`titre`);

--
-- Indexes for table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`idFacture`),
  ADD KEY `idUtilisateur` (`id_utilisateur`),
  ADD KEY `numVersion` (`numVersion`);

--
-- Indexes for table `salle`
--
ALTER TABLE `salle`
  ADD PRIMARY KEY (`numSalle`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`idUtilisateur`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `version`
--
ALTER TABLE `version`
  ADD PRIMARY KEY (`numVersion`),
  ADD KEY `numSalle` (`numSalle`),
  ADD KEY `idEvenement` (`idEvenement`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `evenement`
--
ALTER TABLE `evenement`
  MODIFY `idEvenement` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `billet`
--
ALTER TABLE `billet`
  ADD CONSTRAINT `idFacture` FOREIGN KEY (`idFacture`) REFERENCES `facture` (`idFacture`);

--
-- Constraints for table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`idUtilisateur`),
  ADD CONSTRAINT `numVersion` FOREIGN KEY (`numVersion`) REFERENCES `version` (`numVersion`);

--
-- Constraints for table `version`
--
ALTER TABLE `version`
  ADD CONSTRAINT `version_ibfk_1` FOREIGN KEY (`numSalle`) REFERENCES `salle` (`numSalle`),
  ADD CONSTRAINT `version_ibfk_2` FOREIGN KEY (`idEvenement`) REFERENCES `evenement` (`idEvenement`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
