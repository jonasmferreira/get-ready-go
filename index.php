<?php

	require_once 'class/publicidade.class.php';

	$objPubl = new publicidade();
	$objPubl->setPublicidadeTipo('fullbanner');
	$aFullBanner = $objPubl->getPublicidadeByTipo();
	
	$objPubl->setPublicidadeTipo('bg banner');
	$aBgBanner = $objPubl->getPublicidadeByTipo();
	
	$objPubl->setPublicidadeTipo('banner lateral');
	$aSideBanner = $objPubl->getPublicidadeByTipo();
	
	//echo "<pre>" . "raios == " . print_r($aFullBanner,true) . "</pre>";

	include_once 'includes/cabecalho.php';
	include_once 'includes/header.php';
	require_once 'class/home.class.php';
	
	$obj = new home();
	$obj->setLimitMax(12);
	$obj->setLimitStart(0);
	$obj->setCategoria_id(1);
	$aNoticias = $obj->getLastPost();
	$totalNoticia = $obj->getTotal();

	
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
	<script type="text/javascript">
		$(document).ready(function(){
			$('.anterior').click(function(){
				 $(".paginacao a.ativoPaginacao").prev().trigger("click");
			});
			$('.proximo').click(function(){
				$(".paginacao a.ativoPaginacao").next().trigger("click");
			});
			$('.inicio').click(function(){
				$(".paginacao a.paginacaoPage").fadeIn();
				$(".paginacao a.paginacaoPage").first().trigger("click");
			});
			$('.fim').click(function(){
				$(".paginacao a.paginacaoPage").fadeIn();
				$(".paginacao a.paginacaoPage").last().trigger("click");
			});
			$(".paginacaoPage:not(:.ativoPaginacao)").live('click',function(e){
				$(this).stop(true, true);
				var obj = $(this);
				var idAtivo = $(".paginacao a.ativoPaginacao").attr('id').split("_").pop();
				obj.next().fadeIn();
				$(".paginacao a").removeClass("ativoPaginacao");
				obj.addClass("ativoPaginacao");
				var paginacao = obj.context.id.split("_").pop();
				var pagePaginacao = $("#listagem_"+""+paginacao);
				if(pagePaginacao.html()==null){
					$.ajax({
						'type':'POST',
						'async':false,
						'url':'<?php echo $linkAbsolute;?>ajax/ajaxPaginacao',
						'dataType':'html',
						'data':{
							'action':'listagem',
							'categoria_id':1,
							'limit':paginacao
						},
						success:function(resp){
							resp = resp.replace(/@LINKABSOLUTO@/g, '<?php echo $linkAbsolute;?>');
							$("#listagem_"+idAtivo).fadeOut('fast',function(){
								pagePaginacao.fadeIn();
								$("#listagem").append(resp);
							});
						}
					});
				}else{
					$("#listagem_"+idAtivo).fadeOut('fast',function(){
						pagePaginacao.fadeIn('slow');
					});
				}
			})
		});
	</script>
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
			<div id="listagem">
				<div id="listagem_0">
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
					<p><?php echo $obj->cutHTML($v['post_conteudo'],150); ?></p>
					<p class="comments"><img src="imgs/icon_comentario.gif" align="absmiddle" /> <a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}"; ?>#comentarios"><?php echo $v['qtdComentario']; ?> comentários</a></p>
				</div>
			</div>
			<?php 
					}
				}
			?>
				</div>
			</div>
			<?php if($totalNoticia>=12){ ?>
				<p class="paginacao">
					«<a href="javascript:void(0)" class="inicio">Início</a>
					<a href="javascript:void(0)" class="anterior">Anterior</a>
					<?php
						$porPage = 0;
						for($i=1;$i<=ceil($totalNoticia/12);$i++):

						$displayNone = ($i<=5)?'':'displayNone';
						$actActive = ($i==1)?'ativoPaginacao':'';
					?>
						<a href="javascript:void(0)" id="limit_<?php echo $porPage ?>" class="paginacaoPage <?php echo "{$displayNone} {$actActive}"?>"><?php echo $i; ?></a>
					<?php
						$porPage += 12;
						endfor;
					?>

					<a href="javascript:void(0)" class="proximo">Próximo</a>
					<a href="javascript:void(0)" class="fim">Fim</a>
					»
				</p>
			<?php } ?>

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
			<h2><b class="title">Indicamos</b></h2>
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
					<a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}"; ?>"><?php echo $v['game_titulo']; ?></a><br />
					<?php echo $v['game_tipo_nome']; ?> - <?php echo $v['game_categoria_nome']; ?><br />
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