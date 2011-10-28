<?php
$path_root_class = dirname(__FILE__);
$DS = DIRECTORY_SEPARATOR;
$path_root_class = "{$path_root_class}{$DS}";
require_once "{$path_root_class}default.class.php";
class home extends defaultClass{

	private $categoria_id = '';
	private $opcao_enquete_opcao_id;

	public function setCategoria_id($categoria_id) {
	 $this->categoria_id = $categoria_id;
	}
	
	public function setOpcao_enquete_opcao_id($opcao_enquete_opcao_id) {
		$this->opcao_enquete_opcao_id = $opcao_enquete_opcao_id;
	}
	
	public function getLastPost(){
		$sql = array();
		$sql[] = "
			SELECT	p.post_id
					,p.categoria_id
					,c.categoria_nome
					,p.usuario_id
					,p.post_titulo
					,p.post_thumb_home
					,p.post_imagem
					,p.post_thumb_imagem
					,p.post_palavra_chave
					,p.post_conteudo
					,DATE_FORMAT(p.post_dtcomp_criacao,'%d.%m.%Y %h:%i') AS post_dt_criacao
					,DATE_FORMAT(p.post_dtcomp_criacao,'%d/%m/%Y %h:%i:%s') AS post_dt_criacao2
					,p.post_dtcomp_criacao
					,p.post_dt_alteracao
					,p.post_dtcomp_alteracao
					,p.post_status
					,u.usuario_nome
					,u.usuario_avatar
					,(SELECT COUNT(*) FROM tb_comentario WHERE post_id = p.post_id AND comentario_status = 1) as qtdComentario
			FROM	tb_post p

			JOIN	tb_usuario u
			ON		p.usuario_id = u.usuario_id

			JOIN	tb_categoria c
			ON		p.categoria_id = c.categoria_id

			WHERE	1 = 1
			AND		p.post_status = 1
			AND		c.categoria_id IN ({$this->categoria_id})
			ORDER BY post_dtcomp_criacao DESC
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

	public function getGames(){
		$sql = array();
		$sql[] = "
			SELECT *
			FROM  tb_game g
			JOIN  tb_game_categoria gc ON g.game_categoria_id = gc.game_categoria_id
			JOIN  tb_game_midia gm ON g.game_midia_id = gm.game_midia_id
			JOIN  tb_game_tipo gt ON g.game_tipo_id = gt.game_tipo_id
			ORDER BY game_id DESC
			LIMIT 0,7
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

	public function getEnquete(){
		$sql = array();
		$sql[] = "
			SELECT	enquete_id
					,enquete_titulo
					,enquete_status
					,enquete_dt_criacao
					,enquete_dtcomp_criacao
					,enquete_dt_alteracao
					,enquete_dtcomp_alteracao
			FROM	tb_enquete
			WHERE	1 = 1
			AND		enquete_status = 1
			ORDER BY enquete_dt_criacao
			LIMIT 1
		";
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

	public function opcaoEnquete($enquete_id){
		$sql = array();
		$sql[] = "
			SELECT	eo.enquete_opcao_id
					,eo.enquete_id
					,eo.enquete_opcao_titulo
			FROM	tb_enquete_opcao eo
			WHERE	1 = 1
			AND		eo.enquete_id = '{$enquete_id}'
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
		return $this->utf8_array_encode($res);
	}
	
	public function verifyVotos(){
		$sql = "
			SELECT *
			FROM tb_enquete_votacao 
			WHERE enquete_votacao_ip = '{$_SERVER['REMOTE_ADDR']}'
			AND enquete_votacao_dt = DATE_FORMAT(NOW(),'%Y-%m-%d')
		";
		$result = $this->dbConn->db_query($sql);
		if($result['total'] > 0){
			return false;
		}
		return true;
	}
	
	public function saveVoto(){
		$sql = "
			INSERT INTO tb_enquete_votacao SET
				opcao_enquete_opcao_id = $this->opcao_enquete_opcao_id,
				enquete_votacao_ip = '{$_SERVER['REMOTE_ADDR']}',
				enquete_votacao_dt = NOW(),
				enquete_votacao_dtcomp = NOW()
		";
		$result = $this->dbConn->db_execute($sql);
		if($result['success']===true){
			return true;
		}
		return false;
	}
	
	public function showEnqueteResult($aEnqRes){

			$aEnqRes['success'] = true;
			$li = '';
			//totalizando
			$tot = 0;
			foreach($aEnqRes['data'] as $k => $v){
				$tot += $v['total'];
			}
			foreach($aEnqRes['data'] as $k => $v){
				if($v['total']==0){
					$w = 0;
					$per = 0;
				}else{
					$per = (100 * $v['total'] / $tot);
					$w = (210 / 100 * $per);
				}
				$per = number_format($per,2);
				$w = number_format($w,0);
				
				$li.= "<li>";
				$li.= $v['enquete_opcao_titulo'] . "<br />";
				$li.= "<img src='{$linkAbsolute}imgs/enquete_result1.gif' /><img src='{$linkAbsolute}imgs/enquete_result3.gif' width='$w' height='5' /><img src='{$linkAbsolute}imgs/enquete_result2.gif' />&nbsp;" . $per ."%";
				$li.= "</li> ";
			}
			$aEnqRes['result'] = $li;
			return $aEnqRes;
	}
	
	public function getEnqueteResult($enquete_id){
		$sql = array();
		$sql[] = "
			SELECT	e.enquete_id
					,e.enquete_titulo
					,eo.enquete_opcao_id
					,eo.enquete_opcao_titulo
					,count(ev.enquete_votacao_id) AS total
			FROM	tb_enquete_opcao eo
			LEFT JOIN tb_enquete_votacao ev
			ON		ev.opcao_enquete_opcao_id = eo.enquete_opcao_id
			JOIN	tb_enquete e
			ON		eo.enquete_id = e.enquete_id

			WHERE	0=0
			AND		e.enquete_id = '{$enquete_id}'

			GROUP BY 
					e.enquete_id, eo.enquete_opcao_id
			ORDER BY 
					eo.enquete_opcao_id ASC

		";
		$result = $this->dbConn->db_query(implode("\n",$sql));
		if(!$result['success']){
			return false;
		}
		$res = array();
		$rsEnq = array(
			'total'=> $result['total']
			,'message' => ''
			,'success' => $result['success']
			,'data' => array()
			,'result' => ''
		);
		
		if($result['total'] > 0){
			while($rs = $this->dbConn->db_fetch_assoc($result['result'])){
				array_push($res, $rs);
			}
			$rsEnq['data']= $this->utf8_array_encode($res);
		}

		return $this->showEnqueteResult($rsEnq);
		
	}
	public function getConteudoDestaque($id){
		$sql = array();
		$sql[] = "SELECT post_conteudo FROM	tb_post WHERE post_id = '{$id}'";
		$result = $this->dbConn->db_query(implode("\n",$sql));
		$rs = $this->dbConn->db_fetch_assoc($result['result']);
		$rs['post_conteudo'] = preg_replace("/( +)/", " ",trim($this->cutHTML(strip_tags($rs['post_conteudo']),180)));
		return $rs['post_conteudo'];
	}
	public function getOutdoorDestaque(){
		$sql = array();
		$sql[] = "
			SELECT	p.post_id
					,p.categoria_id
					,c.categoria_nome
					,p.post_titulo
					,p.post_thumb_home
					,p.post_imagem
					,p.post_thumb_imagem
					,p.post_conteudo
					,DATE_FORMAT(p.post_dtcomp_criacao,'%d.%m.%Y %h:%i') AS post_dt_criacao
					,DATE_FORMAT(p.post_dtcomp_criacao,'%d/%m/%Y %h:%i:%s') AS post_dt_criacao2
			FROM	tb_post p

			JOIN	tb_usuario u
			ON		p.usuario_id = u.usuario_id

			JOIN	tb_categoria c
			ON		p.categoria_id = c.categoria_id

			WHERE	1 = 1
			AND		p.post_status = 1
			AND		c.categoria_id IN (2,3)
			ORDER BY post_dtcomp_criacao DESC
			LIMIT 5
		";
		$res = array();
		$this->setTotal($this->getMaxCount(implode("\n",$sql)));
		//echo $this->getTotal();
		$result = $this->dbConn->db_query(implode("\n",$sql));
		if(!$result['success']){
			return false;
		}
		
		if($result['total'] > 0){
			while($rs = $this->dbConn->db_fetch_assoc($result['result'])){
				$cat_nome = str_replace(' ', '_',$this->retiraAcentos($rs['categoria_nome']));
				$post_nome = str_replace(' ', '+', $this->retiraAcentos($rs['post_titulo']));

				$rs['linkDetalhe'] = "detalhe/{$cat_nome}/{$rs['categoria_id']}/{$post_nome}/{$rs['post_id']}";
				$rs['post_conteudo'] = preg_replace("/( +)/", " ",trim(strip_tags($this->cutHTML($rs['post_conteudo'],120))));
				array_push($res, $rs);
			}
		}
		return $this->utf8_array_encode($res);
	}
	public function getGamesRss(){
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
	public function createRss($categoria_id='1'){
		
		$rssType = "";
		switch($categoria_id){
			case '1':
				$rssType = "Notícias";
			break;
			case '2':
				$rssType = "Artigos";
			break;
			case '3':
				$rssType = "Análises";
			break;
		}
		$rss = array();
		$rss[] = '<?xml version="1.0" encoding="UTF-8"?>';
		$rss[]= '<rss version="2.0">';
		$rss[]= '<channel>';
		$rss[]= "<title>Get Ready Go... {$rssType}</title>";
		$rss[]= "<description>Rss de {$rssType}</description>";
		$rss[]= "<link>{$this->linkAbsolute}</link>";
		$rss[]= '<language>pt-br</language>';
		$this->categoria_id = $categoria_id;
		$aNoticias = $this->getLastPost();
		foreach($aNoticias AS $dados) {
			$aDt = explode(" ",$dados['post_dt_criacao2']);
			$dia = explode("/",$aDt[0]);
			$hora = explode(":",$aDt[1]);
			$rss[]= '<item>';
			$rss[]= "<title><![CDATA[".html_entity_decode($dados['post_titulo'])."]]></title>";
			$rss[]= "<description><![CDATA[".$this->cutHTML((html_entity_decode($dados['post_conteudo'], ENT_QUOTES, 'UTF-8')),500)."]]></description>";
			$rss[]= "<link>{$this->linkAbsolute}{$dados['linkDetalhe']}</link>";
			$rss[]= "<pubDate>".date("r",mktime ($hora[0],$hora[1],$hora[2], $dia[1] , $dia[0], $dia[2]))."</pubDate>";
			$rss[]= '</item>';
		}
		$rss[]="</channel>";
		$rss[]="</rss>";
		return implode("\n",$rss);
	}
	public function createRssDestaque(){
		$rss = array();
		$rss[] = '<?xml version="1.0" encoding="UTF-8"?>';
		$rss[]= '<rss version="2.0">';
		$rss[]= '<channel>';
		$rss[]= "<title>Get Ready Go... Destaques</title>";
		$rss[]= "<description>Rss de Destaques</description>";
		$rss[]= "<link>{$this->linkAbsolute}</link>";
		$rss[]= '<language>pt-br</language>';
		$aNoticias = $this->getOutdoorDestaque();
		foreach($aNoticias AS $dados) {
			$aDt = explode(" ",$dados['post_dt_criacao2']);
			$dia = explode("/",$aDt[0]);
			$hora = explode(":",$aDt[1]);
			$rss[]= '<item>';
			$rss[]= "<title><![CDATA[".html_entity_decode($dados['post_titulo'])."]]></title>";
			$rss[]= "<description><![CDATA[".$this->cutHTML((html_entity_decode($dados['post_conteudo'], ENT_QUOTES, 'UTF-8')),500)."]]></description>";
			$rss[]= "<link>{$this->linkAbsolute}{$dados['linkDetalhe']}</link>";
			$rss[]= "<pubDate>".date("r",mktime ($hora[0],$hora[1],$hora[2], $dia[1] , $dia[0], $dia[2]))."</pubDate>";
			$rss[]= '</item>';
		}
		$rss[]="</channel>";
		$rss[]="</rss>";
		return implode("\n",$rss);
	}
	public function createRssIndicamos(){
		/*// Instanciamos/chamamos a classe
		$rss = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss></rss>');
		$rss->addAttribute('version', '2.0');

		// Cria o elemento <channel> dentro de <rss>
		$canal = $rss->addChild('channel');
		// Adiciona sub-elementos ao elemento <channel>
		$canal->addChild('title', 'Get Ready Go... Destaques');
		$canal->addChild('link', "{$this->linkAbsolute}");
		$canal->addChild('description', 'Rss de Destaques');
		$aNoticias = $this->getOutdoorDestaque();

		// Inclui um <item> para cada resultado encontrado
		foreach($aNoticias AS $dados) {
			// Cria um elemento <item> dentro de <channel>
			$item = $canal->addChild('item');
			// Adiciona sub-elementos ao elemento <item>
			$item->addChild('title', html_entity_decode($dados['post_titulo']));
			$item->addChild('link', "{$this->linkAbsolute}{$dados['linkDetalhe']}");
			$item->addChild('description', html_entity_decode($this->cutHTML(($dados['post_conteudo']),500), ENT_QUOTES, 'UTF-8'));
			$aDt = explode(" ",$dados['post_dt_criacao2']);
			
			$dia = explode("/",$aDt[0]);
			$hora = explode(":",$aDt[1]);
			$item->addChild('pubDate',date("r",mktime ($hora[0],$hora[1],$hora[2], $dia[1] , $dia[0], $dia[2])));
		}
		// Entrega o conteúdo do RSS completo:
		$rss_complete = $rss->asXML();
		return $rss_complete;*/
		$rss = array();
		$rss[] = '<?xml version="1.0" encoding="UTF-8"?>';
		$rss[]= '<rss version="2.0">';
		$rss[]= '<channel>';
		$rss[]= "<title>Get Ready Go... Indicamos</title>";
		$rss[]= "<description>Rss de Indicamos</description>";
		$rss[]= "<link>{$this->linkAbsolute}</link>";
		$rss[]= '<language>pt-br</language>';
		$aNoticias = $this->getGamesRss();
		foreach($aNoticias AS $dados) {
			$rss[]= '<item>';
			$rss[]= "<title><![CDATA[".html_entity_decode("{$dados['game_tipo_nome']} - {$dados['game_categoria_nome']} {$dados['game_titulo']}")."]]></title>";
			$rss[]= "<description><![CDATA[".$this->cutHTML((html_entity_decode($dados['game_descricao'], ENT_QUOTES, 'UTF-8')),500)."]]></description>";
			$rss[]= "<link>{$this->linkAbsolute}{$dados['linkDetalhe']}</link>";
			$rss[]= '</item>';
		}
		$rss[]="</channel>";
		$rss[]="</rss>";
		return implode("\n",$rss);
	}
	
}
?>
