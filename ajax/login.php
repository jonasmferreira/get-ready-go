<?php
	$path_root_postController = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_postController = "{$path_root_postController}{$DS}..{$DS}";
	require_once "{$path_root_postController}class/login.class.php";
	$obj = new login();
	switch($_REQUEST['action']){
		case 'logar':
			$obj->setValues($_POST);
			$result = $obj->logon();
			$aRes = array();
			if($result===false){
				$aRes['success'] = false;
			}else{
				$aRes['success'] = true;
				$aRes['session'] = $_SESSION['GET_READY_GO_2011_SITE'];
			}
			echo json_encode($aRes);
		break;
		case 'sessionUser':
			$aRes['session'] = print_r($_SESSION,true);
			echo json_encode($aRes);
		break;
		case 'logoff':
			$obj->destroySession();
		break;
	}
?>
