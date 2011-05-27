<?php
$path_root_categoriaClass = dirname(__FILE__);
$DS = DIRECTORY_SEPARATOR;
$path_root_categoriaClass = "{$path_root_categoriaClass}{$DS}..{$DS}..{$DS}";
require_once "{$path_root_categoriaClass}admin{$DS}model{$DS}default.class.php";
class publicidadeTipo extends defaultClass{
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
			SELECT	*
			FROM	tb_publicidade_tipo

			WHERE	1 = 1
		";
		if(isset($this->values['publicidade_tipo_titulo'])&&trim($this->values['publicidade_tipo_titulo'])!=''){
			$sql[] = "AND	publicidade_tipo_titulo LIKE '%{$this->values['publicidade_tipo_titulo']}%'";
		}
		$sql[] = ") AS a";
		$totalCount = $this->getMaxCount(implode("\n",$sql));

		if(isset($this->sort_field)&&trim($this->sort_field)!=''){
			$sql[] = "ORDER BY {$this->sort_field} {$this->sort_direction}";
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
			SELECT	*
			FROM	tb_publicidade_tipo

			WHERE	1 = 1
		";
		if(isset($this->values['publicidade_tipo_id'])&&trim($this->values['publicidade_tipo_id'])!=''){
			$sql[] = "AND	publicidade_tipo_id = '{$this->values['publicidade_tipo_id']}'";
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
	public function edit(){
		$result = false;
		if(isset($this->values['publicidade_tipo_id'])&&trim($this->values['publicidade_tipo_id'])!=''){
			$result = $this->update();
		}else{
			$result = $this->insert();
		}
		return $result;
	}

	public function update(){
		$this->dbConn->db_start_transaction();
		$sql = array();
		$sql[] = "
			UPDATE	tb_publicidade_tipo SET
					publicidade_tipo_titulo = '{$this->values['publicidade_tipo_titulo']}'
					,publicidade_tipo_altura = '{$this->values['publicidade_tipo_altura']}'
					,publicidade_tipo_largura = '{$this->values['publicidade_tipo_largura']}'
					,publicidade_tipo_dt_alteracao = NOW()
					,publicidade_tipo_dtcomp_alteracao = NOW()
		";
		$sql[] = "WHERE publicidade_tipo_id = '{$this->values['publicidade_tipo_id']}'";
		$ret = array(
			'success'=>false
			,'publicidade_tipo_id' =>$this->values['publicidade_tipo_id']
		);
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			$this->dbConn->db_commit();
			$ret['success'] = $result['success'];
			$ret['publicidade_tipo_id'] = $this->values['publicidade_tipo_id'];
		}else{
			$this->dbConn->db_rollback();
		}
		return $ret;
	}
	public function insert(){
		$this->dbConn->db_start_transaction();
		$sql = array();
		$sql[] = "
			INSERT INTO tb_publicidade_tipo SET
					publicidade_tipo_titulo = '{$this->values['publicidade_tipo_titulo']}'
					,publicidade_tipo_altura = '{$this->values['publicidade_tipo_altura']}'
					,publicidade_tipo_largura = '{$this->values['publicidade_tipo_largura']}'
					,publicidade_tipo_dt_criacao = NOW()
					,publicidade_tipo_dtcomp_criacao = NOW()
		";

		$ret = array(
			'success'=>false
			,'publicidade_tipo_id' =>''
		);
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			$this->dbConn->db_commit();
			$ret['success'] = $result['success'];
			$ret['publicidade_tipo_id'] = $result['last_id'];
		}else{
			$this->dbConn->db_rollback();
		}
		return $ret;
	}
}
?>
