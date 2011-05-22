ALTER TABLE `get_ready_go`.`tb_imagem_galeria` DROP COLUMN `imagem_galeria_thumb` ;

ALTER TABLE `get_ready_go`.`tb_post` ADD COLUMN `post_thumb_imagem` VARCHAR(255) NOT NULL  AFTER `post_imagem` ;
