DROP DATABASE IF EXISTS proyecto_ev;
CREATE DATABASE proyecto_ev;
USE proyecto_ev;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-11-2023 a las 17:16:32
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
                          `Año` year(4) NOT NULL,
                          `Matricula` char(7) NOT NULL,
                          `Kilometraje` int(11) NOT NULL,
                          `Descripcion` varchar(255) DEFAULT NULL,
                          `Precio` int(11) NOT NULL,
                          `imagenes` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `coches`
--

INSERT INTO `coches` (`CarID`, `UserID`, `Marca`, `Modelo`, `Año`, `Matricula`, `Kilometraje`, `Descripcion`, `Precio`, `imagenes`) VALUES
                                                                                                                                        (47, 1, 'Ford', 'Focus', '2010', 'BCD2345', 200000, 'Necesita reparaciones menores', 4000, NULL),
                                                                                                                                        (48, 1, 'Chevrolet', 'Cruze', '2011', 'CDE3456', 130000, 'Excelente estado, un solo dueño', 6000, NULL),
                                                                                                                                        (49, 1, 'Honda', 'Accord', '2015', 'DEF4567', 120000, 'Pocos detalles de uso', 10000, NULL),
                                                                                                                                        (50, 1, 'Toyota', 'Corolla', '2018', 'EFG5678', 80000, 'Como nuevo, poco kilometraje', 15000, NULL),
                                                                                                                                        (51, 1, 'Toyota', 'Camry', '2017', 'FGH6789', 110000, 'Perfectas condiciones', 13000, NULL),
                                                                                                                                        (52, 1, 'Nissan', 'Sentra', '2014', 'GHI7890', 100000, 'Pequeños rasguños en pintura', 7500, NULL),
                                                                                                                                        (53, 1, 'Hyundai', 'Elantra', '2019', 'HIJ8901', 50000, NULL, 16000, NULL),
                                                                                                                                        (54, 1, 'Volkswagen', 'Golf', '2013', 'IJK9012', 140000, NULL, 7000, NULL),
                                                                                                                                        (55, 1, 'BMW', 'Series 3', '2020', 'JKL0123', 30000, 'Excelente estado, un solo dueño', 22000, NULL),
                                                                                                                                        (56, 1, 'Audi', 'A4', '2016', 'KLM1234', 90000, 'Pocos detalles de uso', 18000, NULL),
                                                                                                                                        (57, 1, 'Mercedes-Benz', 'C-Class', '2021', 'LMN2345', 10000, 'Como nuevo', 25000, NULL),
                                                                                                                                        (58, 1, 'Ford', 'Mustang', '2019', 'MNO3456', 40000, 'Perfectas condiciones, poco kilometraje', 26000, NULL),
                                                                                                                                        (59, 1, 'Chevrolet', 'Spark', '2017', 'NOP4567', 95000, NULL, 8000, NULL),
                                                                                                                                        (60, 1, 'Renault', 'Duster', '2018', 'OPQ5678', 65000, 'Buen estado, bien cuidado', 9000, NULL),
                                                                                                                                        (61, 1, 'Toyota', 'Yaris', '2023', 'JDH7777', 1, 'Nuevo', 30000, NULL),
                                                                                                                                        (62, 1, 'Ford', 'Focus', '2023', 'KKK7777', 2, '2', 25000, 'img/ford-focus-es-FORD_EXPLORER_3-21x9-2160x925-bb-blue-focus-parked-on-the-street.jpg.renditions.original.jpeg'),
                                                                                                                                        (68, 1, 'Lamborghini', 'Diablo', '2009', 'KYS6969', 2, 'Precioso', 150000, 'img/lamborghini_diablo_gt_1-1-1.jpeg');

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
    (1, 'Daniel', 'Indias', 'indiasdaniel@gmail.com', NULL, 0, '2000-06-20', NULL, 'inventada', '$2y$10$ZYkCygPKFTpVURqe/Md0I.cAxrShSLvdbexE4T5/smTnftpG0hk0O');

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
  ADD KEY `fk_usuarios_reservas` (`UserID`),
  ADD KEY `fk_coches_reservas` (`CarID`);

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
    MODIFY `CarID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
    MODIFY `ReservationID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
    MODIFY `UserID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
