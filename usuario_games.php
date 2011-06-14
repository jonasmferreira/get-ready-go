<?php
	include_once 'includes/cabecalho.php';
	include_once 'includes/header.php';
	require_once 'class/busca_result.class.php';

	require_once "class/home.class.php";

	$obj = new home();
	$obj->setCategoria_id($_GET['categoria_id']);
	$obj->setLimitMax(15);
	$obj->setLimitStart(0);
	$aLista = $obj->getLastPost();
	
	$obj = new busca_result();
	$obj->setValues($_GET);
	$obj->setLimitMax(10);
	$obj->setLimitStart(0);
	$aBusca = $obj->getBuscaGamesUser();
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
						'action':'games_user',
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
	<img src="<?php echo $linkAbsolute ?>imgs/content_top.png" align="absbottom" />
	<div id="conteudo">
		<!-- Últimas Notícias -->
		<h2><b class="title">Resultado da Busca</b></h2>
		
		<div id="newsContent">

			<!-- Resultado da Busca -->
			<div class="newsHeader">
				<input type="hidden" id="totalBusca" value="<?=$totalBusca?>" />
				<h3>Resultado da busca pelo usuario "<?=$_REQUEST['usuario_nome']?>"</h3>
				<p class="autor small" id="countBusca">Resultados 1 a 10 de <?=$totalBusca?></p>
			</div>
			<div id="listagem">
				<div id="listagem_0">
					<?	if(is_array($aBusca) && count($aBusca) > 0):?>
					<?		foreach($aBusca AS $v):?>
					<!-- Item -->
					<div id="itemBusca">
						<h3><a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}"; ?>"><?php echo $v['game_titulo']; ?></a></h3>
						<p class="data"><strong><?php echo $v['game_tipo_nome']; ?> - <?php echo $v['game_categoria_nome']; ?></strong></p>
						<p><?php echo preg_replace("/<img(.+?)>/",'',$obj->cutHTML($v['game_descricao'],150)); ?></p>
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
	<img src="<?php echo $linkAbsolute ?>imgs/content_bot.png" align="top" />

</div>
            <!-- Coluna Direita -->
           
<?php
	include_once 'includes/lateralDireita.php';
	include_once 'includes/footer.php';
?>

			