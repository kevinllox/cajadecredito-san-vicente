-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 27-05-2024 a las 03:15:01
-- Versión del servidor: 5.7.31
-- Versión de PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `finiquitoccsv`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitafiniquito`
--

DROP TABLE IF EXISTS `bitafiniquito`;
CREATE TABLE IF NOT EXISTS `bitafiniquito` (
  `IdBitacora` int(11) NOT NULL AUTO_INCREMENT,
  `UserGenerador` char(15) COLLATE utf32_spanish2_ci NOT NULL,
  `FechaGenera` datetime NOT NULL,
  `RefCredito` char(12) COLLATE utf32_spanish2_ci NOT NULL,
  `DUICliente` char(9) COLLATE utf32_spanish2_ci NOT NULL,
  PRIMARY KEY (`IdBitacora`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `finiquito`
--

DROP TABLE IF EXISTS `finiquito`;
CREATE TABLE IF NOT EXISTS `finiquito` (
  `IdFiniquito` int(11) NOT NULL AUTO_INCREMENT,
  `Cliente` char(60) COLLATE utf32_spanish2_ci DEFAULT NULL,
  `DUICliente` char(9) COLLATE utf32_spanish2_ci DEFAULT NULL,
  `RefCredito` char(12) COLLATE utf32_spanish2_ci DEFAULT NULL,
  `MontoRef` int(11) DEFAULT NULL,
  `FechaDesembolso` date DEFAULT NULL,
  `FechaCancelacion` date DEFAULT NULL,
  `CorreoCliente` char(70) COLLATE utf32_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`IdFiniquito`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf32 COLLATE=utf32_spanish2_ci;

--
-- Volcado de datos para la tabla `finiquito`
--

INSERT INTO `finiquito` (`IdFiniquito`, `Cliente`, `DUICliente`, `RefCredito`, `MontoRef`, `FechaDesembolso`, `FechaCancelacion`, `CorreoCliente`) VALUES
(1, 'JOSÉ PÉREZ LÓPEZ', '123456787', '003212345678', 10000, '2023-10-01', '1970-01-01', NULL),
(2, 'MARÍA GÓMEZ GONZÁLEZ', '876543213', '003287654321', 7500, '1970-01-01', '1970-01-01', NULL),
(3, 'CARLOS RAMÍREZ FLORES', '987654327', '003298765432', 5000, '2023-05-08', '1970-01-01', NULL),
(4, 'ANA RIVERA VÁSQUEZ', '123456701', '003212345670', 12000, '1970-01-01', '2024-10-05', NULL),
(5, 'PEDRO CAMPOS MOLINA', '876543298', '003287654329', 8000, '1970-01-01', '1970-01-01', NULL),
(6, 'SOFIA MÉNDEZ HERNÁNDEZ', '987654306', '003298765430', 6000, '2023-01-03', '1970-01-01', NULL),
(7, 'JUAN CASTRO AGUILAR', '123456716', '003212345671', 15000, '2022-04-10', '1970-01-01', NULL),
(8, 'ISABEL MORALES GARCÍA', '876543229', '003287654322', 9000, '2023-12-07', '1970-01-01', NULL),
(9, 'DIEGO SOTOMAYOR FUENTES', '987654312', '003298765431', 7000, '1970-01-01', '2024-01-25', NULL),
(10, 'ANDREA MEJÍA PÉREZ', '123456724', '003212345672', 11000, '1970-01-01', '1970-01-01', NULL),
(11, 'CARLOS RENE MONTANO ARIAS', '024578927', '003201475679', 5600, '1969-12-31', '2024-05-26', 'papitolindo@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `userfini`
--

DROP TABLE IF EXISTS `userfini`;
CREATE TABLE IF NOT EXISTS `userfini` (
  `IdUsuarios` int(11) NOT NULL AUTO_INCREMENT,
  `NombreCompleto` char(50) COLLATE utf32_spanish2_ci NOT NULL,
  `User` char(15) COLLATE utf32_spanish2_ci NOT NULL,
  `Pass` char(10) COLLATE utf32_spanish2_ci NOT NULL,
  PRIMARY KEY (`IdUsuarios`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf32 COLLATE=utf32_spanish2_ci;

--
-- Volcado de datos para la tabla `userfini`
--

INSERT INTO `userfini` (`IdUsuarios`, `NombreCompleto`, `User`, `Pass`) VALUES
(1, 'CARLOS RENE MONTANO ARIAS', 'MONTANO', '12345');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
