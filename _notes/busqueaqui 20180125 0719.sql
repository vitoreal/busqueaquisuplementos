-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.29-MariaDB


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema busqueaquisuplementos
--

CREATE DATABASE IF NOT EXISTS busqueaquisuplementos;
USE busqueaquisuplementos;

--
-- Definition of table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categoria`
--

/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` (`id`,`nome`) VALUES 
 (6,'dasdas asd \"'),
 (3,'tesss tee'),
 (1,'teste categoria'),
 (5,'vitor foda');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;


--
-- Definition of table `marca`
--

DROP TABLE IF EXISTS `marca`;
CREATE TABLE `marca` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `marca`
--

/*!40000 ALTER TABLE `marca` DISABLE KEYS */;
INSERT INTO `marca` (`id`,`nome`) VALUES 
 (3,'teste 2e');
/*!40000 ALTER TABLE `marca` ENABLE KEYS */;


--
-- Definition of table `permissoes`
--

DROP TABLE IF EXISTS `permissoes`;
CREATE TABLE `permissoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `roles` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissoes`
--

/*!40000 ALTER TABLE `permissoes` DISABLE KEYS */;
INSERT INTO `permissoes` (`id`,`nome`,`roles`) VALUES 
 (1,'Root','[\"ROLE_USUARIO\", \"ROLE_ADMIN\", \"ROLE_SUPER_ADMIN\"]'),
 (2,'Administrador','[\"ROLE_USUARIO\", \"ROLE_ADMIN\"]'),
 (3,'Usuario','[\"ROLE_USUARIO\"]');
/*!40000 ALTER TABLE `permissoes` ENABLE KEYS */;


--
-- Definition of table `sabor`
--

DROP TABLE IF EXISTS `sabor`;
CREATE TABLE `sabor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sabor`
--

/*!40000 ALTER TABLE `sabor` DISABLE KEYS */;
INSERT INTO `sabor` (`id`,`nome`) VALUES 
 (4,'Uva2');
/*!40000 ALTER TABLE `sabor` ENABLE KEYS */;


--
-- Definition of table `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` (`id`,`nome`) VALUES 
 (1,'Aprovado'),
 (2,'Aguardando Análise'),
 (3,'Não Aprovado'),
 (4,'Bloqueado');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;


--
-- Definition of table `tipo_produto`
--

DROP TABLE IF EXISTS `tipo_produto`;
CREATE TABLE `tipo_produto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tipo_produto_categoria1_idx` (`id_categoria`),
  CONSTRAINT `fk_tipo_produto_categoria1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tipo_produto`
--

/*!40000 ALTER TABLE `tipo_produto` DISABLE KEYS */;
INSERT INTO `tipo_produto` (`id`,`nome`,`id_categoria`) VALUES 
 (1,'teste',3),
 (2,'dasds',3),
 (4,'dsadsad',6);
/*!40000 ALTER TABLE `tipo_produto` ENABLE KEYS */;


--
-- Definition of table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_status` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dt_cadastro` datetime NOT NULL,
  `id_permissoes` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_UNIQUE` (`username`) USING BTREE,
  UNIQUE KEY `senha_UNIQUE` (`password`) USING BTREE,
  KEY `fk_usuario_status1_idx` (`id_status`),
  KEY `fk_usuario_permissoes1_idx` (`id_permissoes`),
  CONSTRAINT `fk_usuario_permissoes1` FOREIGN KEY (`id_permissoes`) REFERENCES `permissoes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_status1` FOREIGN KEY (`id_status`) REFERENCES `status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuario`
--

/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`id`,`id_status`,`nome`,`email`,`username`,`password`,`dt_cadastro`,`id_permissoes`) VALUES 
 (1,1,'root','root@root.com','root','$2y$13$.R8HocYM6QAcynopfRNQf..BDsBUMwZNwFkSa3DJ.QbQAp3tNJBSS','2017-07-18 04:49:58',1),
 (2,2,'teste2','teste@teste.com','teste','$2y$13$SYuTxyXqW7ZHtmmvAEmalOlAURV/P2XNJiHIdjGnLZTTTQi8cz7Py','2018-01-24 02:59:50',1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
