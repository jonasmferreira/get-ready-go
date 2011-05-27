DROP TABLE IF EXISTS `get_ready_go`.`tb_avatar`;
CREATE TABLE  `get_ready_go`.`tb_avatar` (
  `avatar_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `avatar_titulo` varchar(255) NOT NULL,
  `avatar_imagem` varchar(255) NOT NULL,
  PRIMARY KEY (`avatar_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;