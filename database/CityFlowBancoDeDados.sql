-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: cityflow
-- ------------------------------------------------------
-- Server version	8.0.41

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
-- Table structure for table `atividade`
--

DROP TABLE IF EXISTS `atividade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `atividade` (
  `id_atividade` int NOT NULL AUTO_INCREMENT,
  `id_usuarios` int NOT NULL,
  `id_evento` int NOT NULL,
  `id_categoria` int NOT NULL,
  `feedback` text,
  PRIMARY KEY (`id_atividade`),
  KEY `id_usuarios` (`id_usuarios`),
  KEY `id_evento` (`id_evento`),
  KEY `id_categoria` (`id_categoria`),
  CONSTRAINT `atividade_ibfk_1` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE,
  CONSTRAINT `atividade_ibfk_2` FOREIGN KEY (`id_evento`) REFERENCES `eventos_cadastrados` (`id_evento`) ON DELETE CASCADE,
  CONSTRAINT `atividade_ibfk_3` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atividade`
--

LOCK TABLES `atividade` WRITE;
/*!40000 ALTER TABLE `atividade` DISABLE KEYS */;
/*!40000 ALTER TABLE `atividade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `id_categoria` int NOT NULL AUTO_INCREMENT,
  `categoria_evento` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'Música'),(2,'Dança'),(3,'Leitura'),(4,'Gastronomia'),(5,'Esporte'),(6,'Cinema'),(7,'Teatro'),(8,'Performance'),(9,'Pintura/Arte'),(10,'Educação'),(11,'Standups'),(12,'Congressos/Paletras'),(13,'Cursos/Workshops'),(14,'Pride'),(15,'Religião/Espiritualidade'),(16,'Recitar'),(17,'Escrita/poemas');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventos_cadastrados`
--

DROP TABLE IF EXISTS `eventos_cadastrados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventos_cadastrados` (
  `id_evento` int NOT NULL AUTO_INCREMENT,
  `id_usuarios` int NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `subtitulo` varchar(255) DEFAULT NULL,
  `descIMG` varchar(255) DEFAULT NULL,
  `descricao` text,
  `rua` varchar(100) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `numero` int DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `CEP` varchar(11) DEFAULT NULL,
  `ponto_referencia` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `data_inicio_evento` date DEFAULT NULL,
  `data_fim_evento` date DEFAULT NULL,
  `horario_inicio_evento` time DEFAULT NULL,
  `horario_fim_evento` time DEFAULT NULL,
  `id_categoria` int NOT NULL,
  `Imagem` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_evento`),
  KEY `id_usuarios` (`id_usuarios`),
  KEY `id_categoria` (`id_categoria`),
  CONSTRAINT `eventos_cadastrados_ibfk_1` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE,
  CONSTRAINT `eventos_cadastrados_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventos_cadastrados`
--

LOCK TABLES `eventos_cadastrados` WRITE;
/*!40000 ALTER TABLE `eventos_cadastrados` DISABLE KEYS */;
/*!40000 ALTER TABLE `eventos_cadastrados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id_usuarios` int NOT NULL AUTO_INCREMENT,
  `nome_completo` varchar(100) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `telefone` varchar(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(100) DEFAULT NULL,
  `nome_usuario` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_usuarios`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Giovana Ramos de Oliveira','2008-06-05','54731060800','12997913721','giovana.r.oliveira@gmail.com','123456','Giov'),(2,'Clara de Cássia Vieira','2009-05-23','49207448890','12991501130','claracvr23@gmail.com','2530','Clarinha'),(3,'Giovana Mendonça Raimundo','2009-02-10','56378966720','12988716705','gigimr10@gmail.com','ablabla','gigi.mends'),(4,'Anna Clara Benitez Erberelli','2008-11-20','49203930833','12996201108','abenitezerberelli@gmail.com','123321','Aninha'),(5,'João Lucas de Almeida Rocha Silva','2009-05-01','48563347780','12981140719','joaolucasars@gmail.com','kkj012','Jounis'),(6,'Kaiky Bryan Martins','2007-09-07','5677844699','12981270516','kaiky.bryan@gmail.com','kaiky123','Kaiky');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-27 14:26:26
