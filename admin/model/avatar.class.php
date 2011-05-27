<?php
$path_root_avatarClass = dirname(__FILE__);
$DS = DIRECTORY_SEPARATOR;
$path_root_avatarClass = "{$path_root_avatarClass}{$DS}..{$DS}..{$DS}";
require_once "{$path_root_avatarClass}admin{$DS}model{$DS}default.class.php";
class avatar extends defaultClass{
	private $avatarFolder;
	public function __construct() {
		$path_root_avatarClass = dirname(__FILE__);
		$DS = DIRECTORY_SEPARATOR;
		$path_root_avatarClass = "{$path_root_avatarClass}{$DS}..{$DS}..{$DS}";
		$this->dbConn = new DataBaseClass();
		$this->avatarFolder = "{$path_root_avatarClass}avatar_user{$DS}";
		if(!is_dir($this->avatarFolder)){
			mkdir($this->avatarFolder,0777);
			chmod($this->avatarFolder,0777);
		}
	}
	public function getLista($returnExt=true){
		$sql = array();
		$sql[] = "
			SELECT a.* 
			FROM	(
		";
		$sql[] = "
			SELECT	a.*
			FROM	tb_avatar a
			
			WHERE	1 = 1
		";
		if(isset($this->values['avatar_titulo'])&&trim($this->values['avatar_titulo'])!=''){
			$sql[] = "AND	a.avatar_titulo LIKE '%{$this->values['avatar_titulo']}%'";
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
			return $this->convertExtReturn($res, $success,$totalCount);
		}
		return $this->utf8_array_encode($res);
	}
	
	public function getOne(){
		$sql = array();
		$sql[] = "
			SELECT	a.*
			FROM	tb_avatar a
			
			WHERE	1 = 1
		";
		if(isset($this->values['avatar_id'])&&trim($this->values['avatar_id'])!=''){
			$sql[] = "AND	a.avatar_id = '{$this->values['avatar_id']}'";
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
		if(isset($this->values['avatar_id'])&&trim($this->values['avatar_id'])!=''){
			$result = $this->update();
		}else{
			$result = $this->insert();
		}
		return $result;
	}
	
	public function update(){
		$img = "";
		$fileNameImagem = str_replace(".","",microtime(true))."_".$this->files['avatar_imagem']['name'];
		if(move_uploaded_file($this->files['avatar_imagem']['tmp_name'], $this->avatarFolder.$fileNameImagem)){
			$img = $fileNameImagem;
		}else{
			$img = "";
		}
		
		$this->dbConn->db_start_transaction();
		$sql = array();
		$sql[] = "
			UPDATE	tb_avatar SET
					avatar_titulo = '{$this->values['avatar_titulo']}'
		";
		if(trim($img)!=''){
			$sql[] = ",avatar_imagem = '{$img}'";
		}
		$sql[] = "WHERE avatar_id = '{$this->values['avatar_id']}'";
		$ret = array(
			'success'=>false
			,'avatar_id' =>$this->values['avatar_id']
		);
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			$this->dbConn->db_commit();
			$ret['success'] = $result['success'];
			$ret['avatar_id'] = $this->values['avatar_id'];
		}else{
			$this->dbConn->db_rollback();
		}
		return $ret;
	}
	
	public function insert(){
		$img = "";
		$fileNameImagem = str_replace(".","",microtime(true))."_".$this->files['avatar_imagem']['name'];
		if(move_uploaded_file($this->files['avatar_imagem']['tmp_name'], $this->avatarFolder.$fileNameImagem)){
			$img = $fileNameImagem;
		}else{
			$img = "";
		}
		
		$this->dbConn->db_start_transaction();
		$sql = array();
		$sql[] = "
			INSERT INTO tb_avatar SET
					avatar_titulo = '{$this->values['avatar_titulo']}'
		";
		if(trim($img)!=''){
			$sql[] = ",avatar_imagem = '{$img}'";
		}
		$ret = array(
			'success'=>false
			,'avatar_id' =>''
		);
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			$this->dbConn->db_commit();
			$ret['success'] = $result['success'];
			$ret['avatar_id'] = $result['last_id'];
		}else{
			$this->dbConn->db_rollback();
		}
		return $ret;
	}
	
}
?>
