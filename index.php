<?php

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
	
	$aArtigo = $obj->getTopPost(2);

	$aAnalises = $obj->getTopPost(3);

	$obj->setLimitMax(null);
	$obj->setLimitStart(null);
	$obj->setCategoria_id(4);
	$aIndicados = $obj->getLastPost();

	$aGame = $obj->getGames();

	$aEnquete = $obj->getEnquete();
	$aEnqueteOpcao = $obj->opcaoEnquete($aEnquete['enquete_id']);
	//echo "<pre>".print_r($aEnqueteOpcao,true)."</pre>";

	//DESTAQUES ROTATIVOS (OUTDOOR)
	$aOutdoor = $obj->getOutdoorDestaque();
	$arrImg = array();
	$arrImgThum = array();
	$arrConteudo = array();
	$arrLink = array();
	$arrTitulo = array();
	foreach($aOutdoor AS $k=>$v){
		array_push($arrTitulo,substr($v['post_titulo'],0,50));
		array_push($arrImg,"{$linkAbsolute}posts/{$v['post_imagem']}");
		array_push($arrImgThum,"{$linkAbsolute}posts/{$v['post_thumb_imagem']}");
		array_push($arrConteudo,$v['post_conteudo']);
		array_push($arrLink,"{$linkAbsolute}{$v['linkDetalhe']}");
	}
	$_SESSION['arrConteudo'] = $arrConteudo;
?>
	<script type="text/javascript" src="<?php echo $linkAbsolute?>js/jquery.cycle.all.min.js"></script>
	<script type="text/javascript">
		var sImg = '<?=implode("|",$arrImg)?>';
		var sImgThum = '<?=implode("|",$arrImgThum)?>';
		var sLink = '<?=implode("|",$arrLink)?>';
		var sTitulo = '<?=implode("|",$arrTitulo)?>';
		
		var arrImg = sImg.split("|");
		var arrImgThum = sImgThum.split("|");
		var arrLink = sLink.split("|");
		var arrTitulo = sTitulo.split("|");
		var i = 0;
		function getConteudo(id){
			return $.ajax({
				'type':'POST',
				'async':false,
				'url':'<?php echo $linkAbsolute;?>ajax/ajaxPaginacao',
				'dataType':'html',
				'data':{
					'action':'getConteudoDestaque',
					'id':id
				}
			}).responseText;
		}
		function createThumbs(){
			var arrDestaqueThumbs = new Array();
			for(var j=0;j<arrImgThum.length;j++){
				arrDestaqueThumbs.push('<div id="destaqueThumbs_'+j+'" style="cursor:pointer;"><img src="'+arrImgThum[j]+'" /></div>');
			}
			jQuery("#destaqueThumbs").html(arrDestaqueThumbs.join("\n"));
			jQuery("#destaqueThumbs div:first").addClass('selected');
			jQuery("#container").css({
				'background':'url('+arrImg[0]+')'
			});
			jQuery("#destaqueInfo a").attr("href",arrLink[0]);
			jQuery("#destaqueInfo a").html('<strong>'+arrTitulo[0]+'</strong>'+getConteudo(0));
		}
		function createThumbsForPlugin(){
			var arrDestaqueThumbs = new Array();
			var arrDestaqueImg = new Array();
			for(var j=0;j<arrImgThum.length;j++){
				//arrDestaqueThumbs.push('<div id="destaqueThumbs_'+j+'" style="cursor:pointer;"><img src="'+arrImgThum[j]+'" /></div>');
				arrDestaqueImg.push('<img id="imagem_destaque_'+j+'" src="'+arrImg[j]+'" />');
			}
			//jQuery("#destaqueThumbs").html(arrDestaqueThumbs.join("\n"));
			jQuery("#container").html(arrDestaqueImg.join("\n"));
			jQuery("#destaqueThumbs div:first").addClass('selected');
			
			
			/*jQuery("#container").css({
				'background':'url('+arrImg[0]+')'
			});
			jQuery("#destaqueInfo a").attr("href",arrLink[0]);
			jQuery("#destaqueInfo a").html('<strong>'+arrTitulo[0]+'</strong>'+getConteudo(0));*/

		}
		function setThumb(id){
			jQuery("#destaqueThumbs_"+id).addClass('selected');
			/*jQuery("#container").css({
				'background':'url('+arrImg[id]+')'
			});*/
			$('#container')
				.animate({opacity: 0}, 'slow', function() {
					$(this)
						.css({'background-image': 'url('+arrImg[id]+')'})
						.animate({opacity: 1});
			});
			jQuery("#destaqueInfo a").attr("href",arrLink[id]);
			jQuery("#destaqueInfo a").html('<strong>'+arrTitulo[id]+'</strong>'+getConteudo(id));
		}
		function changeThumbs(){
			var id = jQuery("#destaqueThumbs div.selected").attr('id');
			jQuery("#destaqueThumbs div").removeClass('selected');
			id = id.split("_");
			id = ((id[1]*1)+1);
			id = (id>(arrImgThum.length -1))?'0':id;
			setThumb(id);
		}
		
		$(document).ready(function(){
			/*createThumbs();
			window.setInterval(function(){
				changeThumbs();
			}, 5000);*/
			createThumbsForPlugin();
			jQuery.fn.cycle.updateActivePagerLink = function(pager, currSlideIndex) {
				jQuery(pager).find('div').removeClass('selected');
				jQuery(pager).find('li:eq('+currSlideIndex+') div').addClass('selected');
			};
			$('#container').cycle({ 
				fx:     'scrollLeft' 
				/*,speed: 500*/
				,timeout:5000
				,cleartype:  true
				,cleartypeNoBg:  true
				,pause:   1
				,pager:  '#destaqueThumbs ul'
				,before:function(currSlideElement, nextSlideElement, options, forwardFlag){
					var imgId = nextSlideElement.id;
					imgId = imgId.toString();
					imgId = imgId.split("_");
					imgId = imgId[2];
					jQuery("#destaqueInfo a").attr("href",arrLink[imgId]);
					jQuery("#destaqueInfo a").html('<strong>'+arrTitulo[imgId]+'</strong>'+getConteudo(imgId));
				}
				,pagerAnchorBuilder: function(idx, slide) { 
					var img = arrImgThum[idx];
					return '<li style="list-style-type:none;width:100%;height:100%;"><div style="padding: 3px 12px 5px;"><a href="javascript:void(0)"><img src="' + img + '" /></a></div></li>'; 
				} 
			});
			
			/*$("#destaqueThumbs div").live("click",function(){
				jQuery("#destaqueThumbs div").removeClass('selected');
				var id = jQuery(this).attr('id');
				id = id.split("_");
				id = ((id[1]*1));
				setThumb(id);
			});*/
			$('.anterior').click(function(){
				if($(".paginacao a.ativoPaginacao").prev().html() != $(this).html()){
					$(".paginacao a.ativoPaginacao").prev().trigger("click");
				}
			});
			$('.proximo').click(function(){
				if($(".paginacao a.ativoPaginacao").next().html() != $(this).html()){
					$(".paginacao a.ativoPaginacao").next().trigger("click");
				}
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
			});
			$("#votar").click(function(){
			
				if($(".enquetes input:radio:checked").val()==undefined){
					alert("Escolha uma opção da enquete!")
					return false;
				}
				//console.log('ID_ENQUETE = ' + $("#enquete_id").val());
				$.ajax({
					'type':'POST',
					'async':false,
					'url':'<?php echo $linkAbsolute;?>ajax/home',
					'dataType':'json',
					'data':{
						'action':'addEnquete',
						'enquete_id':$("#enquete_id").val(),
						'opcao_voto':$(".enquetes input:radio:checked").val()
					},
					success:function(resp){
						alert(resp.message);
						$("#enquete_result").css('display', 'block');
						$("#enquete_question").css('display', 'none');
						$("#enquete_result ul").html(resp.result);
					}
				});
			});
			$("#feedRss").click(function(e){
				e.preventDefault();
				window.location.href = $("#linkAbsolute").val()+"rss/rss_destaque";
			});
			if ($.browser.msie && $.browser.version == 7) {
				$("#containerInfos").css({
					'top':'290px'
				});
				$("#destaqueThumbs").css({
					'display':"inline"
				});
				
			}
		});
	</script>
	<!-- Coluna Esquerda -->
	<div id="leftCol">

		<!-- Destaque rotativo -->
		<img src="<?php echo "{$linkAbsolute}"?>imgs/content_top.png" align="absbottom" />
		<div id="destaque" style="height:270px;">
			<!-- div id="container" style="background:url(<?php echo "{$linkAbsolute}"?>imgs/destaque/01.jpg)"></div -->
			<div id="container"></div>
			<div id="containerInfos" style="position:absolute;top:281px;z-index:10000">
				<div id="destaqueThumbs">
					<!--div><a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/destaque/01_tb.jpg" /></a></div>
					<div class="selected"><a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/destaque/02_tb.jpg" /></a></div>
					<div><a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/destaque/03_tb.jpg" /></a></div>
					<div><a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/destaque/04_tb.jpg" /></a></div -->
					<ul></ul>
				</div>
				<div id="destaqueInfo">
					<a href="noticia.html" style="background:url(<?php echo "{$linkAbsolute}"?>imgs/bg_destaque_info.png);">
						<strong></strong>
					</a>
				</div>
				<div style="clear:both"></div>
			</div>
		</div>
		<img src="<?php echo "{$linkAbsolute}"?>imgs/content_bot.png" align="top" />

		<!-- Conteúdo -->
		<img src="<?php echo "{$linkAbsolute}"?>imgs/content_top.png" align="absbottom" />
		<div id="conteudo">
			<!-- Últimas Notícias -->
			<h2><b class="title">Últimas notícias</b></h2>
			<div id="listagem" style="height:100%; overflow: hidden;">
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
					<p class="comments"><img src="<?php echo "{$linkAbsolute}"?>imgs/icon_comentario.gif" align="absmiddle" /> <a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}"; ?>#comentarios"><?php echo $v['qtdComentario']; ?> comentários</a></p>
				</div>
			</div>
			<div style="clear:both;"></div>
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
		<img src="<?php echo "{$linkAbsolute}"?>imgs/content_bot.png" align="top" />

	</div>
	<!-- Coluna Direita -->
	<div id="rightCol">

		<!-- Jogos indicados -->
		<img src="<?php echo "{$linkAbsolute}"?>imgs/box_top.png" align="absbottom" />
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
					<br /><?php echo ($v['game_categoria_id']==1)?"Baixado ".$v['game_qtd_download']:"Jogado ".$v['game_qtd_jogado']; ?> vezes
				</div>
			</div>
			<?php
				} 
			}
			?>
			<div style="clear:both"></div>

		</div>
		<img src="<?php echo "{$linkAbsolute}"?>imgs/box_bot.png" align="top" style="clear:both" />

		<? if(is_array($aSideBanner) && count($aSideBanner)>0){ ?>
			<!-- Banner 300x250 -->
			<div id="sideBanner">
				<!-- Publicidade - banner 728x90 -->
				<? 
					
					foreach($aSideBanner as $k => $v){
						$link = $v['publicidade_link'];
						$arq = $linkAbsolute . 'publicidade/' . $v['publicidade_arquivo'];
						$w = $v['publicidade_tipo_largura'];
						$h = $v['publicidade_tipo_altura'];

						if($v['publicidade_tipomedia']==0){ 
				?>
							<a href="<?=$link;?>" target="_blank"><img src="<?=$arq;?>" width="<?=$w;?>"  height="<?=$h;?>" /></a>			
				<?		} else { ?>
							<script type="text/javascript">buildFlash('<?=$arq;?>','<?=$w;?>','<?=$h;?>','opaque');</script> 
				<?		} 
					}
			?>
			<!--img src="banners/banner_300x250.jpg" /-->
			</div>
		<? } ?>
		<!-- Enquete -->
		<div id="enquete_question">
		<img src="<?php echo "{$linkAbsolute}"?>imgs/box_top.png" align="absbottom" />
		<div id="rightBox" class="enquetes">
			<h2><b class="title">enquete</b></h2>
			<p>
				<?php echo $aEnquete['enquete_titulo']; ?><input type="hidden" id="enquete_id" value="<?php echo $aEnquete['enquete_id']; ?>" />
			</p>
			<ul>
				<?php foreach($aEnqueteOpcao as $k => $v){ ?>
					<li><input type="radio" name="enquete" value="<?php echo $v['enquete_opcao_id']; ?>" /><?php echo $v['enquete_opcao_titulo']; ?></li>
				<?php } ?>
			</ul>
			<p><input type="image" src="<?php echo "{$linkAbsolute}"?>imgs/bt_votar.gif" id="votar" /></p>
			<br />
		</div>
		<img src="<?php echo "{$linkAbsolute}"?>imgs/box_bot.png" align="top" style="clear:both" />
		</div>
		
		<!-- Enquete - Resultado -->
		<div id="enquete_result" style="display:none;">
		<img src="<?php echo "{$linkAbsolute}"?>imgs/box_top.png" align="absbottom" />
		<div id="rightBox" class="enquetes">
			<h2><b class="title">enquete - resultado</b></h2>
			<p><?php echo $aEnquete['enquete_titulo']; ?></p><br />
			<ul>
				
			</ul>
			<br />
		</div>
		<img src="<?php echo "{$linkAbsolute}"?>imgs/box_bot.png" align="top" style="clear:both" />
		</div>
		
		<!-- Top artigos -->
		<img src="<?php echo "{$linkAbsolute}"?>imgs/box_top.png" align="absbottom" />
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
		<img src="<?php echo "{$linkAbsolute}"?>imgs/box_bot.png" align="top" style="clear:both" />
	</div>
<?php include_once 'includes/footer.php'; ?>