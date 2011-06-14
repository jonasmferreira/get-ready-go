<?php
require_once "default.class.php";
class busca_result extends defaultClass{
	public function __construct() {
		$this->dbConn = new DataBaseClass();
	}
	public function getBusca(){
		$busca = $this->values['busca'];
		$sql = array();
		$sql[] = "
			SELECT	p.post_id
					,p.categoria_id
					,c.categoria_nome
					,p.post_titulo
					,p.post_palavra_chave
					,p.post_conteudo
					,DATE_FORMAT(p.post_dtcomp_criacao,'%d.%m.%Y %h:%i') AS post_dt_criacao
			FROM	tb_post p
			
			JOIN	tb_usuario u
			ON		p.usuario_id = u.usuario_id
			
			JOIN	tb_categoria c
			ON		p.categoria_id = c.categoria_id
			
			WHERE	1 = 1
		";
		$sql[] = "AND	(
				p.post_titulo LIKE '%{$busca}%'
				OR c.categoria_nome LIKE '%{$busca}%'
				OR u.usuario_nome LIKE '%{$busca}%'
				OR p.post_conteudo LIKE '%{$busca}%'
				OR p.post_palavra_chave LIKE '%{$busca}%'
			)
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
