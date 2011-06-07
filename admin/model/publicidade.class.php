<?php
$path_root_publicidadeClass = dirname(__FILE__);
$DS = DIRECTORY_SEPARATOR;
$path_root_publicidadeClass = "{$path_root_publicidadeClass}{$DS}..{$DS}..{$DS}";
require_once "{$path_root_publicidadeClass}admin{$DS}model{$DS}default.class.php";
class publicidade extends defaultClass{
	private $publicidadeFolder;
	public function __construct() {
		$path_root_publicidadeClass = dirname(__FILE__);
		$DS = DIRECTORY_SEPARATOR;
		$path_root_publicidadeClass = "{$path_root_publicidadeClass}{$DS}..{$DS}..{$DS}";
		$this->dbConn = new DataBaseClass();
		$this->publicidadeFolder = "{$path_root_publicidadeClass}publicidade{$DS}";
		if(!is_dir($this->publicidadeFolder)){
			mkdir($this->publicidadeFolder,0777);
			chmod($this->publicidadeFolder,0777);
		}
	}
	public function getLista(){
		$sql = array();
		$sql[] = "
			SELECT	p.publicidade_id
					,p.publicidade_tipo_id
					,p.publicidade_tipomedia
					,p.publicidade_arquivo
					,p.publicidade_link
					,p.publicidade_numclique
					,p.publicidade_dt_ativacao
					,p.publicidade_dt_desativacao
					,p.publicidade_dt_criacao
					,p.publicidade_dtcomp_criacao
					,pt.publicidade_tipo_titulo
			FROM	tb_publicidade p
			
			JOIN	tb_publicidade_tipo pt
			ON		pt.publicidade_tipo_id = p.publicidade_tipo_id
			
			WHERE	1 = 1
		";
		if(isset($this->values['publicidade_tipomedia'])&&trim($this->values['publicidade_tipomedia'])!=''){
			$sql[] = "AND	p.publicidade_tipomedia = '{$this->values['publicidade_tipomedia']}'";
		}
		if(isset($this->values['publicidade_arquivo'])&&trim($this->values['publicidade_arquivo'])!=''){
			$sql[] = "AND	p.publicidade_arquivo = '{$this->values['publicidade_arquivo']}'";
		}
		if(isset($this->values['publicidade_numclique'])&&trim($this->values['publicidade_numclique'])!=''){
			$sql[] = "AND	p.publicidade_numclique = '{$this->values['publicidade_numclique']}'";
		}
		
		if(isset($this->values['publicidade_tipo_id'])&&trim($this->values['publicidade_tipo_id'])!=''){
			$sql[] = "AND	p.publicidade_tipo_id = '{$this->values['publicidade_tipo_id']}'";
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
		return $this->utf8_array_encode($res);
	}
	public function getOne(){
		$sql = array();
		$sql[] = "
			SELECT	publicidade_id
					,publicidade_tipo_id
					,publicidade_tipomedia
					,publicidade_arquivo
					,publicidade_link
					,publicidade_numclique
					,publicidade_dt_ativacao
					,publicidade_dt_desativacao
					,publicidade_dt_criacao
					,publicidade_dtcomp_criacao
			FROM	tb_publicidade
			WHERE	1 = 1
		";
		if(isset($this->values['publicidade_id'])&&trim($this->values['publicidade_id'])!=''){
			$sql[] = "AND	publicidade_id = '{$this->values['publicidade_id']}'";
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
		if(isset($this->values['publicidade_id'])&&trim($this->values['publicidade_id'])!=''){
			$result = $this->update();
		}else{
			$result = $this->insert();
		}
		return $result;
	}
	public function update(){
		$this->dbConn->db_start_transaction();
		$sql = array();
		if(is_file($this->files['publicidade_arquivo']['tmp_name'])){
			$fileName = microtime(true)."_".$this->files['publicidade_arquivo']['name'];
			if(move_uploaded_file($this->files['publicidade_arquivo']['tmp_name'], $this->publicidadeFolder.$fileName)){
				$this->values['publicidade_arquivo'] = $fileName;
			}else{
				$this->values['publicidade_arquivo'] = "";
			}
		}
		$this->values['publicidade_dt_ativacao'] = $this->dateBR2DB($this->values['publicidade_dt_ativacao']);
		$this->values['publicidade_dt_desativacao'] = $this->dateBR2DB($this->values['publicidade_dt_desativacao']);
		
		$sql[] = "
			UPDATE	tb_publicidade SET
				publicidade_tipomedia = '{$this->values['publicidade_tipomedia']}'
				,publicidade_numclique = '{$this->values['publicidade_numclique']}'
				,publicidade_tipo_id = '{$this->values['publicidade_tipo_id']}'
				,publicidade_dt_ativacao = '{$this->values['publicidade_dt_ativacao']}'
				,publicidade_dt_desativacao = '{$this->values['publicidade_dt_desativacao']}'
				,publicidade_dt_criacao = NOW()
				,publicidade_dtcomp_criacao	= NOW()
		";
		if(isset($this->values['publicidade_arquivo'])&&trim($this->values['publicidade_arquivo'])!=''){
			$sql[] = ",publicidade_arquivo = '{$this->values['publicidade_arquivo']}'";
		}
		if(isset($this->values['publicidade_link'])&&trim($this->values['publicidade_link'])!=''){
			$sql[] = ",publicidade_link = '{$this->values['publicidade_link']}'";
		}
		
		$sql[] = "WHERE publicidade_id = '{$this->values['publicidade_id']}'";
		$ret = array(
			'success'=>false
			,'publicidade_id' =>$this->values['publicidade_id']
		);
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			$this->dbConn->db_commit();
			$ret['success'] = $result['success'];
			$ret['publicidade_id'] = $this->values['publicidade_id'];
		}else{
			$this->dbConn->db_rollback();
		}
		return $ret;
	}
	
	public function insert(){
		$this->dbConn->db_start_transaction();
		$sql = array();
		if(is_file($this->files['publicidade_arquivo']['tmp_name'])){
			$fileName = microtime(true)."_".$this->files['publicidade_arquivo']['name'];
			if(move_uploaded_file($this->files['publicidade_arquivo']['tmp_name'], $this->publicidadeFolder.$fileName)){
				$this->values['publicidade_arquivo'] = $fileName;
			}else{
				$this->values['publicidade_arquivo'] = "";
			}
		}
		$this->values['publicidade_dt_ativacao'] = $this->dateBR2DBTime($this->values['publicidade_dt_ativacao']);
		$this->values['publicidade_dt_desativacao'] = $this->dateBR2DBTime($this->values['publicidade_dt_desativacao']);
		$sql[] = "
			INSERT INTO	tb_publicidade SET
				publicidade_tipomedia = '{$this->values['publicidade_tipomedia']}'
				,publicidade_tipo_id = '{$this->values['publicidade_tipo_id']}'
				,publicidade_numclique = '{$this->values['publicidade_numclique']}'
				,publicidade_dt_ativacao = '{$this->values['publicidade_dt_ativacao']}'
				,publicidade_dt_desativacao = '{$this->values['publicidade_dt_desativacao']}'
				,publicidade_dt_criacao = NOW()
				,publicidade_dtcomp_criacao	= NOW()
		";
		if(isset($this->values['publicidade_arquivo'])&&trim($this->values['publicidade_arquivo'])!=''){
			$sql[] = ",publicidade_arquivo = '{$this->values['publicidade_arquivo']}'";
		}
		if(isset($this->values['publicidade_link'])&&trim($this->values['publicidade_link'])!=''){
			$sql[] = ",publicidade_link = '{$this->values['publicidade_link']}'";
		}
		
		$ret = array(
			'success'=>false
			,'publicidade_id' =>''
		);
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			$this->dbConn->db_commit();
			$ret['success'] = $result['success'];
			$ret['publicidade_id'] = $result['last_id'];
		}else{
			$this->dbConn->db_rollback();
		}
		return $ret;
	}
	public function getPublicidadeTipoCombo($returnExt=true){
		$sql = array();
		$sql[] = "
			SELECT	*
			FROM	tb_publicidade_tipo

			WHERE	1 = 1
		";
		$result = $this->dbConn->db_query(implode("\n",$sql));
		if(!$result['success']){
			return false;
		}
		$rs = array();
		if($result['total'] > 0){
			$res = array();
			if($result['total'] > 0){
				while($rs = $this->dbConn->db_fetch_assoc($result['result'])){
					array_push($res, $rs);
				}
			}
		}
		if($returnExt){
			return $this->convertExtReturn($res, $success,count($res));
		}
		return $this->utf8_array_encode($res);
	}
	
}
?>
