-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/11/2024 às 14:51
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_sistema_financeiro`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_categoria`
--

CREATE TABLE `tb_categoria` (
  `id_categoria` int(11) NOT NULL,
  `nome_categoria` varchar(45) NOT NULL,
  `tipo_de_categoria` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_contas_a_pagar`
--

CREATE TABLE `tb_contas_a_pagar` (
  `id_contas_a_pagar` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `data_vencimento` date NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `valor` float NOT NULL,
  `statuss` varchar(100) NOT NULL,
  `id_cnpj` char(14) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_contas_a_receber`
--

CREATE TABLE `tb_contas_a_receber` (
  `id_contas_a_receber` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `valor` float NOT NULL,
  `data_vencimento` date NOT NULL,
  `data_recebimento` date NOT NULL,
  `statuss` varchar(100) NOT NULL,
  `parcelas` varchar(100) NOT NULL,
  `cpf` char(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_fornecedor`
--

CREATE TABLE `tb_fornecedor` (
  `id_cnpj` char(14) NOT NULL,
  `nome` char(100) NOT NULL,
  `endereco` char(14) NOT NULL,
  `telefone` char(14) NOT NULL,
  `email` char(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `cpf` varchar(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `sexo` varchar(100) NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  `profissao` varchar(50) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `foto_cliente` varchar(255) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tb_categoria`
--
ALTER TABLE `tb_categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Índices de tabela `tb_contas_a_pagar`
--
ALTER TABLE `tb_contas_a_pagar`
  ADD PRIMARY KEY (`id_contas_a_pagar`),
  ADD KEY `id_cnpj` (`id_cnpj`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Índices de tabela `tb_contas_a_receber`
--
ALTER TABLE `tb_contas_a_receber`
  ADD PRIMARY KEY (`id_contas_a_receber`),
  ADD KEY `cpf` (`cpf`);

--
-- Índices de tabela `tb_fornecedor`
--
ALTER TABLE `tb_fornecedor`
  ADD PRIMARY KEY (`id_cnpj`);

--
-- Índices de tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`cpf`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_contas_a_pagar`
--
ALTER TABLE `tb_contas_a_pagar`
  MODIFY `id_contas_a_pagar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_contas_a_receber`
--
ALTER TABLE `tb_contas_a_receber`
  MODIFY `id_contas_a_receber` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tb_contas_a_pagar`
--
ALTER TABLE `tb_contas_a_pagar`
  ADD CONSTRAINT `tb_contas_a_pagar_ibfk_1` FOREIGN KEY (`id_cnpj`) REFERENCES `tb_fornecedor` (`id_cnpj`),
  ADD CONSTRAINT `tb_contas_a_pagar_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `tb_categoria` (`id_categoria`);

--
-- Restrições para tabelas `tb_contas_a_receber`
--
ALTER TABLE `tb_contas_a_receber`
  ADD CONSTRAINT `tb_contas_a_receber_ibfk_1` FOREIGN KEY (`cpf`) REFERENCES `tb_usuario` (`cpf`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
