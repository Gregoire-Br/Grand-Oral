-- MariaDB dump 10.19  Distrib 10.7.3-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: grandoral
-- ------------------------------------------------------
-- Server version	10.7.3-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `grandoral`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `grandoral` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `grandoral`;

--
-- Table structure for table `form`
--

DROP TABLE IF EXISTS `form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clé primaire',
  `username` varchar(20) NOT NULL COMMENT 'Nom d''utilisateur lié',
  `q1` text NOT NULL COMMENT 'Question 1',
  `q2` text NOT NULL COMMENT 'Question 2',
  `e1valid` timestamp NULL DEFAULT NULL COMMENT 'Date de validation par l''enseignant 1',
  `e2valid` timestamp NULL DEFAULT NULL COMMENT 'Date de validation par l''enseignant 2',
  `proValid` timestamp NULL DEFAULT NULL COMMENT 'Date de validation par le proviseur',
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form`
--

LOCK TABLES `form` WRITE;
/*!40000 ALTER TABLE `form` DISABLE KEYS */;
INSERT INTO `form` VALUES
(1,'garfield','azerty','qwerty','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2,'garfield','dvorak','qwertz','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `form` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Date de l''action',
  `action` int(11) NOT NULL DEFAULT 0 COMMENT '0: Modification de fiche\r\n1: Validation de fiche\r\n2: Refus de fiche',
  `actor1` varchar(20) NOT NULL COMMENT 'Premier acteur',
  `actor2` varchar(20) DEFAULT NULL COMMENT 'Second acteur',
  KEY `actor1` (`actor1`),
  KEY `actor2` (`actor2`),
  CONSTRAINT `log_ibfk_1` FOREIGN KEY (`actor1`) REFERENCES `users` (`username`),
  CONSTRAINT `log_ibfk_2` FOREIGN KEY (`actor2`) REFERENCES `users` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Activités récentes';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `username` varchar(20) NOT NULL COMMENT 'Nom d''utilisateur, clé primaire étrangère sur users',
  `ine` varchar(11) NOT NULL COMMENT 'INE crypté; provient de la base siècle',
  `spec1` varchar(60) NOT NULL COMMENT 'Spécialité 1',
  `spec2` varchar(60) NOT NULL COMMENT 'Spécialité 2',
  `ens1` varchar(20) NOT NULL COMMENT 'Enseignant 1',
  `ens2` varchar(20) NOT NULL COMMENT 'Enseignant 2',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES
('garfield','123456789af','lasagnes','dormir','Jean','Claude');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `username` varchar(20) NOT NULL COMMENT 'Nom d''utilisateur, clé primaire, insensible à la casse',
  `password` varchar(48) NOT NULL COMMENT 'Mot de passe à hasher',
  `lastLog` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `firstname` varchar(100) DEFAULT NULL COMMENT 'Pour la communication',
  `lastname` varchar(100) DEFAULT NULL COMMENT 'Pour la communication',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'Définit le grade de l''user; 0: étudiant ; 1: enseignant; 2: proviseur adjoint ; 3: secrétaire ',
  `email` varchar(320) NOT NULL COMMENT 'Pour la communication',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tous les utilisateurs';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
('garfield','def456','2022-03-18 07:23:28','gar','field',0,'gar@field.com');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-03-25 13:14:39
