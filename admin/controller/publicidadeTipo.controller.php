<?php

	$path_root_publicidateTipoController = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_publicidateTipoController = "{$path_root_publicidateTipoController}{$DS}..{$DS}..{$DS}";
	require_once "{$path_root_publicidateTipoController}admin{$DS}model{$DS}publicidadeTipo.class.php";
	$obj = new publicidadeTipo();
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
				$obj->setSession('msgEdit', 'Erro ao tentar criar/editar Tipo de publicidade!');
				header('Location: ../publicidadeTipo.php');
			}else{
				$obj->setSession('msgEdit', 'Tipo de publicidade salvo com Sucesso!');
				header('Location: ../publicidadeTipoEdicao.php?publicidade_tipo_id='.$result['publicidade_tipo_id']);
			}
		break;
	}
?>
