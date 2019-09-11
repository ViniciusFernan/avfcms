-- --------------------------------------------------------
-- Servidor:                     localhost
-- Versão do servidor:           10.3.12-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para locacao-sis
CREATE DATABASE IF NOT EXISTS `avf_cms` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `avf_cms`;

-- Copiando estrutura para tabela locacao-sis.perfil
CREATE TABLE IF NOT EXISTS `perfil` (
  `idPerfil` int(11) NOT NULL AUTO_INCREMENT,
  `nomePerfil` varchar(50) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idPerfil`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT COMMENT='Perfils de usuarios criados pelo administrador do sistema';

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela locacao-sis.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `idPerfil` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `sobreNome` varchar(50) DEFAULT NULL,
  `email` varchar(120) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='Tabela de Usuário do sistema.';

-- Exportação de dados foi desmarcado.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
