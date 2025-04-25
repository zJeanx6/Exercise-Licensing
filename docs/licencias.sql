
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-04-2025 a las 17:08:03
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
-- Base de datos: `licencias`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_receta`
--

CREATE TABLE `detalle_receta` (
  `id` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL,
  `id_ingrediente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_recetas`
--

CREATE TABLE `detalle_recetas` (
  `id` int(11) NOT NULL,
  `id_receta` int(11) DEFAULT NULL,
  `id_ingrediente` int(11) DEFAULT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `unidad_medida` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `nit` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`nit`, `nombre`, `direccion`, `telefono`, `correo`) VALUES
('900123456-1', 'Comidas Rápidas El Tío', 'Cra 10 #15-20, Bogotá', '3111234567', 'contacto@eltio.com'),
('900765432-0', 'Sazón Colombiano S.A.S', 'Av. 19 #45-99, Cali', '3108881122', 'admin@sazoncol.com'),
('901567234-9', 'Panadería Dulce Hogar', 'Calle 8 #22-10, Medellín', '3005678910', 'dulces@hogar.com'),
('902345678-2', 'La Cocina de Mamá', 'Cra 6 #34-12, Bucaramanga', '3123456789', 'info@cocinamama.com'),
('903456789-3', 'Pizzería El Buen Sabor', 'Calle 13 #9-44, Bogotá', '3204567890', 'pizzas@buenosabor.com'),
('904567890-4', 'Jugos Naturales Yupi', 'Av. Nutrición #99-12, Cali', '3019876543', 'ventas@yupi.com'),
('905678901-5', 'Empanadas del Vallee', NULL, NULL, NULL),
('906789012-6', 'Arepas Don Pedro', 'Calle 5 #7-33, Cúcuta', '3101112233', 'admin@donpedro.com'),
('907890123-7', 'Restaurante Sazón Criollo', 'Av. Gourmet #100-77, Cartagena', '3003334444', 'sazon@criollo.com'),
('908901234-8', 'Delicias Express', 'Cra 40 #28-11, Barranquilla', '3225556666', 'info@deliciasexpress.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id`, `nombre`) VALUES
(1, 'activa'),
(2, 'expirada'),
(11, 'desactivada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredientes`
--

CREATE TABLE `ingredientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `codigo_barras` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ingredientes`
--

INSERT INTO `ingredientes` (`id`, `nombre`, `codigo_barras`) VALUES
(24, 'Cebolla larga', 'INGRE-YNA0024'),
(25, 'Queso', 'INGRE-IDG0025'),
(26, 'Huevos', 'INGRE-JGK0026'),
(27, 'Tomate', 'INGRE-BEF0027'),
(28, 'Leche', 'INGRE-GZJ0028'),
(29, 'Masamorra', 'AOQEUQWOHD1'),
(30, 'Huevos pericos', 'INGRE-CWB0030'),
(31, 'Masapan', 'INGRE-ZIY0031'),
(32, 'Migajas', 'as'),
(33, 'tomatico', 'aadsdasdasd'),
(34, 'tomatote', 'INGRE-PVF0034'),
(36, 'ajitomate', 'INGRE-YXW0036'),
(37, 'Cargador', 'KP135010082030120FP103'),
(38, 'Corrector', '7703336004959'),
(39, 'Celular de Aranda', '864469068846700'),
(40, 'MovilRed Scanner', '1107192821'),
(41, 'Portátil Jean', '922610128222');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `licencias`
--

CREATE TABLE `licencias` (
  `licencia` varchar(255) NOT NULL,
  `nit_empresa` varchar(20) DEFAULT NULL,
  `fecha_compra` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `id_estado` int(11) DEFAULT NULL,
  `id_tipo_licencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `licencias`
--

INSERT INTO `licencias` (`licencia`, `nit_empresa`, `fecha_compra`, `fecha_fin`, `id_estado`, `id_tipo_licencia`) VALUES
('2E37-42DE-D44E-44A9-9242', '900123456-1', '2025-04-24', '2025-05-25', 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas`
--

CREATE TABLE `recetas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `instrucciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recetas`
--

INSERT INTO `recetas` (`id`, `nombre`, `instrucciones`) VALUES
(1, 'Queso melado', 'nadita');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'superadmin'),
(2, 'admin'),
(3, 'empleado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_licencias`
--

CREATE TABLE `tipos_licencias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `duracion` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_licencias`
--

INSERT INTO `tipos_licencias` (`id`, `nombre`, `duracion`, `precio`) VALUES
(1, 'Demo', 3, 0.00),
(2, 'Mensual', 30, 15000.00),
(3, 'Trimestral', 90, 40000.00),
(4, 'Semestral', 180, 70000.00),
(5, 'Anual', 365, 120000.00),
(8, 'Permanente', 0, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `cedula` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `nit_empresa` varchar(20) DEFAULT NULL,
  `contraseña` varchar(500) NOT NULL,
  `rol_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`cedula`, `nombre`, `correo`, `nit_empresa`, `contraseña`, `rol_id`) VALUES
('1095300640', 'stiven', 'stiven@gmail.com', '900123456-1', '$2y$10$I4FlDsNlHNaBneKuG.db/uPn1KvNeNh2GCDaU1OcFwSzbZ.9RyfaS', 2),
('1095305', 'admin Jean', 'admin@gmail.com', NULL, '$2y$10$nxXfY5VzPYsuRimEi2rvNO2.b9JpxEiqFd0AjTJ2eoubN36hfDb02', 1),
('111', 'empleado', 'empleado@gmail.com', '900123456-1', '$2y$10$7HkBK2eslb5uAg4Ea9UR9eTI/RdbQjYRMF6kKBKM8D7KFPoQ5CbHm', 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalle_receta`
--
ALTER TABLE `detalle_receta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_receta` (`id_receta`),
  ADD KEY `id_ingrediente` (`id_ingrediente`);

--
-- Indices de la tabla `detalle_recetas`
--
ALTER TABLE `detalle_recetas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_receta` (`id_receta`),
  ADD KEY `id_ingrediente` (`id_ingrediente`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`nit`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_barras` (`codigo_barras`);

--
-- Indices de la tabla `licencias`
--
ALTER TABLE `licencias`
  ADD PRIMARY KEY (`licencia`),
  ADD KEY `id_tipo_licencia` (`id_tipo_licencia`),
  ADD KEY `nit_empresa` (`nit_empresa`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Indices de la tabla `recetas`
--
ALTER TABLE `recetas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos_licencias`
--
ALTER TABLE `tipos_licencias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`cedula`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `nit_empresa` (`nit_empresa`),
  ADD KEY `usuarios_ibfk_3` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalle_receta`
--
ALTER TABLE `detalle_receta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_recetas`
--
ALTER TABLE `detalle_recetas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `recetas`
--
ALTER TABLE `recetas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipos_licencias`
--
ALTER TABLE `tipos_licencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_receta`
--
ALTER TABLE `detalle_receta`
  ADD CONSTRAINT `detalle_receta_ibfk_1` FOREIGN KEY (`id_receta`) REFERENCES `recetas` (`id`),
  ADD CONSTRAINT `detalle_receta_ibfk_2` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingredientes` (`id`);

--
-- Filtros para la tabla `detalle_recetas`
--
ALTER TABLE `detalle_recetas`
  ADD CONSTRAINT `detalle_recetas_ibfk_1` FOREIGN KEY (`id_receta`) REFERENCES `recetas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_recetas_ibfk_2` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingredientes` (`id`);

--
-- Filtros para la tabla `licencias`
--
ALTER TABLE `licencias`
  ADD CONSTRAINT `licencias_ibfk_1` FOREIGN KEY (`id_tipo_licencia`) REFERENCES `tipos_licencias` (`id`),
  ADD CONSTRAINT `licencias_ibfk_2` FOREIGN KEY (`nit_empresa`) REFERENCES `empresas` (`nit`),
  ADD CONSTRAINT `licencias_ibfk_3` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`nit_empresa`) REFERENCES `empresas` (`nit`),
  ADD CONSTRAINT `usuarios_ibfk_3` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
