-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 02-Ago-2021 às 08:12
-- Versão do servidor: 8.0.26-0ubuntu0.20.04.2
-- versão do PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `shoopflow`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `COFINS_link_estado`
--

CREATE TABLE `COFINS_link_estado` (
  `id` int NOT NULL,
  `FKIDRegrasTributacaoCOFINS` int NOT NULL,
  `FKIDEstado` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `COFINS_link_produtos`
--

CREATE TABLE `COFINS_link_produtos` (
  `id` int NOT NULL,
  `tipo` enum('ncm','produto','grupoProduto') NOT NULL,
  `FKIDRegrasTributacaoCOFINS` int NOT NULL,
  `FKIDProduto` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `COFINS_regras_tributacao`
--

CREATE TABLE `COFINS_regras_tributacao` (
  `id` int NOT NULL,
  `QualquerProduto` tinyint(1) DEFAULT NULL,
  `QualquerEstado` tinyint(1) DEFAULT NULL,
  `Aliquota` float DEFAULT NULL,
  `Base` float DEFAULT NULL,
  `situacaoTributaria` int DEFAULT NULL COMMENT '      49 - Outras Operações de Saída     • 50 - Operação com Direito a Crédito - Vinculada Exclusivamente a Receita Tributada no Mercado Interno     • 51 - Operação com Direito a Crédito – Vinculada Exclusivamente a Receita Não Tributada no Mercado Interno     • 52 - Operação com Direito a Crédito - Vinculada Exclusivamente a Receita de Exportação     • 53 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno     • 54 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas no Mercado Interno e de Exportação     • 55 - Operação com Direito a Crédito - Vinculada a Receitas Não-Tributadas no Mercado Interno e de Exportação     • 56 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação     • 60 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Tributada no Mercado Interno     • 61 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Nã',
  `InformacoesComplementares` text,
  `InformacoesAdicionais` text,
  `FKIDNaturezaOperacao` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ICMS_link_estado`
--

CREATE TABLE `ICMS_link_estado` (
  `id` int NOT NULL,
  `FKIDRegrasTributacaoICMS` int NOT NULL,
  `FKIDEstado` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ICMS_link_produtos`
--

CREATE TABLE `ICMS_link_produtos` (
  `id` int NOT NULL,
  `FKIDRegrasTributacaoICMS` int NOT NULL,
  `tipo` enum('ncm','produto','grupoProduto') NOT NULL,
  `FKIDProduto` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ICMS_partilha`
--

CREATE TABLE `ICMS_partilha` (
  `id` int NOT NULL,
  `FKIDRegrasTributacaoICMS` int NOT NULL,
  `TipoTributacao` char(1) DEFAULT NULL COMMENT 'N – Normal I - Isento',
  `BaseCalculo` float DEFAULT NULL,
  `AliquotaInternaUFDestino` float DEFAULT NULL,
  `AliquotaFCP` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ICMS_regras_tributacao`
--

CREATE TABLE `ICMS_regras_tributacao` (
  `id` int NOT NULL,
  `FKIDNaturezaOperacao` int UNSIGNED NOT NULL,
  `QualquerProduto` tinyint(1) DEFAULT NULL,
  `QualquerEstado` tinyint(1) DEFAULT NULL,
  `CodigoSituacaoOperacao` int DEFAULT NULL COMMENT '    • 101 - Tributada com permissão de crédito     • 102 - Tributada sem permissão de crédito     • 103 - Isenção do ICMS para faixa de receita bruta     • 201 - Tributada com permissão de crédito e com cobrança do ICMS por ST     • 202 - Tributada sem permissão de crédito e com cobrança do ICMS por ST     • 203 - Isenção do ICMS para faixa de receita bruta e com cobrança do ICMS por ST     • 300 – Imune     • 400 - Não tributada     • 500 - ICMS cobrado anteriormente por ST ou por antecipação     • 900 - Outros',
  `AliquotaAplicavel` float DEFAULT NULL,
  `FCP` float DEFAULT NULL,
  `ModalidadeBC` int DEFAULT NULL COMMENT '    • Margem Valor Agregado (%)     • Pauta (valor)     • Preço Tabelado Máx. (valor)     • Valor da operação',
  `ValorPauta` bigint DEFAULT NULL,
  `AliquotaICMS` float DEFAULT NULL,
  `BaseICMS` float DEFAULT NULL,
  `Diferimento` float DEFAULT NULL,
  `InformacoesComplementares` text,
  `InformacoesAdicionais` text,
  `Aliquota` float DEFAULT NULL,
  `Presumido` float DEFAULT NULL,
  `CodigoBeneficioFiscal` int DEFAULT NULL,
  `Base` float DEFAULT NULL,
  `MotivoDesoneracao` int DEFAULT NULL COMMENT '    • 1 - Taxi     • 3 -Produtor Agropecuário     • 4 - Frotista/Locadora     • 5 - Diplomático/Consular     • 6 - Utilitários e Motocicletas da Amazônia Ocidental e Áreas de Livre Comércio (Resolução 714/88 e 790/94 – CONTRAN e suas alterações)     • 7 – SUFRAMA     • 8 - Venda a Órgão Público     • 9 - Outros     • 10 - Deficiente Condutor     • 11 - Deficiente Não Condutor     • 90 - Solicitado pelo Fisco',
  `CFOP` bigint DEFAULT NULL,
  `situacaoTributaria` int DEFAULT NULL COMMENT '    • 10 - Tributada e com cobrança do ICMS por substituição tributária     • 20 - Com redução de base de cálculo     • 30 - Isenta ou não tributada e com cobrança do ICMS por substituição tributária     • 40 - Isenta     • 41 - Não tributada     • 50 - Suspensão     • 51 - Diferimento     • 60 - ICMS cobrado anteriormente por substituição tributária     • 70 - Com redução de base de cálculo e cobrança do ICMS por substituição tributária     • 90 – Outras     • 00 – Tributada integralmente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ICMS_situacao_tributaria`
--

CREATE TABLE `ICMS_situacao_tributaria` (
  `id` int NOT NULL,
  `FKIDRegrasTributacaoICMS` int NOT NULL,
  `ModalidadeBC` int NOT NULL COMMENT '    • Preço tabelado ou máximo sugerido     • Lista Negativa (valor)     • Lista Positiva (valor)     • Lista Neutra (valor)     • Margem Valor Agregado (%)     • Pauta (valor)     • Valor da Operação',
  `AliquotaICMS` float DEFAULT NULL,
  `BaseCalculoICMS` float DEFAULT NULL,
  `Base` float DEFAULT NULL,
  `MVA` float DEFAULT NULL,
  `PIS` float DEFAULT NULL,
  `COFINS` float DEFAULT NULL,
  `MargemAdicionalICMS` float DEFAULT NULL,
  `ValorPauta` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ICMS_substituicao_TRA`
--

CREATE TABLE `ICMS_substituicao_TRA` (
  `id` int NOT NULL,
  `FKIDRegrasTributacaoICMS` int NOT NULL,
  `BaseICMS` float DEFAULT NULL,
  `AliquotaICMS` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `II_link_estado`
--

CREATE TABLE `II_link_estado` (
  `id` int NOT NULL,
  `FKIDRegrasTributacaoII` int NOT NULL,
  `FKIDEstado` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `II_link_produtos`
--

CREATE TABLE `II_link_produtos` (
  `id` int NOT NULL,
  `tipo` enum('ncm','produto','grupoProduto') NOT NULL,
  `FKIDRegrasTributacaoII` int NOT NULL,
  `FKIDProduto` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `II_regras_tributacao`
--

CREATE TABLE `II_regras_tributacao` (
  `id` int NOT NULL,
  `QualquerProduto` tinyint(1) DEFAULT NULL,
  `QualquerEstado` tinyint(1) DEFAULT NULL,
  `Aliquota` float DEFAULT NULL,
  `situacaoTributaria` int DEFAULT NULL COMMENT '    • 01 – Tributado     • 02 - Não tributado',
  `InformacoesComplementares` text,
  `InformacoesAdicionais` text,
  `FKIDNaturezaOperacao` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `IPI_link_estado`
--

CREATE TABLE `IPI_link_estado` (
  `id` int NOT NULL,
  `FKIDRegrasTributacaoIPI` int NOT NULL,
  `FKIDEstado` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `IPI_link_produtos`
--

CREATE TABLE `IPI_link_produtos` (
  `id` int NOT NULL,
  `FKIDRegrasTributacaoIPI` int NOT NULL,
  `tipo` enum('ncm','produto','grupoProduto') NOT NULL,
  `FKIDProduto` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `IPI_regras_tributacao`
--

CREATE TABLE `IPI_regras_tributacao` (
  `id` int NOT NULL,
  `QualquerProduto` tinyint(1) DEFAULT NULL,
  `QualquerEstado` tinyint(1) DEFAULT NULL,
  `IncluirFreteBase` tinyint(1) DEFAULT NULL,
  `situacaoTributaria` int DEFAULT NULL COMMENT '    • Sem IPI     • 50 - Saída tributada     • 51 - Saída tributada com alíquota zero     • 52 - Saída isenta     • 53 - Saída não-tributada     • 54 - Saída imune     • 55 - Saída com suspensão     • 99 - Outras saídas',
  `Aliquota` float DEFAULT NULL,
  `Base` float DEFAULT NULL,
  `CodEnquadramento` int DEFAULT NULL COMMENT 'Sem IPI {         999,601,602,603,604,605,606,607,608,     }     50 - Saída tributada{           999,601,602,603,604,605,606,607,608,     }     51 - Saída tributada com alíquota zero{           999,601,602,603,604,605,606,607,608,     }     52 - Saída isenta{         999,301,302,303,304,305,306,307,308,309,310,311,312,313,314,315,316,317,318,319,320,321,322,323,324,325,326,327,328,329,330,331,332,333,334,335,336,337,338,339,340,341,342,343,344,345,346,347,348,349,350,351,     }     53 - Saída não-tributada{           999,601,602,603,604,605,606,607,608,     }     54 - Saída imune{         999,1,2,3,4,5,6,7,     }     55 - Saída com suspensão{         999,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,     }     99 - Outras saídas{         999,601,602,603,604,605,606,607,608,     }',
  `InformacoesComplementares` text,
  `InformacoesAdicionais` text,
  `FKIDNaturezaOperacao` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ISSQN_link_estado`
--

CREATE TABLE `ISSQN_link_estado` (
  `id` int NOT NULL,
  `FKIDRegrasTributacaoISSQN` int NOT NULL,
  `FKIDEstado` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ISSQN_link_produtos`
--

CREATE TABLE `ISSQN_link_produtos` (
  `id` int NOT NULL,
  `tipo` enum('ncm','produto','grupoProduto') NOT NULL,
  `FKIDRegrasTributacaoISSQN` int NOT NULL,
  `FKIDProduto` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ISSQN_regras_tributacao`
--

CREATE TABLE `ISSQN_regras_tributacao` (
  `id` int NOT NULL,
  `QualquerProduto` tinyint(1) DEFAULT NULL,
  `QualquerEstado` tinyint(1) DEFAULT NULL,
  `situacaoTributaria` int DEFAULT NULL,
  `Aliquota` float DEFAULT NULL,
  `Base` float DEFAULT NULL,
  `InformacoesComplementares` text,
  `InformacoesAdicionais` text,
  `DescontarISS` float DEFAULT NULL,
  `ReterISS` tinyint(1) DEFAULT NULL,
  `FKIDNaturezaOperacao` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `natureza_operacao`
--

CREATE TABLE `natureza_operacao` (
  `id` int UNSIGNED NOT NULL,
  `descricao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `serie` bigint DEFAULT NULL,
  `tipo` int NOT NULL COMMENT '    • saída     • entrada',
  `codigoRegimeTrib` int DEFAULT NULL COMMENT '    • simples nacional,     • Simples nacional - Excesso de sublimite de #receita bruta,     • Regime normal',
  `indicadorPresenca` int DEFAULT NULL COMMENT '    • 0 - Não se aplica,     • 1 - Operação presencial     • 2 - Operação não presencial, pela Internet     • 3 - Operação não presencial, Teleatendimento     • 4 - NFC-e em operação com entrega em domicílio     • 5 - Operação presencial, fora do estabelecimento     • 9 - Operação não presencial, Outros',
  `faturada` tinyint(1) DEFAULT NULL,
  `consumidorFinal` tinyint(1) DEFAULT NULL,
  `IncluirFreteBase` tinyint(1) DEFAULT NULL,
  `operacaoDevolucao` tinyint(1) DEFAULT NULL,
  `atualizarPrecoUltimaCompra` tinyint(1) DEFAULT NULL,
  `InformacoesComplementares` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `InformacoesAdicionais` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `empresaIDFK` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `outros_regras_tributacao`
--

CREATE TABLE `outros_regras_tributacao` (
  `id` int NOT NULL,
  `FKIDNaturezaOperacao` int UNSIGNED NOT NULL,
  `presumidoCalculoPisCofins` tinyint(1) DEFAULT NULL,
  `somarOutrasDespesas` tinyint(1) DEFAULT NULL,
  `aliquotaFunrural` float DEFAULT NULL,
  `compraProdutorRural` tinyint(1) DEFAULT NULL,
  `descontarFunRuralTotal` tinyint(1) DEFAULT NULL,
  `tipoAproxTrib` char(1) DEFAULT NULL,
  `tributos` float DEFAULT NULL,
  `tipoDesconto` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `PIS_link_estado`
--

CREATE TABLE `PIS_link_estado` (
  `id` int NOT NULL,
  `FKIDRegrasTributacaoPIS` int NOT NULL,
  `FKIDEstado` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `PIS_link_produtos`
--

CREATE TABLE `PIS_link_produtos` (
  `id` int NOT NULL,
  `FKIDRegrasTributacaoPIS` int NOT NULL,
  `FKIDProduto` varchar(15) NOT NULL,
  `tipo` enum('ncm','produto','grupoProduto') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `PIS_regras_tributacao`
--

CREATE TABLE `PIS_regras_tributacao` (
  `id` int NOT NULL,
  `QualquerProduto` tinyint(1) DEFAULT NULL,
  `QualquerEstado` tinyint(1) DEFAULT NULL,
  `Aliquota` float DEFAULT NULL,
  `Base` float DEFAULT NULL,
  `situacaoTributaria` int DEFAULT NULL COMMENT '      49 - Outras Operações de Saída     • 50 - Operação com Direito a Crédito - Vinculada Exclusivamente a Receita Tributada no Mercado Interno     • 51 - Operação com Direito a Crédito – Vinculada Exclusivamente a Receita Não Tributada no Mercado Interno     • 52 - Operação com Direito a Crédito - Vinculada Exclusivamente a Receita de Exportação     • 53 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno     • 54 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas no Mercado Interno e de Exportação     • 55 - Operação com Direito a Crédito - Vinculada a Receitas Não-Tributadas no Mercado Interno e de Exportação     • 56 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação     • 60 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Tributada no Mercado Interno     • 61 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Nã',
  `InformacoesComplementares` text,
  `InformacoesAdicionais` text,
  `FKIDNaturezaOperacao` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `retencoes_regras_tributacao`
--

CREATE TABLE `retencoes_regras_tributacao` (
  `id` int NOT NULL,
  `FKIDNaturezaOperacao` int UNSIGNED NOT NULL,
  `RetencaoImpostos` tinyint(1) DEFAULT NULL,
  `AliquotaCSLL` float DEFAULT NULL,
  `AliquotaIRRetido` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `COFINS_link_estado`
--
ALTER TABLE `COFINS_link_estado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKIDRegrasTributacaoCOFINS` (`FKIDRegrasTributacaoCOFINS`),
  ADD KEY `FKIDEstado` (`FKIDEstado`);

--
-- Índices para tabela `COFINS_link_produtos`
--
ALTER TABLE `COFINS_link_produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKIDRegrasTributacaoCOFINS` (`FKIDRegrasTributacaoCOFINS`);

--
-- Índices para tabela `COFINS_regras_tributacao`
--
ALTER TABLE `COFINS_regras_tributacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKIDNaturezaOperacao` (`FKIDNaturezaOperacao`);

--
-- Índices para tabela `ICMS_link_estado`
--
ALTER TABLE `ICMS_link_estado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKIDRegrasTributacaoICMS` (`FKIDRegrasTributacaoICMS`),
  ADD KEY `FKIDEstado` (`FKIDEstado`);

--
-- Índices para tabela `ICMS_link_produtos`
--
ALTER TABLE `ICMS_link_produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKIDRegrasTributacaoICMS` (`FKIDRegrasTributacaoICMS`);

--
-- Índices para tabela `ICMS_partilha`
--
ALTER TABLE `ICMS_partilha`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKIDRegrasTributacaoICMS` (`FKIDRegrasTributacaoICMS`);

--
-- Índices para tabela `ICMS_regras_tributacao`
--
ALTER TABLE `ICMS_regras_tributacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKIDNaturezaOperacao` (`FKIDNaturezaOperacao`);

--
-- Índices para tabela `ICMS_situacao_tributaria`
--
ALTER TABLE `ICMS_situacao_tributaria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKIDRegrasTributacaoICMS` (`FKIDRegrasTributacaoICMS`);

--
-- Índices para tabela `ICMS_substituicao_TRA`
--
ALTER TABLE `ICMS_substituicao_TRA`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKIDRegrasTributacaoICMS` (`FKIDRegrasTributacaoICMS`);

--
-- Índices para tabela `II_link_estado`
--
ALTER TABLE `II_link_estado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKIDRegrasTributacaoII` (`FKIDRegrasTributacaoII`),
  ADD KEY `FKIDEstado` (`FKIDEstado`);

--
-- Índices para tabela `II_link_produtos`
--
ALTER TABLE `II_link_produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKIDRegrasTributacaoII` (`FKIDRegrasTributacaoII`);

--
-- Índices para tabela `II_regras_tributacao`
--
ALTER TABLE `II_regras_tributacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKIDNaturezaOperacao` (`FKIDNaturezaOperacao`);

--
-- Índices para tabela `IPI_link_estado`
--
ALTER TABLE `IPI_link_estado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKIDRegrasTributacaoIPI` (`FKIDRegrasTributacaoIPI`),
  ADD KEY `FKIDEstado` (`FKIDEstado`);

--
-- Índices para tabela `IPI_link_produtos`
--
ALTER TABLE `IPI_link_produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKIDRegrasTributacaoIPI` (`FKIDRegrasTributacaoIPI`);

--
-- Índices para tabela `IPI_regras_tributacao`
--
ALTER TABLE `IPI_regras_tributacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKIDNaturezaOperacao` (`FKIDNaturezaOperacao`);

--
-- Índices para tabela `ISSQN_link_estado`
--
ALTER TABLE `ISSQN_link_estado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ISSQN_link_estado_ibfk_1` (`FKIDEstado`),
  ADD KEY `FKIDRegrasTributacaoISSQN` (`FKIDRegrasTributacaoISSQN`);

--
-- Índices para tabela `ISSQN_link_produtos`
--
ALTER TABLE `ISSQN_link_produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKIDRegrasTributacaoISSQN` (`FKIDRegrasTributacaoISSQN`);

--
-- Índices para tabela `ISSQN_regras_tributacao`
--
ALTER TABLE `ISSQN_regras_tributacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKIDNaturezaOperacao` (`FKIDNaturezaOperacao`);

--
-- Índices para tabela `natureza_operacao`
--
ALTER TABLE `natureza_operacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empresaIDFK` (`empresaIDFK`);

--
-- Índices para tabela `outros_regras_tributacao`
--
ALTER TABLE `outros_regras_tributacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKIDNaturezaOperacao` (`FKIDNaturezaOperacao`);

--
-- Índices para tabela `PIS_link_estado`
--
ALTER TABLE `PIS_link_estado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKIDRegrasTributacaoPIS` (`FKIDRegrasTributacaoPIS`),
  ADD KEY `FKIDEstado` (`FKIDEstado`);

--
-- Índices para tabela `PIS_link_produtos`
--
ALTER TABLE `PIS_link_produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKIDRegrasTributacaoPIS` (`FKIDRegrasTributacaoPIS`);

--
-- Índices para tabela `PIS_regras_tributacao`
--
ALTER TABLE `PIS_regras_tributacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKIDNaturezaOperacao` (`FKIDNaturezaOperacao`);

--
-- Índices para tabela `retencoes_regras_tributacao`
--
ALTER TABLE `retencoes_regras_tributacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKIDNaturezaOperacao` (`FKIDNaturezaOperacao`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `COFINS_link_estado`
--
ALTER TABLE `COFINS_link_estado`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `COFINS_link_produtos`
--
ALTER TABLE `COFINS_link_produtos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `COFINS_regras_tributacao`
--
ALTER TABLE `COFINS_regras_tributacao`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ICMS_link_estado`
--
ALTER TABLE `ICMS_link_estado`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ICMS_link_produtos`
--
ALTER TABLE `ICMS_link_produtos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ICMS_partilha`
--
ALTER TABLE `ICMS_partilha`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ICMS_regras_tributacao`
--
ALTER TABLE `ICMS_regras_tributacao`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ICMS_situacao_tributaria`
--
ALTER TABLE `ICMS_situacao_tributaria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ICMS_substituicao_TRA`
--
ALTER TABLE `ICMS_substituicao_TRA`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `II_link_estado`
--
ALTER TABLE `II_link_estado`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `II_link_produtos`
--
ALTER TABLE `II_link_produtos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `II_regras_tributacao`
--
ALTER TABLE `II_regras_tributacao`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `IPI_link_estado`
--
ALTER TABLE `IPI_link_estado`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `IPI_link_produtos`
--
ALTER TABLE `IPI_link_produtos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `IPI_regras_tributacao`
--
ALTER TABLE `IPI_regras_tributacao`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ISSQN_link_estado`
--
ALTER TABLE `ISSQN_link_estado`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ISSQN_link_produtos`
--
ALTER TABLE `ISSQN_link_produtos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ISSQN_regras_tributacao`
--
ALTER TABLE `ISSQN_regras_tributacao`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `natureza_operacao`
--
ALTER TABLE `natureza_operacao`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `outros_regras_tributacao`
--
ALTER TABLE `outros_regras_tributacao`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `PIS_link_estado`
--
ALTER TABLE `PIS_link_estado`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `PIS_link_produtos`
--
ALTER TABLE `PIS_link_produtos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `PIS_regras_tributacao`
--
ALTER TABLE `PIS_regras_tributacao`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `retencoes_regras_tributacao`
--
ALTER TABLE `retencoes_regras_tributacao`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `COFINS_link_estado`
--
ALTER TABLE `COFINS_link_estado`
  ADD CONSTRAINT `COFINS_link_estado_ibfk_1` FOREIGN KEY (`FKIDRegrasTributacaoCOFINS`) REFERENCES `COFINS_regras_tributacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `COFINS_link_estado_ibfk_2` FOREIGN KEY (`FKIDEstado`) REFERENCES `estado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `COFINS_link_produtos`
--
ALTER TABLE `COFINS_link_produtos`
  ADD CONSTRAINT `COFINS_link_produtos_ibfk_1` FOREIGN KEY (`FKIDRegrasTributacaoCOFINS`) REFERENCES `COFINS_regras_tributacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `COFINS_regras_tributacao`
--
ALTER TABLE `COFINS_regras_tributacao`
  ADD CONSTRAINT `COFINS_regras_tributacao_ibfk_1` FOREIGN KEY (`FKIDNaturezaOperacao`) REFERENCES `natureza_operacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `ICMS_link_estado`
--
ALTER TABLE `ICMS_link_estado`
  ADD CONSTRAINT `ICMS_link_estado_ibfk_1` FOREIGN KEY (`FKIDRegrasTributacaoICMS`) REFERENCES `ICMS_regras_tributacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ICMS_link_estado_ibfk_2` FOREIGN KEY (`FKIDEstado`) REFERENCES `estado` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `ICMS_link_produtos`
--
ALTER TABLE `ICMS_link_produtos`
  ADD CONSTRAINT `ICMS_link_produtos_ibfk_1` FOREIGN KEY (`FKIDRegrasTributacaoICMS`) REFERENCES `ICMS_regras_tributacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `ICMS_partilha`
--
ALTER TABLE `ICMS_partilha`
  ADD CONSTRAINT `ICMS_partilha_ibfk_1` FOREIGN KEY (`FKIDRegrasTributacaoICMS`) REFERENCES `ICMS_regras_tributacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `ICMS_regras_tributacao`
--
ALTER TABLE `ICMS_regras_tributacao`
  ADD CONSTRAINT `ICMS_regras_tributacao_ibfk_1` FOREIGN KEY (`FKIDNaturezaOperacao`) REFERENCES `natureza_operacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `ICMS_situacao_tributaria`
--
ALTER TABLE `ICMS_situacao_tributaria`
  ADD CONSTRAINT `ICMS_situacao_tributaria_ibfk_1` FOREIGN KEY (`FKIDRegrasTributacaoICMS`) REFERENCES `ICMS_regras_tributacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `ICMS_substituicao_TRA`
--
ALTER TABLE `ICMS_substituicao_TRA`
  ADD CONSTRAINT `ICMS_substituicao_TRA_ibfk_1` FOREIGN KEY (`FKIDRegrasTributacaoICMS`) REFERENCES `ICMS_regras_tributacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `II_link_estado`
--
ALTER TABLE `II_link_estado`
  ADD CONSTRAINT `II_link_estado_ibfk_1` FOREIGN KEY (`FKIDRegrasTributacaoII`) REFERENCES `II_regras_tributacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `II_link_estado_ibfk_2` FOREIGN KEY (`FKIDEstado`) REFERENCES `estado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `II_link_produtos`
--
ALTER TABLE `II_link_produtos`
  ADD CONSTRAINT `II_link_produtos_ibfk_1` FOREIGN KEY (`FKIDRegrasTributacaoII`) REFERENCES `II_regras_tributacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `II_regras_tributacao`
--
ALTER TABLE `II_regras_tributacao`
  ADD CONSTRAINT `II_regras_tributacao_ibfk_1` FOREIGN KEY (`FKIDNaturezaOperacao`) REFERENCES `natureza_operacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `IPI_link_estado`
--
ALTER TABLE `IPI_link_estado`
  ADD CONSTRAINT `IPI_link_estado_ibfk_1` FOREIGN KEY (`FKIDRegrasTributacaoIPI`) REFERENCES `IPI_regras_tributacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `IPI_link_estado_ibfk_2` FOREIGN KEY (`FKIDEstado`) REFERENCES `estado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `IPI_link_produtos`
--
ALTER TABLE `IPI_link_produtos`
  ADD CONSTRAINT `IPI_link_produtos_ibfk_1` FOREIGN KEY (`FKIDRegrasTributacaoIPI`) REFERENCES `IPI_regras_tributacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `IPI_regras_tributacao`
--
ALTER TABLE `IPI_regras_tributacao`
  ADD CONSTRAINT `IPI_regras_tributacao_ibfk_1` FOREIGN KEY (`FKIDNaturezaOperacao`) REFERENCES `natureza_operacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `ISSQN_link_estado`
--
ALTER TABLE `ISSQN_link_estado`
  ADD CONSTRAINT `ISSQN_link_estado_ibfk_1` FOREIGN KEY (`FKIDEstado`) REFERENCES `estado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ISSQN_link_estado_ibfk_2` FOREIGN KEY (`FKIDRegrasTributacaoISSQN`) REFERENCES `ISSQN_regras_tributacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `ISSQN_link_produtos`
--
ALTER TABLE `ISSQN_link_produtos`
  ADD CONSTRAINT `ISSQN_link_produtos_ibfk_1` FOREIGN KEY (`FKIDRegrasTributacaoISSQN`) REFERENCES `ISSQN_regras_tributacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `ISSQN_regras_tributacao`
--
ALTER TABLE `ISSQN_regras_tributacao`
  ADD CONSTRAINT `ISSQN_regras_tributacao_ibfk_1` FOREIGN KEY (`FKIDNaturezaOperacao`) REFERENCES `natureza_operacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `natureza_operacao`
--
ALTER TABLE `natureza_operacao`
  ADD CONSTRAINT `natureza_operacao_ibfk_1` FOREIGN KEY (`empresaIDFK`) REFERENCES `empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `outros_regras_tributacao`
--
ALTER TABLE `outros_regras_tributacao`
  ADD CONSTRAINT `outros_regras_tributacao_ibfk_1` FOREIGN KEY (`FKIDNaturezaOperacao`) REFERENCES `natureza_operacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `PIS_link_estado`
--
ALTER TABLE `PIS_link_estado`
  ADD CONSTRAINT `PIS_link_estado_ibfk_1` FOREIGN KEY (`FKIDRegrasTributacaoPIS`) REFERENCES `PIS_regras_tributacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `PIS_link_estado_ibfk_2` FOREIGN KEY (`FKIDEstado`) REFERENCES `estado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `PIS_link_produtos`
--
ALTER TABLE `PIS_link_produtos`
  ADD CONSTRAINT `PIS_link_produtos_ibfk_1` FOREIGN KEY (`FKIDRegrasTributacaoPIS`) REFERENCES `PIS_regras_tributacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `PIS_regras_tributacao`
--
ALTER TABLE `PIS_regras_tributacao`
  ADD CONSTRAINT `PIS_regras_tributacao_ibfk_1` FOREIGN KEY (`FKIDNaturezaOperacao`) REFERENCES `natureza_operacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `retencoes_regras_tributacao`
--
ALTER TABLE `retencoes_regras_tributacao`
  ADD CONSTRAINT `retencoes_regras_tributacao_ibfk_1` FOREIGN KEY (`FKIDNaturezaOperacao`) REFERENCES `natureza_operacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
