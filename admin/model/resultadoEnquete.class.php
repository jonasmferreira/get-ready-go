<?php
$path_root_resultadoEnqueteClass = dirname(__FILE__);
$DS = DIRECTORY_SEPARATOR;
$path_root_resultadoEnqueteClass = "{$path_root_resultadoEnqueteClass}{$DS}..{$DS}..{$DS}";
require_once "{$path_root_resultadoEnqueteClass}admin{$DS}model{$DS}default.class.php";
class resultadoEnquete extends defaultClass{
	public function __construct() {
		$this->dbConn = new DataBaseClass();
	}
	public function getLista($returnExt=true){
		$sql = array();
		$sql[] = "
			SELECT a.* 
			FROM	(
		";
		$sql[] = "
			SELECT	eo.enquete_opcao_id
					,eo.enquete_id
					,eo.enquete_opcao_titulo
					,(SELECT COUNT(enquete_votacao_id) FROM tb_enquete_votacao WHERE opcao_enquete_opcao_id = eo.enquete_opcao_id) AS 'resultado'
			FROM	tb_enquete_opcao eo
			WHERE	1 = 1
			
		";
		$sql[] = "AND eo.enquete_id =  '{$this->values['enquete_id']}'";
		$sql[] = ") AS a";
		
		if(isset($this->sort_field)&&trim($this->sort_field)!=''){
			$sql[] = "ORDER BY {$this->sort_field} {$this->sort_direction}";
		}
		
		
		$result = $this->dbConn->db_query(implode("\n",$sql));
		$success = $result['success'];
		if(!$result['success']){
			return false;
		}
		$res = array();
		if($result['total'] > 0){
			$enqueteTotal = $this->getTotal();
			while($rs = $this->dbConn->db_fetch_assoc($result['result'])){
				if($rs['resultado']>0 && $enqueteTotal > 0){
					$rs['percentual'] = $this->getPercent($enqueteTotal,$rs['resultado']);
				}else{
					$rs['percentual'] = 0;
				}
				array_push($res, $rs);
			}
		}
		if($returnExt){
			return $this->convertExtReturn($res, $success,$totalCount);
		}
		return $this->utf8_array_encode($res);
	}
	
	private function getTotal(){
		$sql = array();
		$sql[] = "
				SELECT	COUNT(enquete_votacao_id) AS total
				FROM	tb_enquete_votacao 
				WHERE	opcao_enquete_opcao_id IN (SELECT enquete_opcao_id FROM tb_enquete_opcao WHERE enquete_id = '{$this->values['enquete_id']}')
		";
		$result = $this->dbConn->db_query(implode("\n",$sql));
		$success = $result['success'];
		if(!$result['success']){
			return false;
		}
		$rs = $this->dbConn->db_fetch_assoc($result['result']);
		return $rs['total'];
	}
	private function getPercent($enqueteTotal,$resultado){
		$x = (100 * $resultado)/$enqueteTotal;
		return $x;
		
	}
	
	
}
?>
