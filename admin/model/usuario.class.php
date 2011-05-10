<?php
$path_root_usuarioClass = dirname(__FILE__);
$DS = DIRECTORY_SEPARATOR;
$path_root_usuarioClass = "{$path_root_usuarioClass}{$DS}..{$DS}..{$DS}";
require_once "{$path_root_usuarioClass}admin{$DS}model{$DS}default.class.php";
class usuario extends defaultClass{
	private $avatarFolder;
	public function __construct() {
		$path_root_usuarioClass = dirname(__FILE__);
		$DS = DIRECTORY_SEPARATOR;
		$path_root_usuarioClass = "{$path_root_usuarioClass}{$DS}..{$DS}..{$DS}";
		$this->dbConn = new DataBaseClass();
		$this->avatarFolder = "{$path_root_usuarioClass}avatars{$DS}";
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
				SELECT	u.usuario_id
						,u.usuario_nivel_id
						,u.usuario_nome
						,u.usuario_login
						,u.usuario_senha
						,u.usuario_email
						,u.usuario_avatar
						,u.usuario_status
						,un.usuario_nivel_titulo
				FROM	tb_usuario u

				JOIN	tb_usuario_nivel un
				ON		un.usuario_nivel_id = u.usuario_nivel_id

				WHERE	1 = 1
		";
		if(isset($this->values['usuario_nivel_id'])&&trim($this->values['usuario_nivel_id'])!=''){
			$sql[] = "	AND	u.usuario_nivel_id = '{$this->values['usuario_nivel_id']}'";
		}
		if(isset($this->values['usuario_nome'])&&trim($this->values['usuario_nome'])!=''){
			$sql[] = "	AND	u.usuario_nome = '{$this->values['usuario_nome']}'";
		}
		if(isset($this->values['usuario_login'])&&trim($this->values['usuario_login'])!=''){
			$sql[] = "	AND	u.usuario_login = '{$this->values['usuario_login']}'";
		}
		if(isset($this->values['usuario_email'])&&trim($this->values['usuario_email'])!=''){
			$sql[] = "	AND	u.usuario_email = '{$this->values['usuario_email']}'";
		}
		if(isset($this->values['usuario_status'])&&trim($this->values['usuario_status'])!=''){
			$sql[] = "	AND	u.usuario_status = '{$this->values['usuario_email']}'";
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
		return $res;
	}
	public function getOne(){
		$sql = array();
		$sql[] = "
			SELECT	u.usuario_id
					,u.usuario_nivel_id
					,u.usuario_nome
					,u.usuario_login
					,u.usuario_senha
					,u.usuario_email
					,u.usuario_avatar
					,u.usuario_status
					,un.usuario_nivel_titulo
			FROM	tb_usuario u
			
			JOIN	tb_usuario_nivel un
			ON		un.usuario_nivel_id = u.usuario_nivel_id
			
			WHERE	1 = 1
		";
		if(isset($this->values['usuario_id'])&&trim($this->values['usuario_id'])!=''){
			$sql[] = "AND	u.usuario_id = '{$this->values['usuario_id']}'";
		}
		$result = $this->dbConn->db_query(implode("\n",$sql));
		$success = $result['success'];
		if(!$result['success']){
			return false;
		}
		$rs = array();
		
		if($result['total'] > 0){
			$rs = $this->dbConn->db_fetch_assoc($result['result']);
		}
		return $rs;
	}
	public function verifyUsuario(){
		$sql = array();
		$sql[] = "
			SELECT	*
			FROM	tb_usuario u
			WHERE	1 = 1
		";
		$sqlOr = array();
		if(isset($this->values['usuario_id'])&&trim($this->values['usuario_id'])!=''){
			$sql[] = "AND	u.usuario_id != '{$this->values['usuario_id']}'";
		}
		if(isset($this->values['usuario_nome'])&&trim($this->values['usuario_nome'])!=''){
			$sqlOr[] = "u.usuario_nome = '{$this->values['usuario_nome']}'";
		}
		if(isset($this->values['usuario_login'])&&trim($this->values['usuario_login'])!=''){
			$sqlOr[] = "u.usuario_login = '{$this->values['usuario_login']}'";
		}
		if(isset($this->values['usuario_email'])&&trim($this->values['usuario_email'])!=''){
			$sqlOr[] = "u.usuario_email = '{$this->values['usuario_email']}'";
		}
		if(count($sqlOr)>0){
			$sql[] = "AND	(".implode(" OR ",$sqlOr).")";
		}
		$result = $this->dbConn->db_query(implode("\n",$sql));
		if(!$result['success']){
			return false;
		}
		$rs = array();
		if($result['total'] > 0){
			return false;
		}else{
			return true;
		}
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
		
		$fileName = str_replace(".","",microtime(true))."_".$this->files['usuario_avatar_up']['name'];
		if(move_uploaded_file($this->files['usuario_avatar_up']['tmp_name'], $this->avatarFolder.$fileName)){
			$this->values['usuario_avatar'] = $fileName;
		}else{
			$this->values['usuario_avatar'] = "";
		}
		
		
		$sql[] = "
			UPDATE	tb_usuario SET
				usuario_nivel_id = '{$this->values['usuario_nivel_id']}'
				,usuario_nome = '{$this->values['usuario_nome']}'
				,usuario_login = '{$this->values['usuario_login']}'
				,usuario_senha = '{$this->values['usuario_senha']}'
				,usuario_email = '{$this->values['usuario_email']}'				
		";
		if(isset($this->values['usuario_avatar'])&&trim($this->values['usuario_avatar'])!=''){
			$sql[] = ",usuario_avatar = '{$this->values['usuario_avatar']}'";
		}
		$sql[] = "WHERE usuario_id = '{$this->values['usuario_id']}'";
		$ret = array(
			'success'=>false
			,'usuario_id' =>''
		);
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			$this->dbConn->db_commit();
			$ret['success'] = $result['success'];
			$ret['usuario_id'] = $this->values['usuario_id'];
		}else{
			$this->dbConn->db_rollback();
		}
		return $ret;
	}
	public function insert(){
		$this->dbConn->db_start_transaction();
		$sql = array();
		
		$fileName = str_replace(".","",microtime(true))."_".$this->files['usuario_avatar_up']['name'];
		if(move_uploaded_file($this->files['usuario_avatar_up']['tmp_name'], $this->avatarFolder.$fileName)){
			$this->values['usuario_avatar'] = $fileName;
		}else{
			$this->values['usuario_avatar'] = "";
		}
		
		$sql[] = "
			INSERT INTO	tb_usuario SET
				usuario_nivel_id = '{$this->values['usuario_nivel_id']}'
				,usuario_nome = '{$this->values['usuario_nome']}'
				,usuario_login = '{$this->values['usuario_login']}'
				,usuario_senha = '{$this->values['usuario_senha']}'
				,usuario_email = '{$this->values['usuario_email']}'
				,usuario_status = '{$this->values['usuario_status']}'
		";
		if(isset($this->values['usuario_avatar'])&&trim($this->values['usuario_avatar'])!=''){
			$sql[] = ",usuario_avatar = '{$this->values['usuario_avatar']}'";
		}
		
		$ret = array(
			'success'=>false
			,'usuario_id' =>''
		);
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			$this->dbConn->db_commit();
			$ret['success'] = $result['success'];
			$ret['usuario_id'] = $result['last_id'];
		}else{
			$this->dbConn->db_rollback();
		}
		return $ret;
	}
	public function getUsuarioNivel($returnExt=true){
		$sql = array();
		$sql[] = "
				SELECT	un.usuario_nivel_id
						,un.usuario_nivel_titulo
				FROM	tb_usuario_nivel un
				WHERE	1 = 1
		";
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
		return $res;
	}
}