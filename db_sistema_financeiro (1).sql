-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18/11/2024 às 12:40
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
-- Estrutura para tabela `tb_contas`
--

CREATE TABLE `tb_contas` (
  `id_conta` int(11) NOT NULL,
  `nome_conta` varchar(45) NOT NULL,
  `tipo_conta` varchar(45) NOT NULL,
  `saldo_atual` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_contas_pagar`
--

CREATE TABLE `tb_contas_pagar` (
  `idcontaspagar` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao_dispesa` varchar(100) NOT NULL,
  `data_vencimento` date NOT NULL,
  `valor` float NOT NULL,
  `idcategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_contas_receber`
--

CREATE TABLE `tb_contas_receber` (
  `idcontasreceber` int(11) NOT NULL,
  `nome_cliente` varchar(100) NOT NULL,
  `descricao_receita` varchar(100) NOT NULL,
  `data_recebimento` date NOT NULL,
  `valor` float NOT NULL,
  `idcategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_lancamentos`
--

CREATE TABLE `tb_lancamentos` (
  `id_lancamento` int(11) NOT NULL,
  `data_lancamento` date NOT NULL,
  `descricao` varchar(45) NOT NULL,
  `valor` float NOT NULL,
  `tipo_lancamento` varchar(45) NOT NULL,
  `cpf_usuario` char(14) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_conta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_relatorio`
--

CREATE TABLE `tb_relatorio` (
  `id_relatorio` int(11) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `total_receitas` float NOT NULL,
  `total_despesas` float NOT NULL,
  `saldo` float NOT NULL,
  `cpf_usuario` char(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `cpf` char(14) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` char(14) NOT NULL,
  `senha` char(8) NOT NULL,
  `confirma_senha` char(8) NOT NULL,
  `sexo` varchar(45) NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  `profissao` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `endereco` varchar(100) DEFAULT NULL,
  `cep` char(9) DEFAULT NULL,
  `numero` char(100) DEFAULT NULL,
  `foto_cliente` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tb_categoria`
--
ALTER TABLE `tb_categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Índices de tabela `tb_contas`
--
ALTER TABLE `tb_contas`
  ADD PRIMARY KEY (`id_conta`);

--
-- Índices de tabela `tb_contas_pagar`
--
ALTER TABLE `tb_contas_pagar`
  ADD PRIMARY KEY (`idcontaspagar`),
  ADD KEY `idcategoria` (`idcategoria`);

--
-- Índices de tabela `tb_contas_receber`
--
ALTER TABLE `tb_contas_receber`
  ADD PRIMARY KEY (`idcontasreceber`),
  ADD KEY `idcategoria` (`idcategoria`);

--
-- Índices de tabela `tb_lancamentos`
--
ALTER TABLE `tb_lancamentos`
  ADD PRIMARY KEY (`id_lancamento`),
  ADD KEY `cpf_usuario` (`cpf_usuario`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_conta` (`id_conta`);

--
-- Índices de tabela `tb_relatorio`
--
ALTER TABLE `tb_relatorio`
  ADD PRIMARY KEY (`id_relatorio`),
  ADD KEY `cpf_usuario` (`cpf_usuario`);

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
-- AUTO_INCREMENT de tabela `tb_contas_pagar`
--
ALTER TABLE `tb_contas_pagar`
  MODIFY `idcontaspagar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_contas_receber`
--
ALTER TABLE `tb_contas_receber`
  MODIFY `idcontasreceber` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tb_contas_pagar`
--
ALTER TABLE `tb_contas_pagar`
  ADD CONSTRAINT `tb_contas_pagar_ibfk_1` FOREIGN KEY (`idcategoria`) REFERENCES `tb_categoria` (`id_categoria`);

--
-- Restrições para tabelas `tb_contas_receber`
--
ALTER TABLE `tb_contas_receber`
  ADD CONSTRAINT `tb_contas_receber_ibfk_1` FOREIGN KEY (`idcategoria`) REFERENCES `tb_categoria` (`id_categoria`);

--
-- Restrições para tabelas `tb_lancamentos`
--
ALTER TABLE `tb_lancamentos`
  ADD CONSTRAINT `tb_lancamentos_ibfk_1` FOREIGN KEY (`cpf_usuario`) REFERENCES `tb_usuario` (`cpf`),
  ADD CONSTRAINT `tb_lancamentos_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `tb_categoria` (`id_categoria`),
  ADD CONSTRAINT `tb_lancamentos_ibfk_3` FOREIGN KEY (`id_conta`) REFERENCES `tb_contas` (`id_conta`);

--
-- Restrições para tabelas `tb_relatorio`
--
ALTER TABLE `tb_relatorio`
  ADD CONSTRAINT `tb_relatorio_ibfk_1` FOREIGN KEY (`cpf_usuario`) REFERENCES `tb_usuario` (`cpf`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
