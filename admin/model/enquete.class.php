<?php
$path_root_enqueteClass = dirname(__FILE__);
$DS = DIRECTORY_SEPARATOR;
$path_root_enqueteClass = "{$path_root_enqueteClass}{$DS}..{$DS}..{$DS}";
require_once "{$path_root_enqueteClass}admin{$DS}model{$DS}default.class.php";
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
				$rs['opcoes'] = $this->opcaoEnquete($rs['enquete_id']);
				array_push($res, $rs);
			}
		}
		return $res;
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
			$rs['galerias'] = $this->galeriaPost($rs['post_id']);
			$rs['comentarios'] = $this->comentarioPost($rs['post_id']);
			$rs = $this->dbConn->db_fetch_assoc($result['result']);
		}
		return $rs;
	}
	public function opcaoEnquete($enquete_id){
		$sql = array();
		$sql[] = "
			SELECT	eo.enquete_opcao_id
					,eo.enquete_id
					,eo.enquete_opcao_titulo
					,(SELECT COUNT(enquete_votacao_id) FROM tb_enquete_votacao WHERE enquete_opcao_id = eo.enquete_opcao_id) AS 'resultado'
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
		return $res;
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
		$sql = array();
		$sql[] = "
			UPDATE	tb_enquete SET
					enquete_titulo = '{$this->values['enquete_titulo']}'
					,enquete_status  = '{$this->values['enquete_status']}'
					#,enquete_dt_criacao = NOW()
					#,enquete_dtcomp_criacao = NOW()
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
			if($this->replaceOpcoes($this->values['opcoes'])===true){
				$this->dbConn->db_commit();
				$ret['success'] = $result['success'];
				$ret['enquete_id'] = $this->values['enquete_id'];
			}else{
				$this->dbConn->db_rollback();
			}
		}else{
			$this->dbConn->db_rollback();
		}
		return $ret;
	}
	public function insert(){
		$sql = array();
		$sql[] = "
			INSERT INTO	tb_enquete SET
					enquete_titulo = '{$this->values['enquete_titulo']}'
					,enquete_status  = '{$this->values['enquete_status']}'
					,enquete_dt_criacao = NOW()
					,enquete_dtcomp_criacao = NOW()
					#,enquete_dt_alteracao = NOW()
					#,enquete_dtcomp_alteracao = NOW()
		";
		$ret = array(
			'success'=>false
			,'enquete_id' =>''
		);
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			if($this->replaceOpcoes($this->values['opcoes'])===true){
				$this->dbConn->db_commit();
				$ret['success'] = $result['success'];
				$ret['enquete_id'] = $result['last_id'];
			}else{
				$this->dbConn->db_rollback();
			}
		}else{
			$this->dbConn->db_rollback();
		}
		return $ret;
	}
}
?>
