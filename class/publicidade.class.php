<?php
$path_root_class = dirname(__FILE__);
$DS = DIRECTORY_SEPARATOR;
$path_root_class = "{$path_root_class}{$DS}";
require_once "{$path_root_class}default.class.php";
class publicidade extends defaultClass{

	private $publicidade_id = '';
	private $publicidade_tipo = '';
	private $publicidade_tipo_id = '';

	public function setPublicidade_id($publicidade_id) {
	 $this->publicidade_id = $publicidade_id;
	}

	public function setPublicidadeTipo($publicidade_tipo) {
	 $this->publicidade_tipo = $publicidade_tipo;
	}

	public function setPublicidadeTipo_id($publicidade_tipo_id) {
	 $this->publicidade_tipo_id = $publicidade_tipo_id;
	}

	private $total;
	public function getTotal() {
	 return $this->total;
	}
	public function setTotal($total) {
	 $this->total = $total;
	}

	public function getPublicidadeByTipo(){
		$sql = array();
		$sql[] = "
			
			SELECT   pt.publicidade_tipo_id
					,pt.publicidade_tipo_titulo
					,pt.publicidade_tipo_altura
					,pt.publicidade_tipo_largura
					,p.publicidade_id
					,p.publicidade_tipomedia
					,p.publicidade_arquivo
					,p.publicidade_link
					,p.publicidade_dtcomp_criacao
					,IF(p.publicidade_dt_ativacao='0000-00-00 00:00:00',NOW(),p.publicidade_dt_ativacao) AS publicidade_dt_ativacao
					,IF(p.publicidade_dt_desativacao='0000-00-00 00:00:00',NOW(),p.publicidade_dt_desativacao) AS publicidade_dt_desativacao
					,p.publicidade_numclique

			FROM tb_publicidade_tipo pt
			JOIN tb_publicidade p
			ON pt.publicidade_tipo_id = p.publicidade_tipo_id
			WHERE 0=0
			AND  pt.publicidade_tipo_id = '{$this->publicidade_tipo}'
			HAVING DATE_FORMAT(NOW(),'%Y-%m-%d') BETWEEN DATE_FORMAT(publicidade_dt_ativacao,'%Y-%m-%d') AND DATE_FORMAT(publicidade_dt_desativacao ,'%Y-%m-%d')
			ORDER BY RAND()
			
			LIMIT 1
		";
		$res = array();
		$this->setTotal($this->getMaxCount(implode("\n",$sql)));
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
				array_push($res, $rs);
			}
		}
		return $this->utf8_array_encode($res);
	}

}
?>
