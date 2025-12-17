-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour chirorg
CREATE DATABASE IF NOT EXISTS `chirorg` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `chirorg`;

-- Listage de la structure de table chirorg. chirurgie
CREATE TABLE IF NOT EXISTS `chirurgie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `intitule` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fiche_technique` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `salle` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valide` tinyint NOT NULL,
  `utilisateur_id` int DEFAULT NULL,
  `operer_id` int DEFAULT NULL,
  `outiller_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_EC562809FB88E14F` (`utilisateur_id`),
  KEY `IDX_EC5628095F0388CB` (`operer_id`),
  KEY `IDX_EC562809E0E4D13F` (`outiller_id`),
  CONSTRAINT `FK_EC5628095F0388CB` FOREIGN KEY (`operer_id`) REFERENCES `chirurgien` (`id`),
  CONSTRAINT `FK_EC562809E0E4D13F` FOREIGN KEY (`outiller_id`) REFERENCES `liste_materiel` (`id`),
  CONSTRAINT `FK_EC562809FB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table chirorg.chirurgie : ~20 rows (environ)
INSERT INTO `chirurgie` (`id`, `intitule`, `fiche_technique`, `date`, `salle`, `valide`, `utilisateur_id`, `operer_id`, `outiller_id`) VALUES
	(1, 'Prothèse hanche', 'Pose prothèse totale', '2025-01-10 08:00:00', 'Salle 1', 1, 1, 1, 1),
	(2, 'Pontage coronarien', 'CEC + pontage', '2025-01-11 09:00:00', 'Salle 2', 1, 2, 2, 2),
	(3, 'Cholécystectomie', 'Cœlioscopie', '2025-01-12 10:00:00', 'Salle 3', 1, 3, 3, 3),
	(4, 'Craniotomie', 'Ablation tumeur', '2025-01-13 08:30:00', 'Salle 4', 0, 4, 4, 4),
	(5, 'Rhinoplastie', 'Chirurgie esthétique', '2025-01-14 09:30:00', 'Salle 5', 1, 5, 5, 5),
	(6, 'Thoracotomie', 'Accès pulmonaire', '2025-01-15 08:00:00', 'Salle 6', 1, 6, 6, 6),
	(7, 'Bypass vasculaire', 'Revascularisation', '2025-01-16 10:00:00', 'Salle 2', 1, 7, 7, 7),
	(8, 'Néphrectomie', 'Ablation rein', '2025-01-17 09:00:00', 'Salle 3', 0, 8, 8, 8),
	(9, 'Arthroscopie', 'Exploration articulaire', '2025-01-18 08:00:00', 'Salle 1', 1, 9, 9, 1),
	(10, 'Colectomie', 'Ablation côlon', '2025-01-19 10:00:00', 'Salle 3', 1, 10, 10, 3),
	(11, 'Valve cardiaque', 'Pose valve', '2025-01-20 09:00:00', 'Salle 2', 1, 1, 11, 2),
	(12, 'Discectomie', 'Hernie discale', '2025-01-21 08:30:00', 'Salle 4', 1, 2, 12, 4),
	(13, 'Liposuccion', 'Aspiration graisse', '2025-01-22 11:00:00', 'Salle 5', 0, 3, 5, 5),
	(14, 'Pontage artériel', 'Chirurgie vasculaire', '2025-01-23 09:00:00', 'Salle 2', 1, 4, 7, 7),
	(15, 'Cystectomie', 'Ablation vessie', '2025-01-24 08:00:00', 'Salle 3', 1, 5, 8, 8),
	(16, 'Appendicectomie', 'Urgence', '2025-01-25 07:30:00', 'Salle 1', 1, 6, 3, 10),
	(17, 'Neurostimulation', 'Implant', '2025-01-26 09:30:00', 'Salle 4', 1, 7, 12, 4),
	(18, 'Prothèse genou', 'Pose prothèse', '2025-01-27 08:00:00', 'Salle 1', 0, 8, 1, 1),
	(19, 'Plastie mammaire', 'Reconstruction', '2025-01-28 10:30:00', 'Salle 5', 1, 9, 5, 5),
	(20, 'Exploration thorax', 'Biopsie', '2025-01-29 09:00:00', 'Salle 6', 1, 10, 6, 6);

-- Listage de la structure de table chirorg. chirurgien
CREATE TABLE IF NOT EXISTS `chirurgien` (
  `id` int NOT NULL AUTO_INCREMENT,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `specialiser_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1384D5EFF548D04` (`specialiser_id`),
  CONSTRAINT `FK_1384D5EFF548D04` FOREIGN KEY (`specialiser_id`) REFERENCES `specialite` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table chirorg.chirurgien : ~12 rows (environ)
INSERT INTO `chirurgien` (`id`, `prenom`, `nom`, `specialiser_id`) VALUES
	(1, 'Paul', 'Durand', 1),
	(2, 'Sophie', 'Lefevre', 2),
	(3, 'Marc', 'Bernard', 3),
	(4, 'Claire', 'Moreau', 4),
	(5, 'Julien', 'Roux', 5),
	(6, 'Isabelle', 'Fontaine', 6),
	(7, 'Antoine', 'Blanc', 7),
	(8, 'Camille', 'Perrin', 8),
	(9, 'Nicolas', 'Henry', 1),
	(10, 'Laura', 'Gauthier', 3),
	(11, 'Eric', 'Chevalier', 2),
	(12, 'Marine', 'Lopez', 4);

-- Listage de la structure de table chirorg. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table chirorg.doctrine_migration_versions : ~1 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20251217133825', '2025-12-17 13:38:44', 140);

-- Listage de la structure de table chirorg. liste_materiel
CREATE TABLE IF NOT EXISTS `liste_materiel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `intitule` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chirurgien_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table chirorg.liste_materiel : ~10 rows (environ)
INSERT INTO `liste_materiel` (`id`, `intitule`, `chirurgien_id`) VALUES
	(1, 'Kit orthopédie', 0),
	(2, 'Kit chirurgie cardiaque', 0),
	(3, 'Kit chirurgie digestive', 0),
	(4, 'Kit neurochirurgie', 0),
	(5, 'Kit chirurgie plastique', 0),
	(6, 'Kit chirurgie thoracique', 0),
	(7, 'Kit chirurgie vasculaire', 0),
	(8, 'Kit chirurgie urologique', 0),
	(9, 'Kit laparoscopie', 0),
	(10, 'Kit urgence bloc', 0);

-- Listage de la structure de table chirorg. materiel
CREATE TABLE IF NOT EXISTS `materiel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `intitule` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `classer_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_18D2B091269E3C41` (`classer_id`),
  CONSTRAINT `FK_18D2B091269E3C41` FOREIGN KEY (`classer_id`) REFERENCES `specialite` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table chirorg.materiel : ~20 rows (environ)
INSERT INTO `materiel` (`id`, `intitule`, `type`, `adresse`, `classer_id`) VALUES
	(1, 401, 'Scalpel stérile', 'Instrument', 'Bloc A - Armoire 1', 3),
	(2, 402, 'Perceuse chirurgicale', 'Appareil', 'Bloc B - Salle 2', 1),
	(3, 403, 'Pince hémostatique', 'Instrument', 'Bloc A - Armoire 2', 2),
	(4, 404, 'Écarteur cérébral', 'Instrument', 'Bloc C - Armoire 1', 4),
	(5, 405, 'Bistouri électrique', 'Appareil', 'Bloc A - Salle 1', 3),
	(6, 406, 'Écarteur abdominal', 'Instrument', 'Bloc B - Armoire 3', 3),
	(7, 407, 'Valve cardiaque', 'Implant', 'Bloc C - Stock sécurisé', 2),
	(8, 408, 'Clamp vasculaire', 'Instrument', 'Bloc D - Armoire 1', 7),
	(9, 409, 'Caméra laparoscopique', 'Appareil', 'Bloc A - Salle 3', 3),
	(10, 410, 'Sonde urinaire', 'Consommable', 'Bloc E - Stock', 8),
	(11, 411, 'Agrafeuse cutanée', 'Instrument', 'Bloc B - Armoire 2', 5),
	(12, 412, 'Scie oscillante', 'Appareil', 'Bloc A - Salle 2', 1),
	(13, 413, 'Aspirateur chirurgical', 'Appareil', 'Bloc C - Salle 1', 6),
	(14, 414, 'Micro-instruments neuro', 'Instrument', 'Bloc C - Armoire 4', 4),
	(15, 415, 'Fil de suture', 'Consommable', 'Bloc E - Stock', 5),
	(16, 416, 'Trocart', 'Instrument', 'Bloc A - Armoire 5', 3),
	(17, 417, 'Cathéter', 'Consommable', 'Bloc E - Stock', 7),
	(18, 418, 'Table opératoire mobile', 'Équipement', 'Bloc A', 6),
	(19, 419, 'Masque anesthésie', 'Consommable', 'Bloc E - Stock', 2),
	(20, 420, 'Laser chirurgical', 'Appareil', 'Bloc D - Salle spécialisée', 5);

-- Listage de la structure de table chirorg. materiel_liste_materiel
CREATE TABLE IF NOT EXISTS `materiel_liste_materiel` (
  `materiel_id` int NOT NULL,
  `liste_materiel_id` int NOT NULL,
  PRIMARY KEY (`materiel_id`,`liste_materiel_id`),
  KEY `IDX_8065958116880AAF` (`materiel_id`),
  KEY `IDX_80659581FF6D643` (`liste_materiel_id`),
  CONSTRAINT `FK_8065958116880AAF` FOREIGN KEY (`materiel_id`) REFERENCES `materiel` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_80659581FF6D643` FOREIGN KEY (`liste_materiel_id`) REFERENCES `liste_materiel` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table chirorg.materiel_liste_materiel : ~20 rows (environ)
INSERT INTO `materiel_liste_materiel` (`materiel_id`, `liste_materiel_id`) VALUES
	(1, 3),
	(2, 1),
	(3, 2),
	(4, 4),
	(5, 3),
	(6, 3),
	(7, 2),
	(8, 7),
	(9, 9),
	(10, 8),
	(11, 5),
	(12, 1),
	(13, 6),
	(14, 4),
	(15, 5),
	(16, 9),
	(17, 7),
	(18, 6),
	(19, 2),
	(20, 5);

-- Listage de la structure de table chirorg. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table chirorg.messenger_messages : ~0 rows (environ)

-- Listage de la structure de table chirorg. specialite
CREATE TABLE IF NOT EXISTS `specialite` (
  `id` int NOT NULL AUTO_INCREMENT,
  `intitule` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table chirorg.specialite : ~8 rows (environ)
INSERT INTO `specialite` (`id`, `intitule`) VALUES
	(1, 101, 'Chirurgie orthopédique'),
	(2, 102, 'Chirurgie cardiaque'),
	(3, 103, 'Chirurgie digestive'),
	(4, 104, 'Neurochirurgie'),
	(5, 105, 'Chirurgie plastique'),
	(6, 106, 'Chirurgie thoracique'),
	(7, 107, 'Chirurgie vasculaire'),
	(8, 108, 'Chirurgie urologique');

-- Listage de la structure de table chirorg. utilisateur
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table chirorg.utilisateur : ~0 rows (environ)
INSERT INTO `utilisateur` (`id`, `email`, `roles`, `password`, `prenom`, `nom`) VALUES
	(1, 'admin@chirorg.fr', '["ROLE_ADMIN"]', 'pwd1', 'Alice', 'Martin'),
	(2, 'planning@chirorg.fr', '["ROLE_ADMIN"]', 'pwd2', 'Luc', 'Renaud'),
	(3, 'user1@chirorg.fr', '["ROLE_USER"]', 'pwd3', 'Jean', 'Dupont'),
	(4, 'user2@chirorg.fr', '["ROLE_USER"]', 'pwd4', 'Emma', 'Leroy'),
	(5, 'user3@chirorg.fr', '["ROLE_USER"]', 'pwd5', 'Paul', 'Durand'),
	(6, 'user4@chirorg.fr', '["ROLE_USER"]', 'pwd6', 'Sophie', 'Bernard'),
	(7, 'user5@chirorg.fr', '["ROLE_USER"]', 'pwd7', 'Nina', 'Robert'),
	(8, 'user6@chirorg.fr', '["ROLE_USER"]', 'pwd8', 'Marc', 'Petit'),
	(9, 'user7@chirorg.fr', '["ROLE_USER"]', 'pwd9', 'Laura', 'Moreau'),
	(10, 'user8@chirorg.fr', '["ROLE_USER"]', 'pwd10', 'Thomas', 'Garcia');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
