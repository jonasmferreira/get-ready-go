<?php
require_once "default.class.php";
class meu_perfil extends defaultClass{
	public function __construct() {
		$this->dbConn = new DataBaseClass();
	}
	public function savePerfil(){
		$this->dbConn->db_start_transaction();
		$usuario_nome = $this->antiInjection($this->values['usuario_nome']);
		$usuario_email = $this->antiInjection($this->values['usuario_email']);
		$usuario_country = $this->antiInjection($this->values['usuario_country']);
		$usuario_city = $this->antiInjection($this->values['usuario_city']);
		$usuario_birthdate = $this->antiInjection($this->values['usuario_birthdate']);
		$usuario_gender = $this->antiInjection($this->values['usuario_gender']);
		$usuario_perfil = $this->antiInjection($this->values['usuario_perfil']);
		
		$sql = array();
		$sql[] = "
			UPDATE tb_usuario SET
				usuario_nivel_id = '3'
				,usuario_nome = '{$usuario_nome}'
				,usuario_email = '{$usuario_email}'
				,usuario_country = '{$usuario_country}'
				,usuario_city = '{$usuario_city}'
				,usuario_birthdate = '{$usuario_birthdate}'
				,usuario_gender = '{$usuario_gender}'
				,usuario_perfil = '{$usuario_perfil}'
			WHERE 1=1
			AND usuario_id = {$_SESSION['GET_READY_GO_2011_SITE']['usuario_id']}
		";
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		
		if($result['success']===true){
			$this->dbConn->db_commit();
			$this->logon();
			return $this->utf8Encode2Decode('<p align="center" class="green"><strong>Perfil alterado com Sucesso!</strong></p>');
			
		}else{
			$this->dbConn->db_rollback();
			return $this->utf8Encode2Decode('<p align="center" class="red"><strong>Falha ao alterar Perfil</strong></p>');
		}
		
	}
	public function logon(){
		$login = $this->antiInjection($this->values['login']);
		$senha = $this->antiInjection(md5($this->values['password']));
		$sql = array();
		$sql[] = "
			SELECT	u.*
					,un.usuario_nivel_titulo
			FROM	tb_usuario u
			JOIN	tb_usuario_nivel un
			ON		un.usuario_nivel_id = u.usuario_nivel_id
			WHERE	1 = 1
			AND		u.usuario_id = '{$_SESSION['GET_READY_GO_2011_SITE']['usuario_id']}'
		";
		$result = $this->dbConn->db_query(implode("\n",$sql));
		if(!$result['success']||$result['total']!=1){
			return false;
		}
		$rs = $this->dbConn->db_fetch_assoc($result['result']);
		$this->setSession($rs);
		return true;
	}
	public function perfil(){
		$login = $this->antiInjection($this->values['login']);
		$senha = $this->antiInjection(md5($this->values['password']));
		$sql = array();
		$sql[] = "
			SELECT	u.*
					,un.usuario_nivel_titulo
			FROM	tb_usuario u
			JOIN	tb_usuario_nivel un
			ON		un.usuario_nivel_id = u.usuario_nivel_id
			WHERE	1 = 1
			AND		u.usuario_id = ''
		";
		$result = $this->dbConn->db_query(implode("\n",$sql));
		if(!$result['success']||$result['total']!=1){
			return false;
		}
		$rs = $this->dbConn->db_fetch_assoc($result['result']);
		$this->setSession($rs);
		return true;
	}
	
	public function getAvatares(){
		$sql = "SELECT * FROM tb_avatar";
		$result = $this->dbConn->db_query($sql);
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
	public function alteraAvatar(){
		$this->dbConn->db_start_transaction();
		$usuario_avatar = $this->antiInjection($this->values['usuario_avatar']);
		$sql = "
			UPDATE tb_usuario SET
				usuario_avatar = '{$usuario_avatar}'
			WHERE 1=1
			AND usuario_id = {$_SESSION['GET_READY_GO_2011_SITE']['usuario_id']}
		";
		$result = $this->dbConn->db_execute($sql);
		if($result['success']===true){
			$this->dbConn->db_commit();
			$this->logon();
			return $this->utf8Encode2Decode('Avatar alterado com Sucesso!');
			
		}else{
			$this->dbConn->db_rollback();
			return $this->utf8Encode2Decode('Falha ao alterar Avatar');
		}
	}
}

?>
