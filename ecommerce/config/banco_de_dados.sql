-- phpMyAdmin SQL Dump
-- Versão do servidor: 10.4.24-MariaDB
-- Versão do PHP: 8.1.6

-- Criação do Banco de Dados
CREATE DATABASE IF NOT EXISTS `loja_hidrata+` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `loja_hidrata+`;

-- --------------------------------------------------------

-- Tabela: usuarios
-- Armazena os dados dos usuários.
CREATE TABLE `usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `senha` VARCHAR(255) NOT NULL,
  `data_registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserção de um usuário de teste (ID 1)
-- Senha: '123456' (Use um hash real como MD5 ou BCRYPT em produção!)
INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`) VALUES
(1, 'Usuário Teste', 'teste@hidrata.com', 'e10adc3949ba59abbe56e057f20f883e'); -- MD5 de '123456'

-- --------------------------------------------------------

-- Tabela: produtos
-- Armazena os produtos da loja.
CREATE TABLE `produtos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(150) NOT NULL,
  `descricao_curta` VARCHAR(255) NOT NULL,
  `descricao` TEXT NOT NULL,
  `preco` DECIMAL(10,2) NOT NULL,
  `estoque` INT(11) NOT NULL DEFAULT 0,
  `imagem_url` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserção de Produtos de Exemplo
INSERT INTO `produtos` (`id`, `nome`, `descricao_curta`, `descricao`, `preco`, `estoque`, `imagem_url`) VALUES
(1, 'Copo Quencher Stanley | 1.18L', 'Copo térmico ideal para hidratação diária, com alça e canudo.', 'Mantenha-se hidratado o dia todo com o Copo Quencher Stanley de 1.18L. Possui isolamento a vácuo de parede dupla que mantém a temperatura por horas. Inclui alça robusta e canudo reutilizável.', 359.00, 50, 'https://placehold.co/150x200/9370DB/ffffff?text=Copo+Roxo'),
(2, 'Copo Térmico de Cerveja | 473ml', 'Perfeito para manter sua cerveja gelada por até 4 horas.', 'O Copo Térmico de Cerveja de 473ml é o parceiro ideal para o happy hour. Livre de BPA e feito de aço inoxidável, garante durabilidade e mantém a temperatura da sua bebida.', 189.00, 100, 'https://placehold.co/150x200/C0C0C0/333333?text=Copo+Prata'),
(3, 'Garrafa Flip Straw | 700ml', 'Garrafa com bico flip, excelente para esportes e academia.', 'Design ergonômico e bico flip para consumo rápido. Perfeita para quem pratica atividades físicas, garantindo hidratação sem vazamentos.', 149.90, 75, 'https://placehold.co/150x200/00CED1/ffffff?text=Garrafa+Azul');

-- --------------------------------------------------------

-- Tabela: carrinho_itens
-- Armazena os produtos que o usuário (ou sessão) colocou no carrinho.
CREATE TABLE `carrinho_itens` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` INT(11) NOT NULL,
  `produto_id` INT(11) NOT NULL,
  `quantidade` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`produto_id`) REFERENCES `produtos`(`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserção de um item de teste no carrinho do Usuário ID 1
INSERT INTO `carrinho_itens` (`usuario_id`, `produto_id`, `quantidade`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

-- Tabela: pedidos
-- Armazena os dados principais de um pedido finalizado.
CREATE TABLE `pedidos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` INT(11) NOT NULL,
  `data_pedido` DATETIME NOT NULL,
  `total` DECIMAL(10,2) NOT NULL,
  `status` VARCHAR(50) NOT NULL,
  `forma_pagamento` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- Tabela: itens_pedido
-- Armazena os detalhes de cada item dentro de um pedido específico.
CREATE TABLE `itens_pedido` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` INT(11) NOT NULL,
  `produto_id` INT(11) NOT NULL,
  `quantidade` INT(11) NOT NULL,
  `preco_unitario` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`pedido_id`) REFERENCES `pedidos`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`produto_id`) REFERENCES `produtos`(`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;