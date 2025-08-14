-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-06-2025 a las 07:58:24
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
-- Base de datos: `base_formulario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulario`
--

CREATE TABLE `formulario` (
  `id_factura` int(9) NOT NULL,
  `nombre_cliente` varchar(40) NOT NULL,
  `numero_documento` varchar(10) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(8) NOT NULL,
  `modelo_vehiculo` varchar(40) NOT NULL,
  `marca_vehiculo` varchar(40) NOT NULL,
  `n_serial` int(17) NOT NULL,
  `nombre_producto` varchar(40) NOT NULL,
  `cantidad_producto` int(9) NOT NULL,
  `precio_unitario` int(9) NOT NULL,
  `precio_iva` int(9) NOT NULL,
  `fecha_factura` date NOT NULL,
  `metodo_pago` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `formulario`
--

INSERT INTO `formulario` (`id_factura`, `nombre_cliente`, `numero_documento`, `direccion`, `telefono`, `modelo_vehiculo`, `marca_vehiculo`, `n_serial`, `nombre_producto`, `cantidad_producto`, `precio_unitario`, `precio_iva`, `fecha_factura`, `metodo_pago`) VALUES
(51, 'PEPE', 'V-31448338', 'AV Candelaria Naiguata marrueco chiquinkira', '04241234', 'versache', 'Ferrary', 2147483647, 'Rueda', 90, 9000000, 10440000, '2025-06-22', 'Efectivo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `formulario`
--
ALTER TABLE `formulario`
  ADD PRIMARY KEY (`id_factura`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `formulario`
--
ALTER TABLE `formulario`
  MODIFY `id_factura` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
