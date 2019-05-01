CREATE SCHEMA IF NOT EXISTS `patterns` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
ALTER DATABASE `patterns` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `patterns` ;

DROP TABLE IF EXISTS `patterns`.`produto` ;

CREATE TABLE IF NOT EXISTS `patterns`.`produto` (
                  `id` INT UNSIGNED NOT NULL,
                  `descricao` TEXT NOT NULL,
                  `estoque` FLOAT NOT NULL,
                  `preco_custo` FLOAT NOT NULL,
                  `preco_venda` FLOAT NOT NULL,
                  `codigo_barras` TEXT NULL,
                  `data_cadastro` DATE NOT NULL,
                  `origem` CHAR(1) NULL,
                  PRIMARY KEY (`id`))ENGINE = InnoDB;