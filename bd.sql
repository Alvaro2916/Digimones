-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-02-2025 a las 22:53:45
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
-- Base de datos: `digi`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `digimones_inv`
--

CREATE TABLE `digimones_inv` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `digimon_id` int(11) NOT NULL,
  `seleccionado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `digimones_inv`
--

INSERT INTO `digimones_inv` (`id`, `usuario_id`, `digimon_id`, `seleccionado`) VALUES
(1, 2, 27, 1),
(2, 2, 15, 1),
(3, 2, 31, 1),
(4, 3, 6, 1),
(5, 3, 1, 1),
(6, 3, 10, 1),
(7, 4, 23, 1),
(8, 4, 15, 1),
(9, 4, 27, 1),
(10, 5, 27, 1),
(11, 5, 19, 1),
(12, 5, 10, 1),
(13, 6, 11, 1),
(14, 6, 15, 1),
(15, 6, 6, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `digimones_inv`
--
ALTER TABLE `digimones_inv`
  ADD PRIMARY KEY (`id`),
  ADD KEY `digi_usuario` (`usuario_id`),
  ADD KEY `digi_digimon` (`digimon_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `digimones_inv`
--
ALTER TABLE `digimones_inv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `digimones_inv`
--
ALTER TABLE `digimones_inv`
  ADD CONSTRAINT `digi_digimon` FOREIGN KEY (`digimon_id`) REFERENCES `digimones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `digi_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
