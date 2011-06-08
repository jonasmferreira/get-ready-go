<?php
$path_root_home = dirname(__FILE__);
$DS = DIRECTORY_SEPARATOR;
$path_root_home = "{$path_root_home}{$DS}..{$DS}";
require_once "{$path_root_home}class{$DS}home.class.php";
$obj = new home();
switch($_REQUEST['action']){
	case 'addEnquete':
		$obj->setOpcao_enquete_opcao_id($_POST['opcao_voto']);
		if(!$obj->verifyVotos()){
			$aResult['success'] = true;
			$aResult['message'] = "Seu voto já foi computado!";
			echo json_encode($aResult);
			break;
		}
		if($obj->saveVoto()==false){
			$aResult['success'] = false;
			$aResult['message'] = "Error ao computar o seu voto";
		}else{
			$aResult['success'] = true;
			$aResult['message'] = "Seu voto foi computado com sucesso!";
		}
		echo json_encode($aResult);
	break;
}
?>
