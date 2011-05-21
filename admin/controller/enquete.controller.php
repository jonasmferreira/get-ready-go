<?php

	$path_root_enqueteController = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_enqueteController = "{$path_root_enqueteController}{$DS}..{$DS}..{$DS}";
	require_once "{$path_root_enqueteController}admin{$DS}model{$DS}enquete.class.php";
	$obj = new enquete();
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
			
			$result = $obj->edit();
			if($result['success']===false){
				$obj->setSession('msgEdit', 'Erro ao tentar criar/editar enquete!');
				header('Location: ../enquete.php');
			}else{
				$obj->setSession('msgEdit', 'Enquete salva com Sucesso!');
				header('Location: ../enqueteEdicao.php?enquete_id='.$result['enquete_id']);
			}
		break;
		case 'deleteOpcaoEnquete':
			$obj->setValues($_REQUEST);
			$result = $obj->deleteOpcaoEnquete();
			if($result===false){
				echo 'Erro ao tentar excluir opção da enquete';
			}else{
				echo 'Opção da enquete excluída com sucesso!';
			}
		break;
	}
	
	
?>
