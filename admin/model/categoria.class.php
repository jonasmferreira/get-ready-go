<?php
$path_root_categoriaClass = dirname(__FILE__);
$DS = DIRECTORY_SEPARATOR;
$path_root_categoriaClass = "{$path_root_categoriaClass}{$DS}..{$DS}..{$DS}";
require_once "{$path_root_categoriaClass}admin{$DS}class{$DS}default.class.php";
class categoria extends defaultClass{
	public function __construct() {
		$this->dbConn = new DataBaseClass();
	}
	public function getLista(){
		$sql = array();
		$sql[] = "
			SELECT	categoria_id
					,categoria_nome
					,categoria_destaque_home
					,categoria_galeria
			FROM	tb_categoria
			
			WHERE	1 = 1
		";
		if(isset($this->values['categoria_nome'])&&trim($this->values['categoria_nome'])!=''){
			$sql[] = "AND	categoria_nome = '{$this->values['categoria_nome']}'";
		}
		if(isset($this->values['categoria_galeria'])&&trim($this->values['categoria_galeria'])!=''){
			$sql[] = "AND	categoria_galeria = '{$this->values['categoria_galeria']}'";
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
	
	public function getOne(){
		$sql = array();
		$sql[] = "
			SELECT	categoria_id
					,categoria_nome
					,categoria_destaque_home
					,categoria_galeria
			FROM	tb_categoria
			
			WHERE	1 = 1
		";
		if(isset($this->values['categoria_id'])&&trim($this->values['categoria_id'])!=''){
			$sql[] = "AND	categoria_id = '{$this->values['categoria_id']}'";
		}
		$result = $this->dbConn->db_query(implode("\n",$sql));
		if(!$result['success']){
			return false;
		}
		$rs = array();
		if($result['total'] > 0){
			$rs = $this->dbConn->db_fetch_assoc($result['result']);
		}
		return $rs;
	}
	public function edit(){
		$result = false;
		if(isset($this->values['usuario_id'])&&trim($this->values['usuario_id'])!=''){
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
			UPDATE	tb_categoria SET
					categoria_nome = '{$this->values['categoria_nome']}'
					,categoria_destaque_home = '{$this->values['categoria_destaque_home']}'
					,categoria_galeria = '{$this->values['categoria_galeria']}'
		";
		$sql[] = "WHERE categoria_id = '{$this->values['categoria_id']}'";
		$ret = array(
			'success'=>false
			,'categoria_id' =>$this->values['categoria_id']
		);
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			$ret['success'] = $result['success'];
			$ret['categoria_id'] = $this->values['categoria_id'];
		}
		return $ret;
	}
	public function insert(){
		$this->dbConn->db_start_transaction();
		$sql = array();
		$sql[] = "
			INSERT INTO	tb_categoria SET
				categoria_nome = '{$this->values['categoria_nome']}'
				,categoria_destaque_home = '{$this->values['categoria_destaque_home']}'
				,categoria_galeria = '{$this->values['categoria_galeria']}'
		";
		
		$ret = array(
			'success'=>false
			,'categoria_id' =>''
		);
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			$this->dbConn->db_commit();
			$ret['success'] = $result['success'];
			$ret['categoria_id'] = $result['last_id'];
		}else{
			$this->dbConn->db_rollback();
		}
		return $ret;
	}
}
?>
