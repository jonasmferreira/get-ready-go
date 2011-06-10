<?php
	include_once 'includes/cabecalho.php';
	include_once 'includes/header.php';
	require_once 'class/game.class.php';
	$obj = new game();
	$obj->setGame_id($_GET['game_id']);
	$aGame = $obj->getJogoDownload();
	//echo "<pre>".print_r($aGame,true)."</pre>";
?>
<script type="text/javascript" src="<?php echo $linkAbsolute ?>js/game.js"></script>
<input type="hidden" name="game_id" id="game_id" value="<?php echo $aGame['game_id'] ?>" />
<input type="hidden" name="pontuacao" id="pontuacao" value="<?php echo ($aGame['game_total_votacao']/$aGame['game_qtd_votacao']) ?>" />
<!-- Coluna Esquerda -->
<div id="leftCol">

	<!-- Conteúdo -->
	<img src="imgs/content_top.png" align="absbottom" />
	<div id="conteudo">
		<!-- nome da seção -->
		<h2><b class="title">para download</b></h2>

		<h1><?php echo $aGame['game_titulo'] ?></h1>
		<!-- Conteúdo do Artigo -->
		<div id="newsContent">
			<div class="newsHeader">
				<p class="data">Criado por</p>
				<div style="float:left; width:62px;">
					<?php if($v['usuario_avatar']==''){ ?>
						<img src="<?php echo $linkAbsolute ?>imgs/avatares/1.jpg" class="avatar" style="width:60px;border:1px solid #000;" />
					<?php }else{ ?>
					<a href="perfil.html">
						<img src="<?php echo "{$linkAbsolute}avatars/{$v['usuario_avatar']}" ?>" style="width:60px;border:1px solid #000;" />
					</a>
					<?php } ?>

				</div>
				<div style="float:left; margin:15px 5px 5px 5px">
					<h3>
						<?php if($aGame['game_criador_is_user']){ ?>
							<a href="perfil.html"><?php echo $aGame['game_criador_nome'] ?></a>
							<p><a href="busca.html">veja mais jogos desse autor</a></p>
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
	<img src="<?php echo "{$linkAbsolute}"?>imgs/content_bot.png" align="top" />

</div>
<!-- Coluna Direita -->
<div id="rightCol">
	<?php if(isset($_SESSION['GET_READY_GO_2011_SITE']['usuario_id']) && !empty($_SESSION['GET_READY_GO_2011_SITE']['usuario_id'])){ ?>
	<!-- Estatísticas -->
	<img src="<?php echo "{$linkAbsolute}"?>imgs/box_top.png" align="absbottom" />
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
				<td colspan="2" align="center">Baixado: <strong><?php echo $aGame['game_qtd_download'] ?></strong> <?php echo ($aGame['game_qtd_download']==1)?'vez':'vezes' ?></td>
			</tr>
		</table>
		<p align="center">
			<a href="<?php echo $aGame['game_link'] ?>" target="_blank" id="somaDownload">
				<img src="<?php echo "{$linkAbsolute}"?>imgs/bt_download.jpg" />
			</a>
		</p>
	</div>
	<img src="<?php echo "{$linkAbsolute}"?>imgs/box_bot.png" align="top" style="clear:both" />
	<?php } ?>

	<!-- Banner 300x250 -->
	<div id="sideBanner"><img src="<?php echo "{$linkAbsolute}"?>banners/banner_300x250.jpg" /></div>

</div>
<?php
	include_once 'includes/footer.php';
?>