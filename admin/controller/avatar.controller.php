<?php

	$path_root_avatarController = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_avatarController = "{$path_root_avatarController}{$DS}..{$DS}..{$DS}";
	require_once "{$path_root_avatarController}admin{$DS}model{$DS}avatar.class.php";
	$obj = new avatar();
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
				$obj->setSession('msgEdit', 'Erro ao tentar criar/editar avatar!');
				header('Location: ../avatar.php');
			}else{
				$obj->setSession('msgEdit', 'Avatar salvo com Sucesso!');
				header('Location: ../avatarEdicao.php?avatar_id='.$result['avatar_id']);
			}
		break;
		
	}
	
	
?>
