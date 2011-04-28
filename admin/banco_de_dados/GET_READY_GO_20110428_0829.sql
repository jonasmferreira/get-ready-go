-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.1.41-3ubuntu12.10


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema get_ready_go
--

CREATE DATABASE IF NOT EXISTS get_ready_go;
USE get_ready_go;

--
-- Definition of table `get_ready_go`.`tb_categoria`
--

DROP TABLE IF EXISTS `get_ready_go`.`tb_categoria`;
CREATE TABLE  `get_ready_go`.`tb_categoria` (
  `categoria_id` int(10) unsigned NOT NULL,
  `categoria_nome` varchar(255) NOT NULL,
  `categoria_destaque_home` char(1) NOT NULL DEFAULT 'N',
  `categoria_galeria` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`categoria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `get_ready_go`.`tb_categoria`
--

/*!40000 ALTER TABLE `tb_categoria` DISABLE KEYS */;
LOCK TABLES `tb_categoria` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `tb_categoria` ENABLE KEYS */;


--
-- Definition of table `get_ready_go`.`tb_comentario`
--

DROP TABLE IF EXISTS `get_ready_go`.`tb_comentario`;
CREATE TABLE  `get_ready_go`.`tb_comentario` (
  `comentario_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) NOT NULL,
  `comentario_autor` varchar(255) NOT NULL,
  `comentario_email` varchar(255) NOT NULL,
  `comentario_conteudo` longtext NOT NULL,
  `comentario_dt_criacao` date NOT NULL,
  `comentario_dtcomp_criacao` datetime NOT NULL,
  `comentario_dt_alteracao` date NOT NULL,
  `comentario_dtcomp_alteracao` datetime NOT NULL,
  `usuario_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`comentario_id`),
  KEY `idx_comentario_dt_criacao` (`comentario_dt_criacao`),
  KEY `idx_comentario_dt_alteracao` (`comentario_dt_alteracao`),
  KEY `tb_comentario_FKIndex1` (`post_id`),
  CONSTRAINT `tb_comentario_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `tb_post` (`post_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `get_ready_go`.`tb_comentario`
--

/*!40000 ALTER TABLE `tb_comentario` DISABLE KEYS */;
LOCK TABLES `tb_comentario` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `tb_comentario` ENABLE KEYS */;


--
-- Definition of table `get_ready_go`.`tb_enquete`
--

DROP TABLE IF EXISTS `get_ready_go`.`tb_enquete`;
CREATE TABLE  `get_ready_go`.`tb_enquete` (
  `enquete_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `enquete_titulo` varchar(255) NOT NULL,
  `enquete_status` char(1) NOT NULL DEFAULT 'A',
  `enquete_dt_criacao` date NOT NULL,
  `enquete_dtcomp_criacao` datetime NOT NULL,
  `enquete_dt_alteracao` date NOT NULL,
  `enquete_dtcomp_alteracao` datetime NOT NULL,
  PRIMARY KEY (`enquete_id`),
  KEY `idx_enquete_dt_criacao` (`enquete_dt_criacao`),
  KEY `idx_enquete_dt_alteracao` (`enquete_dtcomp_alteracao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `get_ready_go`.`tb_enquete`
--

/*!40000 ALTER TABLE `tb_enquete` DISABLE KEYS */;
LOCK TABLES `tb_enquete` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `tb_enquete` ENABLE KEYS */;


--
-- Definition of table `get_ready_go`.`tb_enquete_opcao`
--

DROP TABLE IF EXISTS `get_ready_go`.`tb_enquete_opcao`;
CREATE TABLE  `get_ready_go`.`tb_enquete_opcao` (
  `enquete_opcao_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `enquete_id` bigint(20) NOT NULL,
  `enquete_opcao_titulo` varchar(255) NOT NULL,
  PRIMARY KEY (`enquete_opcao_id`),
  KEY `tb_enquete_opcao_FKIndex1` (`enquete_id`),
  CONSTRAINT `tb_enquete_opcao_ibfk_1` FOREIGN KEY (`enquete_id`) REFERENCES `tb_enquete` (`enquete_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `get_ready_go`.`tb_enquete_opcao`
--

/*!40000 ALTER TABLE `tb_enquete_opcao` DISABLE KEYS */;
LOCK TABLES `tb_enquete_opcao` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `tb_enquete_opcao` ENABLE KEYS */;


--
-- Definition of table `get_ready_go`.`tb_enquete_votacao`
--

DROP TABLE IF EXISTS `get_ready_go`.`tb_enquete_votacao`;
CREATE TABLE  `get_ready_go`.`tb_enquete_votacao` (
  `enquete_votacao_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `opcao_enquete_opcao_id` bigint(20) NOT NULL,
  `enquete_votacao_ip` varchar(255) NOT NULL,
  `enquete_votacao_dt` date NOT NULL,
  `enquete_votacao_dtcomp` datetime DEFAULT NULL,
  PRIMARY KEY (`enquete_votacao_id`),
  KEY `idx_enquete_votacao_dt` (`enquete_votacao_dt`),
  KEY `tb_enquete_votacao_FKIndex1` (`opcao_enquete_opcao_id`),
  CONSTRAINT `tb_enquete_votacao_ibfk_1` FOREIGN KEY (`opcao_enquete_opcao_id`) REFERENCES `tb_enquete_opcao` (`enquete_opcao_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `get_ready_go`.`tb_enquete_votacao`
--

/*!40000 ALTER TABLE `tb_enquete_votacao` DISABLE KEYS */;
LOCK TABLES `tb_enquete_votacao` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `tb_enquete_votacao` ENABLE KEYS */;


--
-- Definition of table `get_ready_go`.`tb_galeria`
--

DROP TABLE IF EXISTS `get_ready_go`.`tb_galeria`;
CREATE TABLE  `get_ready_go`.`tb_galeria` (
  `galeria_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `galeria_titulo` varchar(255) NOT NULL,
  `galeria_dt_criacao` date NOT NULL,
  `galeria_dtcomp_criacao` datetime NOT NULL,
  `galeria_dt_alteracao` date NOT NULL,
  `galeria_dtcomp_alteracao` datetime NOT NULL,
  `galeria_status` char(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`galeria_id`),
  KEY `idx_galeria_dt_criacao` (`galeria_dt_criacao`),
  KEY `idx_galeria_dt_alteracao` (`galeria_dt_alteracao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `get_ready_go`.`tb_galeria`
--

/*!40000 ALTER TABLE `tb_galeria` DISABLE KEYS */;
LOCK TABLES `tb_galeria` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `tb_galeria` ENABLE KEYS */;


--
-- Definition of table `get_ready_go`.`tb_imagem_galeria`
--

DROP TABLE IF EXISTS `get_ready_go`.`tb_imagem_galeria`;
CREATE TABLE  `get_ready_go`.`tb_imagem_galeria` (
  `imagem_galeria_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `galeria_id` int(10) unsigned NOT NULL,
  `imagem_galeria_titulo` varchar(255) NOT NULL,
  `imagem_galeria_imagem` varchar(255) NOT NULL,
  `imagem_galeria_thumb` varchar(255) NOT NULL,
  `imagem_galeria_dt_criacao` date NOT NULL,
  `imagem_galeria_dtcomp_criacao` datetime NOT NULL,
  `imagem_galeria_dt_alteracao` date NOT NULL,
  `imagem_galeria_dtcomp_alteracao` datetime NOT NULL,
  PRIMARY KEY (`imagem_galeria_id`),
  KEY `idx_imagem_galeria_dt_criacao` (`imagem_galeria_dt_criacao`),
  KEY `idx_imagem_galeria_dt_alteracao` (`imagem_galeria_dt_alteracao`),
  KEY `tb_imagem_galeria_FKIndex1` (`galeria_id`),
  CONSTRAINT `tb_imagem_galeria_ibfk_1` FOREIGN KEY (`galeria_id`) REFERENCES `tb_galeria` (`galeria_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `get_ready_go`.`tb_imagem_galeria`
--

/*!40000 ALTER TABLE `tb_imagem_galeria` DISABLE KEYS */;
LOCK TABLES `tb_imagem_galeria` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `tb_imagem_galeria` ENABLE KEYS */;


--
-- Definition of table `get_ready_go`.`tb_post`
--

DROP TABLE IF EXISTS `get_ready_go`.`tb_post`;
CREATE TABLE  `get_ready_go`.`tb_post` (
  `post_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `categoria_id` int(10) unsigned NOT NULL,
  `usuario_id` bigint(20) NOT NULL,
  `post_titulo` varchar(255) NOT NULL,
  `post_thumb_home` varchar(255) NOT NULL,
  `post_imagem` varchar(255) NOT NULL,
  `post_palavra_chave` text NOT NULL,
  `post_conteudo` longtext NOT NULL,
  `post_dt_criacao` date NOT NULL,
  `post_dtcomp_criacao` datetime NOT NULL,
  `post_dt_alteracao` date NOT NULL,
  `post_dtcomp_alteracao` datetime NOT NULL,
  `post_status` char(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`post_id`),
  KEY `idx_post_dt_criacao` (`post_dtcomp_criacao`),
  KEY `idx_post_dt_alteracao` (`post_dt_alteracao`),
  KEY `tb_post_FKIndex1` (`usuario_id`),
  KEY `tb_post_FKIndex2` (`categoria_id`),
  CONSTRAINT `tb_post_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `tb_usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tb_post_ibfk_2` FOREIGN KEY (`categoria_id`) REFERENCES `tb_categoria` (`categoria_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `get_ready_go`.`tb_post`
--

/*!40000 ALTER TABLE `tb_post` DISABLE KEYS */;
LOCK TABLES `tb_post` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `tb_post` ENABLE KEYS */;


--
-- Definition of table `get_ready_go`.`tb_post_galeria`
--

DROP TABLE IF EXISTS `get_ready_go`.`tb_post_galeria`;
CREATE TABLE  `get_ready_go`.`tb_post_galeria` (
  `galeria_id` int(10) unsigned NOT NULL,
  `post_id` bigint(20) NOT NULL,
  PRIMARY KEY (`galeria_id`,`post_id`),
  KEY `tb_post_has_tb_galeria_FKIndex1` (`post_id`),
  KEY `tb_post_has_tb_galeria_FKIndex2` (`galeria_id`),
  CONSTRAINT `tb_post_galeria_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `tb_post` (`post_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tb_post_galeria_ibfk_2` FOREIGN KEY (`galeria_id`) REFERENCES `tb_galeria` (`galeria_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `get_ready_go`.`tb_post_galeria`
--

/*!40000 ALTER TABLE `tb_post_galeria` DISABLE KEYS */;
LOCK TABLES `tb_post_galeria` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `tb_post_galeria` ENABLE KEYS */;


--
-- Definition of table `get_ready_go`.`tb_publicidade`
--

DROP TABLE IF EXISTS `get_ready_go`.`tb_publicidade`;
CREATE TABLE  `get_ready_go`.`tb_publicidade` (
  `publicidade_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `publicidade_tipomedia` char(1) NOT NULL DEFAULT 'I',
  `publicidade_arquivo` varchar(255) NOT NULL,
  `publicidade_numclique` varchar(10) NOT NULL,
  `publicidade_dt_ativacao` datetime NOT NULL,
  `publicidade_dt_desativacao` datetime NOT NULL,
  `publicidade_dt_criacao` date NOT NULL,
  `publicidade_dtcomp_criacao` datetime NOT NULL,
  PRIMARY KEY (`publicidade_id`),
  KEY `idx_publicidade_dt_criacao` (`publicidade_dt_criacao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `get_ready_go`.`tb_publicidade`
--

/*!40000 ALTER TABLE `tb_publicidade` DISABLE KEYS */;
LOCK TABLES `tb_publicidade` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `tb_publicidade` ENABLE KEYS */;


--
-- Definition of table `get_ready_go`.`tb_publicidade_numclique`
--

DROP TABLE IF EXISTS `get_ready_go`.`tb_publicidade_numclique`;
CREATE TABLE  `get_ready_go`.`tb_publicidade_numclique` (
  `publicidade_numclique_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `publicidade_id` bigint(20) NOT NULL,
  `publicidade_numclique_ip` varchar(255) NOT NULL,
  `publicidade_numclique_dt` date NOT NULL,
  `publicidade_num_clique_dtcomp` datetime NOT NULL,
  PRIMARY KEY (`publicidade_numclique_id`),
  KEY `idx_publicidade_numclique_dt` (`publicidade_numclique_dt`),
  KEY `tb_publicidade_numclique_FKIndex1` (`publicidade_id`),
  CONSTRAINT `tb_publicidade_numclique_ibfk_1` FOREIGN KEY (`publicidade_id`) REFERENCES `tb_publicidade` (`publicidade_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `get_ready_go`.`tb_publicidade_numclique`
--

/*!40000 ALTER TABLE `tb_publicidade_numclique` DISABLE KEYS */;
LOCK TABLES `tb_publicidade_numclique` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `tb_publicidade_numclique` ENABLE KEYS */;


--
-- Definition of table `get_ready_go`.`tb_usuario`
--

DROP TABLE IF EXISTS `get_ready_go`.`tb_usuario`;
CREATE TABLE  `get_ready_go`.`tb_usuario` (
  `usuario_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `usuario_nivel_id` int(10) unsigned NOT NULL,
  `usuario_nome` varchar(150) NOT NULL,
  `usuario_login` varchar(45) NOT NULL,
  `usuario_senha` varchar(45) NOT NULL,
  `usuario_email` varchar(255) NOT NULL,
  `usuario_avatar` varchar(255) NOT NULL,
  `usuario_status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`usuario_id`),
  KEY `tb_usuario_FKIndex1` (`usuario_nivel_id`),
  CONSTRAINT `tb_usuario_ibfk_1` FOREIGN KEY (`usuario_nivel_id`) REFERENCES `tb_usuario_nivel` (`usuario_nivel_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `get_ready_go`.`tb_usuario`
--

/*!40000 ALTER TABLE `tb_usuario` DISABLE KEYS */;
LOCK TABLES `tb_usuario` WRITE;
INSERT INTO `get_ready_go`.`tb_usuario` VALUES  (1,1,'Jonas Mendes','tchoi','destino','inboxfox@gmail.com',' ',1);
UNLOCK TABLES;
/*!40000 ALTER TABLE `tb_usuario` ENABLE KEYS */;


--
-- Definition of table `get_ready_go`.`tb_usuario_nivel`
--

DROP TABLE IF EXISTS `get_ready_go`.`tb_usuario_nivel`;
CREATE TABLE  `get_ready_go`.`tb_usuario_nivel` (
  `usuario_nivel_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_nivel_titulo` varchar(255) NOT NULL,
  PRIMARY KEY (`usuario_nivel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `get_ready_go`.`tb_usuario_nivel`
--

/*!40000 ALTER TABLE `tb_usuario_nivel` DISABLE KEYS */;
LOCK TABLES `tb_usuario_nivel` WRITE;
INSERT INTO `get_ready_go`.`tb_usuario_nivel` VALUES  (1,'Administrador'),
 (2,'Editor'),
 (3,'Usuário');
UNLOCK TABLES;
/*!40000 ALTER TABLE `tb_usuario_nivel` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
