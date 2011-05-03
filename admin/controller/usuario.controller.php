<?php

	$path_root_usuarioController = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_usuarioController = "{$path_root_usuarioController}{$DS}..{$DS}..{$DS}";
	require_once "{$path_root_usuarioController}admin{$DS}model{$DS}usuario.class.php";
	$obj = new usuario();
	switch($_REQUEST['action']){
		case 'getLista':
		default:
			if(isset($_REQUEST['start'])==true) $obj->setLimitStart($_REQUEST['start']);
			if(isset($_REQUEST['limit'])==true) $obj->setLimitMax($_REQUEST['limit']);
			if(isset($_REQUEST['sort'])==true) $obj->setSort($_REQUEST['sort']);
			$aJson = array();
			$aJson = $obj->getLista();
			echo json_encode($aJson);
		break;
	}
?>
