-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 08-Jul-2022 às 18:02
-- Versão do servidor: 5.7.33-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sibd_alexandresoares`
--
CREATE DATABASE IF NOT EXISTS `sibd_alexandresoares` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `sibd_alexandresoares`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `ID` int(11) NOT NULL,
  `NOME` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`ID`, `NOME`) VALUES
(1, 'Sem Categoria'),
(5, 'Teste'),
(6, 'Monitor'),
(8, 'Teclado'),
(9, 'Projetor'),
(10, 'Computadores');

-- --------------------------------------------------------

--
-- Estrutura da tabela `equipamento`
--

CREATE TABLE `equipamento` (
  `ID` int(11) NOT NULL,
  `MARCA` varchar(45) DEFAULT NULL,
  `MODELO` varchar(45) DEFAULT NULL,
  `categorias_ID` int(11) NOT NULL DEFAULT '1',
  `ANO` varchar(45) DEFAULT NULL,
  `espaco_ID` int(11) DEFAULT '1',
  `kit_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `equipamento`
--

INSERT INTO `equipamento` (`ID`, `MARCA`, `MODELO`, `categorias_ID`, `ANO`, `espaco_ID`, `kit_ID`) VALUES
(8, 'hp', 'desktop', 10, '2001', 13, 13),
(11, 'idk', 'desktop', 1, '2000', 1, 13),
(16, 'hp', 'teste123', 1, '2020', 1, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `espaco`
--

CREATE TABLE `espaco` (
  `ID` int(11) NOT NULL,
  `NOME` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `espaco`
--

INSERT INTO `espaco` (`ID`, `NOME`) VALUES
(1, 'Armazém'),
(5, 'A.0.BentoQ'),
(6, 'A.06.AEE'),
(7, 'A.07.AEE'),
(8, 'A.08.AEE'),
(9, 'A.09.AEE'),
(10, 'A.1.MadSot'),
(11, 'A.10.AEE'),
(12, 'A.11.AEE'),
(13, 'A.Bibliot'),
(14, 'A.E-1 Gab1'),
(15, 'A.E-1.Rest'),
(16, 'A.E1TrabDT'),
(17, 'A.EF'),
(18, 'A.EF_GIN'),
(19, 'A.EF_SALA'),
(20, 'A.FCT'),
(21, 'B.0.02'),
(22, 'B.0.03'),
(23, 'B.0.04'),
(24, 'B.0.05'),
(26, 'B.0.07'),
(27, 'B.0.08Cn'),
(28, 'B.0.09'),
(29, 'B.0.10'),
(30, 'B.0.11'),
(31, 'B.0.12'),
(32, 'B.0.13'),
(33, 'B.0.14Ms'),
(34, 'B.0.15Fq'),
(35, 'B.1.06'),
(36, 'B.1.07'),
(37, 'B.1.08'),
(38, 'B.1.09'),
(39, 'B.1.10'),
(40, 'B.1.11'),
(41, 'B.1.14'),
(42, 'B.1.15'),
(43, 'B.1.16'),
(44, 'B.1.17'),
(45, 'B.1.18'),
(46, 'B.1.19'),
(47, 'B.1.GAP'),
(48, 'B.2.04'),
(49, 'B.2.05'),
(50, 'B.2.06'),
(51, 'B.2.07'),
(52, 'B.2.10'),
(53, 'B.2.11'),
(54, 'B.2.12'),
(55, 'B.2.13'),
(56, 'B.2.14'),
(57, 'B.2.15'),
(58, 'B.3.Psic'),
(59, 'B2.08.Ga'),
(60, 'B2.09.Ga'),
(61, 'C.0.10CN'),
(62, 'C.0.9 ET'),
(63, 'C.1.Mus'),
(64, 'E.0.15'),
(65, 'E.0.16'),
(66, 'E.0.17'),
(67, 'E.0.18'),
(68, 'E.0.19'),
(69, 'E.0.20'),
(70, 'E.0.21'),
(71, 'E.0.22'),
(72, 'E.0.23'),
(73, 'E.0.24'),
(74, 'E.0.25'),
(75, 'E.0.26'),
(76, 'E.0.27'),
(77, 'E.0.28'),
(78, 'E.0.29'),
(79, 'E.0.30'),
(80, 'E.0.31'),
(81, 'E.0.32'),
(82, 'E.0.33'),
(83, 'E.0.34'),
(84, 'E.0.35'),
(85, 'E.0.36'),
(86, 'E.0.AVCOA'),
(87, 'E.0.Gab2'),
(88, 'E.1.51'),
(89, 'E.1.52'),
(90, 'E.1.53'),
(91, 'E.1.DES'),
(92, 'E.1.ET'),
(93, 'E.1.EV'),
(94, 'E.1.Gab FQ'),
(95, 'E.1.LAB1'),
(96, 'E.1.LAB2'),
(97, 'E.1.LAB3'),
(98, 'E.1.LAB4'),
(99, 'E.1.LAB5'),
(100, 'E.1.LAB6'),
(101, 'E.1.LAB7'),
(102, 'E.1.LMt1'),
(103, 'E.1.LTi1'),
(104, 'E.1.LTi2'),
(105, 'E.1.LTi3'),
(106, 'E.1.LTi5'),
(107, 'E.1.LTi8'),
(108, 'E.1.OfAr'),
(109, 'E.1.TIC6'),
(110, 'E.1.TIC7'),
(111, 'F.0.ELAB'),
(112, 'F.0.ELEC'),
(113, 'F.0.ELMq'),
(114, 'F.0.ELOf'),
(115, 'F.0.MCAD'),
(116, 'F.0.MCAM'),
(117, 'F.0.McOF');

-- --------------------------------------------------------

--
-- Estrutura da tabela `kit`
--

CREATE TABLE `kit` (
  `ID` int(11) NOT NULL,
  `NOME` varchar(45) DEFAULT NULL,
  `espaco_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `kit`
--

INSERT INTO `kit` (`ID`, `NOME`, `espaco_ID`) VALUES
(13, 'Teste', 13),
(14, 'Kit2', 1),
(16, 'ola', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tickets`
--

CREATE TABLE `tickets` (
  `ID` int(11) NOT NULL,
  `DESCRICAO` tinytext,
  `espaco_ID` int(11) NOT NULL,
  `DATAHORA` datetime DEFAULT NULL,
  `ESTADO` tinytext,
  `users_id` int(11) NOT NULL,
  `TITULO` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tickets`
--

INSERT INTO `tickets` (`ID`, `DESCRICAO`, `espaco_ID`, `DATAHORA`, `ESTADO`, `users_id`, `TITULO`) VALUES
(20, 'Teste', 5, '2022-04-19 09:58:01', 'Aberto', 1, 'Projetor nao liga'),
(21, 'PC 2 nao liga', 1, '2022-04-19 09:58:19', 'Em Processamento', 1, 'PC queimou'),
(22, 'Teste', 6, '2022-04-19 09:58:55', 'Fechado', 1, 'Teste'),
(23, 'PC 2 queimou', 1, '2022-04-19 11:39:28', 'Aberto', 1, 'Avaria'),
(24, 'isto é um teste\r\n', 1, '2022-05-31 12:55:41', 'Aberto', 15, 'Teste user tickets'),
(25, 'dwad', 5, '2022-06-14 16:15:48', 'Aberto', 1, 'wdaw');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` char(255) NOT NULL,
  `profile` varchar(15) NOT NULL DEFAULT 'user',
  `avatar` varchar(255) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `profile`, `avatar`) VALUES
(1, 'alex', 'alex@gmail.com', '$2y$10$Sa9QiuZq4iIYARFnqXgW2uBKIKYu22TrDvW0F0d9O8ldr4Z9FJatG', 'Admin', 'https://i.pinimg.com/564x/16/0d/7d/160d7d1142138a3e2198ffd1fb895865.jpg'),
(15, 'alex1', 'alex1@gmail.com', '$2y$10$3ie/0KUnBrIL0NWUyk.q.uJq8uPDgrEaIFi2yTt.X4d1zV.QUWIqe', 'userTickets', ''),
(16, 'alex2', 'alex2@gmail.com', '$2y$10$aQ5RdSYG4klb15OSLyKjkeHFpUvyTndeccnb1QrLvE2SerEgjyWdO', 'user', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `equipamento`
--
ALTER TABLE `equipamento`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_equipamento_categorias_idx` (`categorias_ID`),
  ADD KEY `fk_equipamento_espaco1_idx` (`espaco_ID`),
  ADD KEY `fk_equipamento_kit1_idx` (`kit_ID`);

--
-- Indexes for table `espaco`
--
ALTER TABLE `espaco`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `kit`
--
ALTER TABLE `kit`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_kit_espaco1_idx` (`espaco_ID`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_tickets_espaco_idx` (`espaco_ID`),
  ADD KEY `fk_tickets_users1_idx` (`users_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `equipamento`
--
ALTER TABLE `equipamento`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `espaco`
--
ALTER TABLE `espaco`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;
--
-- AUTO_INCREMENT for table `kit`
--
ALTER TABLE `kit`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `equipamento`
--
ALTER TABLE `equipamento`
  ADD CONSTRAINT `fk_equipamento_categorias` FOREIGN KEY (`categorias_ID`) REFERENCES `categorias` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_equipamento_espaco1` FOREIGN KEY (`espaco_ID`) REFERENCES `espaco` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_equipamento_kit1` FOREIGN KEY (`kit_ID`) REFERENCES `kit` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `kit`
--
ALTER TABLE `kit`
  ADD CONSTRAINT `fk_kit_espaco1` FOREIGN KEY (`espaco_ID`) REFERENCES `espaco` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `fk_tickets_espaco` FOREIGN KEY (`espaco_ID`) REFERENCES `espaco` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tickets_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
