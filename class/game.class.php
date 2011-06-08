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
			return true;
		}
		return false;
	}
}
?>
