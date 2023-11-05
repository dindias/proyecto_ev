DROP DATABASE IF EXISTS proyecto_ev;
CREATE DATABASE proyecto_ev;
USE proyecto_ev;

CREATE TABLE `usuarios` (
                            `UserID` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                            `Nombre` VARCHAR(50) NOT NULL,
                            `Apellido` VARCHAR(50) NOT NULL,
                            `Email` VARCHAR(50) NOT NULL UNIQUE,
                            `email_verified_at` TIMESTAMP NULL,
                            `Privilegios` INT NOT NULL DEFAULT 0,
                            `Nacimiento` DATE NOT NULL,
                            `NumeroCuenta` VARCHAR(255) UNIQUE NULL,
                            `Direccion` VARCHAR(100) NOT NULL,
                            `password` VARCHAR(255) NOT NULL,  /*Añade esta línea*/
                            PRIMARY KEY (`UserID`)
);

CREATE TABLE `coches` (
                          `CarID` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                          `UserID` BIGINT UNSIGNED NOT NULL,
                          `Marca` VARCHAR(50) NOT NULL,
                          `Modelo` VARCHAR(50) NOT NULL,
                          `Año` YEAR NOT NULL,
                          `Matricula` CHAR(7) NOT NULL UNIQUE,
                          `Kilometraje` INT NOT NULL,
                          `Descripcion` VARCHAR(255) NULL,
                          `Precio` INT NOT NULL,
                          PRIMARY KEY (`CarID`),
                          CONSTRAINT `fk_usuarios`
                              FOREIGN KEY (`UserID`)
                                  REFERENCES `usuarios` (`UserID`)
);

CREATE TABLE `reservas` (
                            `ReservationID` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                            `UserID` BIGINT UNSIGNED NOT NULL,
                            `CarID` BIGINT UNSIGNED NOT NULL,
                            `FechaInicio` DATE NOT NULL,
                            `FechaFin` DATE NOT NULL,
                            `Observaciones` VARCHAR(255) NULL,
                            PRIMARY KEY (`ReservationID`),
                            CONSTRAINT `fk_usuarios_reservas`
                                FOREIGN KEY (`UserID`)
                                    REFERENCES `usuarios` (`UserID`),
                            CONSTRAINT `fk_coches_reservas`
                                FOREIGN KEY (`CarID`)
                                    REFERENCES `coches` (`CarID`)
);
