-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-11-2023 a las 13:03:58
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4
DROP DATABASE proyecto_ev;
CREATE DATABASE proyecto_ev;
USE proyecto_ev;
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
  `Kilometraje` int(11) NOT NULL,
  `Descripcion` varchar(255) DEFAULT NULL,
  `Precio` int(11) NOT NULL,
  `imagenes` varchar(255) DEFAULT NULL,
  `Tipo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `coches`
--

INSERT INTO `coches` (`CarID`, `UserID`, `Marca`, `Modelo`, `Ano`, `Matricula`, `Kilometraje`, `Descripcion`, `Precio`, `imagenes`, `Tipo`) VALUES
(47, 1, 'Ford', 'Focus', '2011', 'BCD2345', 200000, 'Necesita reparaciones menores', 4000, 'img/generic.jpg', ''),
(49, 1, 'Honda', 'Accord', '2011', 'DEF4567', 120000, 'Pocos detalles de uso', 10000, 'img/generic.jpg', ''),
(50, 1, 'Toyota', 'Corolla', '2011', 'EFG5678', 80000, 'Como nuevo, poco kilometraje', 15000, 'img/generic.jpg', ''),
(51, 1, 'Toyota', 'Camry', '2011', 'FGH6789', 110000, 'Perfectas condiciones', 13000, 'img/generic.jpg', ''),
(52, 1, 'Nissan', 'Sentra', '2011', 'GHI7890', 100000, 'Pequeños rasguños en pintura', 7500, 'img/generic.jpg', ''),
(53, 1, 'Hyundai', 'Elantra', '2011', 'HIJ8901', 50000, NULL, 16000, 'img/generic.jpg', ''),
(54, 1, 'Volkswagen', 'Golf', '2011', 'IJK9012', 140000, NULL, 7000, 'img/generic.jpg', ''),
(55, 1, 'BMW', 'Series 3', '2011', 'JKL0123', 30000, 'Excelente estado, un solo dueño', 22000, 'img/generic.jpg', ''),
(56, 1, 'Audi', 'A4', '2011', 'KLM1234', 90000, 'Pocos detalles de uso', 18000, 'img/generic.jpg', ''),
(57, 1, 'Mercedes-Benz', 'C-Class', '2011', 'LMN2345', 10000, 'Como nuevo', 25000, 'img/generic.jpg', ''),
(58, 1, 'Ford', 'Mustang', '2011', 'MNO3456', 40000, 'Perfectas condiciones, poco kilometraje', 26000, 'img/generic.jpg', ''),
(59, 1, 'Chevrolet', 'Spark', '2011', 'NOP4567', 95000, NULL, 8000, 'img/generic.jpg', ''),
(60, 1, 'Renault', 'Duster', '2011', 'OPQ5678', 65000, 'Buen estado, bien cuidado', 9000, 'img/generic.jpg', ''),
(61, 1, 'Toyota', 'Yaris', '2011', 'JDH7777', 1, 'Nuevo', 30000, 'img/generic.jpg', ''),
(62, 1, 'Ford', 'Focus', '2011', 'KKK7777', 2, '2', 25000, 'img/ford-focus-es-FORD_EXPLORER_3-21x9-2160x925-bb-blue-focus-parked-on-the-street.jpg.renditions.original.jpeg', ''),
(68, 1, 'Lamborghini', 'Diablo', '2011', 'KYS6969', 2, 'Precioso', 150000, 'img/lamborghini_diablo_gt_1-1-1.jpeg', ''),
(70, 1, 'BMW', 'M3', '2011', 'LLL9999', 2, 'Nuevo', 70000, 'img/1366_2000.jpeg', ''),
(71, 1, 'Volkswagen', 'Polo', '2011', 'MMM2222', 2, 'Viejo', 5000, 'img/generic.jpg', ''),
(75, 2, 'Citroen', 'Sara', '2000', 'XXX2222', 200000, 'Muy viejo', 2000, 'img/Citroën_Xsara_(Facelift)_–_Frontansicht,_17._März_2011,_Wülfrath.jpg', 'Compacto');

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
  `Observaciones` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`ReservationID`, `UserID`, `CarID`, `FechaInicio`, `FechaFin`, `Observaciones`) VALUES
(5, 2, 68, '2023-11-16', '2023-11-23', ''),
(6, 2, 68, '2023-11-16', '2023-11-23', ''),
(7, 2, 68, '2023-11-16', '2023-11-23', '');

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
(2, 'Alvaro', '', 'alvaro@gmail.com', NULL, 0, '2000-06-20', NULL, 'inventada', '$2y$10$W9TQnruj1/MY/R3K.ElXSeYNUFl13.Jnnc9kJsQ/uvN49woJrqFGi');

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
  MODIFY `CarID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `ReservationID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `UserID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `coches`
--
ALTER TABLE `coches`
  ADD CONSTRAINT `fk_usuarios` FOREIGN KEY (`UserID`) REFERENCES `usuarios` (`UserID`);

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
