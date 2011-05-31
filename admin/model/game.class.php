<?php
$path_root_gameClass = dirname(__FILE__);
$DS = DIRECTORY_SEPARATOR;
$path_root_gameClass = "{$path_root_gameClass}{$DS}..{$DS}..{$DS}";
require_once "{$path_root_gameClass}admin{$DS}model{$DS}default.class.php";
class game extends defaultClass{
	private $gameFolder = "";
	public function __construct() {
		$path_root_gameClass = dirname(__FILE__);
		$DS = DIRECTORY_SEPARATOR;
		$path_root_gameClass = "{$path_root_gameClass}{$DS}..{$DS}..{$DS}";
		$this->gameFolder = "{$path_root_gameClass}games{$DS}";
		if(!is_dir($this->gameFolder)){
			mkdir($this->gameFolder,0777);
			chmod($this->gameFolder,0777);
		}
		$this->dbConn = new DataBaseClass();
	}
	public function getLista($returnExt=true){
		$sql = array();
		$sql[] = "
			SELECT a.* 
			FROM	(
		";
		$sql[] = "
			SELECT	g.game_id
				,g.game_titulo
				,g.game_descricao
				,g.game_thumb
				,g.game_imagem_destaque
				,g.game_tipo_id
				,g.game_categoria_id
				,g.game_midia_id
				,g.game_link
				,g.game_qtd_download
				,g.game_qtd_jogado
				,g.game_qtd_votacao
				,g.game_total_votacao
				,g.game_criador_is_user
				,g.game_criador_nome
				,gc.game_categoria_nome
				,gt.game_tipo_nome
				,gm.game_midia_nome
			FROM	tb_game g
			
			JOIN	tb_game_tipo gt
			ON		gt.game_tipo_id = g.game_tipo_id
			
			JOIN	tb_game_categoria gc
			ON		gc.game_categoria_id = g.game_categoria_id
			
			JOIN	tb_game_midia gm
			ON		gm.game_midia_id = g.game_midia_id
			
			WHERE	1 = 1
		";
		if(isset($this->values['game_tipo_titulo'])&&trim($this->values['game_tipo_titulo'])!=''){
			$sql[] = "AND	g.game_tipo_titulo LIKE '%{$this->values['game_tipo_titulo']}%'";
		}
		if(isset($this->values['game_tipo_id'])&&trim($this->values['game_tipo_id'])!=''){
			$sql[] = "AND	g.game_tipo_id = '{$this->values['game_tipo_id']}'";
		}
		if(isset($this->values['game_categoria_id'])&&trim($this->values['game_categoria_id'])!=''){
			$sql[] = "AND	g.game_categoria_id = '{$this->values['game_categoria_id']}'";
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
		return $this->utf8_array_encode($res);
	}
	
	public function getOne(){
		$sql = array();
		$sql[] = "
			SELECT	g.game_id
				,g.game_titulo
				,g.game_descricao
				,g.game_thumb
				,g.game_imagem_destaque
				,g.game_tipo_id
				,g.game_categoria_id
				,g.game_midia_id
				,g.game_link
				,g.game_qtd_download
				,g.game_qtd_jogado
				,g.game_criador_is_user
				,g.game_criador_nome
				,gc.game_categoria_nome
				,gt.game_tipo_nome
			FROM	tb_game g
			
			JOIN	tb_game_tipo gt
			ON		gt.game_tipo_id = g.game_tipo_id
			
			JOIN	tb_game_categoria gc
			ON		gc.game_categoria_id = g.game_categoria_id
			
			JOIN	tb_game_midia gm
			ON		gm.game_midia_id = g.game_midia_id
			
			WHERE	1 = 1
		";
		if(isset($this->values['game_id'])&&trim($this->values['game_id'])!=''){
			$sql[] = "AND	g.game_id = '{$this->values['game_id']}'";
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
		if(isset($this->values['game_id'])&&trim($this->values['game_id'])!=''){
			$result = $this->update();
		}else{
			$result = $this->insert();
		}
		return $result;
	}
	
	public function update(){
		$fileName = str_replace(".","",microtime(true))."_".$this->files['game_thumb']['name'];
		if(move_uploaded_file($this->files['game_thumb']['tmp_name'], $this->gameFolder.$fileName)){
			$this->values['game_thumb'] = $fileName;
		}else{
			$this->values['game_thumb'] = "";
		}
		
		$fileName2 = str_replace(".","",microtime(true))."_".$this->files['game_imagem_destaque']['name'];
		if(move_uploaded_file($this->files['game_imagem_destaque']['tmp_name'], $this->gameFolder.$fileName2)){
			$this->values['game_imagem_destaque'] = $fileName2;
		}else{
			$this->values['game_imagem_destaque'] = "";
		}
		
		$this->dbConn->db_start_transaction();
		$sql = array();
		$sql[] = "
			UPDATE	tb_game SET
					game_titulo = '{$this->values['game_titulo']}'
					,game_descricao = '{$this->values['game_descricao']}'
					,game_tipo_id = '{$this->values['game_tipo_id']}'
					,game_categoria_id = '{$this->values['game_categoria_id']}'
					,game_midia_id = '{$this->values['game_midia_id']}'
					,game_link = '{$this->values['game_link']}'
					,game_qtd_download = '{$this->values['game_qtd_download']}'
					,game_qtd_jogado = '{$this->values['game_qtd_jogado']}'
					,game_criador_is_user = '{$this->values['game_criador_is_user']}'
					,game_criador_nome = '{$this->values['game_criador_nome']}'
		";
		if(isset($this->values['game_thumb'])&&trim($this->values['game_thumb'])!=''){
			$sql[] = ",game_thumb = '{$this->values['game_thumb']}'";
		}
		if(isset($this->values['game_imagem_destaque'])&&trim($this->values['game_imagem_destaque'])!=''){
			$sql[] = ",game_imagem_destaque = '{$this->values['game_imagem_destaque']}'";
		}
		$sql[] = "WHERE game_id = '{$this->values['game_id']}'";
		$ret = array(
			'success'=>false
			,'game_id' =>$this->values['game_id']
		);
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			$this->dbConn->db_commit();
			$ret['success'] = $result['success'];
			$ret['game_id'] = $this->values['game_id'];
		}else{
			$this->dbConn->db_rollback();
		}
		return $ret;
	}
	public function insert(){
		$fileName = str_replace(".","",microtime(true))."_".$this->files['game_thumb']['name'];
		if(move_uploaded_file($this->files['game_thumb']['tmp_name'], $this->gameFolder.$fileName)){
			$this->values['game_thumb'] = $fileName;
		}else{
			$this->values['game_thumb'] = "";
		}
		
		$fileName2 = str_replace(".","",microtime(true))."_".$this->files['game_imagem_destaque']['name'];
		if(move_uploaded_file($this->files['game_imagem_destaque']['tmp_name'], $this->gameFolder.$fileName2)){
			$this->values['game_imagem_destaque'] = $fileName2;
		}else{
			$this->values['game_imagem_destaque'] = "";
		}
		
		$this->dbConn->db_start_transaction();
		$sql = array();
		$sql[] = "
			INSERT INTO	tb_game SET
				game_titulo = '{$this->values['game_titulo']}'
				,game_descricao = '{$this->values['game_descricao']}'
				,game_tipo_id = '{$this->values['game_tipo_id']}'
				,game_categoria_id = '{$this->values['game_categoria_id']}'
				,game_midia_id = '{$this->values['game_midia_id']}'
				,game_link = '{$this->values['game_link']}'
				,game_qtd_download = '{$this->values['game_qtd_download']}'
				,game_qtd_jogado = '{$this->values['game_qtd_jogado']}'
				,game_criador_is_user = '{$this->values['game_criador_is_user']}'
				,game_criador_nome = '{$this->values['game_criador_nome']}'
		";
		if(isset($this->values['game_thumb'])&&trim($this->values['game_thumb'])!=''){
			$sql[] = ",game_thumb = '{$this->values['game_thumb']}'";
		}
		if(isset($this->values['game_imagem_destaque'])&&trim($this->values['game_imagem_destaque'])!=''){
			$sql[] = ",game_imagem_destaque = '{$this->values['game_imagem_destaque']}'";
		}
		$ret = array(
			'success'=>false
			,'game_id' =>''
		);
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			$this->dbConn->db_commit();
			$ret['success'] = $result['success'];
			$ret['game_id'] = $result['last_id'];
		}else{
			$this->dbConn->db_rollback();
		}
		return $ret;
	}
	public function getTipoCombo($returnExt=true){
		$sql = array();
		$sql[] = "
			SELECT	*
			FROM	tb_game_tipo
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
		return $this->utf8_array_encode($res);
	}
	public function getCategoriaCombo($returnExt=true){
		$sql = array();
		$sql[] = "
			SELECT	*
			FROM	tb_game_categoria
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
		return $this->utf8_array_encode($res);
	}
	public function getMidiaCombo($returnExt=true){
		$sql = array();
		$sql[] = "
			SELECT	*
			FROM	tb_game_midia
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
		return $this->utf8_array_encode($res);
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
		if(isset($this->values['usuario_id'])&&trim($this->values['usuario_id'])){
			$sql[] = "AND u.usuario_id = '{$this->values['usuario_id']}'";
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
		return $this->utf8_array_encode($res);
	}
}
?>
