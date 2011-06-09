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
			
			$aEnqRes = $obj->getEnqueteResult($_POST['enquete_id']);
			
			$aEnqRes['success'] = true;
			$aEnqRes['message'] = "Seu voto já foi computado!";
			$li = '';
			
			$tot = 0;
			//totalizando
			foreach($aEnqRes['data'] as $k => $v){
				$tot += $v['total'];
			}
			
			foreach($aEnqRes['data'] as $k => $v){
				if($v['total']==0){
					$w = 1;
					$per = 0;
				}else{
					$per = (100 * $v['total'] / $tot);
					$w = (210 / $per * 100);
				}
				
				$li.= "<li>";
				$li.= $v['enquete_opcao_titulo'] . "<br />";
				$li.= "<img src='{$linkAbsolute}imgs/enquete_result1.gif' />";
				$li.= "&nbsp;<img src='{$linkAbsolute}imgs/enquete_result3.gif' width='$w' height='5' />";
				$li.= "&nbsp;<img src='{$linkAbsolute}imgs/enquete_result2.gif' />&nbsp;" . $per ."%";
				$li.= "</li> ";
			}
			$aEnqRes['result'] = $li;
			echo json_encode($aEnqRes);
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
