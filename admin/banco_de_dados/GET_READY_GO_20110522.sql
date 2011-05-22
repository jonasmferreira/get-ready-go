SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

ALTER TABLE `get_ready_go`.`tb_categoria` CHANGE COLUMN `categoria_id` `categoria_id` INT(10) UNSIGNED NOT NULL  ;

ALTER TABLE `get_ready_go`.`tb_imagem_galeria` DROP COLUMN `imagem_galeria_thumb` ;

ALTER TABLE `get_ready_go`.`tb_post` ADD COLUMN `post_thumb_imagem` VARCHAR(255) NOT NULL  AFTER `post_imagem` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
