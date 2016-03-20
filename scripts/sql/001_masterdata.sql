
--
-- Volcado de datos para la tabla `admin_rol`
--

INSERT INTO `admin_rol` (`id`, `nombre`, `fecha_creacion`, `fecha_edicion`, `estado`) VALUES
(1, 'Administrador', NULL, '2016-03-17 04:58:14', 1);

--
-- Volcado de datos para la tabla `admin_recurso`
--

INSERT INTO `admin_recurso` (`id`, `recurso_id`, `nombre`, `url`, `orden`, `icono`, `fecha_creacion`, `fecha_edicion`, `estado`) VALUES
(3, NULL, 'Seguridad', '', 1, 'fa-dashboard', '2016-03-16 06:13:49', '2016-03-17 23:32:23', 1),
(4, 3, 'Usuarios', 'admin/usuario', 1, 'fa-circle-o', '2016-03-16 06:16:29', '2016-03-17 22:52:16', 1),
(5, 3, 'Recurso', 'admin/recurso', 2, 'fa-circle-o', '2016-03-17 05:00:59', '2016-03-17 22:52:37', 1),
(6, 3, 'Rol', 'admin/rol', 3, 'fa-circle-o', '2016-03-17 05:01:34', '2016-03-17 23:37:24', 1),
(7, 3, 'Permiso', 'admin/permiso', 4, 'fa-circle-o', '2016-03-17 05:02:22', '2016-03-17 22:52:31', 1);

--
-- Volcado de datos para la tabla `admin_permiso`
--

INSERT INTO `admin_permiso` (`id`, `acl`, `rol_id`, `recurso_id`, `fecha_creacion`, `fecha_edicion`) VALUES
(3, '', 1, 3, NULL, NULL),
(4, 'RCUD', 1, 7, NULL, NULL),
(5, 'RCUD', 1, 4, NULL, NULL),
(6, 'RCUD', 1, 6, NULL, NULL),
(7, 'RCUD', 1, 5, NULL, NULL);

--
-- Volcado de datos para la tabla `admin_usuario`
--

INSERT INTO `admin_usuario` (`id`, `rol_id`, `email`, `password`, `estado`, `imagen`, `fecha_creacion`, `fecha_edicion`) VALUES
(1, 1, 'montesinos2005ii@gmail.com', 'ed4db5a235c07a800fb1eb67b5cf5184ea6e73e70d174efd106d98343c3c9716', 1, NULL, '2016-03-14 22:54:53', '2016-03-17 04:59:47'),
(2, 1, 'admin@gmail.com', '11eea3699494ca917927577da24d18cd09288f56384510db54b4b3f21b9659ff', 1, NULL, '2016-03-17 06:45:05', NULL);