-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-02-2025 a las 16:13:03
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
(1, 'Botamon', 'Botamon.png', 'Botamon_v.png', 'Botamon_d.png', 50, 30, 1, 0, 'virus'),
(2, 'Koromon', 'Koromon.png', 'Koromon_v.png', 'Koromon_d.png', 70, 50, 1, 24, 'vacuna'),
(3, 'Agumon', 'Agumon.png', 'Agumon_v.png', 'Agumon_d.png', 120, 100, 2, 0, 'vacuna'),
(4, 'Greymon', 'Greymon.png', 'Greymon_v.png', 'Greymon_d.png', 160, 140, 3, 5, 'vacuna'),
(5, 'MetalGreymon', 'MetalGreymon.png', 'MetalGreymon_v.png', 'MetalGreymon_d.png', 200, 180, 4, 0, 'vacuna'),
(6, 'Tsunomon', 'Tsunomon.png', 'Tsunomon_v.png', 'Tsunomon_d.png', 60, 40, 1, 12, 'vacuna'),
(7, 'Gabumon', 'Gabumon.png', 'Gabumon_v.png', 'Gabumon_d.png', 110, 90, 2, 0, 'vacuna'),
(8, 'Garurumon', 'Garurumon.png', 'Garurumon_v.png', 'Garurumon_d.png', 140, 120, 3, 9, 'vacuna'),
(9, 'WereGarurumon', 'WereGarurumon.png', 'WereGarurumon_v.png', 'WereGarurumon_d.png', 180, 160, 4, 0, 'vacuna'),
(10, 'Poyomon', 'Poyomon.png', 'Poyomon_v.png', 'Poyomon_d.png', 40, 20, 1, 0, 'elemental'),
(11, 'Tokomon', 'Tokomon.png', 'Tokomon_v.png', 'Tokomon_d.png', 60, 40, 1, 0, 'vacuna'),
(12, 'Patamon', 'Patamon.png', 'Patamon_v.png', 'Patamon_d.png', 100, 80, 2, 0, 'vacuna'),
(13, 'Angemon', 'Angemon.png', 'Angemon_v.png', 'Angemon_d.png', 150, 110, 3, 0, 'vacuna'),
(14, 'MagnaAngemon', 'MagnaAngemon.png', 'MagnaAngemon_v.png', 'MagnaAngemon_d.png', 190, 150, 4, 0, 'vacuna'),
(15, 'Nyaromon', 'Nyaromon.png', 'Nyaromon_v.png', 'Nyaromon_d.png', 50, 30, 1, 0, 'vacuna'),
(16, 'Salamon', 'Salamon.png', 'Salamon_v.png', 'Salamon_d.png', 90, 80, 2, 0, 'vacuna'),
(17, 'Gatomon', 'Gatomon.png', 'Gatomon_v.png', 'Gatomon_d.png', 130, 110, 3, 0, 'vacuna'),
(18, 'Nefertimon', 'Nefertimon.png', 'Nefertimon_v.png', 'Nefertimon_d.png', 140, 120, 4, 0, 'vacuna'),
(19, 'Yokomon', 'Yokomon.png', 'Yokomon_v.png', 'Yokomon_d.png', 60, 40, 1, 0, 'planta'),
(20, 'Biyomon', 'Biyomon.png', 'Biyomon_v.png', 'Biyomon_d.png', 90, 80, 2, 0, 'vacuna'),
(21, 'Birdramon', 'Birdramon.png', 'Birdramon_v.png', 'Birdramon_d.png', 140, 100, 3, 0, 'vacuna'),
(22, 'Garudamon', 'Garudamon.png', 'Garudamon_v.png', 'Garudamon_d.png', 170, 130, 4, 0, 'vacuna'),
(23, 'Motimon', 'Motimon.png', 'Motimon_v.png', 'Motimon_d.png', 50, 30, 1, 0, 'virus'),
(24, 'Tentomon', 'Tentomon.png', 'Tentomon_v.png', 'Tentomon_d.png', 120, 110, 2, 0, 'vacuna'),
(25, 'Kabuterimon', 'Kabuterimon.png', 'Kabuterimon_v.png', 'Kabuterimon_d.png', 150, 160, 3, 0, 'vacuna'),
(26, 'MegaKabuterimon', 'MegaKabuterimon.png', 'MegaKabuterimon_v.png', 'MegaKabuterimon_d.png', 180, 200, 4, 0, 'vacuna'),
(27, 'Tanemon', 'Tanemon.png', 'Tanemon_v.png', 'Tanemon_d.png', 40, 20, 1, 0, 'planta'),
(28, 'Palmon', 'Palmon.png', 'Palmon_v.png', 'Palmon_d.png', 100, 90, 2, 29, 'planta'),
(29, 'Togemon', 'Togemon.png', 'Togemon_v.png', 'Togemon_d.png', 130, 140, 3, 30, 'planta'),
(30, 'Lillymon', 'Lillymon.png', 'Lillymon_v.png', 'Lillymon_d.png', 140, 130, 4, 0, 'planta'),
(31, 'Upamon', 'Upamon.png', 'Upamon_v.png', 'Upamon_d.png', 70, 50, 1, 0, 'vacuna');

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
(35, 1, 27, 1),
(36, 1, 15, 1),
(37, 1, 11, 1),
(38, 1, 27, 1),
(39, 1, 11, 1),
(40, 1, 19, 1),
(41, 1, 6, 1),
(42, 1, 2, 1),
(43, 1, 27, 1),
(44, 1, 6, 1),
(45, 1, 31, 1),
(46, 1, 10, 1);

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
(1, 'admin', 'default.png', 0, 0, 0, 1, '$2y$10$dIBvy.QseqFNzP7GErgSF.P7coKdx/onIiO4QNiiLnbwYyPMxOUFm', 0),
(2, 'Ismael', 'bb193d3c2af2d12905197222b95e635d.jpg', 0, 0, 0, 0, '$2y$10$f0REKCje9bcS1D8VI6Xm9.zw3scaUsG3Mx2GIOe6xMBW4No2mCBCu', 0),
(3, 'Alvaro', '6cukfi.jpg', 0, 0, 0, 0, '$2y$10$XLwVIHsjp8emORhcMh9OyOGbZtg.LVnyCf9WAqp6ujAxlw2U669E.', 0),
(4, 'Ana', 'default.png', 0, 0, 0, 1, '$2y$10$wVRpBDbyZ5K6D7LV6t5jS.zEHWfsI7mkY1.aZ5nHt0Y7X6q.AUWsW', 0),
(5, 'Luis', 'default.png', 0, 0, 0, 0, '$2y$10$YfOn83Zk.VWazVL5b6UCCe0EVYC1RbQxkH2NoJPpan3vcoMxtjiGW', 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `digimones_inv`
--
ALTER TABLE `digimones_inv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `digimones_inv`
--
ALTER TABLE `digimones_inv`
  ADD CONSTRAINT `digi_digimon` FOREIGN KEY (`digimon_id`) REFERENCES `digimones` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `digi_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
