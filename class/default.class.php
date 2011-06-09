<?php

$path_root_dbClass = dirname(__FILE__);
$DS = DIRECTORY_SEPARATOR;
$path_root_dbClass = "{$path_root_dbClass}{$DS}..{$DS}";
require_once "{$path_root_dbClass}lib{$DS}DataBaseClass.php";
require_once "{$path_root_dbClass}lib{$DS}mail{$DS}class.phpmailer.php";
session_name('GET_READY_GO_2011_SITE');
if(session_id()==''){
	session_start();
}
class defaultClass {
	protected $dbConn;
	protected $values;
	protected $files;
	protected $sort_field;
	protected $sort_direction;
	protected $limit_start;
	protected $limit_max;
	
	protected $email_host = "mail.cdanime.com";
	protected $email_port = "25";
	protected $email_username = "administrador+cdanime.com";
	protected $email_pass = "destino";
	protected $email_resposta = array(
		'nome'=>"Administrador"
		,'email'=>"administrador@cdanime.com"
	);
	protected $email_remetente = array(
		'nome'=>"Administrador"
		,'email'=>"administrador@cdanime.com"
	);
	protected $assunto;
	protected $conteudo;
	protected $emails;
	protected $anexos;



	private $total;
	public function getTotal() {
	 return $this->total;
	}
	public function setTotal($total) {
	 $this->total = $total;
	}

	public function __construct() {
		$this->dbConn = new DataBaseClass();
	}
	
	public function setAssunto($assunto) {
		$this->assunto = $assunto;
	}

	public function setConteudo($conteudo) {
		$this->conteudo = $conteudo;
	}

	public function setEmails($emails) {
		$this->emails = $emails;
	}

	public function setAnexos($anexos) {
		$this->anexos = $anexos;
	}
	
	public function setValues($values) {
		$this->values = $values;
	}

	public function setFiles($files) {
		$this->files = $files;
	}
	public function setSort($jSort){
		$jSort = json_decode($jSort);
		$this->setSortField($jSort[0]->property);
		$this->setSortDirection($jSort[0]->direction);
	}
	public function setSortField($sort_field){
		$this->sort_field = $sort_field;
	}//MÉTODO setSortField
	public function setSortDirection($sort_direction){
		$this->sort_direction = $sort_direction;
	}//MÉTODO setSortField
	public function setLimitStart($limit_start){
		$this->limit_start = $limit_start;
	}//MÉTODO setLimitStart
	public function setLimitMax($limit_max){
		$this->limit_max = $limit_max;
	}//MÉTODO setLimitMax

	public function destroySession() {
		unset($_SESSION['GET_READY_GO_2011_SITE']);
		session_destroy();
	}
	public function setSession($session,$value=null) {
		if(!is_array($session)){
			$_SESSION['GET_READY_GO_2011_SITE'][$session] = $value;
		}else if(is_array($session) && count($session)>0){
			foreach($session AS $k=>$v){
				$_SESSION['GET_READY_GO_2011_SITE'][$k] = $v;
			}
		}
	}
	public function getSessions(){
		return $_SESSION['GET_READY_GO_2011_SITE'];
	}
	public function unsetSession($session) {
		if(!is_array($session)){
			unset($_SESSION['GET_READY_GO_2011_SITE'][$session]);
		}else{
			foreach($session AS $k=>$v){
				unset($_SESSION['GET_READY_GO_2011_SITE'][$v]);
			}
		}
	}
	public function utf8Encode2Decode($string) {
		if (strtoupper(mb_detect_encoding($string . "x", 'UTF-8, ISO-8859-1')) == 'UTF-8') {
			return $string;
		} else {
			return utf8_encode($string);
		}
	}

	public function utf8_array_encode($input) {
		$return = array();
		foreach ($input as $key => $val) {
			if (is_array($val)) {
				$return[$key] = $this->utf8_array_encode($val);
			} else {
				$return[$key] = $this->utf8Encode2Decode($val);
			}
		}
		return $return;
	}

	public function antiInjection($input) {
		if(is_array($input)){
			foreach ($input as $key => $val) {
				$sql = preg_replace("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/", "", $val);
				$sql = trim($sql);
				$sql = (get_magic_quotes_gpc()) ? $sql : addslashes($sql);
				$input[$key] = $sql;
			}
			return $input;
		}
		$sql = preg_replace("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/", "", $input);
		$sql = trim($sql);
		$sql = (get_magic_quotes_gpc()) ? $sql : addslashes($sql);
		return $sql;
	}
	public function alert($msg,$url=''){
		$aScript = array();
		$aScript[] = '<script type="text/javascript">';
		$aScript[] = "alert('{$msg}');";
		$aScript[] = (!is_null($url)&&trim($url)!='')?"window.location.href = '{$url}';":'';
		$aScript[] = '</script>';
		echo implode("\r\n",$aScript);
	}
	public function consoleLog($mixed=''){
		$msg = print_r($mixed,true);
		$aScript = array();
		$aScript[] = '<script type="text/javascript">';
		$aScript[] = "console.log('{$msg}');";
		$aScript[] = '</script>';
		echo implode("\r\n",$aScript);
	}
	public function verifyLogin(){
		$session = $this->getSessions();
		if(!isset($session['usuario_id'])&&trim($session['usuario_id'])==''){
			header('Location: index.php');
		}
	}
	public function convertExtReturn($data,$success,$totalCount){
		$arr = array(
			'data'=>$this->utf8_array_encode($data)
			,'totalCount'=>$totalCount
			,'success'=>$success
		);
		return $arr;
	}
	public function getMaxCount($query){
		$sql = array();
		$sql[] = "
			SELECT COUNT(*) as qtde
			FROM	(
				{$query}
			) AS qt
		";
		$result = $this->dbConn->db_query(implode("\n",$sql));
		if(!$result['success']){
			return false;
		}
		$rs = array();
		if($result['total'] > 0){
			$rs = $this->dbConn->db_fetch_assoc($result['result']);
		}
		return $rs['qtde'];
	}
	public function dateDB2BR($date) {
		return preg_replace(
			"/([0-9]{4})-([0-9]{2})-([0-9]{2})/i",
			"$3/$2/$1",
			$date
		);
	}

	public function dateBR2DB($date) {
		return preg_replace(
			"/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/i",
			"$3-$2-$1",
			$date
		);
	}

	public function dateDB2BRTime($date) {
		return preg_replace(
			"/([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/i",
			"$3/$2/$1 $4:$5:$6",
			$date
		);
	}

	public function dateBR2DBTime($date) {
		return preg_replace(
			"/([0-9]{2})\/([0-9]{2})\/([0-9]{4}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/i",
			"$3-$2-$1 $4:$5:$6",
			$date
		);
	}
	public function cutHTML($text, $length=100, $ending=' ...', $cutWords=false, $considerHtml=true) {
		if ($considerHtml) {
			// se o texto for mais curto que $length, retornar o texto na totalidade
			if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
				return $text;
			}

			// separa todas as tags html em linhas pesquisáveis
			preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);

			$total_length = strlen($ending);
			$open_tags = array();
			$truncate = '';

			foreach ($lines as $line_matchings) {
				// se existir uma tag html nesta linha, considerá-la e adicioná-la ao output (sem contar com ela)
				if (!empty($line_matchings[1])) {
					// se for um "elemento vazio" com ou sem barra de auto-fecho xhtml (ex. <br />)
					if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
						// não fazer nada
						// se a tag for de fecho (ex. </b>)
					} else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
						// apagar a tag do array $open_tags
						$pos = array_search($tag_matchings[1], $open_tags);
						if ($pos !== false) {
							unset($open_tags[$pos]);
						}
						// se a tag é uma tag inicial (ex. <b>)
					} else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
						// adicionar tag ao início do array $open_tags
						array_unshift($open_tags, strtolower($tag_matchings[1]));
					}
					// adicionar tag html ao texto $truncate
					$truncate .= $line_matchings[1];
				}

				// calcular a largura da parte do texto da linha; considerar entidades como um caracter
				$content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
				if ($total_length + $content_length > $length) {
					// o número dos caracteres que faltam
					$left = $length - $total_length;
					$entities_length = 0;
					// pesquisar por entidades html
					if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
						// calcular a largura real de todas as entidades no alcance "legal"
						foreach ($entities[0] as $entity) {
							if ($entity[1] + 1 - $entities_length <= $left) {
								$left--;
								$entities_length += strlen($entity[0]);
							} else {
								// não existem mais caracteres
								break;
							}
						}
					}
					$truncate .= substr($line_matchings[2], 0, $left + $entities_length);
					// chegamos à largura máxima, por isso saímos do loop
					break;
				} else {
					$truncate .= $line_matchings[2];
					$total_length += $content_length;
				}

				// se chegarmos à largura máxima, saímos do loop
				if ($total_length >= $length) {
					break;
				}
			}
		} else {
			if (strlen($text) <= $length) {
				return $text;
			} else {
				$truncate = substr($text, 0, $length - strlen($ending));
			}
		}

		// se as palavras não puderem ser cortadas a meio...
		if (!$cutWords) {
			// ...procurar a última ocorrência de um espaço...
			$spacepos = strrpos($truncate, ' ');
			if (isset($spacepos)) {
				// ...e cortar o texto nesta posição
				$truncate = substr($truncate, 0, $spacepos);
			}
		}

		// adicionar $ending no final do texto
		$truncate .= $ending;

		if ($considerHtml) {
			// fechar todas as tags html não fechadas
			foreach ($open_tags as $tag) {
				$truncate .= '</' . $tag . '>';
			}
		}
		return $truncate;
	}
	public function retiraAcentos($texto){
		$texto = $this->utf8Encode2Decode($texto);
		$array1 = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
						 , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç","?","!" );
		$array2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
						 , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C","","" );
		return str_replace( $array1, $array2, $texto );
	}

	public function tagToEmoticon($string){
		$aTrocaTagPorEmoticon = array(
			":)"=>"<img src=\"@LINKABSOLUTO@imgs/smiles/smiley.gif\" />",
			":D"=>"<img src=\"@LINKABSOLUTO@imgs/smiles/cheesy.gif\" />",
			";)"=>"<img src=\"@LINKABSOLUTO@imgs/smiles/wink.gif\" />",
			":o"=>"<img src=\"@LINKABSOLUTO@imgs/smiles/(eek).gif\" />",
			":p"=>"<img src=\"@LINKABSOLUTO@imgs/smiles/tongue.gif\" />",
			"B)"=>"<img src=\"@LINKABSOLUTO@imgs/smiles/cool.gif\" />",
			":@"=>"<img src=\"@LINKABSOLUTO@imgs/smiles/mad.gif\" />",
			":/"=>"<img src=\"@LINKABSOLUTO@imgs/smiles/undecided.gif\" />",
			":blush:"=>"<img src=\"@LINKABSOLUTO@imgs/smiles/iredface.gif\" />",
			":("=>"<img src=\"@LINKABSOLUTO@imgs/smiles/triste.gif\" />",
			":ugh:"=>"<img src=\"@LINKABSOLUTO@imgs/smiles/ugh.gif\" />",
			":kiss:"=>"<img src=\"@LINKABSOLUTO@imgs/smiles/kiss.gif\" />",
			":roll:"=>"<img src=\"@LINKABSOLUTO@imgs/smiles/roll.gif\" />",
			":arrow:"=>"<img src=\"@LINKABSOLUTO@imgs/smiles/arrowan0.gif\" />",
			":bow:"=>"<img src=\"@LINKABSOLUTO@imgs/smiles/bowdown.gif\" />",
			":hate:"=>"<img src=\"@LINKABSOLUTO@imgs/smiles/fdp.gif\" />",
			":wtf:"=>"<img src=\"@LINKABSOLUTO@imgs/smiles/hum.gif\" />",
			":cool:"=>"<img src=\"@LINKABSOLUTO@imgs/smiles/joia.gif\" />",
			":not:"=>"<img src=\"@LINKABSOLUTO@imgs/smiles/nao.gif\" />",
			":run:"=>"<img src=\"@LINKABSOLUTO@imgs/smiles/runaway.gif\" />",
			":z:"=>"<img src=\"@LINKABSOLUTO@imgs/smiles/zzz.gif\" />"
		);
		return str_replace(array_keys($aTrocaTagPorEmoticon),array_values($aTrocaTagPorEmoticon),$string);
	}

	public function enviaEmail(){
		$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
		$mail->CharSet = 'utf-8';
		$mail->IsSMTP(); // telling the class to use SMTP
		/*echo "<pre>".print_r($this->emails,true)."</pre>";
		echo "<pre>".print_r($this->email_resposta,true)."</pre>";
		echo "<pre>".print_r($this->email_remetente,true)."</pre>";*/
		try {
			
			$mail->SMTPDebug  = 0;
			$mail->SMTPAuth   = true;
			$mail->Host       = $this->email_host;
			$mail->Port       = $this->email_port;
			$mail->Username   = $this->email_username;
			$mail->Password   = $this->email_pass;
			if(is_array($this->email_resposta)&&count($this->email_resposta)>0){
				$mail->AddReplyTo($this->email_resposta['email'], $this->email_resposta['nome']);
			}
			if(is_array($this->email_remetente)&&count($this->email_remetente)>0){
				$mail->SetFrom($this->email_remetente['email'], $this->email_remetente['nome']);
			}
			
			if(is_array($this->emails)&&count($this->emails)>0){
				
				foreach($this->emails AS $v){
					$mail->AddAddress($v['email'], $v['nome']);
				}
			}
			$mail->Subject = $this->assunto;
			$mail->AltBody = 'Para ver a mensagem corretamente, utilize um leitor de e-mail compativel com html!';
			$mail->MsgHTML($this->conteudo);
			$mail->Send();
		} catch (phpmailerException $e) {
			return $e->errorMessage();
		} catch (Exception $e) {
			return $e->getMessage();
		}
		return true;
	}

	public function dtExtensoComentario($strDate){
		$arrMonthsOfYear = array(1 => 'Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
		$intDayOfWeek = date('w',strtotime($strDate));
		$intDayOfMonth = date('d',strtotime($strDate));
		$intMonthOfYear = date('n',strtotime($strDate));
		$intYear = date('Y',strtotime($strDate));
		$intHora = date('H:i',strtotime($strDate));
		return "Em {$intDayOfWeek} de {$arrMonthsOfYear[$intMonthOfYear]} de {$intYear}, às {$intHora}";
	}
	public function dtExtensoNoticia($strDate){
		$arrDaysOfWeek = array('Dom','Seg','Ter','Qua','Qui','Sex','Sáb');
		$arrMonthsOfYear = array(1 => 'Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
		$intDayOfWeek = date('w',strtotime($strDate));
		$intDayOfMonth = date('d',strtotime($strDate));
		$intMonthOfYear = date('n',strtotime($strDate));
		$intYear = date('Y',strtotime($strDate));
		$intHora = date('H:i',strtotime($strDate));
		return "{$arrDaysOfWeek[$intDayOfWeek]},  {$intDayOfMonth}  de  {$arrMonthsOfYear[$intMonthOfYear]}  de  {$intYear} {$intHora}";
	}
	public function savePageView(){
		$sql = "
			INSERT INTO tb_post_pageview SET
			post_id = '{$this->values['post_id']}',
			categoria_id = '{$this->values['categoria_id']}',
			post_dt_pageview = NOW(),
			post_ip_pageview = '{$_SERVER['REMOTE_ADDR']}'
		";
		$result = $this->dbConn->db_execute($sql);
	}
	public function getTopPost($categoria){
		$sql = array();
		$sql[] = "
			SELECT	p.post_id
					,p.categoria_id
					,c.categoria_nome
					,p.usuario_id
					,p.post_titulo
					,p.post_thumb_home
					,p.post_imagem
					,p.post_thumb_imagem
					,p.post_palavra_chave
					,p.post_conteudo
					,DATE_FORMAT(p.post_dtcomp_criacao,'%d.%m.%Y %h:%i') AS post_dt_criacao
					,p.post_dtcomp_criacao
					,p.post_dt_alteracao
					,p.post_dtcomp_alteracao
					,p.post_status
					,(SELECT COUNT(*) FROM tb_comentario WHERE post_id = p.post_id AND comentario_status = 1) as qtdComentario
			FROM	tb_post p
		
			JOIN	tb_post_pageview pp
			ON		p.post_id = pp.post_id

			JOIN	tb_categoria c
			ON		p.categoria_id = c.categoria_id

			WHERE	1 = 1
			AND		p.post_status = 1
			AND		c.categoria_id = {$categoria}
			ORDER BY post_dtcomp_criacao DESC
		";
		$res = array();
		//$this->setTotal($this->getMaxCount(implode("\n",$sql)));
		//echo $this->getTotal();
		if(isset($this->limit_start)&&trim($this->limit_start)!=''){
			$sql[] = "LIMIT {$this->limit_start}, {$this->limit_max}";
		}
		$result = $this->dbConn->db_query(implode("\n",$sql));
		if(!$result['success']){
			return false;
		}
		
		if($result['total'] > 0){
			while($rs = $this->dbConn->db_fetch_assoc($result['result'])){
				$cat_nome = str_replace(' ', '_',$this->retiraAcentos($rs['categoria_nome']));
				$post_nome = str_replace(' ', '+', $this->retiraAcentos($rs['post_titulo']));

				$rs['linkDetalhe'] = "detalhe/{$cat_nome}/{$rs['categoria_id']}/{$post_nome}/{$rs['post_id']}";

				array_push($res, $rs);
			}
		}
		return $this->utf8_array_encode($res);
	}
}
?>
