-- MySQL dump 10.13  Distrib 5.7.37, for Linux (x86_64)
--
-- Host: localhost    Database: go1
-- ------------------------------------------------------
-- Server version	5.7.37-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `form`
--

DROP TABLE IF EXISTS `form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clé primaire',
  `username` varchar(20) NOT NULL COMMENT 'Nom d''utilisateur lié',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date de création/dernière modification. Le formulaire le plus récent pour un utilisateur est considéré actif',
  `q1` text NOT NULL COMMENT 'Question 1',
  `q2` text NOT NULL COMMENT 'Question 2',
  `e1valid` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Est-ce que l''enseignant 1 a validé?',
  `e2valid` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Est-ce que l''enseignant 2 a validé?',
  `proValid` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Est-ce que le proviseur adjoint a validé?',
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form`
--

LOCK TABLES `form` WRITE;
/*!40000 ALTER TABLE `form` DISABLE KEYS */;
INSERT INTO `form` VALUES (1,'gfield','2022-04-26 14:13:27','a','b',0,0,0),(2,'gfield','2022-04-26 14:28:09','bonjour','bonne nuit',1,0,0);
/*!40000 ALTER TABLE `form` ENABLE KEYS */;
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
  `etabville` varchar(100) NOT NULL COMMENT 'Etablissement et ville; pourrait ne pas être demandé',
  `Classe` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES ('gfield','123456789af','bonsoir','bonne soirée','jaimarre','pemploi','paris',NULL);
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
  `password` varchar(100) NOT NULL COMMENT 'Mot de passe à hasher',
  `lastLog` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `firstname` varchar(100) DEFAULT NULL COMMENT 'Pour la communication',
  `lastname` varchar(100) DEFAULT NULL COMMENT 'Pour la communication',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Définit le grade de l''user; 0: étudiant ; 1: enseignant; 2: proviseur adjoint ; 3: secrétaire ',
  `email` varchar(320) NOT NULL COMMENT 'Pour la communication',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tous les utilisateurs';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('gfield','*510246E3A202BAD9D6A294FE5D32EC06901E9ADB','2022-04-26 15:11:49','gar','field',0,'gar@field.com'),('jaimarre','*203169C7928B974CFACD3A683DBB8F3495583600','2022-04-15 11:36:26','Jean','aimarre',1,'jean.aimarre@ac-poitiers.fr'),('jquille','*18CC52BB809704BBD196BC40745CA983C2B95E34','2022-04-26 14:10:07','Jean','Quille',2,'jean.quille@ac-poitiers.fr'),('pemploi','*FE9A92983BAB1202EB3D0D3C1A2D2DC730245476','2022-04-26 14:24:41','Paul','Emploi',1,'paul.emploi@ac-poitiers.fr');
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

-- Dump completed on 2022-04-27  8:27:21
