<?php
$path_root_enqueteClass = dirname(__FILE__);
$DS = DIRECTORY_SEPARATOR;
$path_root_enqueteClass = "{$path_root_enqueteClass}{$DS}..{$DS}..{$DS}";
require_once "{$path_root_enqueteClass}admin{$DS}class{$DS}default.class.php";
class categoria extends defaultClass{
	public function __construct() {
		$this->dbConn = new DataBaseClass();
	}
	public function getLista(){
		$sql = array();
		$sql[] = "
			SELECT	enquete_id
					,enquete_titulo
					,enquete_status
					,enquete_dt_criacao
					,enquete_dtcomp_criacao
					,enquete_dt_alteracao
					,enquete_dtcomp_alteracao
			FROM	tb_enquete
			WHERE	1 = 1
		";
		if(isset($this->values['enquete_titulo'])&&trim($this->values['enquete_titulo'])!=''){
			$sql[] = "AND	enquete_titulo = '{$this->values['enquete_titulo']}'";
		}
		if(isset($this->values['enquete_status'])&&trim($this->values['enquete_status'])!=''){
			$sql[] = "AND	enquete_status = '{$this->values['enquete_status']}'";
		}
		$result = $this->dbConn->db_query(implode("\n",$sql));
		if(!$result['success']){
			return false;
		}
		$res = array();
		if($result['total'] > 0){
			while($rs = $this->dbConn->db_fetch_assoc($result['result'])){
				array_push($res, $rs);
			}
		}
		return $res;
	}
	public function opcaoEnquete($enquete_id){
		$sql = array();
		$sql[] = "
			SELECT	enquete_id
					,enquete_titulo
					,enquete_status
					,enquete_dt_criacao
					,enquete_dtcomp_criacao
					,enquete_dt_alteracao
					,enquete_dtcomp_alteracao
			FROM	tb_enquete
			WHERE	1 = 1
		";
		
	}
}
?>
