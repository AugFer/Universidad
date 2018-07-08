-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-11-2016 a las 13:59:07
-- Versión del servidor: 5.6.16
-- Versión de PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `db_sveu`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE IF NOT EXISTS `administradores` (
  `adm_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `adm_usuario` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `adm_pass` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `adm_dni` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`adm_usuario`),
  UNIQUE KEY `adm_id` (`adm_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=26 ;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`adm_id`, `adm_usuario`, `adm_pass`, `adm_dni`) VALUES
(25, '1-87654321/14', '5e8667a439c68f5145dd2fcbecf02209', '87654321'),
(1, 'admin', 'f6fdffe48c908deb0f4c3bd36c032e72', '11111111'),
(24, 'robertogomez', 'dd47e952f6244849b45020644ab9fd0c', '1234567');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apoderados_listas`
--

CREATE TABLE IF NOT EXISTS `apoderados_listas` (
  `apo_id` int(10) NOT NULL AUTO_INCREMENT,
  `apo_usuario` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `apo_pass` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `apo_dni` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`apo_usuario`),
  UNIQUE KEY `apo_id` (`apo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `apoderados_listas`
--

INSERT INTO `apoderados_listas` (`apo_id`, `apo_usuario`, `apo_pass`, `apo_dni`) VALUES
(3, '24897128', '66fcfc7d2a0e54af3a116c5ce0871133', '24897128'),
(6, '25468791', '1b19c2ff02ad442a2eaea7c6e2fbe996', '25468791'),
(5, '29548782', '00af194b6b2f973a17125ea0d7340fdf', '29548782'),
(7, '30565304', '81183af9779cf1131f5f262029c8cf37', '30565304'),
(2, '7317383', 'd99ec01114ebc5635e9d1769bd2e6a7d', '7317383');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `candidatos`
--

CREATE TABLE IF NOT EXISTS `candidatos` (
  `cand_id` int(10) NOT NULL AUTO_INCREMENT,
  `cand_dni` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `cand_lista` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `cand_cargo` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`cand_dni`),
  UNIQUE KEY `cand_id` (`cand_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=55 ;

--
-- Volcado de datos para la tabla `candidatos`
--

INSERT INTO `candidatos` (`cand_id`, `cand_dni`, `cand_lista`, `cand_cargo`) VALUES
(2, '1234567', 'Partecipare', '2do Consejero - Titular'),
(1, '14217897', 'Partecipare', '1er Consejero - Titular'),
(12, '16358417', 'Partecipare', '4to Consejero - Suplente'),
(33, '20588791', 'Fabrizio', '4to Consejero - Titular'),
(31, '21588791', 'Fabrizio', '2do Consejero - Titular'),
(47, '21971323', 'Fabrizio', '3er Consejero - Suplente'),
(8, '22158963', 'Partecipare', '5to Consejero - Titular'),
(50, '22771526', 'Fabrizio', '6to Consejero - Suplente'),
(46, '22971323', 'Fabrizio', '2do Consejero - Suplente'),
(48, '22971523', 'Fabrizio', '4to Consejero - Suplente'),
(49, '22971777', 'Fabrizio', '5to Consejero - Suplente'),
(44, '24897127', 'Ragusa', '4to Consejero - Suplente'),
(34, '24897128', 'Ragusa', '1er Consejero - Titular'),
(53, '25148963', 'Lista 71', '2do Consejero - Suplente'),
(32, '25468791', 'Fabrizio', '3er Consejero - Titular'),
(29, '25888999', 'Lista Civica', '5to Consejero - Titular'),
(37, '25897128', 'Ragusa', '2do Consejero - Suplente'),
(43, '27971321', 'Ragusa', '3er Consejero - Suplente'),
(42, '27971323', 'Lista Civica', '5to Consejero - Suplente'),
(41, '28486687', 'Lista Civica', '4to Consejero - Suplente'),
(52, '28579153', 'Lista 71', '1er Consejero - Suplente'),
(40, '28589777', 'Lista Civica', '3er Consejero - Suplente'),
(38, '28589781', 'Lista Civica', '1er Consejero - Suplente'),
(26, '28894782', 'Lista Civica', '2do Consejero - Titular'),
(19, '29548782', 'Racalmuto', '1er Consejero - Titular'),
(30, '29658712', 'Fabrizio', '1er Consejero - Titular'),
(36, '29687482', 'Ragusa', '1er Consejero - Suplente'),
(45, '29687483', 'Fabrizio', '1er Consejero - Suplente'),
(9, '29789654', 'Partecipare', '1er Consejero - Suplente'),
(39, '30126897', 'Lista Civica', '2do Consejero - Suplente'),
(3, '30565304', 'Partecipare', '3er Consejero - Titular'),
(51, '30566987', 'Lista 71', '1er Consejero - Titular'),
(11, '31123456', 'Partecipare', '3er Consejero - Suplente'),
(13, '31467522', 'Partecipare', '5to Consejero - Suplente'),
(20, '31567951', 'Racalmuto', '1er Consejero - Suplente'),
(28, '31587488', 'Lista Civica', '4to Consejero - Titular'),
(21, '31589417', 'Racalmuto', '2do Consejero - Suplente'),
(22, '31589717', 'Racalmuto', '3er Consejero - Suplente'),
(10, '32587915', 'Partecipare', '2do Consejero - Suplente'),
(35, '33248985', 'Ragusa', '2do Consejero - Titular'),
(7, '33587112', 'Partecipare', '4to Consejero - Titular'),
(54, '33987456', 'Lista 71', '3er Consejero - Suplente'),
(27, '35158793', 'Lista Civica', '3er Consejero - Titular'),
(25, '7317383', 'Lista Civica', '1er Consejero - Titular');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `electores`
--

CREATE TABLE IF NOT EXISTS `electores` (
  `ele_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `ele_legajo` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `ele_claustro` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `ele_dni` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `ele_pass` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `ele_voto` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `ele_cargo_carrera` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `ele_pin` int(6) unsigned NOT NULL,
  PRIMARY KEY (`ele_legajo`,`ele_id`),
  UNIQUE KEY `ele_id` (`ele_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=54 ;

--
-- Volcado de datos para la tabla `electores`
--

INSERT INTO `electores` (`ele_id`, `ele_legajo`, `ele_claustro`, `ele_dni`, `ele_pass`, `ele_voto`, `ele_cargo_carrera`, `ele_pin`) VALUES
(51, '1-14217897/98', 'Alumnos', '14217897', '433bab0e40893dc9f1392a7fd8b7de26', '', 'T.U.G.O.', 0),
(2, '1-14324015/10', 'Alumnos', '14324015', 'b0a3dba3fc4fd08a097d2cae63cd81cb', '', 'Profesorado en Primaria', 0),
(6, '1-16358417/11', 'Alumnos', '16358417', '3ab1a8734faad8468197689651c5a631', '', 'Profesorado en Primaria', 0),
(5, '1-17410200/12', 'Alumnos', '17410200', 'a4de8a184226c7e3b59dc19c92dfd64d', '', 'Ingeniera Electromecanica', 0),
(32, '1-20588791/06', 'Profesores', '20588791', '6048eafa93819fc1cccccf2f2c885a78', '', 'T.U.G.O.', 0),
(30, '1-21588791/06', 'Profesores', '21588791', 'cf68976112e8c7daed2b7b9f4f317ed7', '', 'Ingeniería en Sistemas', 0),
(47, '1-21971323/05', 'Profesores', '21971323', '4bac7c8dce4dbe97571b4aec533ebb53', '', 'Profesor', 0),
(22, '1-22158963/10', 'Alumnos', '22158963', '36b9e123d7afe326fd20d525c6d58164', '', 'Ingeniera Electromecanica', 0),
(50, '1-22771526/04', 'Profesores', '22771526', '8fd67a288c8274efc1443a9a336b43a4', '', 'Profesor', 0),
(46, '1-22971323/05', 'Profesores', '22971323', '6aadaadcb6e4783887dcd0e6be602265', '', 'Profesor', 0),
(48, '1-22971523/05', 'Profesores', '22971523', 'f7ad70e489f907967aa2e7e04810c960', '', 'Profesor', 0),
(49, '1-22971777/06', 'Profesores', '22971777', '1bc7047e5cc7cf611ba91f6b692ba542', '', 'Profesor', 0),
(18, '1-24888999/09', 'Auxiliares', '24888999', '1b679c93e90f68da09308c4b0862b597', '', 'Ingeniera Electromecanica', 0),
(44, '1-24897127/07', 'Auxiliares', '24897127', '875765f8eac93e4269b7df2cbaf6a4c3', '', 'Agente Alumnos', 0),
(33, '1-24897128/09', 'Auxiliares', '24897128', 'c6f0a24c866d67aeaa2b6d1310dfdff1', '', 'Cs. de la Educación', 0),
(7, '1-25148963/10', 'Cuerpo AyA', '25148963', '9acbdb0d9248b186e7d58b0c62fc5059', '', 'Analista de Sistemas', 0),
(31, '1-25468791/07', 'Profesores', '25468791', 'e2b1fe5562cdc65c336e520406a08640', '', 'Ingeniera Electromecanica', 0),
(28, '1-25888999/09', 'Alumnos', '25888999', 'fcf65d2abf17a9a68a15aa7a8e2ec5f1', '', 'T.U.S.H.', 0),
(36, '1-25897128/09', 'Auxiliares', '25897128', '31527853d736f83e1de42dc89625368d', '', 'Acceso y Permanencia', 0),
(9, '1-26258945/11', 'Auxiliares', '26258945', 'f5bb35f7e4554cc0c606ce80bce063f5', '', 'T.U.G.O.', 0),
(3, '1-27329366/08', 'Alumnos', '27329366', 'd13911c56e9284327f217601c1ccd2e8', '', 'T.U.G.O.', 0),
(43, '1-27971321/08', 'Auxiliares', '27971321', '27af39276f889f545b831ab37dd69564', '', 'Acceso y Permanencia', 0),
(42, '1-27971323/08', 'Alumnos', '27971323', '7362bf278478c9ee13004d274c5f38f9', '', 'Ciencias de la Educación', 0),
(53, '1-28333222/10', 'Cuerpo AyA', '28333222', '35e2faa8d01cc673a0ef98b04d3f46fc', '', 'T.U.G.O.', 0),
(41, '1-28486687/10', 'Alumnos', '28486687', '6def48cf75792937715e55412a165237', '', 'Ciencias de la Educación', 0),
(15, '1-28579153/10', 'Cuerpo AyA', '28579153', 'c2fd06590218e107ad56e494b488bd76', '', 'Analista de Sistemas', 0),
(40, '1-28589777/11', 'Alumnos', '28589777', 'aa3409b9ce2cf50bed995c325d3bed98', '', 'Profesorado en Primaria', 0),
(37, '1-28589781/10', 'Alumnos', '28589781', 'de55bcf7ecd53d268bc9a7ba4a5fa7c0', '', 'T.U.S.H.', 0),
(17, '1-28697411/11', 'Auxiliares', '28697411', '7361888af937cfd4c11fdad5fa82dfa0', '', 'Auxiliar', 0),
(25, '1-28894782/11', 'Alumnos', '28894782', 'ed007c8eefb64379c0297fd7fce5665b', '', 'Analista de Sistemas', 0),
(8, '1-29548782/07', 'Profesores', '29548782', '9dc5c5078005be6a71f24812bca3f11d', '', 'Analista de Sistemas', 0),
(29, '1-29658712/10', 'Profesores', '29658712', '207d2beb3d5d002fc855377eb4c9f017', '', 'Profesorado en Primaria', 0),
(35, '1-29687482/08', 'Auxiliares', '29687482', 'fd29c72ffe60942fc1e8ba68e614c45a', '', 'Administrativa Mesa de Entrada', 0),
(45, '1-29687483/08', 'Profesores', '29687483', '8a211d295e591d41ea756025340dcbcd', '', 'Profesor', 0),
(21, '1-29789654/11', 'Alumnos', '29789654', '26b715501001b8ec97e0e4d7dea89eaf', '', 'T.U.G.O.', 0),
(39, '1-30126897/09', 'Alumnos', '30126897', '31a4c888fe1a9b88efb4f378e4188c70', '', 'T.U.G.O.', 0),
(1, '1-30565304/11', 'Alumnos', '30565304', '662ba283f03fca9509033ce5b6c2240a', '', 'Ingenieria en Sistemas', 0),
(14, '1-30566987/12', 'Cuerpo AyA', '30566987', '1ed18472f6d2c06be9660852b34495bc', '', 'T.U.G.O.', 0),
(19, '1-31123456/13', 'Alumnos', '31123456', '74bef89019e6fed60552a46c177040fc', '', 'Ingeniería en Sistemas', 0),
(4, '1-31467522/09', 'Alumnos', '31467522', 'cc57172e5804ce2fc431798282159526', '', 'T.U.S.H.', 0),
(16, '1-31567951/07', 'Profesores', '31567951', 'b29349ac45ade3719ee84f83c4f823f8', '', 'Profesor', 0),
(27, '1-31587488/11', 'Alumnos', '31587488', 'ce8bb0079c6eb3d25740598a8ab952f9', '', 'T.U.G.O.', 0),
(11, '1-31589417/10', 'Profesores', '31589417', '6826358c24d76d66cb24abe65cef368c', '', 'Profesor', 0),
(13, '1-31589717/11', 'Profesores', '31589717', 'f709d7e35a0efef0b0f67b3ea47adbc5', '', 'Analista de Sistemas', 0),
(12, '1-32258431/09', 'Auxiliares', '32258431', '7a975ff70ef740c09f8aa67096595330', '', 'Auxiliar', 0),
(20, '1-32587915/11', 'Alumnos', '32587915', 'ab068bd0100c47b3ad83e1b05cbf44c3', '', 'Profesorado en Primaria', 0),
(34, '1-33248985/10', 'Auxiliares', '33248985', '17324197193689ad45a68e1ec1de98f5', '', 'Jefe de Alumnos', 0),
(23, '1-33587112/12', 'Alumnos', '33587112', 'c0b2013280ed61927c304a5e7d25222c', '', 'Profesorado en Primaria', 0),
(10, '1-33987456/12', 'Cuerpo AyA', '33987456', '0f0a3f24d43061273a7e4498fe991c06', '', 'T.U.S.H.', 0),
(26, '1-35158793/12', 'Alumnos', '35158793', '529a0591ce49de0dd58783e86a784fdc', '', 'Profesorado en Primaria', 0),
(24, '1-7317383/10', 'Alumnos', '7317383', '219d8d814794f596fc5744d223a14219', '', 'Ingeniera Electromecanica', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `integrantes_junta_electoral`
--

CREATE TABLE IF NOT EXISTS `integrantes_junta_electoral` (
  `jun_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `jun_usuario` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `jun_pass` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `jun_claustro` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `jun_cargo` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `jun_dni` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`jun_usuario`),
  UNIQUE KEY `jun_id` (`jun_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `integrantes_junta_electoral`
--

INSERT INTO `integrantes_junta_electoral` (`jun_id`, `jun_usuario`, `jun_pass`, `jun_claustro`, `jun_cargo`, `jun_dni`) VALUES
(1, 'galaretto', 'b7f39e68e1c1307078b79917e8f61fb3', 'Docentes', 'Profesor', '14217897'),
(3, 'jaramillo', '980abc9511ec9ac91992e290eeabafa1', 'Alumnos', 'Estudiante', '29789654');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listas_candidatos`
--

CREATE TABLE IF NOT EXISTS `listas_candidatos` (
  `lis_id` int(10) NOT NULL AUTO_INCREMENT,
  `lis_nombre` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `lis_cant_votos` int(5) unsigned NOT NULL,
  `lis_apo_dni` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `lis_claustro` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `lis_logo` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `lis_fecha_alta` date NOT NULL,
  PRIMARY KEY (`lis_nombre`),
  UNIQUE KEY `lis_id` (`lis_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `listas_candidatos`
--

INSERT INTO `listas_candidatos` (`lis_id`, `lis_nombre`, `lis_cant_votos`, `lis_apo_dni`, `lis_claustro`, `lis_logo`, `lis_fecha_alta`) VALUES
(4, 'Fabrizio', 21, '25468791', 'Profesores', 'Fabrizio.jpg', '2014-10-21'),
(8, 'Lista 71', 0, '25148963', 'Cuerpo AyA', 'Lista 71.jpeg', '2016-10-26'),
(7, 'Lista Civica', 62, '7317383', 'Alumnos', 'Lista Civica.png', '2014-11-04'),
(1, 'Partecipare', 60, '30565304', 'Alumnos', 'Partecipare.png', '2014-11-03'),
(2, 'Racalmuto', 34, '29548782', 'Cuerpo AyA', 'Racalmuto.jpg', '2014-11-04'),
(5, 'Ragusa', 45, '24897128', 'Auxiliares', 'Ragusa.jpg', '2014-10-22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `otros_votos`
--

CREATE TABLE IF NOT EXISTS `otros_votos` (
  `otros_votos_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `otros_votos_nombre` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `otros_votos_cant` int(10) unsigned NOT NULL,
  PRIMARY KEY (`otros_votos_nombre`),
  UNIQUE KEY `otros_votos_id` (`otros_votos_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `otros_votos`
--

INSERT INTO `otros_votos` (`otros_votos_id`, `otros_votos_nombre`, `otros_votos_cant`) VALUES
(1, 'AlumnosBlanco', 0),
(2, 'AlumnosNulo', 0),
(5, 'AuxiliaresBlanco', 0),
(6, 'AuxiliaresNulo', 0),
(7, 'CuerpoAyABlanco', 0),
(8, 'CuerpoAyANulo', 0),
(3, 'ProfesoresBlanco', 0),
(4, 'ProfesoresNulo', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE IF NOT EXISTS `personas` (
  `per_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `per_dni` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `per_apellidos` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `per_nombres` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `per_tel` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `per_email` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `per_fecha_alta` date NOT NULL,
  PRIMARY KEY (`per_dni`),
  UNIQUE KEY `per_id` (`per_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=79 ;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`per_id`, `per_dni`, `per_apellidos`, `per_nombres`, `per_tel`, `per_email`, `per_fecha_alta`) VALUES
(1, '11111111', 'admin', 'admin', '12345678910', 'admin@admin.com', '2014-10-13'),
(24, '1234567', 'Gomez', 'Roberto', '1651561516', 'robertog@hotmail.com', '2014-10-16'),
(28, '12345678', 'Garcia Jerez', 'Gabriel Nicolas', '02974975879', 'garciagarcia@hotmail.com', '2014-10-26'),
(26, '14217897', 'Galaretto', 'Marta', '1654987984', 'martagalaretto@uaco.unpa.edu.ar', '2014-10-18'),
(29, '14324015', 'Aguirre', 'Fany', '0297466117', 'fanyaguirre@hotmail.com', '2014-10-27'),
(33, '16358417', 'Ampuero', 'Jorge', '029751654165', 'Jorgeemail@hotmail.com', '2014-10-15'),
(32, '17410200', 'Alvarez', 'Susana', '0297156464', 'Susana123@gmail.com', '2014-10-06'),
(59, '20588791', 'Villapan', 'Marcela', '0297111566', 'villapan2000@yahoo.com.ar', '2014-11-02'),
(57, '21588791', 'Portrillo', 'Maximiliano', '0297156464', 'portrillito@hotmail.com', '2014-11-01'),
(73, '21971323', 'Vacan', 'Rodrigo', '02974975879', 'vacan@uaco.unpa.edu.ar', '2014-11-05'),
(49, '22158963', 'Lujea', 'Rodrigo', '0297185915', 'lujeaes123@outlook.com', '2014-10-08'),
(76, '22771526', 'García', 'Enrique', '0297111566', 'enriqueg@uaco.unpa.edu.ar', '2014-11-05'),
(72, '22971323', 'Roldan', 'Yolanda', '02974974724', 'rolandd@gmail.com', '2014-11-04'),
(74, '22971523', 'Molinos', 'Fernanda', '02974975879', 'fernandam@uaco.unpa.edu.ar', '2014-11-04'),
(75, '22971777', 'Valdevenito', 'Gerardo', '02974975879', 'vgerardo@uaco.unpa.edu.ar', '2014-11-04'),
(77, '24587963', 'Zapata', 'Marcela', '029715648916', 'zapatamarcela@yahoo.com.ar', '2016-10-16'),
(45, '24888999', 'Guardo', 'Alejandro', '0297466117', 'guardo12345@gmail.com', '2014-10-10'),
(70, '24897127', 'Fernandez', 'Cristina', '02974975879', 'cristinak@hotmail.com', '2014-11-04'),
(60, '24897128', 'Melo', 'Verónica', '0297156464', 'veronicavvv@yahoo.com', '2014-11-02'),
(34, '25148963', 'Amynahuel', 'Gastón', '0297156464', 'gastonamy123@gmail.com', '2014-10-08'),
(58, '25468791', 'Volpe', 'José Luís', '0297156464', 'volpell@yahoo.com.ar', '2014-11-02'),
(55, '25888999', 'Arriola', 'Jorge Pedro', '0297156464', 'arriolaaa@yahoo.com.ar', '2014-11-17'),
(63, '25897128', 'Rodriguez', 'Antonio', '0297156464', 'rodriguez99@gmail.com', '2014-11-02'),
(36, '26258945', 'Avellaneda', 'Beatriz', '02974975879', 'ave5599@hotmail.com', '2014-10-08'),
(30, '27329366', 'Albarracin', 'Manuel', '0297111566', 'manalba@yahoo.com.ar', '2014-10-28'),
(69, '27971321', 'Mártin', 'José', '0297111566', 'martinn99@gmail.com', '2014-11-04'),
(68, '27971323', 'Barrionuevo', 'Nicolás', '0297156464', 'bnicolasn@yahoo.com', '2014-11-03'),
(78, '28333222', 'Peréz', 'José', '0297154123221', 'joseperez25@yahoo.com.ar', '2016-10-22'),
(67, '28486687', 'Guerrero', 'Anabel', '0297185915', 'anabelguerrero123@outlook.com', '2014-11-03'),
(42, '28579153', 'Espina', 'José Manuel', '02974975879', 'Espina546@yahoo.com.ar', '2014-10-15'),
(66, '28589777', 'Mendez', 'Gabriela', '0297466117', 'mendezg32@yahoo.com.ar', '2014-11-03'),
(64, '28589781', 'Powell', 'David', '0297156464', 'davidppp@hotmail.com', '2014-11-03'),
(44, '28697411', 'Gomez', 'Cecilia', '0297156464', 'gomezcecilia@outlook.com', '2014-10-14'),
(52, '28894782', 'Ampuero', 'Graciela', '0297156464', 'ampgra123@outlook.com', '2014-11-11'),
(35, '29548782', 'Barria', 'Carlos', '0297111566', 'barriacarlos@yahoo.com.ar', '2014-10-14'),
(56, '29658712', 'Acanpai', 'Verónica', '0297156464', 'acanpaiveronk@gmail.com', '2014-11-03'),
(62, '29687482', 'Benitez', 'Araceli', '0297156464', 'arabenitez12@outlook.com', '2014-11-02'),
(71, '29687483', 'Joliee', 'Angelina', '02974975879', 'joliee@hotmail.com', '2014-11-12'),
(48, '29789654', 'Jaramillo', 'Celeste Andrea', '0297466117', 'JaramilloJaramillo@hotmail.com', '2014-10-14'),
(65, '30126897', 'Villacorta', 'Mariela', '0297156464', 'villacortaM@yahoo.com.ar', '2014-11-03'),
(27, '30565304', 'Natole Pauwels', 'Gabriel', '02974974724', 'gnatole@yahoo.com.ar', '2014-10-21'),
(41, '30566987', 'De la Mata', 'Alejandra', '0297156464', 'delamata99@outlook.com', '2014-10-14'),
(46, '31123456', 'Heredia', 'Raquel', '0297156464', 'raquel12312@yahoo.com.ar', '2014-10-14'),
(31, '31467522', 'Alonso', 'Amelia', '0297185915', 'Alono_Amelia@lasheras.com.ar', '2014-10-21'),
(43, '31567951', 'Figueroa', 'Ana Mabel', '02974975879', 'figueroaana@gmail.com', '2014-10-09'),
(54, '31587488', 'Arbe Cruz', 'Jonathan', '0297111566', 'jonhyarbe@hotmail.com', '2014-11-17'),
(38, '31589417', 'Castro', 'Ana María', '0297466117', 'castrocastro2@outlook.com', '2014-10-13'),
(40, '31589717', 'Crespo', 'Hernesto', '0297111566', 'Crespo@hotmail.com', '2014-10-13'),
(39, '32258431', 'Ferreira', 'Antonio', '029751654165', 'ferreiraantonio@hotmail.com', '2014-10-13'),
(47, '32587915', 'Inostroza', 'Gerardo', '0297111566', 'gerardocapo@hotmail.com', '2014-10-08'),
(61, '33248985', 'Fraihaut ', 'Gabriel', '0297156464', 'fraigab@hotmail.com', '2014-11-02'),
(50, '33587112', 'Mardones', 'Mónica', '0297111566', 'monica5566@yahoo.com.ar', '2014-10-21'),
(37, '33987456', 'Barrientos', 'Sergio', '02974975879', 'sergiobarrientos@hotmail.com', '2014-10-07'),
(53, '35158793', 'Andrade', 'Jessica', '0297156464', 'andradejjj@gmail.com', '2014-11-26'),
(51, '7317383', 'Amigorena', 'Sixto', '0297156464', 'sixtoamigorena@yahoo.com.ar', '2014-11-25'),
(25, '87654321', 'Apellido', 'Nombre', '29741262358', 'nombre.apellido@yahoo.com', '2014-10-16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proceso_eleccionario`
--

CREATE TABLE IF NOT EXISTS `proceso_eleccionario` (
  `pro_id` int(10) NOT NULL AUTO_INCREMENT,
  `pro_cod` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `pro_nombre` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `pro_fecha_inicio` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pro_fecha_fin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pro_conf` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `pro_fecha_conf` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`pro_cod`),
  UNIQUE KEY `pro_id` (`pro_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `proceso_eleccionario`
--

INSERT INTO `proceso_eleccionario` (`pro_id`, `pro_cod`, `pro_nombre`, `pro_fecha_inicio`, `pro_fecha_fin`, `pro_conf`, `pro_fecha_conf`) VALUES
(1, 'pe2016', 'elecciones consejeros 2016', '2016-11-11 19:00:00', '2016-11-11 20:00:00', 'configurado por: galaretto', '2016-10-26 12:41:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_elecciones`
--

CREATE TABLE IF NOT EXISTS `resultados_elecciones` (
  `res_id` int(11) NOT NULL AUTO_INCREMENT,
  `res_claustro` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `res_lista` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `res_cargo` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `res_dni` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `res_coeficiente` int(2) unsigned NOT NULL,
  `res_sorteo` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`res_dni`),
  UNIQUE KEY `res_id` (`res_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transacciones`
--

CREATE TABLE IF NOT EXISTS `transacciones` (
  `tran_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tran_identificador` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `tran_lista` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`tran_identificador`),
  UNIQUE KEY `tran_id` (`tran_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `usu_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usu_usuario` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `usu_perfil` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`usu_usuario`),
  UNIQUE KEY `usu_id` (`usu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=88 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usu_id`, `usu_usuario`, `usu_perfil`) VALUES
(31, '1-14324015/10', 'Elector'),
(35, '1-16358417/11', 'Elector'),
(34, '1-17410200/12', 'Elector'),
(61, '1-20588791/06', 'Elector'),
(59, '1-21588791/06', 'Elector'),
(75, '1-21971323/05', 'Elector'),
(51, '1-22158963/10', 'Elector'),
(78, '1-22771526/04', 'Elector'),
(74, '1-22971323/05', 'Elector'),
(76, '1-22971523/05', 'Elector'),
(77, '1-22971777/06', 'Elector'),
(47, '1-24888999/09', 'Elector'),
(72, '1-24897127/07', 'Elector'),
(62, '1-24897128/09', 'Elector'),
(36, '1-25148963/10', 'Elector'),
(60, '1-25468791/07', 'Elector'),
(57, '1-25888999/09', 'Elector'),
(65, '1-25897128/09', 'Elector'),
(38, '1-26258945/11', 'Elector'),
(32, '1-27329366/08', 'Elector'),
(71, '1-27971321/08', 'Elector'),
(70, '1-27971323/08', 'Elector'),
(87, '1-28333222/10', 'Elector'),
(69, '1-28486687/10', 'Elector'),
(44, '1-28579153/10', 'Elector'),
(68, '1-28589777/11', 'Elector'),
(66, '1-28589781/10', 'Elector'),
(46, '1-28697411/11', 'Elector'),
(54, '1-28894782/11', 'Elector'),
(37, '1-29548782/07', 'Elector'),
(58, '1-29658712/10', 'Elector'),
(64, '1-29687482/08', 'Elector'),
(73, '1-29687483/08', 'Elector'),
(50, '1-29789654/11', 'Elector'),
(67, '1-30126897/09', 'Elector'),
(29, '1-30565304/11', 'Elector'),
(43, '1-30566987/12', 'Elector'),
(48, '1-31123456/13', 'Elector'),
(33, '1-31467522/09', 'Elector'),
(45, '1-31567951/07', 'Elector'),
(56, '1-31587488/11', 'Elector'),
(40, '1-31589417/10', 'Elector'),
(42, '1-31589717/11', 'Elector'),
(41, '1-32258431/09', 'Elector'),
(49, '1-32587915/11', 'Elector'),
(63, '1-33248985/10', 'Elector'),
(52, '1-33587112/12', 'Elector'),
(39, '1-33987456/12', 'Elector'),
(55, '1-35158793/12', 'Elector'),
(53, '1-7317383/10', 'Elector'),
(27, '1-87654321/14', 'Administrador'),
(79, '24897128', 'Apoderado'),
(81, '25468791', 'Apoderado'),
(82, '29548782', 'Apoderado'),
(83, '30565304', 'Apoderado'),
(84, '7317383', 'Apoderado'),
(1, 'admin', 'Administrador'),
(28, 'galaretto', 'Junta Electoral'),
(86, 'jaramillo', 'Junta Electoral'),
(30, 'pinonoasd', 'Elector'),
(26, 'robertogomez', 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votos`
--

CREATE TABLE IF NOT EXISTS `votos` (
  `voto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `voto_transaccion` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `voto_fecha` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`voto_transaccion`),
  UNIQUE KEY `voto_id` (`voto_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
