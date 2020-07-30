-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.12-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura para tabela avf_cms.anuncio
DROP TABLE IF EXISTS `anuncio`;
CREATE TABLE IF NOT EXISTS `anuncio` (
  `idAnuncio` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) NOT NULL DEFAULT 0,
  `tituloAnuncio` varchar(255) NOT NULL,
  `slugAnuncio` varchar(255) NOT NULL,
  `nomeRepresentante` varchar(255) DEFAULT NULL,
  `telefone` bigint(25) NOT NULL,
  `telWhatsApp` int(1) DEFAULT NULL,
  `telefoneAlt` bigint(25) DEFAULT NULL,
  `telAltWhatsApp` int(1) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `naoReceberEmail` int(1) DEFAULT NULL,
  `cep` bigint(25) NOT NULL,
  `rua` mediumtext NOT NULL,
  `numero` bigint(20) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `maps` mediumtext DEFAULT NULL,
  `horarioDeFuncionamento` varchar(50) DEFAULT NULL,
  `siteProprio` varchar(255) DEFAULT NULL,
  `imgCapa` varchar(255) DEFAULT NULL,
  `imgsGaleria` varchar(255) DEFAULT NULL,
  `miniDescricao` text DEFAULT NULL,
  `sobre` longtext DEFAULT NULL,
  `servicosOferecidos` tinytext DEFAULT NULL,
  `principaisProdutos` tinytext DEFAULT NULL,
  `midiasSociais` text DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `tituloSEO` text DEFAULT NULL,
  `descicaoSEO` text DEFAULT NULL,
  `keyWordsSEO` text DEFAULT NULL,
  `qtView` text DEFAULT NULL,
  `dataCadastro` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idAnuncio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela avf_cms.noticia
DROP TABLE IF EXISTS `noticia`;
CREATE TABLE IF NOT EXISTS `noticia` (
  `idNoticia` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) CHARACTER SET latin1 NOT NULL,
  `subTitulo` varchar(255) CHARACTER SET latin1 NOT NULL,
  `texto` longtext CHARACTER SET latin1 NOT NULL,
  `idUsuario` int(11) NOT NULL DEFAULT 0,
  `img` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idNoticia`) USING BTREE,
  KEY `titulo` (`titulo`),
  KEY `FK_noticias_usuario` (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela avf_cms.perfil
DROP TABLE IF EXISTS `perfil`;
CREATE TABLE IF NOT EXISTS `perfil` (
  `idPerfil` int(11) NOT NULL AUTO_INCREMENT,
  `nomePerfil` varchar(50) CHARACTER SET latin1 NOT NULL,
  `tipoPerfil` int(1) NOT NULL DEFAULT 2 COMMENT '[0->admin | 1-anunciante | 2-> usuario]',
  `status` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idPerfil`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='Perfils de usuarios criados pelo administrador do sistema';

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela avf_cms.usuario
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `idPerfil` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `sobreNome` varchar(50) DEFAULT NULL,
  `email` varchar(120) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `telefone_aux` varchar(20) DEFAULT NULL,
  `CPF` varchar(50) DEFAULT NULL,
  `senha` varchar(32) NOT NULL,
  `dataNascimento` datetime DEFAULT NULL,
  `sexo` char(5) DEFAULT NULL,
  `dataCadastro` datetime NOT NULL,
  `dataUltimoAcesso` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=ATIVO | 2=INATIVO | 0=DELETADO',
  `detalhes` mediumtext DEFAULT NULL,
  `superAdmin` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'SuperAdmin é o usuario master do sistema.',
  `imgPerfil` varchar(250) DEFAULT NULL,
  `chaveDeRecuperacao` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`idUsuario`),
  KEY `FK_usuario_perfil` (`idPerfil`),
  CONSTRAINT `FK_usuario_perfil` FOREIGN KEY (`idPerfil`) REFERENCES `perfil` (`idPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='Tabela de Usuário do sistema.';

-- Exportação de dados foi desmarcado.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
