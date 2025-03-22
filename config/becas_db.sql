-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-03-2025 a las 03:12:20
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
-- Estructura de tabla para la tabla `convocatoria`
--

CREATE TABLE `convocatoria` (
  `id_detalle` int(11) NOT NULL,
  `id_programa_fk` int(11) NOT NULL,
  `id_persona_fk` int(11) NOT NULL,
  `id_estado_fk` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `id` int(11) NOT NULL,
  `persona_id` int(11) NOT NULL,
  `tipo_documento` varchar(100) NOT NULL,
  `ruta_archivo` varchar(255) NOT NULL
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
  `id` int(11) NOT NULL,
  `id_tipo_persona_fk` int(11) NOT NULL,
  `id_tipo_Documento_fk` int(11) NOT NULL,
  `numero_documento` varchar(20) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `genero_fk` int(11) NOT NULL,
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
  `tiempo_residencia` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `id_tipo_persona_fk`, `id_tipo_Documento_fk`, `numero_documento`, `nombres`, `apellidos`, `genero_fk`, `vereda_centro_poblado`, `direccion`, `celular`, `correo`, `pass`, `nombre_representante`, `anexo1_persona_natural`, `estado_anexo1`, `anexo2_grupos_constituidos`, `estado_anexo2`, `anexo3_persona_juridica`, `estado_anexo3`, `copia_documento_identidad`, `estado_copia_documento`, `certificado_residencia`, `estado_certificado_residencia`, `copia_rut`, `estado_copia_rut`, `certificado_sicut`, `estado_certificado_sicut`, `id_tipo_proponente_fk`, `tiempo_residencia`) VALUES
(23, 3, 3, '1078370110', 'martha', 'gonzalez duarte', 2, 'centro', 'CRA 3#8-80', '3122734752', 'cc.ticlopez@gmail.com', '123456789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(29, 3, 1, '10783701100', 'jhonatan ricard...', 'LOPEZ GONZALEZ', 2, 'centro', 'CRA 3#8-80', '3122734752', 'cc.ticlopez@gma...', '123456789', 'valentina', '5', 'anexos.pdf', 'MODELO ORDEN DE...', 'registro jhonat...', 'anexos.pdf', 'MODELO CUENTA D...', 'CertiAfiliacion...', 'MODELO ORDEN DE...', 'en proceso', 'en proceso', 'en proceso', 'en proceso', 'en proceso', 'en proceso', 3, 'en proceso');

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
  `nombre_programa` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_inicio` timestamp NULL DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `programas`
--

INSERT INTO `programas` (`id_programa`, `nombre_programa`, `descripcion`, `fecha_inicio`, `fecha_fin`) VALUES
(6, 'lopez', 'aaaaaaaaaaa', '2025-03-19 05:00:00', '2025-03-21'),
(7, 'lopez111', 'aaaaaaaaaaa', '2025-03-19 05:00:00', '2025-03-21'),
(8, 'hhhh', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '1999-01-18 05:00:00', '1998-01-18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `id` int(11) NOT NULL,
  `convocatoria_id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `evidencia` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo de proponente`
--

CREATE TABLE `tipo de proponente` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(5, 'PERMISO ESPECIAL DE PERMANENCIA'),
(1, 'REGISTRO CIVIL'),
(2, 'TARJETA DE IDENTIDAD');

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

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `convocatoria`
--
ALTER TABLE `convocatoria`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_programa_fk` (`id_programa_fk`),
  ADD KEY `id_persona_fk` (`id_persona_fk`),
  ADD KEY `id_estado_fk` (`id_estado_fk`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `persona_id` (`persona_id`);

--
-- Indices de la tabla `estado_proceso`
--
ALTER TABLE `estado_proceso`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_estado` (`nombre_estado`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_documento` (`numero_documento`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `id_tipo_persona_fk` (`id_tipo_persona_fk`),
  ADD KEY `id_tipo_Documento_fk` (`id_tipo_Documento_fk`),
  ADD KEY `genero_fk` (`genero_fk`),
  ADD KEY `fk_tipo_proponente` (`id_tipo_proponente_fk`);

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
  ADD UNIQUE KEY `nombre_programa` (`nombre_programa`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `convocatoria_id` (`convocatoria_id`);

--
-- Indices de la tabla `tipo de proponente`
--
ALTER TABLE `tipo de proponente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tipoDocumento` (`tipoDocumento`);

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
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `convocatoria`
--
ALTER TABLE `convocatoria`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `poblacion`
--
ALTER TABLE `poblacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `programas`
--
ALTER TABLE `programas`
  MODIFY `id_programa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `convocatoria`
--
ALTER TABLE `convocatoria`
  ADD CONSTRAINT `convocatoria_ibfk_1` FOREIGN KEY (`id_programa_fk`) REFERENCES `programas` (`id_programa`),
  ADD CONSTRAINT `convocatoria_ibfk_2` FOREIGN KEY (`id_persona_fk`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `convocatoria_ibfk_3` FOREIGN KEY (`id_estado_fk`) REFERENCES `estado_proceso` (`id`);

--
-- Filtros para la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD CONSTRAINT `documentos_ibfk_1` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`);

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`id_tipo_persona_fk`) REFERENCES `tipo_persona` (`id`);

--
-- Filtros para la tabla `personas`
--
ALTER TABLE `personas`
  ADD CONSTRAINT `fk_tipo_proponente` FOREIGN KEY (`id_tipo_proponente_fk`) REFERENCES `tipo_proponente` (`id`),
  ADD CONSTRAINT `personas_ibfk_1` FOREIGN KEY (`id_tipo_persona_fk`) REFERENCES `tipo_persona` (`id`),
  ADD CONSTRAINT `personas_ibfk_2` FOREIGN KEY (`id_tipo_Documento_fk`) REFERENCES `tipo_documento` (`id`),
  ADD CONSTRAINT `personas_ibfk_3` FOREIGN KEY (`genero_fk`) REFERENCES `genero` (`id`);

--
-- Filtros para la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `proyectos_ibfk_1` FOREIGN KEY (`convocatoria_id`) REFERENCES `convocatoria` (`id_detalle`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
