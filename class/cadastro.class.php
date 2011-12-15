<?php
require_once "default.class.php";
class cadastro extends defaultClass{
	public function __construct() {
		$this->dbConn = new DataBaseClass();
	}
	public function verifyLogin(){
		$sql = array();
		$sql[] = "
			SELECT	usuario_id
			FROM	tb_usuario
			WHERE	usuario_login = '{$this->values['usuario_login']}'
		";
		$result = $this->dbConn->db_query(implode("\n",$sql));
		if($result['success']===false){
			return $this->utf8Encode2Decode('<p align="center" class="red"><strong>Falha ao Verificar o Login</strong></p>');
		}
		if($result['total']>0){
			return $this->utf8Encode2Decode('<p align="center" class="red"><strong>Login já Cadastrado</strong></p>');
		}
		return 'CMD_SUCCESS';
	}
	public function verifyEmail(){
		$sql = array();
		$sql[] = "
			SELECT	usuario_id
			FROM	tb_usuario
			WHERE	usuario_email = '{$this->values['usuario_email']}'
		";
		$result = $this->dbConn->db_query(implode("\n",$sql));
		if($result['success']===false){
			return $this->utf8Encode2Decode('<p align="center" class="red"><strong>Falha ao Verificar o E-mail</strong></p>');
		}
		if($result['total']>0){
			return $this->utf8Encode2Decode('<p align="center" class="red"><strong>E-mail já Cadastrado</strong></p>');
		}
		return 'CMD_SUCCESS';
	}
	public function cadastrarUsuario(){
		$this->dbConn->db_start_transaction();
		$usuario_nome = $this->antiInjection($this->values['usuario_nome']);
		$usuario_login = $this->antiInjection($this->values['usuario_login']);
		$usuario_senha = $this->antiInjection($this->values['usuario_senha']);
		$usuario_email = $this->antiInjection($this->values['usuario_email']);
		
		$sql = array();
		$sql[] = "
			INSERT INTO	tb_usuario SET
				usuario_nivel_id = '3'
				,usuario_nome = '{$usuario_nome}'
				,usuario_login = '{$usuario_login}'
				,usuario_senha = '{$usuario_senha}'
				,usuario_email = '{$usuario_email}'
				,usuario_status = '1'
		";
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		
		if($result['success']===true){
			$conteudo = '
				<p>
					Bem Vindo a Comunidade Get Ready!
				</p>
				<p>
					Por favor, confira seu login e sua senha ao final desta mensagem:
				</p>
				<p>
					Usuário: '.$this->values['usuario_nome'].'<br />
					Login: '.$this->values['usuario_login'].'<br />
					Senha: '.$this->values['usuario_senha'].'<br />
					E-mail: '.$this->values['usuario_email'].'
				</p>
			';

			$this->setAssunto("Get Ready... Go - Bem Vindo a Cominidade Get Ready");
			$this->setConteudo($conteudo);
			$email[0]['nome'] = $this->values['usuario_nome'];
			$email[0]['email'] = $this->values['usuario_email'];
			$this->setEmails($email);
			$isEnvio = $this->enviaEmail();
			if($isEnvio!==true){
				$this->dbConn->db_rollback();
				return $this->utf8Encode2Decode('<p align="center" class="red"><strong>Falha no Cadastro de Usuário</strong></p><p>'.$isEnvio.'</p>');
				//return $this->utf8Encode2Decode('<p align="center" class="red"><strong>'.$isEnvio.'.</strong></p>');
			}else{
				$this->dbConn->db_commit();
				return $this->utf8Encode2Decode('<p align="center" class="green"><strong>Usuário Cadastrado com Sucesso!</strong></p>');
			}
		}else{
			$this->dbConn->db_rollback();
			return $this->utf8Encode2Decode('<p align="center" class="red"><strong>Falha no Cadastro de Usuário</strong></p>');
		}
		
	}
}
?>
