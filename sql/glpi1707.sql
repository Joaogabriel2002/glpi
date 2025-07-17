-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17/07/2025 às 19:58
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
-- Banco de dados: `glpi`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `atualizacoes`
--

CREATE TABLE `atualizacoes` (
  `id_atualizacao` int(20) NOT NULL,
  `chamadoId` int(20) DEFAULT NULL,
  `dt_atualizacao` datetime NOT NULL DEFAULT current_timestamp(),
  `tecnico` varchar(100) DEFAULT NULL,
  `comentario` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `avisos`
--

CREATE TABLE `avisos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `mensagem` text DEFAULT NULL,
  `data_postagem` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `chamados`
--

CREATE TABLE `chamados` (
  `chamadoId` int(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `tipoChamado` varchar(20) DEFAULT NULL,
  `tituloChamado` varchar(60) NOT NULL,
  `descricaoChamado` varchar(1000) DEFAULT NULL,
  `dtAbertura` datetime NOT NULL DEFAULT current_timestamp(),
  `dtFechamento` datetime DEFAULT NULL,
  `autorId` int(11) DEFAULT NULL,
  `autorNome` varchar(40) NOT NULL,
  `autorEmail` varchar(60) NOT NULL,
  `autorSetor` varchar(40) NOT NULL,
  `imagemPath` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Acionadores `chamados`
--
DELIMITER $$
CREATE TRIGGER `Data de Fechamento` BEFORE UPDATE ON `chamados` FOR EACH ROW begin 	if new.STATUS='Fechado' then
		set new.dtFechamento = NOW();
	end if;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `equipamentos`
--

CREATE TABLE `equipamentos` (
  `idEquipamento` int(11) NOT NULL,
  `descricaoEquipamento` varchar(100) NOT NULL,
  `tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `estoque`
--

CREATE TABLE `estoque` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `nota_fiscal` varchar(20) DEFAULT NULL,
  `fornecedor` varchar(100) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `tipo_movimentacao` varchar(20) NOT NULL,
  `data_movimentacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `motivo` varchar(100) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cnpj` varchar(18) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `endereco` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `imobilizados`
--

CREATE TABLE `imobilizados` (
  `id` int(11) NOT NULL,
  `patrimonio` varchar(50) DEFAULT NULL,
  `modelo_id` int(11) NOT NULL,
  `localizacao` varchar(100) DEFAULT NULL,
  `nota_fiscal` varchar(50) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Ativo',
  `modelo` varchar(100) DEFAULT NULL,
  `ultima_manutencao` date DEFAULT NULL,
  `prox_manutencao` date DEFAULT NULL,
  `intervalo_manutencao` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Acionadores `imobilizados`
--
DELIMITER $$
CREATE TRIGGER `before_insert_imobilizados` BEFORE INSERT ON `imobilizados` FOR EACH ROW BEGIN
  DECLARE v_descricao VARCHAR(100);

  SELECT tipo INTO v_descricao
  FROM equipamentos
  WHERE idEquipamento = NEW.modelo_id;

  SET NEW.modelo = v_descricao;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `impressora_tonner`
--

CREATE TABLE `impressora_tonner` (
  `id` int(11) NOT NULL,
  `impressoraId` int(11) NOT NULL,
  `modeloTonnerId` int(11) NOT NULL,
  `cor` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens`
--

CREATE TABLE `itens` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `manutencao`
--

CREATE TABLE `manutencao` (
  `id` int(11) NOT NULL,
  `id_imobilizado` int(11) NOT NULL,
  `id_fornecedor` int(11) DEFAULT NULL,
  `dt_envio` date NOT NULL,
  `dt_retorno` date DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `descricao_problema` text DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `movimentacao`
--

CREATE TABLE `movimentacao` (
  `id` int(11) NOT NULL,
  `estoque_id` int(11) DEFAULT NULL,
  `tipo` enum('entrada','baixa') NOT NULL,
  `quantidade` int(11) NOT NULL,
  `data_movimentacao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `setores_locais`
--

CREATE TABLE `setores_locais` (
  `setor` varchar(40) NOT NULL,
  `local` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tarefas`
--

CREATE TABLE `tarefas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `prioridade` enum('baixa','media','alta') DEFAULT 'media',
  `data_prevista` date NOT NULL,
  `status` enum('pendente','em_andamento','concluida') DEFAULT 'pendente',
  `criado_por` int(11) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tarefas_usuarios`
--

CREATE TABLE `tarefas_usuarios` (
  `id` int(11) NOT NULL,
  `id_tarefa` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `status` enum('nao_iniciada','em_andamento','concluida') DEFAULT 'nao_iniciada',
  `hora_inicio` datetime DEFAULT NULL,
  `hora_conclusao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tonneratualizacao`
--

CREATE TABLE `tonneratualizacao` (
  `id_atualizacao` int(20) NOT NULL,
  `solicitacaoId` int(11) NOT NULL,
  `dtAtualizacao` datetime NOT NULL DEFAULT current_timestamp(),
  `tecnico` varchar(100) DEFAULT NULL,
  `situacao` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tonnersolicitacao`
--

CREATE TABLE `tonnersolicitacao` (
  `solicitacaoId` int(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `corTonner` varchar(20) DEFAULT NULL,
  `dtAbertura` datetime NOT NULL DEFAULT current_timestamp(),
  `dtFechamento` datetime DEFAULT NULL,
  `autorId` int(20) NOT NULL,
  `autorNome` varchar(40) NOT NULL,
  `autorEmail` varchar(60) NOT NULL,
  `autorSetor` varchar(40) NOT NULL,
  `situacao` varchar(40) DEFAULT NULL,
  `impressoraId` int(20) NOT NULL,
  `tonnerId` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Acionadores `tonnersolicitacao`
--
DELIMITER $$
CREATE TRIGGER `dtFechamento` BEFORE UPDATE ON `tonnersolicitacao` FOR EACH ROW begin 	if new.STATUS='Fechado' then
		set new.dtFechamento = NOW();
	end if;
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_before_insert_tonnersolicitacao` BEFORE INSERT ON `tonnersolicitacao` FOR EACH ROW BEGIN
  DECLARE v_tonnerId INT;
  SELECT modeloTonnerId INTO v_tonnerId FROM impressora_tonner WHERE impressoraId = NEW.impressoraId LIMIT 1;
  IF v_tonnerId IS NOT NULL THEN
    SET NEW.tonnerId = v_tonnerId;
  ELSE
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Erro: impressoraId sem tonner associado!';
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(20) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `email` varchar(60) NOT NULL,
  `senha` varchar(40) NOT NULL,
  `setor` varchar(40) NOT NULL,
  `local` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Acionadores `usuarios`
--
DELIMITER $$
CREATE TRIGGER `trg_set_local` BEFORE INSERT ON `usuarios` FOR EACH ROW BEGIN
    DECLARE v_local VARCHAR(100);

    -- Busca o local correspondente ao setor
    SELECT local INTO v_local 
    FROM setores_locais
    WHERE setor = NEW.setor
    LIMIT 1;

    -- Define o local para o novo registro
    IF v_local IS NOT NULL THEN
        SET NEW.local = v_local;
    ELSE
        SET NEW.local = 'Local Indefinido';
    END IF;
END
$$
DELIMITER ;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `atualizacoes`
--
ALTER TABLE `atualizacoes`
  ADD PRIMARY KEY (`id_atualizacao`),
  ADD KEY `chamadoId` (`chamadoId`);

--
-- Índices de tabela `avisos`
--
ALTER TABLE `avisos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `chamados`
--
ALTER TABLE `chamados`
  ADD PRIMARY KEY (`chamadoId`);

--
-- Índices de tabela `equipamentos`
--
ALTER TABLE `equipamentos`
  ADD PRIMARY KEY (`idEquipamento`);

--
-- Índices de tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `fk_usuario_id` (`usuario_id`);

--
-- Índices de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cnpj` (`cnpj`);

--
-- Índices de tabela `imobilizados`
--
ALTER TABLE `imobilizados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `modelo_id` (`modelo_id`);

--
-- Índices de tabela `impressora_tonner`
--
ALTER TABLE `impressora_tonner`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unq_impressora_cor` (`impressoraId`,`cor`),
  ADD KEY `impressoraId` (`impressoraId`),
  ADD KEY `modeloTonnerId` (`modeloTonnerId`);

--
-- Índices de tabela `itens`
--
ALTER TABLE `itens`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `manutencao`
--
ALTER TABLE `manutencao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_imobilizado` (`id_imobilizado`),
  ADD KEY `id_fornecedor` (`id_fornecedor`);

--
-- Índices de tabela `movimentacao`
--
ALTER TABLE `movimentacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estoque_id` (`estoque_id`);

--
-- Índices de tabela `setores_locais`
--
ALTER TABLE `setores_locais`
  ADD PRIMARY KEY (`setor`);

--
-- Índices de tabela `tarefas`
--
ALTER TABLE `tarefas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `criado_por` (`criado_por`);

--
-- Índices de tabela `tarefas_usuarios`
--
ALTER TABLE `tarefas_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_tarefa` (`id_tarefa`,`id_usuario`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `tonneratualizacao`
--
ALTER TABLE `tonneratualizacao`
  ADD PRIMARY KEY (`id_atualizacao`),
  ADD KEY `tonnerId` (`solicitacaoId`);

--
-- Índices de tabela `tonnersolicitacao`
--
ALTER TABLE `tonnersolicitacao`
  ADD PRIMARY KEY (`solicitacaoId`),
  ADD KEY `fk_tonner_impressora` (`impressoraId`),
  ADD KEY `fk_tonner_item` (`tonnerId`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `atualizacoes`
--
ALTER TABLE `atualizacoes`
  MODIFY `id_atualizacao` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `avisos`
--
ALTER TABLE `avisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `chamados`
--
ALTER TABLE `chamados`
  MODIFY `chamadoId` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `equipamentos`
--
ALTER TABLE `equipamentos`
  MODIFY `idEquipamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `imobilizados`
--
ALTER TABLE `imobilizados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `impressora_tonner`
--
ALTER TABLE `impressora_tonner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `itens`
--
ALTER TABLE `itens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `manutencao`
--
ALTER TABLE `manutencao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `movimentacao`
--
ALTER TABLE `movimentacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tarefas`
--
ALTER TABLE `tarefas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tarefas_usuarios`
--
ALTER TABLE `tarefas_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tonneratualizacao`
--
ALTER TABLE `tonneratualizacao`
  MODIFY `id_atualizacao` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tonnersolicitacao`
--
ALTER TABLE `tonnersolicitacao`
  MODIFY `solicitacaoId` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `atualizacoes`
--
ALTER TABLE `atualizacoes`
  ADD CONSTRAINT `atualizacoes_ibfk_1` FOREIGN KEY (`chamadoId`) REFERENCES `chamados` (`chamadoId`);

--
-- Restrições para tabelas `estoque`
--
ALTER TABLE `estoque`
  ADD CONSTRAINT `estoque_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `itens` (`id`),
  ADD CONSTRAINT `fk_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `imobilizados`
--
ALTER TABLE `imobilizados`
  ADD CONSTRAINT `imobilizados_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `imobilizados_ibfk_2` FOREIGN KEY (`modelo_id`) REFERENCES `equipamentos` (`idEquipamento`);

--
-- Restrições para tabelas `impressora_tonner`
--
ALTER TABLE `impressora_tonner`
  ADD CONSTRAINT `impressora_tonner_ibfk_1` FOREIGN KEY (`impressoraId`) REFERENCES `equipamentos` (`idEquipamento`),
  ADD CONSTRAINT `impressora_tonner_ibfk_2` FOREIGN KEY (`modeloTonnerId`) REFERENCES `itens` (`id`);

--
-- Restrições para tabelas `manutencao`
--
ALTER TABLE `manutencao`
  ADD CONSTRAINT `manutencao_ibfk_1` FOREIGN KEY (`id_imobilizado`) REFERENCES `imobilizados` (`id`),
  ADD CONSTRAINT `manutencao_ibfk_2` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id`);

--
-- Restrições para tabelas `movimentacao`
--
ALTER TABLE `movimentacao`
  ADD CONSTRAINT `movimentacao_ibfk_1` FOREIGN KEY (`estoque_id`) REFERENCES `estoque` (`id`);

--
-- Restrições para tabelas `tarefas`
--
ALTER TABLE `tarefas`
  ADD CONSTRAINT `tarefas_ibfk_1` FOREIGN KEY (`criado_por`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tarefas_usuarios`
--
ALTER TABLE `tarefas_usuarios`
  ADD CONSTRAINT `tarefas_usuarios_ibfk_1` FOREIGN KEY (`id_tarefa`) REFERENCES `tarefas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tarefas_usuarios_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tonneratualizacao`
--
ALTER TABLE `tonneratualizacao`
  ADD CONSTRAINT `solicitacaoId` FOREIGN KEY (`solicitacaoId`) REFERENCES `tonnersolicitacao` (`solicitacaoId`),
  ADD CONSTRAINT `tonneratualizacao_ibfk_1` FOREIGN KEY (`solicitacaoId`) REFERENCES `tonnersolicitacao` (`solicitacaoId`);

--
-- Restrições para tabelas `tonnersolicitacao`
--
ALTER TABLE `tonnersolicitacao`
  ADD CONSTRAINT `fk_tonner_impressora` FOREIGN KEY (`impressoraId`) REFERENCES `equipamentos` (`idEquipamento`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tonner_item` FOREIGN KEY (`tonnerId`) REFERENCES `itens` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
