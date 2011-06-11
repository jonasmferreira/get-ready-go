ALTER TABLE `tb_usuario` 
	ADD COLUMN `usuario_country` VARCHAR(255) DEFAULT NULL AFTER `usuario_status`,
	ADD COLUMN `usuario_city` VARCHAR(255) DEFAULT NULL AFTER `usuario_country`,
	ADD COLUMN `usuario_birthdate` DATE DEFAULT NULL AFTER `usuario_city`,
	ADD COLUMN `usuario_gender` VARCHAR(1) DEFAULT NULL AFTER `usuario_birthdate`,
	ADD COLUMN `usuario_perfil` LONGTEXT DEFAULT NULL AFTER `usuario_gender`;

	