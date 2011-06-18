<?php
	include_once 'includes/cabecalho.php';
	include_once 'includes/header.php';
	
	require_once "class/game.class.php";

	$obj = new game();
	$aGameMaisJogado = $obj->getJogoMaisJogado();
	$aGamePopular = $obj->getPopulares();
	$aGameVotado = $obj->getMaisVotados();
	$obj->setLimitMax(24);
	$obj->setLimitStart(0);
	$aGames = $obj->getGames();
	$totalGame = $obj->getTotal();
	$aGamesChuck = array_chunk($aGames, 2);
	$pont=0;
	if($aGameMaisJogado['game_qtd_votacao']>0){
		$pont = ($aGameMaisJogado['game_total_votacao']/$aGameMaisJogado['game_qtd_votacao']);
	}
	//echo "<pre>".print_r($aGamesChuck,true)."</pre>";
?>
			<script type="text/javascript">
				$(document).ready(function(){
					$('.avalia').raty({
						half: true,
						path:$("#linkAbsolute").val()+"js/img",
						start: <?=$pont?>,
						readOnly:  true
					});
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
									'action':'jogos',
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
						window.location.href = $("#linkAbsolute").val()+"rss/rss_indicamos";
					});
				});
			</script>
			
			<!-- Coluna Esquerda -->
            <div id="leftCol">
            
                <!-- Conteúdo -->
                <img src="<?php echo $linkAbsolute ?>imgs/content_top.png" align="absbottom" />
                <div id="conteudo">
					<!-- Mais Jogado -->
					<h2><b class="title">Mais Jogado</b></h2>
                    
                    <!-- Jogo mais popular (maior número de visualizações no mês) -->
                    <div id="mostPlayed">
                    	<div id="gameImg">
							<a href="<?php echo "{$linkAbsolute}{$aGameMaisJogado['linkDetalhe']}" ?>">
								<img src="<?php echo "{$linkAbsolute}games/{$aGameMaisJogado['game_imagem_destaque']}" ?>" />
							</a>
						</div>
                        <div id="gameInfo">
							<p class="data">Para Download</p>
                        	<h3>
								<a href="<?php echo "{$linkAbsolute}{$aGameMaisJogado['linkDetalhe']}" ?>"><?php echo "{$aGameMaisJogado['game_titulo']}" ?></a>
							</h3>
                            <div class="avalia"></div>
							<p class="data">Jogado <?php echo "{$aGameMaisJogado['game_qtd_jogado']}" ?> vezes</p>
                            <p class="autor">
                            	Criado por<br />
								
								<?php
									$file =  "{$linkAbsolute}imgs/avatares/1.jpg";
									if($aGameMaisJogado['game_criador_is_user']){
										if(@file_get_contents("{$linkAbsolute}avatars/{$aGameMaisJogado['usuario_avatar']}")==true){
											$file = "{$linkAbsolute}avatars/{$aGameMaisJogado['usuario_avatar']}";
										}else{
											$file = "{$linkAbsolute}avatar_user/{$aGameMaisJogado['usuario_avatar']}";
										}
									}
								?>
								<img src="<?php echo $file ?>" align="absmiddle" />
								<?php if($aGameMaisJogado['game_criador_is_user']!=0){ ?>
								
								<a href="<?php echo "{$linkAbsolute}perfil_usuario/{$aGameMaisJogado['game_criador_is_user']}"; ?>">
									<strong><?php echo "{$aGameMaisJogado['game_criador_nome']}" ?></strong>
								</a>
								<?php }else{ ?>
								<?php echo "{$aGameMaisJogado['game_criador_nome']}" ?>
								<?php } ?>
                            </p>
                        </div>
                    </div>
					<div style="clear:both"></div>
					<!-- Últimos jogos -->
                    <?php if(is_array($aGameVotado) && count($aGameVotado)>0){ ?>
                    <div id="twoCol">
                    	<h2><b class="title">mais votados</b></h2>

	                    <?php foreach($aGameVotado as $k => $v){  ?>
	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos">
								<a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}" ?>">
									<img src="<?php echo "{$linkAbsolute}games/{$v['game_thumb']}" ?>" />
								</a>
							</div>
            	            <div>
								<a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}"; ?>"><?php echo $v['game_titulo']; ?></a>
								<br /><?php echo $v['game_tipo_nome']; ?> - <?php echo $v['game_categoria_nome']; ?>
								<br /><strong><?php echo $v['game_criador_nome']; ?></strong>
								<br /><?php echo ($v['game_categoria_id']==1)?"Baixado ".$v['game_qtd_download']:"Jogado ".$v['game_qtd_jogado']; ?> vezes
							</div>
                	    </div>    
						<?php } ?>                
                    </div>
					<?php } ?>
					<?php if(is_array($aGamePopular) && count($aGamePopular)>0){ ?>
                    <div id="twoCol">
                    	<h2><b class="title">Populares</b></h2>
						<?php foreach($aGamePopular as $k => $v){  ?>
	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos">
								<a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}" ?>">
									<img src="<?php echo "{$linkAbsolute}games/{$v['game_thumb']}" ?>" />
								</a>
							</div>
            	            <div>
								<a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}"; ?>"><?php echo $v['game_titulo']; ?></a>
								<br /><?php echo $v['game_tipo_nome']; ?> - <?php echo $v['game_categoria_nome']; ?>
								<br /><strong><?php echo $v['game_criador_nome']; ?></strong>
								<br /><?php echo ($v['game_categoria_id']==1)?"Baixado ".$v['game_qtd_download']:"Jogado ".$v['game_qtd_jogado']; ?> vezes
							</div>
                	    </div>    
						<?php } ?>
                    </div>
					<?php } ?>
                    <div style="clear:both"></div>
                
                </div>
                <img src="<?php echo "{$linkAbsolute}"?>imgs/content_bot.png" align="top" />

                <!-- Conteúdo -->
                <img src="<?php echo "{$linkAbsolute}"?>imgs/content_top.png" align="absbottom" />
                <div id="conteudo">
					<h2><b class="title">últimos</b></h2>
					<div id="listagem" style="height:650px; overflow: visible;">
						<div id="listagem_0">
							<?php
								if(is_array($aGames) && count($aGames)>0){
									foreach($aGamesChuck as $key => $value){
							?>
							<table id="twoCol" style="width: 100%!important;">
								<tr>
									<?php	foreach($value as $k => $v){ ?>
									<td style="width: 50%!important;">
										 <div class="itemJogos">
											<div class="imgItemJogos">
												<a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}" ?>">
													<img src="<?php echo "{$linkAbsolute}games/{$v['game_thumb']}" ?>" />
												</a>
												<div style="clear:both;"></div>
											</div>
											<div>
												<a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}"; ?>"><?php echo $v['game_titulo']; ?></a>
												<br /><?php echo $v['game_tipo_nome']; ?> - <?php echo $v['game_categoria_nome']; ?>
												<br /><strong><?php echo $v['game_criador_nome']; ?></strong>
												<br /><?php echo ($v['game_categoria_id']==1)?"Baixado ".$v['game_qtd_download']:"Jogado ".$v['game_qtd_jogado']; ?> vezes
											</div>
										</div>
										<div style="clear:both;"></div>
									</td>
									<?php } ?>
								</tr>
							</table>
							<?php
									}
								}
							?>
							<div style="clear:both;"></div>
						</div>
					</div>
					<?php if($totalGame>=24){ ?>
						<p class="paginacao">
							«<a href="javascript:void(0)" class="inicio">Início</a>
							<a href="javascript:void(0)" class="anterior">Anterior</a>
							<?php
								$porPage = 0;
								for($i=1;$i<=ceil($totalGame/24);$i++):

								$displayNone = ($i<=5)?'':'displayNone';
								$actActive = ($i==1)?'ativoPaginacao':'';
							?>
								<a href="javascript:void(0)" id="limit_<?php echo $porPage ?>" class="paginacaoPage <?php echo "{$displayNone} {$actActive}"?>"><?php echo $i; ?></a>
							<?php
								$porPage += 24;
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

			