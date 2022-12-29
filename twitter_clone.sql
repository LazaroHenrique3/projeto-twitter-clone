-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29-Dez-2022 às 14:11
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `twitter_clone`
--
CREATE DATABASE IF NOT EXISTS `twitter_clone` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `twitter_clone`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tweets`
--

CREATE TABLE `tweets` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tweet` varchar(140) NOT NULL,
  `data` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tweets`
--

INSERT INTO `tweets` (`id`, `id_usuario`, `tweet`, `data`) VALUES
(2, 2, 'Este é um outro Tweet teste!', '2022-10-13 15:40:04'),
(3, 2, 'Mais um Tweet armazenado com sucesso!', '2022-10-13 16:11:13'),
(4, 2, 'Top demais!', '2022-10-13 16:11:35'),
(5, 2, 'Olá!', '2022-10-13 16:24:27'),
(6, 1, 'Olá teste!', '2022-10-14 14:27:38'),
(7, 2, 'Tweet 5', '2022-10-14 14:55:26'),
(8, 2, 'Tweet 6', '2022-10-14 14:55:31'),
(9, 2, 'Tweet 7', '2022-10-14 14:55:35'),
(12, 2, 'Tweet 8', '2022-10-14 14:56:01'),
(13, 2, 'Tweet 9', '2022-10-14 14:56:06'),
(14, 2, 'Tweet 10', '2022-10-14 14:56:12'),
(15, 2, 'Tweet 11', '2022-10-14 14:56:15'),
(16, 2, 'Tweet 12', '2022-10-14 14:56:21'),
(17, 2, 'Tweet 13', '2022-10-14 14:56:25'),
(18, 2, 'Tweet 14', '2022-10-14 14:56:29'),
(19, 2, 'Tweet 15', '2022-10-14 14:56:37');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`) VALUES
(1, 'Lazaro', 'lazaro@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(2, 'Jamilton', 'jamilton@gmail.com', 'e2fc714c4727ee9395f324cd2e7f331f'),
(3, 'Maria', 'maria@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055'),
(4, 'João', 'joao@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_seguidores`
--

CREATE TABLE `usuarios_seguidores` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_usuario_seguindo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios_seguidores`
--

INSERT INTO `usuarios_seguidores` (`id`, `id_usuario`, `id_usuario_seguindo`) VALUES
(3, 1, 4),
(8, 2, 1),
(9, 1, 2);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tweets`
--
ALTER TABLE `tweets`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios_seguidores`
--
ALTER TABLE `usuarios_seguidores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tweets`
--
ALTER TABLE `tweets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuarios_seguidores`
--
ALTER TABLE `usuarios_seguidores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
