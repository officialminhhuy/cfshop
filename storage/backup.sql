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
INSERT INTO `accounts` VALUES ('admin@123','b6839b5aa44345759007b10c796e0b8f','active'),('quilivh11@gmail.com','b6839b5aa44345759007b10c796e0b8f','active');
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
  `totalprice` decimal(10,0) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (1,'Nguyễn Minh Huy','2002-08-24','1806/67 Huỳnh Tấn Phát, Thị Trấn Nhà Bè, Nhà Bè,TP.HCM','quilivh11@gmail.com');
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
INSERT INTO `employees` VALUES (1,'Boss','Manager','Nguyen Minh Huy',NULL,'admin@123');
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
  `Material` text,
  `image` varchar(255) DEFAULT NULL,
  `validproduct` int DEFAULT NULL,
  `E_ID` int DEFAULT NULL,
  PRIMARY KEY (`P_ID`),
  KEY `E_ID` (`E_ID`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`E_ID`) REFERENCES `employees` (`E_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'Iced Matcha Coconut Latte',55000,'Matcha powder, Coconut milk, Ice, Espresso or coffee ','IcedMatcha Coconut Latte.jpg',500,1),(2,'Lavender Honey Rooibos Tea',25000,'Rooibos tea leaves, Lavender flowers or lavender syrup, Honey, Hot water','Lavender Honey Rooibos Tea.jpg',500,1),(3,'Iced Salted Caramel Latte',35000,'Espresso or coffee, Milk, Caramel syrup, Sea salt, Ice','Iced Salted Caramel Latte.jpg',500,1),(4,'Chamomile Lavender Mint Tea',35000,'Chamomile tea bags or loose chamomile flowers, Lavender flowers or lavender syrup','Chamomile Lavender Mint Tea.jpg',500,1),(5,'Iced Nutella Latte',60000,'Nutella (hazelnut chocolate spread), Milk, Espresso or coffee, Ice','Iced Nutella Latte.jpg',500,1),(6,'Coconut Lemongrass Green Tea',40000,' Green tea bags or loose green tea leaves, Lemongrass, Coconut milk or coconut syrup, Hot water','Coconut Lemongrass Green Tea.jpg',500,1),(7,'Iced Maple Bourbon Latte',55000,'Espresso or coffee, Milk, Maple syrup, Bourbon (optional), Ice','Iced Maple Bourbon Latte.jpg',500,1),(8,'Rose Hibiscus Herbal Tea',36000,'Hibiscus tea bags or dried hibiscus flowers, Rose petals or rose syrup, Hot water','rosehebicus.jpg',500,1),(9,'Iced Cookies and Cream Latte',47000,'Milk, Espresso or coffee, Cookies and cream syrup or crushed cookies, Ice','Iced Cookies and Cream Latte.jpg',500,1),(10,'Cherry Blossom Green Tea',40000,'Green tea bags or loose green tea leaves, Cherry blossom petals or cherry blossom syrup, Hot water','Cherry Blossom Green Tea.jpg',500,1),(11,'Iced Almond Joy Latte',28000,'Almond milk, Chocolate syrup, Coconut syrup, Espresso or coffee, Ice','Iced Almond Joy Latte.jpg',500,1),(12,'Passionfruit Mango Herbal Tea',65000,'Dried passionfruit, Dried mango, Herbal tea bags or loose herbal tea leaves, Hot water','Mango Green Tea.jpg',500,1),(13,'Iced Peanut Butter Cup Mocha',35000,'Peanut butter, Chocolate syrup, Espresso or coffee, Milk, Ice','Iced Peanut Butter Cup Mocha.jpg',500,1),(14,'Coconut Lime Herbal Tea',35000,'Dried coconut flakes, Lime slices or lime syrup, Herbal tea bags or loose herbal tea leaves, Hot water','Coconut Lime Herbal Tea.jpg',500,1),(15,'Iced Snickerdoodle Latte',42000,'Cookies and cream syrup or flavoring, Espresso or coffee, Milk, Ice','Iced Snickerdoodle Latte.jpg',500,1),(16,'Pineapple Sage Herbal Tea',31000,'Herbal tea blend, Pineapple, Sage','Pineapple.jpg',500,1),(17,'Iced Tuxedo Mocha',70000,'White chocolate syrup, Dark chocolate syrup, Espresso or coffee, Milk, Ice','Iced Tuxedo Mocha.jpg',500,1),(18,'Blue Butterfly Pea Flower Tea',30000,'Butterfly pea flower tea, Lemon or lime juice','Blue Butterfly Pea Flower Tea.jpg',500,1),(19,'Iced Caramel Toffee Latte',45000,'Caramel syrup, Toffee syrup, Espresso or coffee, Milk, Ice','Iced Caramel Toffee Latte.jpg',500,1),(20,'Ginger Peach Green Tea',33000,'Green tea, Ginger, Peach','Ginger Peach Green Tea.jpg',500,1),(21,'Iced Brown Sugar Cinnamon Latte',20000,'Brown sugar syrup, Cinnamon syrup, Espresso or coffee, Milk, Ice','Iced Brown Sugar Cinnamon Latte.jpg',500,1),(22,'Strawberry Basil Herbal Tea',25000,'Herbal tea blend, Strawberry, Basil','Strawberry Basil Herbal Tea.jpg',500,1),(23,'Iced Hazelnut Praline Latte',28000,'Hazelnut syrup, Praline syrup, Espresso or coffee, Milk, Ice','Iced Hazelnut Praline Latte.jpg',500,1),(24,'Dragonfruit Mango Green Tea',27000,'Green tea, Dragonfruit, Mango','Dragonfruit Mango Green Tea.jpg',500,1),(25,'Iced Caramel Frappuccino',36000,'Caramel syrup, Espresso or coffee, Milk, Ice, Whipped cream ','Iced Caramel.jpg',500,1),(26,'Lemon Ginger Herbal Tea',45000,'Herbal tea blend, Lemon, Ginger','Lemon Ginger Herbal.jpg',500,1),(27,'Iced Vanilla Bean Latte',62000,'Vanilla syrup or bean, Espresso or coffee, Milk, Ice','Iced Vanilla Bean Latte.jpg',500,1),(28,'Hibiscus Berry Iced Tea',47000,'Hibiscus tea, Mixed berries','Hibiscus Berry Iced Tea.jpg',500,1),(29,'Iced Coconut Mocha',43000,'Coconut syrup, Chocolate syrup, Espresso or coffee, Milk, Ice','Iced Coconut Mocha.jpg',500,1),(30,'Matcha Latte',44000,'Matcha, Milk, Sweetener','iced-matcha-latte-1-web.jpg',500,1),(31,'Iced Peppermint Mocha',23000,'Peppermint syrup, Chocolate syrup, Espresso or coffee, Milk, Ice','Iced Peppermint Mocha.jpg',500,1),(32,'Raspberry Hibiscus Iced Tea',36000,'Hibiscus tea, Raspberry','Raspberry Hibiscus Iced Tea.jpg',500,1),(33,'Iced Caramel Crunch Latte',41000,'Caramel syrup, Espresso or coffee, Milk, Ice, Caramel drizzle ','Iced Caramel Crunch Latte.jpg',500,1),(34,'Chai Spice Iced Tea',14000,'Chai tea, Spices (cinnamon, cardamom, cloves, ginger), Ice','Chai Spice Iced Tea.jpg',500,1),(35,'Iced Cappuccino',32000,'Espresso or coffee, Milk foam, Ice','Iced Cappuccinoo.jpg',500,1),(36,'Pomegranate Green Tea',46000,'Green tea, Pomegranate juice or syrup','Pomegranate Green Tea.jpg',500,1),(37,'Iced Chocolate Hazelnut Latte',41000,'Chocolate syrup, Hazelnut syrup, Espresso or coffee, Milk, Ice','Iced Chocolate Hazelnut Latte.jpg',500,1),(38,'Lemon Verbena Iced Tea',32000,'Verbena tea, Lemon','Lemon Verbena Iced Tea.jpg',500,1),(39,'Iced Maple Pecan Latte',36000,'Maple syrup, Pecan syrup, Espresso or coffee, Milk, Ice','Iced Maple Pecan Latte.jpg',500,1),(40,'Turmeric Citrus Herbal Tea',48000,'Herbal tea blend, Turmeric, Citrus (lemon, orange)','Turmeric Citrus Herbal Tea.jpg',500,1),(41,'Iced Tiramisu Latte',51000,'Tiramisu syrup, Espresso or coffee, Milk, Ice','Iced Tiramisu Latte.jpg',500,1),(42,'Blueberry Lavender Herbal Tea',50000,'Herbal tea blend, Blueberry, Lavender','Blueberry Lavender Herbal Tea.jpg',500,1),(43,'Iced Caramel Macchiato',57000,'Caramel syrup, Espresso or coffee, Milk, Ice','iced-caramel-macchiato-photo-683x1024.jpg',500,1),(44,'Peppermint Herbal Tea',24000,'Peppermint leaves','Peppermint Herbal Tea.jpg',500,1),(45,'Iced Caramel Mocha',26000,'Caramel syrup, Chocolate syrup, Espresso or coffee, Milk, Ice','Iced Caramel Mocha.jpg.jpg',500,1),(46,'Jasmine Pearl Tea',27000,'Jasmine tea, Pearl tapioca ','Jasmine Pearl Teaa.jpg',500,1),(47,'Iced Hazelnut Coffee',23000,'Hazelnut syrup, Coffee, Milk, Ice','Iced Chocolate Hazelnut Latte.jpg',500,1),(48,'Berry Herbal Tea',29000,'Mixed berries','Berry Herbal Tea.jpg',500,1),(49,'Iced White Chocolate Mocha',34000,'White chocolate syrup, Espresso or coffee, Milk, Ice','Iced White Chocolate Mocha.jpg',500,1),(50,'Chamomile Herbal Tea',39000,'Chamomile flowers','Chamomile Herbal Tea.jpg',500,1),(51,'Iced Cinnamon Latte',40000,'Cinnamon syrup, Espresso or coffee, Milk, Ice','Iced Brown Sugar Cinnamon Latte.jpg',500,1),(52,'Mango Green Tea',50000,'Green tea, Mango','Mango Green Tea.jpg',500,1),(53,'Iced Irish Cream Coffee',30000,'Irish cream syrup, Coffee, Milk, Ice','Iced Irish Cream Coffee.jpg',500,1),(54,'Lavender Herbal Tea',32000,'Lavender','Blueberry Lavender Herbal Tea.jpg',500,1),(55,'Iced Cinnamon Dolce Latte',35000,'Mint syrup, Lime juice, Coffee, Milk, Ice, Mint leaves','Iced Cinnamon Dolce Lattee.jpg',500,1),(56,'Peach Iced Tea',45000,'Vanilla syrup, Chai tea, Milk','Peach Iced Tea.jpg',500,1),(57,'Iced Vanilla Latte',55000,'Coconut syrup, Coffee, Milk, Ice','Iced Vanilla Lattee.jpg',500,1),(58,'Mint Green Tea',25000,'Black tea, Mango','Mint Green Tea.jpg',500,1),(59,'Iced Caramel Coffee',60000,'Caramel syrup, Espresso or coffee, Milk, Vanilla syrup ','Iced Caramel Coffeee.jpg',500,1),(60,'Spiced Chai Latte',15000,'Chai syrup or chai tea concentrate, Milk, Spices (cinnamon, cardamom, cloves, ginger)','Spiced Chai Latte.jpg',500,1),(61,'Iced Mocha',45000,'Chocolate syrup, Espresso or coffee, Milk, Ice','Iced Mochaa.jpg',500,1),(62,'Lemon Iced Tea',55000,'Black tea or herbal tea, Lemon juice, Sugar, Ice','Lemon Iced tea.jpg',500,1),(63,'Iced Cinnamon Dolce Latte',55000,'Cinnamon dolce syrup, Espresso or coffee, Milk, Ice','Iced Cinnamon Dolce Lattee.jpg',500,1),(64,'Peach Iced Tea',25000,'Black tea or herbal tea, Peach syrup or peach puree, Ice','Peach Iced Tea.jpg',500,1),(65,'Iced Vanilla Latte',26000,'Vanilla syrup or vanilla extract, Espresso or coffee, Milk, Ice','Iced Vanilla Latte.jpg',500,1),(66,'Mint Green Tea',34000,'Green tea, Mint leaves, Sweetener (optional)','Mint Green Tea.jpg',500,1),(67,'Iced Caramel Coffee',36000,'Caramel syrup, Coffee, Milk, Ice','Iced Caramel Coffeea.jpg',500,1),(68,'Spiced Chai Latte',45000,'Chai syrup or chai tea concentrate, Milk, ','Spiced Chai Lattee.jpg',500,1),(69,'Iced Mocha chocolate',55000,'Chocolate syrup, Espresso or coffee, Milk, Ice','Iced Mocha chocolate.jpg',500,1),(70,'Lemon coconout Iced Tea',50000,'Black tea or herbal tea, Lemon juice, Sugar, Ice','Lemon Iced Teae.jpg',500,1),(71,'Iced Caramel Macchiato',46000,'Cinnamon dolce syrup, Espresso or coffee, Milk, Ice','iced-caramel-macchiato-photo-683x1024.jpg',500,1),(72,'Peppermint Herbal Tea',35000,'Peppermint leaves','Peppermint Herbal Tea.jpg',500,1),(73,'Iced Caramel Mocha',29000,'Caramel syrup, Chocolate syrup, Espresso or coffee, Milk, Ice','Iced Caramel Mocha.jpg.jpg',500,1),(74,'Jasmine Pearl Tea',29000,'Jasmine tea, Pearl tapioca (optional)','blackcafe.jpg',500,1),(75,'Iced Hazelnut Coffee',35000,'Hazelnut syrup, Coffee, Milk, Ice','Iced Hazelnut Coffee.jpg',500,1);
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

-- Dump completed on 2024-03-31  2:49:46
