SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

ALTER TABLE `get_ready_go`.`tb_publicidade` ADD COLUMN `publicidade_tipo_id` INT(11) NOT NULL  AFTER `publicidade_id` , 
  ADD CONSTRAINT `tb_publicidade_ibfk_1`
  FOREIGN KEY (`publicidade_tipo_id` )
  REFERENCES `get_ready_go`.`tb_publicidade_tipo` (`publicidade_tipo_id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, ADD INDEX `tb_publicidade_ibfk_1` (`publicidade_tipo_id` ASC) ;

CREATE  TABLE IF NOT EXISTS `get_ready_go`.`tb_publicidade_tipo` (
  `publicidade_tipo_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `publicidade_tipo_titulo` VARCHAR(255) NOT NULL ,
  `publicidade_tipo_altura` INT(11) NOT NULL ,
  `publicidade_tipo_largura` INT(11) NOT NULL ,
  `publicidade_tipo_dt_criacao` DATE NOT NULL ,
  `publicidade_tipo_dtcomp_criacao` DATETIME NOT NULL ,
  `publicidade_tipo_dt_alteracao` DATE NULL DEFAULT NULL ,
  `publicidade_tipo_dtcomp_alteracao` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`publicidade_tipo_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
