-- =============================================
-- Sistema de Controle de Frotas
-- Banco de Dados MySQL
-- =============================================
 
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
 
-- -----------------------------------------------------
-- Schema frota
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `frota` DEFAULT CHARACTER SET utf8mb4;
USE `frota`;
 
-- -----------------------------------------------------
-- Tabela usuario
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `senha` TEXT NOT NULL,
  `perfil` ENUM('admin','operador') DEFAULT 'operador',
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
 
-- -----------------------------------------------------
-- Tabela categoria_veiculo
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `categoria_veiculo` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
 
-- -----------------------------------------------------
-- Tabela veiculo
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `veiculo` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `placa` VARCHAR(10) NOT NULL UNIQUE,
  `modelo` VARCHAR(100) NOT NULL,
  `marca` VARCHAR(100) NOT NULL,
  `ano` YEAR NOT NULL,
  `cor` VARCHAR(50),
  `km_atual` DECIMAL(10,2) DEFAULT 0,
  `status` ENUM('disponivel','em_uso','manutencao','inativo') DEFAULT 'disponivel',
  `categoria_id` INT NOT NULL,
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_veiculo_categoria_idx` (`categoria_id`),
  CONSTRAINT `fk_veiculo_categoria`
    FOREIGN KEY (`categoria_id`) REFERENCES `categoria_veiculo` (`id`)
    ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;
 
-- -----------------------------------------------------
-- Tabela motorista
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `motorista` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `cnh` VARCHAR(20) NOT NULL UNIQUE,
  `categoria_cnh` ENUM('A','B','C','D','E','AB','AC','AD','AE') NOT NULL,
  `validade_cnh` DATE NOT NULL,
  `telefone` VARCHAR(20),
  `email` VARCHAR(255),
  `status` ENUM('ativo','inativo') DEFAULT 'ativo',
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
 
-- -----------------------------------------------------
-- Tabela abastecimento
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `abastecimento` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `veiculo_id` INT NOT NULL,
  `motorista_id` INT NOT NULL,
  `data_abastecimento` DATE NOT NULL,
  `km_abastecimento` DECIMAL(10,2) NOT NULL,
  `litros` DECIMAL(8,3) NOT NULL,
  `valor_litro` DECIMAL(8,3) NOT NULL,
  `valor_total` DECIMAL(10,2) NOT NULL,
  `combustivel` ENUM('gasolina','etanol','diesel','gnv','flex') NOT NULL,
  `posto` VARCHAR(255),
  `observacao` TEXT,
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_abastecimento_veiculo_idx` (`veiculo_id`),
  INDEX `fk_abastecimento_motorista_idx` (`motorista_id`),
  CONSTRAINT `fk_abastecimento_veiculo`
    FOREIGN KEY (`veiculo_id`) REFERENCES `veiculo` (`id`)
    ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_abastecimento_motorista`
    FOREIGN KEY (`motorista_id`) REFERENCES `motorista` (`id`)
    ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;
 
-- -----------------------------------------------------
-- Tabela manutencao
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `manutencao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `veiculo_id` INT NOT NULL,
  `tipo` ENUM('preventiva','corretiva','revisao') NOT NULL,
  `descricao` TEXT NOT NULL,
  `data_entrada` DATE NOT NULL,
  `data_saida` DATE,
  `km_entrada` DECIMAL(10,2) NOT NULL,
  `valor` DECIMAL(10,2),
  `oficina` VARCHAR(255),
  `status` ENUM('aberta','concluida') DEFAULT 'aberta',
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_manutencao_veiculo_idx` (`veiculo_id`),
  CONSTRAINT `fk_manutencao_veiculo`
    FOREIGN KEY (`veiculo_id`) REFERENCES `veiculo` (`id`)
    ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;
 
-- -----------------------------------------------------
-- Tabela viagem
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `viagem` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `veiculo_id` INT NOT NULL,
  `motorista_id` INT NOT NULL,
  `origem` VARCHAR(255) NOT NULL,
  `destino` VARCHAR(255) NOT NULL,
  `data_saida` DATETIME NOT NULL,
  `data_retorno` DATETIME,
  `km_saida` DECIMAL(10,2) NOT NULL,
  `km_retorno` DECIMAL(10,2),
  `motivo` TEXT,
  `status` ENUM('em_andamento','concluida','cancelada') DEFAULT 'em_andamento',
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_viagem_veiculo_idx` (`veiculo_id`),
  INDEX `fk_viagem_motorista_idx` (`motorista_id`),
  CONSTRAINT `fk_viagem_veiculo`
    FOREIGN KEY (`veiculo_id`) REFERENCES `veiculo` (`id`)
    ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_viagem_motorista`
    FOREIGN KEY (`motorista_id`) REFERENCES `motorista` (`id`)
    ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;
 
-- -----------------------------------------------------
-- Dados iniciais
-- -----------------------------------------------------
INSERT INTO `usuario` (`nome`, `email`, `senha`, `perfil`) VALUES
('Administrador', 'admin@frota.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
-- Senha padrão: password
 
INSERT INTO `categoria_veiculo` (`nome`) VALUES
('Passeio'),
('Utilitário'),
('Caminhão'),
('Moto'),
('Van');
 
SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;