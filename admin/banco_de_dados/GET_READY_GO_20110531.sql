ALTER TABLE `tb_game`
ADD COLUMN `game_width` INT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER `game_criador_nome`,
ADD COLUMN `game_height` INTEGER(10) UNSIGNED NOT NULL DEFAULT 0 AFTER `game_width`;

