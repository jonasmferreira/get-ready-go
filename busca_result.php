<?php
	include_once 'includes/cabecalho.php';
	include_once 'includes/header.php';
	require_once 'class/busca_result.class.php';
	
	$obj = new busca_result();
	$obj->setValues($_POST);
	$obj->setLimitMax(10);
	$obj->setLimitStart(0);
	$aBusca = $obj->getBusca();
	$totalBusca = $obj->getTotal();
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
			var action = $(".paginacao a.ativoPaginacao").attr('rel');
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
						'action':'busca',
						'limit':paginacao
					},
					success:function(resp){
						resp = resp.replace(/@LINKABSOLUTO@/g, '<?php echo $linkAbsolute;?>');
						$("#listagem_"+idAtivo).fadeOut('fast',function(){
							var count = parseInt(paginacao);
							var regTotal = $("#totalBusca").val();
							var regCountAtual = count+10;
							regCountAtual = (regCountAtual < regTotal)?regCountAtual:regTotal;
							$("#countBusca").html("Resultados "+(count+1)+" a "+regCountAtual+" de "+regTotal);
							
							pagePaginacao.fadeIn();
							$("#listagem").append(resp);
						});
					}
				});
			}else{
				$("#listagem_"+idAtivo).fadeOut('fast',function(){
					var count = parseInt(paginacao);
					var regTotal = $("#totalBusca").val();
					var regCountAtual = count+10;
					regCountAtual = (regCountAtual < regTotal)?regCountAtual:regTotal;
					$("#countBusca").html("Resultados "+(count+1)+" a "+regCountAtual+" de "+regTotal);
					pagePaginacao.fadeIn('slow');
				});
			}
		});
	});
</script>
<!-- Coluna Esquerda -->
<div id="leftCol">

	<!-- Conteúdo -->
	<img src="imgs/content_top.png" align="absbottom" />
	<div id="conteudo">
		<!-- Últimas Notícias -->
		<h2><b class="title">Resultado da Busca</b></h2>
		
		<div id="newsContent">

			<!-- Resultado da Busca -->
			<div class="newsHeader">
				<input type="hidden" id="totalBusca" value="<?=$totalBusca?>" />
				<h3>Resultado da busca por "<?=$_REQUEST['busca']?>"</h3>
				<p class="autor small" id="countBusca">Resultados 1 a 10 de <?=$totalBusca?></p>
			</div>
			<div id="listagem">
				<div id="listagem_0">
					<?	if(is_array($aBusca) && count($aBusca) > 0):?>
					<?		foreach($aBusca AS $v):?>
					<!-- Item -->
					<div id="itemBusca">
						<h3><a href="<?="{$linkAbsolute}{$v['linkDetalhe']}"; ?>"><?=$v['post_titulo']?></a></h3>
						<p class="data"><strong><?=$v['categoria_nome']?></strong> postado em <?=$v['post_dt_criacao']?></p>
						<p><?php echo $obj->cutHTML($v['post_conteudo'],150); ?></p>
					</div>
					<?		endforeach;?>
					<?	endif;?>
				</div>
			</div>
				
			<?php if($totalBusca>=10){ ?>
				<p class="paginacao">
					«<a href="javascript:void(0)" class="inicio">Início</a>
					<a href="javascript:void(0)" class="anterior">Anterior</a>
					<?php
						$porPage = 0;
						for($i=1;$i<=ceil($totalBusca/10);$i++):

						$displayNone = ($i<=5)?'':'displayNone';
						$actActive = ($i==1)?'ativoPaginacao':'';
					?>
						<a href="javascript:void(0)" id="limit_<?php echo $porPage ?>" class="paginacaoPage <?php echo "{$displayNone} {$actActive}"?>"><?php echo $i; ?></a>
					<?php
						$porPage += 10;
						endfor;
					?>

					<a href="javascript:void(0)" class="proximo">Próximo</a>
					<a href="javascript:void(0)" class="fim">Fim</a>
					»
				</p>
			<?php } ?>
		</div>

	</div>
	<img src="imgs/content_bot.png" align="top" />

</div>
<!-- Coluna Direita -->
<div id="rightCol">

	<!-- Banner 300x250 -->
	<div id="sideBanner"><img src="banners/banner_300x250.jpg" /></div>

	<!-- Top noticias -->
	<img src="imgs/box_top.png" align="absbottom" />
	<div id="rightBox" class="topNoticias">
		<h2><b class="title">Top notícias</b></h2>
		<div class="item">
			<div class="img"><a href="noticia.html"><img src="imgs/news/15.jpg" /></a></div>
			<div class="info"><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></div>
		</div>

		<div class="item">
			<div class="img"><a href="noticia.html"><img src="imgs/news/02.jpg" /></a></div>
			<div class="info"><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></div>
		</div>

		<div class="item">
			<div class="img"><a href="noticia.html"><img src="imgs/news/07.jpg" /></a></div>
			<div class="info"><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></div>
		</div>

		<div class="item">
			<div class="img"><a href="noticia.html"><img src="imgs/news/09.jpg" /></a></div>
			<div class="info"><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></div>
		</div>

		<div class="item">
			<div class="img"><a href="noticia.html"><img src="imgs/news/03.jpg" /></a></div>
			<div class="info"><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></div>
		</div>

		<div style="clear:both"></div>
	</div>
	<img src="imgs/box_bot.png" align="top" style="clear:both" />

	<!-- Top artigos -->
	<img src="imgs/box_top.png" align="absbottom" />
	<div id="rightBox" class="topArtigos">
		<h2><b class="title">Top artigos</b></h2>
		<ul>
			<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></li>
			<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></li>
			<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></li>
			<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></li>
			<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></li>
			<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></li>
			<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></li>
			<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></li>
		</ul>
	</div>
	<img src="imgs/box_bot.png" align="top" style="clear:both" />

	<!-- Top noticias -->
	<img src="imgs/box_top.png" align="absbottom" />
	<div id="rightBox" class="topNoticias">
		<h2><b class="title">Top análises</b></h2>
		<div class="item">
			<div class="img"><a href="noticia.html"><img src="imgs/news/12.jpg" /></a></div>
			<div class="info"><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></div>
		</div>

		<div class="item">
			<div class="img"><a href="noticia.html"><img src="imgs/news/10.jpg" /></a></div>
			<div class="info"><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></div>
		</div>

		<div class="item">
			<div class="img"><a href="noticia.html"><img src="imgs/news/01.jpg" /></a></div>
			<div class="info"><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></div>
		</div>

		<div class="item">
			<div class="img"><a href="noticia.html"><img src="imgs/news/08.jpg" /></a></div>
			<div class="info"><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></div>
		</div>

		<div class="item">
			<div class="img"><a href="noticia.html"><img src="imgs/news/04.jpg" /></a></div>
			<div class="info"><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></div>
		</div>

		<div style="clear:both"></div>
	</div>
	<img src="imgs/box_bot.png" align="top" style="clear:both" />

</div>
<?php	include_once 'includes/footer.php'; ?>