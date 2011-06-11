<?php
$path_root_comentarioClass = dirname(__FILE__);
$DS = DIRECTORY_SEPARATOR;
$path_root_comentarioClass = "{$path_root_comentarioClass}{$DS}..{$DS}..{$DS}";
require_once "{$path_root_comentarioClass}admin{$DS}model{$DS}default.class.php";
class comentario extends defaultClass{

	private function cutHTML($text, $length=100, $ending=' ...', $cutWords=false, $considerHtml=true) {
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

    public function getLista(){
		$sql = array();
		$sql[] = "
			SELECT	c.*,u.*,p.post_titulo, ct.*
			FROM	tb_comentario c

			LEFT JOIN	tb_usuario u
			ON		c.usuario_id = u.usuario_id

			JOIN	tb_post p
			ON		c.post_id = p.post_id

			JOIN	tb_categoria ct
			ON		p.categoria_id = ct.categoria_id

			WHERE	1 = 1
		";
		if(isset($this->values['usuario_id'])&&trim($this->values['usuario_id'])!=''){
			$sql[] = "AND	p.usuario_id = '{$this->values['usuario_id']}'";
		}
		if(isset($this->values['post_titulo'])&&trim($this->values['post_titulo'])!=''){
			$sql[] = "AND	p.post_titulo = '{$this->values['post_titulo']}'";
		}
		if(isset($this->values['usuario_nome'])&&trim($this->values['usuario_nome'])!=''){
			$sql[] = "AND	u.usuario_nome = '{$this->values['usuario_nome']}'";
		}
		if(isset($this->values['comentario_status'])&&trim($this->values['comentario_status'])!=''){
			$sql[] = "AND	c.comentario_status = '{$this->values['comentario_status']}'";
		}
		if(isset($this->values['categoria_id'])&&trim($this->values['categoria_id'])!=''){
			$sql[] = "AND	p.categoria_id = '{$this->values['categoria_id']}'";
		}

		$sql[] = " ORDER BY comentario_dt_criacao DESC ";

		$result = $this->dbConn->db_query(implode("\n",$sql));
		if(!$result['success']){
			return false;
		}
		$res = array();
		if($result['total'] > 0){
			while($rs = $this->dbConn->db_fetch_assoc($result['result'])){
				$rs['comentario_conteudo'] = $this->cutHTML($rs['comentario_conteudo'],120);
				array_push($res, $rs);
			}
		}
		return $this->utf8_array_encode($res);
	}
    public function getOne(){
		$sql = array();
		$sql[] = "
			SELECT	c.*,u.*,p.post_titulo
			FROM	tb_comentario c

			LEFT JOIN	tb_usuario u
			ON		c.usuario_id = u.usuario_id

			JOIN	tb_post p
			ON		c.post_id = p.post_id

			WHERE	1 = 1
			AND		comentario_id = '{$this->values['comentario_id']}'
		";

		$sql[] = " ORDER BY comentario_dt_criacao DESC ";

		$result = $this->dbConn->db_query(implode("\n",$sql));
		if(!$result['success']){
			return false;
		}
		$res = array();
		if($result['total'] > 0){
			$rs = $this->dbConn->db_fetch_assoc($result['result']);
		}
		return $this->utf8_array_encode($rs);
	}
	public function saveStatus(){
		$this->dbConn->db_start_transaction();
		$sql = array();
		$sql[] = "
			UPDATE	tb_comentario SET
					comentario_status = '{$this->values['comentario_status']}'
					,comentario_dt_alteracao = NOW()
					,comentario_dtcomp_alteracao = NOW()
		";
		$sql[] = "WHERE comentario_id = '{$this->values['comentario_id']}'";
		$ret = array(
			'success'=>false
			,'comentario_id' =>$this->values['comentario_id']
		);
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			$this->dbConn->db_commit();
			$ret['success'] = $result['success'];
			$ret['comentario_id'] = $this->values['comentario_id'];
		}else{
			$this->dbConn->db_rollback();
		}
		return $ret;
	}
}
?>
