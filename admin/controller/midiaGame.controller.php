<?php

	$path_root_midiaGameController = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_midiaGameController = "{$path_root_midiaGameController}{$DS}..{$DS}..{$DS}";
	require_once "{$path_root_midiaGameController}admin{$DS}model{$DS}midiaGame.class.php";
	$obj = new midiaGame();
	switch($_REQUEST['action']){
		case 'getLista':
		default:
			$obj->setLimitStart($_REQUEST['start']);
			$obj->setLimitMax($_REQUEST['limit']);
			$obj->setSort($_REQUEST['sort']);
			
			$obj->setValues($_REQUEST);
			
			$aJson = array();
			$aJson = $obj->getLista();
			echo json_encode($aJson);
		break;
		case 'edit':
			$obj->setValues($_REQUEST);
			$obj->setFiles($_FILES);
			$result = $obj->edit();
			if($result['success']===false){
				$obj->setSession('msgEdit', 'Erro ao tentar criar/editar Mídia de Games!');
				header('Location: ../midiaGame.php');
			}else{
				$obj->setSession('msgEdit', 'Mídia de Games salvo com Sucesso!');
				header('Location: ../midiaGameEdicao.php?game_midia_id='.$result['game_midia_id']);
			}
		break;
	}
?>
