<?php
	include_once 'includes/cabecalho.php';
	include_once 'includes/header.php';
	require_once 'class/game.class.php';
	$obj = new game();
	$obj->setGame_id($_GET['game_id']);
	$aGame = $obj->getJogoDownload();
	$aVoted = $obj->isUserVoted();
	$obj->saveQtdJogado();
	$pont = 0;
	if($aGame['game_qtd_votacao']>0){
		$pont = ($aGame['game_total_votacao']/$aGame['game_qtd_votacao']);
	}
	//echo "<pre>".print_r($aGame,true)."</pre>";
?>

			<script type="text/javascript" src="<?php echo $linkAbsolute ?>js/game.js"></script>
			<?	if(is_array($aVoted)&&count($aVoted) >0):?>
			<script type="text/javascript">
				$(document).ready(function(){
					$.fn.raty.start(<?=$aVoted['valor_votacao']?>, '.avalia');
					$.fn.raty.readOnly(true, '.avalia');
				});
			</script>
			<?	endif;?>
			<?php if(!isset($_SESSION['GET_READY_GO_2011_SITE']['usuario_id']) && empty($_SESSION['GET_READY_GO_2011_SITE']['usuario_id'])): ?>
			<script type="text/javascript">
				$(document).ready(function(){
					$.fn.raty.readOnly(true, '.avalia');
				});
			</script>
			<?	endif;?>
			<input type="hidden" name="game_id" id="game_id" value="<?php echo $aGame['game_id'] ?>" />
			<input type="hidden" name="pontuacao" id="pontuacao" value="<?php echo ($pont) ?>" />
        	<!-- Jogo -->
            <img src="<?php echo $linkAbsolute ?>imgs/full_content_top.png" align="absbottom" />
            <div id="conteudo" class="gameArea">
				<!-- nome da seção -->
				<h2><b class="title">browser game</b></h2>
                   
            	<!-- Conteúdo do Artigo -->
                <h1><?php echo $aGame['game_titulo'] ?></h1>
                
                <!-- Área do jogo -->
                <div align="center">
					<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="<?php echo $aGame['game_width'] ?>px" height="<?php echo $aGame['game_height'] ?>px" border="0">
						<param name="allowScriptAccess" value="sameDomain"/>
						<param name="movie" value="<?php echo $aGame['game_link'] ?>"/>
						<embed src="<?php echo $aGame['game_link'] ?>" width="<?php echo $aGame['game_width'] ?>px" height="<?php echo $aGame['game_height'] ?>px" allowscriptaccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"/></embed>
					</object>
            	</div>
            
            </div>
            <img src="<?php echo $linkAbsolute ?>imgs/full_content_bot.png" align="absbottom" />
        
        	<!-- Coluna Esquerda -->
            <div id="leftCol">
            
                <!-- Conteúdo -->
                <img src="<?php echo $linkAbsolute ?>imgs/content_top.png" align="absbottom" />
                <div id="conteudo">
                   
                    <!-- Conteúdo do Artigo -->
                    
                    <div id="newsContent">

                    	<div class="newsHeader">
                        	<p class="data">Criado por</p>
                            <div style="float:left; width:62px;">
								<?php if($aGame['usuario_avatar']==''){ ?>
									<img src="<?php echo $linkAbsolute ?>imgs/avatares/1.jpg" class="avatar" style="width:60px;border:1px solid #000;" />
								<?php }else{ ?>
								<a href="<?php echo "{$linkAbsolute}perfil_usuario/{$aGame['usuario_id']}" ?>">
									<?php
										$file =  "{$linkAbsolute}imgs/avatares/1.jpg";
										if($aGame['game_criador_is_user']>0){
											if(@file_get_contents("{$linkAbsolute}avatars/{$aGame['usuario_avatar']}")==true){
												$file = "{$linkAbsolute}avatars/{$aGame['usuario_avatar']}";
											}else{
												$file = "{$linkAbsolute}avatar_user/{$aGame['usuario_avatar']}";
											}
										}
									?>
									<img src="<?php echo "$file" ?>" style="width:60px;border:1px solid #000;" />
								</a>
								<?php } ?>

							</div>
                            <div style="float:left; margin:15px 5px 5px 5px">
                            	<h3>
									<?php if($aGame['game_criador_is_user']){ ?>
										<a href="<?php echo "{$linkAbsolute}perfil_usuario/{$aGame['usuario_id']}" ?>"><?php echo $aGame['game_criador_nome'] ?></a>
										<!--p><a href="busca.html">veja mais jogos desse autor</a></p-->
									<?php }else{ ?>
										<?php echo $aGame['game_criador_nome'] ?>
									<?php } ?>
								</h3>
                            </div><div style="clear:both"></div>
                        </div>

                        <!-- Texto -->
						<?php echo $aGame['game_descricao'] ?>
                    
                    </div>
                    
                </div>
                <img src="<?php echo $linkAbsolute ?>imgs/content_bot.png" align="top" />
                 
            </div>
            <!-- Coluna Direita -->
            <div id="rightCol">

				<!-- Estatísticas -->
                <img src="<?php echo $linkAbsolute ?>imgs/box_top.png" align="absbottom" />
                <div id="rightBox" class="stats">
	                <h2><b class="title">Estatísticas</b></h2>
			        <table cellspacing="5" width="100%" border="0" cellpadding="0">
						<tr>
                    		<td align="center">
								Avaliação geral:<br />
								<div id="avaliado"></div>
							</td>
                        	<td align="center">Sua avaliação:<br />
                        		<div class="avalia"></div>
                        	</td>
                        </tr>
                        <tr>
		                	<td colspan="2" align="center">Jogado: <strong><?php echo $aGame['game_qtd_jogado'] ?></strong> <?php echo ($aGame['game_qtd_jogado']==1)?'vez':'vezes' ?></td>
                    	</tr>
                	</table>
                </div>
                <img src="<?php echo $linkAbsolute ?>imgs/box_bot.png" align="top" style="clear:both" />

            	<!-- Banner 300x250 -->
            	<div id="sideBanner"><img src="<?php echo $linkAbsolute ?>banners/banner_300x250.jpg" /></div>

            </div>
<?php
	include_once 'includes/footer.php';
?>