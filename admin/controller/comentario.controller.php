<?php
	$path_root_comentarioController = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_comentarioController = "{$path_root_comentarioController}{$DS}..{$DS}..{$DS}";
	require_once "{$path_root_comentarioController}admin{$DS}model{$DS}comentario.class.php";
	$obj = new comentario();
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

			$result = $obj->saveStatus();
			if($result['success']===false){
				$obj->setSession('msgEdit', 'Erro ao tentar ativar comentario!');
				header('Location: ../comentario.php');
			}else{
				$obj->setSession('msgEdit', 'Status do comentario alterado com sucesso!');
				header('Location: ../comentarioView.php?comentario_id='.$result['comentario_id']);
			}
		break;
	}
?>
