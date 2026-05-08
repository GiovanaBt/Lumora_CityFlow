create database cityflow;
use cityflow;

-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: cityflow
-- ------------------------------------------------------
-- Server version 8.0.41

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventos_cadastrados`
--

LOCK TABLES `eventos_cadastrados` WRITE;
/*!40000 ALTER TABLE `eventos_cadastrados` DISABLE KEYS */;
INSERT INTO `eventos_cadastrados` VALUES (1,2,'Evento de pintura a óleo ',NULL,NULL,'Que tal viver uma experiência artística única? Participe do nosso Workshop de Pintura a Óleo e mergulhe no mundo das cores, formas e criatividade! ?️✨\r\nDurante o encontro, você será guiado passo a passo por um instrutor que vai ensinar as técnicas clássicas e ajudar você a dar vida à sua própria tela. Não importa se você nunca segurou um pincel ou se já tem experiência — o objetivo é se expressar, relaxar e aproveitar cada pincelada!','Av Eng Davi Monteiro Lino','Jardim Marcondes',3595,'Jacarei',NULL,'Raça Centro de Artes',-23.27146860,-45.95467930,'2027-02-14','2027-02-14','17:00:00','19:00:00',9,'69c6d6ad458ba.jpeg'),(2,1,'Audição para o Grupo Raça',NULL,NULL,'Estamos em busca de novos talentos (maiores de 17 anos) para integrar nossa história! Confira o que preparamos para o dia:\r\nCredenciamento e Triagem: Recepção dos candidatos, numeração e breve conversa sobre trajetória na dança e repertório. Técnica e Repertório: Aula prática com nosso diretor coreográfico para avaliação de absorção técnica e execução de sequência inédita. Improviso e Versatilidade: Teste de musicalidade e adaptação corporal sob diferentes estímulos e ritmos. Postura e Presença: Avaliação do carisma, elegância e disciplina em cena — a verdadeira essência do Grupo Raça.\r\nPrepare o corpo e a alma. Nos vemos no palco!','Av Nove de Julho','Jardim Pereira do Amparo',141,'Jacareí',NULL,'Raça Centro de Artes',-23.30170600,-45.97039130,'2027-01-14','2027-01-14','16:00:00','18:00:00',2,'69c6da0fbf0ee.jpeg'),(3,4,'Aulão de Capoeira',NULL,NULL,'Que tal viver uma experiência de pura ginga e tradição? Participe do nosso Encontro de Capoeira e mergulhe no mundo do ritmo, do movimento e da nossa cultura!\r\nDurante o evento, seremos guiados por mestres que vão ensinar desde os fundamentos da esquiva e do ataque até o toque do berimbau e os cantos da roda. Não importa se você nunca jogou ou se já tem anos de cordel — o objetivo é trocar energia, respeitar o axé e evoluir a cada movimento!','Avenida Siqueira Campos','Centro',1616,'Jacareí',NULL,'Shopping Jacareí',-23.30176610,-45.96199360,'2026-07-25','2026-07-25','21:00:00','00:00:00',5,'69c6dc6bb7725.png'),(4,5,'Festival de skate',NULL,NULL,'Que tal viver a cultura de rua de um jeito único? Cola no nosso evento de skate e mergulhe no mundo das manobras, do asfalto e da pura criatividade sobre rodas! ??\r\nDurante o rolê, a gente vai trocar ideia sobre a base, ajustar aquele pé que tá sobrando e te ajudar a destravar novas manobras, passo a passo. Não importa se você nunca subiu num shape ou se já manda ver no corrimão — o foco aqui é a evolução, a diversão e o estilo próprio!','Rua Barao de Jacarei','Centro',839,'Jacarei',NULL,'Rua Barão',-23.30210970,-45.95969290,'2027-03-06','2027-03-06','14:00:00','16:00:00',5,'69c6ddaf9d894.jpeg');
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
select*from usuarios;
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

-- Dump completed on 2026-04-02  8:25:47
CREATE TABLE favoritos (
    id_favorito INT NOT NULL AUTO_INCREMENT,

    id_usuario INT NOT NULL,
    id_evento INT NOT NULL,

    data_favorito TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id_favorito),

    KEY id_usuario (id_usuario),
    KEY id_evento (id_evento),

    CONSTRAINT favoritos_ibfk_1
    FOREIGN KEY (id_usuario)
    REFERENCES usuarios(id_usuarios)
    ON DELETE CASCADE,

    CONSTRAINT favoritos_ibfk_2
    FOREIGN KEY (id_evento)
    REFERENCES eventos_cadastrados(id_evento)
    ON DELETE CASCADE
);


