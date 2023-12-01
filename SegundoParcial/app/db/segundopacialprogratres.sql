-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2023 at 12:42 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `segundopacialprogratres`
--

-- --------------------------------------------------------

--
-- Table structure for table `ajustes`
--

CREATE TABLE `ajustes` (
  `id` int(11) NOT NULL,
  `numeroReserva` int(11) NOT NULL,
  `motivo` varchar(50) NOT NULL,
  `nuevoImporte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ajustes`
--

INSERT INTO `ajustes` (`id`, `numeroReserva`, `motivo`, `nuevoImporte`) VALUES
(4, 16, 'parcial', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `numeroCliente` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `tipoDocumento` varchar(50) NOT NULL,
  `numeroDocumento` int(11) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `tipoCliente` varchar(50) NOT NULL,
  `pais` varchar(50) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `telefono` int(11) NOT NULL,
  `modalidadPago` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id`, `numeroCliente`, `nombre`, `apellido`, `tipoDocumento`, `numeroDocumento`, `mail`, `tipoCliente`, `pais`, `ciudad`, `telefono`, `modalidadPago`, `estado`) VALUES
(11, 705640, 'ahuitz', 'briceno', 'dni', 44685740, 'ahuitzcaracciolo@gmail.com', 'individual', 'argentina', 'caba', 1131831276, 'efectivo', 'activo');

-- --------------------------------------------------------

--
-- Table structure for table `movimientos`
--

CREATE TABLE `movimientos` (
  `id` int(11) NOT NULL,
  `request` varchar(50) NOT NULL,
  `nombreUsuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `movimientos`
--

INSERT INTO `movimientos` (`id`, `request`, `nombreUsuario`) VALUES
(6, 'POST /clientes/consultar', 'Ahuitz');

-- --------------------------------------------------------

--
-- Table structure for table `movimientosexitosos`
--

CREATE TABLE `movimientosexitosos` (
  `id` int(11) NOT NULL,
  `operacion` varchar(50) NOT NULL,
  `nombreUsuario` varchar(50) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `movimientosexitosos`
--

INSERT INTO `movimientosexitosos` (`id`, `operacion`, `nombreUsuario`, `fecha`) VALUES
(2, 'POST /clientes/alta', 'Ahuitz', '2023-12-01 20:32:16'),
(3, 'POST /reservas/consultar/10/a', 'Juan', '2023-12-01 20:32:42');

-- --------------------------------------------------------

--
-- Table structure for table `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `fechaDeEntrada` date NOT NULL,
  `fechaDeSalida` date NOT NULL,
  `tipoHabitacion` varchar(50) NOT NULL,
  `importeTotal` int(11) NOT NULL,
  `numeroCliente` int(11) NOT NULL,
  `tipoCliente` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservas`
--

INSERT INTO `reservas` (`id`, `fechaDeEntrada`, `fechaDeSalida`, `tipoHabitacion`, `importeTotal`, `numeroCliente`, `tipoCliente`, `estado`) VALUES
(16, '2023-05-10', '2023-05-20', 'simple', 1000, 872650, 'individual', 'cancelada');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `rol` varchar(50) NOT NULL,
  `clave` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `mail`, `rol`, `clave`) VALUES
(1, 'Ahuitz', 'ahuitzcaracciolo@gmail.com', 'gerente', 'elgaturro'),
(2, 'Juan', 'juan@gmail.com', 'recepcionista', 'eljuan'),
(3, 'Carlos', 'carlos@gmail.com', 'cliente', 'elcarlos');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ajustes`
--
ALTER TABLE `ajustes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movimientosexitosos`
--
ALTER TABLE `movimientosexitosos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ajustes`
--
ALTER TABLE `ajustes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `movimientosexitosos`
--
ALTER TABLE `movimientosexitosos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
