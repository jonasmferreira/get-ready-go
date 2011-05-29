<?php

	$path_root_gameController = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_gameController = "{$path_root_gameController}{$DS}..{$DS}..{$DS}";
	require_once "{$path_root_gameController}admin{$DS}model{$DS}game.class.php";
	$obj = new game();
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
				$obj->setSession('msgEdit', 'Erro ao tentar criar/editar Game!');
				header('Location: ../game.php');
			}else{
				$obj->setSession('msgEdit', 'Game salvo com Sucesso!');
				header('Location: ../gameEdicao.php?game_id='.$result['game_id']);
			}
		break;
		case 'getTipoCombo':
			$aJson = array();
			$aJson = $obj->getTipoCombo();
			echo json_encode($aJson);
		break;
		case 'getCategoriaCombo':
			$aJson = array();
			$aJson = $obj->getCategoriaCombo();
			echo json_encode($aJson);
		break;
		case 'getUsuario':
			$aJson = array();
			$aJson = $obj->getUsuario();
			echo json_encode($aJson);
		break;
		case 'getUsuarioNome':
			$aJson = array();
			$obj->setValues($_REQUEST);
			$aJson = $obj->getUsuario(false);
			echo $aJson[0]['usuario_nome_nivel'];
		break;
	}
?>
