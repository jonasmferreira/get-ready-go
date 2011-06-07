ALTER TABLE `tb_publicidade` 
	ADD COLUMN `publicidade_link` VARCHAR(255) DEFAULT NULL AFTER `publicidade_arquivo`;


ALTER TABLE `tb_usuario` ADD UNIQUE INDEX `unq_email`(`usuario_email`);

ALTER TABLE `tb_usuario` ADD UNIQUE INDEX `unq_login`(`usuario_login`);






