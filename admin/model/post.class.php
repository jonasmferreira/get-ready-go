<?php
$path_root_postClass = dirname(__FILE__);
$DS = DIRECTORY_SEPARATOR;
$path_root_postClass = "{$path_root_postClass}{$DS}..{$DS}..{$DS}";
require_once "{$path_root_postClass}admin{$DS}model{$DS}default.class.php";
class post extends defaultClass{
	private $postFolder;
	public function __construct() {
		$path_root_postClass = dirname(__FILE__);
		$DS = DIRECTORY_SEPARATOR;
		$path_root_postClass = "{$path_root_postClass}{$DS}..{$DS}..{$DS}";
		$this->dbConn = new DataBaseClass();
		$this->postFolder = "{$path_root_postClass}posts{$DS}";
		if(!is_dir($this->postFolder)){
			mkdir($this->postFolder,0777);
			chmod($this->postFolder,0777);
		}
	}
	public function getLista(){
		$sql = array();
		$sql[] = "
			SELECT	p.post_id
					,p.categoria_id
					,p.usuario_id
					,p.post_titulo
					,p.post_thumb_home
					,p.post_imagem
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
			FROM	tb_post p
			
			JOIN	tb_usuario u
			ON		p.usuario_id = u.usuario_id
			
			JOIN	tb_categoria c
			ON		p.categoria_id = c.categoria_id
			
			WHERE	1 = 1
		";
		if(isset($this->values['categoria_id'])&&trim($this->values['categoria_id'])!=''){
			$sql[] = "AND	p.categoria_id = '{$this->values['categoria_id']}'";
		}
		if(isset($this->values['usuario_id'])&&trim($this->values['usuario_id'])!=''){
			$sql[] = "AND	p.usuario_id = '{$this->values['usuario_id']}'";
		}
		if(isset($this->values['post_titulo'])&&trim($this->values['post_titulo'])!=''){
			$sql[] = "AND	p.post_titulo = '{$this->values['post_titulo']}'";
		}
		if(isset($this->values['usuario_nome'])&&trim($this->values['usuario_nome'])!=''){
			$sql[] = "AND	u.usuario_nome = '{$this->values['usuario_nome']}'";
		}
		if(isset($this->values['categoria_nome'])&&trim($this->values['categoria_nome'])!=''){
			$sql[] = "AND	c.categoria_nome = '{$this->values['categoria_nome']}'";
		}
		$result = $this->dbConn->db_query(implode("\n",$sql));
		if(!$result['success']){
			return false;
		}
		$res = array();
		if($result['total'] > 0){
			while($rs = $this->dbConn->db_fetch_assoc($result['result'])){
				$rs['galerias'] = $this->galeriaPost($rs['post_id']);
				$rs['comentarios'] = $this->comentarioPost($rs['post_id']);
				array_push($res, $rs);
			}
		}
		return $res;
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
			FROM	tb_post p
			
			JOIN	tb_usuario u
			ON		p.usuario_id = u.usuario_id
			
			JOIN	tb_categoria c
			ON		p.categoria_id = c.categoria_id
			
			WHERE	1 = 1
		";
		if(isset($this->values['post_id'])&&trim($this->values['post_id'])!=''){
			$sql[] = "AND	p.post_id = '{$this->values['post_id']}'";
		}
		$result = $this->dbConn->db_query(implode("\n",$sql));
		if(!$result['success']){
			return false;
		}
		$rs = array();
		if($result['total'] > 0){
			$rs['galerias'] = $this->galeriaPost($rs['post_id']);
			$rs['comentarios'] = $this->comentarioPost($rs['post_id']);
			$rs = $this->dbConn->db_fetch_assoc($result['result']);
		}
		return $rs;
	}
	public function comentarioPost($post_id){
		$sql = array();
		$sql[] = "
			SELECT	comentario_id
					,post_id
					,comentario_autor
					,comentario_email
					,comentario_conteudo
					,comentario_dt_criacao
					,comentario_dtcomp_criacao
					,comentario_dt_alteracao
					,comentario_dtcomp_alteracao
			FROM	tb_comentario
			WHERE	1 = 1
			AND		post_id = '{$post_id}'
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
	public function galeriaPost($post_id){
		$sql = array();
		$sql[] = "
			SELECT	ig.imagem_galeria_id
					,ig.galeria_id
					,ig.imagem_galeria_titulo
					,ig.imagem_galeria_imagem
					,ig.imagem_galeria_thumb
					,ig.imagem_galeria_dt_criacao
					,ig.imagem_galeria_dtcomp_criacao
					,ig.imagem_galeria_dt_alteracao
					,ig.imagem_galeria_dtcomp_alteracao
					,g.galeria_nome
			FROM	tb_imagem_galeria ig
		
			JOIN	tb_post_galeria pg
			ON		pg.galeria_id = ig.galeria_id
			
			JOIN	tb_galeria g
			ON		g.galeria_id = ig.galeria_id
			
			WHERE	1 = 1
			AND		pg.post_id = '{$post_id}'
			
			ORDER BY ig.imagem_galeria_dtcomp_criacao DESC
		";
		$result = $this->dbConn->db_query(implode("\n",$sql));
		if(!$result['success']){
			return false;
		}
		$res = array();
		if($result['total'] > 0){
			while($rs = $this->dbConn->db_fetch_assoc($result['result'])){
				$res[$rs['galeria_id']]['galeria_id'] = $rs['galeria_id'];
				$res[$rs['galeria_id']]['galeria_nome'] = $rs['galeria_nome'];
				$res[$rs['galeria_id']]['imagens'][] = $rs;
			}
		}
		return $res;
	}
	public function edit(){
		$result = false;
		if(isset($this->values['post_id'])&&trim($this->values['post_id'])!=''){
			$this->values['post_dt_alteracao']= date('Y-m-d');
			$this->values['post_dtcomp_alteracao']= date('Y-m-d H:i:s');
			
			$result = $this->update();
		}else{
			$result = $this->insert();
		}
		return $result;
	}
	
	public function update(){
		$this->dbConn->db_start_transaction();
		$sql = array();
		
		file_put_contents("files.txt",print_r($this->files,true),FILE_APPEND);

		
		if(is_file($this->files['post_imagem']['tmp_name'])){

			$fileName = microtime(true)."_".$this->files['post_imagem']['name'];
			if(move_uploaded_file($this->files['post_imagem']['tmp_name'], $this->postFolder.$fileName)){
				$this->values['post_imagem'] = $fileName;
			}else{
				$this->values['post_imagem'] = "";
			}
		}
		
		if(is_file($this->files['post_thumb_home']['tmp_name'])){

			$fileThumbName = microtime(true)."_".$this->files['post_thumb_home']['name'];
			if(move_uploaded_file($this->files['post_thumb_home']['tmp_name'], $this->postFolder.$fileThumbName)){
				$this->values['post_thumb_home'] = $fileThumbName;
			}else{
				$this->values['post_thumb_home'] = "";
			}
		
		}

		$sql[] = "
			UPDATE	tb_post SET
					post_id = '{$this->values['post_id']}'
					,categoria_id = '{$this->values['categoria_id']}'
					,usuario_id = '{$this->values['usuario_id']}'
					,post_titulo = '{$this->values['post_titulo']}'
					,post_thumb_home = '{$this->values['post_thumb_home']}'
					,post_imagem = '{$this->values['post_imagem']}'
					,post_palavra_chave = '{$this->values['post_palavra_chave']}'
					,post_conteudo = '{$this->values['post_conteudo']}'
					
					#,post_dt_criacao = NOW()
					#,post_dtcomp_criacao = NOW()
					
					,post_dt_alteracao = NOW()
					,post_dtcomp_alteracao = NOW()
					,post_status = '{$this->values['post_status']}'
		";
		if(isset($this->values['post_imagem'])&&trim($this->values['post_imagem'])!=''){
			$sql[] = ",post_imagem = '{$this->values['post_imagem']}'";
		}
		if(isset($this->values['post_thumb_home'])&&trim($this->values['post_thumb_home'])!=''){
			$sql[] = ",post_thumb_home = '{$this->values['post_thumb_home']}'";
		}

		$sql[] = "WHERE post_id = '{$this->values['post_id']}'";
		$ret = array(
			'success'=>false
			,'post_id' =>$this->values['post_id']
		);
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			$this->dbConn->db_commit();
			$ret['success'] = $result['success'];
		}else{
			$this->dbConn->db_rollback();
		}
		return $ret;
	}
	public function insert(){
		$this->dbConn->db_start_transaction();
		$sql = array();
		
		if(is_file($this->files['post_imagem']['tmp_file'])){

			$fileName = microtime(true)."_".$this->files['post_imagem']['name'];
			if(move_uploaded_file($this->files['post_imagem']['tmp_file'], $this->postFolder.$fileName)){
				$this->values['post_imagem'] = $fileName;
			}else{
				$this->values['post_imagem'] = "";
			}
		}
		
		if(is_file($this->files['post_thumb_home']['tmp_file'])){

			$fileThumbName = microtime(true)."_".$this->files['post_thumb_home']['name'];
			if(move_uploaded_file($this->files['post_thumb_home']['tmp_file'], $this->postFolder.$fileThumbName)){
				$this->values['post_thumb_home'] = $fileThumbName;
			}else{
				$this->values['post_thumb_home'] = "";
			}
		
		}
		
		$sql[] = "
			INSERT INTO	tb_post SET
				post_id = '{$this->values['post_id']}'
				,categoria_id = '{$this->values['categoria_id']}'
				,usuario_id = '{$this->values['usuario_id']}'
				,post_titulo = '{$this->values['post_titulo']}'
				,post_thumb_home = '{$this->values['post_thumb_home']}'
				,post_imagem = '{$this->values['post_imagem']}'
				,post_palavra_chave = '{$this->values['post_palavra_chave']}'
				,post_conteudo = '{$this->values['post_conteudo']}'

				,post_dt_criacao = NOW()
				,post_dtcomp_criacao = NOW()

				#,post_dt_alteracao = NOW()
				#,post_dtcomp_alteracao = NOW()
				,post_status = '{$this->values['post_status']}'
		";
		if(isset($this->values['post_imagem'])&&trim($this->values['post_imagem'])!=''){
			$sql[] = ",post_imagem = '{$this->values['post_imagem']}'";
		}
		if(isset($this->values['post_thumb_home'])&&trim($this->values['post_thumb_home'])!=''){
			$sql[] = ",post_thumb_home = '{$this->values['post_thumb_home']}'";
		}
		
		$ret = array(
			'success'=>false
			,'post_id' =>''
		);
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			$this->dbConn->db_commit();
			$ret['success'] = $result['success'];
			$ret['post_id'] = $result['last_id'];
		}else{
			$this->dbConn->db_rollback();
		}
		return $ret;
	}
	
	public function getCategoria($returnExt=true){
		$sql = array();
		$sql[] = "
				SELECT	c.categoria_id
						,c.categoria_nome
				FROM	tb_categoria c
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

	public function getUsuario($returnExt=true){
		$sql = array();
		$sql[] = "
				SELECT	u.usuario_id
						,CONCAT(u.usuario_nome,' (',un.usuario_nivel_titulo,')') AS usuario_nome_nivel
				FROM	tb_usuario_nivel un
				JOIN	tb_usuario u
				ON		un.usuario_nivel_id = u.usuario_nivel_id
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
?>
