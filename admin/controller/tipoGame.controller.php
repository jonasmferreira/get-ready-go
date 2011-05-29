<?php

	$path_root_tipoGameController = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_tipoGameController = "{$path_root_tipoGameController}{$DS}..{$DS}..{$DS}";
	require_once "{$path_root_tipoGameController}admin{$DS}model{$DS}tipoGame.class.php";
	$obj = new tipoGame();
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
				$obj->setSession('msgEdit', 'Erro ao tentar criar/editar Tipo de Games!');
				header('Location: ../tipoGame.php');
			}else{
				$obj->setSession('msgEdit', 'Tipo de Games salvo com Sucesso!');
				header('Location: ../tipoGameEdicao.php?game_tipo_id='.$result['game_tipo_id']);
			}
		break;
	}
?>
