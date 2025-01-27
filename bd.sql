-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-01-2025 a las 13:39:49
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
-- Estructura de tabla para la tabla `digimones`
--

CREATE TABLE `digimones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `imagenV` varchar(255) NOT NULL,
  `imagenD` varchar(255) NOT NULL,
  `ataque` int(11) NOT NULL,
  `defensa` int(11) NOT NULL,
  `nivel` int(11) NOT NULL DEFAULT 1,
  `evo_id` int(11) NOT NULL,
  `tipo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `digimones`
--

INSERT INTO `digimones` (`id`, `nombre`, `imagen`, `imagenV`, `imagenD`, `ataque`, `defensa`, `nivel`, `evo_id`, `tipo`) VALUES
(1, 'sdfr', '8f39df25cd2944ed11be02c3e98ee7a1.jpg', '', '', 1, 1, 1, 1, 'vacuna'),
(7, '1asf', '428627950_3596220243932349_1074481071812024296_n.jpg', '', '', 1, 1, 1, 1, 'planta'),
(8, 'sav', '711a7693e211a4452e41120a17dc293c.jpg', '', '', 0, 1, 1, 1, 'vacuna'),
(9, 'fbdsv', 'bb193d3c2af2d12905197222b95e635d.jpg', '428627950_3596220243932349_1074481071812024296_n.jpg', '8a31fdd1b57afb650105e1f7fca17415.jpg', 1, 1, 1, 1, 'planta');

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE `equipo` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `digimon_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `partidas_ganadas` int(11) NOT NULL DEFAULT 0,
  `partidas_perdidas` int(11) NOT NULL DEFAULT 0,
  `partidas_totales` int(11) NOT NULL DEFAULT 0,
  `permisos` tinyint(1) NOT NULL DEFAULT 0,
  `contrasenya` varchar(255) NOT NULL,
  `digi_evu` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `imagen`, `partidas_ganadas`, `partidas_perdidas`, `partidas_totales`, `permisos`, `contrasenya`, `digi_evu`) VALUES
(1, 'admin', NULL, 0, 0, 0, 1, '$2y$10$dIBvy.QseqFNzP7GErgSF.P7coKdx/onIiO4QNiiLnbwYyPMxOUFm', 0),
(2, 'ana', NULL, 0, 0, 0, 0, '$2y$10$w4HeBV2bvsRvlRG7Om0vweL6UZvGRtfjw0NAT0b2M/Hfu45HSvWge', 0),
(3, 'luis', 'default.png', 0, 0, 0, 0, 'luis', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `digimones`
--
ALTER TABLE `digimones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `digi_tipo` (`tipo`),
  ADD KEY `evo_id` (`evo_id`);

--
-- Indices de la tabla `digimones_inv`
--
ALTER TABLE `digimones_inv`
  ADD PRIMARY KEY (`id`),
  ADD KEY `digi_usuario` (`usuario_id`),
  ADD KEY `digi_digimon` (`digimon_id`);

--
-- Indices de la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipo_usuario` (`usuario_id`),
  ADD KEY `equipo_digimon` (`digimon_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `digimones`
--
ALTER TABLE `digimones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `digimones_inv`
--
ALTER TABLE `digimones_inv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `equipo`
--
ALTER TABLE `equipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `digimones`
--
ALTER TABLE `digimones`
  ADD CONSTRAINT `evolucion` FOREIGN KEY (`evo_id`) REFERENCES `digimones` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `digimones_inv`
--
ALTER TABLE `digimones_inv`
  ADD CONSTRAINT `digi_digimon` FOREIGN KEY (`digimon_id`) REFERENCES `digimones` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `digi_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD CONSTRAINT `equipo_digimon` FOREIGN KEY (`digimon_id`) REFERENCES `digimones_inv` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `equipo_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
