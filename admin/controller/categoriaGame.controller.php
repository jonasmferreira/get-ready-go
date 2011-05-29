<?php

	$path_root_gameCategoriaController = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_gameCategoriaController = "{$path_root_gameCategoriaController}{$DS}..{$DS}..{$DS}";
	require_once "{$path_root_gameCategoriaController}admin{$DS}model{$DS}categoriaGame.class.php";
	$obj = new categoriaGame();
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
				$obj->setSession('msgEdit', 'Erro ao tentar criar/editar Categoria de Games!');
				header('Location: ../categoriaGame.php');
			}else{
				$obj->setSession('msgEdit', 'Categoria de Games salva com Sucesso!');
				header('Location: ../categoriaGameEdicao.php?game_categoria_id='.$result['game_categoria_id']);
			}
		break;
	}
?>
