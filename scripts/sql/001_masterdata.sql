
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
(4, 3, 'Usuarios', 'admin/usuarioadmin', 6, 'fa-circle-o', '2016-03-16 06:16:29', '2016-05-01 08:20:24', 1),
(5, 3, 'Recurso', 'admin/recurso', 2, 'fa-circle-o', '2016-03-17 05:00:59', '2016-03-17 22:52:37', 1),
(6, 3, 'Rol', 'admin/rol', 3, 'fa-circle-o', '2016-03-17 05:01:34', '2016-03-17 23:37:24', 1),
(7, 3, 'Permiso', 'admin/permiso', 4, 'fa-circle-o', '2016-03-17 05:02:22', '2016-03-19 08:15:17', 1),
(8, NULL, 'Promociones', '', 2, 'fa fa-th', '2016-04-11 20:48:28', '2016-04-15 22:17:47', 1),
(9, 8, 'Paquetes', 'admin/paquete', 3, 'fa-circle-o', '2016-04-11 20:49:31', '2016-05-01 07:40:50', 1),
(10, NULL, 'Reportes', '', 3, 'fa fa-table', '2016-04-15 22:18:37', '2016-04-15 22:22:36', 1),
(11, 10, 'Usuarios', 'admin/usuario', 10, 'fa-circle-o', '2016-04-15 22:18:54', '2016-05-01 07:54:29', 1),
(12, 10, 'Transacciones', 'admin/orden', 12, 'fa-circle-o', '2016-04-15 22:19:11', '2016-05-01 08:54:11', 1),
(13, 10, 'Operaciones', 'admin/ordendetalle', 11, 'fa-circle-o', '2016-04-15 22:20:57', '2016-05-01 08:53:40', 1),
(14, NULL, 'CMS', '', 4, 'fa fa-edit', '2016-04-15 22:21:23', '2016-04-15 22:23:08', 1),
(15, 14, 'Contenido', 'admin/contenido', 4, 'fa-circle-o', '2016-04-15 22:21:36', '2016-05-01 07:26:02', 1);

--
-- Volcado de datos para la tabla `admin_permiso`
--

INSERT INTO `admin_permiso` (`id`, `acl`, `rol_id`, `recurso_id`, `fecha_creacion`, `fecha_edicion`) VALUES
(3, '', 1, 3, NULL, NULL),
(4, 'RCUD', 1, 7, NULL, NULL),
(5, 'RCUD', 1, 4, NULL, NULL),
(6, 'RCUD', 1, 6, NULL, NULL),
(7, 'RCUD', 1, 5, NULL, NULL),
(8, '', 1, 8, NULL, NULL),
(9, 'RCUD', 1, 9, NULL, NULL),
(10, '', 1, 10, NULL, NULL),
(12, 'RCUD', 1, 11, NULL, NULL),
(13, 'RCUD', 1, 12, NULL, NULL),
(14, 'RCUD', 1, 13, NULL, NULL),
(15, '', 1, 14, NULL, NULL),
(16, 'RCUD', 1, 15, NULL, NULL);

--
-- Volcado de datos para la tabla `admin_usuario`
--

INSERT INTO `admin_usuario` (`id`, `rol_id`, `email`, `password`, `estado`, `imagen`, `fecha_creacion`, `fecha_edicion`) VALUES
(1, 1, 'montesinos2005ii@gmail.com', 'ed4db5a235c07a800fb1eb67b5cf5184ea6e73e70d174efd106d98343c3c9716', 1, NULL, '2016-03-14 22:54:53', '2016-03-17 04:59:47'),
(2, 1, 'admin@gmail.com', '11eea3699494ca917927577da24d18cd09288f56384510db54b4b3f21b9659ff', 1, NULL, '2016-03-17 06:45:05', NULL);











INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '00', '00', '00', 'PERU');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '00', '00', 'AMAZONAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '01', '00', 'CHACHAPOYAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '01', '01', 'CHACHAPOYAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '01', '02', 'ASUNCION');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '01', '03', 'BALSAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '01', '04', 'CHETO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '01', '05', 'CHILIQUIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '01', '06', 'CHUQUIBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '01', '07', 'GRANADA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '01', '08', 'HUANCAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '01', '09', 'LA JALCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '01', '10', 'LEIMEBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '01', '11', 'LEVANTO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '01', '12', 'MAGDALENA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '01', '13', 'MARISCAL CASTILLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '01', '14', 'MOLINOPAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '01', '15', 'MONTEVIDEO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '01', '16', 'OLLEROS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '01', '17', 'QUINJALCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '01', '18', 'SAN FRANCISCO DE DAGUAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '01', '19', 'SAN ISIDRO DE MAINO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '01', '20', 'SOLOCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '01', '21', 'SONCHE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '02', '00', 'BAGUA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '02', '01', 'BAGUA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '02', '02', 'ARAMANGO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '02', '03', 'COPALLIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '02', '04', 'EL PARCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '02', '05', 'IMAZA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '02', '06', 'LA PECA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '03', '00', 'BONGARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '03', '01', 'JUMBILLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '03', '02', 'CHISQUILLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '03', '03', 'CHURUJA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '03', '04', 'COROSHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '03', '05', 'CUISPES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '03', '06', 'FLORIDA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '03', '07', 'JAZAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '03', '08', 'RECTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '03', '09', 'SAN CARLOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '03', '10', 'SHIPASBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '03', '11', 'VALERA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '03', '12', 'YAMBRASBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '04', '00', 'CONDORCANQUI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '04', '01', 'NIEVA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '04', '02', 'EL CENEPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '04', '03', 'RIO SANTIAGO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '05', '00', 'LUYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '05', '01', 'LAMUD');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '05', '02', 'CAMPORREDONDO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '05', '03', 'COCABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '05', '04', 'COLCAMAR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '05', '05', 'CONILA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '05', '06', 'INGUILPATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '05', '07', 'LONGUITA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '05', '08', 'LONYA CHICO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '05', '09', 'LUYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '05', '10', 'LUYA VIEJO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '05', '11', 'MARIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '05', '12', 'OCALLI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '05', '13', 'OCUMAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '05', '14', 'PISUQUIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '05', '15', 'PROVIDENCIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '05', '16', 'SAN CRISTOBAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '05', '17', 'SAN FRANCISCO DEL YESO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '05', '18', 'SAN JERONIMO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '05', '19', 'SAN JUAN DE LOPECANCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '05', '20', 'SANTA CATALINA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '05', '21', 'SANTO TOMAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '05', '22', 'TINGO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '05', '23', 'TRITA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '06', '00', 'RODRIGUEZ DE MENDOZA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '06', '01', 'SAN NICOLAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '06', '02', 'CHIRIMOTO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '06', '03', 'COCHAMAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '06', '04', 'HUAMBO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '06', '05', 'LIMABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '06', '06', 'LONGAR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '06', '07', 'MARISCAL BENAVIDES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '06', '08', 'MILPUC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '06', '09', 'OMIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '06', '10', 'SANTA ROSA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '06', '11', 'TOTORA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '06', '12', 'VISTA ALEGRE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '07', '00', 'UTCUBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '07', '01', 'BAGUA GRANDE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '07', '02', 'CAJARURO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '07', '03', 'CUMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '07', '04', 'EL MILAGRO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '07', '05', 'JAMALCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '07', '06', 'LONYA GRANDE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '01', '07', '07', 'YAMON');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '00', '00', 'ANCASH');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '01', '00', 'HUARAZ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '01', '01', 'HUARAZ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '01', '02', 'COCHABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '01', '03', 'COLCABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '01', '04', 'HUANCHAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '01', '05', 'INDEPENDENCIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '01', '06', 'JANGAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '01', '07', 'LA LIBERTAD');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '01', '08', 'OLLEROS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '01', '09', 'PAMPAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '01', '10', 'PARIACOTO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '01', '11', 'PIRA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '01', '12', 'TARICA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '02', '00', 'AIJA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '02', '01', 'AIJA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '02', '02', 'CORIS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '02', '03', 'HUACLLAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '02', '04', 'LA MERCED');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '02', '05', 'SUCCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '03', '00', 'ANTONIO RAYMONDI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '03', '01', 'LLAMELLIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '03', '02', 'ACZO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '03', '03', 'CHACCHO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '03', '04', 'CHINGAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '03', '05', 'MIRGAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '03', '06', 'SAN JUAN DE RONTOY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '04', '00', 'ASUNCION');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '04', '01', 'CHACAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '04', '02', 'ACOCHACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '05', '00', 'BOLOGNESI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '05', '01', 'CHIQUIAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '05', '02', 'ABELARDO PARDO LEZAMETA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '05', '03', 'ANTONIO RAYMONDI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '05', '04', 'AQUIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '05', '05', 'CAJACAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '05', '06', 'CANIS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '05', '07', 'COLQUIOC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '05', '08', 'HUALLANCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '05', '09', 'HUASTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '05', '10', 'HUAYLLACAYAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '05', '11', 'LA PRIMAVERA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '05', '12', 'MANGAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '05', '13', 'PACLLON');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '05', '14', 'SAN MIGUEL DE CORPANQUI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '05', '15', 'TICLLOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '06', '00', 'CARHUAZ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '06', '01', 'CARHUAZ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '06', '02', 'ACOPAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '06', '03', 'AMASHCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '06', '04', 'ANTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '06', '05', 'ATAQUERO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '06', '06', 'MARCARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '06', '07', 'PARIAHUANCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '06', '08', 'SAN MIGUEL DE ACO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '06', '09', 'SHILLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '06', '10', 'TINCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '06', '11', 'YUNGAR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '07', '00', 'CARLOS FERMIN FITZCARRALD');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '07', '01', 'SAN LUIS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '07', '02', 'SAN NICOLAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '07', '03', 'YAUYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '08', '00', 'CASMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '08', '01', 'CASMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '08', '02', 'BUENA VISTA ALTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '08', '03', 'COMANDANTE NOEL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '08', '04', 'YAUTAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '09', '00', 'CORONGO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '09', '01', 'CORONGO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '09', '02', 'ACO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '09', '03', 'BAMBAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '09', '04', 'CUSCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '09', '05', 'LA PAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '09', '06', 'YANAC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '09', '07', 'YUPAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '10', '00', 'HUARI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '10', '01', 'HUARI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '10', '02', 'ANRA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '10', '03', 'CAJAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '10', '04', 'CHAVIN DE HUANTAR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '10', '05', 'HUACACHI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '10', '06', 'HUACCHIS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '10', '07', 'HUACHIS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '10', '08', 'HUANTAR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '10', '09', 'MASIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '10', '10', 'PAUCAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '10', '11', 'PONTO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '10', '12', 'RAHUAPAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '10', '13', 'RAPAYAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '10', '14', 'SAN MARCOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '10', '15', 'SAN PEDRO DE CHANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '10', '16', 'UCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '11', '00', 'HUARMEY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '11', '01', 'HUARMEY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '11', '02', 'COCHAPETI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '11', '03', 'CULEBRAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '11', '04', 'HUAYAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '11', '05', 'MALVAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '12', '00', 'HUAYLAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '12', '01', 'CARAZ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '12', '02', 'HUALLANCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '12', '03', 'HUATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '12', '04', 'HUAYLAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '12', '05', 'MATO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '12', '06', 'PAMPAROMAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '12', '07', 'PUEBLO LIBRE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '12', '08', 'SANTA CRUZ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '12', '09', 'SANTO TORIBIO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '12', '10', 'YURACMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '13', '00', 'MARISCAL LUZURIAGA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '13', '01', 'PISCOBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '13', '02', 'CASCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '13', '03', 'ELEAZAR GUZMAN BARRON');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '13', '04', 'FIDEL OLIVAS ESCUDERO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '13', '05', 'LLAMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '13', '06', 'LLUMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '13', '07', 'LUCMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '13', '08', 'MUSGA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '14', '00', 'OCROS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '14', '01', 'OCROS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '14', '02', 'ACAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '14', '03', 'CAJAMARQUILLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '14', '04', 'CARHUAPAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '14', '05', 'COCHAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '14', '06', 'CONGAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '14', '07', 'LLIPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '14', '08', 'SAN CRISTOBAL DE RAJAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '14', '09', 'SAN PEDRO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '14', '10', 'SANTIAGO DE CHILCAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '15', '00', 'PALLASCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '15', '01', 'CABANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '15', '02', 'BOLOGNESI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '15', '03', 'CONCHUCOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '15', '04', 'HUACASCHUQUE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '15', '05', 'HUANDOVAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '15', '06', 'LACABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '15', '07', 'LLAPO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '15', '08', 'PALLASCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '15', '09', 'PAMPAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '15', '10', 'SANTA ROSA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '15', '11', 'TAUCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '16', '00', 'POMABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '16', '01', 'POMABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '16', '02', 'HUAYLLAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '16', '03', 'PAROBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '16', '04', 'QUINUABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '17', '00', 'RECUAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '17', '01', 'RECUAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '17', '02', 'CATAC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '17', '03', 'COTAPARACO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '17', '04', 'HUAYLLAPAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '17', '05', 'LLACLLIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '17', '06', 'MARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '17', '07', 'PAMPAS CHICO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '17', '08', 'PARARIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '17', '09', 'TAPACOCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '17', '10', 'TICAPAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '18', '00', 'SANTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '18', '01', 'CHIMBOTE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '18', '02', 'CACERES DEL PERU');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '18', '03', 'COISHCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '18', '04', 'MACATE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '18', '05', 'MORO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '18', '06', 'NEPEÑA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '18', '07', 'SAMANCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '18', '08', 'SANTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '18', '09', 'NUEVO CHIMBOTE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '19', '00', 'SIHUAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '19', '01', 'SIHUAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '19', '02', 'ACOBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '19', '03', 'ALFONSO UGARTE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '19', '04', 'CASHAPAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '19', '05', 'CHINGALPO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '19', '06', 'HUAYLLABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '19', '07', 'QUICHES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '19', '08', 'RAGASH');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '19', '09', 'SAN JUAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '19', '10', 'SICSIBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '20', '00', 'YUNGAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '20', '01', 'YUNGAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '20', '02', 'CASCAPARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '20', '03', 'MANCOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '20', '04', 'MATACOTO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '20', '05', 'QUILLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '20', '06', 'RANRAHIRCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '20', '07', 'SHUPLUY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '02', '20', '08', 'YANAMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '00', '00', 'APURIMAC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '01', '00', 'ABANCAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '01', '01', 'ABANCAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '01', '02', 'CHACOCHE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '01', '03', 'CIRCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '01', '04', 'CURAHUASI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '01', '05', 'HUANIPACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '01', '06', 'LAMBRAMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '01', '07', 'PICHIRHUA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '01', '08', 'SAN PEDRO DE CACHORA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '01', '09', 'TAMBURCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '02', '00', 'ANDAHUAYLAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '02', '01', 'ANDAHUAYLAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '02', '02', 'ANDARAPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '02', '03', 'CHIARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '02', '04', 'HUANCARAMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '02', '05', 'HUANCARAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '02', '06', 'HUAYANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '02', '07', 'KISHUARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '02', '08', 'PACOBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '02', '09', 'PACUCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '02', '10', 'PAMPACHIRI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '02', '11', 'POMACOCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '02', '12', 'SAN ANTONIO DE CACHI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '02', '13', 'SAN JERONIMO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '02', '14', 'SAN MIGUEL DE CHACCRAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '02', '15', 'SANTA MARIA DE CHICMO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '02', '16', 'TALAVERA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '02', '17', 'TUMAY HUARACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '02', '18', 'TURPO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '02', '19', 'KAQUIABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '03', '00', 'ANTABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '03', '01', 'ANTABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '03', '02', 'EL ORO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '03', '03', 'HUAQUIRCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '03', '04', 'JUAN ESPINOZA MEDRANO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '03', '05', 'OROPESA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '03', '06', 'PACHACONAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '03', '07', 'SABAINO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '04', '00', 'AYMARAES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '04', '01', 'CHALHUANCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '04', '02', 'CAPAYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '04', '03', 'CARAYBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '04', '04', 'CHAPIMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '04', '05', 'COLCABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '04', '06', 'COTARUSE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '04', '07', 'HUAYLLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '04', '08', 'JUSTO APU SAHUARAURA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '04', '09', 'LUCRE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '04', '10', 'POCOHUANCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '04', '11', 'SAN JUAN DE CHACÑA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '04', '12', 'SAÑAYCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '04', '13', 'SORAYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '04', '14', 'TAPAIRIHUA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '04', '15', 'TINTAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '04', '16', 'TORAYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '04', '17', 'YANACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '05', '00', 'COTABAMBAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '05', '01', 'TAMBOBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '05', '02', 'COTABAMBAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '05', '03', 'COYLLURQUI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '05', '04', 'HAQUIRA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '05', '05', 'MARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '05', '06', 'CHALLHUAHUACHO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '06', '00', 'CHINCHEROS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '06', '01', 'CHINCHEROS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '06', '02', 'ANCO_HUALLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '06', '03', 'COCHARCAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '06', '04', 'HUACCANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '06', '05', 'OCOBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '06', '06', 'ONGOY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '06', '07', 'URANMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '06', '08', 'RANRACANCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '07', '00', 'GRAU');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '07', '01', 'CHUQUIBAMBILLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '07', '02', 'CURPAHUASI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '07', '03', 'GAMARRA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '07', '04', 'HUAYLLATI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '07', '05', 'MAMARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '07', '06', 'MICAELA BASTIDAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '07', '07', 'PATAYPAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '07', '08', 'PROGRESO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '07', '09', 'SAN ANTONIO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '07', '10', 'SANTA ROSA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '07', '11', 'TURPAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '07', '12', 'VILCABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '07', '13', 'VIRUNDO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '03', '07', '14', 'CURASCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '00', '00', 'AREQUIPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '00', 'AREQUIPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '01', 'AREQUIPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '02', 'ALTO SELVA ALEGRE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '03', 'CAYMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '04', 'CERRO COLORADO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '05', 'CHARACATO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '06', 'CHIGUATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '07', 'JACOBO HUNTER');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '08', 'LA JOYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '09', 'MARIANO MELGAR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '10', 'MIRAFLORES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '11', 'MOLLEBAYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '12', 'PAUCARPATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '13', 'POCSI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '14', 'POLOBAYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '15', 'QUEQUEÑA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '16', 'SABANDIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '17', 'SACHACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '18', 'SAN JUAN DE SIGUAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '19', 'SAN JUAN DE TARUCANI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '20', 'SANTA ISABEL DE SIGUAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '21', 'SANTA RITA DE SIGUAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '22', 'SOCABAYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '23', 'TIABAYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '24', 'UCHUMAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '25', 'VITOR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '26', 'YANAHUARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '27', 'YARABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '28', 'YURA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '01', '29', 'JOSE LUIS BUSTAMANTE Y RIVERO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '02', '00', 'CAMANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '02', '01', 'CAMANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '02', '02', 'JOSE MARIA QUIMPER');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '02', '03', 'MARIANO NICOLAS VALCARCEL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '02', '04', 'MARISCAL CACERES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '02', '05', 'NICOLAS DE PIEROLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '02', '06', 'OCOÑA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '02', '07', 'QUILCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '02', '08', 'SAMUEL PASTOR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '03', '00', 'CARAVELI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '03', '01', 'CARAVELI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '03', '02', 'ACARI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '03', '03', 'ATICO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '03', '04', 'ATIQUIPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '03', '05', 'BELLA UNION');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '03', '06', 'CAHUACHO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '03', '07', 'CHALA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '03', '08', 'CHAPARRA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '03', '09', 'HUANUHUANU');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '03', '10', 'JAQUI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '03', '11', 'LOMAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '03', '12', 'QUICACHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '03', '13', 'YAUCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '04', '00', 'CASTILLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '04', '01', 'APLAO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '04', '02', 'ANDAGUA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '04', '03', 'AYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '04', '04', 'CHACHAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '04', '05', 'CHILCAYMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '04', '06', 'CHOCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '04', '07', 'HUANCARQUI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '04', '08', 'MACHAGUAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '04', '09', 'ORCOPAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '04', '10', 'PAMPACOLCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '04', '11', 'TIPAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '04', '12', 'UÑON');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '04', '13', 'URACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '04', '14', 'VIRACO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '05', '00', 'CAYLLOMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '05', '01', 'CHIVAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '05', '02', 'ACHOMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '05', '03', 'CABANACONDE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '05', '04', 'CALLALLI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '05', '05', 'CAYLLOMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '05', '06', 'COPORAQUE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '05', '07', 'HUAMBO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '05', '08', 'HUANCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '05', '09', 'ICHUPAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '05', '10', 'LARI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '05', '11', 'LLUTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '05', '12', 'MACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '05', '13', 'MADRIGAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '05', '14', 'SAN ANTONIO DE CHUCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '05', '15', 'SIBAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '05', '16', 'TAPAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '05', '17', 'TISCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '05', '18', 'TUTI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '05', '19', 'YANQUE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '05', '20', 'MAJES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '06', '00', 'CONDESUYOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '06', '01', 'CHUQUIBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '06', '02', 'ANDARAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '06', '03', 'CAYARANI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '06', '04', 'CHICHAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '06', '05', 'IRAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '06', '06', 'RIO GRANDE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '06', '07', 'SALAMANCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '06', '08', 'YANAQUIHUA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '07', '00', 'ISLAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '07', '01', 'MOLLENDO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '07', '02', 'COCACHACRA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '07', '03', 'DEAN VALDIVIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '07', '04', 'ISLAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '07', '05', 'MEJIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '07', '06', 'PUNTA DE BOMBON');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '08', '00', 'LA UNION');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '08', '01', 'COTAHUASI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '08', '02', 'ALCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '08', '03', 'CHARCANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '08', '04', 'HUAYNACOTAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '08', '05', 'PAMPAMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '08', '06', 'PUYCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '08', '07', 'QUECHUALLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '08', '08', 'SAYLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '08', '09', 'TAURIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '08', '10', 'TOMEPAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '04', '08', '11', 'TORO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '00', '00', 'AYACUCHO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '01', '00', 'HUAMANGA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '01', '01', 'AYACUCHO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '01', '02', 'ACOCRO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '01', '03', 'ACOS VINCHOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '01', '04', 'CARMEN ALTO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '01', '05', 'CHIARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '01', '06', 'OCROS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '01', '07', 'PACAYCASA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '01', '08', 'QUINUA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '01', '09', 'SAN JOSE DE TICLLAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '01', '10', 'SAN JUAN BAUTISTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '01', '11', 'SANTIAGO DE PISCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '01', '12', 'SOCOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '01', '13', 'TAMBILLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '01', '14', 'VINCHOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '01', '15', 'JESUS NAZARENO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '02', '00', 'CANGALLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '02', '01', 'CANGALLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '02', '02', 'CHUSCHI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '02', '03', 'LOS MOROCHUCOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '02', '04', 'MARIA PARADO DE BELLIDO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '02', '05', 'PARAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '02', '06', 'TOTOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '03', '00', 'HUANCA SANCOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '03', '01', 'SANCOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '03', '02', 'CARAPO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '03', '03', 'SACSAMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '03', '04', 'SANTIAGO DE LUCANAMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '04', '00', 'HUANTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '04', '01', 'HUANTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '04', '02', 'AYAHUANCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '04', '03', 'HUAMANGUILLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '04', '04', 'IGUAIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '04', '05', 'LURICOCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '04', '06', 'SANTILLANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '04', '07', 'SIVIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '04', '08', 'LLOCHEGUA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '05', '00', 'LA MAR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '05', '01', 'SAN MIGUEL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '05', '02', 'ANCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '05', '03', 'AYNA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '05', '04', 'CHILCAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '05', '05', 'CHUNGUI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '05', '06', 'LUIS CARRANZA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '05', '07', 'SANTA ROSA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '05', '08', 'TAMBO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '05', '09', 'SAMUGARI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '06', '00', 'LUCANAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '06', '01', 'PUQUIO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '06', '02', 'AUCARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '06', '03', 'CABANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '06', '04', 'CARMEN SALCEDO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '06', '05', 'CHAVIÑA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '06', '06', 'CHIPAO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '06', '07', 'HUAC-HUAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '06', '08', 'LARAMATE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '06', '09', 'LEONCIO PRADO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '06', '10', 'LLAUTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '06', '11', 'LUCANAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '06', '12', 'OCAÑA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '06', '13', 'OTOCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '06', '14', 'SAISA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '06', '15', 'SAN CRISTOBAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '06', '16', 'SAN JUAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '06', '17', 'SAN PEDRO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '06', '18', 'SAN PEDRO DE PALCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '06', '19', 'SANCOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '06', '20', 'SANTA ANA DE HUAYCAHUACHO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '06', '21', 'SANTA LUCIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '07', '00', 'PARINACOCHAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '07', '01', 'CORACORA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '07', '02', 'CHUMPI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '07', '03', 'CORONEL CASTAÑEDA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '07', '04', 'PACAPAUSA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '07', '05', 'PULLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '07', '06', 'PUYUSCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '07', '07', 'SAN FRANCISCO DE RAVACAYCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '07', '08', 'UPAHUACHO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '08', '00', 'PAUCAR DEL SARA SARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '08', '01', 'PAUSA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '08', '02', 'COLTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '08', '03', 'CORCULLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '08', '04', 'LAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '08', '05', 'MARCABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '08', '06', 'OYOLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '08', '07', 'PARARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '08', '08', 'SAN JAVIER DE ALPABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '08', '09', 'SAN JOSE DE USHUA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '08', '10', 'SARA SARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '09', '00', 'SUCRE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '09', '01', 'QUEROBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '09', '02', 'BELEN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '09', '03', 'CHALCOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '09', '04', 'CHILCAYOC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '09', '05', 'HUACAÑA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '09', '06', 'MORCOLLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '09', '07', 'PAICO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '09', '08', 'SAN PEDRO DE LARCAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '09', '09', 'SAN SALVADOR DE QUIJE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '09', '10', 'SANTIAGO DE PAUCARAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '09', '11', 'SORAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '10', '00', 'VICTOR FAJARDO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '10', '01', 'HUANCAPI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '10', '02', 'ALCAMENCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '10', '03', 'APONGO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '10', '04', 'ASQUIPATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '10', '05', 'CANARIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '10', '06', 'CAYARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '10', '07', 'COLCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '10', '08', 'HUAMANQUIQUIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '10', '09', 'HUANCARAYLLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '10', '10', 'HUAYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '10', '11', 'SARHUA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '10', '12', 'VILCANCHOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '11', '00', 'VILCAS HUAMAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '11', '01', 'VILCAS HUAMAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '11', '02', 'ACCOMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '11', '03', 'CARHUANCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '11', '04', 'CONCEPCION');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '11', '05', 'HUAMBALPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '11', '06', 'INDEPENDENCIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '11', '07', 'SAURAMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '05', '11', '08', 'VISCHONGO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '00', '00', 'CAJAMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '01', '00', 'CAJAMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '01', '01', 'CAJAMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '01', '02', 'ASUNCION');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '01', '03', 'CHETILLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '01', '04', 'COSPAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '01', '05', 'ENCAÑADA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '01', '06', 'JESUS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '01', '07', 'LLACANORA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '01', '08', 'LOS BAÑOS DEL INCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '01', '09', 'MAGDALENA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '01', '10', 'MATARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '01', '11', 'NAMORA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '01', '12', 'SAN JUAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '02', '00', 'CAJABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '02', '01', 'CAJABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '02', '02', 'CACHACHI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '02', '03', 'CONDEBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '02', '04', 'SITACOCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '03', '00', 'CELENDIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '03', '01', 'CELENDIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '03', '02', 'CHUMUCH');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '03', '03', 'CORTEGANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '03', '04', 'HUASMIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '03', '05', 'JORGE CHAVEZ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '03', '06', 'JOSE GALVEZ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '03', '07', 'MIGUEL IGLESIAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '03', '08', 'OXAMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '03', '09', 'SOROCHUCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '03', '10', 'SUCRE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '03', '11', 'UTCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '03', '12', 'LA LIBERTAD DE PALLAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '04', '00', 'CHOTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '04', '01', 'CHOTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '04', '02', 'ANGUIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '04', '03', 'CHADIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '04', '04', 'CHIGUIRIP');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '04', '05', 'CHIMBAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '04', '06', 'CHOROPAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '04', '07', 'COCHABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '04', '08', 'CONCHAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '04', '09', 'HUAMBOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '04', '10', 'LAJAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '04', '11', 'LLAMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '04', '12', 'MIRACOSTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '04', '13', 'PACCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '04', '14', 'PION');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '04', '15', 'QUEROCOTO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '04', '16', 'SAN JUAN DE LICUPIS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '04', '17', 'TACABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '04', '18', 'TOCMOCHE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '04', '19', 'CHALAMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '05', '00', 'CONTUMAZA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '05', '01', 'CONTUMAZA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '05', '02', 'CHILETE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '05', '03', 'CUPISNIQUE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '05', '04', 'GUZMANGO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '05', '05', 'SAN BENITO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '05', '06', 'SANTA CRUZ DE TOLED');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '05', '07', 'TANTARICA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '05', '08', 'YONAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '06', '00', 'CUTERVO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '06', '01', 'CUTERVO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '06', '02', 'CALLAYUC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '06', '03', 'CHOROS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '06', '04', 'CUJILLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '06', '05', 'LA RAMADA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '06', '06', 'PIMPINGOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '06', '07', 'QUEROCOTILLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '06', '08', 'SAN ANDRES DE CUTERVO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '06', '09', 'SAN JUAN DE CUTERVO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '06', '10', 'SAN LUIS DE LUCMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '06', '11', 'SANTA CRUZ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '06', '12', 'SANTO DOMINGO DE LA CAPILLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '06', '13', 'SANTO TOMAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '06', '14', 'SOCOTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '06', '15', 'TORIBIO CASANOVA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '07', '00', 'HUALGAYOC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '07', '01', 'BAMBAMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '07', '02', 'CHUGUR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '07', '03', 'HUALGAYOC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '08', '00', 'JAEN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '08', '01', 'JAEN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '08', '02', 'BELLAVISTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '08', '03', 'CHONTALI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '08', '04', 'COLASAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '08', '05', 'HUABAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '08', '06', 'LAS PIRIAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '08', '07', 'POMAHUACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '08', '08', 'PUCARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '08', '09', 'SALLIQUE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '08', '10', 'SAN FELIPE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '08', '11', 'SAN JOSE DEL ALTO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '08', '12', 'SANTA ROSA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '09', '00', 'SAN IGNACIO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '09', '01', 'SAN IGNACIO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '09', '02', 'CHIRINOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '09', '03', 'HUARANGO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '09', '04', 'LA COIPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '09', '05', 'NAMBALLE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '09', '06', 'SAN JOSE DE LOURDES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '09', '07', 'TABACONAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '10', '00', 'SAN MARCOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '10', '01', 'PEDRO GALVEZ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '10', '02', 'CHANCAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '10', '03', 'EDUARDO VILLANUEVA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '10', '04', 'GREGORIO PITA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '10', '05', 'ICHOCAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '10', '06', 'JOSE MANUEL QUIROZ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '10', '07', 'JOSE SABOGAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '11', '00', 'SAN MIGUEL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '11', '01', 'SAN MIGUEL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '11', '02', 'BOLIVAR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '11', '03', 'CALQUIS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '11', '04', 'CATILLUC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '11', '05', 'EL PRADO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '11', '06', 'LA FLORIDA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '11', '07', 'LLAPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '11', '08', 'NANCHOC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '11', '09', 'NIEPOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '11', '10', 'SAN GREGORIO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '11', '11', 'SAN SILVESTRE DE COCHAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '11', '12', 'TONGOD');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '11', '13', 'UNION AGUA BLANCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '12', '00', 'SAN PABLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '12', '01', 'SAN PABLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '12', '02', 'SAN BERNARDINO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '12', '03', 'SAN LUIS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '12', '04', 'TUMBADEN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '13', '00', 'SANTA CRUZ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '13', '01', 'SANTA CRUZ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '13', '02', 'ANDABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '13', '03', 'CATACHE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '13', '04', 'CHANCAYBAÑOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '13', '05', 'LA ESPERANZA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '13', '06', 'NINABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '13', '07', 'PULAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '13', '08', 'SAUCEPAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '13', '09', 'SEXI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '13', '10', 'UTICYACU');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '06', '13', '11', 'YAUYUCAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '07', '00', '00', 'CALLAO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '07', '01', '00', 'CALLAO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '07', '01', '01', 'CALLAO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '07', '01', '02', 'BELLAVISTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '07', '01', '03', 'CARMEN DE LA LEGUA REYNOSO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '07', '01', '04', 'LA PERLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '07', '01', '05', 'LA PUNTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '07', '01', '06', 'VENTANILLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '00', '00', 'CUSCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '01', '00', 'CUSCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '01', '01', 'CUSCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '01', '02', 'CCORCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '01', '03', 'POROY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '01', '04', 'SAN JERONIMO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '01', '05', 'SAN SEBASTIAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '01', '06', 'SANTIAGO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '01', '07', 'SAYLLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '01', '08', 'WANCHAQ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '02', '00', 'ACOMAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '02', '01', 'ACOMAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '02', '02', 'ACOPIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '02', '03', 'ACOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '02', '04', 'MOSOC LLACTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '02', '05', 'POMACANCHI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '02', '06', 'RONDOCAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '02', '07', 'SANGARARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '03', '00', 'ANTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '03', '01', 'ANTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '03', '02', 'ANCAHUASI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '03', '03', 'CACHIMAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '03', '04', 'CHINCHAYPUJIO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '03', '05', 'HUAROCONDO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '03', '06', 'LIMATAMBO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '03', '07', 'MOLLEPATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '03', '08', 'PUCYURA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '03', '09', 'ZURITE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '04', '00', 'CALCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '04', '01', 'CALCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '04', '02', 'COYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '04', '03', 'LAMAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '04', '04', 'LARES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '04', '05', 'PISAC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '04', '06', 'SAN SALVADOR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '04', '07', 'TARAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '04', '08', 'YANATILE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '05', '00', 'CANAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '05', '01', 'YANAOCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '05', '02', 'CHECCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '05', '03', 'KUNTURKANKI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '05', '04', 'LANGUI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '05', '05', 'LAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '05', '06', 'PAMPAMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '05', '07', 'QUEHUE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '05', '08', 'TUPAC AMARU');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '06', '00', 'CANCHIS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '06', '01', 'SICUANI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '06', '02', 'CHECACUPE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '06', '03', 'COMBAPATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '06', '04', 'MARANGANI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '06', '05', 'PITUMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '06', '06', 'SAN PABLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '06', '07', 'SAN PEDRO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '06', '08', 'TINTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '07', '00', 'CHUMBIVILCAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '07', '01', 'SANTO TOMAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '07', '02', 'CAPACMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '07', '03', 'CHAMACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '07', '04', 'COLQUEMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '07', '05', 'LIVITACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '07', '06', 'LLUSCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '07', '07', 'QUIÑOTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '07', '08', 'VELILLE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '08', '00', 'ESPINAR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '08', '01', 'ESPINAR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '08', '02', 'CONDOROMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '08', '03', 'COPORAQUE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '08', '04', 'OCORURO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '08', '05', 'PALLPATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '08', '06', 'PICHIGUA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '08', '07', 'SUYCKUTAMBO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '08', '08', 'ALTO PICHIGUA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '09', '00', 'LA CONVENCION');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '09', '01', 'SANTA ANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '09', '02', 'ECHARATE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '09', '03', 'HUAYOPATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '09', '04', 'MARANURA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '09', '05', 'OCOBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '09', '06', 'QUELLOUNO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '09', '07', 'KIMBIRI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '09', '08', 'SANTA TERESA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '09', '09', 'VILCABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '09', '10', 'PICHARI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '10', '00', 'PARURO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '10', '01', 'PARURO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '10', '02', 'ACCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '10', '03', 'CCAPI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '10', '04', 'COLCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '10', '05', 'HUANOQUITE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '10', '06', 'OMACHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '10', '07', 'PACCARITAMBO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '10', '08', 'PILLPINTO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '10', '09', 'YAURISQUE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '11', '00', 'PAUCARTAMBO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '11', '01', 'PAUCARTAMBO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '11', '02', 'CAICAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '11', '03', 'CHALLABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '11', '04', 'COLQUEPATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '11', '05', 'HUANCARANI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '11', '06', 'KOSÑIPATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '12', '00', 'QUISPICANCHI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '12', '01', 'URCOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '12', '02', 'ANDAHUAYLILLAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '12', '03', 'CAMANTI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '12', '04', 'CCARHUAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '12', '05', 'CCATCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '12', '06', 'CUSIPATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '12', '07', 'HUARO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '12', '08', 'LUCRE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '12', '09', 'MARCAPATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '12', '10', 'OCONGATE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '12', '11', 'OROPESA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '12', '12', 'QUIQUIJANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '13', '00', 'URUBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '13', '01', 'URUBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '13', '02', 'CHINCHERO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '13', '03', 'HUAYLLABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '13', '04', 'MACHUPICCHU');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '13', '05', 'MARAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '13', '06', 'OLLANTAYTAMBO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '08', '13', '07', 'YUCAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '00', '00', 'HUANCAVELICA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '01', '00', 'HUANCAVELICA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '01', '01', 'HUANCAVELICA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '01', '02', 'ACOBAMBILLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '01', '03', 'ACORIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '01', '04', 'CONAYCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '01', '05', 'CUENCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '01', '06', 'HUACHOCOLPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '01', '07', 'HUAYLLAHUARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '01', '08', 'IZCUCHACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '01', '09', 'LARIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '01', '10', 'MANTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '01', '11', 'MARISCAL CACERES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '01', '12', 'MOYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '01', '13', 'NUEVO OCCORO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '01', '14', 'PALCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '01', '15', 'PILCHACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '01', '16', 'VILCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '01', '17', 'YAULI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '01', '18', 'ASCENSION');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '01', '19', 'HUANDO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '02', '00', 'ACOBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '02', '01', 'ACOBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '02', '02', 'ANDABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '02', '03', 'ANTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '02', '04', 'CAJA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '02', '05', 'MARCAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '02', '06', 'PAUCARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '02', '07', 'POMACOCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '02', '08', 'ROSARIO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '03', '00', 'ANGARAES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '03', '01', 'LIRCAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '03', '02', 'ANCHONGA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '03', '03', 'CALLANMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '03', '04', 'CCOCHACCASA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '03', '05', 'CHINCHO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '03', '06', 'CONGALLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '03', '07', 'HUANCA-HUANCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '03', '08', 'HUAYLLAY GRANDE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '03', '09', 'JULCAMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '03', '10', 'SAN ANTONIO DE ANTAPARCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '03', '11', 'SANTO TOMAS DE PATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '03', '12', 'SECCLLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '04', '00', 'CASTROVIRREYNA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '04', '01', 'CASTROVIRREYNA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '04', '02', 'ARMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '04', '03', 'AURAHUA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '04', '04', 'CAPILLAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '04', '05', 'CHUPAMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '04', '06', 'COCAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '04', '07', 'HUACHOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '04', '08', 'HUAMATAMBO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '04', '09', 'MOLLEPAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '04', '10', 'SAN JUAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '04', '11', 'SANTA ANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '04', '12', 'TANTARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '04', '13', 'TICRAPO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '05', '00', 'CHURCAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '05', '01', 'CHURCAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '05', '02', 'ANCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '05', '03', 'CHINCHIHUASI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '05', '04', 'EL CARMEN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '05', '05', 'LA MERCED');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '05', '06', 'LOCROJA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '05', '07', 'PAUCARBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '05', '08', 'SAN MIGUEL DE MAYOCC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '05', '09', 'SAN PEDRO DE CORIS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '05', '10', 'PACHAMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '05', '11', 'COSME');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '06', '00', 'HUAYTARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '06', '01', 'HUAYTARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '06', '02', 'AYAVI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '06', '03', 'CORDOVA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '06', '04', 'HUAYACUNDO ARMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '06', '05', 'LARAMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '06', '06', 'OCOYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '06', '07', 'PILPICHACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '06', '08', 'QUERCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '06', '09', 'QUITO-ARMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '06', '10', 'SAN ANTONIO DE CUSICANCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '06', '11', 'SAN FRANCISCO DE SANGAYAICO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '06', '12', 'SAN ISIDRO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '06', '13', 'SANTIAGO DE CHOCORVOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '06', '14', 'SANTIAGO DE QUIRAHUARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '06', '15', 'SANTO DOMINGO DE CAPILLAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '06', '16', 'TAMBO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '07', '00', 'TAYACAJA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '07', '01', 'PAMPAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '07', '02', 'ACOSTAMBO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '07', '03', 'ACRAQUIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '07', '04', 'AHUAYCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '07', '05', 'COLCABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '07', '06', 'DANIEL HERNANDEZ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '07', '07', 'HUACHOCOLPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '07', '09', 'HUARIBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '07', '10', 'ÑAHUIMPUQUIO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '07', '11', 'PAZOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '07', '13', 'QUISHUAR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '07', '14', 'SALCABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '07', '15', 'SALCAHUASI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '07', '16', 'SAN MARCOS DE ROCCHAC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '07', '17', 'SURCUBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '09', '07', '18', 'TINTAY PUNCU');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '00', '00', 'HUANUCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '01', '00', 'HUANUCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '01', '01', 'HUANUCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '01', '02', 'AMARILIS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '01', '03', 'CHINCHAO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '01', '04', 'CHURUBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '01', '05', 'MARGOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '01', '06', 'QUISQUI (KICHKI)');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '01', '07', 'SAN FRANCISCO DE CAYRAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '01', '08', 'SAN PEDRO DE CHAULAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '01', '09', 'SANTA MARIA DEL VALLE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '01', '10', 'YARUMAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '01', '11', 'PILLCO MARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '01', '12', 'YACUS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '02', '00', 'AMBO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '02', '01', 'AMBO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '02', '02', 'CAYNA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '02', '03', 'COLPAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '02', '04', 'CONCHAMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '02', '05', 'HUACAR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '02', '06', 'SAN FRANCISCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '02', '07', 'SAN RAFAEL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '02', '08', 'TOMAY KICHWA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '03', '00', 'DOS DE MAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '03', '01', 'LA UNION');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '03', '07', 'CHUQUIS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '03', '11', 'MARIAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '03', '13', 'PACHAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '03', '16', 'QUIVILLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '03', '17', 'RIPAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '03', '21', 'SHUNQUI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '03', '22', 'SILLAPATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '03', '23', 'YANAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '04', '00', 'HUACAYBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '04', '01', 'HUACAYBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '04', '02', 'CANCHABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '04', '03', 'COCHABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '04', '04', 'PINRA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '05', '00', 'HUAMALIES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '05', '01', 'LLATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '05', '02', 'ARANCAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '05', '03', 'CHAVIN DE PARIARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '05', '04', 'JACAS GRANDE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '05', '05', 'JIRCAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '05', '06', 'MIRAFLORES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '05', '07', 'MONZON');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '05', '08', 'PUNCHAO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '05', '09', 'PUÑOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '05', '10', 'SINGA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '05', '11', 'TANTAMAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '06', '00', 'LEONCIO PRADO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '06', '01', 'RUPA-RUPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '06', '02', 'DANIEL ALOMIA ROBLES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '06', '03', 'HERMILIO VALDIZAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '06', '04', 'JOSE CRESPO Y CASTILLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '06', '05', 'LUYANDO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '06', '06', 'MARIANO DAMASO BERAUN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '07', '00', 'MARAÑON');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '07', '01', 'HUACRACHUCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '07', '02', 'CHOLON');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '07', '03', 'SAN BUENAVENTURA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '08', '00', 'PACHITEA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '08', '01', 'PANAO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '08', '02', 'CHAGLLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '08', '03', 'MOLINO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '08', '04', 'UMARI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '09', '00', 'PUERTO INCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '09', '01', 'PUERTO INCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '09', '02', 'CODO DEL POZUZO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '09', '03', 'HONORIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '09', '04', 'TOURNAVISTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '09', '05', 'YUYAPICHIS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '10', '00', 'LAURICOCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '10', '01', 'JESUS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '10', '02', 'BAÑOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '10', '03', 'JIVIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '10', '04', 'QUEROPALCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '10', '05', 'RONDOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '10', '06', 'SAN FRANCISCO DE ASIS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '10', '07', 'SAN MIGUEL DE CAURI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '11', '00', 'YAROWILCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '11', '01', 'CHAVINILLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '11', '02', 'CAHUAC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '11', '03', 'CHACABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '11', '04', 'APARICIO POMARES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '11', '05', 'JACAS CHICO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '11', '06', 'OBAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '11', '07', 'PAMPAMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '10', '11', '08', 'CHORAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '00', '00', 'ICA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '01', '00', 'ICA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '01', '01', 'ICA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '01', '02', 'LA TINGUIÑA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '01', '03', 'LOS AQUIJES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '01', '04', 'OCUCAJE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '01', '05', 'PACHACUTEC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '01', '06', 'PARCONA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '01', '07', 'PUEBLO NUEVO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '01', '08', 'SALAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '01', '09', 'SAN JOSE DE LOS MOLINOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '01', '10', 'SAN JUAN BAUTISTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '01', '11', 'SANTIAGO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '01', '12', 'SUBTANJALLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '01', '13', 'TATE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '01', '14', 'YAUCA DEL ROSARIO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '02', '00', 'CHINCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '02', '01', 'CHINCHA ALTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '02', '02', 'ALTO LARAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '02', '03', 'CHAVIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '02', '04', 'CHINCHA BAJA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '02', '05', 'EL CARMEN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '02', '06', 'GROCIO PRADO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '02', '07', 'PUEBLO NUEVO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '02', '08', 'SAN JUAN DE YANAC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '02', '09', 'SAN PEDRO DE HUACARPANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '02', '10', 'SUNAMPE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '02', '11', 'TAMBO DE MORA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '03', '00', 'NAZCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '03', '01', 'NAZCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '03', '02', 'CHANGUILLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '03', '03', 'EL INGENIO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '03', '04', 'MARCONA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '03', '05', 'VISTA ALEGRE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '04', '00', 'PALPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '04', '01', 'PALPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '04', '02', 'LLIPATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '04', '03', 'RIO GRANDE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '04', '04', 'SANTA CRUZ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '04', '05', 'TIBILLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '05', '00', 'PISCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '05', '01', 'PISCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '05', '02', 'HUANCANO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '05', '03', 'HUMAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '05', '04', 'INDEPENDENCIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '05', '05', 'PARACAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '05', '06', 'SAN ANDRES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '05', '07', 'SAN CLEMENTE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '11', '05', '08', 'TUPAC AMARU INCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '00', '00', 'JUNIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '00', 'HUANCAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '01', 'HUANCAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '04', 'CARHUACALLANGA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '05', 'CHACAPAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '06', 'CHICCHE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '07', 'CHILCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '08', 'CHONGOS ALTO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '11', 'CHUPURO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '12', 'COLCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '13', 'CULLHUAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '14', 'EL TAMBO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '16', 'HUACRAPUQUIO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '17', 'HUALHUAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '19', 'HUANCAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '20', 'HUASICANCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '21', 'HUAYUCACHI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '22', 'INGENIO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '24', 'PARIAHUANCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '25', 'PILCOMAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '26', 'PUCARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '27', 'QUICHUAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '28', 'QUILCAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '29', 'SAN AGUSTIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '30', 'SAN JERONIMO DE TUNAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '32', 'SAÑO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '33', 'SAPALLANGA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '34', 'SICAYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '35', 'SANTO DOMINGO DE ACOBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '01', '36', 'VIQUES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '02', '00', 'CONCEPCION');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '02', '01', 'CONCEPCION');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '02', '02', 'ACO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '02', '03', 'ANDAMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '02', '04', 'CHAMBARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '02', '05', 'COCHAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '02', '06', 'COMAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '02', '07', 'HEROINAS TOLEDO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '02', '08', 'MANZANARES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '02', '09', 'MARISCAL CASTILLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '02', '10', 'MATAHUASI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '02', '11', 'MITO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '02', '12', 'NUEVE DE JULIO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '02', '13', 'ORCOTUNA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '02', '14', 'SAN JOSE DE QUERO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '02', '15', 'SANTA ROSA DE OCOPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '03', '00', 'CHANCHAMAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '03', '01', 'CHANCHAMAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '03', '02', 'PERENE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '03', '03', 'PICHANAQUI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '03', '04', 'SAN LUIS DE SHUARO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '03', '05', 'SAN RAMON');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '03', '06', 'VITOC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '00', 'JAUJA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '01', 'JAUJA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '02', 'ACOLLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '03', 'APATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '04', 'ATAURA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '05', 'CANCHAYLLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '06', 'CURICACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '07', 'EL MANTARO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '08', 'HUAMALI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '09', 'HUARIPAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '10', 'HUERTAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '11', 'JANJAILLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '12', 'JULCAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '13', 'LEONOR ORDOÑEZ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '14', 'LLOCLLAPAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '15', 'MARCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '16', 'MASMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '17', 'MASMA CHICCHE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '18', 'MOLINOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '19', 'MONOBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '20', 'MUQUI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '21', 'MUQUIYAUYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '22', 'PACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '23', 'PACCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '24', 'PANCAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '25', 'PARCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '26', 'POMACANCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '27', 'RICRAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '28', 'SAN LORENZO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '29', 'SAN PEDRO DE CHUNAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '30', 'SAUSA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '31', 'SINCOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '32', 'TUNAN MARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '33', 'YAULI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '04', '34', 'YAUYOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '05', '00', 'JUNIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '05', '01', 'JUNIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '05', '02', 'CARHUAMAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '05', '03', 'ONDORES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '05', '04', 'ULCUMAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '06', '00', 'SATIPO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '06', '01', 'SATIPO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '06', '02', 'COVIRIALI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '06', '03', 'LLAYLLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '06', '05', 'PAMPA HERMOSA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '06', '07', 'RIO NEGRO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '06', '08', 'RIO TAMBO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '06', '99', 'MAZAMARI - PANGOA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '07', '00', 'TARMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '07', '01', 'TARMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '07', '02', 'ACOBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '07', '03', 'HUARICOLCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '07', '04', 'HUASAHUASI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '07', '05', 'LA UNION');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '07', '06', 'PALCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '07', '07', 'PALCAMAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '07', '08', 'SAN PEDRO DE CAJAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '07', '09', 'TAPO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '08', '00', 'YAULI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '08', '01', 'LA OROYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '08', '02', 'CHACAPALPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '08', '03', 'HUAY-HUAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '08', '04', 'MARCAPOMACOCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '08', '05', 'MOROCOCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '08', '06', 'PACCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '08', '07', 'SANTA BARBARA DE CARHUACAYAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '08', '08', 'SANTA ROSA DE SACCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '08', '09', 'SUITUCANCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '08', '10', 'YAULI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '09', '00', 'CHUPACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '09', '01', 'CHUPACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '09', '02', 'AHUAC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '09', '03', 'CHONGOS BAJO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '09', '04', 'HUACHAC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '09', '05', 'HUAMANCACA CHICO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '09', '06', 'SAN JUAN DE ISCOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '09', '07', 'SAN JUAN DE JARPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '09', '08', 'TRES DE DICIEMBRE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '12', '09', '09', 'YANACANCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '00', '00', 'LA LIBERTAD');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '01', '00', 'TRUJILLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '01', '01', 'TRUJILLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '01', '02', 'EL PORVENIR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '01', '03', 'FLORENCIA DE MORA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '01', '04', 'HUANCHACO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '01', '05', 'LA ESPERANZA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '01', '06', 'LAREDO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '01', '07', 'MOCHE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '01', '08', 'POROTO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '01', '09', 'SALAVERRY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '01', '10', 'SIMBAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '01', '11', 'VICTOR LARCO HERRERA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '02', '00', 'ASCOPE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '02', '01', 'ASCOPE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '02', '02', 'CHICAMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '02', '03', 'CHOCOPE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '02', '04', 'MAGDALENA DE CAO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '02', '05', 'PAIJAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '02', '06', 'RAZURI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '02', '07', 'SANTIAGO DE CAO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '02', '08', 'CASA GRANDE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '03', '00', 'BOLIVAR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '03', '01', 'BOLIVAR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '03', '02', 'BAMBAMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '03', '03', 'CONDORMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '03', '04', 'LONGOTEA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '03', '05', 'UCHUMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '03', '06', 'UCUNCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '04', '00', 'CHEPEN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '04', '01', 'CHEPEN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '04', '02', 'PACANGA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '04', '03', 'PUEBLO NUEVO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '05', '00', 'JULCAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '05', '01', 'JULCAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '05', '02', 'CALAMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '05', '03', 'CARABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '05', '04', 'HUASO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '06', '00', 'OTUZCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '06', '01', 'OTUZCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '06', '02', 'AGALLPAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '06', '04', 'CHARAT');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '06', '05', 'HUARANCHAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '06', '06', 'LA CUESTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '06', '08', 'MACHE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '06', '10', 'PARANDAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '06', '11', 'SALPO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '06', '13', 'SINSICAP');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '06', '14', 'USQUIL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '07', '00', 'PACASMAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '07', '01', 'SAN PEDRO DE LLOC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '07', '02', 'GUADALUPE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '07', '03', 'JEQUETEPEQUE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '07', '04', 'PACASMAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '07', '05', 'SAN JOSE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '08', '00', 'PATAZ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '08', '01', 'TAYABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '08', '02', 'BULDIBUYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '08', '03', 'CHILLIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '08', '04', 'HUANCASPATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '08', '05', 'HUAYLILLAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '08', '06', 'HUAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '08', '07', 'ONGON');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '08', '08', 'PARCOY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '08', '09', 'PATAZ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '08', '10', 'PIAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '08', '11', 'SANTIAGO DE CHALLAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '08', '12', 'TAURIJA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '08', '13', 'URPAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '09', '00', 'SANCHEZ CARRION');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '09', '01', 'HUAMACHUCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '09', '02', 'CHUGAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '09', '03', 'COCHORCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '09', '04', 'CURGOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '09', '05', 'MARCABAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '09', '06', 'SANAGORAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '09', '07', 'SARIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '09', '08', 'SARTIMBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '10', '00', 'SANTIAGO DE CHUCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '10', '01', 'SANTIAGO DE CHUCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '10', '02', 'ANGASMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '10', '03', 'CACHICADAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '10', '04', 'MOLLEBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '10', '05', 'MOLLEPATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '10', '06', 'QUIRUVILCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '10', '07', 'SANTA CRUZ DE CHUCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '10', '08', 'SITABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '11', '00', 'GRAN CHIMU');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '11', '01', 'CASCAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '11', '02', 'LUCMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '11', '03', 'MARMOT');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '11', '04', 'SAYAPULLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '12', '00', 'VIRU');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '12', '01', 'VIRU');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '12', '02', 'CHAO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '13', '12', '03', 'GUADALUPITO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '00', '00', 'LAMBAYEQUE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '01', '00', 'CHICLAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '01', '01', 'CHICLAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '01', '02', 'CHONGOYAPE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '01', '03', 'ETEN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '01', '04', 'ETEN PUERTO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '01', '05', 'JOSE LEONARDO ORTIZ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '01', '06', 'LA VICTORIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '01', '07', 'LAGUNAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '01', '08', 'MONSEFU');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '01', '09', 'NUEVA ARICA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '01', '10', 'OYOTUN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '01', '11', 'PICSI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '01', '12', 'PIMENTEL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '01', '13', 'REQUE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '01', '14', 'SANTA ROSA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '01', '15', 'SAÑA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '01', '16', 'CAYALTI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '01', '17', 'PATAPO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '01', '18', 'POMALCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '01', '19', 'PUCALA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '01', '20', 'TUMAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '02', '00', 'FERREÑAFE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '02', '01', 'FERREÑAFE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '02', '02', 'CAÑARIS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '02', '03', 'INCAHUASI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '02', '04', 'MANUEL ANTONIO MESONES MURO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '02', '05', 'PITIPO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '02', '06', 'PUEBLO NUEVO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '03', '00', 'LAMBAYEQUE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '03', '01', 'LAMBAYEQUE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '03', '02', 'CHOCHOPE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '03', '03', 'ILLIMO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '03', '04', 'JAYANCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '03', '05', 'MOCHUMI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '03', '06', 'MORROPE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '03', '07', 'MOTUPE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '03', '08', 'OLMOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '03', '09', 'PACORA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '03', '10', 'SALAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '03', '11', 'SAN JOSE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '14', '03', '12', 'TUCUME');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '00', '00', 'LIMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '00', 'LIMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '01', 'LIMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '02', 'ANCON');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '03', 'ATE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '04', 'BARRANCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '05', 'BREÑA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '06', 'CARABAYLLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '07', 'CHACLACAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '08', 'CHORRILLOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '09', 'CIENEGUILLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '10', 'COMAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '11', 'EL AGUSTINO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '12', 'INDEPENDENCIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '13', 'JESUS MARIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '14', 'LA MOLINA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '15', 'LA VICTORIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '16', 'LINCE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '17', 'LOS OLIVOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '18', 'LURIGANCHO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '19', 'LURIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '20', 'MAGDALENA DEL MAR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '21', 'PUEBLO LIBRE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '22', 'MIRAFLORES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '23', 'PACHACAMAC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '24', 'PUCUSANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '25', 'PUENTE PIEDRA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '26', 'PUNTA HERMOSA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '27', 'PUNTA NEGRA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '28', 'RIMAC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '29', 'SAN BARTOLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '30', 'SAN BORJA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '31', 'SAN ISIDRO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '32', 'SAN JUAN DE LURIGANCHO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '33', 'SAN JUAN DE MIRAFLORES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '34', 'SAN LUIS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '35', 'SAN MARTIN DE PORRES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '36', 'SAN MIGUEL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '37', 'SANTA ANITA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '38', 'SANTA MARIA DEL MAR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '39', 'SANTA ROSA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '40', 'SANTIAGO DE SURCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '41', 'SURQUILLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '42', 'VILLA EL SALVADOR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '01', '43', 'VILLA MARIA DEL TRIUNFO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '02', '00', 'BARRANCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '02', '01', 'BARRANCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '02', '02', 'PARAMONGA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '02', '03', 'PATIVILCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '02', '04', 'SUPE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '02', '05', 'SUPE PUERTO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '03', '00', 'CAJATAMBO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '03', '01', 'CAJATAMBO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '03', '02', 'COPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '03', '03', 'GORGOR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '03', '04', 'HUANCAPON');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '03', '05', 'MANAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '04', '00', 'CANTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '04', '01', 'CANTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '04', '02', 'ARAHUAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '04', '03', 'HUAMANTANGA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '04', '04', 'HUAROS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '04', '05', 'LACHAQUI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '04', '06', 'SAN BUENAVENTURA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '04', '07', 'SANTA ROSA DE QUIVES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '05', '00', 'CAÑETE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '05', '01', 'SAN VICENTE DE CAÑETE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '05', '02', 'ASIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '05', '03', 'CALANGO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '05', '04', 'CERRO AZUL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '05', '05', 'CHILCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '05', '06', 'COAYLLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '05', '07', 'IMPERIAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '05', '08', 'LUNAHUANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '05', '09', 'MALA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '05', '10', 'NUEVO IMPERIAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '05', '11', 'PACARAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '05', '12', 'QUILMANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '05', '13', 'SAN ANTONIO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '05', '14', 'SAN LUIS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '05', '15', 'SANTA CRUZ DE FLORES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '05', '16', 'ZUÑIGA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '06', '00', 'HUARAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '06', '01', 'HUARAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '06', '02', 'ATAVILLOS ALTO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '06', '03', 'ATAVILLOS BAJO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '06', '04', 'AUCALLAMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '06', '05', 'CHANCAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '06', '06', 'IHUARI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '06', '07', 'LAMPIAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '06', '08', 'PACARAOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '06', '09', 'SAN MIGUEL DE ACOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '06', '10', 'SANTA CRUZ DE ANDAMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '06', '11', 'SUMBILCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '06', '12', 'VEINTISIETE DE NOVIEMBRE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '00', 'HUAROCHIRI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '01', 'MATUCANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '02', 'ANTIOQUIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '03', 'CALLAHUANCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '04', 'CARAMPOMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '05', 'CHICLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '06', 'CUENCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '07', 'HUACHUPAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '08', 'HUANZA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '09', 'HUAROCHIRI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '10', 'LAHUAYTAMBO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '11', 'LANGA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '12', 'LARAOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '13', 'MARIATANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '14', 'RICARDO PALMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '15', 'SAN ANDRES DE TUPICOCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '16', 'SAN ANTONIO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '17', 'SAN BARTOLOME');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '18', 'SAN DAMIAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '19', 'SAN JUAN DE IRIS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '20', 'SAN JUAN DE TANTARANCHE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '21', 'SAN LORENZO DE QUINTI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '22', 'SAN MATEO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '23', 'SAN MATEO DE OTAO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '24', 'SAN PEDRO DE CASTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '25', 'SAN PEDRO DE HUANCAYRE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '26', 'SANGALLAYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '27', 'SANTA CRUZ DE COCACHACRA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '28', 'SANTA EULALIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '29', 'SANTIAGO DE ANCHUCAYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '30', 'SANTIAGO DE TUNA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '31', 'SANTO DOMINGO DE LOS OLLEROS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '07', '32', 'SURCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '08', '00', 'HUAURA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '08', '01', 'HUACHO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '08', '02', 'AMBAR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '08', '03', 'CALETA DE CARQUIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '08', '04', 'CHECRAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '08', '05', 'HUALMAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '08', '06', 'HUAURA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '08', '07', 'LEONCIO PRADO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '08', '08', 'PACCHO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '08', '09', 'SANTA LEONOR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '08', '10', 'SANTA MARIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '08', '11', 'SAYAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '08', '12', 'VEGUETA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '09', '00', 'OYON');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '09', '01', 'OYON');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '09', '02', 'ANDAJES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '09', '03', 'CAUJUL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '09', '04', 'COCHAMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '09', '05', 'NAVAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '09', '06', 'PACHANGARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '00', 'YAUYOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '01', 'YAUYOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '02', 'ALIS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '03', 'ALLAUCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '04', 'AYAVIRI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '05', 'AZANGARO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '06', 'CACRA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '07', 'CARANIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '08', 'CATAHUASI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '09', 'CHOCOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '10', 'COCHAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '11', 'COLONIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '12', 'HONGOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '13', 'HUAMPARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '14', 'HUANCAYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '15', 'HUANGASCAR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '16', 'HUANTAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '17', 'HUAÑEC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '18', 'LARAOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '19', 'LINCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '20', 'MADEAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '21', 'MIRAFLORES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '22', 'OMAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '23', 'PUTINZA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '24', 'QUINCHES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '25', 'QUINOCAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '26', 'SAN JOAQUIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '27', 'SAN PEDRO DE PILAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '28', 'TANTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '29', 'TAURIPAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '30', 'TOMAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '31', 'TUPE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '32', 'VIÑAC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '15', '10', '33', 'VITIS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '00', '00', 'LORETO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '01', '00', 'MAYNAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '01', '01', 'IQUITOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '01', '02', 'ALTO NANAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '01', '03', 'FERNANDO LORES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '01', '04', 'INDIANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '01', '05', 'LAS AMAZONAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '01', '06', 'MAZAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '01', '07', 'NAPO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '01', '08', 'PUNCHANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '01', '09', 'PUTUMAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '01', '10', 'TORRES CAUSANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '01', '12', 'BELEN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '01', '13', 'SAN JUAN BAUTISTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '01', '14', 'TENIENTE MANUEL CLAVERO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '02', '00', 'ALTO AMAZONAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '02', '01', 'YURIMAGUAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '02', '02', 'BALSAPUERTO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '02', '05', 'JEBEROS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '02', '06', 'LAGUNAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '02', '10', 'SANTA CRUZ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '02', '11', 'TENIENTE CESAR LOPEZ ROJAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '03', '00', 'LORETO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '03', '01', 'NAUTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '03', '02', 'PARINARI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '03', '03', 'TIGRE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '03', '04', 'TROMPETEROS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '03', '05', 'URARINAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '04', '00', 'MARISCAL RAMON CASTILLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '04', '01', 'RAMON CASTILLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '04', '02', 'PEBAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '04', '03', 'YAVARI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '04', '04', 'SAN PABLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '05', '00', 'REQUENA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '05', '01', 'REQUENA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '05', '02', 'ALTO TAPICHE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '05', '03', 'CAPELO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '05', '04', 'EMILIO SAN MARTIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '05', '05', 'MAQUIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '05', '06', 'PUINAHUA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '05', '07', 'SAQUENA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '05', '08', 'SOPLIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '05', '09', 'TAPICHE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '05', '10', 'JENARO HERRERA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '05', '11', 'YAQUERANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '06', '00', 'UCAYALI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '06', '01', 'CONTAMANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '06', '02', 'INAHUAYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '06', '03', 'PADRE MARQUEZ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '06', '04', 'PAMPA HERMOSA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '06', '05', 'SARAYACU');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '06', '06', 'VARGAS GUERRA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '07', '00', 'DATEM DEL MARAÑON');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '07', '01', 'BARRANCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '07', '02', 'CAHUAPANAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '07', '03', 'MANSERICHE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '07', '04', 'MORONA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '07', '05', 'PASTAZA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '16', '07', '06', 'ANDOAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '17', '00', '00', 'MADRE DE DIOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '17', '01', '00', 'TAMBOPATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '17', '01', '01', 'TAMBOPATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '17', '01', '02', 'INAMBARI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '17', '01', '03', 'LAS PIEDRAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '17', '01', '04', 'LABERINTO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '17', '02', '00', 'MANU');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '17', '02', '01', 'MANU');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '17', '02', '02', 'FITZCARRALD');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '17', '02', '03', 'MADRE DE DIOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '17', '02', '04', 'HUEPETUHE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '17', '03', '00', 'TAHUAMANU');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '17', '03', '01', 'IÑAPARI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '17', '03', '02', 'IBERIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '17', '03', '03', 'TAHUAMANU');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '18', '00', '00', 'MOQUEGUA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '18', '01', '00', 'MARISCAL NIETO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '18', '01', '01', 'MOQUEGUA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '18', '01', '02', 'CARUMAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '18', '01', '03', 'CUCHUMBAYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '18', '01', '04', 'SAMEGUA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '18', '01', '05', 'SAN CRISTOBAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '18', '01', '06', 'TORATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '18', '02', '00', 'GENERAL SANCHEZ CERRO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '18', '02', '01', 'OMATE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '18', '02', '02', 'CHOJATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '18', '02', '03', 'COALAQUE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '18', '02', '04', 'ICHUÑA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '18', '02', '05', 'LA CAPILLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '18', '02', '06', 'LLOQUE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '18', '02', '07', 'MATALAQUE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '18', '02', '08', 'PUQUINA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '18', '02', '09', 'QUINISTAQUILLAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '18', '02', '10', 'UBINAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '18', '02', '11', 'YUNGA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '18', '03', '00', 'ILO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '18', '03', '01', 'ILO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '18', '03', '02', 'EL ALGARROBAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '18', '03', '03', 'PACOCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '00', '00', 'PASCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '01', '00', 'PASCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '01', '01', 'CHAUPIMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '01', '02', 'HUACHON');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '01', '03', 'HUARIACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '01', '04', 'HUAYLLAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '01', '05', 'NINACACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '01', '06', 'PALLANCHACRA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '01', '07', 'PAUCARTAMBO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '01', '08', 'SAN FRANCISCO DE ASIS DE YARUSYACAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '01', '09', 'SIMON BOLIVAR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '01', '10', 'TICLACAYAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '01', '11', 'TINYAHUARCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '01', '12', 'VICCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '01', '13', 'YANACANCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '02', '00', 'DANIEL ALCIDES CARRION');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '02', '01', 'YANAHUANCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '02', '02', 'CHACAYAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '02', '03', 'GOYLLARISQUIZGA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '02', '04', 'PAUCAR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '02', '05', 'SAN PEDRO DE PILLAO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '02', '06', 'SANTA ANA DE TUSI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '02', '07', 'TAPUC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '02', '08', 'VILCABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '03', '00', 'OXAPAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '03', '01', 'OXAPAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '03', '02', 'CHONTABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '03', '03', 'HUANCABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '03', '04', 'PALCAZU');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '03', '05', 'POZUZO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '03', '06', 'PUERTO BERMUDEZ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '03', '07', 'VILLA RICA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '19', '03', '08', 'CONSTITUCION');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '00', '00', 'PIURA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '01', '00', 'PIURA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '01', '01', 'PIURA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '01', '04', 'CASTILLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '01', '05', 'CATACAOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '01', '07', 'CURA MORI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '01', '08', 'EL TALLAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '01', '09', 'LA ARENA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '01', '10', 'LA UNION');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '01', '11', 'LAS LOMAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '01', '14', 'TAMBO GRANDE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '02', '00', 'AYABACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '02', '01', 'AYABACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '02', '02', 'FRIAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '02', '03', 'JILILI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '02', '04', 'LAGUNAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '02', '05', 'MONTERO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '02', '06', 'PACAIPAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '02', '07', 'PAIMAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '02', '08', 'SAPILLICA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '02', '09', 'SICCHEZ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '02', '10', 'SUYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '03', '00', 'HUANCABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '03', '01', 'HUANCABAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '03', '02', 'CANCHAQUE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '03', '03', 'EL CARMEN DE LA FRONTERA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '03', '04', 'HUARMACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '03', '05', 'LALAQUIZ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '03', '06', 'SAN MIGUEL DE EL FAIQUE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '03', '07', 'SONDOR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '03', '08', 'SONDORILLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '04', '00', 'MORROPON');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '04', '01', 'CHULUCANAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '04', '02', 'BUENOS AIRES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '04', '03', 'CHALACO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '04', '04', 'LA MATANZA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '04', '05', 'MORROPON');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '04', '06', 'SALITRAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '04', '07', 'SAN JUAN DE BIGOTE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '04', '08', 'SANTA CATALINA DE MOSSA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '04', '09', 'SANTO DOMINGO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '04', '10', 'YAMANGO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '05', '00', 'PAITA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '05', '01', 'PAITA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '05', '02', 'AMOTAPE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '05', '03', 'ARENAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '05', '04', 'COLAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '05', '05', 'LA HUACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '05', '06', 'TAMARINDO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '05', '07', 'VICHAYAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '06', '00', 'SULLANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '06', '01', 'SULLANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '06', '02', 'BELLAVISTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '06', '03', 'IGNACIO ESCUDERO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '06', '04', 'LANCONES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '06', '05', 'MARCAVELICA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '06', '06', 'MIGUEL CHECA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '06', '07', 'QUERECOTILLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '06', '08', 'SALITRAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '07', '00', 'TALARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '07', '01', 'PARIÑAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '07', '02', 'EL ALTO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '07', '03', 'LA BREA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '07', '04', 'LOBITOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '07', '05', 'LOS ORGANOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '07', '06', 'MANCORA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '08', '00', 'SECHURA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '08', '01', 'SECHURA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '08', '02', 'BELLAVISTA DE LA UNION');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '08', '03', 'BERNAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '08', '04', 'CRISTO NOS VALGA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '08', '05', 'VICE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '20', '08', '06', 'RINCONADA LLICUAR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '00', '00', 'PUNO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '01', '00', 'PUNO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '01', '01', 'PUNO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '01', '02', 'ACORA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '01', '03', 'AMANTANI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '01', '04', 'ATUNCOLLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '01', '05', 'CAPACHICA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '01', '06', 'CHUCUITO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '01', '07', 'COATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '01', '08', 'HUATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '01', '09', 'MAÑAZO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '01', '10', 'PAUCARCOLLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '01', '11', 'PICHACANI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '01', '12', 'PLATERIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '01', '13', 'SAN ANTONIO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '01', '14', 'TIQUILLACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '01', '15', 'VILQUE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '02', '00', 'AZANGARO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '02', '01', 'AZANGARO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '02', '02', 'ACHAYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '02', '03', 'ARAPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '02', '04', 'ASILLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '02', '05', 'CAMINACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '02', '06', 'CHUPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '02', '07', 'JOSE DOMINGO CHOQUEHUANCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '02', '08', 'MUÑANI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '02', '09', 'POTONI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '02', '10', 'SAMAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '02', '11', 'SAN ANTON');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '02', '12', 'SAN JOSE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '02', '13', 'SAN JUAN DE SALINAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '02', '14', 'SANTIAGO DE PUPUJA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '02', '15', 'TIRAPATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '03', '00', 'CARABAYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '03', '01', 'MACUSANI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '03', '02', 'AJOYANI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '03', '03', 'AYAPATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '03', '04', 'COASA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '03', '05', 'CORANI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '03', '06', 'CRUCERO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '03', '07', 'ITUATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '03', '08', 'OLLACHEA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '03', '09', 'SAN GABAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '03', '10', 'USICAYOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '04', '00', 'CHUCUITO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '04', '01', 'JULI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '04', '02', 'DESAGUADERO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '04', '03', 'HUACULLANI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '04', '04', 'KELLUYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '04', '05', 'PISACOMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '04', '06', 'POMATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '04', '07', 'ZEPITA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '05', '00', 'EL COLLAO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '05', '01', 'ILAVE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '05', '02', 'CAPAZO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '05', '03', 'PILCUYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '05', '04', 'SANTA ROSA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '05', '05', 'CONDURIRI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '06', '00', 'HUANCANE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '06', '01', 'HUANCANE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '06', '02', 'COJATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '06', '03', 'HUATASANI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '06', '04', 'INCHUPALLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '06', '05', 'PUSI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '06', '06', 'ROSASPATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '06', '07', 'TARACO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '06', '08', 'VILQUE CHICO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '07', '00', 'LAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '07', '01', 'LAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '07', '02', 'CABANILLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '07', '03', 'CALAPUJA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '07', '04', 'NICASIO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '07', '05', 'OCUVIRI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '07', '06', 'PALCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '07', '07', 'PARATIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '07', '08', 'PUCARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '07', '09', 'SANTA LUCIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '07', '10', 'VILAVILA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '08', '00', 'MELGAR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '08', '01', 'AYAVIRI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '08', '02', 'ANTAUTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '08', '03', 'CUPI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '08', '04', 'LLALLI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '08', '05', 'MACARI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '08', '06', 'NUÑOA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '08', '07', 'ORURILLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '08', '08', 'SANTA ROSA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '08', '09', 'UMACHIRI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '09', '00', 'MOHO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '09', '01', 'MOHO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '09', '02', 'CONIMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '09', '03', 'HUAYRAPATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '09', '04', 'TILALI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '10', '00', 'SAN ANTONIO DE PUTINA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '10', '01', 'PUTINA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '10', '02', 'ANANEA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '10', '03', 'PEDRO VILCA APAZA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '10', '04', 'QUILCAPUNCU');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '10', '05', 'SINA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '11', '00', 'SAN ROMAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '11', '01', 'JULIACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '11', '02', 'CABANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '11', '03', 'CABANILLAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '11', '04', 'CARACOTO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '12', '00', 'SANDIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '12', '01', 'SANDIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '12', '02', 'CUYOCUYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '12', '03', 'LIMBANI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '12', '04', 'PATAMBUCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '12', '05', 'PHARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '12', '06', 'QUIACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '12', '07', 'SAN JUAN DEL ORO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '12', '08', 'YANAHUAYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '12', '09', 'ALTO INAMBARI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '12', '10', 'SAN PEDRO DE PUTINA PUNCO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '13', '00', 'YUNGUYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '13', '01', 'YUNGUYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '13', '02', 'ANAPIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '13', '03', 'COPANI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '13', '04', 'CUTURAPI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '13', '05', 'OLLARAYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '13', '06', 'TINICACHI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '21', '13', '07', 'UNICACHI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '00', '00', 'SAN MARTIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '01', '00', 'MOYOBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '01', '01', 'MOYOBAMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '01', '02', 'CALZADA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '01', '03', 'HABANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '01', '04', 'JEPELACIO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '01', '05', 'SORITOR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '01', '06', 'YANTALO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '02', '00', 'BELLAVISTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '02', '01', 'BELLAVISTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '02', '02', 'ALTO BIAVO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '02', '03', 'BAJO BIAVO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '02', '04', 'HUALLAGA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '02', '05', 'SAN PABLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '02', '06', 'SAN RAFAEL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '03', '00', 'EL DORADO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '03', '01', 'SAN JOSE DE SISA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '03', '02', 'AGUA BLANCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '03', '03', 'SAN MARTIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '03', '04', 'SANTA ROSA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '03', '05', 'SHATOJA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '04', '00', 'HUALLAGA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '04', '01', 'SAPOSOA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '04', '02', 'ALTO SAPOSOA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '04', '03', 'EL ESLABON');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '04', '04', 'PISCOYACU');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '04', '05', 'SACANCHE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '04', '06', 'TINGO DE SAPOSOA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '05', '00', 'LAMAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '05', '01', 'LAMAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '05', '02', 'ALONSO DE ALVARADO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '05', '03', 'BARRANQUITA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '05', '04', 'CAYNARACHI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '05', '05', 'CUÑUMBUQUI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '05', '06', 'PINTO RECODO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '05', '07', 'RUMISAPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '05', '08', 'SAN ROQUE DE CUMBAZA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '05', '09', 'SHANAO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '05', '10', 'TABALOSOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '05', '11', 'ZAPATERO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '06', '00', 'MARISCAL CACERES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '06', '01', 'JUANJUI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '06', '02', 'CAMPANILLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '06', '03', 'HUICUNGO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '06', '04', 'PACHIZA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '06', '05', 'PAJARILLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '07', '00', 'PICOTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '07', '01', 'PICOTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '07', '02', 'BUENOS AIRES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '07', '03', 'CASPISAPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '07', '04', 'PILLUANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '07', '05', 'PUCACACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '07', '06', 'SAN CRISTOBAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '07', '07', 'SAN HILARION');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '07', '08', 'SHAMBOYACU');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '07', '09', 'TINGO DE PONASA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '07', '10', 'TRES UNIDOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '08', '00', 'RIOJA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '08', '01', 'RIOJA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '08', '02', 'AWAJUN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '08', '03', 'ELIAS SOPLIN VARGAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '08', '04', 'NUEVA CAJAMARCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '08', '05', 'PARDO MIGUEL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '08', '06', 'POSIC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '08', '07', 'SAN FERNANDO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '08', '08', 'YORONGOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '08', '09', 'YURACYACU');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '09', '00', 'SAN MARTIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '09', '01', 'TARAPOTO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '09', '02', 'ALBERTO LEVEAU');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '09', '03', 'CACATACHI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '09', '04', 'CHAZUTA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '09', '05', 'CHIPURANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '09', '06', 'EL PORVENIR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '09', '07', 'HUIMBAYOC');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '09', '08', 'JUAN GUERRA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '09', '09', 'LA BANDA DE SHILCAYO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '09', '10', 'MORALES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '09', '11', 'PAPAPLAYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '09', '12', 'SAN ANTONIO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '09', '13', 'SAUCE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '09', '14', 'SHAPAJA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '10', '00', 'TOCACHE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '10', '01', 'TOCACHE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '10', '02', 'NUEVO PROGRESO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '10', '03', 'POLVORA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '10', '04', 'SHUNTE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '22', '10', '05', 'UCHIZA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '00', '00', 'TACNA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '01', '00', 'TACNA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '01', '01', 'TACNA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '01', '02', 'ALTO DE LA ALIANZA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '01', '03', 'CALANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '01', '04', 'CIUDAD NUEVA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '01', '05', 'INCLAN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '01', '06', 'PACHIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '01', '07', 'PALCA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '01', '08', 'POCOLLAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '01', '09', 'SAMA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '01', '10', 'CORONEL GREGORIO ALBARRACIN LANCHIPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '02', '00', 'CANDARAVE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '02', '01', 'CANDARAVE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '02', '02', 'CAIRANI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '02', '03', 'CAMILACA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '02', '04', 'CURIBAYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '02', '05', 'HUANUARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '02', '06', 'QUILAHUANI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '03', '00', 'JORGE BASADRE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '03', '01', 'LOCUMBA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '03', '02', 'ILABAYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '03', '03', 'ITE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '04', '00', 'TARATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '04', '01', 'TARATA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '04', '02', 'HEROES ALBARRACIN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '04', '03', 'ESTIQUE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '04', '04', 'ESTIQUE-PAMPA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '04', '05', 'SITAJARA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '04', '06', 'SUSAPAYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '04', '07', 'TARUCACHI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '23', '04', '08', 'TICACO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '24', '00', '00', 'TUMBES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '24', '01', '00', 'TUMBES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '24', '01', '01', 'TUMBES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '24', '01', '02', 'CORRALES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '24', '01', '03', 'LA CRUZ');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '24', '01', '04', 'PAMPAS DE HOSPITAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '24', '01', '05', 'SAN JACINTO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '24', '01', '06', 'SAN JUAN DE LA VIRGEN');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '24', '02', '00', 'CONTRALMIRANTE VILLAR');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '24', '02', '01', 'ZORRITOS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '24', '02', '02', 'CASITAS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '24', '02', '03', 'CANOAS DE PUNTA SAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '24', '03', '00', 'ZARUMILLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '24', '03', '01', 'ZARUMILLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '24', '03', '02', 'AGUAS VERDES');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '24', '03', '03', 'MATAPALO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '24', '03', '04', 'PAPAYAL');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '25', '00', '00', 'UCAYALI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '25', '01', '00', 'CORONEL PORTILLO');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '25', '01', '01', 'CALLERIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '25', '01', '02', 'CAMPOVERDE');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '25', '01', '03', 'IPARIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '25', '01', '04', 'MASISEA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '25', '01', '05', 'YARINACOCHA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '25', '01', '06', 'NUEVA REQUENA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '25', '01', '07', 'MANANTAY');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '25', '02', '00', 'ATALAYA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '25', '02', '01', 'RAYMONDI');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '25', '02', '02', 'SEPAHUA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '25', '02', '03', 'TAHUANIA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '25', '02', '04', 'YURUA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '25', '03', '00', 'PADRE ABAD');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '25', '03', '01', 'PADRE ABAD');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '25', '03', '02', 'IRAZOLA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '25', '03', '03', 'CURIMANA');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '25', '04', '00', 'PURUS');
INSERT INTO sistema_ubigeo (cod_pais, cod_depa, cod_prov, cod_dist, nombre) VALUES ('PE', '25', '04', '01', 'PURUS');


--
-- Volcado de datos para la tabla `usuario_usuario`
--

INSERT INTO `usuario_usuario` (`id`, `mguid`, `facebook_id`, `twitter_id`, `email`, `password`, `estado`, `imagen`, `nombres`, `paterno`, `materno`, `di_tipo`, `di_valor`, `fecha_nac`, `pais_id`, `departamento_id`, `provincia_id`, `distrito_id`, `fecha_creacion`, `fecha_edicion`, `codigo_activar`) VALUES
(4, '{272DFF6A-57D1-4883-A28D-FCD880AE41A7}', NULL, NULL, 'ing.angeljara@gmail.com', 'Nf7lCN0W', 1, NULL, 'Angel', 'Jara', 'test', 1, '2324232', '2015-03-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, '{5C3E7CA9-6412-4CA5-9C8C-F0E0F02968DE}', NULL, NULL, 'jludena@idigital.pe', 'AIUCfvr7', 1, 'null.jpg', 'Juan Carlos', 'test', 'test', 1, '55477433', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a4609eb6ba1f8814e24f4006de8aa6e62a8cdb88b83e51c76b46abcbd9faa325');

INSERT INTO `tarjeta_tarjeta` (`id`, `usuario_id`, `nombre`, `cguid`, `numero`, `emoney`, `emoneyvalue`, `bonus`, `bonusvalue`, `promotionbonus`, `bonusplusvalue`, `gamepoints`, `gamepointsvalue`, `etickets`, `estado_truefi`, `fecha_creacion`, `fecha_edicion`, `fecha_actualizacion`) VALUES
(11, 7, 'Mis Primos2', '{0BEB1DE9-582F-4995-A2FE-8C6ADD526109}', '004-243217-5', 0, 0, 0, 0, 0, 10, 0, 0, 0, 0, '2016-05-16 21:14:30', '2016-05-18 03:45:11', '2016-05-24 03:03:04'),
(12, 7, 'Tios3ass', '{344B00DA-1769-4A93-87E7-BBCF32574EAB}', '004-243218-6', 0, 7.45, 0, 0, 0, 10, 0, 0, 0, 0, '2016-05-16 21:34:59', '2016-05-18 03:45:11', '2016-05-24 03:03:16'),
(13, 7, 'Amigos de la promo1', '{BA4C4BDF-46FC-43CF-8A01-2626EFF6F02C}', '004-243219-7', 0, 0, 0, 0, 0, 10, 0, 0, 0, 0, '2016-05-16 21:36:50', '2016-05-18 03:45:11', '2016-05-24 03:03:30'),
(14, 7, 'mis tios5', '{53CD9800-C515-4B59-81F2-BF6E9812AD29}', '004-243220-8', 0, 34, 0, 0, 0, 10, 0, 0, 0, 0, '2016-05-17 22:31:18', '2016-05-18 03:45:11', '2016-05-24 03:03:42');

--
-- Volcado de datos para la tabla `paquete_paquete`
--

INSERT INTO `paquete_paquete` (`id`, `referencia`, `titulo1`, `titulo2`, `tipo`, `imagen`, `emoney`, `bonus`, `promotionbonus`, `etickets`, `gamepoints`, `legal`, `activo`, `destacado`, `orden`, `fecha_creacion`, `fecha_edicion`) VALUES
(6, '583f0c9af40e350c9837e8f30a73b5c9', '¡COLECCIONA DIVERSIÓN!', '¡Por recargas de S/ 30 llévate 30 en saldo y un VASO 3D!', 1, 'f45731e3d39a1b2330bbf93e9b3de59e-20160414.png', 1, 1, 0, NULL, 0, 'saassa', 1, 0, 1, '2016-04-14 23:32:53', NULL),
(10, '28e9efd8067bb08f9a5be96d5deea073', 'Promoción 1', 'Recarga 1 S/.100, obten S/.50 soles adicionales + S/.30 en Coney Bonos', 2, 'f45731e3d39a1b2330bbf93e9b3de59e-20160415.png', 2, 2, 0, NULL, 0, NULL, 1, 0, 2, '2016-04-18 06:45:01', NULL),
(11, '2f61a7cd1e0c166edcdea52b78e69d44', 'Promoción 2', 'Recarga 2 S/.100 y obtenS/.50soles adicionales + S/.30 en Coney Bonos', 2, 'f45731e3d39a1b2330bbf93e9b3de59e-20160416.png', 3, 3, 0, NULL, 0, NULL, 1, 0, 3, '2016-04-18 06:45:01', NULL),
(12, '2f61a7cd1e0c166edcdea52b78e69d45', 'Promoción 3', 'Recarga 3 S/.100 y obtenS/.50soles adicionales + S/.30 en Coney Bonos', 2, 'f45731e3d39a1b2330bbf93e9b3de59e-20160417.png', 4, 1, 0, NULL, 0, NULL, 1, 1, 4, '2016-04-18 06:45:01', NULL),
(13, '2f61a7cd1e0c166edcdea52b78e69d46', 'Promoción 4', 'Recarga 4 S/.100 y obtenS/.50soles adicionales + S/.30 en Coney Bonos', 2, 'f45731e3d39a1b2330bbf93e9b3de59x-20160417.png', 1, 2, 0, NULL, 0, '', 1, 0, 5, '2016-04-18 06:45:01', NULL);

--
-- Volcado de datos para la tabla `cms_contenido`
--

INSERT INTO `cms_contenido` (`id`, `codigo`, `tipo`, `titulo`, `url`, `contenido`, `estado`, `fecha_creacion`, `fecha_edicion`) VALUES
(1, 'INICIO_LOGIN', 2, '1', '', '<h2>¡Ahora <span>recárgate de diversión </span>con un click!</h2><p class="subtitle">Te invitamos a ser parte de Coney Club y a realizar todas tus recargas de una manera más rápida, <strong>sin necesidad de hacer colas</strong>, además, tendrás <strong>promociones exclusivas </strong>que no te puedes perder.</p>', 1, '2016-04-16 01:53:19', '2016-05-21 04:15:48'),
(2, 'BENEFICIOS', 2, '1', '', '<p><span style="font-size:18px"><span style="color:rgb(255, 165, 0)">Beneficios para ti</span></span></p>

<p><span style="font-size:20px">Por ser <strong>miembro del Coney Club </strong>cuentas con las siguientes grandes beneficios</span></p>

<div class="options">
<div class="col_3 left">
<div class="circle"><img alt="" src="/s/front/images/beneficio_1.png" /></div>

<p><span style="font-size:16px">Hasta <strong><span style="color:#FFA500">20% de descuento en todos los juegos.</span> </strong>Seg&uacute;n el tipo de local</span></p>
</div>

<div class="col_3 left">
<div class="circle"><img alt="" src="/s/front/images/beneficio_2.png" /></div>

<p><span style="font-size:16px"><strong><span style="color:#FFA500">20 Coney Bonos gratis</span> </strong>el d&iacute;a de tu cumplea&ntilde;os (Presentando su DNI)</span></p>
</div>

<div class="col_3 right">
<div class="circle"><img alt="" src="/s/front/images/beneficio_3.png" /></div>

<p><span style="font-size:16px"><strong><span style="color:#FFA500">Descuentos exclusivos</span> </strong>por recargas en fechas especiales (D&iacute;a de los enamorados, d&iacute;a de la madre y padre, halloween, etc.)</span></p>
</div>
</div>', 1, '2016-05-21 04:15:29', '2016-05-27 07:33:36'),
(3, 'INICIO_REGISTRO', 2, '1', '', '<h2>¡Bienvenido a <span>Coney Club </span>recargas virtuales!</h2> <h3>¡Un club creado para todos aquellos que buscan <span>más diversión </span>por mucho menos!</h3><p>Ahora podrás hacer tus recargas <strong>sin necesidad de hacer colas, </strong>además podrás gozar de <strong>muchos beneficios</strong></p>', 1, '2016-04-16 01:53:19', '2016-05-21 04:15:48'),
(4, 'TERMINOS_CONDICIONES', 1, 'Términos y Condicionones', 'http://coneypark.pe/recargas/terminos-condiciones', '<p style="text-align:justify"><span style="font-size:18px"><span style="color:rgb(128, 0, 128)"><strong>Vigente a partir del fecha&nbsp; 01 de&nbsp; junio de 2016</strong></span></span></p>

<p style="text-align:justify"><span style="font-size:14px"><strong>Esto es importante para ti:</strong></span></p>

<p style="text-align:justify">En&nbsp; www.coneypark.pe queremos siempre ofrecerte una experiencia de compra que sea&nbsp; segura y divertida. Por favor revisa los T&eacute;rminos y Condiciones Generales y las Pol&iacute;ticas de privacidad de ATRACCIONES CONEY ISLAND S.A.C., ya que son las condiciones de venta que rigen en sus compras en nuestro portal www.coneypark.pe. Ellos establecen sus derechos y obligaciones con respecto a tus recargas, incluyendo importantes limitaciones y exclusiones. La utilizaci&oacute;n del sitio y/o sus servicios constituye la aceptaci&oacute;n de que estas condiciones se aplican a&nbsp; tus recargas, as&iacute; que&nbsp; aseg&uacute;rate que las&nbsp; entiendes antes de realizarlas.</p>

<p style="text-align:justify"><br />
<span style="font-size:22px"><span style="color:rgb(128, 0, 128)"><strong>T&Eacute;RMINOS Y CONDICIONES</strong></span></span></p>

<p style="text-align:justify"><br />
Este documento describe los t&eacute;rminos y condiciones generales (los &quot;T&eacute;rminos y Condiciones Generales&quot;) y las pol&iacute;ticas de privacidad (las &quot;Pol&iacute;ticas de Privacidad&quot;) aplicables al acceso y uso de los servicios ofrecidos por ATRACCIONES CONEY ISLAND S.A.C. (&quot;los Servicios&quot;) dentro del sitio&nbsp; www.conepark.pe, sus subdominios y/u otros dominios (urls) relacionados (en adelante &quot;coneypark.pe&quot; o el &quot;Sitio&quot;), en donde &eacute;stos T&eacute;rminos y Condiciones se encuentren. Cualquier persona que desee acceder y/o suscribirse y/o usar el Sitio o los Servicios podr&aacute; hacerlo sujet&aacute;ndose a los T&eacute;rminos y Condiciones Generales y las Pol&iacute;ticas de Privacidad, junto con todas las dem&aacute;s pol&iacute;ticas y principios que rigen coneypark.pe y que son incorporados al presente directamente o por referencia o que son explicados y/o detallados en otras secciones del Sitio. En consecuencia, todas las visitas y todos los contratos y transacciones que se realicen en este Sitio, as&iacute; como sus efectos jur&iacute;dicos, quedar&aacute;n regidos por estas reglas y sometidos a la legislaci&oacute;n aplicable en Per&uacute;.</p>

<p style="text-align:justify">Los T&eacute;rminos y Condiciones y las Pol&iacute;ticas de Privacidad contenidos en este instrumento se aplicar&aacute;n y se entender&aacute;n como parte integral de todos los actos y contratos que se ejecuten o celebren mediante los sistemas de oferta y comercializaci&oacute;n comprendidos en este sitio entre los usuarios de este sitio y ATRACCIONES CONEY ISLAND S.A.C. (en adelante &quot;ATRACCIONES CONEY ISLAND S.A.C.&quot;, &quot;CONEY PARK&quot; o &quot;la Empresa&quot;, indistintamente), y por cualquiera de las otras sociedades o empresas que sean filiales o vinculadas a ella, y que hagan uso de este sitio, a las cuales se las denominar&aacute; en adelante tambi&eacute;n en forma indistinta como las &quot;Empresas&quot;, o bien la &quot;Empresa Oferente&quot;, el &quot;Proveedor&quot; o la &quot;Empresa Proveedora&quot;, seg&uacute;n convenga al sentido del texto.</p>

<p style="text-align:justify">En caso que las Empresas hubieran fijado sus propios T&eacute;rminos y Condiciones y sus Pol&iacute;ticas de Privacidad para los actos y contratos que realicen en este sitio, ellas aparecer&aacute;n en esta p&aacute;gina se&ntilde;alada con un link o indicada como parte de la promoci&oacute;n de sus ofertas y promociones y prevalecer&aacute;n sobre &eacute;stas. CUALQUIER PERSONA QUE NO ACEPTE ESTOS T&Eacute;RMINOS Y CONDICIONES GENERALES Y LAS POL&Iacute;TICAS DE PRIVACIDAD, LOS CUALES TIENEN UN CAR&Aacute;CTER OBLIGATORIO Y VINCULANTE, DEBER&Aacute; ABSTENERSE DE UTILIZAR EL SITIO Y/O LOS SERVICIOS.</p>

<p style="text-align:justify">El Usuario debe leer, entender y aceptar todas las condiciones establecidas en los T&eacute;rminos y Condiciones Generales y en las Pol&iacute;ticas de Privacidad de ATRACCIONES CONEY ISLAND S.A.C. as&iacute; como en los dem&aacute;s documentos incorporados a los mismos por referencia, previo a su registro como Usuario de&nbsp; coneypark.pe y/o a la adquisici&oacute;n de productos y/o entrega de cualquier dato con cualquier fin.</p>

<p style="text-align:justify">Cuando usted visita coneypark.pe se est&aacute; comunicando con CONEY PARK de manera electr&oacute;nica. En ese sentido, usted brinda su consentimiento para recibir comunicaciones de CONEY PARK por correo electr&oacute;nico o mediante la publicaci&oacute;n de avisos en su portal.</p>

<p style="text-align:justify"><span style="font-size:18px"><span style="color:rgb(128, 0, 128)"><strong>1. Capacidad Legal</strong></span></span></p>

<p style="text-align:justify">Los Servicios s&oacute;lo est&aacute;n disponibles para personas que tengan capacidad legal para contratar. No podr&aacute;n utilizar los servicios las personas que no tengan esa capacidad entre estos los menores de edad o Usuarios de coneypark.pe&nbsp; que hayan sido suspendidos temporalmente o inhabilitados definitivamente en raz&oacute;n de o dispuesto en la secci&oacute;n 2 &ldquo;Registro y Uso del Sitio&rdquo;. Los actos que &nbsp;los menores realicen en este sitio ser&aacute;n responsabilidad de sus padres, tutores, encargados o curadores, y por tanto se considerar&aacute;n realizados por &eacute;stos en ejercicio de la representaci&oacute;n legal con la que cuentan.<br />
Quien registre un Usuario como empresa afirmar&aacute; que (i) cuenta con capacidad para contratar en representaci&oacute;n de tal entidad y de obligar a la misma en los t&eacute;rminos de este Acuerdo, (ii) la direcci&oacute;n se&ntilde;alada en el registro es el domicilio principal de dicha entidad, y (iii) cualquier otra informaci&oacute;n presentada a CONEY PARK es verdadera, precisa, actualizada y completa.</p>

<p style="text-align:justify"><span style="font-size:18px"><strong><span style="color:rgb(128, 0, 128)">2. Registro y Uso del Sitio</span></strong></span></p>

<p style="text-align:justify">Es obligatorio completar el formulario de registro en todos sus campos con datos v&aacute;lidos para convertirse en Usuario autorizado de&nbsp; coneypark.pe (el &quot;Socio&quot; CONEY PARK o el &quot;Usuario&quot;), de esta manera, podr&aacute; acceder a las promociones, y a la adquisici&oacute;n de productos y/o servicios ofrecidos en este sitio. El futuro Miembro o Usuario CONEY PARK deber&aacute; completar el formulario de registro con su informaci&oacute;n personal de manera exacta, precisa y verdadera (&quot;Datos Personales&quot;) y asume el compromiso de actualizar los Datos Personales conforme resulte necesario. CONEY PARK podr&aacute; utilizar diversos medios para identificar a sus&nbsp; SOCIOS y USUARIOS, pero CONEY PARK NO se responsabiliza por la certeza de los Datos Personales provistos por sus Socios y Usuarios. Los Socios y Usuarios garantizan y responden, en cualquier caso, de la exactitud, veracidad, vigencia y autenticidad de los Datos Personales ingresados. En ese sentido, la declaraci&oacute;n realizada por los Socios y Usuarios al momento de registrarse se entender&aacute; como una Declaraci&oacute;n Jurada.</p>

<p style="text-align:justify">Cada Socio o Usuario s&oacute;lo podr&aacute; ser titular de 1 (una) cuenta CONEY PARK , no pudiendo acceder a m&aacute;s de 1 (una) cuenta CONEY PARK con distintas direcciones de correo electr&oacute;nico o falseando, modificando y/o alterando sus datos personales de cualquier manera posible. En caso se detecte esta infracci&oacute;n, CONEY PARK comunicar&aacute; al cliente inform&aacute;ndole que todas sus cuentas ser&aacute;n agrupadas en una sola cuenta anul&aacute;ndose todas sus dem&aacute;s cuentas.</p>

<p style="text-align:justify">Si se verificara o sospechara alg&uacute;n uso fraudulento y/o malintencionado y/o contrario a estos T&eacute;rminos y Condiciones y/o contrarios a la buena fe, CONEY PARK&nbsp; tendr&aacute; el derecho inapelable de dar por terminados los cr&eacute;ditos, no hacer efectiva las promociones, cancelar las transacciones en curso, dar de baja las cuentas y hasta de perseguir judicialmente a los infractores.</p>

<p style="text-align:justify">CONEY PARK podr&aacute; realizar controles que crea convenientes para verificar la veracidad de la informaci&oacute;n dada por el Usuario. En ese sentido, se reserva el derecho de solicitar alg&uacute;n comprobante y/o dato adicional a efectos de corroborar los Datos Personales, as&iacute; como de suspender temporal o definitivamente a aquellos Socios o Usuarios cuyos datos no hayan podido ser confirmados. En estos casos de inhabilitaci&oacute;n, CONEY PARK podr&aacute; dar de baja la compra efectuada, sin que ello genere derecho alguno a resarcimiento, pago y/o indemnizaci&oacute;n.</p>

<p style="text-align:justify">El&nbsp; Socio o Usuario , una vez registrado, dispondr&aacute; de su direcci&oacute;n de email y una clave secreta (en adelante la &quot;Clave&quot;) que le permitir&aacute; el acceso personalizado, confidencial y seguro. En caso de poseer estos datos, el Usuario tendr&aacute; la posibilidad de cambiar la Clave de acceso para lo cual deber&aacute; sujetarse al procedimiento establecido en el sitio respectivo. El Usuario se obliga a mantener la confidencialidad de su Clave de acceso, asumiendo totalmente la responsabilidad por el mantenimiento de la confidencialidad de su Clave secreta registrada en este sitio web, la cual le permite efectuar compras, solicitar servicios y obtener informaci&oacute;n (la &ldquo;Cuenta&rdquo;). Dicha Clave es de uso personal, y su entrega a terceros no involucra responsabilidad de ATRACCIONES CONEY ISLAND S.A.C. o de las empresas en caso de utilizaci&oacute;n indebida, negligente y/o incorrecta.</p>

<p style="text-align:justify">El Usuario ser&aacute; responsable por todas las operaciones efectuadas en y desde su Cuenta, pues el acceso a la misma est&aacute; restringido al ingreso y uso de una Clave secreta, de conocimiento exclusivo del Usuario. El Miembro se compromete a notificar a&nbsp; ATRACCIONES CONEY ISLAND S.A.C. en forma inmediata y por medio id&oacute;neo y fehaciente, cualquier uso no autorizado de su Cuenta y/o Clave, as&iacute; como el ingreso por terceros no autorizados a la misma. Se aclara que est&aacute; prohibida la venta, cesi&oacute;n, pr&eacute;stamo o transferencia de la Clave y/o Cuenta bajo ning&uacute;n t&iacute;tulo ATRACCIONES CONEY ISLAND S.A.C. se reserva el derecho de rechazar cualquier solicitud de registro o de cancelar un registro previamente aceptado, sin que est&eacute; obligado a comunicar o exponer las razones de su decisi&oacute;n y sin que ello genere alg&uacute;n derecho a indemnizaci&oacute;n o resarcimiento.</p>

<p style="text-align:justify">El registro del Usuario es personal y no se puede transferir por ning&uacute;n motivo a terceras personas. En ese sentido, ning&uacute;n usuario podr&aacute; vender, intentar vender, ceder o transferir un usuario o contrase&ntilde;a. Por lo dicho, CONEY PARK podr&aacute; suspender o cancelar definitivamente una cuenta en el caso de una venta, ofrecimiento de venta, cesi&oacute;n o transferencia, en infracci&oacute;n de lo dispuesto en el presente p&aacute;rrafo</p>

<p style="text-align:justify"><span style="font-size:18px"><span style="color:rgb(128, 0, 128)"><strong>3. Modificaciones Del Acuerdo</strong></span></span></p>

<p style="text-align:justify">ATRACCIONES CONEY ISLAND S.A.C. podr&aacute; modificar los T&eacute;rminos y Condiciones Generales en cualquier momento, haciendo p&uacute;blicos en el Sitio los t&eacute;rminos modificados. Todos los t&eacute;rminos modificados entrar&aacute;n en vigor a los 10 (diez) d&iacute;as h&aacute;biles despu&eacute;s de su publicaci&oacute;n. Dentro de los 5 (cinco) d&iacute;as h&aacute;biles siguientes a la publicaci&oacute;n de las modificaciones introducidas, el Usuario se deber&aacute; comunicar por e-mail a la siguiente direcci&oacute;n:&nbsp;noclientes@coneyparkperu.com si no acepta las mismas; en ese caso quedar&aacute; disuelto el v&iacute;nculo contractual y ser&aacute; inhabilitado como Socio o Usuario. Vencido este plazo, se considerar&aacute; que el Socio o Usuario acepta los nuevos t&eacute;rminos y el contrato continuar&aacute; vinculando a ambas partes.</p>

<p style="text-align:justify"><strong><span style="font-size:18px"><span style="color:rgb(128, 0, 128)">4. Procedimiento para hacer uso de este sitio de Internet</span></span></strong></p>

<p style="text-align:justify">En los contratos ofrecidos por medio del Sitio,&nbsp; coneypark.pe informar&aacute;, de manera inequ&iacute;voca y f&aacute;cilmente accesible, los pasos que deber&aacute;n seguirse para celebrarlos, e informar&aacute; cuando corresponda, si el documento electr&oacute;nico en que se formalice el contrato ser&aacute; archivado y si &eacute;ste ser&aacute; accesible al Miembro. El solo hecho de seguir los pasos que para tales efectos se indiquen en este sitio para efectuar una recarga o reserva, equivale a aceptar que efectivamente ha dado cumplimiento a las condiciones contenidas en este apartado. Indicar&aacute;, adem&aacute;s, su direcci&oacute;n de correo postal o electr&oacute;nico y los medios t&eacute;cnicos a disposici&oacute;n del Socio o Usuario para identificar y corregir errores en la recarga, reserva o en sus datos.</p>

<p style="text-align:justify"><span style="font-size:18px"><span style="color:rgb(128, 0, 128)"><strong>5. Medios de pago que se podr&aacute;n utilizar en el Sitio</strong></span></span></p>

<p style="text-align:justify">Los productos&nbsp; ofrecidos en el Sitio, salvo que se se&ntilde;ale una forma diferente para casos particulares u ofertas de determinadas cargas o servicios, s&oacute;lo pueden ser pagados con los medios que en cada caso espec&iacute;ficamente se indiquen. El uso de tarjetas de cr&eacute;dito se sujetar&aacute; a lo establecido en estos T&eacute;rminos y Condiciones y, en relaci&oacute;n con su emisor, y a lo pactado en los respectivos Contratos de Apertura y Reglamento de Uso. En caso de contradicci&oacute;n, predominar&aacute; lo expresado en ese &uacute;ltimo instrumento. Trat&aacute;ndose de tarjetas bancarias aceptadas en el Sitio, los aspectos relativos a &eacute;stas, tales como la fecha de emisi&oacute;n, caducidad, cupo, bloqueos, etc., se regir&aacute;n por el respectivo Contrato de Apertura y Reglamento de Uso, de tal forma que el sitio podr&aacute; indicar determinadas condiciones de compra seg&uacute;n el medio de pago que se utilice por el usuario. CONEY PARK podr&aacute; otorgar descuento, ofertas o promociones en la forma de cr&eacute;ditos que los Usuarios podr&aacute;n descontar en su compra. En cada caso CONEY PARK determinar&aacute; unilateralmente el monto m&aacute;ximo de cr&eacute;ditos que el Usuario podr&aacute; utilizar en una compra y lo detallar&aacute; en el sistema, previo a iniciar el proceso de pago. Los cr&eacute;ditos utilizados por los Usuarios no ser&aacute;n reintegrados en caso de devoluci&oacute;n por cualquier causa que esto ocurriera.<br />
Al utilizar una tarjeta de cr&eacute;dito o d&eacute;bito, el nombre del titular de dicha tarjeta debe coincidir con el nombre utilizado al registrarse en el portal de CONEY PARK. De lo contrario, se podr&iacute;a anular la operaci&oacute;n. Bajo cualquier sospecha y/o confirmaci&oacute;n de compras no autorizadas, CONEY PARK cancelar&aacute; la compra y efectuar&aacute; el reverso a la tarjeta.</p>

<p style="text-align:justify"><span style="font-size:18px"><strong><span style="color:rgb(128, 0, 128)">6. Plazo de validez de la oferta y precio</span></strong></span></p>

<p style="text-align:justify">El plazo de validez de la oferta es aquel que coincide con la fecha de vigencia indicada en la promoci&oacute;n o en virtud del agotamiento de las cantidades de productos disponibles para esa promoci&oacute;n debidamente informados al Usuario, o mientras la oferta se mantenga disponible, el menor de &eacute;stos plazos. Cuando quiera que en una promoci&oacute;n no se indique una fecha de terminaci&oacute;n se entender&aacute; que la actividad se extender&aacute; hasta el agotamiento de los inventarios correspondientes.</p>

<p style="text-align:justify">Los precios de los productos y servicios disponibles en el Sitio, mientras aparezcan en &eacute;l, solo tendr&aacute;n vigencia y aplicaci&oacute;n en &eacute;ste y no ser&aacute;n aplicables a otros canales de venta utilizados por las empresas, tales como tiendas f&iacute;sicas, venta telef&oacute;nica, otros sitios de venta por v&iacute;a electr&oacute;nica, volantes, cat&aacute;logos u otros. Los precios de los productos ofrecidos en el Sitio est&aacute;n expresados en Nuevos soles peruanos salvo que se manifieste lo contrario. Los precios ofrecidos corresponden exclusivamente al valor del bien ofrecido y no incluyen gastos de transporte, manejo, env&iacute;o, accesorios, servicios adicionales, shows adicionales, que no se describan expresamente ni ning&uacute;n otro &iacute;tem adicional.</p>

<p style="text-align:justify">Adicionalmente, es posible que cierto n&uacute;mero de productos puedan tener un precio incorrecto. De existir un error tipogr&aacute;fico en alguno de los precios de las recargas, los productos o las reservas, si el precio correcto del art&iacute;culo es m&aacute;s alto que el que figura en la p&aacute;gina, a nuestra discreci&oacute;n ATRACCIONES CONEY ISLAND S.A.C.,&nbsp; lo contactar&aacute; antes de que la recarga o reserva sea realizada, y/o cancelaremos el pedido y le notificaremos acerca de la cancelaci&oacute;n.</p>

<p style="text-align:justify"><span style="font-size:18px"><span style="color:rgb(128, 0, 128)"><strong>7.&nbsp;&nbsp;&nbsp;&nbsp; Promociones</strong></span></span></p>

<p style="text-align:justify">Las promociones que se ofrezcan en este Sitio web no son necesariamente las mismas que ofrezcan otros canales de venta utilizados por la empresa, tales como tiendas f&iacute;sicas, venta telef&oacute;nica, cat&aacute;logos u otros, a menos que se se&ntilde;ale expresamente en este sitio o en la publicidad que realicen las empresas para cada promoci&oacute;n. Cuando el Sitio ofrezca promociones que consistan en precio rebajado, se har&aacute; en el mismo portal web. El Sitio somete sus promociones y actividades promocionales al cumplimiento de las normas vigentes.</p>

<p style="text-align:justify">El uso del cup&oacute;n de descuento es completamente gratuito.</p>

<p style="text-align:justify">Cuando se ofrezcan cupones de descuento, se se&ntilde;alar&aacute; en la publicidad, el valor del cup&oacute;n, la suma m&iacute;nima o m&aacute;xima de compra para poder redimir el bono y&nbsp; las fechas v&aacute;lidas para su redenci&oacute;n.<br />
El cup&oacute;n de descuento aplica para compras realizada exclusivamente en la p&aacute;gina coneypark.pe<br />
Podr&aacute; hacer uso del bono de descuento cualquier persona natural mayor de dieciocho (18) a&ntilde;os.<br />
El cup&oacute;n de descuento no es v&aacute;lido para tarjetas de regalo ni ventas corporativas. Se entiende por ventas corporativas todas aquellas ventas realizadas a personas jur&iacute;dicas.<br />
El monto m&aacute;ximo de compra para el uso del cup&oacute;n va estar expl&iacute;citamente indicado en los elementos gr&aacute;ficos de la campa&ntilde;a.</p>

<p style="text-align:justify">No es acumulable con otras promociones.</p>

<p style="text-align:justify">El uso del bono solamente podr&aacute; ser usado una vez por cada cliente&nbsp;y una vez vencido no podr&aacute; volver ser usado.</p>

<p style="text-align:justify">Al hacer una compra con el cup&oacute;n se entiende que el consumidor ha aceptado &iacute;ntegramente los tanto los T&eacute;rminos y Condiciones generales de la p&aacute;gina as&iacute; como estos T&eacute;rminos y Condiciones particulares.</p>

<p style="text-align:justify"><strong><span style="font-size:18px"><span style="color:rgb(128, 0, 128)">8. Pol&iacute;tica de Devoluci&oacute;n</span></span></strong></p>

<p style="text-align:justify">Para el caso de recargas de tarjeta no se realizar&aacute;n devoluciones de dinero.&nbsp;</p>

<p style="text-align:justify"><span style="font-size:18px"><span style="color:rgb(128, 0, 128)"><strong>9. Comprobantes de Pago</strong></span></span></p>

<p style="text-align:justify">Seg&uacute;n el reglamento de Comprobantes de Pago aprobado por la Resoluci&oacute;n de Superintendencia N&deg; 007-99 / SUNAT (RCP) y el Texto &Uacute;nico Ordenado de la Ley del Impuesto General a las Ventas e Impuesto Selectivo al Consumo, aprobado mediante Decreto Supremo N&deg; 055-99-EF y normas modificatorias (TUO del IGV): &ldquo;No existe ning&uacute;n procedimiento vigente que permita el canje de boletas de venta por facturas, m&aacute;s a&uacute;n las notas de cr&eacute;dito no se encuentran previstas para modificar al adquirente o usuario que figura en el comprobante de pago original&rdquo;.</p>

<p style="text-align:justify">Teniendo en cuenta esta resoluci&oacute;n, es obligaci&oacute;n del consumidor decidir correctamente el documento que solicitar&aacute; como comprobante al momento de su compra, ya que seg&uacute;n los p&aacute;rrafos citados no proceder&aacute; cambio alguno.</p>

<p style="text-align:justify"><span style="font-size:18px"><span style="color:rgb(128, 0, 128)"><strong>10.&nbsp;&nbsp; Propiedad Intelectual</strong></span></span></p>

<p style="text-align:justify">Todo el contenido incluido o puesto a disposici&oacute;n del Usuario en el Sitio, incluyendo textos, gr&aacute;ficas, logos, &iacute;conos, im&aacute;genes, archivos de audio, descargas digitales y cualquier otra informaci&oacute;n (el &quot;Contenido&quot;), es de propiedad de ATRACCIONES CONEY ISLAND S.A.C. o ha sido licenciada a &eacute;sta por las Empresas Proveedoras. La compilaci&oacute;n del Contenido es propiedad exclusiva de ATRACCIONES CONEY ISLAND S.A.C. y, en tal sentido, el Usuario debe abstenerse de extraer y/o reutilizar partes del Contenido sin el consentimiento previo y expreso de la Empresa.</p>

<p style="text-align:justify"><span style="color:#800080"><span style="font-size:18px"><strong>11. Responsabilidad de Coney Park</strong></span></span></p>

<p style="text-align:justify">ATRACCIONES CONEY ISLAND S.A.C. har&aacute; lo posible dentro de sus capacidades para que la transmisi&oacute;n del Sitio sea ininterrumpida y libre de errores. Sin embargo, dada la naturaleza de la Internet, dichas condiciones no pueden ser garantizadas. En el mismo sentido, el acceso del Usuario a la Cuenta puede ser ocasionalmente restringido o suspendido con el objeto de efectuar reparaciones, mantenimiento o introducir nuevos Servicios. ATRACCIONES CONEY ISLAND S.A.C. no ser&aacute; responsable por p&eacute;rdidas (i) que no hayan sido causadas por el incumplimiento de sus obligaciones; (ii) lucro cesante o p&eacute;rdidas de oportunidades comerciales; (iii) cualquier da&ntilde;o indirecto.</p>

<p style="text-align:justify"><strong><span style="font-size:18px"><span style="color:rgb(128, 0, 128)">12. Indemnizaci&oacute;n</span></span></strong></p>

<p style="text-align:justify">El Usuario indemnizar&aacute; y mantendr&aacute; indemne a&nbsp;ATRACCIONES CONEY ISLAND S.A.C., sus filiales, empresas controladas y/o controlantes, directivos, administradores, representantes y empleados, por su incumplimiento en los T&eacute;rminos y Condiciones Generales y dem&aacute;s Pol&iacute;ticas que se entienden incorporadas al presente o por la violaci&oacute;n de cualesquiera leyes o derechos de terceros, incluyendo los honorarios de abogados en una cantidad razonable.</p>

<p style="text-align:justify"><span style="font-size:18px"><span style="color:rgb(128, 0, 128)"><strong>13. T&eacute;rminos de Ley</strong></span></span></p>

<p style="text-align:justify">Este acuerdo ser&aacute; gobernado e interpretado de acuerdo con las leyes de Per&uacute;, sin dar efecto a cualquier principio de conflictos de ley. Si alguna disposici&oacute;n de estos T&eacute;rminos y Condiciones es declarada ilegal, o presenta un vac&iacute;o, o por cualquier raz&oacute;n resulta inaplicable, la misma deber&aacute; ser interpretada dentro del marco del mismo y en cualquier caso no afectar&aacute; la validez y la aplicabilidad de las provisiones restantes.</p>

<p style="text-align:justify"><span style="font-size:18px"><span style="color:rgb(128, 0, 128)"><strong>14. Notificaciones</strong></span></span></p>

<p style="text-align:justify">Cualquier comentario, inquietud o reclamaci&oacute;n respecto de los anteriores T&eacute;rminos y Condiciones, la Pol&iacute;tica de Privacidad, o la ejecuci&oacute;n de cualquiera de &eacute;stos, deber&aacute; ser notificada por escrito a ATRACCIONES CONEY ISLAND S.A.C. a la siguiente direcci&oacute;n: Calle Chamaya 175 3er piso Urbanizaci&oacute;n Pando San Miguel.</p>

<p style="text-align:justify"><span style="color:#800080"><span style="font-size:18px"><strong>15. Jurisdicci&oacute;n y ley aplicable</strong></span></span></p>

<p style="text-align:justify">Este acuerdo estar&aacute; regido en todos sus puntos por las leyes vigentes en la Rep&uacute;blica del Per&uacute;.&nbsp; Cualquier controversia derivada del presente acuerdo, su existencia, validez, interpretaci&oacute;n, alcance o cumplimiento, ser&aacute; sometida a los tribunales competentes de la ciudad de Lima, Per&uacute;.</p>
', 1, now(), null),
(5, 'POLITICAS_PRIVACIDAD', 1, 'Políticas de Privacidad', 'http://coneypark.pe/recargas/politicas-privacidad', '<p style="text-align:justify"><span style="font-size:22px"><span style="color:rgb(128, 0, 128)"><strong>POLITICA DE TRATAMIENTO DE DATOS PERSONALES</strong></span></span></p>

<p style="text-align:justify">Gracias por acceder a la p&aacute;gina web&nbsp;www.coneypark.pe&nbsp;(el &quot;Sitio&quot;) operada por ATRACCIONES CONEY ISLAND S.A.C. &nbsp;Nosotros respetamos su privacidad y su informaci&oacute;n personal. La presente pol&iacute;tica forma parte de uso del Sitio.</p>

<p style="text-align:justify">Nuestra Pol&iacute;tica de Privacidad explica c&oacute;mo recolectamos, utilizamos y (bajo ciertas condiciones) divulgamos su informaci&oacute;n personal. Esta Pol&iacute;tica de Privacidad tambi&eacute;n explica las medidas que hemos tomado para asegurar su informaci&oacute;n personal. Por &uacute;ltimo, esta pol&iacute;tica de privacidad explica los procedimientos que seguimos frente a la recopilaci&oacute;n, uso y divulgaci&oacute;n de su informaci&oacute;n personal.</p>

<p style="text-align:justify">La protecci&oacute;n de datos es una cuesti&oacute;n de confianza y privacidad, por ello es importante para nosotros. Por lo tanto, utilizaremos solamente su nombre y la informaci&oacute;n referente a Ud. bajo los t&eacute;rminos previstos en nuestra Pol&iacute;tica de Privacidad.</p>

<p style="text-align:justify">S&oacute;lo mantendremos su informaci&oacute;n durante el tiempo que nos sea requerido por la ley o debido a la relevancia de los propios fines para los que fueron recopilados.</p>

<p style="text-align:justify">Ud. puede visitar el sitio y navegar sin tener que proporcionar datos personales. Durante su visita al sitio, Ud. permanecer&aacute; an&oacute;nimo y en ning&uacute;n momento podremos identificarlo, a menos que Ud. tenga una cuenta en el sitio e inicie sesi&oacute;n con su nombre de usuario y contrase&ntilde;a.</p>

<p style="text-align:justify"><span style="font-size:18px"><span style="color:rgb(128, 0, 128)"><strong>COOKIES</strong></span></span></p>

<p style="text-align:justify">La aceptaci&oacute;n de las cookies no es un requisito para visitar el Sitio. Sin embargo, nos gustar&iacute;a se&ntilde;alar que el uso de la funcionalidad &quot;mi carrito&quot; en el Sitio y la de aceptar una orden s&oacute;lo es posible con la activaci&oacute;n de las cookies. Las cookies son peque&ntilde;os archivos de texto que identifican a su computadora en nuestro servidor como un usuario &uacute;nico. Las cookies se pueden utilizar para reconocer su direcci&oacute;n de protocolo de Internet, lo que le ahorrar&aacute; tiempo mientras se encuentra en el Sitio o si quiere entrar a &eacute;l en el futuro.</p>

<p style="text-align:justify">S&oacute;lo utilizamos cookies para su comodidad en el uso del Sitio (por ejemplo, para recordar qui&eacute;n es Ud. cuando se desea modificar su carrito de compras sin tener que volver a introducir su direcci&oacute;n de correo electr&oacute;nico) y no para obtener o usar cualquier otra informaci&oacute;n sobre Ud. (por ejemplo de publicidad segmentada u oculta). Su navegador puede ser configurado para no aceptar cookies, pero esto podr&iacute;a restringir su uso del Sitio y limitar su experiencia en el mismo. El uso de cookies no contiene ni afecta datos de car&aacute;cter personal o privado y no representa peligro de virus. Si desea obtener m&aacute;s informaci&oacute;n acerca de las cookies, vaya a http://www.allaboutcookies.org o para obtener informaci&oacute;n sobre la eliminaci&oacute;n de ellos desde el navegador, visite&nbsp;http://www.allaboutcookies.org/manage-cookies/index.html.</p>

<p style="text-align:justify"><span style="font-size:18px"><span style="color:rgb(128, 0, 128)"><strong>SEGURIDAD</strong></span></span></p>

<p style="text-align:justify">Tenemos en marcha medidas t&eacute;cnicas y de seguridad para evitar el acceso no autorizado o ilegal o la p&eacute;rdida accidental, destrucci&oacute;n u ocurrencia de da&ntilde;os a su informaci&oacute;n. Cuando se recogen datos a trav&eacute;s del Sitio, recogemos sus datos personales en un servidor seguro. Nosotros usamos programas de protecci&oacute;n en nuestros servidores. Cuando recopilamos informaci&oacute;n de tarjetas de pago electr&oacute;nico, se utilizan sistemas de cifrado Secure Socket Layer (SSL) que codifica la misma evitando usos fraudulentos.</p>

<p style="text-align:justify">Si bien no es posible garantizar la consecuci&oacute;n de un resultado estos sistemas han probado ser efectivos en el manejo de informaci&oacute;n reservada, toda vez que cuentan con mecanismos que impiden el acceso de amenazas externas (i.e. hackers). Se recomienda no enviar todos los detalles de tarjetas de cr&eacute;dito o d&eacute;bito sin cifrar las comunicaciones electr&oacute;nicas con nosotros. Mantenemos las salvaguardias f&iacute;sicas, electr&oacute;nicas y de procedimiento en relaci&oacute;n con la recolecci&oacute;n, almacenamiento y divulgaci&oacute;n de su informaci&oacute;n. Nuestros procedimientos de seguridad exigen que en ocasiones podamos solicitarle una prueba de identidad antes de revelar informaci&oacute;n personal. Tenga en cuenta que Ud. es el &uacute;nico responsable de la protecci&oacute;n contra el acceso no autorizado a su contrase&ntilde;a y a su computadora.</p>

<p style="text-align:justify"><strong><span style="font-size:18px"><span style="color:rgb(128, 0, 128)">DEFINICIONES</span></span></strong></p>

<p style="text-align:justify">Para efectos de la presente pol&iacute;tica, las palabras que a continuaci&oacute;n se definen tendr&aacute;n el significado asignado en este cap&iacute;tulo, sea que se escriban en min&uacute;sculas o no en may&uacute;sculas, o que se encuentren en plural o singular.</p>

<p style="text-align:justify"><span style="font-size:14px"><span style="color:rgb(128, 0, 128)"><strong>a) Autorizaci&oacute;n:</strong></span></span> Consentimiento previo, expreso e informado del titular para llevar a cabo el Tratamiento de Datos Personales.</p>

<p style="text-align:justify"><span style="font-size:14px"><strong><span style="color:rgb(128, 0, 128)">b) Aviso de Privacidad:</span></strong></span> Documento f&iacute;sico, electr&oacute;nico o en cualquier otro formato, generado por el Responsable del Tratamiento, que es puesto a disposici&oacute;n del Titular para el Tratamiento de sus Datos Personales, el cual comunica al Titular la informaci&oacute;n relativa a la existencia de las pol&iacute;ticas de tratamiento de informaci&oacute;n que le ser&aacute;n aplicables, la forma de acceder a las mismas y las caracter&iacute;sticas del Tratamiento que se pretende dar a los datos personales.</p>

<p style="text-align:justify"><span style="font-size:14px"><span style="color:rgb(128, 0, 128)"><strong>c) Coney Park o Responsable:</strong></span></span> ATRACCIONES CONEY ISLAND S.A.C. Dato Personal: Cualquier informaci&oacute;n vinculada o que pueda asociarse a una o varias personas naturales determinadas o determinables.</p>

<p style="text-align:justify"><span style="font-size:14px"><span style="color:rgb(128, 0, 128)"><strong>e) Datos Sensibles:</strong></span></span> Se entiende por datos sensibles aquellos que afectan la intimidad del Titular o cuyo uso indebido puede generar su discriminaci&oacute;n, tales como aquellos que revelen el origen racial o &eacute;tnico, la orientaci&oacute;n pol&iacute;tica, las convicciones religiosas o filos&oacute;ficas, la pertenencia a sindicatos, organizaciones sociales, de derechos humanos o que promueva intereses de cualquier partido pol&iacute;tico o que garanticen los derechos y garant&iacute;as de partidos pol&iacute;ticos de oposici&oacute;n as&iacute; como los datos relativos a la salud, a la vida sexual y los datos biom&eacute;tricos, entre otros.</p>

<p style="text-align:justify"><span style="font-size:14px"><span style="color:rgb(128, 0, 128)"><strong>f) Encargado del Tratamiento:</strong></span></span> Persona natural o jur&iacute;dica, p&uacute;blica o privada, que por s&iacute; misma o en asocio con otros, realice el Tratamiento de Datos Personales por cuenta del Responsable del Tratamiento de Datos Personales.</p>

<p style="text-align:justify"><span style="color:#800080"><span style="font-size:14px"><strong>g) Responsable del Tratamiento: </strong></span></span>Persona natural o jur&iacute;dica, p&uacute;blica o privada, que por s&iacute; misma o en asocio con otros, decida sobre la base de datos y/o el Tratamiento de los datos.</p>

<p style="text-align:justify"><span style="font-size:14px"><span style="color:rgb(128, 0, 128)"><strong>h) Titular:</strong></span></span> Persona natural cuyos datos personales sean objeto de Tratamiento.</p>

<p style="text-align:justify"><span style="font-size:14px"><span style="color:rgb(128, 0, 128)"><strong>i) Tratamiento de Datos Personales:</strong></span></span> Cualquier operaci&oacute;n o conjunto de operaciones sobre Datos Personales, tales como la recolecci&oacute;n, almacenamiento, uso, circulaci&oacute;n o supresi&oacute;n.</p>

<p style="text-align:justify">&nbsp;</p>

<p style="text-align:justify"><span style="color:#800080"><span style="font-size:20px"><strong>II. NORMAS Y CRITERIOS DE APLICACI&Oacute;N</strong></span></span></p>

<p style="text-align:justify"><span style="font-size:18px"><span style="color:rgb(128, 0, 128)"><strong>1. PRINCIPIOS GENERALES PARA EL TRATAMIENTO DE DATOS PERSONALES</strong></span></span></p>

<p style="text-align:justify">En el Tratamiento de Datos Personales se cumplir&aacute; con los siguientes principios:</p>

<p style="text-align:justify"><span style="font-size:14px"><span style="color:rgb(128, 0, 128)"><strong>Principio de finalidad:</strong></span></span>&nbsp;El Tratamiento de Datos Personales debe obedecer a una finalidad leg&iacute;tima que se informar&aacute; al Titular.</p>

<p style="text-align:justify"><strong><span style="color:#800080"><span style="font-size:14px">Principio de libertad:&nbsp;</span></span></strong>El Tratamiento de Datos Personales s&oacute;lo puede ejercerse con el consentimiento, previo, expreso e informado del Titular. Los Datos Personales no podr&aacute;n ser obtenidos o divulgados sin previa autorizaci&oacute;n, o en ausencia de mandato legal o judicial que releve el consentimiento del Titular.<br />
Principio de veracidad o calidad:&nbsp;La informaci&oacute;n sujeta a tratamiento debe ser veraz, completa, exacta, actualizada, comprobable y comprensible. Se proh&iacute;be el Tratamiento de datos parciales, incompletos, fraccionados o que induzcan a error.</p>

<p style="text-align:justify"><span style="font-size:14px"><span style="color:rgb(128, 0, 128)"><strong>Principio de transparencia:&nbsp;</strong></span></span>En el Tratamiento debe garantizarse el derecho del Titular a obtener de Coney Park, en cualquier momento y sin restricciones, informaci&oacute;n acerca de la existencia de datos que le conciernan.</p>

<p style="text-align:justify"><span style="font-size:14px"><span style="color:rgb(128, 0, 128)"><strong>Principio de acceso y circulaci&oacute;n restringida:&nbsp;</strong></span></span>Los Datos Personales, salvo la informaci&oacute;n p&uacute;blica, no podr&aacute;n estar disponibles en Internet u otros medios de divulgaci&oacute;n o comunicaci&oacute;n masiva, salvo que el acceso sea t&eacute;cnicamente controlable para brindar un conocimiento restringido s&oacute;lo a los Titulares o terceros autorizados por aqu&eacute;l.</p>

<p style="text-align:justify"><span style="color:#800080"><span style="font-size:14px"><strong>Principio de seguridad:&nbsp;</strong></span></span>La informaci&oacute;n sujeta a Tratamiento, se deber&aacute; manejar con las medidas t&eacute;cnicas, humanas y administrativas que sean necesarias para otorgar seguridad a los registros evitando su adulteraci&oacute;n, p&eacute;rdida, consulta, uso o acceso no autorizado o fraudulento.</p>

<p style="text-align:justify"><strong><span style="font-size:14px"><span style="color:rgb(128, 0, 128)">Principio de confidencialidad:&nbsp;</span></span></strong>Todas las personas que intervengan en el Tratamiento de Datos Personales est&aacute;n obligadas a garantizar la reserva de la informaci&oacute;n, inclusive despu&eacute;s de finalizada su relaci&oacute;n con alguna de las labores que comprende el tratamiento.</p>

<p style="text-align:justify"><span style="font-size:18px"><span style="color:rgb(128, 0, 128)"><strong>2. TRATAMIENTO AL CUAL SER&Aacute;N SOMETIDOS LOS DATOS Y FINALIDAD DEL MISMO</strong></span></span></p>

<p style="text-align:justify"><span style="font-size:18px"><span style="color:rgb(128, 0, 128)"><strong>TERCEROS Y ENLACES</strong></span></span></p>

<p style="text-align:justify">Coney Park podr&aacute; transferir y/o transmitir los datos personales sujetos a tratamiento a compa&ntilde;&iacute;as que hagan parte de su grupo empresarial, esto es, a compa&ntilde;&iacute;as matrices, filiales o subsidiarias. Tambi&eacute;n podemos proporcionar su informaci&oacute;n a nuestros agentes y subcontratistas para que nos ayuden con cualquiera de las funciones mencionadas en nuestra Pol&iacute;tica de Privacidad. Por ejemplo, podemos utilizar a terceros para que nos ayuden con la entrega de promoci&oacute;n de productos, recaudar sus pagos, brindar servicios o tercerizar nuestros sistemas de servicio al cliente. Podemos intercambiar informaci&oacute;n con terceros a efectos de protecci&oacute;n contra el fraude y la reducci&oacute;n de riesgo de cr&eacute;dito. Podemos transferir nuestras bases de datos que contienen su informaci&oacute;n personal si vendemos nuestro negocio o parte de este. Al margen de lo establecido en la presente Pol&iacute;tica de Privacidad, no podremos vender o divulgar sus datos personales a terceros sin obtener su consentimiento previo, a menos que sea necesario para los fines establecidos en esta Pol&iacute;tica de Privacidad o estemos obligados a hacerlo por ley. El Sitio puede contener publicidad de terceros y enlaces a otros sitios o marcos de otros sitios. Tenga en cuenta que no somos responsables de las pr&aacute;cticas de privacidad o contenido de dichos terceros u otros sitios, ni por cualquier tercero a quien se transfieran sus datos de acuerdo con nuestra Pol&iacute;tica de Privacidad.<br />
Teniendo en cuenta lo anterior los datos Personales ser&aacute;n utilizados por Coney Park para:</p>

<p style="text-align:justify"><span style="color:#800080"><span style="font-size:14px"><strong>a) </strong></span></span>Proveer servicios y productos requeridos.</p>

<p style="text-align:justify"><strong><span style="font-size:14px"><span style="color:rgb(128, 0, 128)">b) </span></span></strong>Informar sobre nuevos productos o servicios que est&eacute;n relacionados o no, con el contratado o adquirido por el Titular.</p>

<p style="text-align:justify"><span style="font-size:14px"><span style="color:rgb(128, 0, 128)"><strong>c)</strong></span></span> Dar cumplimiento a obligaciones contra&iacute;das con el Titular.</p>

<p style="text-align:justify"><span style="font-size:14px"><span style="color:rgb(128, 0, 128)"><strong>d)</strong></span></span> Informar sobre cambios en productos o servicios.</p>

<p style="text-align:justify"><span style="font-size:14px"><strong><span style="color:rgb(128, 0, 128)">e) </span></strong></span>Evaluar la calidad de productos o servicios.</p>

<p style="text-align:justify"><span style="font-size:14px"><span style="color:rgb(128, 0, 128)"><strong>f)</strong></span></span> Desarrollar actividades de mercadeo o promocionales.</p>

<p style="text-align:justify"><span style="font-size:14px"><span style="color:rgb(128, 0, 128)"><strong>g)</strong></span></span> Enviar al correo f&iacute;sico, electr&oacute;nico, celular o dispositivo m&oacute;vil, - v&iacute;a mensajes de texto (SMS y/o MMS) informaci&oacute;n comercial, publicitaria o promocional sobre los productos y/o servicios, eventos y/o promociones de tipo comercial o no de estas, con el fin de impulsar, invitar, dirigir, ejecutar, informar y de manera general, llevar a cabo campa&ntilde;as, promociones o concursos de car&aacute;cter comercial o publicitario.</p>

<p style="text-align:justify"><span style="font-size:14px"><span style="color:rgb(128, 0, 128)"><strong>h)</strong></span></span> Compartir, incluyendo la transferencia y transmisi&oacute;n de datos personales a terceros para fines relacionados con la operaci&oacute;n de Coney Park.</p>

<p style="text-align:justify"><span style="color:#800080"><span style="font-size:14px"><strong>i)</strong></span></span> Realizar estudios internos sobre el cumplimiento de las relaciones comerciales y estudios de mercado a todo nivel.</p>

<p style="text-align:justify"><span style="font-size:14px"><span style="color:rgb(128, 0, 128)"><strong>j)</strong></span></span> Responder requerimientos legales de entidades administrativas y judiciales.</p>

<p style="text-align:justify"><span style="color:#800080"><span style="font-size:18px"><strong>3. AUTORIZACIONES</strong></span></span></p>

<p style="text-align:justify">El Tratamiento de Datos Personales realizados por Coney Park, requiere del consentimiento libre, previo, expreso e informado del Titular de dichos datos. Coney Park, en su condici&oacute;n de Responsable del Tratamiento de Datos Personales, ha dispuesto de los mecanismos necesarios para obtener la autorizaci&oacute;n de los titulares garantizando en todo caso que sea posible verificar el otorgamiento de dicha autorizaci&oacute;n.</p>

<p style="text-align:justify">La autorizaci&oacute;n podr&aacute; darse verbalmente y/o por medio de un documento f&iacute;sico, electr&oacute;nico o cualquier otro formato que permita garantizar su posterior consulta. En cualquier caso la autorizaci&oacute;n debe ser dada por el Titular y en &eacute;sta se debe poder verificar que &eacute;ste conoce y acepta que Coney Park recoger&aacute; y utilizar&aacute; la informaci&oacute;n para los fines que para el efecto se le d&eacute; a conocer de manera previa al otorgamiento de la autorizaci&oacute;n.</p>

<p style="text-align:justify">En virtud de lo anterior, la autorizaci&oacute;n solicitada deber&aacute; incluir:</p>

<p style="text-align:justify"><span style="font-size:14px"><span style="color:rgb(128, 0, 128)"><strong>a)</strong></span></span> Responsable del Tratamiento y qu&eacute; datos se recopilan;</p>

<p style="text-align:justify"><span style="font-size:14px"><span style="color:rgb(128, 0, 128)"><strong>b)</strong></span></span> La finalidad del tratamiento de los datos;</p>

<p style="text-align:justify"><span style="font-size:14px"><span style="color:rgb(128, 0, 128)"><strong>c) </strong></span></span>Los derechos de acceso, correcci&oacute;n, actualizaci&oacute;n o supresi&oacute;n de los datos personales suministrados por el titular y,</p>

<p style="text-align:justify"><span style="font-size:14px"><span style="color:rgb(128, 0, 128)"><strong>d)</strong></span></span> Si se recopilan Datos Sensibles,</p>

<p style="text-align:justify"><span style="font-size:14px"><span style="color:rgb(128, 0, 128)"><strong>e) </strong></span></span>Adicionalmente se le informar&aacute; al Titular (i) que no se encuentra obligado a autorizar el tratamiento, y (ii) que es facultativo entregar este tipo de informaci&oacute;n.</p>

<p style="text-align:justify"><span style="font-size:18px"><span style="color:rgb(128, 0, 128)"><strong>4. PROCEDIMIENTO PARA EL EJERCICIO DE LOS DERECHOS DE CONOCER, ACTUALIZAR, RECTIFICAR Y SUPRIMIR INFORMACION Y REVOCAR LA AUTORIZACI&Oacute;N</strong></span></span></p>

<p style="text-align:justify">Los Titulares de los Datos Personales podr&aacute;n en cualquier momento solicitarle al Responsable del Tratamiento qu&eacute; informaci&oacute;n de ellos se conserva, as&iacute; como solicitar la actualizaci&oacute;n ratificaci&oacute;n o supresi&oacute;n de dicha informaci&oacute;n, usando los medios descritos en el numeral 7 de la presente pol&iacute;tica. Adicionalmente podr&aacute;n revocar la autorizaci&oacute;n otorgada.</p>

<p style="text-align:justify">La solicitud de supresi&oacute;n de la informaci&oacute;n y la revocatoria de la autorizaci&oacute;n no proceder&aacute;n cuando el Titular tenga un deber legal, contractual o comercial de permanecer en la base de datos.<br />
Con dicho fin, el Titular de la informaci&oacute;n a trav&eacute;s de los diferentes medios predeterminados por Coney Park en el numeral 7) realizar&aacute; el reclamo indicando su n&uacute;mero de identificaci&oacute;n, los datos de contacto y aportando la documentaci&oacute;n pertinente que pretenda hacer valer. S&iacute; Coney Park estima que para el an&aacute;lisis de la solicitud requiere mayor informaci&oacute;n de parte del Titular, proceder&aacute; a comunicar tal situaci&oacute;n dentro de los siete (7) d&iacute;as h&aacute;biles siguientes de recibida la solicitud. Transcurridos diez (10) d&iacute;as h&aacute;biles desde la fecha del requerimiento, sin que el solicitante presente la informaci&oacute;n requerida, se tendr&aacute; por no presentado el reclamo.</p>

<p style="text-align:justify">El t&eacute;rmino m&aacute;ximo para atender el reclamo ser&aacute; de diez (10) quince (15) d&iacute;as h&aacute;biles contados a partir del d&iacute;a siguiente a la fecha de su recibo. Cuando no fuere posible atenderlo dentro de dicho t&eacute;rmino se informar&aacute; al interesado antes del vencimiento del referido plazo los motivos de la demora y la fecha en que se atender&aacute; su reclamo, la cual en ning&uacute;n caso podr&aacute; superar los diez (10) d&iacute;as h&aacute;biles siguientes al vencimiento del primer t&eacute;rmino.</p>

<p style="text-align:justify"><br />
<span style="font-size:18px"><span style="color:rgb(128, 0, 128)"><strong>5. DERECHOS Y DEBERES DE LOS TITULARES</strong></span></span></p>

<p style="text-align:justify">El Titular de los Datos Personales tendr&aacute; los siguientes derechos:</p>

<p style="text-align:justify"><span style="font-size:14px"><span style="color:rgb(128, 0, 128)"><strong>a)</strong></span></span> Conocer, actualizar y rectificar los Datos Personales.</p>

<p style="text-align:justify"><span style="font-size:14px"><span style="color:rgb(128, 0, 128)"><strong>b) </strong></span></span>Solicitar pruebas de la autorizaci&oacute;n otorgada a Coney Park.</p>

<p style="text-align:justify"><span style="font-size:14px"><span style="color:rgb(128, 0, 128)"><strong>c)</strong></span></span> Ser informado por Coney Park, previa solicitud, respecto del uso que le ha dado a sus Datos Personales.</p>

<p style="text-align:justify"><span style="color:#800080"><span style="font-size:14px"><strong>d)</strong></span></span> Presentar consultas ante el Responsable o Encargado del Tratamiento, conforme a lo establecido en el numeral 3 de la presente pol&iacute;tica, e interponer quejas ante el Tribunal Constitucional.</p>

<p style="text-align:justify"><span style="font-size:14px"><span style="color:rgb(128, 0, 128)"><strong>e)</strong></span></span> Acceder de manera gratuita a los Datos Personales que son objeto de Tratamiento en los t&eacute;rminos de la Ley y Reglamento de Protecci&oacute;n de Datos Personales.</p>

<p style="text-align:justify">El Titular de los Datos Personales tendr&aacute; el deber de mantener actualizada su informaci&oacute;n y garantizar, en todo momento, la veracidad de la misma. Coney Park no se har&aacute; responsable, en ning&uacute;n caso, por cualquier tipo de responsabilidad derivada por la inexactitud de la informaci&oacute;n.</p>

<p style="text-align:justify"><span style="font-size:18px"><span style="color:rgb(128, 0, 128)"><strong>6. MEDIDAS DE SEGURIDAD</strong></span></span></p>

<p style="text-align:justify">Coney Park adoptar&aacute; las medidas t&eacute;cnicas, humanas y administrativas que sean necesarias para otorgar seguridad a los registros evitando su adulteraci&oacute;n, p&eacute;rdida, consulta, uso o acceso no autorizado o fraudulento. Dichas medidas responder&aacute;n a los requerimientos m&iacute;nimos hechos por la legislaci&oacute;n vigente y peri&oacute;dicamente se evaluar&aacute; su efectividad.</p>

<p style="text-align:justify"><br />
<span style="font-size:18px"><span style="color:rgb(128, 0, 128)"><strong>7. RESPONSABLE Y CONTACTO</strong></span></span></p>

<p style="text-align:justify">Coney Park estar&aacute; encargada de la recolecci&oacute;n y el Tratamiento de Datos Personales, la Autorizaci&oacute;n y los registros almacenados, en todos los casos, impidiendo que se deterioren, pierdan, alteren o se usen sin autorizaci&oacute;n y conservarlos con la debida seguridad.</p>

<p style="text-align:justify">El &aacute;rea de servicio al cliente estar a cargo de atender las peticiones, quejas y consultas de los titulares de los dato y los Titulares de la Informaci&oacute;n pueden ejercer sus derechos de conocer, actualizar, rectificar y suprimir sus Datos Personales, enviando comunicaciones al &nbsp;Calle Chamaya 175 3er piso Urbanizaci&oacute;n Pando San Miguel, al correo electr&oacute;nico contacto@coneyparkperu.com o al tel&eacute;fono (01)451-7173.</p>

<p style="text-align:justify"><br />
<span style="font-size:18px"><span style="color:rgb(128, 0, 128)"><strong>8. ENTRADA EN VIGENCIA MODIFICACI&Oacute;N Y PERIODO DE VIGENCIA DE LAS BASES DE DATOS</strong></span></span></p>

<p style="text-align:justify">La informaci&oacute;n suministrada por los grupos de inter&eacute;s permanecer&aacute; almacenada hasta por el t&eacute;rmino de cinco (5) a&ntilde;os contados a partir de la fecha del &uacute;ltimo Tratamiento, para permitirnos el cumplimiento de las obligaciones legales y/o contractuales a su cargo especialmente en materia contable, fiscal y tributaria.<br />
Esta pol&iacute;tica podr&aacute; ser modificada en cualquier momento y de forma unilateral por parte de Coney Park, siempre teniendo en consideraci&oacute;n la protecci&oacute;n de datos personales de nuestros usuarios y de conformidad con la legislaci&oacute;n aplicable.</p>

<p style="text-align:justify"><br />
<span style="color:#800080"><span style="font-size:18px"><strong>9.&nbsp;AUTORIDAD</strong></span></span></p>

<p style="text-align:justify">Si el usuario/cliente considera que han sido vulnerados sus derechos respecto de la protecci&oacute;n de datos personales, tiene el derecho de acudir a la autoridad correspondiente para defender su ejercicio. La autoridad es la Autoridad Nacional de Protecci&oacute;n de Datos Personales (APDP) solicitando la tutela de sus derechos, su sitio web es http://www.minjus.gob.pe/proteccion-de-datos-personales/.</p>
', 1, now(), null);


INSERT INTO orden_orden (`id`,`codigo`,`usuario_id`,`comprobante_tipo`,`fac_razon_social`,`documento_tipo`,`documento_numero`,`fac_direccion_fiscal`,`fac_direccion_entrega_factura`,`nombres`,`paterno`,`materno`,`ciudadania`,`direccion`,`pais_id`,`distrito_id`,`pago_referencia`,`pan`,`pago_metodo`,`pago_estado`,`monto`,`estado`,`fecha_creacion`,`fecha_edicion`,`pago_error`,`pago_error_detalle`,`pago_fecha_confirmacion`,`pago_cip`,`pago_token`,`moneda`)
  VALUES (1000,'000001000',4,1,NULL,2,'44332211','Av. Carcamo','Av. Carcamo','Angel','Jara','Vilca',null,'Av. Carcamo',1,300,'99999999999','8838*****77621','VISA','PAGADO',10.2,1,now(),null,'','',now(),null,null,'PEN');

INSERT INTO orden_orden (`id`,`codigo`,`usuario_id`,`comprobante_tipo`,`fac_razon_social`,`documento_tipo`,`documento_numero`,`fac_direccion_fiscal`,`fac_direccion_entrega_factura`,`nombres`,`paterno`,`materno`,`ciudadania`,`direccion`,`pais_id`,`distrito_id`,`pago_referencia`,`pan`,`pago_metodo`,`pago_estado`,`monto`,`estado`,`fecha_creacion`,`fecha_edicion`,`pago_error`,`pago_error_detalle`,`pago_fecha_confirmacion`,`pago_cip`,`pago_token`,`moneda`)
  VALUES (1001,'000001000',4,1,NULL,2,'44332211','Av. Carcamo','Av. Carcamo','Angel','Jara','Vilca',null,'Av. Carcamo',1,300,'99999999999','8838*****77621','VISA','ERROR',10.2,1,now(),null,'','Error 500, por favor inténtelo más tarde.',now(),null,null,'PEN');

INSERT INTO `orden_detalle_orden` (`id`,`paquete_id`,`orden_id`,`tarjeta_id`,`emoney`,`bonus`,`promotionbonus`,`etickets`,`gamepoints`,`monto`,`fecha_creacion`,`fecha_edicion`,`cantidad`,`recarga_cantidad`,`recarga_error`)
 VALUES (1000,6,1000,11,10,12,13,10,2,23,now(),null,1,NULL,'');

INSERT INTO `orden_detalle_orden` (`id`,`paquete_id`,`orden_id`,`tarjeta_id`,`emoney`,`bonus`,`promotionbonus`,`etickets`,`gamepoints`,`monto`,`fecha_creacion`,`fecha_edicion`,`cantidad`,`recarga_cantidad`,`recarga_error`)
 VALUES (1001,6,1001,11,10,12,13,10,2,23,now(),null,1,NULL,'');