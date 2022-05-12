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

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `grandoral` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

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
  `date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Date de création/dernière modification. Le formulaire le plus récent pour un utilisateur est considéré actif',
  `q1` text DEFAULT NULL COMMENT 'Question 1',
  `q2` text DEFAULT NULL COMMENT 'Question 2',
  `ens1` varchar(20) NOT NULL COMMENT 'Nom d''utilisateur de l''enseignant encadrant 1',
  `ens2` varchar(20) NOT NULL COMMENT 'Nom d''utilisateur de l''enseignant encadrant 2',
  `ens1valid` datetime DEFAULT NULL COMMENT 'Date de validation par l''enseignant 1',
  `ens2valid` datetime DEFAULT NULL COMMENT 'Date de validation par l''enseignant 2 ',
  `provalid` datetime DEFAULT NULL COMMENT 'Date de validation par l''enseignant 3',
  `spec11` int(11) NOT NULL COMMENT 'Spécialisation à laquelle la question n°1 est liée',
  `spec12` int(11) DEFAULT NULL COMMENT '2ème spécialisation à laquelle la question n°1 est liée (si il y en a une)',
  `spec21` int(11) NOT NULL COMMENT 'Spécialisation à laquelle la question n°2 est liée',
  `spec22` int(11) DEFAULT NULL COMMENT 'Deuxième spécialisation à laquelle la question n°2 est liée (si il y en a une)',
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form`
--

LOCK TABLES `form` WRITE;
/*!40000 ALTER TABLE `form` DISABLE KEYS */;
INSERT INTO `form` VALUES
(1,'gfield','2022-05-06 07:14:22','a','b','jaimarre','cvallée',NULL,'2022-05-06 09:02:21',NULL,1,0,0,0),
(2,'gfield','2022-04-29 10:09:38','bonjour','bonne nuit','jaimarre','cvallée',NULL,NULL,NULL,1,0,0,0),
(3,'gfield','2022-04-29 10:09:43','sdcbsdjhbcsj',',svbkqsvls','jaimarre','cvallée',NULL,NULL,NULL,1,0,1,0),
(4,'gfield','2022-04-29 10:09:50','pouet','pouet pouet','jaimarre','cvallée',NULL,NULL,NULL,1,0,1,0),
(5,'gfield','2022-04-29 10:10:12','Qu\'a apporté Poincarré aux mathématiques ?','Les mathématiques sont-elles un langage au même titre que le français ?','jaimarre','cvallée',NULL,NULL,NULL,1,0,1,0),
(6,'gfield','2022-04-29 10:13:52','Qu\'a apporté Poincarré aux mathématiques ?','Les mathématiques sont-elles un langage au même titre que le français ?','jaimarre','cvallée',NULL,NULL,NULL,0,0,1,0),
(7,'emiossec','2022-04-29 09:39:32','Question 1 ?','Question 2 ?','jaimarre','cvallée',NULL,NULL,NULL,0,0,1,0),
(8,'clavallée','2022-05-04 14:26:55','Intérêt des IoT dans le monde de demain ?','Comment les hommes du passé envisageaient-ils le monde d\'aujourd\'hui ?','jaimarre','cvallée',NULL,NULL,NULL,1,0,0,0),
(9,'ttoto','2022-05-02 09:42:27','Quel est l\'avenir de l\'ordinateur ?','L\'univers est-il simplement un monde de nombres ?','jaimarre','cvallée',NULL,NULL,NULL,0,0,0,0),
(10,'ttoto','2022-05-02 09:44:11','Quel est l\'avenir de l\'ordinateur ?','L\'univers est-il simplement un monde de nombres ?','jaimarre','cvallée',NULL,NULL,NULL,0,0,0,0),
(11,'gfield','2022-05-04 13:02:37','Qu\'a apporté Poincarré aux mathématiques ?','Les mathématiques sont-elles un langage au même titre que le français ?','jaimarre','cvallée',NULL,NULL,NULL,0,0,1,0),
(12,'jarbuckle','2022-05-06 09:38:38','Arbre','Bus','jaimarre','cvallée',NULL,'2022-05-06 13:23:01',NULL,0,1,1,0),
(13,'jarbuckle','2022-05-06 09:41:06','Arbre','Bus','jaimarre','cvallée',NULL,'2022-05-06 13:23:01',NULL,0,1,0,0),
(14,'jarbuckle','2022-05-06 11:11:29','Arbre','Bus','jaimarre','cvallée',NULL,'2022-05-06 13:23:01',NULL,0,1,1,0),
(15,'jarbuckle','2022-05-06 11:12:37','Arbre','Bus','jaimarre','cvallée',NULL,'2022-05-06 13:23:01',NULL,1,1,0,0),
(16,'jarbuckle','2022-05-06 11:14:26','Arbre','Bus','jaimarre','cvallée',NULL,'2022-05-06 13:23:01',NULL,1,1,1,0),
(17,'jarbuckle','2022-05-06 11:14:50','Arbre','Bus','jaimarre','cvallée',NULL,'2022-05-06 13:23:01',NULL,1,1,1,0),
(18,'jarbuckle','2022-05-06 11:19:13','Arbre','Bus','jaimarre','cvallée',NULL,'2022-05-06 13:23:01',NULL,0,1,1,0),
(19,'jarbuckle','2022-05-06 11:19:36','Arbre','Bus','jaimarre','cvallée',NULL,'2022-05-06 13:23:01',NULL,1,1,1,0),
(20,'jarbuckle','2022-05-06 11:21:02','Arbre','Bus','jaimarre','cvallée',NULL,'2022-05-06 13:23:01',NULL,1,1,0,0),
(21,'jarbuckle','2022-05-06 11:23:01','Arbre','Bus','jaimarre','cvallée',NULL,'2022-05-06 13:23:01',NULL,1,1,0,0);
/*!40000 ALTER TABLE `form` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specs`
--

DROP TABLE IF EXISTS `specs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `specs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spec` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specs`
--

LOCK TABLES `specs` WRITE;
/*!40000 ALTER TABLE `specs` DISABLE KEYS */;
INSERT INTO `specs` VALUES
(0,'Aucune'),
(1,'Histoire-géographie, géopolitique et sciences politiques'),
(2,'Humanités, littérature et philosophie'),
(3,'Langues, littératures et cultures étrangères'),
(4,'Littérature et LCA (langues et cultures de l’Antiquité)'),
(5,'Mathématiques'),
(6,'Numérique et sciences informatiques'),
(7,'Physique-chimie'),
(8,'SVT (Sciences de la Vie et de la Terre)'),
(9,'Sciences de l’ingénieur'),
(10,'SES (Sciences Économiques et Sociales)'),
(11,'Éducation physique, pratiques et culture sportives'),
(12,'Arts');
/*!40000 ALTER TABLE `specs` ENABLE KEYS */;
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
  `class` varchar(50) DEFAULT NULL COMMENT 'Classe de l''étudiant',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES
('clavallee','daed143fe','T02'),
('emiossec','azed123fe','T02'),
('gfield','123456789af','T01'),
('ttoto','GX6tZSe?','T02');
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
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'Définit le grade de l''user; 0: étudiant ; 1: enseignant; 2: proviseur adjoint ; 3: secrétaire ',
  `password` varchar(100) DEFAULT NULL COMMENT 'Mot de passe à hasher',
  `lastLog` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `firstname` varchar(100) DEFAULT NULL COMMENT 'Pour la communication',
  `lastname` varchar(100) DEFAULT NULL COMMENT 'Pour la communication',
  `email` varchar(254) DEFAULT NULL COMMENT 'Pour la communication',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tous les utilisateurs';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
('atest4',0,'*AC4A8123F9C85F62549B86127FBA7AFE6104E529','2022-05-02 09:14:01','alban','test4','test4@mail.fr'),
('clavallée',1,'*537DCD1B1050ABB69204D6C5B69DF1D9F5628246','2022-05-04 12:29:49','Cédric','Lavallée','lavallee.cedric@gmail.com'),
('dtest6',0,'*08BE401DC4A3836778A3A9DF2BA598AA0E25F790','2022-05-02 09:15:12','dylan','test6','test6@mail.fr'),
('eleve',0,'*AC921E256297DA58EDFA09AD2ECB0844294D0CC1','2022-05-06 06:24:07','Elève','Modèle','eleve@modele.fr'),
('emiossec',0,'*1209637CCC738D96080B6529808019AC2865FEB7','2022-05-04 12:29:49','Eric','Miossec','eric.miossec@ac-poitiers.fr'),
('gfield',0,'*C94F61C0840120D06C14F1C93FD5A327335021E7','2022-05-05 11:08:56','gar','field','gar@field.com'),
('gfield1',0,'Bonjour','2022-05-05 11:45:23','gar','field','gar@feld.com'),
('jaimarre',1,'*203169C7928B974CFACD3A683DBB8F3495583600','2022-05-05 09:12:39','Jean','aimarre','jean.aimarre@ac-poitiers.fr'),
('jquille',2,'*18CC52BB809704BBD196BC40745CA983C2B95E34','2022-04-26 14:10:07','Jean','Quille','jean.quille@ac-poitiers.fr'),
('mtest7',0,'*B073F7CA5BB41EFF2A8F0DAB89D3ECD14A50FB7B','2022-05-02 09:15:35','mario','test7','test7@mail.fr'),
('pemploi',1,'*FE9A92983BAB1202EB3D0D3C1A2D2DC730245476','2022-04-26 14:24:41','Paul','Emploi','paul.emploi@ac-poitiers.fr'),
('provi',2,'*18CC52BB809704BBD196BC40745CA983C2B95E34','2022-05-06 06:22:44','Provi','Seur','provi@seur.fr'),
('ptest1',0,'*B9EDD8987D56F4057222A9AC2D9F36A90C523D58','2022-05-02 09:12:31','pouet','test1','test1@gmail.com'),
('ptest2',0,'*EFE1F741FAFAC46159EAB3B43C7F9A0CA14056FF','2022-05-02 09:12:55','pouet','test2','test2@mail.fr'),
('secretaire',3,'*5FB8025CDCECFD04B2333A327036812DA8C80466','2022-05-06 06:24:07','Secré','Taire','secre@taire.fr'),
('stest3',0,'*034412DCD510A74FDEF10417F95A2FCAAD047D67','2022-05-02 09:13:32','Stan','test3','test3@mail.fr'),
('test5',0,'*3C92989FDA53C67F5DABA2991016B2A80CF03DAF','2022-05-02 09:14:37','kevin','test5','test5@mail.fr'),
('ttiti',1,'*AC921E256297DA58EDFA09AD2ECB0844294D0CC1','2022-04-29 18:08:11','tete','titi','titi@tete.fr'),
('ttoto',0,'*AC921E256297DA58EDFA09AD2ECB0844294D0CC1','2022-04-29 18:07:50','tutu','toto','toto@gmail.coco');
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

-- Dump completed on 2022-05-06 16:17:44
