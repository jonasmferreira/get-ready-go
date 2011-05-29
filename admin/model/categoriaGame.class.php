<?php
$path_root_gameCategoriaClass = dirname(__FILE__);
$DS = DIRECTORY_SEPARATOR;
$path_root_gameCategoriaClass = "{$path_root_gameCategoriaClass}{$DS}..{$DS}..{$DS}";
require_once "{$path_root_gameCategoriaClass}admin{$DS}model{$DS}default.class.php";
class categoriaGame extends defaultClass{
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
			SELECT	game_categoria_id
					,game_categoria_nome
			FROM	tb_game_categoria
			
			WHERE	1 = 1
		";
		if(isset($this->values['game_categoria_nome'])&&trim($this->values['game_categoria_nome'])!=''){
			$sql[] = "AND	game_categoria_nome LIKE '%{$this->values['game_categoria_nome']}%'";
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
			SELECT	game_categoria_id
					,game_categoria_nome
			FROM	tb_game_categoria
			
			WHERE	1 = 1
		";
		if(isset($this->values['game_categoria_id'])&&trim($this->values['game_categoria_id'])!=''){
			$sql[] = "AND	game_categoria_id = '{$this->values['game_categoria_id']}'";
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
		if(isset($this->values['game_categoria_id'])&&trim($this->values['game_categoria_id'])!=''){
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
			UPDATE	tb_game_categoria SET
					game_categoria_nome = '{$this->values['game_categoria_nome']}'
		";
		$sql[] = "WHERE game_categoria_id = '{$this->values['game_categoria_id']}'";
		$ret = array(
			'success'=>false
			,'game_categoria_id' =>$this->values['game_categoria_id']
		);
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			$this->dbConn->db_commit();
			$ret['success'] = $result['success'];
			$ret['game_categoria_id'] = $this->values['game_categoria_id'];
		}else{
			$this->dbConn->db_rollback();
		}
		return $ret;
	}
	public function insert(){
		$this->dbConn->db_start_transaction();
		$sql = array();
		$sql[] = "
			INSERT INTO	tb_game_categoria SET
				game_categoria_nome = '{$this->values['game_categoria_nome']}'
		";
		
		$ret = array(
			'success'=>false
			,'game_categoria_id' =>''
		);
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			$this->dbConn->db_commit();
			$ret['success'] = $result['success'];
			$ret['game_categoria_id'] = $result['last_id'];
		}else{
			$this->dbConn->db_rollback();
		}
		return $ret;
	}
}
?>
