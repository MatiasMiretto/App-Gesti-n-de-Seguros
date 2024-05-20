-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-04-2024 a las 13:19:44
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `solucionesintegrales`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asegurados`
--

CREATE TABLE `asegurados` (
  `ID_Asegurado` int(10) NOT NULL,
  `ID_Cliente` int(10) NOT NULL,
  `Nombre` varchar(70) NOT NULL,
  `Apellidos` varchar(70) NOT NULL,
  `Dni` varchar(100) NOT NULL,
  `Direccion` varchar(200) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Telefono` int(200) NOT NULL,
  `Dom_Reparacion` varchar(200) NOT NULL,
  `Creado` timestamp NOT NULL DEFAULT current_timestamp(),
  `Actualizado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `asegurados`
--

INSERT INTO `asegurados` (`ID_Asegurado`, `ID_Cliente`, `Nombre`, `Apellidos`, `Dni`, `Direccion`, `Email`, `Telefono`, `Dom_Reparacion`, `Creado`, `Actualizado`) VALUES
(1, 3, 'jorge', 'pepe', '54312312a', 'avenida 123', 'asd@gmail.com', 654123123, 'avenida 123', '2024-04-11 10:59:40', '2024-04-26 11:16:03'),
(2, 1, 'Marta', 'Garcia', '23555676A', 'calle 123', 'qwer@gmail.com', 654123812, 'calle 123', '2024-04-23 20:30:35', '2024-04-26 11:15:37'),
(3, 2, 'Lionel', 'Messi', '10101010A', 'qatar 2022', 'el10@gmail.com', 655101010, 'qatar 2022', '2024-04-15 12:58:16', '2024-04-26 11:15:46'),
(5, 1, 'wefqwf', 'qwefqwef', '342134123', 'qfqew 123', 'klnwkwq@gmail.com', 2147483647, 'qwef 123', '2024-04-26 11:02:56', '2024-04-26 11:16:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `averias`
--

CREATE TABLE `averias` (
  `ID_Averia` int(10) NOT NULL,
  `Cliente` varchar(70) NOT NULL,
  `Asegurado` varchar(100) NOT NULL,
  `Fecha` date NOT NULL,
  `Descripcion` varchar(350) NOT NULL,
  `Creado` timestamp NOT NULL DEFAULT current_timestamp(),
  `Actualizado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `averias`
--

INSERT INTO `averias` (`ID_Averia`, `Cliente`, `Asegurado`, `Fecha`, `Descripcion`, `Creado`, `Actualizado`) VALUES
(6, 'Seguros Hogar', 'jorge pepe', '2024-04-19', 'fg ergw erg werg weg 34t erg', '2024-04-18 09:47:27', '2024-04-18 09:47:27'),
(8, 'Salvese quien pueda', 'Marta Garcia', '2024-04-25', 'ueruy qweruy we quyewr', '2024-04-23 00:06:46', '2024-04-23 00:06:46'),
(9, 'Seguros Hogar', 'Lionel Messi', '2024-05-10', 'fqwef qwef qwef fefefe', '2024-04-24 07:54:02', '2024-04-24 07:54:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `ID_Cliente` int(10) NOT NULL,
  `Nombre` varchar(70) NOT NULL,
  `Direccion` varchar(200) NOT NULL,
  `Cif` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Telefono` int(200) NOT NULL,
  `Persona_Contacto` varchar(300) NOT NULL,
  `Creado` timestamp NOT NULL DEFAULT current_timestamp(),
  `Actualizado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`ID_Cliente`, `Nombre`, `Direccion`, `Cif`, `Email`, `Telefono`, `Persona_Contacto`, `Creado`, `Actualizado`) VALUES
(1, 'Seguros Hogar', 'Avenida 456', 'a123444123', 'seguros@gmail.com', 654654654, 'Jorge', '2024-04-04 12:08:34', '2024-04-06 18:26:35'),
(2, 'Salvese quien pueda', 'calle 1343', 'a321321321', 'sqp@gmail.com', 666123123, 'Lorenzo', '2024-04-06 16:22:34', '2024-04-23 20:42:12'),
(3, 'SafeHome', 'calle segura', 'a321123123', 'safe@gmail.com', 655123123, 'Patricio', '2024-04-06 16:51:59', '2024-04-11 10:57:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `ID_Pago` int(10) NOT NULL,
  `ID_Averia` int(10) NOT NULL,
  `Monto` int(100) NOT NULL,
  `Metodo_Pago` varchar(30) NOT NULL,
  `Fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajadores`
--

CREATE TABLE `trabajadores` (
  `ID_Trabajador` int(10) NOT NULL,
  `ID_Cliente` int(10) NOT NULL,
  `Numero_SS` varchar(100) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `Apellidos` varchar(60) NOT NULL,
  `Telefono` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ID_Usuario` int(10) NOT NULL,
  `Nombre` varchar(70) NOT NULL,
  `Apellido` varchar(70) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Tipo_Usuario` varchar(30) NOT NULL,
  `Clave` varchar(200) NOT NULL,
  `Foto` varchar(535) NOT NULL,
  `Creado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Actualizado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID_Usuario`, `Nombre`, `Apellido`, `Email`, `Tipo_Usuario`, `Clave`, `Foto`, `Creado`, `Actualizado`) VALUES
(1, 'Administrador', 'Principal', 'admin@gmail.com', 'Administrador', '$2y$10$QiiE7GXAcgqjBzIaP3nG0.9C0azpdWfd3DixR6oMZ1SapPhVm5cim', '', '2024-04-19 08:08:13', '2024-04-19 08:08:13'),
(12, 'SOn', 'Goku', 'qwdf@gmail.com', 'dqwdf', '$2y$10$14p0Jc0qxbxjO7xSQw0JDe2iDRpE2tXcn7ySJ3PnYM/bbapKv5k56', '', '2024-04-22 22:11:57', '2024-04-22 22:11:57'),
(13, 'Josefa', 'Calderon', 'qweohhh@gmail.com', 'escritura', '$2y$10$IHr4z46eMs2vt4wkTuJTpueBkjefJj6lub/2EnnO1UA86T4PT3YjO', '', '2024-04-22 23:08:18', '2024-04-22 23:08:18');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asegurados`
--
ALTER TABLE `asegurados`
  ADD PRIMARY KEY (`ID_Asegurado`),
  ADD KEY `FK_ID_Cliente` (`ID_Cliente`);

--
-- Indices de la tabla `averias`
--
ALTER TABLE `averias`
  ADD PRIMARY KEY (`ID_Averia`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`ID_Cliente`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`ID_Pago`),
  ADD KEY `FK_ID_Averia` (`ID_Averia`);

--
-- Indices de la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  ADD PRIMARY KEY (`ID_Trabajador`),
  ADD KEY `FK_ID_Cliente` (`ID_Cliente`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID_Usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asegurados`
--
ALTER TABLE `asegurados`
  MODIFY `ID_Asegurado` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `averias`
--
ALTER TABLE `averias`
  MODIFY `ID_Averia` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `ID_Cliente` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `ID_Pago` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  MODIFY `ID_Trabajador` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_Usuario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`ID_Averia`) REFERENCES `averias` (`ID_Averia`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  ADD CONSTRAINT `FK_cliente_id` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
