<?php
	include_once 'includes/cabecalho.php';
	include_once 'includes/header.php';

	require_once "class/home.class.php";

	$obj = new home();
	$obj->setCategoria_id($_GET['categoria_id']);
	$obj->setLimitMax(15);
	$obj->setLimitStart(0);
	$aLista = $obj->getLastPost();

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
									'categoria_id':<?php echo $_GET['categoria_id']?>,
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
					$("#feedRss").click(function(e){
						e.preventDefault();
						window.location.href = $("#linkAbsolute").val()+"rss/rss_noticias";
					});
				});
			</script>
        	<!-- Coluna Esquerda -->
            <div id="leftCol">
            
                <!-- Conteúdo -->
                <img src="<?php echo "{$linkAbsolute}"?>imgs/content_top.png" align="absbottom" />
                <div id="conteudo">
					<!-- Últimas Notícias -->
					<h2><b class="title"><?php echo $aLista[0]['categoria_nome']; ?></b></h2>

                	<!-- Notícia -->
					<div id="listagem">
						<div id="listagem_0">
					<?php
						if(is_array($aLista) && count($aLista)>0){
							foreach($aLista as $k => $v){
					?>
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
									<p><?php echo preg_replace("/<img(.+?)>/",'',$obj->cutHTML($v['post_conteudo'],120)); ?></p>
									<p class="comments"><img src="<?php echo "{$linkAbsolute}"?>imgs/icon_comentario.gif" align="absmiddle" /> <a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}"; ?>"><?php echo $v['qtdComentario']; ?> comentários</a></p>
								</div>
							</div>
					<?php
							}
						}
					?>
						</div>
					</div>
					<?php if($obj->getTotal()>=15){ ?>
					<p class="paginacao">
						«<a href="javascript:void(0)" class="inicio">Início</a>
						<a href="javascript:void(0)" class="anterior">Anterior</a>
						<?php
							$porPage = 0;
							for($i=1;$i<=ceil($obj->getTotal()/15);$i++):
							
							$displayNone = ($i<=5)?'':'displayNone';
							$actActive = ($i==1)?'ativoPaginacao':'';
						?>
							<a href="javascript:void(0)" id="limit_<?php echo $porPage ?>" class="paginacaoPage <?php echo "{$displayNone} {$actActive}"?>"><?php echo $i; ?></a>
						<?php
							$porPage += 15;
							endfor;
						?>
						
						<a href="javascript:void(0)" class="proximo">Próximo</a>
						<a href="javascript:void(0)" class="fim">Fim</a>
						»
					</p>
					<?php } ?>
					<div style="clear:both"></div>
                </div>
                <img src="<?php echo "{$linkAbsolute}"?>imgs/content_bot.png" align="top" />
                 
            </div>
            <!-- Coluna Direita -->
           
<?php
	include_once 'includes/lateralDireita.php';
	include_once 'includes/footer.php';
?>