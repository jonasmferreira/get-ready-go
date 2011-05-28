<?php

	$path_root_resultadoEnqueteController = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_resultadoEnqueteController = "{$path_root_resultadoEnqueteController}{$DS}..{$DS}..{$DS}";
	require_once "{$path_root_resultadoEnqueteController}admin{$DS}model{$DS}resultadoEnquete.class.php";
	$obj = new resultadoEnquete();
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
		
	}
	
	
?>
