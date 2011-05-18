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
		return $rs;
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
			/*if(is_array($this->values['imagens'])){
				foreach($this->values['imagens'] AS $k=>$v){
					$imagem = array();
					$imagem['titulo'] = $v['titulo'];
					$imagem['thumb'] = $this->files['thumb'][$k];
					$imagem['imagem'] = $this->files['imagem'][$k];
					$this->insertImagemGaleria($imagem);
				}
			}*/
			
			
			$ret['success'] = $result['success'];
			$ret['galeria_id'] = $result['last_id'];
		}else{
			$this->dbConn->db_rollback();
		}
		return $ret;
	}
	public function insertImagemGaleria($imagem){
		$DS = DIRECTORY_SEPARATOR;
		$galeriaPath = $this->galeriaFolder."galeria_{$this->galeria_id}{$DS}";
		if(!is_dir($galeriaPath)){
			mkdir($galeriaPath,0777);
			chmod($galeriaPath,0777);
		}
		$galeriaThumbPath = $this->galeriaFolder."galeria_{$this->galeria_id}{$DS}thumbs{$DS}";
		if(!is_dir($galeriaThumbPath)){
			mkdir($galeriaThumbPath,0777);
			chmod($galeriaThumbPath,0777);
		}
		
		$img = "";
		$fileNameImagem = str_replace(".","",microtime(true))."_".$imagem['imagem']['name'];
		if(trim($imagem['imagem']['name'])!='' && move_uploaded_file($imagem['imagem']['tmp_name'], $galeriaPath.$fileNameImagem)){
			$img = $fileNameImagem;
		}else{
			$img = "";
		}
		
		$thumb = "";
		$fileNameThumb = str_replace(".","",microtime(true))."_".$imagem['thumb']['name'];
		if(trim($imagem['thumb']['name'])!='' && move_uploaded_file($imagem['thumb']['tmp_name'], $galeriaThumbPath.$fileNameThumb)){
			$thumb = $fileNameThumb;
		}else{
			$thumb = "";
		}
		if(trim($thumb)!='' && trim($img)!=''){
			$sql = array();
			$sql[] = "
				INSERT INTO tb_imagem_galeria
					galeria_id = '{$galeria_id}'
					,imagem_galeria_titulo = '{$imagem['titulo']}'
					,imagem_galeria_imagem = '{$img}'
					,imagem_galeria_thumb = '{$thumb}'
					,imagem_galeria_dt_criacao = NOW()
					,imagem_galeria_dtcomp_criacao = NOW()
			";
			$result = $this->dbConn->db_execute(implode("\n",$sql));
			return $result['success'];
		}else{
			return true;
		}
	}
}
?>
