<?php
$path_root_midiaGameClass = dirname(__FILE__);
$DS = DIRECTORY_SEPARATOR;
$path_root_midiaGameClass = "{$path_root_midiaGameClass}{$DS}..{$DS}..{$DS}";
require_once "{$path_root_midiaGameClass}admin{$DS}model{$DS}default.class.php";
class midiaGame extends defaultClass{
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
			SELECT	game_midia_id
					,game_midia_nome
			FROM	tb_game_midia
			
			WHERE	1 = 1
		";
		if(isset($this->values['game_midia_nome'])&&trim($this->values['game_midia_nome'])!=''){
			$sql[] = "AND	game_midia_nome LIKE '%{$this->values['game_midia_nome']}%'";
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
			SELECT	game_midia_id
					,game_midia_nome
			FROM	tb_game_midia
			
			WHERE	1 = 1
		";
		if(isset($this->values['game_midia_id'])&&trim($this->values['game_midia_id'])!=''){
			$sql[] = "AND	game_midia_id = '{$this->values['game_midia_id']}'";
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
		if(isset($this->values['game_midia_id'])&&trim($this->values['game_midia_id'])!=''){
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
			UPDATE	tb_game_midia SET
					game_midia_nome = '{$this->values['game_midia_nome']}'
		";
		$sql[] = "WHERE game_midia_id = '{$this->values['game_midia_id']}'";
		$ret = array(
			'success'=>false
			,'game_midia_id' =>$this->values['game_midia_id']
		);
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			$this->dbConn->db_commit();
			$ret['success'] = $result['success'];
			$ret['game_midia_id'] = $this->values['game_midia_id'];
		}else{
			$this->dbConn->db_rollback();
		}
		return $ret;
	}
	public function insert(){
		$this->dbConn->db_start_transaction();
		$sql = array();
		$sql[] = "
			INSERT INTO	tb_game_midia SET
				game_midia_nome = '{$this->values['game_midia_nome']}'
		";
		
		$ret = array(
			'success'=>false
			,'game_midia_id' =>''
		);
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			$this->dbConn->db_commit();
			$ret['success'] = $result['success'];
			$ret['game_midia_id'] = $result['last_id'];
		}else{
			$this->dbConn->db_rollback();
		}
		return $ret;
	}
}
?>
