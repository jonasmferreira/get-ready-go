<?php
require_once "default.class.php";
class forgotPassword extends defaultClass{
	public function __construct() {
		$this->dbConn = new DataBaseClass();
	}
	public function resetPassword(){
		$this->values['email_reset'] = $this->antiInjection($this->values['email_reset']);
		$sql = "
			SELECT	usuario_nome
					,usuario_email
					,usuario_login
					,usuario_senha
			FROM	tb_usuario
			WHERE	1 = 1
			AND		usuario_email = '{$this->values['email_reset']}'
		";
		$result = $this->dbConn->db_query($sql);
		if($result['success']===false){
			return $this->utf8Encode2Decode('<p align="center" class="red"><strong>Falha no envio, tente outra vez mais tarde.</strong></p>');
		}
		if($result['total']!==1){
			return $this->utf8Encode2Decode('<p align="center" class="red"><strong>E-mail não cadastrado</strong></p>');
		}
		$rs = $this->dbConn->db_fetch_assoc($result['result']);
		$conteudo = '
			<p>
				Foi solicitado em nosso sistema o reenvio de sua senha de login para a comunidade Get Ready.
			</p>
			<p>
				Por favor, confira seu login e sua senha ao final desta mensagem:
			</p>
			<p>
				Usuário: '.$rs['usuario_nome'].'<br />
				Login: '.$rs['usuario_login'].'<br />
				Senha: '.$rs['usuario_senha'].'<br />
				E-mail: '.$rs['usuario_email'].'
			</p>
		';
		
		$this->setAssunto("Get Ready... Go - Re-envio de Senha");
		$this->setConteudo($conteudo);
		$email[0]['nome'] = $rs['usuario_nome'];
		$email[0]['email'] = $rs['usuario_email'];
		$this->setEmails($email);
		$isEnvio = $this->enviaEmail();
		if($isEnvio!==true){
			return $this->utf8Encode2Decode('<p align="center" class="red"><strong>Falha no envio, tente outra vez mais tarde.</strong></p>');
			//return $this->utf8Encode2Decode('<p align="center" class="red"><strong>'.$isEnvio.'.</strong></p>');
		}else{
			return $this->utf8Encode2Decode('<p align="center" class="green"><strong>E-mail enviado com sucesso!</strong></p>');
		}
		
	}
}
?>
