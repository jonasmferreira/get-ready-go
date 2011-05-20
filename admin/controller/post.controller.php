<?php

	$path_root_postController = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_postController = "{$path_root_postController}{$DS}..{$DS}..{$DS}";
	require_once "{$path_root_postController}admin{$DS}model{$DS}post.class.php";
	$obj = new post();
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
		case 'getGaleria':
			$aJson = array();
			$aJson = $obj->getGaleria();
			echo json_encode($aJson);
		break;
	
		case 'edit':

			//file_put_contents("files.txt",print_r($_FILES,true),FILE_APPEND);
			
			$obj->setValues($_REQUEST);
			$obj->setFiles($_FILES);
			
			$result = $obj->edit();
			if($result['success']===false){
				$obj->setSession('msgEdit', 'Erro ao tentar criar/editar Post!');
				header('Location: ../post.php');
			}else{
				$obj->setSession('msgEdit', 'Post salvo com Sucesso!');
				header('Location: ../postEdicao.php?post_id='.$result['post_id']);
			}
		break;
	}
	
	
?>
