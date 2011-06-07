<?php
	$path_root_forgotController = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_forgotController = "{$path_root_forgotController}{$DS}..{$DS}";
	require_once "{$path_root_forgotController}class/forgotpassword.class.php";
	$obj = new forgotPassword();
	switch($_REQUEST['action']){
		case 'resetPassword':
			$obj->setValues($_POST);
			echo $obj->resetPassword();
		break;
	}
?>
