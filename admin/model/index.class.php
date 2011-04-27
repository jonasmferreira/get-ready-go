<?php
$path_root_indexClass = dirname(__FILE__);
$DS = DIRECTORY_SEPARATOR;
$path_root_indexClass = "{$path_root_indexClass}{$DS}..{$DS}..{$DS}";
require_once "{$path_root_indexClass}admin{$DS}class{$DS}default.class.php";
class index extends defaultClass {
	public function __construct() {
		$this->dbConn = new DataBaseClass();
	}
	
	public function logon(){
		$login = $this->antiInjection($this->values['login']);
		$senha = $this->antiInjection($this->values['senha']);
		$sql = array();
		$sql[] = "
			SELECT	u.*
					,un.usuario_nivel_titulo
			FROM	tb_usuario u
			JOIN	tb_usuario_nivel un
			ON		un.usuario_nivel_id = u.usuario_nivel_id
			WHERE	1 = 1
			AND		u.usuario_login = '{$login}'
			AND		MD5(u.usuario_senha) = '{$senha}' 
		";
		$result = $this->dbConn->db_query(implode("\n",$sql));
		if(!$result['success']||$result['total']!=1){
			return false;
		}
		$rs = $this->dbConn->db_fetch_assoc($result['result']);
		$this->setSession($rs);
		return true;
	}
	public function logoff(){
		$this->destroySession();
	}
}

?>
