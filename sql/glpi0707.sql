-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07/07/2025 às 18:52
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

--
-- Despejando dados para a tabela `atualizacoes`
--

INSERT INTO `atualizacoes` (`id_atualizacao`, `chamadoId`, `dt_atualizacao`, `tecnico`, `comentario`) VALUES
(2, 1063, '2025-06-16 13:39:04', 'Bernardo', 'Inicializando contagem'),
(4, 1071, '2025-06-18 15:25:00', 'João', 'Realizando cotação do material...'),
(5, 1071, '2025-06-18 16:57:09', 'João', 'Realizado a compra do material'),
(6, 1073, '2025-06-18 17:23:37', 'João', 'Solicitação de compra aprovada pela Dalvina, estarei dando sequencia na aquisição'),
(7, 1074, '2025-06-19 13:35:00', 'João', 'Descendo no setor para fazer a verificação do Switch/Unifi'),
(8, 1074, '2025-06-19 14:01:23', 'João', 'Feito o reinicio do switch, no aguardo do retorno do usuário para verificar se o problema persiste'),
(9, 1074, '2025-06-19 16:58:58', 'João', 'Confirmado com a Larissa a estabilidade na rede do setor, encerrando chamado.'),
(10, 1071, '2025-06-20 09:50:53', 'Bernardo', 'Cilindro trocado'),
(11, 1077, '2025-06-20 11:37:19', 'João', 'A caminho do setor para verificar o Switch'),
(12, 1077, '2025-06-20 12:54:54', 'João', 'Problema era no wifi do celular da Adriana. Foi feito a configuração de acesso novamente'),
(13, 1072, '2025-06-20 13:00:51', 'João', 'E-mails criados. Em sequencia estarei fazendo a instalação nas máquinas'),
(14, 1080, '2025-06-20 13:20:27', 'João', 'Pendencia da Pelissari. Chamado Aberto'),
(15, 1079, '2025-06-20 13:21:35', 'João', 'Fornecedor de serviços acionado. Estarei realizando a troca por uma impressora de outro setor, e vou encaminhar a com defeito para o conserto.'),
(16, 1075, '2025-06-20 13:22:05', 'João', 'Alesson foi acionado, a principio o erro estava na liberação de permissões do usuario'),
(17, 1079, '2025-06-20 14:03:33', 'João', 'Impressora enviada para o conserto. Vai ser utilizado a impressora do laboratorio de analise de granel do saneantes'),
(18, 1081, '2025-06-20 14:20:22', 'Bernardo', 'Instalado, ver posteriormente questao do cabo de rede'),
(19, 1080, '2025-06-20 14:54:03', 'João', 'teste'),
(20, 1073, '2025-06-20 15:07:40', 'Bernardo', 'Monitor instalado no setor comercial'),
(21, 1087, '2025-06-20 16:01:56', 'João', 'Solicitação de compra aprovada pela Dalvina'),
(22, 1088, '2025-06-23 08:44:47', 'João', 'Foi atualizado a forma de utilização da VPN. Alterado da VPN padrão do windows para o Software OPENVPN'),
(23, 1072, '2025-06-23 09:21:36', 'João', 'Email comercialsul@chesiquimica.com.br configurado na máquina da nova colaboradora: Valéria'),
(24, 1087, '2025-06-23 09:22:13', 'João', 'Feito a solicitação de compra para o Financeiro'),
(25, 1087, '2025-06-23 13:27:57', 'João', 'Feito a compra do notebook'),
(26, 1091, '2025-06-24 09:36:48', 'João', 'Agendado uma visita da parte da Pelissari e o pessoal do Elói para amanha (25/06) a partir das 15'),
(27, 1090, '2025-06-24 09:55:02', 'João', 'Solicitado a liberação para a Pelissari'),
(28, 1090, '2025-06-24 10:14:07', 'João', 'IP liberado'),
(29, 1094, '2025-06-24 16:22:31', 'João', 'Feito o deslocamento até o local. Identificado que a impressora não estava conectada corretamente no cabo de enthernet.'),
(30, 1095, '2025-06-24 16:31:55', 'João', 'Solicitação recebida. Amanhã será destinado um teclado para a Cinthia e um teclado para o computador do Jhonathan'),
(31, 1097, '2025-06-25 09:33:37', 'João', 'Foi feito o reset do computador. Estava travando na tela de inicialização da BIOS'),
(32, 1095, '2025-06-25 09:42:47', 'Bernardo', 'Teclados novos instalados'),
(33, 1098, '2025-06-25 12:19:35', 'João', 'Nobreaks enviados para o fornecedor de serviços'),
(34, 1093, '2025-06-25 12:20:10', 'João', 'Feito a configuração do usuário do whats app utilizado pelo departamento da Manunteção'),
(35, 1079, '2025-06-25 12:22:55', 'João', 'Impressora retornou do conserto, vou estar realizando a instalação no departamento e encaminhando a nota de serviço para o financeiro'),
(36, 1091, '2025-06-25 16:15:55', 'João', 'Visita realizada, ficou pendente de passar os ips dos celulares de :\r\nJadson, Edenilson e do Guardião'),
(37, 1092, '2025-06-25 16:32:01', 'João', 'Iniciando processo de cotação'),
(38, 1092, '2025-06-25 16:37:49', 'João', 'Compra efetuada, prazo de entrega: 27/06 (sexta-feira)'),
(39, 1098, '2025-06-26 10:16:00', 'João', 'Nobreaks retornaram do conserto, estarei destinando aos respectivos setores'),
(40, 1079, '2025-06-26 10:18:35', 'João', 'Impressora instalada. \r\nIdentificação de conserto: Zebra ZD220; Patrimônio: 0305'),
(41, 1098, '2025-06-27 16:39:06', 'João', 'Nobreak instalado no computador do laboratório de análise, outro nobreak armazenado em estoque'),
(42, 1075, '2025-06-27 16:39:28', 'João', 'Relatório funcionou, teste realizado com o usuário'),
(43, 1072, '2025-06-27 16:40:01', 'João', 'Email comercialnortenordeste instalado, será utilizado pelo usuário Bruna'),
(44, 1087, '2025-06-27 16:41:13', 'João', 'Notebook entregue pelo fornecedor'),
(45, 1092, '2025-06-27 16:41:29', 'João', 'Material entregue'),
(46, 1105, '2025-06-30 16:50:05', 'João', 'Cabo atrás da máquina esta com mal contato.'),
(47, 1099, '2025-07-01 13:01:06', 'João', 'Feito a desinstalação das seguintes máquinas: Apontamento aerossol, saneantes.\r\nLaboratório Aerossol, Saneantes'),
(48, 1087, '2025-07-01 13:01:26', 'João', 'Realizando a configuração da máquina'),
(49, 1116, '2025-07-01 13:34:50', 'Bernardo', 'Arrumado com suporte da plss'),
(50, 1117, '2025-07-02 07:40:21', 'João', 'Impressora com problema de reabastecimento, esta vazando e falhando a impressão.\r\n\r\nEstaremos encaminhando uma impressora temporária e enviando essa para o conserto'),
(51, 1117, '2025-07-02 15:53:27', 'Bernardo', 'Impressora redirecionada pro conserto e remanejada uma nova pro comercial'),
(52, 1087, '2025-07-02 15:54:36', 'Bernardo', 'notebook entregue à ketlin'),
(53, 1091, '2025-07-03 08:32:56', 'João', 'Ip do Jadson: 172.20.90.55'),
(54, 1122, '2025-07-03 08:45:45', 'João', 'Indo até o local'),
(55, 1122, '2025-07-03 08:46:39', 'João', 'Estava com problema no download do WEBClient na execução do acesso ao Protheus, realizei a transferência do arquivo da minha máquina e instalei\r\n\r\nFiz o teste e funcionou'),
(56, 1072, '2025-07-03 09:08:27', 'João', 'E-mail comercialcentrosudeste sera instalado na máquina da Graziela'),
(57, 1123, '2025-07-03 14:32:23', 'Bernardo', 'Maquinas realocadas aos lugares novos'),
(58, 1124, '2025-07-04 08:53:47', 'João', 'E-mail criado, estaremos realizando a instalação: comercialcentrosudeste@chesiquimica.com.br'),
(59, 1065, '2025-07-04 08:58:07', 'João', 'teste'),
(60, 1124, '2025-07-04 10:00:12', 'Bernardo', 'instalado o email comercialcentrosudeste@chesiquimica.com.br'),
(61, 1121, '2025-07-04 10:00:32', 'Bernardo', 'entregue mouse e grampeador'),
(62, 1127, '2025-07-04 10:29:42', 'Bernardo', 'atualizacao teste'),
(63, 1125, '2025-07-04 11:19:55', 'Bernardo', 'Foi criado um chamado unificado para melhor organização'),
(64, 1129, '2025-07-04 13:26:52', 'João', 'Identificado como bloqueio de acesso ao site da Receita, estarei entrando em contato com o suporte para liberar o acesso'),
(65, 1131, '2025-07-04 14:49:47', 'Bernardo', 'Planilha criada e repassada ao paulo'),
(66, 1130, '2025-07-04 14:50:21', 'Bernardo', 'Computador nao tinha entrada de cabo de rede'),
(67, 1083, '2025-07-04 15:06:37', 'Bernardo', 'Todas as meninas do comercial ja foram instruidas quanto ao sistema do GLPI'),
(68, 1132, '2025-07-04 16:57:27', 'João', 'Identificado problema na geração da etiqueta pelo label View'),
(69, 1129, '2025-07-04 17:17:04', 'João', 'Feito a liberação do firewall que estava bloqueando o acesso.\r\n\r\nChamado finalizado junto com a PLSS'),
(70, 1133, '2025-07-07 09:39:44', 'Bernardo', 'switch reiniciado');

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

--
-- Despejando dados para a tabela `avisos`
--

INSERT INTO `avisos` (`id`, `titulo`, `mensagem`, `data_postagem`) VALUES
(1, 'Chuva', 'Vai chover amanha, tragam guarda chuva', '2025-06-30 14:15:43'),
(2, 'Bem-vindo ao sistema!', 'Este é um aviso de exemplo para testar o mural.', '2025-06-30 14:23:33'),
(3, 'Aviso Grande para Teste', 'A expressão Lorem ipsum em design gráfico e editoração é um texto padrão em latim utilizado na produção gráfica para preencher os espaços de texto em publicações para testar e ajustar aspectos visuais antes de utilizar conteúdo real.\r\n A expressão Lorem ipsum em design gráfico e editoração é um texto padrão em latim utilizado na produção gráfica para preencher os espaços de texto em publicações para testar e ajustar aspectos visuais antes de utilizar conteúdo real.', '2025-06-30 14:59:37');

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
  `autorSetor` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chamados`
--

INSERT INTO `chamados` (`chamadoId`, `status`, `tipoChamado`, `tituloChamado`, `descricaoChamado`, `dtAbertura`, `dtFechamento`, `autorId`, `autorNome`, `autorEmail`, `autorSetor`) VALUES
(1063, 'Fechado', 'Baixa', 'Inventário T.I.', 'Realizar contagem dos itens do armário de T.I. para fins de controle de estoque', '2025-06-16 13:37:24', '2025-06-20 13:07:16', 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1064, 'Fechado', 'Média', 'Etiqueta desconfigurada', 'Jonathan da filial esta com problemas na impressão de algumas etiquetas menores. Solicitou um apoio para tentar configurar ela corretamente', '2025-06-17 13:04:53', '2025-06-18 12:35:34', 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1065, 'Aberto', 'Baixa', 'Treinamento de Sistema: Setor Compras/PCP', 'Realizar treinamento de utilização do sistema com o pessoal, instruir a abertura de chamados e orientar a criação de usuários', '2025-06-17 13:09:11', NULL, 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1066, 'Aberto', 'Baixa', 'Treinamento de Sistema: Setor Logistica/Adm', 'Realizar treinamento de utilização do sistema com o pessoal, instruir a abertura de chamados e orientar a criação de usuários', '2025-06-17 13:09:26', NULL, 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1067, 'Fechado', 'Baixa', 'Treinamento de Sistema: Setor Financeiro', 'Realizar treinamento de utilização do sistema com o pessoal, instruir a abertura de chamados e orientar a criação de usuários', '2025-06-17 13:09:38', '2025-06-18 15:29:43', 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1068, 'Fechado', 'Baixa', 'Treinamento de Sistema: Setor Contabil', 'Realizar treinamento de utilização do sistema com o pessoal, instruir a abertura de chamados e orientar a criação de usuários', '2025-06-17 13:09:47', '2025-06-18 15:29:30', 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1069, 'Fechado', NULL, 'Configurar etiqueta no PC do Jhonathan', 'Transferir um modelo de etiqueta do computador do apontamento, para o PC da expedição. Modelo esse de etiqueta com a descrição \"APONTADO\", fazer a transferencia e atualizar para \"ENTRADA\", conforme solicitação do Jhonathan.', '2025-06-18 09:22:28', '2025-06-20 13:18:26', 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1071, 'Fechado', 'Baixa', 'Trocar cilindro da impressora do Almoxarifado', 'Impressora do Almoxarifado está com cilindro \"vencido\", as impressões estão saindo borradas. Realizar a compra e a troca do cilindro. Impressora: Brother HL-1212W', '2025-06-18 15:23:14', '2025-06-20 09:50:53', 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1072, 'Fechado', 'Alta', 'E-mails Comercial', 'Conforme solicitado pela Ressylene, realizar a criação dos seguintes email: comercialnortenordeste, comercialsul e comercialcentrosudeste. Estar tambem realizando a configuraçao nas máquinas as assistentes', '2025-06-18 16:59:09', '2025-07-03 09:08:27', 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1073, 'Fechado', 'Alta', 'Monitor Comercial', 'Realizar a compra e instalação de um monitor para a nova colaboradora do Comercial ', '2025-06-18 17:00:02', '2025-06-20 16:08:16', 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1074, 'Fechado', 'Baixa', 'CONEXAO INTERNET', 'INTERNET LENTA - SOLICITO REINICIAR', '2025-06-19 13:30:39', '2025-06-19 16:58:58', 54, 'Larissa', 'larissa@chesiquimica.com.br', 'Financeiro'),
(1075, 'Fechado', 'Baixa', 'REALATORIOS', 'Ola, estou com problemas em gerar relatórios no modulo faturamento, na aba relatórios/faturamento/notas fiscais. por gentileza verificar assim que possível, obrigada', '2025-06-20 08:17:03', '2025-06-27 16:39:28', 57, 'CINTHIA', 'faturamento@chesiquimica.com.br', 'Logística Adm'),
(1076, 'Fechado', NULL, 'Troca de cilindro', 'Troca de cilindro da impressora do almoxarifado', '2025-06-20 09:49:23', '2025-06-20 09:51:01', 47, 'Bernardo', 'ti@chesiquimica.com.br', 'TI'),
(1077, 'Fechado', 'Baixa', 'verificar o wi-fi', '', '2025-06-20 11:22:51', '2025-06-20 12:55:00', 50, 'Tatiane', 'rh2@chesiquimica.com.br', 'RH'),
(1078, 'Fechado', NULL, 'Monitor para André', 'Realizar a transferencia do Monitor do Diego(PCP) para o André do setor Logistica', '2025-06-20 12:56:04', '2025-06-20 13:14:23', 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1079, 'Fechado', 'Média', 'Impressora Zebra Saneantes', 'Impressora Zebra do Saneantes esta com problema. Encaminhar para o conserto e alocar uma temporária no lugar', '2025-06-20 13:03:26', '2025-06-26 10:18:35', 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1080, 'Fechado', 'Baixa', 'E-mail do GLPI com problemas', 'E-mail ti@chesiquimica.com.br esta com problema no envio dos emails automaticos. Provavelmente devido ao número, foi considerado como SPAM.', '2025-06-20 13:07:44', '2025-06-23 08:44:11', 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1081, 'Fechado', NULL, 'Setup Comercial', 'Instalação do monitor, computador, teclado e mouse na sala do comercial', '2025-06-20 14:19:37', '2025-06-20 14:20:22', 47, 'Bernardo', 'ti@chesiquimica.com.br', 'TI'),
(1082, 'Fechado', NULL, 'Setup Comercial', 'Instalação do monitor, computador, teclado e mouse na sala do comercial', '2025-06-20 14:19:38', '2025-06-20 14:19:51', 47, 'Bernardo', 'ti@chesiquimica.com.br', 'TI'),
(1083, 'Fechado', 'Baixa', 'Treinamento de Sistema: Comercial	', 'Realizar treinamento de utilização do sistema com o pessoal, instruir a abertura de chamados e orientar a criação de usuários', '2025-06-20 14:33:11', '2025-07-04 15:06:37', 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1087, 'Fechado', 'Baixa', 'Notebook Contabilidade', 'Marcelo solicitou a compra de um notebook para o departamento da contabilidade.', '2025-06-20 15:08:20', '2025-07-02 15:54:36', 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1088, 'Fechado', 'Baixa', 'Instalar VPN', 'Franciely da logistica relatou problemas na VPN', '2025-06-20 15:53:49', '2025-06-23 08:44:55', 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1089, 'Fechado', NULL, 'Fios do comercial', 'Arrumação dos fios do comercial com as cobrinhas', '2025-06-23 10:16:54', '2025-06-23 11:41:52', 47, 'Bernardo', 'ti@chesiquimica.com.br', 'TI'),
(1090, 'Fechado', 'Média', 'Liberação de IP (Izi Pro)', 'Liberar IP: 198.161.83.142', '2025-06-23 17:23:06', '2025-06-24 10:14:07', 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1091, 'Em Andamento', 'Alta', 'Acesso aos DVRs', 'Problema no acesso as cameras nos aplicativos que tem conexao com o DVRs internos', '2025-06-24 07:58:07', NULL, 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1092, 'Em Andamento', 'Média', 'Compra de Webcam', 'Jadson solicitou a compra de uma webcam ', '2025-06-24 13:29:13', NULL, 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1093, 'Fechado', 'Alta', 'Whatsapp no Tablet', 'Realizar a configuração do whatsapp da manutenção no tablet do Almoxarifado', '2025-06-24 13:31:01', '2025-06-25 12:20:17', 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1094, 'Fechado', 'Baixa', 'impressora off', 'Ola, estou com problemas na impressora, ela nao esta imprimindo, ja foi aberto todas as entradas e saidas de papel, e foi desligada e reiniciada tambem. peço a gentileza que assim que possivel verificar.obrigada', '2025-06-24 16:14:42', '2025-06-24 16:22:38', 57, 'Cinthia', 'faturamento@chesiquimica.com.br', 'Logística Adm'),
(1095, 'Fechado', 'Baixa', 'teclados', '2 teclados novos', '2025-06-24 16:18:57', '2025-06-25 09:42:47', 58, 'ALEXANDRA', 'atendimento@chesiquimica.com.br', 'Logística Adm'),
(1096, 'Cancelado', NULL, 'teclados', '2 teclados novos', '2025-06-24 16:19:00', NULL, 58, 'ALEXANDRA', 'atendimento@chesiquimica.com.br', 'Logística Adm'),
(1097, 'Fechado', 'Baixa', 'Computador Não Liga', 'Computador do laboratório não esta ligando', '2025-06-25 09:11:39', '2025-06-25 09:33:42', 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1098, 'Fechado', 'Baixa', 'Manunteção de Nobreaks', 'Enviar dois nobreaks para manutenção', '2025-06-25 12:19:07', '2025-06-27 16:39:06', 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1099, 'Em Andamento', 'Média', 'Desinstalar Discord', 'Realizar a desinstalação da plataforma discord na máquinas da produção (com exceção do departamento de qualidade: Luisa, Paulo, Melani, Isabela)', '2025-06-25 12:21:32', NULL, 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1100, 'Fechado', NULL, 'Mudança de usuario', 'Troca de nome da Valéria e criação do usuario da Bruna', '2025-06-26 09:13:47', '2025-06-27 09:25:13', 47, 'Bernardo', 'ti@chesiquimica.com.br', 'TI'),
(1101, 'Cancelado', NULL, 'Teste', 'teste', '2025-06-27 13:55:21', NULL, 47, 'Bernardo', 'ti@chesiquimica.com.br', 'TI'),
(1102, 'Cancelado', NULL, 'chamado tela fun', 'teste', '2025-06-27 14:09:56', NULL, 47, 'Bernardo', 'ti@chesiquimica.com.br', 'TI'),
(1103, 'Cancelado', NULL, 'Teste', '123', '2025-06-27 14:27:20', NULL, 68, 'teste', 'teste@fornecedor.com', 'Laboratório Saneantes'),
(1104, 'Cancelado', NULL, 'sd', 'a', '2025-06-27 14:51:52', NULL, 47, 'Bernardo', 'ti@chesiquimica.com.br', 'TI'),
(1105, 'Fechado', 'Baixa', 'Computador sem internet ', 'Computador laboratório saneantes sem acesso a internet ', '2025-06-30 08:13:32', '2025-06-30 16:50:10', 69, 'Paulo', 'qualidade@chesiquimica.com.br ', 'Laboratório Saneantes'),
(1106, 'Cancelado', NULL, 'Computador sem internet ', 'Computador laboratório saneantes sem acesso a internet ', '2025-06-30 08:13:34', '2025-06-30 11:46:58', 69, 'Paulo', 'qualidade@chesiquimica.com.br ', 'Laboratório Saneantes'),
(1107, 'Cancelado', NULL, 'Computador sem internet ', 'Computador laboratório saneantes sem acesso a internet ', '2025-06-30 08:13:36', '2025-06-30 11:46:46', 69, 'Paulo', 'qualidade@chesiquimica.com.br ', 'Laboratório Saneantes'),
(1108, 'Cancelado', NULL, 'Computador sem internet ', 'Computador laboratório saneantes sem acesso a internet ', '2025-06-30 08:13:44', '2025-06-30 11:46:39', 69, 'Paulo', 'qualidade@chesiquimica.com.br ', 'Laboratório Saneantes'),
(1109, 'Cancelado', NULL, 'Computador sem internet ', 'Computador laboratório saneantes sem acesso a internet ', '2025-06-30 08:13:53', '2025-06-30 10:43:02', 69, 'Paulo', 'qualidade@chesiquimica.com.br ', 'Laboratório Saneantes'),
(1110, 'Cancelado', NULL, 'Computador sem internet ', 'Computador laboratório saneantes sem acesso a internet ', '2025-06-30 08:14:01', '2025-06-30 10:41:44', 69, 'Paulo', 'qualidade@chesiquimica.com.br ', 'Laboratório Saneantes'),
(1111, 'Cancelado', NULL, 'Computador sem internet ', 'Computador laboratório saneantes sem acesso a internet ', '2025-06-30 08:14:10', '2025-06-30 09:26:30', 69, 'Paulo', 'qualidade@chesiquimica.com.br ', 'Laboratório Saneantes'),
(1112, 'Cancelado', NULL, 'teste mural', 'chaamdo teste do mural', '2025-06-30 15:21:28', NULL, 47, 'Bernardo', 'ti@chesiquimica.com.br', 'TI'),
(1113, 'Cancelado', NULL, 'teste mural', 'chaamdo teste do mural', '2025-06-30 15:21:29', NULL, 47, 'Bernardo', 'ti@chesiquimica.com.br', 'TI'),
(1114, 'Cancelado', NULL, 'chamdo teste', 'teste ignorar', '2025-06-30 15:42:05', NULL, 47, 'Bernardo', 'ti@chesiquimica.com.br', 'TI'),
(1115, 'Cancelado', NULL, 'teste', 'excluir', '2025-07-01 11:48:26', NULL, 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1116, 'Fechado', 'Baixa', 'E-mail nao-responda com problema', 'E-mail foi bloqueado pelo painel, realizar a liberação', '2025-07-01 13:01:57', '2025-07-01 13:34:50', 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1117, 'Em Andamento', 'Média', 'IMPRESSORA', 'Colocar o tonner na impressora. ', '2025-07-01 13:28:33', NULL, 71, 'GRAZIELLA', 'assistentecomercial1@chesiquimica.com.br', 'Comercial'),
(1118, 'Fechado', NULL, 'Liberação de IP', 'Núbia esta com dificuldade para acessar um determinado link: http://189.126.156.140:1267/messenger/emp03/PgcWFCot/00000345017e9710f270.htm', '2025-07-02 08:21:04', '2025-07-02 15:54:54', 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1119, 'Fechado', NULL, 'teste', 'teste', '2025-07-02 09:45:45', '2025-07-02 15:52:27', 47, 'Bernardo', 'ti@chesiquimica.com.br', 'TI'),
(1120, 'Fechado', NULL, 'teste', 'dsfasad', '2025-07-02 09:47:36', '2025-07-02 15:52:17', 68, 'teste', 'teste@fornecedor.com', 'Laboratório Saneantes'),
(1121, 'Fechado', 'Baixa', 'mouse novo', 'trocar meu mouse, trazer grampeador', '2025-07-02 14:52:13', '2025-07-04 10:00:32', 64, 'Tereliz', 'apt1@chesiquimica.com.br', 'Apontamento Saneantes'),
(1122, 'Fechado', 'Baixa', 'instalar sistema', 'favor instar sistema na maquina da bruna ', '2025-07-03 08:31:51', '2025-07-03 08:46:39', 76, 'Ressyleny', 'posvenda@chesiquimica.com.br', 'Comercial'),
(1123, 'Fechado', NULL, 'ajuste de maquinas', 'boa tarde\r\npreciso da realocação dos computadores aqui na sala do comercial ', '2025-07-03 13:28:55', '2025-07-03 14:32:23', 76, 'Ressyleny', 'posvenda@chesiquimica.com.br', 'Comercial'),
(1124, 'Fechado', 'Baixa', 'Instalar email', 'Solicito a instalação do e-mail da região Centro Oeste e Sudeste em minha máquina. Porém, não desativar meu antigo (assistentecomercial1@chesiquimica.com.br)', '2025-07-04 08:05:12', '2025-07-04 15:07:06', 71, 'Graziella', 'assistentecomercial1@chesiquimica.com.br', 'Comercial'),
(1125, 'Fechado', NULL, 'INSTALAR FIOS ', 'Por gentileza precisamos de vocesss', '2025-07-04 10:25:30', '2025-07-04 11:19:55', 75, 'Bruna', 'bruna.eduarda1@icloud.com', 'Comercial'),
(1126, 'Fechado', NULL, 'INSTALAR FIOS ', 'Por gentileza precisamos de vocesss', '2025-07-04 10:25:32', '2025-07-04 11:20:04', 75, 'Bruna', 'bruna.eduarda1@icloud.com', 'Comercial'),
(1127, 'Cancelado', 'Baixa', 'atualizaxcao testeq', 'reate\r\n', '2025-07-04 10:28:55', NULL, 68, 'teste', 'teste@fornecedor.com', 'Laboratório Saneantes'),
(1128, 'Cancelado', NULL, 'ERRO NA FORMULA ', 'VOCE PODE VIM AQUI VER,ESTOU CONFUSA ', '2025-07-04 11:02:43', NULL, 67, 'Melani', 'qualidade1@chesiquimica.com.br', 'Laboratório Saneantes'),
(1129, 'Fechado', 'Média', 'SPED FISCAL - NORD RN', 'Bom dia, ao enviar o arquivo do SPED mensal fiscal da empresa nordclean no validador da receita, o mesmo dá o seguinte erro:\r\nERRO!\r\nARQUIVO NAO FOI TRANSMITIDO.\r\nNenhum dos servidores respondeu ao pedido de conexão.\r\nVerifique se sua configuração de rede está de acordo com as instruções constantes no endereço:\r\nwww.receita.fazenda.gov.br, Perguntas e Respostas, Receitanet.\r\nCaso a configuração de rede esteja conforme essas instruções, aguarde algum tempo, e tente novamente a transmissão.', '2025-07-04 11:03:52', '2025-07-04 17:17:04', 72, 'Ketlin', 'fiscal@chesiquimica.com.br', 'Contabilidade'),
(1130, 'Fechado', NULL, 'Comercial SAC', 'Levar cabo de rede no notebook do sac e passar um email que esta no notebook para outra pessoa que esta la embaixo', '2025-07-04 11:19:19', '2025-07-04 14:50:21', 47, 'Bernardo', 'ti@chesiquimica.com.br', 'TI'),
(1131, 'Fechado', NULL, 'Planilha Paulo', 'Paulo da logística solicitou uma planilha de identificação de paletes de materiais acabados, onde ao digitar o código referencia do item, ele puxe automaticamente a descrição do produto solicitado', '2025-07-04 13:27:38', '2025-07-04 14:49:47', 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1132, 'Em Andamento', 'Alta', 'Impressora da 3M com problema', 'Problema com os arquivos PRN de impressão', '2025-07-04 16:54:36', NULL, 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI'),
(1133, 'Fechado', NULL, 'CONEXAO INTERNET', 'Bom dia\r\nSolicito reiniciar a internet, com base no teste enviado ao João, velocidade está baixa', '2025-07-07 08:11:08', '2025-07-07 09:39:44', 54, 'Larissa', 'larissa@chesiquimica.com.br', 'Financeiro'),
(1134, 'Cancelado', NULL, 'CHAMADO', 'B', '2025-07-07 11:10:02', NULL, 47, 'Bernardo', 'ti@chesiquimica.com.br', 'TI'),
(1135, 'Cancelado', NULL, 'teste mw', 'chamdo mensagem\r\n', '2025-07-07 11:17:05', NULL, 47, 'Bernardo', 'ti@chesiquimica.com.br', 'TI'),
(1136, 'Em Andamento', 'Média', 'Itens a adquirir', 'Franciely da logistica solicitou uma máquina nova, estar realizando a cotação dos seguintes itens:\r\n\r\n1x computador desktop\r\n2x monitores\r\n6x teclados logitech\r\n6x mouses logitech\r\n2x cabos de impressoras\r\n2x cabo de energia', '2025-07-07 12:44:38', NULL, 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI');

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

--
-- Despejando dados para a tabela `equipamentos`
--

INSERT INTO `equipamentos` (`idEquipamento`, `descricaoEquipamento`, `tipo`) VALUES
(14, 'Brother HL-1202', 'Impressora'),
(15, 'Impressora LaserJet P2055dn', 'Impressora'),
(16, 'HP Laser MPF 135w', 'Impressora'),
(17, 'Impressora LaserJet P1102', 'Impressora'),
(18, 'EPSON 544 - Tinta Amarela', 'Impressora'),
(19, 'EPSON 544 - Tinta Azul', 'Impressora'),
(20, 'EPSON 544 - Tinta Preta', 'Impressora'),
(21, 'EPSON 544 - Tinta Vermelho', 'Impressora'),
(22, 'HP LaserJet 1015', 'Impressora'),
(23, 'Notebook Acer A515-54 I5-10210U', 'Notebook'),
(24, 'Monitor Philips 193V5', 'Monitor'),
(25, 'Computador O.E.M. I5-8400', 'Computador'),
(26, 'Monitor AOC E970SHWNL', 'Monitor'),
(27, 'Desktop I3-540', 'Computador'),
(28, 'Monitor Samsung B1930', 'Monitor'),
(29, 'Monitor Lg 19.5 20MK400H-B', 'Monitor'),
(30, 'Tablet Galaxy A9', 'Disp. Móvel'),
(31, 'Dell Inspiron 15 3567 I3 -7130', 'Notebook'),
(32, 'VAIO I5-10210U', 'Notebook'),
(33, 'Zebra ZD220', 'Impressora Térmica'),
(34, 'Vx Gaming Ryzen 3 2200G', 'Computador'),
(35, 'Monitor HQ Screen 17\' LED', 'Monitor'),
(36, 'Centrium I3-43160 CPU', 'Computador'),
(37, 'Notebook Lenovo I5 8GB 512 SSd', 'Notebook'),
(38, 'Webcam Pcyes Raza HD-01 720p', 'Outros'),
(40, 'Notebook Lenovo Ideapad 1 15IAU7', 'Notebook'),
(42, 'Asus I5-10400', 'Computador'),
(43, 'Zebra ZD230', 'Impressora Térmica');

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

--
-- Despejando dados para a tabela `estoque`
--

INSERT INTO `estoque` (`id`, `item_id`, `nota_fiscal`, `fornecedor`, `quantidade`, `tipo_movimentacao`, `data_movimentacao`, `motivo`, `usuario_id`) VALUES
(32, 21, '000062629', 'Ponto Forte Atacadista', 6, 'ENTRADA', '2025-06-16 16:24:18', 'Entrada de Material', 46),
(33, 21, NULL, NULL, 1, 'SAIDA', '2025-06-16 16:24:54', 'Entrega de Suprimento', 46),
(34, 19, '0000', 'Ponto Forte Atacadista', 1, 'ENTRADA', '2025-06-16 18:14:58', 'Entrada de Material', 47),
(35, 19, NULL, NULL, 1, 'SAIDA', '2025-06-16 18:15:09', 'Entrega de Suprimento', 47),
(36, 23, '0000', 'Ponto Forte Atacadista', 4, 'ENTRADA', '2025-06-16 18:18:14', 'Entrada de Material', 47),
(37, 24, '0000', 'Ponto Forte Atacadista', 4, 'ENTRADA', '2025-06-16 18:19:46', 'Entrada de Material', 47),
(38, 22, '0000', 'Ponto Forte Atacadista', 3, 'ENTRADA', '2025-06-16 18:27:27', 'Entrada de Material', 47),
(39, 20, '0000', 'Ponto Forte Atacadista', 3, 'ENTRADA', '2025-06-16 18:27:27', 'Entrada de Material', 47),
(40, 14, 'INV160625', 'Ponto Forte Atacadista', 5, 'ENTRADA', '2025-06-16 19:33:28', 'Entrada de Material', 46),
(41, 26, 'INV160625', 'Ponto Forte Atacadista', 1, 'ENTRADA', '2025-06-16 19:33:28', 'Entrada de Material', 46),
(42, 18, 'sem nf', 'Ponto Forte Atacadista', 1, 'ENTRADA', '2025-06-18 15:38:41', 'Entrada de Material', 47),
(43, 16, 'sem nf', 'Ponto Forte Atacadista', 1, 'ENTRADA', '2025-06-18 15:38:41', 'Entrada de Material', 47),
(44, 17, 'sem nf', 'Ponto Forte Atacadista', 1, 'ENTRADA', '2025-06-18 15:38:41', 'Entrada de Material', 47),
(45, 14, NULL, NULL, 1, 'SAIDA', '2025-06-18 17:54:33', 'Entrega de Suprimento', 47),
(46, 19, '000001317', 'Ponto Forte Atacadista', 1, 'ENTRADA', '2025-06-20 12:56:03', 'Entrada de Material', 47),
(47, 14, '000001317', 'Ponto Forte Atacadista', 4, 'ENTRADA', '2025-06-20 12:56:03', 'Entrada de Material', 47),
(48, 27, '000001317', 'Ponto Forte Atacadista', 1, 'ENTRADA', '2025-06-20 12:57:00', 'Entrada de Material', 47),
(49, 14, NULL, NULL, 1, 'SAIDA', '2025-06-23 12:16:44', 'Entrega de Suprimento', 46),
(50, 28, '0000', 'Ponto Forte Atacadista', 1, 'ENTRADA', '2025-06-23 12:34:11', 'Entrada de Material', 47),
(51, 29, '0000', 'Ponto Forte Atacadista', 1, 'ENTRADA', '2025-06-23 12:35:11', 'Entrada de Material', 47),
(52, 30, '0000', 'Ponto Forte Atacadista', 1, 'ENTRADA', '2025-06-23 12:35:11', 'Entrada de Material', 47),
(53, 31, '0000', 'Ponto Forte Atacadista', 2, 'ENTRADA', '2025-06-23 12:37:27', 'Entrada de Material', 47),
(54, 32, '0000', 'Ponto Forte Atacadista', 1, 'ENTRADA', '2025-06-23 12:44:59', 'Entrada de Material', 47),
(55, 33, '0000121992', 'ES Informatica', 2, 'ENTRADA', '2025-06-24 12:52:57', 'Entrada de Material', 47),
(56, 34, '0000121992', 'ES Informatica', 3, 'ENTRADA', '2025-06-24 12:52:57', 'Entrada de Material', 47),
(57, 23, 'SEMNFE', 'ES Informatica', 1, 'ENTRADA', '2025-06-25 14:36:57', 'Entrada de Material', 46),
(58, 27, '', '', 1, 'SAIDA', '2025-06-25 19:27:07', 'Baixa Manual', 46),
(59, 35, '0000122055', 'ES Informatica', 2, 'ENTRADA', '2025-06-27 19:48:16', 'Entrada de Material', 46),
(60, 14, NULL, NULL, 1, 'SAIDA', '2025-06-27 19:55:23', 'Entrega de Suprimento', 46),
(61, 33, '', '', 1, 'SAIDA', '2025-07-02 10:38:32', 'Baixa Manual', 46),
(62, 23, 'SEMNFE', 'Ponto Forte Atacadista', 1, 'ENTRADA', '2025-07-02 10:38:51', 'Entrada de Material', 46),
(63, 14, '', '', 1, 'SAIDA', '2025-07-03 14:30:04', 'Baixa Manual', 47),
(64, 33, '', '', 1, 'SAIDA', '2025-07-03 19:09:20', 'Baixa Manual', 46),
(65, 34, '', '', 3, 'SAIDA', '2025-07-03 19:09:28', 'Baixa Manual', 46),
(66, 27, '000001317', 'Ponto Forte Atacadista', 1, 'ENTRADA', '2025-07-03 19:49:32', 'Entrada de Material', 46),
(67, 14, NULL, NULL, 1, 'SAIDA', '2025-07-04 14:21:11', 'Entrega de Suprimento', 47),
(68, 20, NULL, NULL, 1, 'SAIDA', '2025-07-07 12:39:16', 'Entrega de Suprimento', 47),
(69, 14, '', '', 1, 'SAIDA', '2025-07-07 15:48:06', 'Perda', 46);

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

--
-- Despejando dados para a tabela `fornecedor`
--

INSERT INTO `fornecedor` (`id`, `nome`, `cnpj`, `telefone`, `email`, `endereco`) VALUES
(1, 'Ponto Forte Atacadista', '53431696/0001-77', '4232259393', 'yamilgorayeb@gmail.com', 'Avenida Ernesto Vilela, 295, Centro'),
(2, 'ES Informatica', '02.444.351/0001-17', '4232249608', 'sac@esinfo.com.br', 'Avenida Vicente Machado 949 Loja 2');

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
  `modelo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `imobilizados`
--

INSERT INTO `imobilizados` (`id`, `patrimonio`, `modelo_id`, `localizacao`, `nota_fiscal`, `usuario_id`, `status`, `modelo`) VALUES
(2, '0318', 16, 'Compras', '1214', 46, 'Ativo', 'Impressora'),
(3, '0112', 23, 'TI', '108531', 46, 'Ativo', 'Notebook'),
(6, '0268', 24, 'TI', '2186', 46, 'Ativo', 'Monitor'),
(7, '0260', 26, 'Apontamento Aerossol', '45857', 64, 'Ativo', 'Monitor'),
(8, '0109', 25, '', '2033', 47, 'Ativo', 'Computador'),
(9, '0099', 27, 'Laboratório aerossol', 'SEMNFE', 48, 'Ativo', 'Computador'),
(10, '0250', 28, 'Laboratório aerossol', 'SEMNFE', 48, 'Ativo', 'Monitor'),
(11, '0186', 30, 'Manutenção', '0000', 59, 'Ativo', 'Disp.móvel'),
(12, '0217', 30, 'Almoxarifado', '0000', 60, 'Ativo', 'Disp.móvel'),
(13, '0106', 31, '', 'SEMNFE', 51, 'Ativo', 'Notebook'),
(14, '0111', 23, 'Financeiro', '437088', 54, 'Ativo', 'Notebook'),
(15, '0219', 30, 'Almoxarifado', '0000', 61, 'Ativo', 'Disp. Móvel'),
(16, '0215', 30, 'Almoxarifado', '0000', 62, 'Ativo', 'Disp. Móvel'),
(17, '0213', 30, 'Almoxarifado', '0000', 63, 'Ativo', 'Disp. Móvel'),
(18, '0196', 30, 'Apontamento Saneantes', '0000', 64, 'Ativo', 'Disp. Móvel'),
(19, '0198', 30, 'Apontamento Aerossol', '0000', 65, 'Ativo', 'Disp. Móvel'),
(20, '0200', 30, 'Apontamento Cosmético', '0000', 66, 'Ativo', 'Disp. Móvel'),
(30, '0305', 33, 'Apontamento Saneantes', 'SEMNFE', 69, 'Ativo', 'Impressora Térmica'),
(31, '0105', 34, 'Apontamento Saneantes', 'SEMNFE', 69, 'Ativo', 'Computador'),
(32, '0283', 35, 'Apontamento Saneantes', 'SEMNFE', 69, 'Ativo', 'Monitor'),
(33, '0302', 33, 'Laboratório Saneantes', 'SEMNFE', 67, 'Ativo', 'Impressora Térmica'),
(34, '0325', 22, 'Laboratório Saneantes', 'SEMNFE', 67, 'Ativo', 'Impressora'),
(35, '0266', 26, 'Laboratório Saneantes', 'SEMNFE', 67, 'Ativo', 'Monitor'),
(36, '0104', 36, 'Laboratório Saneantes', 'SEMNFE', 67, 'Ativo', 'Computador'),
(37, '0098', 40, 'Contabilidade', 'SEM NFE', 72, 'Ativo', 'Notebook'),
(38, '0145', 40, 'Externo', 'SEM NFE', 73, 'Ativo', 'Notebook'),
(39, '0097', 29, '', '000211886', 47, 'Ativo', 'Monitor'),
(40, '0125', 42, 'Apontamento Saneantes', '28343', 64, 'Ativo', 'Computador'),
(41, '0094', 43, 'Apontamento Saneantes', '000212282', 64, 'Ativo', 'Impressora Térmica');

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

--
-- Despejando dados para a tabela `impressora_tonner`
--

INSERT INTO `impressora_tonner` (`id`, `impressoraId`, `modeloTonnerId`, `cor`) VALUES
(1, 16, 14, NULL),
(2, 18, 15, NULL),
(3, 19, 16, NULL),
(4, 20, 17, NULL),
(5, 21, 18, NULL),
(6, 22, 21, NULL),
(7, 15, 19, NULL),
(8, 14, 22, NULL),
(9, 17, 20, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens`
--

CREATE TABLE `itens` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `itens`
--

INSERT INTO `itens` (`id`, `nome`, `tipo`) VALUES
(14, 'Tonner W1105A', 'Tonner'),
(15, 'EPSON 544 - Tinta Amarela', 'Tonner'),
(16, 'EPSON 544 - Tinta Azul', 'Tonner'),
(17, 'EPSON 544 - Tinta Preta', 'Tonner'),
(18, 'EPSON 544 - Tinta Vermelho', 'Tonner'),
(19, 'Tonner P-550-A', 'Tonner'),
(20, 'Tonner CE285A', 'Tonner'),
(21, 'Tonner Q2612A', 'Tonner'),
(22, 'Tonner TN 1060', 'Tonner'),
(23, 'Teclado (Usado)', 'Material De Escritório'),
(24, 'Mouse (Usado)', 'Material De Escritório'),
(26, 'Tonner TN-3612XL(25K)', 'Tonner'),
(27, 'Cilindro DR TN1000', 'Tonner'),
(28, 'Cabo Vga', 'Material De Escritório'),
(29, 'Carregador Notebook Cabeça Pequena', 'Material De Escritório'),
(30, 'Carregador Notebook Cabeça Grande', 'Material De Escritório'),
(31, 'Cabo de rede', 'Material De Escritório'),
(32, 'Régua de tomada', 'Material De Escritório'),
(33, 'Teclado Logitech k120 novo', 'Material De Escritório'),
(34, 'Teclado multilaser tc193bu', 'Material De Escritório'),
(35, 'Filtro de linha 6 Tomadas Vinik', 'Material De Escritório'),
(37, 'teste', 'Tonner');

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

--
-- Despejando dados para a tabela `setores_locais`
--

INSERT INTO `setores_locais` (`setor`, `local`) VALUES
('Almoxarifado', 'Barracão 03'),
('Apontamento Aerossol', 'Barracão 02'),
('Apontamento Cosmético', 'Barracão 04'),
('Apontamento Saneantes', 'Barracão 04'),
('Comercial', 'Barracão 03'),
('Compras', 'Barracão 02'),
('Contabilidade', 'Barracão 04'),
('Expedição', 'Barracão 03'),
('Externo', 'Barracão 01'),
('Financeiro', 'Barracão 04'),
('Laboratório aerossol', 'Formulação'),
('Laboratório Saneantes', 'Barracão 04'),
('Logística Adm', 'Barracão 03'),
('Manutenção', 'Barracão 02'),
('Marketing', 'Barracão 01'),
('PCP', 'Barracão 02'),
('RH', 'Barracão 04'),
('TI', 'Barracão 02');

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

--
-- Despejando dados para a tabela `tonneratualizacao`
--

INSERT INTO `tonneratualizacao` (`id_atualizacao`, `solicitacaoId`, `dtAtualizacao`, `tecnico`, `situacao`) VALUES
(1, 1080, '2025-06-16 12:38:50', 'João', 'Sem estoque'),
(2, 1081, '2025-06-16 12:43:33', 'João', 'Sem estoque'),
(3, 1083, '2025-06-16 13:18:34', 'João', 'Sem estoque'),
(4, 1082, '2025-06-16 13:18:50', 'João', 'Sem estoque'),
(5, 1082, '2025-06-16 13:24:43', 'João', 'Em estoque'),
(6, 1082, '2025-06-16 13:24:54', 'João', 'Em estoque'),
(7, 1081, '2025-06-16 13:25:46', 'João', 'Sem estoque'),
(8, 1084, '2025-06-16 14:47:34', 'Bernardo', 'Sem estoque'),
(9, 1084, '2025-06-16 15:15:09', 'Bernardo', 'Em estoque'),
(10, 1085, '2025-06-18 14:48:59', 'Bernardo', 'Em estoque'),
(11, 1085, '2025-06-18 14:54:33', 'Bernardo', 'Em estoque'),
(12, 1087, '2025-06-23 09:16:36', 'João', 'Em estoque'),
(13, 1087, '2025-06-23 09:16:44', 'João', 'Em estoque'),
(14, 1088, '2025-06-27 16:55:23', 'João', 'Em estoque'),
(15, 1089, '2025-07-04 11:21:11', 'Bernardo', 'Em estoque'),
(16, 1090, '2025-07-07 09:39:16', 'Bernardo', 'Em estoque');

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
-- Despejando dados para a tabela `tonnersolicitacao`
--

INSERT INTO `tonnersolicitacao` (`solicitacaoId`, `status`, `corTonner`, `dtAbertura`, `dtFechamento`, `autorId`, `autorNome`, `autorEmail`, `autorSetor`, `situacao`, `impressoraId`, `tonnerId`) VALUES
(1080, 'Cancelado', '', '2025-06-16 12:37:54', NULL, 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI', 'Sem estoque', 16, 14),
(1081, 'Cancelado', '', '2025-06-16 12:42:35', NULL, 47, 'Bernardo', 'ti@chesiquimica.com.br', 'TI', 'Sem estoque', 18, 15),
(1082, 'Fechado', '', '2025-06-16 12:58:15', '2025-06-16 13:24:54', 48, 'Fernanda', 'qualidade3@chesiquimica.com.br', 'Laboratório aerossol', 'Em estoque', 22, 21),
(1083, 'Cancelado', '', '2025-06-16 13:01:59', NULL, 49, 'João', 'joaoogbriel3meia@gmail.com', 'PCP', 'Sem estoque', 22, 21),
(1084, 'Fechado', '', '2025-06-16 13:57:34', '2025-06-16 15:15:09', 50, 'Tatiane', 'rh2@chesiquimica.com.br', 'RH', 'Em estoque', 15, 19),
(1085, 'Fechado', '', '2025-06-18 14:27:49', '2025-06-18 14:54:33', 52, 'Ivanise', 'contabilidade@chesiquimica.com.br', 'Contabilidade', 'Em estoque', 16, 14),
(1086, 'Aberto', '', '2025-06-23 09:01:26', NULL, 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI', NULL, 14, 22),
(1087, 'Fechado', '', '2025-06-23 09:15:34', '2025-06-23 09:16:44', 46, 'João', 'joao.gabriel@chesiquimica.com.br', 'TI', 'Em estoque', 16, 14),
(1088, 'Fechado', '', '2025-06-27 13:55:47', '2025-06-27 16:55:23', 47, 'Bernardo', 'ti@chesiquimica.com.br', 'TI', 'Em estoque', 16, 14),
(1089, 'Fechado', '', '2025-07-04 09:04:55', '2025-07-04 11:21:11', 77, 'Leandro', 'pcp2@chesiquimica.com.br', 'PCP', 'Em estoque', 16, 14),
(1090, 'Fechado', '', '2025-07-07 08:00:35', '2025-07-07 09:39:16', 54, 'Larissa', 'larissa@chesiquimica.com.br', 'Financeiro', 'Em estoque', 17, 20);

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
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `setor`, `local`) VALUES
(1, 'admin', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'TI', 'Local Indefinido'),
(46, 'João Gabriel dos Anjos', 'joao.gabriel@chesiquimica.com.br', '03a6b5a43cfe2e2315e141182e6b3e47f1f61c6f', 'TI', 'Barracão 02'),
(47, 'Bernardo Lima', 'ti@chesiquimica.com.br', 'd517985f8deffa5c285003a8ce290fa46ab16e5e', 'TI', 'Barracão 02'),
(48, 'Fernanda Padilha', 'qualidade3@chesiquimica.com.br', '3e9a3d5674fd9747d82b1f3a4f0acf35c59edde1', 'Laboratório aerossol', 'Formulação'),
(50, 'Tatiane Pires', 'rh2@chesiquimica.com.br', 'f47d48c1d7edb2673729f1c6a172a86b6e781062', 'RH', 'Barracão 04'),
(51, 'usuario', 'usuario@teste.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Logística Adm', 'Barracão 03'),
(52, 'Ivanise Alves', 'contabilidade@chesiquimica.com.br', '8cb2237d0679ca88db6464eac60da96345513964', 'Contabilidade', 'Barracão 04'),
(53, 'Denise', 'adm@chesiquimica.com.br', '3e3d410ee51d28ecafc1c06900cb43e46bb1846f', 'Financeiro', 'Barracão 04'),
(54, 'Larissa Chesini ', 'larissa@chesiquimica.com.br', 'ec7117851c0e5dbaad4effdb7cd17c050cea88cb', 'Financeiro', 'Barracão 04'),
(55, 'Alda T Chesini', 'financeiro@chesiquimica.com.br', '004be89dd9e070ecb080b9b759e5be29ec24881b', 'Financeiro', 'Barracão 04'),
(56, 'Alesson de Lima Barbosa', 'alesson@chesiquimica.com.br', 'd517985f8deffa5c285003a8ce290fa46ab16e5e', 'TI', 'Barracão 02'),
(57, 'Cinthia Martins Fontoura', 'faturamento@chesiquimica.com.br', '36a1db36030b3b966ccec41ac335c44c2abf8ee7', 'Logística Adm', 'Barracão 03'),
(58, 'Alexandra Aparecida de Oliveira', 'atendimento@chesiquimica.com.br', 'd3ae9e647e5e9126e4b5245c73b015b4afacd547', 'Logística Adm', 'Barracão 03'),
(59, 'Edenilson', 'edenilson@chesiquimica.com.br', 'd517985f8deffa5c285003a8ce290fa46ab16e5e', 'Manutenção', 'Barracão 02'),
(60, 'Weliton da Cruz', 'almoxarifado@chesiquimica.com.br', 'd517985f8deffa5c285003a8ce290fa46ab16e5e', 'Almoxarifado', 'Barracão 03'),
(61, 'Hosleane de Pontes Buffalo', 'almox1@chesiquimica.com.br', 'd517985f8deffa5c285003a8ce290fa46ab16e5e', 'Almoxarifado', 'Barracão 03'),
(62, 'Juarez Lopes Junior', 'almox2@chesiquimica.com.br', 'd517985f8deffa5c285003a8ce290fa46ab16e5e', 'Almoxarifado', 'Barracão 03'),
(63, 'Bárbara Taylane Reis Nery', 'almox3@chesiquimica.com.br', 'd517985f8deffa5c285003a8ce290fa46ab16e5e', 'Almoxarifado', 'Barracão 03'),
(64, 'Tereliz da Cruz', 'apt1@chesiquimica.com.br', 'd517985f8deffa5c285003a8ce290fa46ab16e5e', 'Apontamento Saneantes', 'Barracão 04'),
(65, 'Carla Ingrid Guimarães', 'apt2@chesiquimica.com.br', 'd517985f8deffa5c285003a8ce290fa46ab16e5e', 'Apontamento Aerossol', 'Barracão 02'),
(66, 'Tayline Fabiele Borges', 'apt3@chesiquimica.com.br', 'd517985f8deffa5c285003a8ce290fa46ab16e5e', 'Apontamento Cosmético', 'Barracão 04'),
(67, 'Melani', 'qualidade1@chesiquimica.com.br', 'd517985f8deffa5c285003a8ce290fa46ab16e5e', 'Laboratório Saneantes', 'Barracão 04'),
(68, 'teste', 'teste@fornecedor.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Laboratório Saneantes', 'Barracão 04'),
(69, 'Paulo Roberto Rodrigues ', 'embalagem@chesiquimica.com.br', 'd517985f8deffa5c285003a8ce290fa46ab16e5e', 'Laboratório Saneantes', 'Barracão 04'),
(70, 'Diego Takashi Otsuka de Lima', 'pcp@chesiquimica.com.br', 'c0a535ccfa072cf55a855e5e6750059c194ae01b', 'PCP', 'Barracão 02'),
(71, 'Graziella', 'assistentecomercial1@chesiquimica.com.br', 'a84d8beb9302cfd6df1d4488eb70b475ae04c3ca', 'Comercial', 'Barracão 03'),
(72, 'Ketlin Machado', 'fiscal@chesiquimica.com.br', 'd517985f8deffa5c285003a8ce290fa46ab16e5e', 'Contabilidade', 'Barracão 04'),
(73, 'Diogo Chesini', 'diogo@chesiquimica.com.br', 'd517985f8deffa5c285003a8ce290fa46ab16e5e', 'Externo', 'Barracão 01'),
(74, 'Bruna Eduarda Gonçalves ', 'comercialnortenordeste@chesiquimica.com.br', 'b317a33e47b7b6375af5828d8743f75d4bd66abf', 'Comercial', 'Barracão 03'),
(75, 'Bruna Eduarda Gonçalves ', 'bruna.eduarda1@icloud.com', 'b317a33e47b7b6375af5828d8743f75d4bd66abf', 'Comercial', 'Barracão 03'),
(76, 'Ressyleny', 'posvenda@chesiquimica.com.br', 'ccfc47ae242f33b73db5bb9ab6bc4e3c70482181', 'Comercial', 'Barracão 03'),
(77, 'Leandro Carneiro', 'pcp2@chesiquimica.com.br', 'd517985f8deffa5c285003a8ce290fa46ab16e5e', 'PCP', 'Barracão 02');

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
  MODIFY `id_atualizacao` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de tabela `avisos`
--
ALTER TABLE `avisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `chamados`
--
ALTER TABLE `chamados`
  MODIFY `chamadoId` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1137;

--
-- AUTO_INCREMENT de tabela `equipamentos`
--
ALTER TABLE `equipamentos`
  MODIFY `idEquipamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `imobilizados`
--
ALTER TABLE `imobilizados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de tabela `impressora_tonner`
--
ALTER TABLE `impressora_tonner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `itens`
--
ALTER TABLE `itens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de tabela `movimentacao`
--
ALTER TABLE `movimentacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tonneratualizacao`
--
ALTER TABLE `tonneratualizacao`
  MODIFY `id_atualizacao` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `tonnersolicitacao`
--
ALTER TABLE `tonnersolicitacao`
  MODIFY `solicitacaoId` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1091;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

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
-- Restrições para tabelas `movimentacao`
--
ALTER TABLE `movimentacao`
  ADD CONSTRAINT `movimentacao_ibfk_1` FOREIGN KEY (`estoque_id`) REFERENCES `estoque` (`id`);

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
