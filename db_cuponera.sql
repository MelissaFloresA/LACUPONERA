-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-03-2025 a las 20:05:44
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_cuponera`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `CanjearCupon` (IN `CodigoCupon` VARCHAR(50), IN `DuiCliente` VARCHAR(10), OUT `MensajeSalida` VARCHAR(255))   BEGIN
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
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canje_cupones`
--

CREATE TABLE `canje_cupones` (
  `ID_Canje` int(11) NOT NULL,
  `ID_Cupon` int(11) NOT NULL,
  `ID_Cliente` int(11) NOT NULL,
  `Fecha_Canje` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `ID_Cliente` int(11) NOT NULL,
  `Nombre` varchar(200) NOT NULL,
  `Apellido` varchar(200) NOT NULL,
  `Dui` varchar(10) NOT NULL,
  `Telefono` varchar(20) NOT NULL,
  `Direccion` varchar(255) NOT NULL,
  `Correo` varchar(255) NOT NULL,
  `Contrasena` varchar(255) NOT NULL,
  `Token` varchar(255) NOT NULL,
  `Estado` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`ID_Cliente`, `Nombre`, `Apellido`, `Dui`, `Telefono`, `Direccion`, `Correo`, `Contrasena`, `Token`, `Estado`) VALUES
(58, 'Pedro Mariano', 'Lopez Sanchez', '345000022', '89563212', 'ewrfwerwer323', 'pedro@gmail.com', '26gfdg', 'GN2QEVUFJA', b'1'),
(59, 'Marta Rubia', 'Portillo Sosa', '010265697', '78945266', 'soyapango', 'marta_r@gmail.com', '123', 'LKIDYRFMQX', b'0'),
(78, 'pablo', 'Galdamez', '511163698', '12345678', 'ewrfwerwer323', 'Pablogald@gmail.com', '000', 'ESJPOH6982', b'0'),
(80, 'wendy', 'Aguilar', '345000000', '75787087', 'ewrfwerwer323', 'marcelavax@gmail.com', '123', 'IV5TQ146GU', b'0'),
(83, 'Melissa', 'Flores', '066895942', '79173308', 'Soyapango', 'melissa.abi.flores@gmail.com', '123', 'BJIOKRVC92', b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comision_venta`
--

CREATE TABLE `comision_venta` (
  `ID_Comision` int(11) NOT NULL,
  `ID_Venta` int(11) NOT NULL,
  `Monto_Comision` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cupones`
--

CREATE TABLE `cupones` (
  `ID_Cupon` int(11) NOT NULL,
  `ID_Empresa` varchar(6) NOT NULL,
  `Codigo_Cupon` varchar(50) NOT NULL,
  `Titulo` varchar(255) NOT NULL,
  `Imagen` mediumtext NOT NULL,
  `PrecioR` decimal(10,2) NOT NULL,
  `PrecioO` decimal(10,2) NOT NULL,
  `Fecha_Inicial` date NOT NULL,
  `Fecha_Final` date NOT NULL,
  `Fecha_Limite` date NOT NULL,
  `Descripcion` text NOT NULL,
  `Stock` int(11) NOT NULL,
  `Cantidad_Vendidos` int(11) DEFAULT 0,
  `Estado_Aprobacion` varchar(20) DEFAULT 'En espera',
  `Estado_Cupon` varchar(20) NOT NULL DEFAULT 'Disponible',
  `Justificacion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cupones`
--

INSERT INTO `cupones` (`ID_Cupon`, `ID_Empresa`, `Codigo_Cupon`, `Titulo`, `Imagen`, `PrecioR`, `PrecioO`, `Fecha_Inicial`, `Fecha_Final`, `Fecha_Limite`, `Descripcion`, `Stock`, `Cantidad_Vendidos`, `Estado_Aprobacion`, `Estado_Cupon`, `Justificacion`) VALUES
(1, 'MCD001', 'MCD0010131577', 'McMenú BigMac + Cajita Feliz', 'https://1000marcas.net/wp-content/uploads/2019/11/McDonalds-logo.png', 16.00, 9.49, '2025-03-01', '2025-12-31', '2025-12-31', 'Aplica unicamente en McMenú Big Mac y Cajita Feliz de Queso Hamburguesa', 100000, 0, 'Activa', 'Disponible', NULL),
(2, 'GAL001', 'GAL0016339349', '¡Paga $13 en Lugar de $26.25 por 1 Hora de Boliche para 5 Personas + Alquiler de 5 Pares de Zapatos!', 'https://cuponclub.net/img/wide_big_thumb/Deal/23712.d537c7c4c6b8a129994a4a7d05eb0d7d.jpg', 26.25, 13.00, '2025-02-01', '2025-05-01', '2025-05-01', '1 hora completa de diversión para 5 personas en donde disfrutarás en el ambiente sano, entretenido y lleno de emoción que Galaxy Bowling ofrece desde hace 21 años.No aplica los días sábados.', 200, 0, 'Activa', 'Disponible', NULL),
(3, 'DON001', 'DON0017532567', 'Estadía de 1 Noche para 2 Personas en Hostal Donde Polo', 'https://cuponclub.net/img/wide_big_thumb/Deal/23698.09bee3679ae24864714504e91fa1e0a9.jpg', 60.00, 30.00, '2025-02-08', '2025-07-01', '2025-07-01', 'Donde Polo ofrece servicios de hotelería y turismo a lugares emblemáticos de Suchitoto.Las reservaciones para los días viernes y fines de semana tienen un costo adicional de $15, e incluyen desayunos. \\r\\nCheck In a las 2:00 pm. Check Out a las 11:00 am.  ', 200, 0, 'Activa', 'Disponible', NULL),
(4, 'LAR001', 'LAR0012051549', 'Parrillada para 5 personas 40%OFF', 'https://cuponclub.net/img/wide_big_thumb/Deal/23681.8f7cb31646578f07abf017caf937598a.jpg', 70.00, 42.00, '2025-03-01', '2025-07-01', '2025-07-01', ' 10 Oz de puyazo, 10 Oz lomito de aguja, 12 Oz de Spam Ribs, butifarras, quesos y tomates asados, panes con mantequilla y papas fritas. Chimichurri para complementar¡Una opción completa y deliciosa!', 100, 0, 'Activa', 'Disponible', NULL),
(5, 'POS001', 'POS0016432919', 'Estadía de 1 noche para 4 personas en Miramundo', 'https://s3-pagapoco-files-dev.s3.us-east-2.amazonaws.com/profile-images/pagapoco_user_oferta11210posi1.jpeg', 65.00, 27.00, '2025-03-01', '2025-07-01', '2025-07-01', 'Alojamiento hasta para 4 personas en habitación doble,2 entradas de exquisita sopa típica de gallina india y caminata con guía turística al área ecológica del Hotel La Posada del Cielo.', 10, 0, 'Activa', 'Disponible', NULL),
(6, 'PAI001', 'PAI0016009948', 'Juega Paintball con tus amigos y familia', 'https://cuponclub.net/img/wide_big_thumb/Deal/23685.9f5add98bcb2de0445b8599f996041dd.jpg', 90.00, 35.00, '2025-03-01', '2025-07-01', '2025-07-01', 'Juego de 6 personas.Incluye 750 paintballs,6 marcadoras Tippmann TMC de alto rendimiento además de 6 máscaras y 6 chalecos protectores para garantizar seguridad y comodidad en cada enfrentamiento.', 20, 0, 'Activa', 'Disponible', NULL);

--
-- Disparadores `cupones`
--
DELIMITER $$
CREATE TRIGGER `TR_ActualizarEstadoCupon` AFTER UPDATE ON `cupones` FOR EACH ROW BEGIN
    IF NEW.Stock = 0 AND NEW.Fecha_Final < CURDATE() THEN
        UPDATE CUPONES
        SET Estado_Aprobacion = 'Oferta descartada'
        WHERE ID_Cupon = NEW.ID_Cupon;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_GenerarCodigoCupon` BEFORE INSERT ON `cupones` FOR EACH ROW BEGIN
    DECLARE codigo_base VARCHAR(6);
    DECLARE codigo_cupon VARCHAR(50);
    
    SET codigo_base = NEW.ID_Empresa;
    SET codigo_cupon = CONCAT(codigo_base, LPAD(FLOOR(RAND() * 10000000), 7, '0'));
    
    SET NEW.Codigo_Cupon = codigo_cupon;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `ID_Empleado` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Apellido` varchar(100) NOT NULL,
  `Correo` varchar(255) NOT NULL,
  `Contraseña` varchar(255) NOT NULL,
  `ID_Rol` int(11) NOT NULL,
  `Estado` bit(1) DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `ID_Empresa` varchar(6) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Direccion` varchar(255) NOT NULL,
  `Nombre_Contacto` varchar(255) NOT NULL,
  `Telefono` varchar(15) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `ID_Rubro` int(11) NOT NULL,
  `Porcentaje_Comision` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`ID_Empresa`, `Nombre`, `Direccion`, `Nombre_Contacto`, `Telefono`, `Correo`, `ID_Rubro`, `Porcentaje_Comision`) VALUES
('DON001', 'Donde Polo Hostal', '2 avenida sur casa 7, Barrio San José  Suchitoto, a una cuadra abajo del restaurante.', 'Lara Díaz', ' 7568-9446', 'polo.hostal@gmail.com', 3, 10.00),
('GAL001', 'Galaxy Bowling', '75 Av. Norte y Paseo General Escalón, en las Fuentes Beethoven.', 'Mario González', ' 7568-9447 ', 'galaxy.bowling@gmail.com', 2, 10.00),
('LAR001', 'La Rueda Steakhouse', 'Plaza Presidente, Nivel 3: Final Av. La Revolución, San Salvador 11', 'Estela Flores', '7933-6333', 'steakhouse.estela@gmail.com', 1, 10.00),
('MCD001', 'Mcdonald\'s El Salvador', 'Centro Comercial Espiritu Santo, Soyapango, El Salvador', 'José Enriquez', '2509-9999', 'servicio.mcd01@mcd.com.sv', 1, 20.00),
('PAI001', 'Paintball Navarra', 'Parque Balboa, Los Planes de Renderos, San Salvador, El Salvador.', 'César Romero', '7213-6555', 'paintballsv@gmail.com', 2, 10.00),
('POS001', 'Posada El Cielo', 'Calle principal de Miramundo, 9 kms. después de San Ignacio, calle hacia El Pital', 'Julio Morejón', '2274-2233', 'posadaelcielo@gmail.com', 3, 10.00);

--
-- Disparadores `empresa`
--
DELIMITER $$
CREATE TRIGGER `trg_GenerarID_Empresa` BEFORE INSERT ON `empresa` FOR EACH ROW BEGIN
    DECLARE prefijo CHAR(3);
    DECLARE numero INT;
    DECLARE codigo CHAR(6);
    
    SET prefijo = UPPER(LEFT(NEW.Nombre, 3));
    SELECT IFNULL(MAX(CAST(SUBSTRING(ID_Empresa, 4, 3) AS UNSIGNED)), 0) + 1 INTO numero
    FROM EMPRESA WHERE LEFT(ID_Empresa, 3) = prefijo;
    
    SET codigo = CONCAT(prefijo, LPAD(numero, 3, '0'));
    SET NEW.ID_Empresa = codigo;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `representantes`
--

CREATE TABLE `representantes` (
  `ID_Representante` int(11) NOT NULL,
  `ID_Empresa` varchar(6) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Apellido` varchar(100) NOT NULL,
  `Correo` varchar(255) NOT NULL,
  `Contraseña` varchar(255) NOT NULL,
  `Estado` bit(1) DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `ID_Rol` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rubros`
--

CREATE TABLE `rubros` (
  `ID_Rubro` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rubros`
--

INSERT INTO `rubros` (`ID_Rubro`, `Nombre`) VALUES
(1, 'Restaurantes'),
(2, 'Entretenimiento'),
(3, 'Turismo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `ID_Venta` int(11) NOT NULL,
  `ID_Cupon` int(11) NOT NULL,
  `ID_Cliente` int(11) NOT NULL,
  `Fecha_Compra` datetime DEFAULT current_timestamp(),
  `Cantidad` int(11) NOT NULL,
  `Monto` decimal(10,2) NOT NULL,
  `Metodo_Pago` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `ventas`
--
DELIMITER $$
CREATE TRIGGER `trg_ActualizarStock` AFTER INSERT ON `ventas` FOR EACH ROW BEGIN
    UPDATE CUPONES
    SET Stock = Stock - NEW.Cantidad,
        Cantidad_Vendidos = Cantidad_Vendidos + NEW.Cantidad
    WHERE ID_Cupon = NEW.ID_Cupon;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_CalcularComision` AFTER INSERT ON `ventas` FOR EACH ROW BEGIN
    DECLARE comision DECIMAL(10,2);
    SELECT (NEW.Monto * e.Porcentaje_Comision / 100) INTO comision
    FROM CUPONES c
    JOIN EMPRESA e ON c.ID_Empresa = e.ID_Empresa
    WHERE c.ID_Cupon = NEW.ID_Cupon;
    
    INSERT INTO COMISION_VENTA (ID_Venta, Monto_Comision)
    VALUES (NEW.ID_Venta, comision);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_VerificarStock` BEFORE INSERT ON `ventas` FOR EACH ROW BEGIN
    DECLARE stock_actual INT;
    SELECT Stock INTO stock_actual FROM CUPONES WHERE ID_Cupon = NEW.ID_Cupon;
    IF NEW.Cantidad > stock_actual THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No hay suficiente stock para completar la venta.';
    END IF;
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `canje_cupones`
--
ALTER TABLE `canje_cupones`
  ADD PRIMARY KEY (`ID_Canje`),
  ADD KEY `ID_Cupon` (`ID_Cupon`),
  ADD KEY `ID_Cliente` (`ID_Cliente`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`ID_Cliente`),
  ADD UNIQUE KEY `Dui` (`Dui`),
  ADD UNIQUE KEY `Correo` (`Correo`);

--
-- Indices de la tabla `comision_venta`
--
ALTER TABLE `comision_venta`
  ADD PRIMARY KEY (`ID_Comision`),
  ADD KEY `ID_Venta` (`ID_Venta`);

--
-- Indices de la tabla `cupones`
--
ALTER TABLE `cupones`
  ADD PRIMARY KEY (`ID_Cupon`),
  ADD UNIQUE KEY `Codigo_Cupon` (`Codigo_Cupon`),
  ADD KEY `ID_Empresa` (`ID_Empresa`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`ID_Empleado`),
  ADD UNIQUE KEY `Correo` (`Correo`),
  ADD KEY `ID_Rol` (`ID_Rol`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`ID_Empresa`),
  ADD KEY `ID_Rubro` (`ID_Rubro`);

--
-- Indices de la tabla `representantes`
--
ALTER TABLE `representantes`
  ADD PRIMARY KEY (`ID_Representante`),
  ADD UNIQUE KEY `Correo` (`Correo`),
  ADD KEY `ID_Empresa` (`ID_Empresa`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`ID_Rol`);

--
-- Indices de la tabla `rubros`
--
ALTER TABLE `rubros`
  ADD PRIMARY KEY (`ID_Rubro`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`ID_Venta`),
  ADD KEY `ID_Cupon` (`ID_Cupon`),
  ADD KEY `ID_Cliente` (`ID_Cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `canje_cupones`
--
ALTER TABLE `canje_cupones`
  MODIFY `ID_Canje` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `ID_Cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT de la tabla `comision_venta`
--
ALTER TABLE `comision_venta`
  MODIFY `ID_Comision` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cupones`
--
ALTER TABLE `cupones`
  MODIFY `ID_Cupon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `ID_Empleado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `representantes`
--
ALTER TABLE `representantes`
  MODIFY `ID_Representante` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `ID_Rol` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rubros`
--
ALTER TABLE `rubros`
  MODIFY `ID_Rubro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `ID_Venta` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `canje_cupones`
--
ALTER TABLE `canje_cupones`
  ADD CONSTRAINT `canje_cupones_ibfk_1` FOREIGN KEY (`ID_Cupon`) REFERENCES `cupones` (`ID_Cupon`),
  ADD CONSTRAINT `canje_cupones_ibfk_2` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`);

--
-- Filtros para la tabla `comision_venta`
--
ALTER TABLE `comision_venta`
  ADD CONSTRAINT `comision_venta_ibfk_1` FOREIGN KEY (`ID_Venta`) REFERENCES `ventas` (`ID_Venta`);

--
-- Filtros para la tabla `cupones`
--
ALTER TABLE `cupones`
  ADD CONSTRAINT `cupones_ibfk_1` FOREIGN KEY (`ID_Empresa`) REFERENCES `empresa` (`ID_Empresa`);

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`ID_Rol`) REFERENCES `roles` (`ID_Rol`);

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `empresa_ibfk_1` FOREIGN KEY (`ID_Rubro`) REFERENCES `rubros` (`ID_Rubro`);

--
-- Filtros para la tabla `representantes`
--
ALTER TABLE `representantes`
  ADD CONSTRAINT `representantes_ibfk_1` FOREIGN KEY (`ID_Empresa`) REFERENCES `empresa` (`ID_Empresa`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`ID_Cupon`) REFERENCES `cupones` (`ID_Cupon`),
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
