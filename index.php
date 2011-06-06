<?php
	include_once 'includes/cabecalho.php';
	include_once 'includes/header.php';
	require_once 'class/home.class.php';
	$obj = new home();
	$obj->setLimitMax(3);
	$obj->setLimitStart(0);
	$obj->setCategoria_id(1);
	$aNoticias = $obj->getLastPost();

	$obj->setLimitMax(null);
	$obj->setLimitStart(null);
	$obj->setCategoria_id(2);
	$aArtigo = $obj->getLastPost();

	$obj->setLimitMax(null);
	$obj->setLimitStart(null);
	$obj->setCategoria_id(3);
	$aAnalises = $obj->getLastPost();

	$obj->setLimitMax(null);
	$obj->setLimitStart(null);
	$obj->setCategoria_id(4);
	$aIndicados = $obj->getLastPost();

	$aGame = $obj->getGames();

	$aEnquete = $obj->getEnquete();
	$aEnqueteOpcao = $obj->opcaoEnquete($aEnquete['enquete_id']);
	//echo "<pre>".print_r($aEnqueteOpcao,true)."</pre>";
?>
	<!-- Coluna Esquerda -->
	<div id="leftCol">

		<!-- Destaque rotativo -->
		<img src="imgs/content_top.png" align="absbottom" />
		<div id="destaque">
			<div id="container" style="background:url(imgs/destaque/01.jpg)">
				<div id="destaqueThumbs">
					<div class="selected"><a href="#"><img src="imgs/destaque/01_tb.jpg" /></a></div>
					<div><a href="#"><img src="imgs/destaque/02_tb.jpg" /></a></div>
					<div><a href="#"><img src="imgs/destaque/03_tb.jpg" /></a></div>
					<div><a href="#"><img src="imgs/destaque/04_tb.jpg" /></a></div>
				</div>

				<div id="destaqueInfo">
					<a href="noticia.html" style="background:url(imgs/bg_destaque_info.png);"><strong>Lorem ipsum dolor sit amet</strong> Existe uma grande chance de que você tenha estudado com algum retardado que disse isso ou mesmo que você próprio tenha dito…</a>
				</div>
				<div style="clear:both"></div>
			</div>
		</div>
		<img src="imgs/content_bot.png" align="top" />

		<!-- Conteúdo -->
		<img src="imgs/content_top.png" align="absbottom" />
		<div id="conteudo">
			<!-- Últimas Notícias -->
			<h2><b class="title">Últimas notícias</b></h2>
			<?php 
				if(is_array($aNoticias) && count($aNoticias)>0){
					foreach($aNoticias as $k => $v){ 
			?>
			<!-- Notícia -->
			<div id="newsItem">
				<div id="newsImg">
					<a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}"; ?>">
						<img src="<?php echo "{$linkAbsolute}posts/{$v['post_thumb_home']}"; ?>" width="150px" height="80px" alt="<?php echo $v['post_titulo']; ?>" />
					</a>
				</div>
				<div id="newsInfo">
					<h3>
						<a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}"; ?>">
							<?php echo $v['post_titulo']; ?>
						</a>
					</h3>
					<p class="data"><?php echo $v['post_dt_criacao']; ?></p>
					<p><?php echo $obj->cutHTML($v['post_conteudo'],130); ?></p>
					<p class="comments"><img src="imgs/icon_comentario.gif" align="absmiddle" /> <a href="#"><?php echo $v['qtdComentario']; ?> comentários</a></p>
				</div>
			</div>
			<?php 
					}
				}	
			?>
			<p class="paginacao">«<a href="#">Início</a> <a href="#">Anterior</a> <a href="#">1</a> <strong>2</strong> <a href="#">3</a> <a href="#">4</a>  <a href="#">5</a> <a href="#">Próximo</a> <a href="#">Fim</a>»</p>

			<!-- Top Análises -->
			<h2><b class="title">Top Análises</b></h2>
			<ul id="topAnalisesHome">
				<?php 
				if(is_array($aAnalises) && count($aAnalises)>0){
					foreach($aAnalises as $k => $v){ ?>
				<li>
					<!-- Análise -->
					<a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}"; ?>">
						<img src="<?php echo "{$linkAbsolute}posts/{$v['post_thumb_home']}"; ?>" width="150px" height="80px" alt="<?php echo $v['post_titulo']; ?>" />
					</a>
					<h4>
						<a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}"; ?>"><?php echo $v['post_titulo']; ?></a>
					</h4>
					<p class="data"><?php echo $v['qtdComentario']; ?> comentários</p>
				</li>
				<?php 
					} 
				}	
				?>
			</ul>

			<div style="clear:both"></div>

		</div>
		<img src="imgs/content_bot.png" align="top" />

	</div>
	<!-- Coluna Direita -->
	<div id="rightCol">

		<!-- Jogos indicados -->
		<img src="imgs/box_top.png" align="absbottom" />
		<div id="rightBox" class="indiecados">
			<h2><b class="title">Indiecamos</b></h2>
			<?php 
			if(is_array($aGame) && count($aGame)>0){
				foreach($aGame as $k => $v){ ?>
			<!-- item -->
			<div class="itemJogos">
				<div class="imgItemJogos">
					<a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}"; ?>">
						<img src="<?php echo "{$linkAbsolute}games/{$v['game_thumb']}"; ?>" width="60px" height="60px" alt="<?php echo $v['game_titulo']; ?>"/>
					</a>
				</div>
				<div>
					<a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}"; ?>">Nome do jogo</a><br />
					<?php echo $v['game_tipo_nome']; ?><br />
					<strong><?php echo $v['game_criador_nome']; ?></strong>
					<br />Jogado <?php echo $v['game_qtd_jogado']; ?> vezes
				</div>
			</div>
			<?php
				} 
			}
			?>
			<div style="clear:both"></div>

		</div>
		<img src="imgs/box_bot.png" align="top" style="clear:both" />

		<!-- Banner 300x250 -->
		<div id="sideBanner"><img src="banners/banner_300x250.jpg" /></div>

		<!-- Enquete -->
		<img src="imgs/box_top.png" align="absbottom" />
		<div id="rightBox" class="enquetes">
			<h2><b class="title">enquete</b></h2>
			<p><?php echo $aEnquete['enquete_titulo']; ?></p>
			<ul>
				<?php foreach($aEnqueteOpcao as $k => $v){ ?>
					<li><input type="radio" name="enquete" value="<?php echo $v['enquete_opcao_id']; ?>" /><?php echo $v['enquete_opcao_titulo']; ?></li>
				<?php } ?>
			</ul>
			<p><input type="image" src="imgs/bt_votar.gif" /></p>
			<br />
		</div>
		<img src="imgs/box_bot.png" align="top" style="clear:both" />

		<!-- Top artigos -->
		<img src="imgs/box_top.png" align="absbottom" />
		<div id="rightBox" class="topArtigos">
			<h2><b class="title">Top artigos</b></h2>
			<ul>
				<?php 
				if(is_array($aArtigo) && count($aArtigo)>0){
					foreach($aArtigo as $k => $v){ ?>
				<li>
					<a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}"; ?>">
						<?php echo $v['post_titulo']; ?>
					</a>
					<br />
					<span class="data"><?php echo $v['qtdComentario']; ?> comentários</span>
				</li>
				<?php
					} 
				}
				?>
			</ul>
		</div>
		<img src="imgs/box_bot.png" align="top" style="clear:both" />
	</div>
<?php include_once 'includes/footer.php'; ?>