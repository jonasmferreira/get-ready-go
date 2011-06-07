<?php
$path_root_captcha = dirname(__FILE__);
$DS = DIRECTORY_SEPARATOR;
$path_root_captcha = "{$path_root_captcha}{$DS}..{$DS}";
include "{$path_root_captcha}lib{$DS}captcha{$DS}securimage.php";
require_once "{$path_root_captcha}class{$DS}noticia.class.php";
$img = new securimage();
$obj = new noticia();

switch($_REQUEST['action']){
	case 'addComentario':
		$verifyCaptcha = $img->check($_POST['captcha']);
		if($verifyCaptcha==false){
			$aResult['success'] = false;
			$aResult['message'] = "Captcha incorreto!";
			echo json_encode($aResult);
			break;
		}
		$obj->setValues($_POST);
		if($obj->saveComentario()==false){
			$aResult['success'] = false;
			$aResult['message'] = "Error ao inserir o comentário";
		}else{
			$aResult['success'] = true;
			$aResult['message'] = "Comentário salvo com sucesso!";
		}
		echo json_encode($aResult);
	break;
	case'session':
		echo "<pre>".print_r($_SESSION,true)."</pre>";
	break;
}
?>
