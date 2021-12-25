-- MySQL dump 10.13  Distrib 8.0.27, for Linux (x86_64)
--
-- Host: localhost    Database: mongolia
-- ------------------------------------------------------
-- Server version	8.0.27-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Feed_type`
--

DROP TABLE IF EXISTS `Feed_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Feed_type` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `adate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Name` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Price` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Comment` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cow_aged`
--

DROP TABLE IF EXISTS `cow_aged`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cow_aged` (
  `q1` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `q2` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `q3` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `q4` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `cowTID` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `adate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cowID` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `ID` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1018 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cow_quarter`
--

DROP TABLE IF EXISTS `cow_quarter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cow_quarter` (
  `q1` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `q2` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `q3` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `q4` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `cowTID` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `adate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cowID` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `ID` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1065 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cuts`
--

DROP TABLE IF EXISTS `cuts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cuts` (
  `name` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `comment` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `weight` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `wast` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `price` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `adate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ID` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `data`
--

DROP TABLE IF EXISTS `data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `data` (
  `pens` json NOT NULL,
  `meat` int NOT NULL,
  `feed` int NOT NULL,
  `ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `feed`
--

DROP TABLE IF EXISTS `feed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `feed` (
  `pen` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `cows` mediumtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `price` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime DEFAULT NULL,
  `adate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ID` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `feed_cows`
--

DROP TABLE IF EXISTS `feed_cows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `feed_cows` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `adate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `FeedDate` date NOT NULL,
  `Pen` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Price` text NOT NULL,
  `Amount` int NOT NULL,
  `FeedID` text NOT NULL,
  `Comments` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `images` (
  `image` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `cowTID` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `adate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cowID` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `ID` int unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3180 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mon_cows`
--

DROP TABLE IF EXISTS `mon_cows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mon_cows` (
  `tag` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `boughtDate` date DEFAULT NULL,
  `herdsMan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `investor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `feedPrice` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `price` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `ageState` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `penDate` date DEFAULT NULL,
  `pen` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `last_weight` text,
  `date_weight` date DEFAULT NULL,
  `second_last_weight` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `second_last_date` date DEFAULT NULL,
  `first_weight` text,
  `recNo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `regNo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `cellNo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `megNo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `bankNo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `remarks` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `desr` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `source` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT 'yes',
  `calfState` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `calfDate` date DEFAULT NULL,
  `motherTag` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `groupIDBac` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `death` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `death_date` date DEFAULT NULL,
  `loging` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `locker` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `adate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ID` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `TID` int unsigned NOT NULL AUTO_INCREMENT,
  `groupID` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  PRIMARY KEY (`TID`)
) ENGINE=InnoDB AUTO_INCREMENT=2054 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mon_group`
--

DROP TABLE IF EXISTS `mon_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mon_group` (
  `pen` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `groupName` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `BCdata` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `data` json DEFAULT NULL,
  `stats` json DEFAULT NULL,
  `ID` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `package` json DEFAULT NULL,
  `slDate` date DEFAULT NULL,
  `done` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `adate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TID` int unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`TID`)
) ENGINE=InnoDB AUTO_INCREMENT=208 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mon_list`
--

DROP TABLE IF EXISTS `mon_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mon_list` (
  `data` json NOT NULL,
  `adate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ID` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mon_medical`
--

DROP TABLE IF EXISTS `mon_medical`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mon_medical` (
  `cowVaccine` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `medDate` date DEFAULT NULL,
  `cowTID` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `adate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cowID` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `ID` int unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1627 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mon_package`
--

DROP TABLE IF EXISTS `mon_package`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mon_package` (
  `pac_type` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `weight` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `cowTID` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `adate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cowID` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `ID` int unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=995 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mon_weight`
--

DROP TABLE IF EXISTS `mon_weight`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mon_weight` (
  `cowWeight` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `weightDate` date DEFAULT NULL,
  `cowTID` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `adate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cowID` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `ID` int unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=12043 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pen_move`
--

DROP TABLE IF EXISTS `pen_move`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pen_move` (
  `cowID` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Pen` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `type` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `date` date DEFAULT NULL,
  `adate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ID` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2454 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pens`
--

DROP TABLE IF EXISTS `pens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pens` (
  `name` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `users` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `price` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `feedlot` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `adate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ID` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sold`
--

DROP TABLE IF EXISTS `sold`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sold` (
  `cowID` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Name` text NOT NULL,
  `Date` date NOT NULL,
  `Price` int DEFAULT NULL,
  `HerdsmanNumber` int DEFAULT NULL,
  `TID` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`TID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stats`
--

DROP TABLE IF EXISTS `stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stats` (
  `data` json NOT NULL,
  `adate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ID` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1466 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tokens`
--

DROP TABLE IF EXISTS `tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tokens` (
  `user` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ip` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `token` varchar(64) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `adate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ID` int unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1651 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `username` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `permission` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `adate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ID` int unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-12-25  4:37:29
