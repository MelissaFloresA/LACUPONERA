CREATE DATABASE  IF NOT EXISTS `db_cuponera` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `db_cuponera`;
-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: db_cuponera
-- ------------------------------------------------------
-- Server version	5.7.31

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
-- Table structure for table `canje_cupones`
--

DROP TABLE IF EXISTS `canje_cupones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `canje_cupones` (
  `ID_Canje` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Cupon` int(11) NOT NULL,
  `ID_Cliente` int(11) NOT NULL,
  `Fecha_Canje` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID_Canje`),
  KEY `ID_Cupon` (`ID_Cupon`),
  KEY `ID_Cliente` (`ID_Cliente`),
  CONSTRAINT `canje_cupones_ibfk_1` FOREIGN KEY (`ID_Cupon`) REFERENCES `cupones` (`ID_Cupon`),
  CONSTRAINT `canje_cupones_ibfk_2` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `canje_cupones`
--

LOCK TABLES `canje_cupones` WRITE;
/*!40000 ALTER TABLE `canje_cupones` DISABLE KEYS */;
/*!40000 ALTER TABLE `canje_cupones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente` (
  `ID_Cliente` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(200) NOT NULL,
  `Apellido` varchar(200) NOT NULL,
  `Dui` varchar(10) NOT NULL,
  `Telefono` varchar(20) NOT NULL,
  `Direccion` varchar(255) NOT NULL,
  `Correo` varchar(255) NOT NULL,
  `Contrasena` varchar(255) NOT NULL,
  `Token` varchar(255) NOT NULL,
  `Estado` int(11) DEFAULT '0',
  PRIMARY KEY (`ID_Cliente`),
  UNIQUE KEY `Dui` (`Dui`),
  UNIQUE KEY `Correo` (`Correo`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (58,'Pedro Mariano','Lopez Sanchez','345000022','89563212','ewrfwerwer323','pedro@gmail.com','26gfdg','GN2QEVUFJA',0),(59,'Marta Rubia','Portillo Sosa','010265697','78945266','soyapango','marta_r@gmail.com','123','LKIDYRFMQX',0),(78,'pablo','Galdamez','511163698','12345678','ewrfwerwer323','Pablogald@gmail.com','000','ESJPOH6982',0),(80,'wendy','Aguilar','345000000','75787087','ewrfwerwer323','marcelavax@gmail.com','123','IV5TQ146GU',0),(83,'Melissa','Flores','066895942','79173308','Soyapango','melissa.abi.flores@gmail.com','123','BJIOKRVC92',0),(88,'Gabriela','Barrera','12345678-9','12345678','Mejicanos, calle neriu','gabmendez4869@gmail.com','1234','B34Y7FZT81',0),(90,'Veronica','Mazariego','24412366-6','7690-1760','Ciudad Delgado','cat4869bare@gmail.com','8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92','FA7SJP6LY0',0);
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comision_venta`
--

DROP TABLE IF EXISTS `comision_venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comision_venta` (
  `ID_Comision` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Venta` int(11) NOT NULL,
  `Monto_Comision` decimal(10,2) NOT NULL,
  PRIMARY KEY (`ID_Comision`),
  KEY `ID_Venta` (`ID_Venta`),
  CONSTRAINT `comision_venta_ibfk_1` FOREIGN KEY (`ID_Venta`) REFERENCES `ventas` (`ID_Venta`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comision_venta`
--

LOCK TABLES `comision_venta` WRITE;
/*!40000 ALTER TABLE `comision_venta` DISABLE KEYS */;
INSERT INTO `comision_venta` VALUES (1,1,3.80);
/*!40000 ALTER TABLE `comision_venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cupones`
--

DROP TABLE IF EXISTS `cupones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cupones` (
  `ID_Cupon` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Empresa` varchar(6) NOT NULL,
  `Titulo` varchar(255) NOT NULL,
  `Imagen` mediumtext NOT NULL,
  `PrecioR` decimal(10,2) NOT NULL,
  `PrecioO` decimal(10,2) NOT NULL,
  `Fecha_Inicial` date NOT NULL,
  `Fecha_Final` date NOT NULL,
  `Fecha_Limite` date NOT NULL,
  `Descripcion` text NOT NULL,
  `Stock` int(11) NOT NULL,
  `Cantidad_Vendidos` int(11) DEFAULT '0',
  `Estado_Aprobacion` varchar(20) DEFAULT 'En espera',
  `Estado_Cupon` varchar(20) NOT NULL DEFAULT 'Disponible',
  `Justificacion` text,
  PRIMARY KEY (`ID_Cupon`),
  KEY `ID_Empresa` (`ID_Empresa`),
  CONSTRAINT `cupones_ibfk_1` FOREIGN KEY (`ID_Empresa`) REFERENCES `empresa` (`ID_Empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cupones`
--

LOCK TABLES `cupones` WRITE;
/*!40000 ALTER TABLE `cupones` DISABLE KEYS */;
INSERT INTO `cupones` VALUES (1,'MCD001','McMenú BigMac + Cajita Feliz','https://enlamira.com.sv/wp-content/uploads/2023/06/20230627_175849-01-1024x576.jpeg',16.00,9.49,'2025-03-01','2025-12-31','2025-12-31','Aplica unicamente en McMenú Big Mac y Cajita Feliz de Queso Hamburguesa',197,3,'Activa','Disponible',NULL),(2,'GAL001','¡Paga $13 en Lugar de $26.25 por 1 Hora de Boliche para 5 Personas!','https://blog.marti.mx/wp-content/uploads/2024/04/pistas_boliche_header-1024x681.webp',26.25,13.00,'2025-02-01','2025-05-01','2025-05-01','1 hora completa de diversión para 5 personas en donde disfrutarás en el ambiente sano, entretenido y lleno de emoción que Galaxy Bowling ofrece desde hace 21 años.No aplica los días sábados.',199,1,'Activa','Disponible',NULL),(3,'DON001','Estadía de 1 Noche para 2 Personas en Hostal Donde Polo','https://cuponclub.net/img/wide_big_thumb/Deal/23698.09bee3679ae24864714504e91fa1e0a9.jpg',60.00,30.00,'2025-02-08','2025-07-01','2025-07-01','Donde Polo ofrece servicios de hotelería y turismo a lugares emblemáticos de Suchitoto.Las reservaciones para los días viernes y fines de semana tienen un costo adicional de $15, e incluyen desayunos.',200,0,'Activa','Disponible',NULL),(4,'LAR001','Parrillada para 5 personas 40%OFF','https://cuponclub.net/img/wide_big_thumb/Deal/23681.8f7cb31646578f07abf017caf937598a.jpg',70.00,42.00,'2025-03-01','2025-07-01','2025-07-01',' 10 Oz de puyazo, 10 Oz lomito de aguja, 12 Oz de Spam Ribs, butifarras, quesos y tomates asados, panes con mantequilla y papas fritas. Chimichurri para complementar¡Una opción completa y deliciosa!',100,0,'Activa','Disponible',NULL),(5,'POS001','Estadía de 1 noche para 4 personas en Miramundo','https://s3-pagapoco-files-dev.s3.us-east-2.amazonaws.com/profile-images/pagapoco_user_oferta11210posi1.jpeg',65.00,27.00,'2025-03-01','2025-07-01','2025-07-01','Alojamiento hasta para 4 personas en habitación doble,2 entradas de exquisita sopa típica de gallina india y caminata con guía turística al área ecológica del Hotel La Posada del Cielo.',10,0,'Activa','Disponible',NULL),(6,'PAI001','Juega Paintball con tus amigos y familia','https://offloadmedia.feverup.com/valenciasecreta.com/wp-content/uploads/2023/07/13122215/paintball-valencia-1024x683.jpg',90.00,35.00,'2025-03-01','2025-07-01','2025-07-01','Juego de 6 personas.Incluye 750 paintballs,6 marcadoras Tippmann TMC de alto rendimiento además de 6 máscaras y 6 chalecos protectores para garantizar seguridad y comodidad en cada enfrentamiento.',20,0,'Activa','Disponible',NULL);
/*!40000 ALTER TABLE `cupones` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `TR_ActualizarEstadoCupon` AFTER UPDATE ON `cupones` FOR EACH ROW BEGIN
    IF NEW.Stock = 0 AND NEW.Fecha_Final < CURDATE() THEN
        UPDATE CUPONES
        SET Estado_Aprobacion = 'Oferta descartada'
        WHERE ID_Cupon = NEW.ID_Cupon;
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `empleados`
--

DROP TABLE IF EXISTS `empleados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empleados` (
  `ID_Empleado` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `Apellido` varchar(100) NOT NULL,
  `Correo` varchar(255) NOT NULL,
  `Contraseña` varchar(255) NOT NULL,
  `ID_Rol` int(11) NOT NULL,
  `Estado` bit(1) DEFAULT b'1',
  PRIMARY KEY (`ID_Empleado`),
  UNIQUE KEY `Correo` (`Correo`),
  KEY `ID_Rol` (`ID_Rol`),
  CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`ID_Rol`) REFERENCES `roles` (`ID_Rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleados`
--

LOCK TABLES `empleados` WRITE;
/*!40000 ALTER TABLE `empleados` DISABLE KEYS */;
/*!40000 ALTER TABLE `empleados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empresa` (
  `ID_Empresa` varchar(6) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Direccion` varchar(255) NOT NULL,
  `Nombre_Contacto` varchar(255) NOT NULL,
  `Telefono` varchar(15) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `ID_Rubro` int(11) NOT NULL,
  `Porcentaje_Comision` decimal(5,2) NOT NULL,
  PRIMARY KEY (`ID_Empresa`),
  KEY `ID_Rubro` (`ID_Rubro`),
  CONSTRAINT `empresa_ibfk_1` FOREIGN KEY (`ID_Rubro`) REFERENCES `rubros` (`ID_Rubro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` VALUES ('DON001','Donde Polo Hostal','2 avenida sur casa 7, Barrio San José  Suchitoto, a una cuadra abajo del restaurante.','Lara Díaz',' 7568-9446','polo.hostal@gmail.com',3,10.00),('GAL001','Galaxy Bowling','75 Av. Norte y Paseo General Escalón, en las Fuentes Beethoven.','Mario González',' 7568-9447 ','galaxy.bowling@gmail.com',2,10.00),('LAR001','La Rueda Steakhouse','Plaza Presidente, Nivel 3: Final Av. La Revolución, San Salvador 11','Estela Flores','7933-6333','steakhouse.estela@gmail.com',1,10.00),('MCD001','Mcdonald\'s El Salvador','Centro Comercial Espiritu Santo, Soyapango, El Salvador','José Enriquez','2509-9999','servicio.mcd01@mcd.com.sv',1,20.00),('PAI001','Paintball Navarra','Parque Balboa, Los Planes de Renderos, San Salvador, El Salvador.','César Romero','7213-6555','paintballsv@gmail.com',2,10.00),('POS001','Posada El Cielo','Calle principal de Miramundo, 9 kms. después de San Ignacio, calle hacia El Pital','Julio Morejón','2274-2233','posadaelcielo@gmail.com',3,10.00);
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_GenerarID_Empresa` BEFORE INSERT ON `empresa` FOR EACH ROW BEGIN
    DECLARE prefijo CHAR(3);
    DECLARE numero INT;
    DECLARE codigo CHAR(6);
    
    SET prefijo = UPPER(LEFT(NEW.Nombre, 3));
    SELECT IFNULL(MAX(CAST(SUBSTRING(ID_Empresa, 4, 3) AS UNSIGNED)), 0) + 1 INTO numero
    FROM EMPRESA WHERE LEFT(ID_Empresa, 3) = prefijo;
    
    SET codigo = CONCAT(prefijo, LPAD(numero, 3, '0'));
    SET NEW.ID_Empresa = codigo;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `representantes`
--

DROP TABLE IF EXISTS `representantes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `representantes` (
  `ID_Representante` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Empresa` varchar(6) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Apellido` varchar(100) NOT NULL,
  `Correo` varchar(255) NOT NULL,
  `Contraseña` varchar(255) NOT NULL,
  `Estado` bit(1) DEFAULT b'1',
  PRIMARY KEY (`ID_Representante`),
  UNIQUE KEY `Correo` (`Correo`),
  KEY `ID_Empresa` (`ID_Empresa`),
  CONSTRAINT `representantes_ibfk_1` FOREIGN KEY (`ID_Empresa`) REFERENCES `empresa` (`ID_Empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `representantes`
--

LOCK TABLES `representantes` WRITE;
/*!40000 ALTER TABLE `representantes` DISABLE KEYS */;
/*!40000 ALTER TABLE `representantes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `ID_Rol` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`ID_Rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rubros`
--

DROP TABLE IF EXISTS `rubros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rubros` (
  `ID_Rubro` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`ID_Rubro`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rubros`
--

LOCK TABLES `rubros` WRITE;
/*!40000 ALTER TABLE `rubros` DISABLE KEYS */;
INSERT INTO `rubros` VALUES (1,'Restaurantes'),(2,'Entretenimiento'),(3,'Turismo');
/*!40000 ALTER TABLE `rubros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ventas`
--

DROP TABLE IF EXISTS `ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ventas` (
  `ID_Venta` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Cupon` int(11) NOT NULL,
  `ID_Cliente` int(11) NOT NULL,
  `Fecha_Compra` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Cantidad` int(11) NOT NULL,
  `Veces_Canje` int(1) NOT NULL DEFAULT '0',
  `Monto` decimal(10,2) NOT NULL,
  `Metodo_Pago` varchar(50) NOT NULL,
  `Estado` int(1) NOT NULL,
  `Codigo_Cupon` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_Venta`),
  KEY `ID_Cupon` (`ID_Cupon`),
  KEY `ID_Cliente` (`ID_Cliente`),
  CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`ID_Cupon`) REFERENCES `cupones` (`ID_Cupon`),
  CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ventas`
--

LOCK TABLES `ventas` WRITE;
/*!40000 ALTER TABLE `ventas` DISABLE KEYS */;
INSERT INTO `ventas` VALUES (1,1,88,'2025-04-04 00:49:10',2,0,18.98,'Tarjeta de Credito',1,'MCD0015300590'),(2,2,88,'2025-04-03 23:03:13',1,0,13.00,'',0,'GAL0014532908'),(3,1,90,'2025-04-04 00:39:44',1,0,9.49,'',0,'MCD0018114870');
/*!40000 ALTER TABLE `ventas` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_GenerarCodigoCupon` BEFORE INSERT ON `ventas` FOR EACH ROW BEGIN
    DECLARE codigo_base VARCHAR(6);
    DECLARE codigo_cupon VARCHAR(50);
    
    SET codigo_base = (SELECT ID_Empresa FROM cupones WHERE ID_Cupon = NEW.ID_Cupon);
    SET codigo_cupon = CONCAT(codigo_base, LPAD(FLOOR(RAND() * 10000000), 7, '0'));
    
    SET NEW.Codigo_Cupon = codigo_cupon;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_VerificarStock` BEFORE INSERT ON `ventas` FOR EACH ROW BEGIN
    DECLARE stock_actual INT;
    SELECT Stock INTO stock_actual FROM CUPONES WHERE ID_Cupon = NEW.ID_Cupon;
    IF NEW.Cantidad > stock_actual THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No hay suficiente stock para completar la venta.';
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_ActualizarStockInsert` AFTER INSERT ON `ventas` FOR EACH ROW BEGIN
    UPDATE CUPONES
    SET Stock = Stock - NEW.Cantidad,
        Cantidad_Vendidos = Cantidad_Vendidos + NEW.Cantidad
    WHERE ID_Cupon = NEW.ID_Cupon;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_ActualizarStockUpdate` AFTER UPDATE ON `ventas` FOR EACH ROW BEGIN
	DECLARE diferencia INT;
    SET diferencia = NEW.Cantidad - OLD.Cantidad;
	IF diferencia <> 0 THEN
    	UPDATE CUPONES
    	SET Stock = Stock - diferencia,
            Cantidad_Vendidos = Cantidad_Vendidos + diferencia
    	WHERE ID_Cupon = NEW.ID_Cupon;
	END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_CalcularComision` AFTER UPDATE ON `ventas` FOR EACH ROW BEGIN
    DECLARE comision DECIMAL(10,2);
    SELECT (NEW.Monto * e.Porcentaje_Comision / 100) INTO comision
    FROM CUPONES c
    JOIN EMPRESA e ON c.ID_Empresa = e.ID_Empresa
    WHERE c.ID_Cupon = NEW.ID_Cupon;
    
    IF NEW.Estado = 1 THEN
    INSERT INTO COMISION_VENTA (ID_Venta, Monto_Comision)
    VALUES (NEW.ID_Venta, comision);
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_ActualizarStockDelete` AFTER DELETE ON `ventas` FOR EACH ROW BEGIN
    UPDATE CUPONES
    SET Stock = Stock + OLD.Cantidad,
        Cantidad_Vendidos = Cantidad_Vendidos - OLD.Cantidad
    WHERE ID_Cupon = OLD.ID_Cupon;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Dumping events for database 'db_cuponera'
--

--
-- Dumping routines for database 'db_cuponera'
--
/*!50003 DROP PROCEDURE IF EXISTS `CanjearCupon` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `CanjearCupon`(IN `CodigoCupon` VARCHAR(50), IN `DuiCliente` VARCHAR(10), OUT `MensajeSalida` VARCHAR(255))
BEGIN
    DECLARE id_cupon INT;
    DECLARE id_cliente INT;
    
    -- Buscar IDs del cupón y del cliente
    SELECT CU.ID_Cupon, C.ID_Cliente INTO id_cupon, id_cliente
    FROM VENTAS V
    JOIN CLIENTE C ON V.ID_Cliente = C.ID_Cliente
    JOIN CUPONES CU ON V.ID_Cupon = CU.ID_Cupon
    WHERE CU.Codigo_Cupon = CodigoCupon 
    AND C.Dui = DuiCliente
    AND CU.Estado_Cupon = 'Disponible';
    
    -- Si se encontró el cupón y está disponible, se canjea
    IF id_cupon IS NOT NULL THEN
        -- Marcar el cupón como canjeado
        UPDATE CUPONES 
        SET Estado_Cupon = 'Canjeado' 
        WHERE ID_Cupon = id_cupon;
        
        -- Registrar el canje con fecha y hora exacta
        INSERT INTO CANJE_CUPONES (ID_Cupon, ID_Cliente) 
        VALUES (id_cupon, id_cliente);
        
        SET MensajeSalida = 'Cupón canjeado exitosamente';
    ELSE
        SET MensajeSalida = 'Error: Cupón no válido o ya canjeado';
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-04  0:43:47
