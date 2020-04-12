-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-02-2017 a las 18:05:16
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

CREATE TABLE `articulo` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `unidades` int(11) DEFAULT NULL,
  `detalle` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `anuncio` text,
  `mostrar` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`, `descripcion`, `anuncio`, `mostrar`) VALUES
(1, 'Frescos', 'Aquí están los mejores productos frescos del mercado.', NULL, 1),
(2, 'Charcutería y quesos', 'Todo tipo de quesos y la mejor charcutería.', NULL, 1),
(3, 'Lácteos y huevos ', 'Los productos lácteos al mejor precio.', NULL, 1),
(4, 'Bebidas', 'Refréscate con todas las bebidas disponibles.', NULL, 1),
(5, 'Desayunos, Dulces y Pan', 'Los mejores productos para disfrutar del mejor desayuno.', NULL, 1),
(6, 'Congelados', 'Aquí encontrarás todos productos congelados del mercado.', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id` int(11) NOT NULL,
  `estado` char(1) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `cp` int(5) NOT NULL,
  `provincia` char(2) NOT NULL,
  `fecha_pedido` datetime NOT NULL,
  `usuario_id1` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Disparadores `pedido`
--
DELIMITER $$
CREATE TRIGGER `pedido_BEFORE_INSERT` BEFORE INSERT ON `pedido` FOR EACH ROW BEGIN
SET NEW.fecha_pedido = NOW();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `descripcion` text,
  `descuento` decimal(3,1) DEFAULT NULL,
  `anuncio` text,
  `imagen` varchar(30) DEFAULT NULL,
  `pvp` decimal(10,2) NOT NULL,
  `iva` int(2) NOT NULL,
  `stock` int(11) NOT NULL,
  `mostrar` tinyint(1) NOT NULL,
  `finicio_dest` date DEFAULT NULL,
  `ffin_dest` date DEFAULT NULL,
  `destacado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `categoria_id`, `nombre`, `marca`, `descripcion`, `descuento`, `anuncio`, `imagen`, `pvp`, `iva`, `stock`, `mostrar`, `finicio_dest`, `ffin_dest`, `destacado`) VALUES
(26, 1, 'Hueso de canilla blanco', '', '500 gr (2,70 €/Kg.)', NULL, NULL, '1.png', '1.35', 10, 16, 1, '2017-01-01', '2017-03-31', 0),
(27, 1, 'Naranja para zumo', '', 'Malla de 4 Kg de naranjas', NULL, NULL, '2.png', '3.39', 10, 10, 1, '2016-12-01', '2017-02-16', 1),
(28, 1, 'Lechuga Iceberg', '', 'Pieza 1 ud (0,99 €/Kg.)', NULL, NULL, '3.png', '0.99', 10, 6, 1, '2016-12-01', '2017-02-16', 1),
(29, 1, 'Manzana granny', '', 'unidad (275 gr aprox.) (1,59 €/Kg.)', NULL, NULL, '4.png', '0.44', 10, 44, 1, '2017-01-01', '2017-02-28', 1),
(30, 1, 'Solomillo de cerdo', '', '(peso aprox. 585 gr) (7,85 €/Kg.)', NULL, NULL, '5.png', '4.59', 10, 20, 1, '2017-01-03', '2017-02-16', 1),
(31, 1, 'Roler - Hamburguesa de vacuno', '', 'Bandeja 4 uds. (6,25 €/Kg.)', NULL, NULL, '6.png', '2.00', 10, 7, 1, '2017-01-01', '2017-03-31', 1),
(32, 1, 'Limones malla 1 Kg', '', '(1,29 €/ud.)', NULL, NULL, '7.png', '1.29', 10, 0, 1, '2017-01-01', '2017-03-30', 1),
(33, 1, 'Coliflor ud', '', '(2,09 €/ud.)', NULL, NULL, '8.png', '2.09', 10, 6, 1, '2017-01-10', '2017-03-24', 1),
(34, 1, 'Banana', '', 'Unidad (220 gr aprox.) (1,29 €/Kg.)', NULL, NULL, '9.png', '0.28', 10, 30, 1, '2017-01-01', '2017-04-30', 0),
(35, 1, 'Tomate pera', '', 'unidad (140 gr aprox.) (1,99 €/Kg.)', NULL, NULL, '10.png', '0.28', 10, 50, 1, '2017-01-01', '2017-02-28', 1),
(36, 1, 'Pimiento italiano', '', 'Malla 500 gr (2,38 €/Kg.)', NULL, NULL, '11.png', '1.00', 10, 23, 1, '2017-01-01', '2017-03-31', 0),
(37, 1, 'Kiwi unidad (105 gr aprox.)', '', '(2,65 €/Kg.)', NULL, NULL, '12.png', '0.28', 10, 31, 1, '2017-01-01', '2017-03-31', 1),
(38, 1, 'Pollo limpio', '', 'Unidad (peso aprox. 2065 gr)', NULL, NULL, '13.png', '7.33', 10, 30, 1, '2017-01-01', '2017-03-31', 1),
(39, 1, 'Pechugas enteras de pollo', '', 'Bandeja de pechuga (6,30 €/Kg.)', NULL, NULL, '14.jpg', '4.28', 10, 25, 1, '2017-01-01', '2017-03-31', 1),
(40, 1, 'Pimiento rojo malla 500 gr', '', '(1,98 €/Kg.)', NULL, NULL, '15.png', '0.99', 10, 33, 1, '2017-01-01', '2017-02-28', 1),
(41, 3, 'Danone Vitalinea', '', 'Yogur natural desnatado pack 4 ud', NULL, NULL, '17.jpg', '1.00', 10, 23, 1, '2017-01-01', '2017-03-31', 1),
(42, 3, 'Dia leche semidesnatada calcio', '', 'Envase 1l semidesnatada calcio', NULL, NULL, '18.png', '0.71', 10, 35, 1, '2017-01-01', '2017-02-28', 1),
(43, 3, 'DANONE ACTIMEL', '', 'Yogur líquido natural 0% pack 6 uds 100 g', NULL, NULL, '19.jpg', '2.99', 10, 20, 1, '2017-01-01', '2017-02-28', 1),
(44, 3, 'DANONE DANONINO', '', 'petit suisse fresa pack 6 unidades 50 gr', NULL, NULL, '20.jpg', '1.00', 10, 12, 1, '2017-01-01', '2017-03-31', 1),
(45, 3, 'DANONE flan de huevo', '', 'Pack de 6 unidades', NULL, NULL, '21.jpg', '1.55', 10, 12, 1, '2017-01-01', '2017-03-31', 1),
(46, 3, 'REINA natillas con galleta', '', 'Pack 4 unidades 125 g', NULL, NULL, '22.png', '1.15', 10, 14, 1, NULL, NULL, 1),
(47, 3, 'LA RECETA huevos frescos', '', 'Categoria A clase L estuche 12 uds', NULL, NULL, '23.png', '1.35', 10, 12, 1, NULL, NULL, 0),
(48, 3, 'DIA nata para cocinar', '', 'Envase 500 ml', NULL, NULL, '24.png', '1.07', 10, 12, 1, NULL, NULL, 1),
(49, 3, 'DIA batido chocolate', '', 'Botella 1 lt', NULL, NULL, '25.png', '0.85', 10, 23, 1, NULL, NULL, 1),
(51, 3, 'TULIPÁN margarina', '', 'Barqueta 500 g', NULL, NULL, '26.jpg', '1.65', 10, 13, 1, NULL, NULL, 0),
(52, 2, 'DIA salchichas Baviera', '', 'Envase 300 g', NULL, NULL, '27.png', '1.40', 10, 11, 1, NULL, NULL, 0),
(53, 2, 'DIA jamón serrano', '', 'Lonchas sobre 200 g', NULL, NULL, '28.png', '2.93', 10, 23, 1, NULL, NULL, 0),
(54, 2, 'DIA salami extra', '', 'Sobre 225 g', NULL, NULL, '29.png', '1.25', 10, 15, 1, NULL, NULL, 0),
(55, 2, 'DIA salchichas cocktail', '', 'Tarro 180 gr', NULL, NULL, '30.png', '1.79', 10, 15, 1, NULL, NULL, 0),
(56, 2, 'DIA queso tierno', '', 'Pieza 1kg', NULL, NULL, '31.png', '6.54', 10, 13, 1, NULL, NULL, 0),
(57, 2, 'DIA paleta de york', '', 'Envase 1 kg', NULL, NULL, '32.png', '2.99', 10, 12, 1, NULL, NULL, 0),
(58, 2, 'APIS pate higado cerdo', '', 'Lata 200GR', NULL, NULL, '33.jpg', '1.22', 10, 11, 1, NULL, NULL, 0),
(59, 2, 'PRESIDENT crema camembert', '', 'Tarrina 125 gr', NULL, NULL, '34.jpg', '1.65', 10, 23, 1, NULL, NULL, 0),
(60, 2, 'ELPOZO mortadela de pavo', '', 'En lonchas envase 250 gr', NULL, NULL, '35.jpg', '1.50', 10, 12, 1, NULL, NULL, 0),
(61, 2, 'FLOR DE ESGUEVA queso de oveja', '', 'Queso de oveja viejo', NULL, NULL, '36.png', '4.34', 10, 13, 1, NULL, NULL, 0),
(62, 4, 'SAN MIGUEL cerveza rubia nacional', '', 'Pack 6 botellas 25 cl', NULL, NULL, '37.jpg', '2.65', 10, 13, 1, NULL, NULL, 0),
(63, 4, 'DIA cerveza rubia especial', '', 'Pack 6 botellas 33 cl', NULL, NULL, '38.png', '1.99', 10, 15, 1, NULL, NULL, 0),
(64, 4, 'DIA refresco de cola light', '', 'Botella 2 lt', NULL, NULL, '39.png', '0.82', 10, 50, 1, NULL, NULL, 0),
(65, 4, 'DIA néctar light naranja', '', 'Envase 2 lt', NULL, NULL, '40.png', '1.05', 10, 15, 1, NULL, NULL, 0),
(66, 4, 'DIA agua mineral natural', '', 'Botella 5 l', NULL, NULL, '41.png', '0.45', 10, 15, 1, NULL, NULL, 0),
(67, 4, 'AMBAR cerveza rubia nacional', '', 'Pack 6 unidades', NULL, NULL, '42.png', '5.50', 10, 19, 1, NULL, NULL, 0),
(69, 4, 'AQUARIUS bebida refrescante', '', 'Limón pack 9 latas 33 cl', NULL, NULL, '43.jpg', '5.58', 10, 15, 1, NULL, NULL, 0),
(70, 4, 'COCA COLA zero pack', '', 'Pack 12 latas 33 cl', NULL, NULL, '44.jpg', '6.84', 10, 16, 1, NULL, NULL, 0),
(71, 4, 'DIA bebida energética light', '', 'Lata 25 cl', NULL, NULL, '45.png', '0.37', 10, 67, 1, NULL, NULL, 0),
(72, 4, 'DIA néctar light piña', '', 'Pack 6 unidades 200 ml', NULL, NULL, '46.png', '1.16', 10, 23, 1, NULL, NULL, 0),
(73, 5, 'ColaCao soluble', '', 'Caja 3 Kg', NULL, NULL, '47.jpg', '13.95', 10, 23, 1, NULL, NULL, 1),
(74, 5, 'DIA VITAL pan tostado integral', '', 'Paquete 270 gr', NULL, NULL, '48.png', '0.78', 10, 23, 1, NULL, NULL, 0),
(75, 5, 'DONUTS fondant 2 unidades', '', 'Estuche 102 gr', NULL, NULL, '49.jpg', '1.39', 10, 16, 1, NULL, NULL, 0),
(76, 5, 'DIA cereales de chocolate', '', 'Caja 500 gr', NULL, NULL, '50.jpg', '1.89', 10, 29, 1, NULL, NULL, 0),
(77, 5, 'Galletas de mantequilla', '', 'Lata 500 gr', NULL, NULL, '51.png', '2.57', 10, 25, 1, NULL, NULL, 0),
(78, 5, 'DIA cacao instantaneo', '', 'Bote 800 gr', NULL, NULL, '52.jpg', '2.69', 10, 35, 1, NULL, NULL, 0),
(79, 5, 'DIA cereales rellenos de leche', '', 'Paquete 500 gr', NULL, NULL, '53.png', '1.70', 10, 31, 1, NULL, NULL, 0),
(80, 5, 'NOCILLA almendras', '', 'Vaso 190 gr', NULL, NULL, '54.png', '1.99', 10, 34, 1, NULL, NULL, 0),
(81, 5, 'NESCAFE café soluble descafeinado ', '', 'Frasco 100 gr', NULL, NULL, '55.jpg', '3.97', 10, 35, 1, NULL, NULL, 0),
(82, 5, 'ARTIACH Marbú dorada', '', 'Caja 1 Kg', NULL, NULL, '56.png', '2.85', 10, 31, 1, NULL, NULL, 0),
(83, 6, 'Anillas de calamar ', '', 'A la romana Bolsa 500 gr', NULL, NULL, '57.png', '2.70', 10, 15, 1, '2017-01-01', '2017-03-31', 1),
(84, 6, 'FINDUS Salto arroz 3 delicias', '', '3 delicias tradicional Bolsa 500 gr', NULL, NULL, '58.jpg', '2.45', 10, 14, 1, NULL, NULL, 0),
(85, 6, 'DIA canelones de atún', '', 'Caja 600 gr', NULL, NULL, '59.png', '2.19', 10, 15, 1, '2017-01-01', '2017-03-31', 1),
(86, 6, 'LA GULA DEL NORTE gula', '', 'Bandeja 200 gr', NULL, NULL, '60.png', '4.95', 10, 15, 1, NULL, NULL, 0),
(87, 6, 'DIA croquetas de pollo', '', 'Bolsa 500 gr', NULL, NULL, '61.jpg', '0.99', 10, 23, 1, NULL, NULL, 0),
(88, 6, 'DIA menestra especial', '', 'Bolsa 600 gr', NULL, NULL, '62.png', '1.20', 10, 17, 1, NULL, NULL, 0),
(89, 6, 'DIA fingers de pollo', '', 'Bolsa 400 gr', NULL, NULL, '63.png', '2.95', 10, 23, 1, NULL, NULL, 0),
(90, 6, 'McCain patatas fritas', '', 'Bolsa 600 gr forno julienne', NULL, NULL, '64.png', '2.30', 10, 23, 1, NULL, NULL, 0),
(91, 6, 'DIA lasaña de carne', '', 'Caja 600 gr', NULL, NULL, '65.png', '1.89', 10, 15, 1, '2017-01-01', '2017-03-31', 1),
(92, 6, 'DIA helado dulce de leche', '', 'Barqueta 450 gr', NULL, NULL, '66.png', '1.99', 10, 23, 1, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincia`
--

CREATE TABLE `provincia` (
  `id` char(2) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `provincia`
--

INSERT INTO `provincia` (`id`, `nombre`) VALUES
('1', 'Alava'),
('10', 'Cáceres'),
('11', 'Cádiz'),
('12', 'Castellón'),
('13', 'Ciudad Real'),
('14', 'Córdoba'),
('15', 'Coruña (A)'),
('16', 'Cuenca'),
('17', 'Girona'),
('18', 'Granada'),
('19', 'Guadalajara'),
('2', 'Albacete'),
('20', 'Guipzcoa'),
('21', 'Huelva'),
('22', 'Huesca'),
('23', 'Jaén'),
('24', 'León'),
('25', 'Lleida'),
('26', 'Rioja (La)'),
('27', 'Lugo'),
('28', 'Madrid'),
('29', 'Málaga'),
('3', 'Alicante'),
('30', 'Murcia'),
('31', 'Navarra'),
('32', 'Ourense'),
('33', 'Asturias'),
('34', 'Palencia'),
('35', 'Palmas (Las)'),
('36', 'Pontevedra'),
('37', 'Salamanca'),
('38', 'Santa Cruz de Tenerife'),
('39', 'Cantabria'),
('4', 'Almera'),
('40', 'Segovia'),
('41', 'Sevilla'),
('42', 'Soria'),
('43', 'Tarragona'),
('44', 'Teruel'),
('45', 'Toledo'),
('46', 'Valencia'),
('47', 'Valladolid'),
('48', 'Vizcaya'),
('49', 'Zamora'),
('5', 'Avila'),
('50', 'Zaragoza'),
('51', 'Ceuta'),
('52', 'Melilla'),
('6', 'Badajoz'),
('7', 'Balears (Illes)'),
('8', 'Barcelona'),
('9', 'Burgos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(10) NOT NULL,
  `clave` varchar(250) NOT NULL,
  `email` varchar(45) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `dni` varchar(9) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `cp` varchar(5) NOT NULL,
  `provincia_id` char(2) NOT NULL,
  `baja` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `clave`, `email`, `nombre`, `apellidos`, `dni`, `direccion`, `cp`, `provincia_id`, `baja`) VALUES
(4, 'jesus', '$2y$10$nOJdqeNNvTeQ.UVwXMiRaeCeB12E2o5hILnjYIjvtWLfFmEhS1VzO', 'jesusgamedz@gmail.com', 'Jesús', 'Gamero Méndez', '07254317W', 'Barriada El Pomar 13', '06380', '6', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD PRIMARY KEY (`id`,`pedido_id`,`producto_id`),
  ADD KEY `fk_articulos_producto1_idx` (`producto_id`),
  ADD KEY `fk_articulos_pedido` (`pedido_id`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pedido_usuario2_idx` (`usuario_id1`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`,`categoria_id`),
  ADD KEY `fk_producto_categoria1_idx` (`categoria_id`);

--
-- Indices de la tabla `provincia`
--
ALTER TABLE `provincia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`,`provincia_id`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`usuario`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD UNIQUE KEY `dni_UNIQUE` (`dni`),
  ADD KEY `fk_usuario_provincia1_idx` (`provincia_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulo`
--
ALTER TABLE `articulo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD CONSTRAINT `fk_articulos_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedido` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_articulos_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_pedido_usuario2` FOREIGN KEY (`usuario_id1`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_categoria1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_provincia1` FOREIGN KEY (`provincia_id`) REFERENCES `provincia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
