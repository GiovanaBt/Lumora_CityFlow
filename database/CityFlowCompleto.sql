-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: cityflow
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'Música'),(2,'Dança'),(3,'Literatura (Leitura, escrita, recitais, poesia)'),(4,'Gastronomia'),(5,'Esportes'),(6,'Cinema'),(7,'Teatro'),(8,'Artes Visuais (Pintura, exposições'),(9,'Educação (aulas, cursos livres'),(10,'Humor / Stand-up'),(11,'Palestras e Congressos'),(12,'Cursos e Workshops'),(13,'Eventos LGBTQIA+'),(14,'Religião e Espiritualidade'),(15,'Eventos Infantis');
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
  `descricao` varchar(200) DEFAULT NULL,
  `rua` varchar(200) DEFAULT NULL,
  `bairro` varchar(200) DEFAULT NULL,
  `numero` int DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `ponto_referencia` text,
  `data_inicio_evento` date DEFAULT NULL,
  `data_fim_evento` date DEFAULT NULL,
  `horario_inicio_evento` time DEFAULT NULL,
  `horario_fim_evento` time DEFAULT NULL,
  `id_categoria` int NOT NULL,
  `Imagem` varchar(255) DEFAULT NULL,
  `longitude` decimal(10,8) DEFAULT NULL,
  `latitude` decimal(11,8) DEFAULT NULL,
  PRIMARY KEY (`id_evento`),
  KEY `id_usuarios` (`id_usuarios`),
  KEY `id_categoria` (`id_categoria`),
  CONSTRAINT `eventos_cadastrados_ibfk_1` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE,
  CONSTRAINT `eventos_cadastrados_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventos_cadastrados`
--

LOCK TABLES `eventos_cadastrados` WRITE;
/*!40000 ALTER TABLE `eventos_cadastrados` DISABLE KEYS */;
INSERT INTO `eventos_cadastrados` VALUES (1,1,'Worksho de Jazz','Adoniram Barbosa','Villa Branca',157,'Jacareí','Casa da Giovana','2026-02-01','2026-02-20','15:40:00','15:40:00',2,'69a0776c99ea0.jpg',NULL,NULL),(2,2,'Adoração de Jovens ','Albert einstein','Conjunto São Benedito',11,'Jacareí','Casa da Baiana','2026-02-01','2026-02-20','20:40:00','20:40:00',14,'69a083b1bad22.jpg',NULL,NULL),(3,1,'Capoeira Para Todos - Aula de capoeira','Albert einstein','Conjunto São Benedito',11,'Jacareí','Casa da Baiana','2026-02-22','2026-02-20','19:10:00','19:10:00',5,'69a08abe8ea7e.webp',NULL,NULL),(4,1,'Evento de Pintura a Óleo Gratuito','Pascacio Calvo','Conjunto São Benedito',113,'Jacareí','Casa da Baiana','2026-03-01','2026-03-06','17:40:00','17:40:00',8,'69a0a116cf660.png',NULL,NULL),(5,1,'Corrida de Caracol - A mais rápida do Vale do Paraíba','Deputado Arnaldo Laurindo','Parque Meia Lua',154,'Jacareí','Ponto final de ônibus','2026-03-05','2026-03-06','18:00:00','06:00:00',5,'69a190789a6bf.jpg',NULL,NULL),(6,1,'Audição para o Grupo Raça','Av. Alberto Byington',' Vila Maria Alta',397,'São Paulo','Raça Centro de Artes','2027-01-14','2027-01-14','09:00:00','14:00:00',2,'69ab00b41a1b3.jpg',NULL,NULL),(7,1,'Audição para o Grupo Raça','Av. Alberto Byington','Vila Maria Alta',397,'São Paulo','Raça Centro de Artes','2027-01-14','2027-01-14','09:00:00','14:00:00',2,'69ab083e49232.jpg',0.00000000,0.00000000),(8,1,'Workshop de Jazz','Adoniram Barbosa','Villa Branca',157,'Jacareí','Casa da Giovana','2026-02-01','2026-02-20','16:20:00','19:00:00',2,'69ab0a65a4270.jpg',0.00000000,0.00000000),(9,1,'Oficina de Massinha','Princesa Anne Marie Oldenbourg','Parque dos Princípes',111,'Jacareí','Family Presentes','2027-03-30','2027-03-30','10:00:00','16:00:00',15,'69ab0d0cb28dd.png',-45.93849240,-23.29964690),(10,1,'Cinema ao Ar Livre ','Adoniram Barbosa','Villa Branca',157,'Jacareí','Casa da Giovana','2027-04-10','2027-04-10','20:00:00','22:00:00',6,'69ab1786a663d.jpeg',0.00000000,0.00000000),(11,1,'Degustação de Pão de Queijo','Rolando Lippi','Jardim São Luiz',32,'Jacareí','Cantinho da Viola','2026-03-14','2026-03-14','14:00:00','14:00:00',4,'69b30d68e1184.jpg',NULL,NULL);
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
  `nome_completo` varchar(200) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(100) DEFAULT NULL,
  `nome_usuario` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_usuarios`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Giovana Ramos de Oliveira','2008-06-05','giovana.r.oliveira@gmail.com','123456','Giov'),(2,'Clara de Cássia Vieira','2009-05-23','claracvr23@gmail.com','2530','Clarinha'),(3,'Giovana Mendonça Raimundo','2009-02-10','gigimr10@gmail.com','ablabla','gigi.mends'),(4,'Anna Clara Benitez Erberelli','2008-11-20','abenitezerberelli','123321','Aninha'),(5,'João Lucas de Almeida Rocha Silva','2009-05-01','joaolucasars@gmail.com','kkj012','Jounis'),(6,'Rafaela Teles Simões de Freitas','2009-03-05','rafaelatsfreitas@gmail.com','ra4307la','Rafa'),(7,'Kaiky Bryan Martins','2007-09-07','kaiky.bryan@gmail.com','kaiky123','Kaiky');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'cityflow'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-13  8:44:51
  