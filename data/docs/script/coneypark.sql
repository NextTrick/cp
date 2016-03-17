-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-03-2016 a las 13:14:46
-- Versión del servidor: 5.6.25
-- Versión de PHP: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `coneypark`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_permiso`
--

DROP TABLE IF EXISTS `admin_permiso`;
CREATE TABLE IF NOT EXISTS `admin_permiso` (
  `id` int(11) NOT NULL,
  `acl` varchar(5) DEFAULT NULL,
  `rol_id` int(11) NOT NULL,
  `recurso_id` int(11) NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_edicion` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `admin_permiso`
--

INSERT INTO `admin_permiso` (`id`, `acl`, `rol_id`, `recurso_id`, `fecha_creacion`, `fecha_edicion`) VALUES
(3, '', 1, 3, NULL, NULL),
(4, 'RCUD', 1, 7, NULL, NULL),
(5, 'RCUD', 1, 4, NULL, NULL),
(6, 'RCUD', 1, 6, NULL, NULL),
(7, 'RCUD', 1, 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_recurso`
--

DROP TABLE IF EXISTS `admin_recurso`;
CREATE TABLE IF NOT EXISTS `admin_recurso` (
  `id` int(11) NOT NULL,
  `recurso_id` int(11) DEFAULT NULL,
  `nombre` varchar(60) NOT NULL,
  `url` varchar(120) DEFAULT NULL,
  `nivel` int(11) NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_edicion` datetime DEFAULT NULL,
  `estado` smallint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `admin_recurso`
--

INSERT INTO `admin_recurso` (`id`, `recurso_id`, `nombre`, `url`, `nivel`, `fecha_creacion`, `fecha_edicion`, `estado`) VALUES
(3, NULL, 'Seguridad', '', 1, '2016-03-16 06:13:49', NULL, 1),
(4, 3, 'Usuarios', 'admin/usuario', 2, '2016-03-16 06:16:29', NULL, 1),
(5, 3, 'Recurso', 'admin/recurso', 2, '2016-03-17 05:00:59', NULL, 1),
(6, 3, 'Rol', 'admin/rol', 2, '2016-03-17 05:01:34', NULL, 1),
(7, 3, 'Permiso', 'admin/permiso', 2, '2016-03-17 05:02:22', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_rol`
--

DROP TABLE IF EXISTS `admin_rol`;
CREATE TABLE IF NOT EXISTS `admin_rol` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_edicion` datetime DEFAULT NULL,
  `estado` smallint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `admin_rol`
--

INSERT INTO `admin_rol` (`id`, `nombre`, `fecha_creacion`, `fecha_edicion`, `estado`) VALUES
(1, 'Administrador', NULL, '2016-03-17 04:58:14', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_usuario`
--

DROP TABLE IF EXISTS `admin_usuario`;
CREATE TABLE IF NOT EXISTS `admin_usuario` (
  `id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `imagen` varchar(50) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_edicion` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `admin_usuario`
--

INSERT INTO `admin_usuario` (`id`, `rol_id`, `email`, `password`, `estado`, `imagen`, `fecha_creacion`, `fecha_edicion`) VALUES
(1, 1, 'montesinos2005ii@gmail.com', 'ed4db5a235c07a800fb1eb67b5cf5184ea6e73e70d174efd106d98343c3c9716', 1, NULL, '2016-03-14 22:54:53', '2016-03-17 04:59:47'),
(2, 1, 'admin@gmail.com', '11eea3699494ca917927577da24d18cd09288f56384510db54b4b3f21b9659ff', 1, NULL, '2016-03-17 06:45:05', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_carrito`
--

DROP TABLE IF EXISTS `orden_carrito`;
CREATE TABLE IF NOT EXISTS `orden_carrito` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `comprobante_tipo` tinyint(5) DEFAULT NULL,
  `comprobante_numero` varchar(10) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `pago_referencia` varchar(30) DEFAULT NULL,
  `pago_estado` varchar(1) DEFAULT NULL,
  `pago_tarjeta` varchar(5) DEFAULT NULL,
  `monto_total` float DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_edicion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_detalle_carrito`
--

DROP TABLE IF EXISTS `orden_detalle_carrito`;
CREATE TABLE IF NOT EXISTS `orden_detalle_carrito` (
  `id` int(11) NOT NULL,
  `paquete_id` int(11) NOT NULL,
  `carrito_id` int(11) NOT NULL,
  `tarjeta_id` int(11) NOT NULL,
  `coney_bonos` float DEFAULT NULL,
  `coney_bonus_plus` float DEFAULT NULL,
  `tickets` float DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_edicion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_detalle_orden`
--

DROP TABLE IF EXISTS `orden_detalle_orden`;
CREATE TABLE IF NOT EXISTS `orden_detalle_orden` (
  `id` int(11) NOT NULL,
  `paquete_id` int(11) NOT NULL,
  `orden_id` int(11) NOT NULL,
  `tarjeta_id` int(11) NOT NULL,
  `coney_bonos` float DEFAULT NULL,
  `coney_bonus_plus` float DEFAULT NULL,
  `tickets` float DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_edicion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_orden`
--

DROP TABLE IF EXISTS `orden_orden`;
CREATE TABLE IF NOT EXISTS `orden_orden` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `comprobante_tipo` tinyint(5) DEFAULT NULL,
  `comprobante_numero` varchar(10) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `pago_referencia` varchar(30) DEFAULT NULL,
  `pago_estado` varchar(1) DEFAULT NULL,
  `pago_tarjeta` varchar(5) DEFAULT NULL,
  `monto` float DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_edicion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_request_historial`
--

DROP TABLE IF EXISTS `orden_request_historial`;
CREATE TABLE IF NOT EXISTS `orden_request_historial` (
  `id` int(11) NOT NULL,
  `orden_id` int(11) NOT NULL,
  `request` text,
  `response` text,
  `estado` smallint(1) NOT NULL,
  `tarjeta` varchar(5) DEFAULT NULL,
  `pp_referencia` varchar(30) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_edicion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquete_paquete`
--

DROP TABLE IF EXISTS `paquete_paquete`;
CREATE TABLE IF NOT EXISTS `paquete_paquete` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `coney_bonos` float DEFAULT NULL,
  `coney_bonos_plus` float DEFAULT NULL,
  `tickets` float DEFAULT NULL,
  `monto_total` float NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_edicion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sistema_ubigeo`
--

DROP TABLE IF EXISTS `sistema_ubigeo`;
CREATE TABLE IF NOT EXISTS `sistema_ubigeo` (
  `id` int(11) NOT NULL,
  `cod_pais` varchar(2) NOT NULL,
  `cod_depa` varchar(2) NOT NULL,
  `cod_prov` varchar(2) NOT NULL,
  `cod_dist` varchar(2) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjeta_tarjeta`
--

DROP TABLE IF EXISTS `tarjeta_tarjeta`;
CREATE TABLE IF NOT EXISTS `tarjeta_tarjeta` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `cguid` varchar(40) DEFAULT NULL,
  `numero` varchar(12) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_edicion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_perfil_pago`
--

DROP TABLE IF EXISTS `usuario_perfil_pago`;
CREATE TABLE IF NOT EXISTS `usuario_perfil_pago` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `comprobante` tinyint(1) NOT NULL,
  `ciudadania` tinyint(1) NOT NULL,
  `doc_identidad` varchar(10) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `pais_id` int(11) DEFAULT NULL,
  `distrito_id` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_edicion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_usuario`
--

DROP TABLE IF EXISTS `usuario_usuario`;
CREATE TABLE IF NOT EXISTS `usuario_usuario` (
  `id` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `token` varchar(200) DEFAULT NULL,
  `red` varchar(2) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `imagen` varchar(50) DEFAULT NULL,
  `nombres` varchar(30) NOT NULL,
  `paterno` varchar(30) NOT NULL,
  `materno` varchar(30) NOT NULL,
  `fecha_nac` date DEFAULT NULL,
  `cod_pais` varchar(2) NOT NULL,
  `cod_depa` varchar(2) DEFAULT NULL,
  `cod_prov` varchar(2) DEFAULT NULL,
  `cod_dist` varchar(2) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_edicion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin_permiso`
--
ALTER TABLE `admin_permiso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_admin_permiso_admin_rol1` (`rol_id`),
  ADD KEY `fk_admin_permiso_admin_recurso1` (`recurso_id`);

--
-- Indices de la tabla `admin_recurso`
--
ALTER TABLE `admin_recurso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_admin_recurso_admin_recurso1` (`recurso_id`);

--
-- Indices de la tabla `admin_rol`
--
ALTER TABLE `admin_rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `admin_usuario`
--
ALTER TABLE `admin_usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD KEY `fk_admin_usuario_admin_rol1` (`rol_id`);

--
-- Indices de la tabla `orden_carrito`
--
ALTER TABLE `orden_carrito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orden_carrito_usuario_usuario1` (`usuario_id`);

--
-- Indices de la tabla `orden_detalle_carrito`
--
ALTER TABLE `orden_detalle_carrito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orden_detalle_carrito_paquete_paquete1` (`paquete_id`),
  ADD KEY `fk_orden_detalle_carrito_orden_carrito1` (`carrito_id`),
  ADD KEY `fk_orden_detalle_carrito_tarjeta_tarjeta1` (`tarjeta_id`);

--
-- Indices de la tabla `orden_detalle_orden`
--
ALTER TABLE `orden_detalle_orden`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orden_detalle_orden_paquete_paquete1` (`paquete_id`),
  ADD KEY `fk_orden_detalle_orden_orden_orden1` (`orden_id`),
  ADD KEY `fk_orden_detalle_orden_tarjeta_tarjeta1` (`tarjeta_id`);

--
-- Indices de la tabla `orden_orden`
--
ALTER TABLE `orden_orden`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orden_orden_usuario_usuario1` (`usuario_id`);

--
-- Indices de la tabla `orden_request_historial`
--
ALTER TABLE `orden_request_historial`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paquete_paquete`
--
ALTER TABLE `paquete_paquete`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sistema_ubigeo`
--
ALTER TABLE `sistema_ubigeo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_pais` (`cod_pais`),
  ADD KEY `index_depa` (`cod_depa`),
  ADD KEY `index_prov` (`cod_prov`),
  ADD KEY `index_dist` (`cod_dist`);

--
-- Indices de la tabla `tarjeta_tarjeta`
--
ALTER TABLE `tarjeta_tarjeta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tarjeta_tarjeta_usuario_usuario1` (`usuario_id`);

--
-- Indices de la tabla `usuario_perfil_pago`
--
ALTER TABLE `usuario_perfil_pago`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario_perfil_pago_usuario_usuario1` (`usuario_id`);

--
-- Indices de la tabla `usuario_usuario`
--
ALTER TABLE `usuario_usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin_permiso`
--
ALTER TABLE `admin_permiso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `admin_recurso`
--
ALTER TABLE `admin_recurso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `admin_rol`
--
ALTER TABLE `admin_rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `admin_usuario`
--
ALTER TABLE `admin_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `orden_carrito`
--
ALTER TABLE `orden_carrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `orden_detalle_carrito`
--
ALTER TABLE `orden_detalle_carrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `orden_detalle_orden`
--
ALTER TABLE `orden_detalle_orden`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `orden_orden`
--
ALTER TABLE `orden_orden`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `orden_request_historial`
--
ALTER TABLE `orden_request_historial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `paquete_paquete`
--
ALTER TABLE `paquete_paquete`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `sistema_ubigeo`
--
ALTER TABLE `sistema_ubigeo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tarjeta_tarjeta`
--
ALTER TABLE `tarjeta_tarjeta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuario_perfil_pago`
--
ALTER TABLE `usuario_perfil_pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuario_usuario`
--
ALTER TABLE `usuario_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `admin_permiso`
--
ALTER TABLE `admin_permiso`
  ADD CONSTRAINT `fk_admin_permiso_admin_recurso1` FOREIGN KEY (`recurso_id`) REFERENCES `admin_recurso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_admin_permiso_admin_rol1` FOREIGN KEY (`rol_id`) REFERENCES `admin_rol` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `admin_recurso`
--
ALTER TABLE `admin_recurso`
  ADD CONSTRAINT `fk_admin_recurso_admin_recurso1` FOREIGN KEY (`recurso_id`) REFERENCES `admin_recurso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `admin_usuario`
--
ALTER TABLE `admin_usuario`
  ADD CONSTRAINT `fk_admin_usuario_admin_rol1` FOREIGN KEY (`rol_id`) REFERENCES `admin_rol` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `orden_carrito`
--
ALTER TABLE `orden_carrito`
  ADD CONSTRAINT `fk_orden_carrito_usuario_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario_usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `orden_detalle_carrito`
--
ALTER TABLE `orden_detalle_carrito`
  ADD CONSTRAINT `fk_orden_detalle_carrito_orden_carrito1` FOREIGN KEY (`carrito_id`) REFERENCES `orden_carrito` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_orden_detalle_carrito_paquete_paquete1` FOREIGN KEY (`paquete_id`) REFERENCES `paquete_paquete` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_orden_detalle_carrito_tarjeta_tarjeta1` FOREIGN KEY (`tarjeta_id`) REFERENCES `tarjeta_tarjeta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `orden_detalle_orden`
--
ALTER TABLE `orden_detalle_orden`
  ADD CONSTRAINT `fk_orden_detalle_orden_orden_orden1` FOREIGN KEY (`orden_id`) REFERENCES `orden_orden` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_orden_detalle_orden_paquete_paquete1` FOREIGN KEY (`paquete_id`) REFERENCES `paquete_paquete` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_orden_detalle_orden_tarjeta_tarjeta1` FOREIGN KEY (`tarjeta_id`) REFERENCES `tarjeta_tarjeta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `orden_orden`
--
ALTER TABLE `orden_orden`
  ADD CONSTRAINT `fk_orden_orden_usuario_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario_usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tarjeta_tarjeta`
--
ALTER TABLE `tarjeta_tarjeta`
  ADD CONSTRAINT `fk_tarjeta_tarjeta_usuario_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario_usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_perfil_pago`
--
ALTER TABLE `usuario_perfil_pago`
  ADD CONSTRAINT `fk_usuario_perfil_pago_usuario_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario_usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
