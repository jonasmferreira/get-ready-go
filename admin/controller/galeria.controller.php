<?php

	$path_root_galeriaController = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_galeriaController = "{$path_root_galeriaController}{$DS}..{$DS}..{$DS}";
	require_once "{$path_root_galeriaController}admin{$DS}model{$DS}galeria.class.php";
	$obj = new galeria();
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
		case 'getCategoria':
			$aJson = array();
			$aJson = $obj->getCategoria();
			echo json_encode($aJson);
		break;
		case 'getUsuario':
			$aJson = array();
			$aJson = $obj->getUsuario();
			echo json_encode($aJson);
		break;
	
		case 'edit':

			file_put_contents("files.txt",print_r($_FILES,true),FILE_APPEND);
			
			$obj->setValues($_REQUEST);
			$obj->setFiles($_FILES);
			
			$result = $obj->edit();
			if($result['success']===false){
				$obj->setSession('msgEdit', 'Erro ao tentar criar/editar galeria!');
				header('Location: ../galeria.php');
			}else{
				$obj->setSession('msgEdit', 'Galeria salva com Sucesso!');
				header('Location: ../galeriaEdicao.php?galeria_id='.$result['galeria_id']);
			}
		break;
	}
	
	
?>
