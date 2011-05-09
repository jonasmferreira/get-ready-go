<?php

	$path_root_usuarioController = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_usuarioController = "{$path_root_usuarioController}{$DS}..{$DS}..{$DS}";
	require_once "{$path_root_usuarioController}admin{$DS}model{$DS}usuario.class.php";
	$obj = new usuario();
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
		case 'getUsuarioNivel':
			$aJson = array();
			$aJson = $obj->getUsuarioNivel();
			echo json_encode($aJson);
		break;
		case 'getOne':
			$aJson = array();
			$obj->setValues($_REQUEST);
			$aJson = $obj->getOne();
			echo json_encode($aJson);
		break;
		case 'edit':
			$obj->setValues($_REQUEST);
			$obj->setFiles($_FILES);
			$result = $obj->edit();
			if($result['success']===false){
				$obj->setSession('msgEdit', 'Erro ao tentar criar/editar Usuário!');
				header('Location: ../usuario.php');
			}else{
				$obj->setSession('msgEdit', 'Usuário salvo com Sucesso!');
				header('Location: ../usuarioEdicao.php?usuario_id='.$result['usuario_id']);
			}
		break;
	}
?>
