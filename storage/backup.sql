-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: store
-- ------------------------------------------------------
-- Server version	8.0.34

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
-- Table structure for table `accounts`
--
drop database if exists	`store`;
create database `store`;
use `store`;
DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts` (
  `username` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES ('0999999999','b6839b5aa44345759007b10c796e0b8f','disable'),('admin@123','b6839b5aa44345759007b10c796e0b8f','active'),('afx50452@omeie.com','$2y$10$8te7IrExujR3k12FKo78sulaeNhz3np/wHyen14ftGcb4EHlmr8j.','disable'),('cim73431@zbock.com','$2y$10$6XKxRQWNoGdsnRLKdD9ZM.Xq3AQcXocrt47t.Xh/T1/tZNyu1Xw8K','active'),('fmp02998@zslsz.com','$2y$10$4iVFutyyi0Uu6DSNT77WVuRu5P.zLzb228eZvAHBRSXXkbIJy7BhK','active'),('fpv77847@fosiq.com','2f9b83c001741d3949b55b4460fe26f2','disable'),('krc07594@zslsz.com','$2y$10$uLnd1d24.KxSaVVhO4i0JOiXmADh.3I8ipEGHXHG0lJJ5LaWb.ZVO','active'),('mmd15619@zslsz.com','$2y$10$qQsYuw148ju7quQuNfbX9uo9.gaY04HF/ptU9FCagM4PRPu.Nf.96','disable'),('mzo71613@zslsz.com','$2y$10$21XS3OJeNWilyMB7gFa7VOsuyJIsMN9uZ8kQRUJSNuZtLKE0XoycS','active'),('ndf01470@vogco.com','705acf84532cfb031fd07f87d530d8da','disable'),('ngz64130@zbock.com','$2y$10$6GlJBlaawr3dQYMTbRm48ex0t1Y/VY6UYR9O/HvmLVnC5PiFVRHXS','active'),('nlhhminhthang@gmail.com','$2y$10$PcGT1ETCRzOMLHr2QqMjI.L43Q.YmVjDTEv9czy2mLkO.6D6nWiMK','disable'),('nlhminhthang@gmail.com','$2y$10$8zgr3RYvU9EmERPXvaA9N.1L5Sx8OhIdHrGAtsORvC4lWmkInxICm','active'),('nvt69094@zbock.com','$2y$10$sVMbGqtkevd2SOTSeo6dwOISJBwYuopHuYcRBEhAGfrLB8W8O4xhG','disable'),('plm06455@fosiq.com','ce72e94fa884c11fbe52b8ced7a8102f','active'),('qfm50699@omeie.com','$2y$10$q6SOddAf3DszOKeAWE3A0OjuF6m4nVt5BwCKOs/.cCrZgrfFxlo6y','active'),('quilivh11@gmail.com','b6839b5aa44345759007b10c796e0b8f','active'),('rar62522@vogco.com','b6839b5aa44345759007b10c796e0b8f','disable'),('rot40200@zslsz.com','$2y$10$w1EW/cqG1hxNTf469XcuW.9CenlH4qF11WvDqKx39/kLvP3mPagkW','disable'),('sdh93228@zbock.com','$2y$10$tyJHs6ZHOW1Xr/GiQ2tbme/47UNlL0eRR7FJ.S5b/CL.kiU29J54O','disable'),('tgt39673@romog.com','10219c0c405b13c1ee19d7c02631f38e','disable'),('toi21194@fosiq.com','20b5082713143691b7c6604c9b492762','disable'),('ukj94208@omeie.com','$2y$10$xzwJsCuKLZEdJqz5XSkkT.7W2AOLkWhmIpgqT41TszIen0rS7DBu6','active'),('vut42107@fosiq.com','d6594a91e564215a0a49c44268727e00','disable');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart` (
  `C_ID` int NOT NULL,
  `P_ID` int DEFAULT NULL,
  `number` varchar(100) DEFAULT NULL,
  `totalprice` decimal(10) DEFAULT NULL,
  PRIMARY KEY (`C_ID`),
  KEY `P_ID` (`P_ID`),
  KEY `cart_ibfk_1` (`C_ID`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`C_ID`) REFERENCES `customers` (`C_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer` (
  `C_ID` int NOT NULL AUTO_INCREMENT,
  `CName` varchar(100) DEFAULT NULL,
  `CDOB` date DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  PRIMARY KEY (`C_ID`,`username`),
  KEY `customer_ibfk_1` (`username`),
  CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`username`) REFERENCES `accounts` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (1,NULL,NULL,NULL,'quilivh11@gmail.com'),(3,NULL,NULL,NULL,'cim73431@zbock.com'),(4,NULL,NULL,NULL,'quilivh11@gmail.com'),(5,NULL,NULL,NULL,'quilivh11@gmail.com'),(6,NULL,NULL,NULL,'quilivh11@gmail.com'),(7,NULL,NULL,NULL,'ukj94208@omeie.com'),(8,NULL,NULL,NULL,'qfm50699@omeie.com'),(9,NULL,NULL,NULL,'krc07594@zslsz.com'),(13,NULL,NULL,NULL,'fmp02998@zslsz.com'),(14,NULL,NULL,NULL,'mzo71613@zslsz.com'),(15,NULL,NULL,NULL,'ngz64130@zbock.com'),(16,NULL,NULL,NULL,'plm06455@fosiq.com');
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employees` (
  `E_ID` int NOT NULL AUTO_INCREMENT,
  `level` varchar(50) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `Ename` varchar(100) DEFAULT NULL,
  `EDOB` date DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  PRIMARY KEY (`E_ID`),
  KEY `username` (`username`),
  CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`username`) REFERENCES `accounts` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,NULL,NULL,NULL,NULL,'admin@123');
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `history` (
  `H_ID` int NOT NULL AUTO_INCREMENT,
  `ImportDate` date DEFAULT NULL,
  `ExportDate` date DEFAULT NULL,
  `P_ID` int DEFAULT NULL,
  `ProNumber` varchar(100) DEFAULT NULL,
  `O_ID` int DEFAULT NULL,
  PRIMARY KEY (`H_ID`),
  KEY `P_ID` (`P_ID`),
  KEY `O_ID` (`O_ID`),
  CONSTRAINT `history_ibfk_1` FOREIGN KEY (`P_ID`) REFERENCES `product` (`P_ID`),
  CONSTRAINT `history_ibfk_2` FOREIGN KEY (`O_ID`) REFERENCES `orders` (`O_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history`
--

LOCK TABLES `history` WRITE;
/*!40000 ALTER TABLE `history` DISABLE KEYS */;
/*!40000 ALTER TABLE `history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `O_ID` int NOT NULL AUTO_INCREMENT,
  `totalprice` decimal(10,2) DEFAULT NULL,
  `paymentmethod` varchar(20) DEFAULT NULL,
  `E_ID` int DEFAULT NULL,
  PRIMARY KEY (`O_ID`),
  KEY `E_ID` (`E_ID`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`E_ID`) REFERENCES `employees` (`E_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product` (
  `P_ID` int NOT NULL AUTO_INCREMENT,
  `PName` varchar(100) DEFAULT NULL,
  `prices` decimal(10,0) DEFAULT NULL,
  `Material` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `validproduct` int DEFAULT NULL,
  `E_ID` int DEFAULT NULL,
  PRIMARY KEY (`P_ID`),
  KEY `E_ID` (`E_ID`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`E_ID`) REFERENCES `employees` (`E_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'Iced Matcha Coconut Latte',55000,'Matcha powder, Coconut milk, Ice, Espresso or coffee ','IcedMatcha Coconut Latte.jpg',500,1),(2,'Lavender Honey Rooibos Tea',25000,'Rooibos tea leaves, Lavender flowers or lavender syrup, Honey, Hot water','Lavender Honey Rooibos Tea.jpg',500,1),(3,'Iced Salted Caramel Latte',35000,'Espresso or coffee, Milk, Caramel syrup, Sea salt, Ice','Iced Salted Caramel Latte.jpg',500,1),(9,'Chamomile Lavender Mint Tea',35000,'Chamomile tea bags or loose chamomile flowers, Lavender flowers or lavender syrup','Chamomile Lavender Mint Tea.jpg',500,1);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `verify`
--

DROP TABLE IF EXISTS `verify`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `verify` (
  `otpid` int NOT NULL AUTO_INCREMENT,
  `otpcode` varchar(100) DEFAULT NULL,
  `otpok` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`otpid`),
  KEY `username` (`username`),
  CONSTRAINT `verify_ibfk_1` FOREIGN KEY (`username`) REFERENCES `accounts` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `verify`
--

LOCK TABLES `verify` WRITE;
/*!40000 ALTER TABLE `verify` DISABLE KEYS */;
INSERT INTO `verify` VALUES (1,NULL,NULL,'mzo71613@zslsz.com'),(2,NULL,NULL,'nlhminhthang@gmail.com'),(3,NULL,NULL,'quilivh11@gmail.com'),(4,NULL,NULL,'ngz64130@zbock.com');
/*!40000 ALTER TABLE `verify` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-03-28 17:31:56
