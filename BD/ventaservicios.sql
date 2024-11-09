-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-11-2024 a las 10:24:37
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ventaservicios`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenido_mensaje_notificacion`
--

CREATE TABLE `contenido_mensaje_notificacion` (
  `Id_Mensaje` int(11) NOT NULL,
  `Contenido` varchar(50) NOT NULL DEFAULT 'El pago de la factura vence en 5 días'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_solicitud`
--

CREATE TABLE `estado_solicitud` (
  `Id_Solicitud` int(11) NOT NULL,
  `ID_Usuario` int(11) DEFAULT NULL,
  `Estado` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_solicitud`
--

INSERT INTO `estado_solicitud` (`Id_Solicitud`, `ID_Usuario`, `Estado`) VALUES
(1, 2, 'aceptado'),
(2, 3, 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `Id_Factura` int(11) NOT NULL,
  `ID_Usuario` int(11) DEFAULT NULL,
  `Razon_de_Factura` varchar(250) NOT NULL,
  `Fecha_limite_de_pago` date NOT NULL,
  `Archivo_Factura` longblob DEFAULT NULL,
  `Estado` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion`
--

CREATE TABLE `notificacion` (
  `Id_Notificacion` int(11) NOT NULL,
  `ID_Usuario` int(11) DEFAULT NULL,
  `Mensaje` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `ID_Usuario` int(11) NOT NULL,
  `Nombre_de_Empresa` varchar(100) NOT NULL,
  `CURP` longblob DEFAULT NULL,
  `RFC` longblob DEFAULT NULL,
  `Acta_Constitutiva` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`ID_Usuario`, `Nombre_de_Empresa`, `CURP`, `RFC`, `Acta_Constitutiva`) VALUES

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID_Usuario` int(11) NOT NULL,
  `Usuario` varchar(50) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellidos` varchar(100) NOT NULL,
  `Correo` varchar(50) NOT NULL,
  `Contraseña` varchar(255) NOT NULL,
  `Tipo_Usuario` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID_Usuario`, `Usuario`, `Nombre`, `Apellidos`, `Correo`, `Contraseña`, `Tipo_Usuario`) VALUES
(1, 'admin', 'Michel', 'Alvarez Gomez', 'michel0810.ma@gmail.com', '$2y$10$EqWdE7VXFxG6aAuSCQFoX.ZG/O8rz22sUF9cYBUshBcTPxzgXaBAi', 'administrador'),
(2, 'geo123', 'Geovanni', 'Hernandes Andres', 'geo.hdez.and@gmail.com', '$2y$10$ZcvzG/YvEhi0z1ac98t6VuYHBKOBOyP.2sjR7K3wRmRwpYn53qNKa', 'cliente'),
(3, 'luisb', 'Luis', 'Navarro', 'luis.diaz.navarro.210@gmail.com', '$2y$10$oa5bJgiDZXe0jIxLj19cHOhKD4MKoWGdLq6GXyT5eN4WUpYvwQ/CW', 'proveedor');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contenido_mensaje_notificacion`
--
ALTER TABLE `contenido_mensaje_notificacion`
  ADD PRIMARY KEY (`Id_Mensaje`);

--
-- Indices de la tabla `estado_solicitud`
--
ALTER TABLE `estado_solicitud`
  ADD PRIMARY KEY (`Id_Solicitud`),
  ADD KEY `ID_Usuario` (`ID_Usuario`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`Id_Factura`),
  ADD KEY `ID_Usuario` (`ID_Usuario`);

--
-- Indices de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD PRIMARY KEY (`Id_Notificacion`),
  ADD KEY `ID_Usuario` (`ID_Usuario`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`ID_Usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID_Usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `estado_solicitud`
--
ALTER TABLE `estado_solicitud`
  MODIFY `Id_Solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `Id_Factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  MODIFY `Id_Notificacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `estado_solicitud`
--
ALTER TABLE `estado_solicitud`
  ADD CONSTRAINT `estado_solicitud_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`);

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `proveedores` (`ID_Usuario`);

--
-- Filtros para la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD CONSTRAINT `notificacion_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`);

--
-- Filtros para la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `proveedores_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;