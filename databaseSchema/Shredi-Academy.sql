-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: shredi_academy_project
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `exercises`
--

DROP TABLE IF EXISTS `exercises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exercises` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `notes` mediumtext DEFAULT NULL,
  `exercise_type` varchar(50) DEFAULT NULL,
  `reps` int(11) DEFAULT NULL,
  `sets` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `custom_exercise` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exercises`
--

LOCK TABLES `exercises` WRITE;
/*!40000 ALTER TABLE `exercises` DISABLE KEYS */;
INSERT INTO `exercises` VALUES (2,'Squats',NULL,'Legs',8,5,135,0),(3,'Shoulder Press',NULL,'Shoulder',3,10,75,0),(4,'Crunches',NULL,'Abs',35,4,30,0),(5,'Burpees',NULL,'Abs',10,3,16,0),(30,'Hammer Curls',NULL,'Biceps',10,4,20,0),(31,'Skull Crushers',NULL,'Triceps',10,3,55,0),(36,'Brand New',NULL,'Abs',3,3,8,1),(37,'Brand Old',NULL,'Abs',3,3,55,1),(38,'New three',NULL,'Abs',1,1,4,1),(39,'Extra new',NULL,'Abs',3,3,3,1),(40,'Preacher Curls',NULL,'Biceps',10,4,20,0),(41,'Curls',NULL,'Biceps',10,4,20,0),(42,'Lat Pulldowns',NULL,'Back',10,4,100,0),(43,'Seated Rows',NULL,'Back',10,4,80,0);
/*!40000 ALTER TABLE `exercises` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `progress`
--

DROP TABLE IF EXISTS `progress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `progress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `exercise_id` int(11) NOT NULL,
  `weight` decimal(6,0) NOT NULL,
  `first_entry` tinyint(1) NOT NULL,
  `personal_best` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `progress`
--

LOCK TABLES `progress` WRITE;
/*!40000 ALTER TABLE `progress` DISABLE KEYS */;
INSERT INTO `progress` VALUES (1,'2023-04-02',2,90,1,0),(2,'2023-05-30',2,90,0,0),(3,'2023-06-10',2,90,0,0),(4,'2023-06-30',2,95,0,0),(5,'2023-07-15',2,95,0,0),(6,'2023-08-24',2,95,0,0),(7,'2023-09-14',2,95,0,0),(8,'2023-10-01',2,100,0,0),(9,'2023-11-03',2,100,0,0),(10,'2023-12-05',2,105,0,0),(11,'2024-01-17',2,105,0,0),(12,'2024-02-03',2,105,0,0),(13,'2024-03-10',2,105,0,0),(14,'2024-04-04',2,110,0,1),(15,'2023-04-02',3,70,1,0),(16,'2023-07-15',3,75,0,0),(17,'2024-02-03',3,80,0,1),(18,'2023-04-02',5,0,1,0),(19,'2023-05-30',4,0,0,0),(20,'2023-06-10',4,0,0,0),(21,'2023-06-30',4,0,0,0),(22,'2023-07-15',4,0,0,0),(23,'2023-08-24',4,10,0,0),(24,'2023-09-14',4,10,0,0),(25,'2023-10-01',4,10,0,0),(26,'2023-11-03',4,10,0,0),(27,'2023-12-05',4,10,0,0),(28,'2024-01-17',4,10,0,0),(29,'2024-02-03',4,10,0,0),(30,'2024-03-10',4,10,0,0),(31,'2024-04-04',4,10,0,1),(32,'2023-04-02',4,15,1,0),(33,'2023-05-30',4,15,0,0),(34,'2023-06-10',4,15,0,0),(35,'2023-06-30',4,15,0,0),(36,'2023-07-15',4,15,0,0),(37,'2023-08-24',4,15,0,0),(38,'2023-09-14',4,20,0,0),(39,'2023-10-01',4,20,0,0),(40,'2023-11-03',4,20,0,0),(41,'2023-12-05',4,25,0,0),(42,'2024-01-17',4,25,0,0),(43,'2024-02-03',4,20,0,0),(44,'2024-03-10',4,20,0,0),(45,'2024-04-04',4,20,0,0),(46,'2024-04-06',37,3,1,0),(47,'0000-00-00',37,4,0,0),(48,'2024-04-06',37,4,0,0),(49,'2024-04-05',37,5,0,0),(50,'2024-04-05',37,6,0,0),(51,'2024-04-05',37,15,0,0),(52,'2024-04-05',36,4,0,1),(53,'2024-04-05',36,4,0,0),(54,'2024-04-05',36,4,0,0),(55,'2024-04-05',36,4,0,0),(56,'2024-04-05',36,4,0,0),(57,'2024-04-05',36,5,0,0),(58,'2024-04-05',36,6,0,0),(59,'2024-04-05',36,7,0,0),(60,'2024-04-05',36,8,0,0),(61,'2024-04-05',35,4,0,0),(62,'2024-04-05',38,1,1,0),(63,'2024-04-05',38,2,0,0),(64,'2024-04-05',38,3,0,0),(65,'2024-04-05',38,4,0,1),(66,'2024-04-05',37,40,0,0),(67,'2024-04-05',36,8,0,1),(68,'2024-04-05',37,35,0,0),(69,'2024-04-05',37,55,0,1),(70,'2024-04-05',5,15,0,0),(71,'2024-04-05',5,16,0,1),(72,'2024-04-05',4,30,0,1),(73,'2024-04-05',39,3,1,1),(74,'2024-04-21',40,20,1,1),(75,'2024-04-21',40,20,0,0),(76,'2024-04-21',40,20,0,0),(77,'2024-04-21',40,20,0,0),(78,'2024-04-21',40,20,0,0),(79,'2024-04-21',36,8,0,1),(80,'2024-04-21',36,8,0,1);
/*!40000 ALTER TABLE `progress` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_info`
--

DROP TABLE IF EXISTS `user_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_info` (
  `User_ID` int(11) NOT NULL,
  `User_Name` varchar(100) DEFAULT NULL,
  `User_Age` int(11) DEFAULT NULL,
  `User_Height` float DEFAULT NULL,
  `User_Gender` varchar(10) DEFAULT NULL,
  `User_Weight` float DEFAULT NULL,
  PRIMARY KEY (`User_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_info`
--

LOCK TABLES `user_info` WRITE;
/*!40000 ALTER TABLE `user_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(512) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'erin','69a382de7a3ed31f8feb5ebb9af64f7d08783a529ac46'),(2,'e','e7d4d30be766d3444e066bed99591b594b5cbc923c34c');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workout_exercise_connection`
--

DROP TABLE IF EXISTS `workout_exercise_connection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `workout_exercise_connection` (
  `workoutId` int(11) DEFAULT NULL,
  `exerciseId` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workout_exercise_connection`
--

LOCK TABLES `workout_exercise_connection` WRITE;
/*!40000 ALTER TABLE `workout_exercise_connection` DISABLE KEYS */;
INSERT INTO `workout_exercise_connection` VALUES (1,40,1),(1,41,2),(1,42,3),(1,43,4),(1,30,5),(0,4,7),(0,4,10),(0,4,13),(0,4,16),(0,4,19),(0,0,22),(0,0,23),(0,0,24),(0,0,25),(0,0,26),(0,0,27),(0,4,29),(0,4,32),(47,36,59),(48,2,64),(48,3,65),(48,5,66);
/*!40000 ALTER TABLE `workout_exercise_connection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workouts`
--

DROP TABLE IF EXISTS `workouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `workouts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `muscle_group` varchar(100) DEFAULT NULL,
  `difficulty_level` varchar(50) DEFAULT NULL,
  `day_of_the_week` varchar(20) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workouts`
--

LOCK TABLES `workouts` WRITE;
/*!40000 ALTER TABLE `workouts` DISABLE KEYS */;
INSERT INTO `workouts` VALUES (1,'Back','2','T W ','Back and Biceps'),(2,'Legs','4','F','Leg Day'),(47,'Chest','2','M ','Chest Day'),(48,'Back','2','U M T W H F S ','Some workout');
/*!40000 ALTER TABLE `workouts` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-04-23 18:28:49
