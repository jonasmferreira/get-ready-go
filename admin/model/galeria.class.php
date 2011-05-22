<?php
$path_root_galeriaClass = dirname(__FILE__);
$DS = DIRECTORY_SEPARATOR;
$path_root_galeriaClass = "{$path_root_galeriaClass}{$DS}..{$DS}..{$DS}";
require_once "{$path_root_galeriaClass}admin{$DS}model{$DS}default.class.php";
class galeria extends defaultClass{
	private $galeriaFolder;
	public function __construct() {
		$path_root_galeriaClass = dirname(__FILE__);
		$DS = DIRECTORY_SEPARATOR;
		$path_root_galeriaClass = "{$path_root_galeriaClass}{$DS}..{$DS}..{$DS}";
		$this->dbConn = new DataBaseClass();
		$this->galeriaFolder = "{$path_root_galeriaClass}galerias{$DS}";
		if(!is_dir($this->galeriaFolder)){
			mkdir($this->galeriaFolder,0777);
			chmod($this->galeriaFolder,0777);
		}
	}
	public function getLista($returnExt=true){
		$sql = array();
		$sql[] = "
			SELECT a.* 
			FROM	(
		";
		$sql[] = "
			SELECT	g.galeria_id
					,g.galeria_titulo
					,g.galeria_dt_criacao
					,g.galeria_dtcomp_criacao
					,g.galeria_dt_alteracao
					,g.galeria_dtcomp_alteracao
					,g.galeria_status
					,(SELECT COUNT(*) FROM tb_imagem_galeria WHERE galeria_id = g.galeria_id) AS 'qtde_imagens'
			FROM	tb_galeria g
			
			WHERE	1 = 1
		";
		if(isset($this->values['galeria_titulo'])&&trim($this->values['galeria_titulo'])!=''){
			$sql[] = "AND	g.galeria_titulo LIKE '%{$this->values['galeria_titulo']}%'";
		}
		if(isset($this->values['galeria_status'])&&trim($this->values['galeria_status'])!=''){
			$sql[] = "AND	g.galeria_status = '{$this->values['galeria_status']}'";
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
		return $res;
	}
	
	public function getOne(){
		$sql = array();
		$sql[] = "
			SELECT	galeria_id
					,galeria_titulo
					,galeria_dt_criacao
					,galeria_dtcomp_criacao
					,galeria_dt_alteracao
					,galeria_dtcomp_alteracao
					,galeria_status
			FROM	tb_galeria
			
			WHERE	1 = 1
		";
		if(isset($this->values['galeria_id'])&&trim($this->values['galeria_id'])!=''){
			$sql[] = "AND	galeria_id = '{$this->values['galeria_id']}'";
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
		if(isset($this->values['galeria_id'])&&trim($this->values['galeria_id'])!=''){
			$result = $this->update();
		}else{
			$result = $this->insert();
		}
		return $result;
	}
	
	public function update(){
		$this->dbConn->db_start_transaction();
		$sql = array();
		$sql[] = "
			UPDATE	tb_galeria SET
					galeria_titulo = '{$this->values['galeria_titulo']}'
					,galeria_dt_alteracao = NOW()
					,galeria_dtcomp_alteracao = NOW()
					,galeria_status = '{$this->values['galeria_status']}'
		";
		$sql[] = "WHERE galeria_id = '{$this->values['galeria_id']}'";
		$ret = array(
			'success'=>false
			,'galeria_id' =>$this->values['galeria_id']
		);
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			$this->dbConn->db_commit();
			if(is_array($this->values['imagem_galeria_id'])){
				foreach($this->values['imagem_galeria_id'] AS $k=>$v){
					$imagem = array();
					$imagem['id'] = $v;
					$imagem['galeria_id'] = $this->values['galeria_id'];
					$imagem['titulo'] = $this->values['imagem_galeria_titulo'][$k];
					
					//$imagem['thumb']['name'] = $this->files['imagem_galeria_thumb']['name'][$k];
					$imagem['imagem']['name'] = $this->files['imagem_galeria_imagem']['name'][$k];
					
					//$imagem['thumb']['tmp_name'] = $this->files['imagem_galeria_thumb']['tmp_name'][$k];
					$imagem['imagem']['tmp_name'] = $this->files['imagem_galeria_imagem']['tmp_name'][$k];
					if(trim($imagem['id'])==''){
						$this->insertImagemGaleria($imagem);
					}else{
						$this->updateImagemGaleria($imagem);
					}
				}
			}
			$ret['success'] = $result['success'];
			$ret['galeria_id'] = $this->values['galeria_id'];
		}else{
			$this->dbConn->db_rollback();
		}
		return $ret;
	}
	public function insert(){
		$this->dbConn->db_start_transaction();
		$sql = array();
		$sql[] = "
			INSERT INTO	tb_galeria SET
				galeria_titulo = '{$this->values['galeria_titulo']}'
				,galeria_dt_criacao = NOW()
				,galeria_dtcomp_criacao = NOW()
				,galeria_status = '{$this->values['galeria_status']}'
		";
		
		$ret = array(
			'success'=>false
			,'galeria_id' =>''
		);
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			$this->dbConn->db_commit();
			if(is_array($this->values['imagem_galeria_id'])){
				foreach($this->values['imagem_galeria_id'] AS $k=>$v){
					$imagem = array();
					$imagem['id'] = $v;
					$imagem['galeria_id'] = $result['last_id'];
					$imagem['titulo'] = $this->values['imagem_galeria_titulo'][$k];
					
					$imagem['thumb']['name'] = $this->files['imagem_galeria_thumb']['name'][$k];
					$imagem['imagem']['name'] = $this->files['imagem_galeria_imagem']['name'][$k];
					
					$imagem['thumb']['tmp_name'] = $this->files['imagem_galeria_thumb']['tmp_name'][$k];
					$imagem['imagem']['tmp_name'] = $this->files['imagem_galeria_imagem']['tmp_name'][$k];
					if(trim($imagem['id'])==''){
						$this->insertImagemGaleria($imagem);
					}else{
						$this->updateImagemGaleria($imagem);
					}
				}
			}
			
			$ret['success'] = $result['success'];
			$ret['galeria_id'] = $result['last_id'];
		}else{
			$this->dbConn->db_rollback();
		}
		return $ret;
	}
	
	public function deleteImagemGaleria(){
		$DS = DIRECTORY_SEPARATOR;
		$this->dbConn->db_start_transaction();
		$sqlSelect = "SELECT * FROM tb_imagem_galeria WHERE imagem_galeria_id = '{$this->values['imagem_galeria_id']}'";
		$resultSelect = $this->dbConn->db_query($sqlSelect);
		if(!$resultSelect['success']){
			return false;
		}
		$rs = array();
		if($resultSelect['total'] > 0){
			$rs = $this->dbConn->db_fetch_assoc($resultSelect['result']);
			$galeriaPath = $this->galeriaFolder."galeria_{$rs['galeria_id']}{$DS}";
			$thumb = $galeriaPath.$rs['imagem_galeria_thumb'];
			$imagem = $galeriaPath.$rs['imagem_galeria_imagem'];
		}
		$sql = array();
		$sql[] = "DELETE FROM tb_imagem_galeria WHERE imagem_galeria_id = '{$this->values['imagem_galeria_id']}'";
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		if($result['success']===true){
			$this->dbConn->db_commit();
			if(is_file($thumb)){
				unlink($thumb);
			}
			if(is_file($imagem)){
				unlink($imagem);
			}
			return true;
		}else{
			$this->dbConn->db_rollback();
			return false;
		}
	}
	public function insertImagemGaleria($imagem){
		$galeria_id = $imagem['galeria_id'];
		$DS = DIRECTORY_SEPARATOR;
		$galeriaPath = $this->galeriaFolder."galeria_{$galeria_id}{$DS}";
		if(!is_dir($galeriaPath)){
			mkdir($galeriaPath,0777);
			chmod($galeriaPath,0777);
		}
		
		$galeriaThumbPath = $this->galeriaFolder."galeria_{$galeria_id}{$DS}thumbs{$DS}";
		if(!is_dir($galeriaThumbPath)){
			mkdir($galeriaThumbPath,0777);
			chmod($galeriaThumbPath,0777);
		}
		
		$img = "";
		$fileNameImagem = str_replace(".","",microtime(true))."_".$imagem['imagem']['name'];
		if(move_uploaded_file($imagem['imagem']['tmp_name'], $galeriaPath.$fileNameImagem)){
			$img = $fileNameImagem;
		}else{
			$img = "";
		}
		
		/*
		$thumb = "";
		$fileNameThumb = str_replace(".","",microtime(true))."_".$imagem['thumb']['name'];
		if(move_uploaded_file($imagem['thumb']['tmp_name'], $galeriaThumbPath.$fileNameThumb)){
			$thumb = $fileNameThumb;
		}else{
			$thumb = "";
		}
		*/
		$sql = array();
		$sql[] = "
			INSERT INTO tb_imagem_galeria SET
				galeria_id = '{$galeria_id}'
				,imagem_galeria_titulo = '{$imagem['titulo']}'
				,imagem_galeria_dt_criacao = NOW()
				,imagem_galeria_dtcomp_criacao = NOW()
		";
		if($img!=''){
			$sql[] = ",imagem_galeria_imagem = '{$img}'";
		}
		/*
		if($thumb!=''){
			$sql[] = ",imagem_galeria_thumb = '{$thumb}'";
		}
		 */
		
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		return $result['success'];
		
	}
	public function updateImagemGaleria($imagem){
		$galeria_id = $imagem['galeria_id'];
		$DS = DIRECTORY_SEPARATOR;
		$galeriaPath = $this->galeriaFolder."galeria_{$galeria_id}{$DS}";
		if(!is_dir($galeriaPath)){
			mkdir($galeriaPath,0777);
			chmod($galeriaPath,0777);
		}
		$galeriaThumbPath = $this->galeriaFolder."galeria_{$galeria_id}{$DS}thumbs{$DS}";
		if(!is_dir($galeriaThumbPath)){
			mkdir($galeriaThumbPath,0777);
			chmod($galeriaThumbPath,0777);
		}
		
		$img = "";
		$fileNameImagem = str_replace(".","",microtime(true))."_".$imagem['imagem']['name'];
		if(move_uploaded_file($imagem['imagem']['tmp_name'], $galeriaPath.$fileNameImagem)){
			$img = $fileNameImagem;
		}else{
			$img = "";
		}
		
		/*
		$thumb = "";
		$fileNameThumb = str_replace(".","",microtime(true))."_".$imagem['thumb']['name'];
		if(move_uploaded_file($imagem['thumb']['tmp_name'], $galeriaThumbPath.$fileNameThumb)){
			$thumb = $fileNameThumb;
		}else{
			$thumb = "";
		}
		 */
		
		$sql = array();
		$sql[] = "
			UPDATE tb_imagem_galeria SET
				galeria_id = '{$galeria_id}'
				,imagem_galeria_titulo = '{$imagem['titulo']}'
				,imagem_galeria_dt_alteracao = NOW()
				,imagem_galeria_dtcomp_alteracao = NOW()
		";
		if($img!=''){
			$sql[] = ",imagem_galeria_imagem = '{$img}'";
		}
		
		/*
		if($thumb!=''){
			$sql[] = ",imagem_galeria_thumb = '{$thumb}'";
		}
		*/
		
		$sql[] = "WHERE imagem_galeria_id = '{$imagem['id']}'";
		$result = $this->dbConn->db_execute(implode("\n",$sql));
		return $result['success'];
	}
	public function getListaImagens($galeria_id){
		$sql = array();
		$sql[] = "
			SELECT	ig.*
			FROM	tb_imagem_galeria ig
			WHERE	1 = 1
		";
		if(isset($galeria_id)&&trim($galeria_id)!=''){
			$sql[] = "AND	ig.galeria_id = '{$galeria_id}'";
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
		return $this->utf8_array_encode($res);
	}
}
?>
