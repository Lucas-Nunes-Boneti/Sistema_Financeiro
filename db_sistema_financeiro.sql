 -- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02/12/2024 às 15:53
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

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tb_contas_a_pagar`
--
ALTER TABLE `tb_contas_a_pagar`
  ADD PRIMARY KEY (`id_contas_a_pagar`),
  ADD KEY `id_cnpj` (`id_cnpj`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_contas_a_pagar`
--
ALTER TABLE `tb_contas_a_pagar`
  MODIFY `id_contas_a_pagar` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tb_contas_a_pagar`
--
ALTER TABLE `tb_contas_a_pagar`
  ADD CONSTRAINT `tb_contas_a_pagar_ibfk_1` FOREIGN KEY (`id_cnpj`) REFERENCES `tb_fornecedor` (`id_cnpj`),
  ADD CONSTRAINT `tb_contas_a_pagar_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `tb_categoria` (`id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
