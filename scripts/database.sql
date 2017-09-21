megallantas.com.ar:

Tablas:
	Grupos
	Categorias (marcas)
	Productos
	Ofertas

create database megallantas;

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE IF NOT EXISTS `grupos` (
  `GRP_ID` int(10) NOT NULL AUTO_INCREMENT,
  `GRP_DESCRIPCION` varchar(255) DEFAULT NULL,
  `GRP_ESTADO` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`GRP_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
  `CAT_ID` int(10) NOT NULL AUTO_INCREMENT,
  `GRP_ID` int(10) NOT NULL,
  `CAT_DESCRIPCION` varchar(255) DEFAULT NULL,
  CAT_FOTO varchar(255),
  `CAT_ESTADO` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`CAT_ID`),
  KEY `GRP_ID` (`GRP_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------


--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `PRO_ID` int(10) NOT NULL AUTO_INCREMENT,
  `CAT_ID` int(10) NOT NULL,
  `GRP_ID` int(10) NOT NULL,
  `PRO_DESCRIPCION` varchar(255) DEFAULT NULL,
  `PRO_FOTO` varchar(255) DEFAULT NULL,
  `PRO_PRECIO_COSTO` double(12,2) DEFAULT NULL,
  `PRO_PROVEEDOR` varchar(255) DEFAULT NULL,
  `PRO_ESTADO` int(10) NOT NULL DEFAULT '0',
  `PRO_CODIGO` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`PRO_ID`),
  KEY `CAT_ID` (`CAT_ID`),
  KEY `GRP_ID` (`GRP_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;


--
-- Estructura de tabla para la tabla `ofertas`
--

CREATE TABLE IF NOT EXISTS ofertas (
OFE_ID int(10) NOT NULL AUTO_INCREMENT,
OFE_TITULO varchar(255),
OFE_DESCRIPCION varchar(2000),
OFE_PRECIO double(15,2),
OFE_FOTO varchar(255),
OFE_ESTADO int(10) NOT NULL DEFAULT '0',
PRIMARY KEY (`OFE_ID`) 
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `seguridad` (
  `SEG_ID` int(10) NOT NULL AUTO_INCREMENT,
  `SEG_USER` varchar(255) NOT NULL,
  `SEG_PASS` varchar(255) DEFAULT NULL,
  `SEG_ESTADO` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`SEG_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `seguridad`
--

INSERT INTO `seguridad` (`SEG_ID`, `SEG_USER`, `SEG_PASS`, `SEG_ESTADO`) VALUES
(1, 'admin', 'bf6c0fcef3759e81a7f043fe4dd27b5b', 0);
