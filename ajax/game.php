<?php
	$path_root_postController = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_postController = "{$path_root_postController}{$DS}..{$DS}";
	require_once "{$path_root_postController}class{$DS}game.class.php";
	$obj = new game();
	$obj->setGame_id($_POST['game_id']);
	switch($_REQUEST['action']){
		case'somaDownload':
			$aResult['success'] = $obj->saveQtdDownload();
			echo json_encode($aResult['success']);
		break;
		case'avaliacao':
			$obj->setPontuacao($_POST['pontuacao']);
			$aResult['success'] = $obj->savePontuacao();
			echo json_encode($aResult['success']);
		break;
	}
?>
