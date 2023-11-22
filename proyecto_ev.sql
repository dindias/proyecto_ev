-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-11-2023 a las 22:47:14
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
-- Base de datos: `proyecto_ev`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coches`
--

CREATE TABLE `coches` (
  `CarID` bigint(20) UNSIGNED NOT NULL,
  `UserID` bigint(20) UNSIGNED NOT NULL,
  `Marca` varchar(50) NOT NULL,
  `Modelo` varchar(50) NOT NULL,
  `Ano` year(4) NOT NULL,
  `Matricula` char(7) NOT NULL,
  `Potencia` int(11) NOT NULL,
  `Autonomia` int(11) NOT NULL,
  `Kilometraje` int(11) NOT NULL,
  `Motorizacion` varchar(20) NOT NULL,
  `Contaminacion` int(11) NOT NULL,
  `Precio` int(11) NOT NULL,
  `Tipo` varchar(50) DEFAULT NULL,
  `ubicacion` varchar(30) NOT NULL,
  `Descripcion` varchar(255) DEFAULT NULL,
  `Exterior` text NOT NULL,
  `Interior` text NOT NULL,
  `Seguridad` text NOT NULL,
  `Tecnologia` text NOT NULL,
  `fecha_adicion` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `coches`
--

INSERT INTO `coches` (`CarID`, `UserID`, `Marca`, `Modelo`, `Ano`, `Matricula`, `Potencia`, `Autonomia`, `Kilometraje`, `Motorizacion`, `Contaminacion`, `Precio`, `Tipo`, `ubicacion`, `Descripcion`, `Exterior`, `Interior`, `Seguridad`, `Tecnologia`, `fecha_adicion`) VALUES
(82, 1, 'BMW', 'X3', '2023', 'AAA1111', 500, 800, 25000, 'Hibrida', 100, 600, 'Suv', 'Mérida', 'Nuevo', 'Negro', 'Beige', 'Es de hierro coño', 'ABS', '2023-11-16'),
(84, 1, 'Ford', 'Focus', '2022', 'ZZZ1111', 200, 600, 10000, 'Hibrido', 80, 200, 'Compacto', 'Mérida', 'Nuevo', '', '', '', '', '2023-11-22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `FavoritoID` bigint(20) UNSIGNED NOT NULL,
  `CarID` bigint(20) UNSIGNED NOT NULL,
  `UserID` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `favoritos`
--

INSERT INTO `favoritos` (`FavoritoID`, `CarID`, `UserID`) VALUES
(10, 82, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `ImagenID` bigint(20) UNSIGNED NOT NULL,
  `CarID` bigint(20) UNSIGNED NOT NULL,
  `UserID` bigint(20) UNSIGNED NOT NULL,
  `Imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `imagenes`
--

INSERT INTO `imagenes` (`ImagenID`, `CarID`, `UserID`, `Imagen`) VALUES
(10, 82, 1, 'img/bmw-x3.jpg'),
(11, 82, 1, 'img/bmw-x32.jpg'),
(12, 84, 1, 'img/ford-focus.jpg'),
(13, 84, 1, 'img/for-focus2.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `NotificationID` bigint(20) UNSIGNED NOT NULL,
  `ReservaID` int(11) DEFAULT NULL,
  `UserID` bigint(20) UNSIGNED NOT NULL,
  `CarID` bigint(20) UNSIGNED NOT NULL,
  `Message` varchar(255) NOT NULL,
  `IsRead` tinyint(1) NOT NULL DEFAULT 0,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`NotificationID`, `ReservaID`, `UserID`, `CarID`, `Message`, `IsRead`, `CreatedAt`) VALUES
(4, NULL, 1, 82, 'El usuario Daniel (indiasdaniel@gmail.com) ha alquilado tu coche BMW X3 (2023) por un coste de 1800 € entre los días 2023-11-23 - 2023-11-25 a día 2023-11-22 12:46:13. Ha dejado las siguientes Observaciones: ', 1, '2023-11-22 11:46:13'),
(5, NULL, 1, 84, 'El usuario Daniel (indiasdaniel@gmail.com) ha alquilado tu coche Ford Focus (2022) por un coste de 600 € entre los días 2023-11-23 - 2023-11-25 a día 2023-11-22 12:46:23. Ha dejado las siguientes Observaciones: ', 0, '2023-11-22 11:46:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `ReservationID` bigint(20) UNSIGNED NOT NULL,
  `UserID` bigint(20) UNSIGNED NOT NULL,
  `CarID` bigint(20) UNSIGNED NOT NULL,
  `FechaInicio` date NOT NULL,
  `FechaFin` date NOT NULL,
  `Coste` int(11) NOT NULL,
  `Observaciones` varchar(255) DEFAULT NULL,
  `fecha_reserva` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`ReservationID`, `UserID`, `CarID`, `FechaInicio`, `FechaFin`, `Coste`, `Observaciones`, `fecha_reserva`) VALUES
(47, 1, 82, '2023-11-23', '2023-11-25', 1800, '', '2023-11-22 12:46:13'),
(48, 1, 84, '2023-11-23', '2023-11-25', 600, '', '2023-11-22 12:46:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `UserID` bigint(20) UNSIGNED NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `Privilegios` int(11) NOT NULL DEFAULT 0,
  `Nacimiento` date NOT NULL,
  `NumeroCuenta` varchar(255) DEFAULT NULL,
  `Direccion` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`UserID`, `Nombre`, `Apellido`, `Email`, `email_verified_at`, `Privilegios`, `Nacimiento`, `NumeroCuenta`, `Direccion`, `password`) VALUES
(1, 'Daniel', 'Indias', 'indiasdaniel@gmail.com', NULL, 0, '2000-06-20', NULL, 'inventada', '$2y$10$ZYkCygPKFTpVURqe/Md0I.cAxrShSLvdbexE4T5/smTnftpG0hk0O'),
(2, 'Alvaro', '', 'alvaro@gmail.com', NULL, 0, '2000-06-20', NULL, 'inventada', '$2y$10$W9TQnruj1/MY/R3K.ElXSeYNUFl13.Jnnc9kJsQ/uvN49woJrqFGi'),
(3, 'Pepito', 'Palotes', 'inventada@gmail.com', NULL, 0, '2000-06-20', NULL, 'inventada', '$2y$10$ZsW.wfsK0bhj6UHfaWwn2efEIp5wbnznwkYQc1IlCUt5.rb9E3lOm');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `coches`
--
ALTER TABLE `coches`
  ADD PRIMARY KEY (`CarID`),
  ADD UNIQUE KEY `Matricula` (`Matricula`),
  ADD KEY `fk_usuarios` (`UserID`);

--
-- Indices de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`FavoritoID`),
  ADD KEY `CarID` (`CarID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`ImagenID`),
  ADD KEY `CarID` (`CarID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`NotificationID`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`ReservationID`),
  ADD KEY `fk_coches_reservas` (`CarID`),
  ADD KEY `fk_usuarios_reservas` (`UserID`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `NumeroCuenta` (`NumeroCuenta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `coches`
--
ALTER TABLE `coches`
  MODIFY `CarID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `FavoritoID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `ImagenID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `NotificationID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `ReservationID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `UserID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `coches`
--
ALTER TABLE `coches`
  ADD CONSTRAINT `fk_usuarios` FOREIGN KEY (`UserID`) REFERENCES `usuarios` (`UserID`);

--
-- Filtros para la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `favoritos_ibfk_1` FOREIGN KEY (`CarID`) REFERENCES `coches` (`CarID`),
  ADD CONSTRAINT `favoritos_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `usuarios` (`UserID`);

--
-- Filtros para la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD CONSTRAINT `imagenes_ibfk_1` FOREIGN KEY (`CarID`) REFERENCES `coches` (`CarID`),
  ADD CONSTRAINT `imagenes_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `usuarios` (`UserID`);

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `fk_coches_reservas` FOREIGN KEY (`CarID`) REFERENCES `coches` (`CarID`),
  ADD CONSTRAINT `fk_usuarios_reservas` FOREIGN KEY (`UserID`) REFERENCES `usuarios` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
