-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2026 at 07:12 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12
SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
  time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projetophp`
--
-- --------------------------------------------------------
--
-- Table structure for table `cidades`
--
CREATE TABLE
  `cidades` (
    `id` int (11) NOT NULL,
    `nome` varchar(100) NOT NULL,
    `estado_id` int (11) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `cidades`
--
INSERT INTO
  `cidades` (`id`, `nome`, `estado_id`)
VALUES
  (1, 'Rio Branco', 1),
  (2, 'Maceió', 2),
  (3, 'Macapá', 3),
  (4, 'Manaus', 4),
  (5, 'Salvador', 5),
  (6, 'Porto Seguro', 5),
  (7, 'Lençóis', 5),
  (8, 'Fortaleza', 6),
  (9, 'Jericoacoara', 6),
  (10, 'Brasília', 7),
  (11, 'Vitória', 8),
  (12, 'Guarapari', 8),
  (13, 'Goiânia', 9),
  (14, 'Caldas Novas', 9),
  (15, 'São Luís', 10),
  (16, 'Barreirinhas', 10),
  (17, 'Cuiabá', 11),
  (18, 'Chapada dos Guimarães', 11),
  (19, 'Bonito', 12),
  (20, 'Campo Grande', 12),
  (21, 'Belo Horizonte', 13),
  (22, 'Ouro Preto', 13),
  (23, 'Capitólio', 13),
  (24, 'Belém', 14),
  (25, 'Alter do Chão', 14),
  (26, 'João Pessoa', 15),
  (27, 'Curitiba', 16),
  (28, 'Foz do Iguaçu', 16),
  (29, 'Recife', 17),
  (30, 'Porto de Galinhas', 17),
  (31, 'Teresina', 18),
  (32, 'Rio de Janeiro', 19),
  (33, 'Búzios', 19),
  (34, 'Paraty', 19),
  (35, 'Natal', 20),
  (36, 'Pipa', 20),
  (37, 'Porto Alegre', 21),
  (38, 'Gramado', 21),
  (39, 'Canela', 21),
  (40, 'Porto Velho', 22),
  (41, 'Boa Vista', 23),
  (42, 'Florianópolis', 24),
  (43, 'Balneário Camboriú', 24),
  (44, 'Bombinhas', 24),
  (45, 'São Paulo', 25),
  (46, 'Campos do Jordão', 25),
  (47, 'Santos', 25),
  (48, 'Aparecida', 25),
  (49, 'Aracaju', 26),
  (50, 'Palmas', 27);

-- --------------------------------------------------------
--
-- Table structure for table `estados`
--
CREATE TABLE
  `estados` (`id` int (11) NOT NULL, `sigla` char(2) NOT NULL) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `estados`
--
INSERT INTO
  `estados` (`id`, `sigla`)
VALUES
  (1, 'AC'),
  (2, 'AL'),
  (4, 'AM'),
  (3, 'AP'),
  (5, 'BA'),
  (6, 'CE'),
  (7, 'DF'),
  (8, 'ES'),
  (9, 'GO'),
  (10, 'MA'),
  (13, 'MG'),
  (12, 'MS'),
  (11, 'MT'),
  (14, 'PA'),
  (15, 'PB'),
  (17, 'PE'),
  (18, 'PI'),
  (16, 'PR'),
  (19, 'RJ'),
  (20, 'RN'),
  (22, 'RO'),
  (23, 'RR'),
  (21, 'RS'),
  (24, 'SC'),
  (26, 'SE'),
  (25, 'SP'),
  (27, 'TO');

-- --------------------------------------------------------
--
-- Table structure for table `motoristas`
--
CREATE TABLE
  `motoristas` (
    `id` int (11) NOT NULL,
    `nome` varchar(255) NOT NULL,
    `data_nascimento` date NOT NULL,
    `cpf` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `telefone` varchar(255) NOT NULL,
    `cnh` varchar(255) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `rotas`
--
CREATE TABLE
  `rotas` (
    `id` int (11) NOT NULL,
    `Cidade_inicio` varchar(255) NOT NULL,
    `Estado_inicio` char(2) NOT NULL,
    `Cidade_fim` varchar(255) NOT NULL,
    `Estado_fim` char(2) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `usuario`
--
CREATE TABLE
  `usuario` (
    `id` int (11) NOT NULL,
    `nome` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `senha` varchar(255) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;

--
-- Dumping data for table `usuario`
--
INSERT INTO
  `usuario` (`id`, `nome`, `email`, `senha`)
VALUES
  (
    1,
    'adm',
    'admin@email.com',
    '$2y$10$pt5hx1LzKklLOlv03CLzXOBqz4ZhIr/2hr2ck80ME3rS8dwrixALG'
  );

-- --------------------------------------------------------
--
-- Table structure for table `veiculos`
--
CREATE TABLE
  `veiculos` (
    `id` int (11) NOT NULL,
    `Placa` varchar(255) NOT NULL,
    `Modelo` varchar(255) NOT NULL,
    `Cor` varchar(255) NOT NULL,
    `Fabricante` varchar(255) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `viagens`
--
CREATE TABLE
  `viagens` (
    `id` int (11) NOT NULL,
    `Veiculos_id` int (11) NOT NULL,
    `Motoristas_id` int (11) NOT NULL,
    `rotas_id` int (11) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;

--
-- Indexes for dumped tables
--
--
-- Indexes for table `cidades`
--
ALTER TABLE `cidades` ADD PRIMARY KEY (`id`),
ADD KEY `estado_id` (`estado_id`);

--
-- Indexes for table `estados`
--
ALTER TABLE `estados` ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `sigla` (`sigla`);

--
-- Indexes for table `motoristas`
--
ALTER TABLE `motoristas` ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rotas`
--
ALTER TABLE `rotas` ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario` ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Indexes for table `veiculos`
--
ALTER TABLE `veiculos` ADD PRIMARY KEY (`id`);

--
-- Indexes for table `viagens`
--
ALTER TABLE `viagens` ADD PRIMARY KEY (`id`),
ADD KEY `fk_Viagens_Veiculos1_idx` (`Veiculos_id`),
ADD KEY `fk_Viagens_Motoristas1_idx` (`Motoristas_id`),
ADD KEY `fk_viagens_rotas1_idx` (`rotas_id`);

--
-- AUTO_INCREMENT for dumped tables
--
--
-- AUTO_INCREMENT for table `cidades`
--
ALTER TABLE `cidades` MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 51;

--
-- AUTO_INCREMENT for table `estados`
--
ALTER TABLE `estados` MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 28;

--
-- AUTO_INCREMENT for table `motoristas`
--
ALTER TABLE `motoristas` MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rotas`
--
ALTER TABLE `rotas` MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario` MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT for table `veiculos`
--
ALTER TABLE `veiculos` MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `viagens`
--
ALTER TABLE `viagens` MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--
--
-- Constraints for table `cidades`
--
ALTER TABLE `cidades` ADD CONSTRAINT `cidades_ibfk_1` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`);

--
-- Constraints for table `viagens`
--
ALTER TABLE `viagens` ADD CONSTRAINT `fk_Viagens_Motoristas1` FOREIGN KEY (`Motoristas_id`) REFERENCES `motoristas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_Viagens_Veiculos1` FOREIGN KEY (`Veiculos_id`) REFERENCES `veiculos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_viagens_rotas1` FOREIGN KEY (`rotas_id`) REFERENCES `rotas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;