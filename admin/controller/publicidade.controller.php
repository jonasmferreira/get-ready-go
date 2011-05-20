<?php
	$path_root_publicidadeView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_publicidadeView = "{$path_root_publicidadeView}{$DS}..{$DS}..{$DS}";
	require_once "{$path_root_publicidadeView}admin{$DS}model{$DS}publicidade.class.php";
	$obj = new publicidade();
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
			$obj->setValues($_REQUEST);
			$obj->setFiles($_FILES);

			$result = $obj->edit();
			if($result['success']===false){
				$obj->setSession('msgEdit', 'Erro ao tentar criar/editar publicidade!');
				header('Location: ../publicidade.php');
			}else{
				$obj->setSession('msgEdit', 'Publicidade salva com Sucesso!');
				header('Location: ../publicidadeEdicao.php?publicidade_id='.$result['publicidade_id']);
			}
		break;
		case 'deleteImagemGaleria':
			$obj->setValues($_REQUEST);
			$result = $obj->deleteImagemGaleria();
			if($result===false){
				echo 'Erro ao tentar excluir imagem da galeria';
			}else{
				echo 'Imagem da galeria excluida com sucesso!';
			}
		break;
	}


?>
