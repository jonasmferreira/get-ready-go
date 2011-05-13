<?php

	$path_root_categoriaController = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_categoriaController = "{$path_root_categoriaController}{$DS}..{$DS}..{$DS}";
	require_once "{$path_root_categoriaController}admin{$DS}model{$DS}categoria.class.php";
	$obj = new categoria();
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
				$obj->setSession('msgEdit', 'Erro ao tentar criar/editar Categoria!');
				header('Location: ../categoria.php');
			}else{
				$obj->setSession('msgEdit', 'Categoria salva com Sucesso!');
				header('Location: ../categoriaEdicao.php?categoria_id='.$result['categoria_id']);
			}
		break;
	}
?>
