<?php
$path_root_enqueteClass = dirname(__FILE__);
$DS = DIRECTORY_SEPARATOR;
$path_root_enqueteClass = "{$path_root_enqueteClass}{$DS}..{$DS}..{$DS}";
require_once "{$path_root_enqueteClass}admin{$DS}model{$DS}default.class.php";
class enquete extends defaultClass{
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
			SELECT	e.enquete_id
					,e.enquete_titulo
					,e.enquete_status
					,e.enquete_dt_criacao
					,e.enquete_dtcomp_criacao
					,e.enquete_dt_alteracao
					,e.enquete_dtcomp_alteracao
					,(SELECT COUNT(*) FROM	tb_enquete_opcao WHERE enquete_id = e.enquete_id) AS qtde_opcoes
			FROM	tb_enquete e
			WHERE	1 = 1
		";
		if(isset($this->values['enquete_titulo'])&&trim($this->values['enquete_titulo'])!=''){
			$sql[] = "AND	e.enquete_titulo LIKE '%{$this->values['enquete_titulo']}%'";
		}
		if(isset($this->values['enquete_status'])&&trim($this->values['enquete_status'])!=''){
			$sql[] = "AND	e.enquete_status = '{$this->values['enquete_status']}'";
		}
		$sql[] = ") AS a";
		$totalCount = $this->getMaxCount(implode("\n",$sql));
		
		if(isset($this->sort_field)&&trim($this->sort_field)!=''){
			$sql[] = "ORDER BY a.{$this->sort_field} {$this->sort_direction}";
		}
		if(isset($this->limit_start)&&trim($this->limit_start)!=''){
			$sql[] = "LIMIT {$this->limit_start}, {$this->limit_max}";
		}
		
		$result = $this->dbConn->db_query(implode("\n",$sql));
		$success = $result['success'];
		if(!$result['success']){
			return false;
		}
		$res = array();
		if($result['total'] > 0){
			while($rs = $this->dbConn->db_fetch_assoc($result['result'])){
				array_push($res, $rs);
			}
		}
		if($returnExt){
			return $this->convertExtReturn($res, $success,count($res));
		}
		return $this->utf8_array_encode($res);
	}
	public function getOne(){
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
		if(isset($this->values['enquete_id'])&&trim($this->values['enquete_id'])!=''){
			$sql[] = "AND	enquete_id = '{$this->values['enquete_id']}'";
		}
		$result = $this->dbConn->db_query(implode("\n",$sql));
		if(!$result['success']){
			return false;
		}
		$rs = array();
		if($result['total'] > 0){
			$rs = $this->dbConn->db_fetch_assoc($result['result']);
		}
		return $this->utf8_array_encode($rs);
	}
	public function opcaoEnquete($enquete_id){
		$sql = array();
		$sql[] = "
			SELECT	eo.enquete_opcao_id
					,eo.enquete_id
					,eo.enquete_opcao_titulo
					,(SELECT COUNT(enquete_votacao_id) FROM tb_enquete_votacao WHERE opcao_enquete_opcao_id = eo.enquete_opcao_id) AS 'resultado'
			FROM	tb_enquete_opcao eo
			WHERE	1 = 1
			AND		eo.enquete_id = '{$enquete_id}'
		";
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
		return $this->utf8_array_encode($res);
	}
	public function edit(){
		$result = false;
		if(isset($this->values['enquete_id'])&&trim($this->values['enquete_id'])!=''){
			$result = $this->update();
		}else{
			$result = $this->insert();
		}
		return $result;
	}
	public function replaceOpcoes($opcoes){
		if(is_array($opcoes) && count($opcoes) > 0){
			foreach($opcoes AS $k=>$v){
				$sql = array();
				$sql[] = "
					REPLACE	INTO tb_enquete_opcoes SET
						enquete_id = '{$this->values['enquete_id']}'
						,enquete_opcao_titulo  = '{$v['enquete_opcao_titulo']}'
				";
				if(isset($v['enquete_opcao_id'])&&trim($v['enquete_opcao_id'])!=''){
					$sql[] = ",enquete_opcao_id = '{$v['enquete_opcao_id']}'";
				}
				$result = $this->dbConn->db_execute(implode("\n",$sql));
				if($result['success']===false){
					return false;
				}
			}
		}
		return true;
	}
	public function update(){
		$this->dbConn->db_start_transaction();
		$sql = array();
		$sql[] = "
			UPDATE	tb_enquete SET
					enquete_titulo = '{$this->values['enquete_titulo']}'
					,enquete_status  = '{$this->values['enquete_status']}'
					
					,enquete_dt_alteracao = NOW()
					,enquete_dtcomp_alteracao = NOW()
			WHERE	enquete_id = '{$this->values['enquete_id']}'
		";
		$ret = array(
			'success'=>false
			,'enquete_id' =>$this->values['enquete_id']
		);
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			$enquete_id = $this->values['enquete_id'];
			if(is_array($this->values['enquete_opcao_id'])&&count($this->values['enquete_opcao_id']>0)){
				foreach($this->values['enquete_opcao_id'] AS $k=> $v){
					$arr = array();
					$arr['enquete_opcao_id']=$v;
					$arr['enquete_opcao_id']=$enquete_id;
					$arr['enquete_opcao_titulo'] = $this->values['enquete_opcao_titulo'][$k];
					if(trim($v)!=''){
						$isSaveOpcao = $this->updateOpcaoEnquete($arr);
					}else{
						$isSaveOpcao = $this->insertOpcaoEnquete($arr);
					}
					if($isSaveOpcao['success']===false){
						$this->dbConn->db_rollback();
						return $isSaveOpcao;
					}
				}
			}
			$this->dbConn->db_commit();
			$ret['success'] = $result['success'];
			$ret['enquete_id'] = $this->values['enquete_id'];
		}else{
			$this->dbConn->db_rollback();
		}
		return $ret;
	}
	public function insert(){
		$this->dbConn->db_start_transaction();
		$sql = array();
		$sql[] = "
			INSERT INTO	tb_enquete SET
					enquete_titulo = '{$this->values['enquete_titulo']}'
					,enquete_status  = '{$this->values['enquete_status']}'
					,enquete_dt_criacao = NOW()
					,enquete_dtcomp_criacao = NOW()
		";
		$ret = array(
			'success'=>false
			,'enquete_id' =>''
		);
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			$enquete_id = $result['last_id'];
			if(is_array($this->values['enquete_opcao_id'])&&count($this->values['enquete_opcao_id']>0)){
				foreach($this->values['enquete_opcao_id'] AS $k=> $v){
					$arr = array();
					$arr['enquete_opcao_id']=$v;
					$arr['enquete_id']=$enquete_id;
					$arr['enquete_opcao_titulo'] = $this->values['enquete_opcao_titulo'][$k];
					if(trim($v)!=''){
						$isSaveOpcao = $this->updateOpcaoEnquete($arr);
					}else{
						$isSaveOpcao = $this->insertOpcaoEnquete($arr);
					}
					if($isSaveOpcao['success']===false){
						$this->dbConn->db_rollback();
						return $isSaveOpcao;
					}
				}
			}
			
			$this->dbConn->db_commit();
			$ret['success'] = $result['success'];
			$ret['enquete_id'] = $result['last_id'];
		}else{
			$this->dbConn->db_rollback();
		}
		return $ret;
	}
	private function insertOpcaoEnquete($arr){
		
		$sql = array();
		$sql[] = "
			INSERT INTO	tb_enquete_opcao SET
				enquete_id = '{$arr['enquete_id']}'
				,enquete_opcao_titulo = '{$arr['enquete_opcao_titulo']}'
		";
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		return $result;
		
	}
	private function updateOpcaoEnquete($arr){
		$sql = array();
		$sql[] = "
			UPDATE	tb_enquete_opcao SET
				enquete_id = '{$arr['enquete_id']}'
				,enquete_opcao_titulo = '{$arr['enquete_opcao_titulo']}'
			WHERE enquete_opcao_id = '{$arr['enquete_opcao_id']}'
		";
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		return $result;
	}
	public function deleteOpcaoEnquete(){
		$this->dbConn->db_start_transaction();
		$sql = array();
		$sql[] = "DELETE FROM tb_enquete_votacao WHERE enquete_opcao_id = '{$this->values['enquete_opcao_id']}'";
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			$sql = array();
			$sql[] = "DELETE FROM tb_enquete_opcao WHERE enquete_opcao_id = '{$this->values['enquete_opcao_id']}'";
			$result = $this->dbConn->db_execute(implode("\n",$sql));
			if($result['success']===true){
				$this->dbConn->db_commit();
				return true;
			}else{
				$this->dbConn->db_rollback();
				return false;
			}
		}else{
			$this->dbConn->db_rollback();
			return false;
		}
	}
}
?>
