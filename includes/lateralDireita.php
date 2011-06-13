<?php
	require_once 'class/publicidade.class.php';

	$objPubl = new publicidade();
	$objPubl->setPublicidadeTipo('fullbanner');
	$aFullBanner = $objPubl->getPublicidadeByTipo();
	
	$objPubl->setPublicidadeTipo('bg banner');
	$aBgBanner = $objPubl->getPublicidadeByTipo();
	
	$objPubl->setPublicidadeTipo('banner lateral');
	$aSideBanner = $objPubl->getPublicidadeByTipo();
	
	$aTopNoticias = $obj->getTopPost(1);
	$aTopArtigos = $obj->getTopPost(2);
	$aTopAnalises = $obj->getTopPost(3);
	
?>
<div id="rightCol">
	<!-- Itens relacionados -->
	<?php if($aItensRelacionados!=null){ ?>
	<img src="<?php echo "{$linkAbsolute}"?>imgs/box_top.png" align="absbottom" />
	<div id="rightBox" class="topArtigos">
		<h2><b class="title">itens relacionados</b></h2>
		<?php if(is_array($aItensRelacionados) && count($aItensRelacionados)>0){ ?>
			<ul>
				<?php foreach($aItensRelacionados as $k => $v){ ?>
					<li>
						<a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}"; ?>">
							<?php echo $v['post_titulo']; ?>
						</a>
						<br />
						<span class="data"><?php echo $v['categoria_nome']; ?></span>
					</li>
				<?php } ?>
			</ul>
		<?php } ?>
	</div>
	<img src="<?php echo "{$linkAbsolute}"?>imgs/box_bot.png" align="top" style="clear:both" />
	<?php } ?>
	
	<?php if(is_array($aTopNoticias) && count($aTopNoticias)>0){ ?>
	<!-- Top noticias -->
	<img src="<?php echo "{$linkAbsolute}"?>imgs/box_top.png" align="absbottom" />
	<div id="rightBox" class="topNoticias">
		<h2><b class="title">Top notícias</b></h2>
			<?php foreach($aTopNoticias as $k => $v){ ?>
				<div class="item">
					<div class="img">
						<a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}"; ?>">
							<img src="<?php echo "{$linkAbsolute}posts/{$v['post_thumb_home']}"; ?>" alt="<?php echo $v['post_titulo']; ?>" />
						</a>
					</div>
					<div class="info">
						<a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}"; ?>">
							<?php echo $v['post_titulo']; ?>
						</a>
						<br />
						<span class="data"><?php echo $v['qtdComentario']; ?> comentários</span>
					</div>
				</div>
			<?php } ?>
		<div style="clear:both"></div>
	</div>
	<img src="<?php echo "{$linkAbsolute}"?>imgs/box_bot.png" align="top" style="clear:both" />
	<?php } ?>
	
	<? if(is_array($aSideBanner) && count($aSideBanner)>0){ ?>
		<!--img src="<?php //echo "{$linkAbsolute}"?>imgs/box_top.png" align="absbottom" /-->
		<!-- Banner 300x250 -->
		<div id="sideBanner">
			<!-- Publicidade - banner 728x90 -->
			<? 
				foreach($aSideBanner as $k => $v){
					$link = $v['publicidade_link'];
					$arq = $linkAbsolute . 'publicidade/' . $v['publicidade_arquivo'];
					$w = $v['publicidade_largura'];
					$h = $v['publicidade_altura'];

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
		<!--img src="<?php //echo "{$linkAbsolute}"?>imgs/box_bot.png" align="top" style="clear:both" /-->
	<? } ?>
	
	<?php if(is_array($aTopArtigos) && count($aTopArtigos)>0){ ?>
	<!-- Top artigos -->
	<img src="<?php echo "{$linkAbsolute}"?>imgs/box_top.png" align="absbottom" />
	<div id="rightBox" class="topArtigos">
		<h2><b class="title">Top artigos</b></h2>
			
		<ul>
			<?php foreach($aTopArtigos as $k => $v){ ?>
			<li>
				<a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}"; ?>"><?php echo $v['post_titulo']; ?></a><br /><span class="data"><?php echo $v['qtdComentario']; ?> comentários</span>
			</li>
			<?php } ?>
		</ul>
	</div>
	<img src="<?php echo "{$linkAbsolute}"?>imgs/box_bot.png" align="top" style="clear:both" />
	<?php } ?>
	
	<?php if(is_array($aTopAnalises) && count($aTopAnalises)>0){ ?>
	<!-- Top noticias -->
	<img src="<?php echo "{$linkAbsolute}"?>imgs/box_top.png" align="absbottom" />
	<div id="rightBox" class="topNoticias">
		<h2><b class="title">Top análises</b></h2>
		<?php foreach($aTopAnalises as $k => $v){ ?>
			<div class="item">
				<div class="img">
					<a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}"; ?>">
						<img src="<?php echo "{$linkAbsolute}posts/{$v['post_thumb_home']}"; ?>" alt="<?php echo $v['post_titulo']; ?>" />
					</a>
				</div>
				<div class="info">
					<a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}"; ?>">
						<?php echo $v['post_titulo']; ?>
					</a>
					<br />
					<span class="data"><?php echo $v['qtdComentario']; ?> comentários</span>
				</div>
			</div>
		<?php } ?>

		<div style="clear:both"></div>
	</div>
	<img src="<?php echo "{$linkAbsolute}"?>imgs/box_bot.png" align="top" style="clear:both" />
	<?php } ?>

</div>