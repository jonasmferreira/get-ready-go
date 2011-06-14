<?php
require_once "default.class.php";
class game extends defaultClass{

	private $game_id;
	private $pontuacao;
	public function setGame_id($game_id) {
	 $this->game_id = $game_id;
	}
	public function setPontuacao($pontuacao) {
	 $this->pontuacao = $pontuacao;
	}

	public function getJogoDownload(){
		$sql = array();
		$sql[] = "
			SELECT *
			FROM	tb_game g
			JOIN	tb_game_categoria gc ON g.game_categoria_id = gc.game_categoria_id
			JOIN	tb_game_midia gm ON g.game_midia_id = gm.game_midia_id
			JOIN	tb_game_tipo gt ON g.game_tipo_id = gt.game_tipo_id
			LEFT JOIN	tb_usuario u ON u.usuario_id = g.game_criador_is_user
			WHERE 1=1
			AND game_id = {$this->game_id}
		";
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
	public function getJogoMaisJogado(){
		$sql = array();
		$sql[] = "
			SELECT *
			FROM	tb_game g
			JOIN	tb_game_categoria gc ON g.game_categoria_id = gc.game_categoria_id
			JOIN	tb_game_midia gm ON g.game_midia_id = gm.game_midia_id
			JOIN	tb_game_tipo gt ON g.game_tipo_id = gt.game_tipo_id
			LEFT JOIN	tb_usuario u ON u.usuario_id = g.game_criador_is_user
			WHERE 1=1
			AND g.game_categoria_id = 2
			ORDER BY game_qtd_jogado DESC
			LIMIT 1
		";
		$result = $this->dbConn->db_query(implode("\n",$sql));
		if(!$result['success']){
			return false;
		}
		$res = array();
		if($result['total'] > 0){
			$rs = $this->dbConn->db_fetch_assoc($result['result']);
			$cat_nome = str_replace(' ', '_',$this->retiraAcentos($rs['game_categoria_nome']));
			$game_nome = str_replace(' ', '+', $this->retiraAcentos($rs['game_titulo']));
			$rs['linkDetalhe'] = "jogoBrowser/{$cat_nome}/{$rs['game_categoria_id']}/{$game_nome}/{$rs['game_id']}";
		}
		return $this->utf8_array_encode($rs);
	}
	public function getMaisVotados(){
		$sql = array();
		$sql[] = "
			SELECT *,IFNULL((game_total_votacao/game_qtd_votacao),0) AS total
			FROM	tb_game g
			JOIN	tb_game_categoria gc ON g.game_categoria_id = gc.game_categoria_id
			JOIN	tb_game_midia gm ON g.game_midia_id = gm.game_midia_id
			JOIN	tb_game_tipo gt ON g.game_tipo_id = gt.game_tipo_id
			LEFT JOIN	tb_usuario u ON u.usuario_id = g.game_criador_is_user
			WHERE 1=1
			AND game_id != (SELECT gv.game_id FROM tb_game gv WHERE 1=1 AND gv.game_categoria_id = 2 ORDER BY gv.game_qtd_jogado DESC LIMIT 1)
			ORDER BY total DESC
			LIMIT 3
		";
		$result = $this->dbConn->db_query(implode("\n",$sql));
		if(!$result['success']){
			return false;
		}
		$res = array();
		if($result['total'] > 0){
			while($rs = $this->dbConn->db_fetch_assoc($result['result'])){
				$cat_nome = str_replace(' ', '_',$this->retiraAcentos($rs['game_categoria_nome']));
				$game_nome = str_replace(' ', '+', $this->retiraAcentos($rs['game_titulo']));
				if($rs['game_categoria_id']==1){
					$rs['linkDetalhe'] = "jogoDownload/{$cat_nome}/{$rs['game_categoria_id']}/{$game_nome}/{$rs['game_id']}";
				}else{
					$rs['linkDetalhe'] = "jogoBrowser/{$cat_nome}/{$rs['game_categoria_id']}/{$game_nome}/{$rs['game_id']}";
				}

				array_push($res, $rs);
			}
		}
		return $this->utf8_array_encode($res);
	}
	public function getPopulares(){
		$sql = array();
		$sql[] = "
			SELECT *,IFNULL((game_total_votacao/game_qtd_votacao),0) AS total
			FROM	tb_game g
			JOIN	tb_game_categoria gc ON g.game_categoria_id = gc.game_categoria_id
			JOIN	tb_game_midia gm ON g.game_midia_id = gm.game_midia_id
			JOIN	tb_game_tipo gt ON g.game_tipo_id = gt.game_tipo_id
			LEFT JOIN	tb_usuario u ON u.usuario_id = g.game_criador_is_user
			WHERE 1=1
			AND game_id != (SELECT gv.game_id FROM tb_game gv WHERE 1=1 AND gv.game_categoria_id = 2 ORDER BY gv.game_qtd_jogado DESC LIMIT 1)
			ORDER BY game_qtd_jogado DESC
			LIMIT 3
		";
		$result = $this->dbConn->db_query(implode("\n",$sql));
		if(!$result['success']){
			return false;
		}
		$res = array();
		if($result['total'] > 0){
			while($rs = $this->dbConn->db_fetch_assoc($result['result'])){
				$cat_nome = str_replace(' ', '_',$this->retiraAcentos($rs['game_categoria_nome']));
				$game_nome = str_replace(' ', '+', $this->retiraAcentos($rs['game_titulo']));
				if($rs['game_categoria_id']==1){
					$rs['linkDetalhe'] = "jogoDownload/{$cat_nome}/{$rs['game_categoria_id']}/{$game_nome}/{$rs['game_id']}";
				}else{
					$rs['linkDetalhe'] = "jogoBrowser/{$cat_nome}/{$rs['game_categoria_id']}/{$game_nome}/{$rs['game_id']}";
				}

				array_push($res, $rs);
			}
		}
		return $this->utf8_array_encode($res);
	}
	public function isUserVoted(){
		$sql = array();
		$sql[] = "
			SELECT	*
			FROM	tb_game_usuario_votacao
			WHERE	1 = 1
			AND		usuario_id = '{$_SESSION['GET_READY_GO_2011_SITE']['usuario_id']}'
			AND		game_id = {$this->game_id}	
		";
		$result = $this->dbConn->db_query(implode("\n",$sql));
		if(!$result['success']){
			return false;
		}
		$res = array();
		if($result['total'] > 0){
			$rs = $this->dbConn->db_fetch_assoc($result['result']);
		}else{
			return array();
		}
		return $this->utf8_array_encode($rs);	
	}
	public function saveQtdJogado(){
		$sql = "
			UPDATE tb_game SET
			game_qtd_jogado = (game_qtd_jogado+1)
			WHERE 1=1
			AND game_id = {$this->game_id}
		";
		$result = $this->dbConn->db_execute($sql);
		if($result['success']===true){
			return true;
		}
		return false;
	}
	public function saveQtdDownload(){
		$sql = "
			UPDATE tb_game SET
			game_qtd_download = (game_qtd_download+1)
			WHERE 1=1
			AND game_id = {$this->game_id}
		";
		$result = $this->dbConn->db_execute($sql);
		if($result['success']===true){
			return true;
		}
		return false;
	}
	public function getGames(){
		$sql = array();
		$sql[] = "
			SELECT 
				g.game_id,
				g.game_titulo,
				g.game_descricao,
				g.game_thumb,
				g.game_imagem_destaque,
				g.game_tipo_id,
				g.game_categoria_id,
				g.game_midia_id,
				g.game_link,
				g.game_qtd_download,
				g.game_qtd_jogado,
				g.game_qtd_votacao,
				g.game_total_votacao,
				g.game_criador_is_user,
				g.game_criador_nome,
				g.game_width,
				g.game_height,
				gc.game_categoria_nome,
				gm.game_midia_nome,
				gt.game_tipo_nome
			FROM  tb_game g
			JOIN  tb_game_categoria gc ON g.game_categoria_id = gc.game_categoria_id
			JOIN  tb_game_midia gm ON g.game_midia_id = gm.game_midia_id
			JOIN  tb_game_tipo gt ON g.game_tipo_id = gt.game_tipo_id
			ORDER BY game_id DESC
		";
		$this->setTotal($this->getMaxCount(implode("\n",$sql)));
		//echo $this->getTotal();
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
				$cat_nome = str_replace(' ', '_',$this->retiraAcentos($rs['game_categoria_nome']));
				$game_nome = str_replace(' ', '+', $this->retiraAcentos($rs['game_titulo']));
				if($rs['game_categoria_id']==1){
					$rs['linkDetalhe'] = "jogoDownload/{$cat_nome}/{$rs['game_categoria_id']}/{$game_nome}/{$rs['game_id']}";
				}else{
					$rs['linkDetalhe'] = "jogoBrowser/{$cat_nome}/{$rs['game_categoria_id']}/{$game_nome}/{$rs['game_id']}";
				}

				array_push($res, $rs);
			}
		}
		return $this->utf8_array_encode($res);
	}
	public function savePontuacao(){
		$sql = "
			UPDATE tb_game SET
			game_total_votacao = (game_total_votacao+$this->pontuacao),
			game_qtd_votacao = (game_qtd_votacao+1)
			WHERE 1=1
			AND game_id = {$this->game_id}
		";
		$result = $this->dbConn->db_execute($sql);
		if($result['success']===true){
			$sql = "
				INSERT INTO tb_game_usuario_votacao SET
					game_id = '{$this->game_id}'
					,usuario_id = '{$_SESSION['GET_READY_GO_2011_SITE']['usuario_id']}'
					,valor_votacao = '{$this->pontuacao}'
			";
			$result = $this->dbConn->db_execute($sql);
			return true;
		}
		return false;
	}
}
?>
