CREATE DATABASE  IF NOT EXISTS `club_leon` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `club_leon`;
-- MySQL dump 10.13  Distrib 8.0.46, for Win64 (x86_64)
--
-- Host: localhost    Database: club_leon
-- ------------------------------------------------------
-- Server version	8.0.46

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
-- Table structure for table `equipos`
--

DROP TABLE IF EXISTS `equipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipos` (
  `IdEquipo` int NOT NULL AUTO_INCREMENT,
  `NombreDelEncargado` varchar(255) DEFAULT NULL,
  `TelefonoDelEncargado` varchar(255) DEFAULT NULL,
  `Equipo` varchar(255) DEFAULT NULL,
  `Clave` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`IdEquipo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipos`
--

LOCK TABLES `equipos` WRITE;
/*!40000 ALTER TABLE `equipos` DISABLE KEYS */;
INSERT INTO `equipos` VALUES (1,'Jose Garza','8445914902','CUERVOS NEGROS','AMISTOSO'),(2,'JEJE MARUEZ','8446987878','LEON FC','AMISTOSO'),(3,'Jose Garza','8445787656','CHIVAS FC','AMISTOSO'),(4,'JEJE MARUEZ','8445876576','JUAREZ FC','AMISTOSO');
/*!40000 ALTER TABLE `equipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jugadores`
--

DROP TABLE IF EXISTS `jugadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jugadores` (
  `IdJugador` int NOT NULL AUTO_INCREMENT,
  `NombreDeJugador` varchar(255) DEFAULT NULL,
  `ApellidosDeJugador` varchar(255) DEFAULT NULL,
  `Curp` varchar(255) DEFAULT NULL,
  `TelEmergencia` varchar(255) DEFAULT NULL,
  `IdEquipo` int DEFAULT NULL,
  PRIMARY KEY (`IdJugador`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jugadores`
--

LOCK TABLES `jugadores` WRITE;
/*!40000 ALTER TABLE `jugadores` DISABLE KEYS */;
INSERT INTO `jugadores` VALUES (1,'Representante','Del Equipo',NULL,NULL,NULL),(2,'Juan','Eudes','MACJ050411HCLRRSA4','8555262627',1),(3,'Laura Lorena','Cervantes Mendoza','MACJ050411HCLRRSA6','8776766768',2),(4,'Samantha Nathaly','Martinez Cervantes','MACJ050411HSLR2999','8445914905',3),(5,'Samantha Nath','Martinez Cervantes','MACJ050411HSLR27H7','8445914905',4);
/*!40000 ALTER TABLE `jugadores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registro de abono`
--

DROP TABLE IF EXISTS `registro de abono`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registro de abono` (
  `IdAbono` int NOT NULL AUTO_INCREMENT,
  `Usuario_IdUsuario` int DEFAULT NULL,
  `MontoAbonado` int DEFAULT NULL,
  `Parcialidad` int DEFAULT NULL,
  `FechaDeAbono` date DEFAULT NULL,
  PRIMARY KEY (`IdAbono`),
  KEY `Usuario_IdUsuario` (`Usuario_IdUsuario`),
  CONSTRAINT `registro de abono_ibfk_1` FOREIGN KEY (`Usuario_IdUsuario`) REFERENCES `usuario` (`IdUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro de abono`
--

LOCK TABLES `registro de abono` WRITE;
/*!40000 ALTER TABLE `registro de abono` DISABLE KEYS */;
INSERT INTO `registro de abono` VALUES (1,1,375,3,'2026-05-01'),(2,1,500,4,'2026-05-12'),(3,1,250,2,'2026-05-14');
/*!40000 ALTER TABLE `registro de abono` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registro de pagos`
--

DROP TABLE IF EXISTS `registro de pagos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registro de pagos` (
  `IdPago` int NOT NULL AUTO_INCREMENT,
  `Jugadores_IdJugador` int DEFAULT NULL,
  `Monto` int DEFAULT NULL,
  `Concepto` varchar(255) DEFAULT NULL,
  `FechaDePago` date DEFAULT NULL,
  `EstatusDePago` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`IdPago`),
  KEY `Jugadores_IdJugador` (`Jugadores_IdJugador`),
  CONSTRAINT `registro de pagos_ibfk_1` FOREIGN KEY (`Jugadores_IdJugador`) REFERENCES `jugadores` (`IdJugador`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro de pagos`
--

LOCK TABLES `registro de pagos` WRITE;
/*!40000 ALTER TABLE `registro de pagos` DISABLE KEYS */;
INSERT INTO `registro de pagos` VALUES (5,1,1500,'Inscripción de Equipo','2026-04-29','PAGADO'),(6,1,1500,'Inscripción de Equipo','2026-04-29','PAGADO'),(7,1,1500,'Inscripción de Equipo','2026-04-30','PAGADO'),(8,1,1500,'Inscripción de Equipo','2026-04-03','PAGADO'),(9,4,1500,'Inscripción de Equipo','2026-05-14','PAGADO'),(10,2,1500,'Inscripción de Equipo','2026-05-15','PAGADO'),(11,3,1500,'Inscripción de Equipo','2026-05-14','PAGADO'),(12,3,1500,'Inscripción de Equipo','2026-05-14','PAGADO'),(13,4,1500,'Inscripción de Equipo','2026-05-14','PAGADO'),(14,3,1500,'Inscripción de Equipo','2026-05-14','PAGADO'),(15,4,1500,'Inscripción de Equipo','2026-05-14','PAGADO');
/*!40000 ALTER TABLE `registro de pagos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol de juego`
--

DROP TABLE IF EXISTS `rol de juego`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rol de juego` (
  `IdRol` int NOT NULL AUTO_INCREMENT,
  `Equipos_IdEquipo` int DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Hora` datetime DEFAULT NULL,
  `Cancha` int DEFAULT NULL,
  `Categoria` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`IdRol`),
  KEY `Equipos_IdEquipo` (`Equipos_IdEquipo`),
  CONSTRAINT `rol de juego_ibfk_1` FOREIGN KEY (`Equipos_IdEquipo`) REFERENCES `equipos` (`IdEquipo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol de juego`
--

LOCK TABLES `rol de juego` WRITE;
/*!40000 ALTER TABLE `rol de juego` DISABLE KEYS */;
/*!40000 ALTER TABLE `rol de juego` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol_juegos`
--

DROP TABLE IF EXISTS `rol_juegos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rol_juegos` (
  `IdPartido` int NOT NULL AUTO_INCREMENT,
  `EquipoLocal_Id` int NOT NULL,
  `EquipoVisitante_Id` int NOT NULL,
  `Fecha` date NOT NULL,
  `Hora` varchar(10) NOT NULL,
  `Cancha` varchar(50) NOT NULL,
  PRIMARY KEY (`IdPartido`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol_juegos`
--

LOCK TABLES `rol_juegos` WRITE;
/*!40000 ALTER TABLE `rol_juegos` DISABLE KEYS */;
INSERT INTO `rol_juegos` VALUES (1,1,2,'2026-05-06','08:10','CANCHA 1'),(3,3,1,'2026-05-12','07:00','CANCHA 2'),(4,4,3,'2026-05-12','07:00','CANCHA 2'),(5,3,1,'2026-05-14','09:00','CANCHA 1');
/*!40000 ALTER TABLE `rol_juegos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `IdRol` int NOT NULL AUTO_INCREMENT,
  `NombreRol` varchar(50) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`IdRol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrador','Gestiona usuarios y sistema'),(2,'Encargado del rol de juego','Equipos, roles, posiciones'),(3,'Encargado de la liga','Pagos, abonos, ingresos');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tabla de posiciones`
--

DROP TABLE IF EXISTS `tabla de posiciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tabla de posiciones` (
  `IdPosicion` int NOT NULL AUTO_INCREMENT,
  `Rol de Juego_Equipos_IdEquipo` int DEFAULT NULL,
  `Rol de Juego_IdRol` int DEFAULT NULL,
  `GolesAFavor` int DEFAULT NULL,
  `GolesEnContra` int DEFAULT NULL,
  `Estatus` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`IdPosicion`),
  KEY `Rol de Juego_IdRol` (`Rol de Juego_IdRol`),
  KEY `Rol de Juego_Equipos_IdEquipo` (`Rol de Juego_Equipos_IdEquipo`),
  CONSTRAINT `tabla de posiciones_ibfk_2` FOREIGN KEY (`Rol de Juego_Equipos_IdEquipo`) REFERENCES `equipos` (`IdEquipo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tabla de posiciones`
--

LOCK TABLES `tabla de posiciones` WRITE;
/*!40000 ALTER TABLE `tabla de posiciones` DISABLE KEYS */;
INSERT INTO `tabla de posiciones` VALUES (2,1,1,3,0,'VICTORIA'),(3,2,1,0,3,'DERROTA'),(4,1,2,1,0,'VICTORIA'),(5,2,2,0,1,'DERROTA');
/*!40000 ALTER TABLE `tabla de posiciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `IdUsuario` int NOT NULL AUTO_INCREMENT,
  `Contraseña` varchar(255) NOT NULL,
  `Correo` varchar(255) NOT NULL,
  PRIMARY KEY (`IdUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'123456','Enctigo01');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `IdUsuario` int NOT NULL AUTO_INCREMENT,
  `NombreCompleto` varchar(100) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Rol_Id` int NOT NULL,
  PRIMARY KEY (`IdUsuario`),
  UNIQUE KEY `Correo` (`Correo`),
  KEY `Rol_Id` (`Rol_Id`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`Rol_Id`) REFERENCES `roles` (`IdRol`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Juan','santiago@gmail.com','$2y$10$DnzBHBLPWgqopChfZ/Nw/.Nj.zshBq35VDnDPoXVpypopo5EGjDGG',1),(2,'Pedro','santiago2@gmail.com','$2y$10$TsQWNlkQFBiIYy7FQi3D3.qWTnfSpD7AGHWG9ogOthh4Cd3xOoFP.',1);
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

-- Dump completed on 2026-05-14  7:15:52
