<?php

	$path_root_usuarioController = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_usuarioController = "{$path_root_usuarioController}{$DS}..{$DS}..{$DS}";
	require_once "{$path_root_usuarioController}admin{$DS}model{$DS}usuario.class.php";
	$obj = new usuario();
	switch($_REQUEST['action']){
		case 'getLista':
		default:
			$aJson = array();
			$aJson = $obj->getLista();
			echo json_encode($aJson);
		break;
	}
?>
