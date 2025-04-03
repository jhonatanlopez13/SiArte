-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-04-2025 a las 17:43:29
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
-- Base de datos: `becas_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `id_area` int(11) NOT NULL,
  `nombre_area` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`id_area`, `nombre_area`) VALUES
(1, 'cultura'),
(2, 'turismo'),
(3, 'patrimonio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `nombreCategoria` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombreCategoria`) VALUES
(1, 'Artes visuales'),
(2, 'Música\r\n'),
(3, 'Artes aplicadas'),
(4, 'Prácticas sustentables'),
(5, 'sostenibles'),
(6, 'Artes escénicas'),
(7, 'Artes audiovisuales'),
(8, 'Literatura');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convocatoria`
--

CREATE TABLE `convocatoria` (
  `id_detalle` int(200) NOT NULL,
  `id_programa_fk` int(11) NOT NULL,
  `id_persona_fk` int(11) NOT NULL,
  `id_estado_convocatoria_fk` int(11) NOT NULL DEFAULT 1,
  `convocatoria_estado` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1: Activo, 0: Inactivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `id` int(11) NOT NULL,
  `persona_id` int(11) DEFAULT NULL,
  `tipo_documento` varchar(100) NOT NULL,
  `ruta_archivo` varchar(255) NOT NULL,
  `proyecto_id` int(11) DEFAULT NULL,
  `estado` enum('pendiente','cumple','no_cumple') DEFAULT 'pendiente',
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_proceso`
--

CREATE TABLE `estado_proceso` (
  `id` int(11) NOT NULL,
  `nombre_estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_proceso`
--

INSERT INTO `estado_proceso` (`id`, `nombre_estado`) VALUES
(2, 'Aprobado'),
(1, 'Creado'),
(3, 'Rechazado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluacion_proyecto`
--

CREATE TABLE `evaluacion_proyecto` (
  `id` int(11) NOT NULL,
  `id_proyecto` int(11) NOT NULL,
  `id_evaluador` int(11) NOT NULL,
  `fecha_evaluacion` datetime DEFAULT current_timestamp(),
  `puntuacion` int(11) DEFAULT NULL,
  `comentarios` text DEFAULT NULL,
  `recomendacion` enum('aprobado','rechazado','pendiente') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero`
--

CREATE TABLE `genero` (
  `id` int(11) NOT NULL,
  `nombre_Genero` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `genero`
--

INSERT INTO `genero` (`id`, `nombre_Genero`) VALUES
(4, 'Agénero'),
(2, 'Hombre'),
(5, 'Intergénero'),
(1, 'Mujer'),
(3, 'No binario'),
(6, 'Transgénero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `id_tipo_persona_fk` int(11) NOT NULL,
  `accion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `id_tipo_persona_fk`, `accion`) VALUES
(1, 1, 'ver_ofertas'),
(2, 1, 'subir_evidencias'),
(3, 2, 'ver_ofertas'),
(4, 2, 'evaluar_proyectos'),
(5, 3, 'crear_ofertas'),
(6, 3, 'ver_ofertas'),
(7, 3, 'gestionar_usuarios'),
(8, 4, 'crear_ofertas'),
(9, 4, 'ver_ofertas'),
(10, 4, 'gestionar_usuarios'),
(11, 4, 'gestionar_roles');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id_persona` int(11) NOT NULL,
  `id_tipo_persona_fk` int(11) NOT NULL,
  `id_tipo_Documento_fk` int(11) NOT NULL,
  `numero_documento` varchar(20) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `genero_fk` int(11) DEFAULT NULL,
  `vereda_centro_poblado` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `correo` varchar(250) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `nombre_representante` varchar(255) DEFAULT NULL COMMENT 'Nombre del representante (Aplica solo para Grupo Constituido o Persona Jurídica)',
  `anexo1_persona_natural` varchar(255) DEFAULT NULL COMMENT 'ANEXO 1: Persona natural - Formatos de autorización (PDF)',
  `estado_anexo1` varchar(50) DEFAULT NULL COMMENT 'Estado del ANEXO 1',
  `anexo2_grupos_constituidos` varchar(255) DEFAULT NULL COMMENT 'ANEXO 2: Grupos constituidos - Formatos de autorización y acta de conformación (PDF)',
  `estado_anexo2` varchar(50) DEFAULT NULL COMMENT 'Estado del ANEXO 2',
  `anexo3_persona_juridica` varchar(255) DEFAULT NULL COMMENT 'ANEXO 3: Persona jurídica - Formatos de autorización (PDF)',
  `estado_anexo3` varchar(50) DEFAULT NULL COMMENT 'Estado del ANEXO 3',
  `copia_documento_identidad` varchar(255) DEFAULT NULL COMMENT 'Copia clara y legible del documento de identidad (PDF)',
  `estado_copia_documento` varchar(50) DEFAULT NULL COMMENT 'Estado de la copia del documento de identidad',
  `certificado_residencia` varchar(300) DEFAULT NULL COMMENT 'Certificado de residencia (PDF)',
  `estado_certificado_residencia` varchar(300) DEFAULT NULL COMMENT 'Estado del certificado de residencia',
  `copia_rut` varchar(300) DEFAULT NULL COMMENT 'Copia legible del RUT (PDF)',
  `estado_copia_rut` varchar(300) DEFAULT NULL COMMENT 'Estado de la copia del RUT',
  `certificado_sicut` varchar(300) DEFAULT NULL COMMENT 'Certificado de registro en el SICUT (PDF)',
  `estado_certificado_sicut` varchar(50) DEFAULT NULL COMMENT 'Estado del certificado de registro en el SICUT',
  `id_tipo_proponente_fk` int(11) DEFAULT NULL,
  `tiempo_residencia` varchar(200) DEFAULT NULL,
  `NIT` int(11) NOT NULL,
  `documento_representante` varchar(20) DEFAULT NULL,
  `id_vereda_fk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id_persona`, `id_tipo_persona_fk`, `id_tipo_Documento_fk`, `numero_documento`, `nombres`, `apellidos`, `genero_fk`, `vereda_centro_poblado`, `direccion`, `celular`, `correo`, `pass`, `nombre_representante`, `anexo1_persona_natural`, `estado_anexo1`, `anexo2_grupos_constituidos`, `estado_anexo2`, `anexo3_persona_juridica`, `estado_anexo3`, `copia_documento_identidad`, `estado_copia_documento`, `certificado_residencia`, `estado_certificado_residencia`, `copia_rut`, `estado_copia_rut`, `certificado_sicut`, `estado_certificado_sicut`, `id_tipo_proponente_fk`, `tiempo_residencia`, `NIT`, `documento_representante`, `id_vereda_fk`) VALUES
(45, 1, 3, '20994518', 'mancho', 'rodriguez lopez', 2, 'centro cund', 'CRA 3#8-80', '3122734752', 'ramirez@gmail.com', '987654321', 'jhonatan ricardo lopez', 'CIRCULAR 007 DE 2025 (1).pdf', 'cumple', 'Certificado_afiliacion (2).pdf', 'cumple', 'Certificado_afiliacion (1).pdf', 'cumple', NULL, 'cumple', 'CertiAfiliacionContributivo_1078371526.pdf', 'cumple', 'CertiAfiliacionContributivo_1078371526.pdf', 'cumple', 'Certificado_afiliacion (2).pdf', 'cumple', 1, '9 meses', 0, '', 4),
(47, 3, 4, '1078371526', 'jhonatan ricardo', 'LOPEZ GONZALEZ', 2, 'centro cund', 'CRA 3#8-80', '31227347521', 'metty.salazar@gmail.com', '123456789', 'valentina', 'Certificado_afiliacion (2).pdf', 'en proceso', 'Certificado_afiliacion (2).pdf', 'en proceso', 'Certificado_afiliacion (1).pdf', 'en proceso', NULL, 'en proceso', 'Certificado_afiliacion (1).pdf', 'en proceso', 'CIRCULAR 007 DE 2025.pdf', 'en proceso', 'CIRCULAR 007 DE 2025.pdf', 'en proceso', 1, '9 meses', 0, NULL, NULL),
(59, 1, 3, '3199837', 'diego hernando', 'Ramirez gonzalez', 2, '', 'CRA 3#8-80', '3122734752', 'ramirez1@gmail.com', 'Lopez*13031', 'valentina ramirez gonzalez', '67ec64e9ae43d.pdf', 'pendiente', NULL, 'pendiente', NULL, 'pendiente', '67ec64e9ae991.pdf', 'pendiente', '67ec64e9af04e.pdf', 'pendiente', '67ec64e9af717.pdf', 'pendiente', '67ec64e9afc57.pdf', 'pendiente', 1, '10', 0, '', 6),
(60, 1, 11, '987654321', 'asociados lopez', 'aaaa', NULL, '', '', '', 'asociadoslopez@gmail.com', 'Lopez*13031', '', NULL, 'pendiente', NULL, 'pendiente', NULL, 'pendiente', NULL, 'pendiente', NULL, 'pendiente', NULL, 'pendiente', NULL, 'pendiente', 2, '20', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `poblacion`
--

CREATE TABLE `poblacion` (
  `id` int(11) NOT NULL,
  `tipo_poblacion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programas`
--

CREATE TABLE `programas` (
  `id_programa` int(11) NOT NULL,
  `nombre_estimulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_inicio` timestamp NULL DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `id_tipo_estimulo_fk` int(11) DEFAULT NULL,
  `id_categoria_fk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `programas`
--

INSERT INTO `programas` (`id_programa`, `nombre_estimulo`, `descripcion`, `fecha_inicio`, `fecha_fin`, `id_tipo_estimulo_fk`, `id_categoria_fk`) VALUES
(20, 'Promoción de la cultura local y el reconocimiento de las expresiones artísticas', NULL, NULL, NULL, NULL, NULL),
(21, ' Promoción de la cultura local y el reconocimiento de las expresiones artísticas', NULL, NULL, NULL, NULL, NULL),
(24, 'Beca de narrativas diversas', 'Fomento del diálogo intercultural y la convivencia pacífica', NULL, NULL, NULL, NULL),
(25, 'Beca de creación cultura local', 'Promoción de la cultura local y el reconocimiento de las expresiones artísticas', NULL, NULL, NULL, NULL),
(26, 'Beca de creación artística para jóvenes artistas', 'Promoción de la cultura local y el reconocimiento de las expresiones artísticas', NULL, NULL, NULL, NULL),
(27, 'Beca de empoderamiento de género', 'Fomento del diálogo intercultural y la convivencia pacífica', NULL, NULL, NULL, NULL),
(28, 'Beca audiovisual memorias de Tenjo', 'Recuperación de memorias y patrimonios a través del arte', NULL, NULL, NULL, NULL),
(29, 'Beca Laboratorio de Arte, Nuevas Tecnologías e Inteligencia Artificial', 'Promoción de la cultura local y el reconocimiento de las expresiones artísticas', NULL, NULL, NULL, NULL),
(30, 'Beca Laboratorio de arte para la Primera Infancia. Diálogos transdiciplinares', 'Fomento del diálogo intercultural y la convivencia pacífica', NULL, NULL, NULL, NULL),
(31, 'Beca Festival artístico para la Primera Infancia', 'Fomento del diálogo intercultural y la convivencia pacífica', NULL, NULL, NULL, NULL),
(32, 'Beca de circulación proyectos para artistas jóvenes', 'Promoción de la cultura local y el reconocimiento de las expresiones artísticas', NULL, NULL, NULL, NULL),
(33, 'Beca de circulación productos artísticos consolidados', 'Promoción de la cultura local y el reconocimiento de las expresiones artísticas', NULL, NULL, NULL, NULL),
(34, 'Residencia artística nacional', 'Promoción de la cultura local y el reconocimiento de las expresiones artísticas', NULL, NULL, NULL, NULL),
(35, 'Residencia artística internacional', 'Promoción de la cultura local y el reconocimiento de las expresiones artísticas', NULL, NULL, NULL, NULL),
(36, 'Premio legado cultural', 'Recuperación de memorias y patrimonios a través del arte', NULL, NULL, NULL, NULL),
(37, 'Reconocimiento a experiencias artísticas significativas', 'Recuperación de memorias y patrimonios a través del arte', NULL, NULL, NULL, NULL),
(38, 'Beca guardianes del patrimonio natural y arqueológico de Tenjo', 'Prácticas para el bienestar y la sostenibilidad', NULL, NULL, NULL, NULL),
(39, 'Beca guardianes del patrimonio documental de Tenjo', 'Recuperación de memorias y patrimonios a través del arte', NULL, NULL, NULL, NULL),
(40, 'Beca guardianes del patrimonio inmaterial de Tenjo', 'Recuperación de memorias y patrimonios a través del arte', NULL, NULL, NULL, NULL),
(41, 'Beca saberes y prácticas gastronómicas tradicionales de Tenjo', 'Recuperación de memorias y patrimonios a través del arte', NULL, NULL, NULL, NULL),
(42, 'Residencia internacional', 'Impulsando el intercambio de saberes culturales', NULL, NULL, NULL, NULL),
(43, 'Pasantía', 'Narrativas y relatos comunitarios sobre el patrimonio del municipio', NULL, NULL, NULL, NULL),
(44, 'Beca guardianes del patrimonio arquitectónico de Tenjo', 'Recuperación de memorias y patrimonios a través del arte', NULL, NULL, NULL, NULL),
(45, 'Beca de innovación turística sostenible', 'Prácticas para el bienestar y la sostenibilidad', NULL, NULL, NULL, NULL),
(46, 'Beca de turismo regenerativo', 'Prácticas para el bienestar y la sostenibilidad', NULL, NULL, NULL, NULL),
(47, 'Beca de turismo cultural y construcción de Paz', 'Fomento del diálogo intercultural y la convivencia pacífica', NULL, NULL, NULL, NULL),
(48, 'Beca de turismo comunitario', 'Prácticas para el bienestar y la sostenibilidad', NULL, NULL, NULL, NULL),
(49, 'Residencia internacional de experiencias significativas en turismo comunitario', 'Fomento del diálogo intercultural y la convivencia pacífica', NULL, NULL, NULL, NULL),
(50, 'Beca en marketing turístico digital', 'Prácticas para el bienestar y la sostenibilidad', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `id_proyecto` int(11) NOT NULL,
  `convocatoria_id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `objetivo_general` text NOT NULL,
  `productos` text NOT NULL,
  `descripcion` text DEFAULT NULL,
  `evidencia` varchar(255) DEFAULT NULL,
  `comentario` text NOT NULL,
  `id_programa_fk` int(11) DEFAULT NULL,
  `productos_servicios` text DEFAULT NULL,
  `archivo_formato_presentacion` varchar(255) DEFAULT NULL,
  `archivo_presupuesto` varchar(255) DEFAULT NULL,
  `archivo_cronograma` varchar(255) DEFAULT NULL,
  `archivo_soportes_experiencia` varchar(255) DEFAULT NULL,
  `archivo_documentos_adicionales` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategoria`
--

CREATE TABLE `subcategoria` (
  `id_sub` int(11) NOT NULL,
  `nombreSub` varchar(255) NOT NULL,
  `id_categoria_fk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `subcategoria`
--

INSERT INTO `subcategoria` (`id_sub`, `nombreSub`, `id_categoria_fk`) VALUES
(1, 'Creación', NULL),
(2, 'Circulación', NULL),
(3, 'Formación', NULL),
(4, 'Investigación', NULL),
(5, 'Prácticas sustentables y sostenibles', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id` int(11) NOT NULL,
  `tipoDocumento` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`id`, `tipoDocumento`) VALUES
(3, 'CEDULA DE CIUDADANÍA'),
(4, 'CEDULA DE EXTRANJERÍA'),
(11, 'NIT'),
(5, 'PERMISO ESPECIAL DE PERMANENCIA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_estimulo`
--

CREATE TABLE `tipo_estimulo` (
  `id` int(11) NOT NULL,
  `nombre de estimulo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_estimulo`
--

INSERT INTO `tipo_estimulo` (`id`, `nombre de estimulo`) VALUES
(1, 'beca'),
(2, 'residencia'),
(3, 'reconcimiento '),
(4, 'premio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_persona`
--

CREATE TABLE `tipo_persona` (
  `id` int(11) NOT NULL,
  `nombreTipopersona` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_persona`
--

INSERT INTO `tipo_persona` (`id`, `nombreTipopersona`) VALUES
(3, 'admin'),
(1, 'aspirante'),
(2, 'jurado'),
(4, 'super admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_proponente`
--

CREATE TABLE `tipo_proponente` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_proponente`
--

INSERT INTO `tipo_proponente` (`id`, `nombre`) VALUES
(2, 'Grupo Constituido'),
(3, 'Persona Jurídica'),
(1, 'Persona Natural');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vereda`
--

CREATE TABLE `vereda` (
  `id_vereda` int(11) NOT NULL,
  `nombre_vereda` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vereda`
--

INSERT INTO `vereda` (`id_vereda`, `nombre_vereda`) VALUES
(1, 'Carrasquilla'),
(2, 'Chacal'),
(3, 'Chincé'),
(4, 'Chitasugá'),
(5, 'Chu-cua'),
(6, 'Churuguaco'),
(7, 'El Estanco'),
(8, 'Guangatá'),
(9, 'Jacalito'),
(10, 'Juaica'),
(11, 'La punta'),
(12, 'Martín Espino'),
(13, 'Poveda 1'),
(14, 'Poveda 2'),
(15, 'Santa Cruz'),
(16, 'Casco Urbano');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id_area`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `convocatoria`
--
ALTER TABLE `convocatoria`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_programa_fk` (`id_programa_fk`),
  ADD KEY `id_estado_fk` (`id_estado_convocatoria_fk`),
  ADD KEY `convocatoria_ibfk_2` (`id_persona_fk`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `persona_id` (`persona_id`),
  ADD KEY `proyecto_id` (`proyecto_id`);

--
-- Indices de la tabla `estado_proceso`
--
ALTER TABLE `estado_proceso`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_estado` (`nombre_estado`);

--
-- Indices de la tabla `evaluacion_proyecto`
--
ALTER TABLE `evaluacion_proyecto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_proyecto` (`id_proyecto`),
  ADD KEY `id_evaluador` (`id_evaluador`);

--
-- Indices de la tabla `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_Genero` (`nombre_Genero`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tipo_persona_fk` (`id_tipo_persona_fk`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_persona`),
  ADD UNIQUE KEY `numero_documento` (`numero_documento`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `id_tipo_persona_fk` (`id_tipo_persona_fk`),
  ADD KEY `id_tipo_Documento_fk` (`id_tipo_Documento_fk`),
  ADD KEY `genero_fk` (`genero_fk`),
  ADD KEY `fk_tipo_proponente` (`id_tipo_proponente_fk`),
  ADD KEY `fk_persona_vereda` (`id_vereda_fk`);

--
-- Indices de la tabla `poblacion`
--
ALTER TABLE `poblacion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tipo_poblacion` (`tipo_poblacion`);

--
-- Indices de la tabla `programas`
--
ALTER TABLE `programas`
  ADD PRIMARY KEY (`id_programa`),
  ADD UNIQUE KEY `nombre_programa` (`nombre_estimulo`),
  ADD KEY `fk_programa_tipo_estimulo` (`id_tipo_estimulo_fk`),
  ADD KEY `fk_programa_categoria` (`id_categoria_fk`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id_proyecto`),
  ADD KEY `convocatoria_id` (`convocatoria_id`),
  ADD KEY `fk_proyecto_programa` (`id_programa_fk`);

--
-- Indices de la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  ADD PRIMARY KEY (`id_sub`),
  ADD KEY `fk_subcategoria_categoria` (`id_categoria_fk`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tipoDocumento` (`tipoDocumento`);

--
-- Indices de la tabla `tipo_estimulo`
--
ALTER TABLE `tipo_estimulo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_persona`
--
ALTER TABLE `tipo_persona`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombreTipopersona` (`nombreTipopersona`);

--
-- Indices de la tabla `tipo_proponente`
--
ALTER TABLE `tipo_proponente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `vereda`
--
ALTER TABLE `vereda`
  ADD PRIMARY KEY (`id_vereda`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `id_area` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `convocatoria`
--
ALTER TABLE `convocatoria`
  MODIFY `id_detalle` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado_proceso`
--
ALTER TABLE `estado_proceso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `evaluacion_proyecto`
--
ALTER TABLE `evaluacion_proyecto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `genero`
--
ALTER TABLE `genero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `poblacion`
--
ALTER TABLE `poblacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `programas`
--
ALTER TABLE `programas`
  MODIFY `id_programa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `id_proyecto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  MODIFY `id_sub` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tipo_estimulo`
--
ALTER TABLE `tipo_estimulo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_persona`
--
ALTER TABLE `tipo_persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_proponente`
--
ALTER TABLE `tipo_proponente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `vereda`
--
ALTER TABLE `vereda`
  MODIFY `id_vereda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `convocatoria`
--
ALTER TABLE `convocatoria`
  ADD CONSTRAINT `convocatoria_ibfk_1` FOREIGN KEY (`id_programa_fk`) REFERENCES `programas` (`id_programa`),
  ADD CONSTRAINT `convocatoria_ibfk_2` FOREIGN KEY (`id_persona_fk`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE;

--
-- Filtros para la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD CONSTRAINT `documentos_ibfk_1` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id_persona`),
  ADD CONSTRAINT `documentos_ibfk_2` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id_proyecto`);

--
-- Filtros para la tabla `evaluacion_proyecto`
--
ALTER TABLE `evaluacion_proyecto`
  ADD CONSTRAINT `evaluacion_proyecto_ibfk_1` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos` (`id_proyecto`),
  ADD CONSTRAINT `evaluacion_proyecto_ibfk_2` FOREIGN KEY (`id_evaluador`) REFERENCES `personas` (`id_persona`);

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`id_tipo_persona_fk`) REFERENCES `tipo_persona` (`id`);

--
-- Filtros para la tabla `personas`
--
ALTER TABLE `personas`
  ADD CONSTRAINT `fk_persona_vereda` FOREIGN KEY (`id_vereda_fk`) REFERENCES `vereda` (`id_vereda`),
  ADD CONSTRAINT `fk_tipo_proponente` FOREIGN KEY (`id_tipo_proponente_fk`) REFERENCES `tipo_proponente` (`id`),
  ADD CONSTRAINT `personas_ibfk_1` FOREIGN KEY (`id_tipo_persona_fk`) REFERENCES `tipo_persona` (`id`),
  ADD CONSTRAINT `personas_ibfk_2` FOREIGN KEY (`id_tipo_Documento_fk`) REFERENCES `tipo_documento` (`id`),
  ADD CONSTRAINT `personas_ibfk_3` FOREIGN KEY (`genero_fk`) REFERENCES `genero` (`id`);

--
-- Filtros para la tabla `programas`
--
ALTER TABLE `programas`
  ADD CONSTRAINT `fk_programa_categoria` FOREIGN KEY (`id_categoria_fk`) REFERENCES `categoria` (`id_categoria`),
  ADD CONSTRAINT `fk_programa_tipo_estimulo` FOREIGN KEY (`id_tipo_estimulo_fk`) REFERENCES `tipo_estimulo` (`id`);

--
-- Filtros para la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `fk_proyecto_programa` FOREIGN KEY (`id_programa_fk`) REFERENCES `programas` (`id_programa`),
  ADD CONSTRAINT `proyectos_ibfk_1` FOREIGN KEY (`convocatoria_id`) REFERENCES `convocatoria` (`id_detalle`);

--
-- Filtros para la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  ADD CONSTRAINT `fk_subcategoria_categoria` FOREIGN KEY (`id_categoria_fk`) REFERENCES `categoria` (`id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
