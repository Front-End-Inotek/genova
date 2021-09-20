-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `nombre_comercial` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `direccion` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `ciudad` varchar(30) CHARACTER SET utf8mb4 DEFAULT NULL,
  `estado` varchar(30) CHARACTER SET utf8mb4 DEFAULT NULL,
  `codigo_postal` int(11) DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 DEFAULT NULL,
  `correo` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `rfc` varchar(30) CHARACTER SET utf8mb4 DEFAULT NULL,
  `curp` varchar(30) CHARACTER SET utf8mb4 DEFAULT NULL,
  `estado_cliente` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cliente` (`id`, `nombre`, `nombre_comercial`, `direccion`, `ciudad`, `estado`, `codigo_postal`, `telefono`, `correo`, `rfc`, `curp`, `estado_cliente`) VALUES
(1,	'Kenworth',	'Kenworth',	'Av. Vallartra',	'Granja',	'Jalisco',	45029,	'151456',	'Kenworth@hotmail.com',	'jdfe38873783',	'jdfe38873783as',	1),
(2,	'no',	'no',	'di',	'ci',	'es',	22,	'33',	'@',	'12',	'33',	1),
(3,	'Prueba',	'Probando',	'1',	'1',	'1',	1,	'1',	'1',	'1',	'1',	1),
(4,	'Probando22',	'22',	'2',	'2',	'2',	2,	'2',	'2',	'2',	'2',	1),
(5,	'Probando22',	'2',	'2',	'2',	'2',	2,	'2',	'2',	'2',	'2',	1),
(6,	'Otro',	'1',	'1',	'1',	'1',	1,	'1',	'1',	'1',	'1',	1),
(7,	'Otro',	'8',	'8',	'8',	'8',	8,	'8',	'8',	'8',	'8',	1),
(8,	'Mas',	'2',	'2',	'2',	'2',	2,	'2',	'2',	'2',	'2',	1),
(9,	'Torre',	'58',	'58',	'8',	'8',	6,	'8',	'88',	'8',	'5',	1),
(10,	'Codificando',	'Code',	'Los Molinos',	'La Molienda',	'8',	8,	'8',	'8',	'8',	'8',	1),
(11,	'Main',	'88',	'8',	'88',	'8',	88,	'8',	'88',	'8',	'88',	1);

DROP TABLE IF EXISTS `configuracion`;
CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activacion` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `configuracion` (`id`, `activacion`, `nombre`) VALUES
(1,	1766951435,	'Sighersa');

DROP TABLE IF EXISTS `cotizaciones`;
CREATE TABLE `cotizaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `vigencia` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `abierto` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cotizaciones` (`id`, `id_usuario`, `id_cliente`, `fecha`, `vigencia`, `abierto`, `estado`) VALUES
(1,	3,	2,	'1611163119',	'1611163000',	1,	1),
(2,	10,	11,	'1611163266',	'1609480800',	1,	1),
(3,	3,	1,	'1611163398',	'1611295200',	1,	1),
(4,	9,	10,	'1611166493',	'1611381600',	1,	1),
(5,	11,	1,	'1611181372',	'1610690400',	1,	1),
(6,	11,	11,	'1611181843',	'1611122400',	1,	1),
(7,	3,	10,	'1611345096',	'1611122400',	0,	0),
(8,	3,	9,	'1611586358',	'1611986400',	1,	1),
(9,	10,	1,	'1611587127',	'1611727200',	1,	1),
(10,	10,	2,	'1611587397',	'1609480800',	1,	1);

DROP TABLE IF EXISTS `inventario`;
CREATE TABLE `inventario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `modelo` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `numero_parte` varchar(30) CHARACTER SET utf8mb4 NOT NULL,
  `descripcion` tinytext CHARACTER SET utf8mb4 NOT NULL,
  `cantidad` int(11) NOT NULL,
  `costo_unitario` double NOT NULL,
  `costo_total` double NOT NULL,
  `rack` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `estante` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `acomulado` double NOT NULL,
  `minimos` int(11) NOT NULL,
  `maximos` int(11) NOT NULL,
  `unidad_medida` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `desperdicio` int(11) NOT NULL,
  `bodega` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `inventario` (`id`, `nombre`, `modelo`, `numero_parte`, `descripcion`, `cantidad`, `costo_unitario`, `costo_total`, `rack`, `estante`, `acomulado`, `minimos`, `maximos`, `unidad_medida`, `desperdicio`, `bodega`, `estado`) VALUES
(1,	'Torre',	'',	'',	'',	-4,	12,	-48,	'',	'',	17,	0,	0,	'',	0,	0,	1),
(2,	'Maquina',	'1528',	'R1523',	'Electromagnetica',	-21,	1200,	-25200,	'A',	'29',	25,	0,	0,	'Unidades',	0,	0,	1),
(3,	'Tornillos',	'5',	'5',	'5',	3,	5,	15,	'5',	'5',	2,	0,	0,	'5',	5,	5,	1),
(4,	'Probando',	'j',	'j',	'j',	-37,	1,	-37,	'1',	'1',	38,	0,	0,	'1',	1,	1,	1),
(5,	'Tiner',	'ase3',	'321',	'50%',	10,	350,	3500,	'S',	'25',	0,	0,	0,	'litros',	1,	2,	1),
(6,	'Lata1',	'666',	'666',	'666',	657,	666,	437562,	'666',	'666',	675,	666,	666,	'666',	666,	666,	1),
(7,	'Pijas',	'4',	'4',	'4',	-20,	8,	-160,	'4',	'4',	28,	4,	4,	'4',	4,	4,	1),
(8,	'Main',	'88',	'88',	'8',	53,	8,	424,	'88',	'8',	123,	88,	8,	'88',	8,	89,	1),
(9,	'Tuercas',	'6',	'6',	'6',	-15,	6,	-90,	'6',	'6',	73,	6,	6,	'6',	6,	6,	1);

DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` int(11) NOT NULL,
  `hora` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `ip` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `actividad` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `logs` (`id`, `usuario`, `hora`, `ip`, `actividad`) VALUES
(215,	2,	'1611598519',	'::1',	'Borrar cotizacion: 1'),
(216,	2,	'1611598557',	'::1',	'Borrar cotizacion: 3'),
(217,	2,	'1611598633',	'::1',	'Borrar cotizacion: 7'),
(218,	2,	'1611598768',	'::1',	'Borrar requisicion: 11'),
(219,	2,	'1611674829',	'::1',	'Agregar salida: 11'),
(220,	2,	'1611675377',	'::1',	'Agregar salida: 11'),
(221,	2,	'1611675581',	'::1',	'Agregar salida: 11'),
(222,	2,	'1611675692',	'::1',	'Agregar salida: 11'),
(223,	2,	'1611675815',	'::1',	'Agregar salida: 11'),
(224,	2,	'1611675896',	'::1',	'Agregar salida: 11'),
(225,	2,	'1611675954',	'::1',	'Agregar salida: 11'),
(226,	2,	'1611676025',	'::1',	'Agregar salida: 11'),
(227,	2,	'1611676134',	'::1',	'Agregar salida: 11'),
(228,	2,	'1611676388',	'::1',	'Agregar salida: 11'),
(229,	2,	'1611676902',	'::1',	'Agregar salida: 11'),
(230,	2,	'1611677285',	'::1',	'Agregar salida: 11'),
(231,	2,	'1611677358',	'::1',	'Agregar salida: 11'),
(232,	2,	'1611677807',	'::1',	'Agregar salida: 11'),
(233,	2,	'1611677900',	'::1',	'Agregar salida: 11'),
(234,	2,	'1611677993',	'::1',	'Agregar salida: 11'),
(235,	2,	'1611678292',	'::1',	'Agregar salida: 11'),
(236,	2,	'1611678538',	'::1',	'Borrar salida: 23'),
(237,	2,	'1611678541',	'::1',	'Borrar salida: 22'),
(238,	2,	'1611678543',	'::1',	'Borrar salida: 21'),
(239,	2,	'1611678546',	'::1',	'Borrar salida: 20'),
(240,	2,	'1611678548',	'::1',	'Borrar salida: 19'),
(241,	2,	'1611678550',	'::1',	'Borrar salida: 18'),
(242,	2,	'1611678552',	'::1',	'Borrar salida: 17'),
(243,	2,	'1611678555',	'::1',	'Borrar salida: 16'),
(244,	2,	'1611678559',	'::1',	'Borrar salida: 7'),
(245,	2,	'1611679221',	'::1',	'Agregar salida: 11'),
(246,	2,	'1611681267',	'::1',	'Borrar salida: 4'),
(247,	2,	'1611681272',	'::1',	'Borrar salida: 3'),
(248,	2,	'1611862451',	'::1',	'Inicio de session el usuario: 2'),
(249,	2,	'1611862451',	'::1',	'Inicio de session'),
(250,	2,	'1611875757',	'::1',	'Agregar material salido: 8'),
(251,	2,	'1611875891',	'::1',	'Agregar material salido: 8'),
(252,	2,	'1611876106',	'::1',	'Agregar material salido: 7'),
(253,	2,	'1611876301',	'::1',	'Agregar material salido: '),
(254,	2,	'1611876387',	'::1',	'Agregar material salido: '),
(255,	2,	'1611876509',	'::1',	'Agregar material salido: 1'),
(256,	2,	'1611876598',	'::1',	'Agregar material salido: 1'),
(257,	2,	'1611876676',	'::1',	'Agregar material salido: 1'),
(258,	2,	'1611876735',	'::1',	'Agregar material cotizado: 1'),
(259,	2,	'1612287172',	'::1',	'Agregar material cotizado: 7'),
(260,	2,	'1612288512',	'::1',	'Agregar material cotizado: 8'),
(261,	2,	'1612289000',	'::1',	'Agregar material cotizado: 7'),
(262,	2,	'1612289236',	'::1',	'Agregar material cotizado: 7');

DROP TABLE IF EXISTS `material_cotizado`;
CREATE TABLE `material_cotizado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `id_cotizacion` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `pedido` int(11) NOT NULL,
  `fecha_cotizacion` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `abierto` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `material_cotizado` (`id`, `id_producto`, `id_cotizacion`, `cantidad`, `pedido`, `fecha_cotizacion`, `abierto`, `estado`) VALUES
(1,	8,	1,	1,	0,	'1611767795',	1,	1),
(2,	9,	1,	1,	0,	'16117677849',	1,	1),
(3,	6,	7,	1,	0,	'1611873853',	0,	1),
(4,	7,	7,	1,	0,	'1611873888',	0,	1),
(5,	2,	8,	1,	0,	'1611875373',	1,	1),
(6,	4,	8,	1,	0,	'1611875380',	1,	1);

DROP TABLE IF EXISTS `material_salido`;
CREATE TABLE `material_salido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `id_salida` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `pedido` int(11) NOT NULL,
  `fecha_salida` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `abierto` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `material_salido` (`id`, `id_producto`, `id_salida`, `cantidad`, `pedido`, `fecha_salida`, `abierto`, `estado`) VALUES
(115,	8,	1,	1,	0,	'1611767795',	1,	1),
(116,	9,	1,	1,	0,	'1611767849',	1,	1),
(117,	5,	6,	1,	0,	'1611788890',	1,	1),
(118,	7,	8,	1,	0,	'1611849684',	1,	1),
(119,	2,	8,	1,	0,	'1611849772',	1,	1),
(120,	6,	0,	1,	0,	'1611850124',	1,	1),
(121,	4,	3,	1,	0,	'1611850244',	1,	1),
(122,	1,	3,	1,	0,	'1611850287',	1,	1),
(123,	4,	1,	1,	0,	'1611859693',	1,	1);

DROP TABLE IF EXISTS `necesidades`;
CREATE TABLE `necesidades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_requisicion` int(11) NOT NULL,
  `fecha` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `observaciones` tinytext,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `necesidades` (`id`, `id_usuario`, `id_cliente`, `id_requisicion`, `fecha`, `observaciones`, `estado`) VALUES
(1,	11,	11,	22,	'1611343246',	'Urge',	1),
(2,	4,	7,	5,	'1611344198',	'Dar prioridad',	1),
(3,	10,	6,	6,	'1611344575',	'Ninguna',	1),
(4,	4,	8,	12,	'1611587486',	'12',	1),
(5,	6,	1,	3,	'1611587889',	'3',	1),
(6,	4,	8,	55,	'1611588214',	'55',	1);

DROP TABLE IF EXISTS `regreso`;
CREATE TABLE `regreso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_requisicion` int(11) NOT NULL,
  `id_salida` int(11) NOT NULL,
  `fecha_regreso` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `regreso` (`id`, `id_usuario`, `id_cliente`, `id_requisicion`, `id_salida`, `fecha_regreso`, `estado`) VALUES
(1,	5,	9,	2,	4,	'1611331757',	1),
(2,	7,	11,	2,	2,	'1611332366',	1),
(3,	6,	6,	5,	5,	'1611332974',	1),
(4,	4,	11,	111,	111,	'1611589810',	1);

DROP TABLE IF EXISTS `requisicion`;
CREATE TABLE `requisicion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `entrada` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `material_adicional` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cliente` (`id_cliente`),
  CONSTRAINT `requisicion_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `requisicion` (`id`, `id_usuario`, `id_cliente`, `entrada`, `material_adicional`, `estado`) VALUES
(1,	2,	1,	'1610748314',	'',	1),
(2,	0,	8,	'1610743208',	'Cables',	1),
(3,	2,	2,	'1610748309',	'',	1),
(4,	6,	8,	'1610748308',	'cables y pijas ',	1),
(5,	5,	3,	'1610748371',	'Tubos',	1),
(6,	3,	1,	'1611094107',	'Tubos',	1),
(7,	4,	9,	'1611094806',	'Ninguno',	1),
(8,	3,	1,	'1611102592',	'cables  y pijas , casa',	1),
(9,	4,	1,	'1611153526',	'Cables',	1),
(10,	7,	7,	'1611153727',	'Pijas',	1),
(11,	3,	10,	'1611159561',	'cables  y pijas ',	1),
(12,	9,	10,	'1611159771',	'cables  y pijas , casa',	1),
(13,	4,	11,	'1611181016',	'cables  y pijas , casa',	1),
(14,	10,	6,	'1611589620',	'cables ',	1);

DROP TABLE IF EXISTS `salida`;
CREATE TABLE `salida` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_requisicion` int(11) NOT NULL,
  `fecha_salida` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `abierto` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `salida` (`id`, `id_usuario`, `id_cliente`, `id_requisicion`, `fecha_salida`, `abierto`, `estado`) VALUES
(1,	3,	10,	4,	'1611900000',	1,	1),
(2,	3,	10,	1,	'1611153226',	1,	1),
(3,	11,	11,	1,	'1611208800',	1,	0),
(4,	11,	8,	6,	'1611900000',	1,	1),
(5,	4,	11,	8,	'1611330936',	1,	1),
(6,	6,	1,	122,	'1611589739',	1,	1),
(7,	11,	11,	1,	'1611674829',	1,	0),
(16,	11,	11,	10,	'1611676388',	1,	0),
(17,	11,	11,	2,	'1611676901',	1,	0),
(18,	11,	11,	3,	'1611677285',	1,	0),
(19,	11,	11,	4,	'1611677358',	1,	0),
(20,	11,	11,	5,	'1611677807',	1,	0),
(21,	11,	11,	6,	'1611677900',	1,	0),
(22,	11,	11,	7,	'1611677993',	1,	0),
(23,	11,	11,	7,	'1611678292',	1,	0),
(24,	11,	11,	8,	'1611679042',	1,	0),
(25,	11,	11,	9,	'1611679221',	1,	0);

DROP TABLE IF EXISTS `token`;
CREATE TABLE `token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(100) NOT NULL,
  `usuario` int(11) NOT NULL,
  `fecha_generado` int(11) NOT NULL,
  `fecha_vencimiento` int(11) NOT NULL,
  `activo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario` (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `token` (`id`, `token`, `usuario`, `fecha_generado`, `fecha_vencimiento`, `activo`) VALUES
(1,	'df614a1ccc989786f94d18e5146539ae5805d0bd60ce7a90d8ea3d019cb0565f',	1,	1609194854,	1609799654,	1),
(2,	'fbaa6631b69fee6fe59b303a8d1e43250efaf77e0d94a0b281e6d647a33ec15b',	1,	1609194936,	1609799736,	1),
(3,	'604a49b165cbf209f8c99bc01fb9963e1766a1a3abfde5fcd234ee3b40f98921',	1,	1609195053,	1609799853,	1),
(4,	'fc762d163c6c345f9c9bb9dec52ae08aed22aca8dfc3c85332aab41547b4820f',	2,	1610403245,	1611008045,	1),
(5,	'0fe7cb646e927978ac35d62bdb13d052633d3c10d6690cb5f6229358ef69cfdb',	2,	1610407277,	1611012077,	1),
(6,	'e2c9ece8897d0a223e8d2125c9f1c42c62011befcec445311905b339bddc80ce',	2,	1610559864,	1611164664,	1),
(7,	'be4b12644d16c1689f09ec933d4b96dc278a85490298a5be5a6af8fcb8575fe8',	2,	1610559904,	1611164704,	1),
(8,	'e07d00c89dfef9ee92d68e432a9ed8a6de0e4104091df459ed59d1983613946f',	2,	1610563281,	1611168081,	1),
(9,	'cdc325abc141fc3f177b4c231590fc7b2c784192595a07bc19c523ed917894b0',	2,	1611169280,	1611774080,	1),
(10,	'6cc8b270b8ecc9091fc265916d831a7e23f92106f58e26d87c1500a45a100748',	2,	1611169304,	1611774104,	1),
(11,	'e3d210f019c4f71bc68eee4ffff92098a26fb6fc72748c1cd7719a1c4b9ff5ca',	2,	1611169472,	1611774272,	1),
(12,	'2cddf7f1974243b0ad15b986415dccdfc45c2b5930448e2e429e16e4d30572de',	2,	1611169537,	1611774337,	1),
(13,	'03b25a3ecd31a3d98e39360686f0f7f29205aa50ee86ec9c863ccff5e51a3ec1',	2,	1611169540,	1611774340,	1),
(14,	'3177d3380f88251aa7888d641a7f62d93cd78484ec95383d8adb9f7e88ff6586',	2,	1611169569,	1611774369,	1),
(15,	'8f3ea113726b35370c5ca7990253e74ab8d781937c3b4f24a3890998cb6498ca',	2,	1611169584,	1611774384,	1),
(16,	'7bf749985ddad47784f6f7f17e4bf46c4fbb8b4c9fade09fd96605b87b8987b0',	2,	1611169657,	1611774457,	1),
(17,	'2423d6059a2a4378e1ce6402dcfe639ea7a22d3405fc12c611ed6ac0db546df5',	1,	1611169739,	1611774539,	1),
(18,	'479d556f158ead997c6780883179061fa035d584c76253489db1d2815d9a1b3c',	2,	1611169761,	1611774561,	1),
(19,	'd89e8dcf9ca6f34f64316f39e9d2208099ede67b120c9d932a1c2795010841d4',	2,	1611169784,	1611774584,	1),
(20,	'fc89a90bb9b9848d2baf62c4f1b8190fc328bd584f058a223b2eac51c8bff78b',	2,	1611169848,	1611774648,	1),
(21,	'011b6a5d9741119165c5fdf221a96f19d28e1dd74c7e90d3beec8d6ccd277c27',	2,	1611170104,	1611774904,	1),
(22,	'7c03369e9f9daf04b14c4767fe79b9cc5a64d650fa63385af6a4c89366954eee',	2,	1611170186,	1611774986,	1),
(23,	'a3f07a4a4ad5f76fc53d78ba48d6af93d3e1bd90f0768b471df82a091dec879f',	2,	1611170465,	1611775265,	1),
(24,	'84f8f31d2b1faa48353037e94c92bfb7f103a029e66644dccecb61ca150b8a13',	2,	1611171140,	1611775940,	1),
(25,	'0087e10c2f379cdc98e092a5c40f972fdb84e752d5524fe48b27274709767cc7',	2,	1611171964,	1611776764,	1),
(26,	'abbb30a3ed4d79bf1d50febacdda26198c7bc67bd2b5df602b485f86587ab98b',	2,	1611255644,	1611860444,	1),
(27,	'9e38729cc328a7537fc6f8f6e1e7df6c423e7edb52f53621f624c5ed59988d12',	2,	1611862451,	1612467251,	1);

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `nivel` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `activo` int(11) NOT NULL,
  `nombre_completo` varchar(50) NOT NULL,
  `puesto` varchar(20) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `direccion` tinytext NOT NULL,
  `usuario_ver` int(11) NOT NULL,
  `usuario_agregar` int(11) NOT NULL,
  `usuario_editar` int(11) NOT NULL,
  `usuario_borrar` int(11) NOT NULL,
  `cliente_ver` int(11) NOT NULL,
  `cliente_agregar` int(11) NOT NULL,
  `cliente_editar` int(11) NOT NULL,
  `cliente_borrar` int(11) NOT NULL,
  `inventario_ver` int(11) NOT NULL,
  `inventario_agregar` int(11) NOT NULL,
  `inventario_editar` int(11) NOT NULL,
  `inventario_borrar` int(11) NOT NULL,
  `requisicion_ver` int(11) NOT NULL,
  `requisicion_agregar` int(11) NOT NULL,
  `requisicion_editar` int(11) NOT NULL,
  `requisicion_borrar` int(11) NOT NULL,
  `requisicion_reporte` int(11) NOT NULL,
  `salida_ver` int(11) NOT NULL,
  `salida_agregar` int(11) NOT NULL,
  `salida_editar` int(11) NOT NULL,
  `salida_borrar` int(11) NOT NULL,
  `salida_disminucion` int(11) NOT NULL,
  `salida_reporte` int(11) NOT NULL,
  `regreso_ver` int(11) NOT NULL,
  `regreso_agregar` int(11) NOT NULL,
  `regreso_editar` int(11) NOT NULL,
  `regreso_borrar` int(11) NOT NULL,
  `regreso_desperdicios` int(11) NOT NULL,
  `regreso_reporte` int(11) NOT NULL,
  `necesidades_ver` int(11) NOT NULL,
  `necesidades_agregar` int(11) NOT NULL,
  `necesidades_editar` int(11) NOT NULL,
  `necesidades_borrar` int(11) NOT NULL,
  `cotizaciones_ver` int(11) NOT NULL,
  `cotizaciones_agregar` int(11) NOT NULL,
  `cotizaciones_editar` int(11) NOT NULL,
  `cotizaciones_borrar` int(11) NOT NULL,
  `cotizaciones_formato` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `usuario` (`id`, `usuario`, `pass`, `nivel`, `estado`, `activo`, `nombre_completo`, `puesto`, `celular`, `correo`, `direccion`, `usuario_ver`, `usuario_agregar`, `usuario_editar`, `usuario_borrar`, `cliente_ver`, `cliente_agregar`, `cliente_editar`, `cliente_borrar`, `inventario_ver`, `inventario_agregar`, `inventario_editar`, `inventario_borrar`, `requisicion_ver`, `requisicion_agregar`, `requisicion_editar`, `requisicion_borrar`, `requisicion_reporte`, `salida_ver`, `salida_agregar`, `salida_editar`, `salida_borrar`, `salida_disminucion`, `salida_reporte`, `regreso_ver`, `regreso_agregar`, `regreso_editar`, `regreso_borrar`, `regreso_desperdicios`, `regreso_reporte`, `necesidades_ver`, `necesidades_agregar`, `necesidades_editar`, `necesidades_borrar`, `cotizaciones_ver`, `cotizaciones_agregar`, `cotizaciones_editar`, `cotizaciones_borrar`, `cotizaciones_formato`) VALUES
(1,	'carlosramongarcia',	'd4d7a6b8b3ed8ed86db2ef2cd728d8ec',	0,	1,	1,	'',	'',	'',	'',	'',	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0),
(2,	'desarollo',	'13e57e83d5bca1edb6c17c8ce36d5a9b',	0,	1,	1,	'',	'',	'',	'',	'',	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1),
(3,	'anna1',	'81d2017f9a08a6bb9e1cd4ffe7dcd902',	1,	1,	1,	'Anna',	'10',	'10',	'10',	'10',	1,	1,	1,	1,	0,	0,	0,	0,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	0,	0,	1,	1,	1,	1,	1,	1,	1,	1,	1),
(4,	'Julio',	'ac3492cc2632952e615d17e0cf4a1778',	1,	1,	1,	'Julio Martinez',	'IT',	'3366998855',	'algo',	'Chapultepec',	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	0,	1,	1,	1,	1,	1),
(5,	'MarioPrueba',	'8dd8fd065ae6e434e3bf6691e186e77a',	1,	1,	1,	'88',	'88',	'8',	'8',	'8',	1,	1,	0,	0,	1,	1,	0,	0,	1,	1,	1,	1,	1,	1,	1,	1,	0,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	0,	1,	1,	1,	1),
(6,	'Daniel',	'603feb3c8af35dabecc6c31cfe11f85a',	1,	1,	1,	'5',	'5',	'5',	'5',	'5',	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	0,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	0,	1,	1,	1,	1),
(7,	'Paralogs',	'd66dab4ef17385f4bc1d31a2bd0a7f4e',	2,	1,	1,	'10',	'10',	'10',	'10',	'10',	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0),
(8,	'Probando',	'6b66c96bb0be423a0d35201a06cd0a6e',	0,	1,	1,	'10',	'10',	'10',	'10',	'10',	1,	0,	0,	0,	1,	0,	0,	0,	1,	0,	0,	0,	1,	0,	0,	0,	0,	1,	0,	0,	0,	0,	0,	1,	0,	0,	0,	0,	0,	1,	0,	0,	0,	1,	0,	0,	0,	0),
(9,	'Nuevo',	'ef02a0d28d7c5b387b15be82485e1006',	4,	1,	1,	'7',	'7',	'7',	'7',	'7',	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1),
(10,	'Otro',	'a50dcce67a4d527760c3fe1b24b92afe',	5,	1,	1,	'Otra prueba',	'8',	'8 8 8 8',	'8',	'8',	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1),
(11,	'Main',	'1679091c5a880faf6fb5e6087eb1b2dc',	1,	1,	1,	'6',	'6',	'6',	'6',	'6',	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1);

-- 2021-02-02 18:15:16
