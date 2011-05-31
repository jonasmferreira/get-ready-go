DROP TABLE IF EXISTS `tb_game_midia`;
CREATE TABLE  `tb_game_midia` (
  `game_midia_id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `game_midia_nome` varchar(255) NOT NULL,
  PRIMARY KEY (`game_midia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tb_game`;
CREATE TABLE  `tb_game` (
  `game_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `game_titulo` varchar(255) NOT NULL,
  `game_descricao` longtext NOT NULL,
  `game_thumb` varchar(255) NOT NULL,
  `game_imagem_destaque` varchar(255) NOT NULL,
  `game_tipo_id` int(10) unsigned NOT NULL,
  `game_categoria_id` int(10) unsigned NOT NULL,
  `game_link` varchar(255) NOT NULL,
  `game_qtd_download` int(10) unsigned NOT NULL,
  `game_qtd_jogado` int(10) unsigned NOT NULL,
  `game_criador_is_user` tinyint(1) NOT NULL,
  `game_criador_nome` varchar(255) NOT NULL,
  PRIMARY KEY (`game_id`),
  KEY `fk_game_cat` (`game_categoria_id`),
  KEY `fk_game_tipo` (`game_tipo_id`),
  CONSTRAINT `fk_game_cat` FOREIGN KEY (`game_categoria_id`) REFERENCES `tb_game_categoria` (`game_categoria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `tb_game`
ADD COLUMN `game_midia_id` INT(3) UNSIGNED NOT NULL AFTER `game_categoria_id`,
 ADD COLUMN `game_qtd_votacao` INT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER `game_qtd_jogado`,
 ADD COLUMN `game_total_votacao` BIGINT(20) UNSIGNED NOT NULL DEFAULT 0 AFTER `game_qtd_votacao`,
 ADD CONSTRAINT `fk_game_midia` FOREIGN KEY `fk_game_midia` (`game_midia_id`)
    REFERENCES `tb_game_midia` (`game_midia_id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;


