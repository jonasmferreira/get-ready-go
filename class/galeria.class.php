<?php
require_once "default.class.php";
class galeria extends defaultClass{

	private $post_id;

	public function setPost_id($post_id) {
	 $this->post_id = $post_id;
	}

	public function getFotos($idOrdem){
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
		";
		$result = $this->dbConn->db_query(implode("\n",$sql));
		if(!$result['success']){
			return false;
		}
		$res = array();
		$i=1;
		if($result['total'] > 0){
			while($rs = $this->dbConn->db_fetch_assoc($result['result'])){
				$foto = ($idOrdem==$rs['imagem_galeria_id'])?0:$i;
				$res[$foto]['imagem_galeria_id'] = $rs['imagem_galeria_id'];
				$res[$foto]['galeria_id'] = $rs['galeria_id'];
				$res[$foto]['imagem_galeria_titulo'] = $rs['imagem_galeria_titulo'];
				$res[$foto]['imagem_galeria_imagem'] = $rs['imagem_galeria_imagem'];
				$res[$foto]['imagem_galeria_dt_criacao'] = $rs['imagem_galeria_dt_criacao'];
				$res[$foto]['imagem_galeria_dtcomp_criacao'] = $rs['imagem_galeria_dtcomp_criacao'];
				$res[$foto]['imagem_galeria_dt_alteracao'] = $rs['imagem_galeria_dt_alteracao'];
				$res[$foto]['imagem_galeria_dtcomp_alteracao'] = $rs['imagem_galeria_dtcomp_alteracao'];
				$res[$foto]['galeria_titulo'] = $rs['galeria_titulo'];
				$i++;
			}
		}
		ksort($res);
		return $res;
	}
}
?>
