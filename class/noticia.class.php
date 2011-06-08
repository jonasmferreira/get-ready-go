<?php
require_once "default.class.php";
class noticia extends defaultClass{

	private $post_id;

	public function setPost_id($post_id) {
	 $this->post_id = $post_id;
	}


    public function getOne(){
		$sql = array();
		$sql[] = "
			SELECT	p.post_id
					,p.categoria_id
					,p.usuario_id
					,p.post_titulo
					,p.post_thumb_home
					,p.post_imagem
					,p.post_thumb_imagem
					,p.post_palavra_chave
					,p.post_conteudo
					,p.post_dt_criacao
					,p.post_dtcomp_criacao
					,p.post_dt_alteracao
					,p.post_dtcomp_alteracao
					,p.post_status
					,u.usuario_nome
					,u.usuario_avatar
					,c.categoria_nome
					,(SELECT COUNT(*) FROM tb_comentario WHERE post_id = p.post_id) as qtdComentario
			FROM	tb_post p

			JOIN	tb_usuario u
			ON		p.usuario_id = u.usuario_id

			JOIN	tb_categoria c
			ON		p.categoria_id = c.categoria_id

			WHERE	1 = 1
			AND	p.post_id = '{$this->post_id}'
		";
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

	public function galeriaPost(){
		$sql = array();
		$sql[] = "
			SELECT	ig.imagem_galeria_id
					,ig.galeria_id
					,ig.imagem_galeria_titulo
					,ig.imagem_galeria_imagem
					,ig.imagem_galeria_dt_criacao
					,ig.imagem_galeria_dtcomp_criacao
					,ig.imagem_galeria_dt_alteracao
					,ig.imagem_galeria_dtcomp_alteracao
					,g.galeria_titulo
			FROM	tb_imagem_galeria ig

			JOIN	tb_post_galeria pg
			ON		pg.galeria_id = ig.galeria_id

			JOIN	tb_galeria g
			ON		g.galeria_id = ig.galeria_id

			WHERE	1 = 1
			AND		pg.post_id = '{$this->post_id}'

			ORDER BY ig.imagem_galeria_dtcomp_criacao DESC
			LIMIT 4
		";
		$result = $this->dbConn->db_query(implode("\n",$sql));
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

	public function comentarioPost(){
		$sql = array();
		$sql[] = "
			SELECT	c.*,u.usuario_nome,u.usuario_avatar

			FROM	tb_comentario c

			LEFT JOIN	tb_usuario u
			ON		c.usuario_id = u.usuario_id
		
			WHERE	1 = 1
			AND		post_id = '{$this->post_id}'
			AND		comentarios_status = 1

			ORDER BY comentario_dtcomp_criacao DESC
		";
		$this->setTotal($this->getMaxCount(implode("\n",$sql)));
		if(isset($this->limit_start)&&trim($this->limit_start)!=''){
			$sql[] = "LIMIT {$this->limit_start}, {$this->limit_max}";
		}
		$result = $this->dbConn->db_query(implode("\n",$sql));
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

	public function getItensRelacionadas($like){

		$like = explode(",",$like);
		foreach($like as $v){
			$andClau[] = " p.post_palavra_chave LIKE '%{$v}%' ";
		}
		$andClau = implode(" OR ",$andClau);

		$sql = array();
		$sql[] = "
			SELECT	p.post_id
					,p.categoria_id
					,p.usuario_id
					,p.post_titulo
					,p.post_thumb_home
					,p.post_imagem
					,p.post_thumb_imagem
					,p.post_palavra_chave
					,p.post_conteudo
					,p.post_dt_criacao
					,p.post_dtcomp_criacao
					,p.post_dt_alteracao
					,p.post_dtcomp_alteracao
					,p.post_status
					,u.usuario_nome
					,u.usuario_avatar
					,c.categoria_nome
					,(SELECT COUNT(*) FROM tb_comentario WHERE post_id = p.post_id) as qtdComentario
			FROM	tb_post p

			JOIN	tb_usuario u
			ON		p.usuario_id = u.usuario_id

			JOIN	tb_categoria c
			ON		p.categoria_id = c.categoria_id

			WHERE	1 = 1
			AND	({$andClau})
			AND p.post_id != '{$this->post_id}'
			ORDER BY post_dt_criacao DESC
			LIMIT 10
		";

		

		$result = $this->dbConn->db_query(implode("\n",$sql));
		if(!$result['success']){
			return false;
		}
		$res = array();
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
	public function saveComentario(){
		$this->values = $this->antiInjection($this->values);
		$email = ($this->values['usuario_id'])?"(SELECT usuario_email FROM tb_usuario where usuario_id = '{$this->values['usuario_id']}')":"'sem-email@sem-email.com.br'";
		$sql = "
			INSERT INTO tb_comentario SET
			post_id = {$this->values['post_id']},
			comentario_autor = '{$this->values['nome']}',
			comentario_email = {$email},
			comentario_conteudo = '{$this->values['comentario']}',
			usuario_id = '{$this->values['usuario_id']}',
			comentario_dt_criacao = DATE_FORMAT(NOW(),'%Y-%m-%d'),
			comentario_dtcomp_criacao = NOW()
		";
		$result = $this->dbConn->db_execute($sql);

		if($result['success']===true){
			return true;
		}
		return false;
	}
}
?>
