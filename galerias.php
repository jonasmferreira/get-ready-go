<?php
	include_once 'includes/cabecalho.php';
	include_once 'includes/header.php';
	require_once 'class/galeria.class.php';
	require_once 'class/noticia.class.php';

	$obj = new galeria();
	$obj->setPost_id($_GET['post_id']);
	$aFotos = $obj->getFotos($_GET['id_imagem']);

	$objNoticia = new noticia();
	$objNoticia->setPost_id($_GET['post_id']);
	$aNoticia = $objNoticia->getOne();
	$postTitulo = str_replace(' ', '+',$_GET['post_titulo']);

	//echo "<pre style='color:#fff'>".print_r($aFotos,true)."</pre>";
?>
	<script type="text/javascript">
		$(document).ready(function(){

			$(".semAcao").live('click',function(e){
				return false;
			})

			$(".anterior").bind('click',function(event){
				event.stopPropagation();
				var divAtual = $("#imgsGalerias").children().not(".displayNone");
				var anterior = divAtual.prev();
				if(anterior.html()!=null){
					divAtual.fadeOut('fast',function(){
						anterior.fadeIn();
						divAtual.addClass('displayNone');
						anterior.removeClass('displayNone');
						$('.qtdImage').text(parseInt($('.qtdImage:first').text())-1)
					});
				}
				$(this).unbind();
			});

			$(".proxima").bind('click',function(event){
				$(this).removeClass('proxima');
				event.stopPropagation();
				var divAtual = $("#imgsGalerias").children().not(".displayNone");
				var proxima = divAtual.next();
				if(proxima.html()!=null){
					divAtual.fadeOut('fast',function(){
						proxima.fadeIn();
						divAtual.addClass('displayNone');
						proxima.removeClass('displayNone');
						$('.qtdImage').text(parseInt($('.qtdImage:first').text())+1)
					});
				}
			});
			$(".prox").bind('click',function(event){
				$(this).stop(true,true);
				event.stopPropagation();
				var galeryAtive = $("#imageGalery > div.activeGalery");
				if(galeryAtive.next().html()!=null){
					galeryAtive.fadeOut('fast',function(){
						galeryAtive.removeClass('activeGalery');
						galeryAtive.next().fadeIn().addClass('activeGalery').removeClass('displayNone')
						var qtd1 = galeryAtive.attr("id").split("_").pop();
						var qtd2 = galeryAtive.next().attr("id").split("_").pop();
						$(".qtd1").text(parseInt($(".qtd1").text())+parseInt(qtd1));
						$(".qtd2").text(parseInt($(".qtd2").text())+parseInt(qtd2));
					});
				}
			});
			$(".ant").live('click',function(event){
				$(this).stop(true,true);
				event.stopPropagation();
				var galeryAtive = $("#imageGalery > div.activeGalery");
				if(galeryAtive.prev().html()!=null){
					galeryAtive.fadeOut('fast',function(){
						galeryAtive.removeClass('activeGalery');
						galeryAtive.prev().fadeIn().addClass('activeGalery').removeClass('displayNone');
						var qtd1 = galeryAtive.attr("id").split("_").pop();
						var qtd2 = galeryAtive.prev().attr("id").split("_").pop();
						$(".qtd1").text(parseInt($(".qtd1").text())-parseInt(qtd2));
						$(".qtd2").text(parseInt($(".qtd2").text())-parseInt(qtd1));
					});
				}
			});
			
		});
	</script>
	<!-- Coluna Esquerda -->
	<div id="leftCol">
		<!-- Conteúdo -->
		<img src="<?php echo "{$linkAbsolute}"?>imgs/content_top.png" align="absbottom" />
		<div id="conteudo">
			
			<h2><b class="title">Galeria</b></h2>
			<h3><?php echo $aNoticia['post_titulo'] ?></h3>

			<!-- Galeria -->
			<table width="100%">
				<tr>
					<td><a href="javascript:void(0)" class="anterior">◄ Anterior</a></td>
					<td align="center">Imagem <span class="qtdImage">1</span> de <?php echo count($aFotos)?></td>
					<td align="right"><a href="javascript:void(0)" class="proxima">Próxima ►</a></td>
				</tr>
			</table>
			<div id="imgsGalerias">
				<?php
					$i=1;
					foreach($aFotos as $k => $v){
						$displayNone = ($i==1)?'':'displayNone';
				?>
				<div class="imgGaleria <?=$displayNone?>" style="background-image:url(<?php echo "{$linkAbsolute}galerias/galeria_{$v['galeria_id']}/{$v['imagem_galeria_imagem']}"; ?>);">
					<img src="<?php echo "{$linkAbsolute}"?>imgs/image.png" />
				</div>
				<?php
						$i++;
					}
				?>
			</div>
			<table width="100%">
				<tr>
					<td><a href="javascript:void(0)" class="anterior">◄ Anterior</a></td>
					<td align="center">Imagem <span class="qtdImage">1</span> de <?php echo count($aFotos)?></td>
					<td align="right"><a href="javascript:void(0)" class="proxima">Próxima ►</a></td>
				</tr>
			</table>
			<br />

		</div>
		<img src="<?php echo "{$linkAbsolute}"?>imgs/content_bot.png" align="top" />

	</div>
	<!-- Coluna Direita -->
	<div id="rightCol">

		<!-- Thumbs -->
		<img src="<?php echo "{$linkAbsolute}"?>imgs/box_top.png" align="absbottom" />
		<div id="rightBox" class="thubsGaleria">
			<table width="100%">
				<tr>
					<td><a href="javascript:void(0)" class="ant">◄</a> <a href="javascript:void(0)" class="prox">►</a></td>
					<td align="right">Imagens <span class="qtd1">1</span> - <span class="qtd2"><?php echo (count($aFotos)>=9)?9:count($aFotos); ?></span> de <?php echo count($aFotos)?></td>
				</tr>
			</table>
			<div id="imageGalery">
				<?php
					$aFotosChuck = array_chunk($aFotos, 9);
					foreach($aFotosChuck as $key => $value){
						$displayNone = ($key==0)?'activeGalery':'displayNone';
				?>
					<div class="<?=$displayNone?>" id="qtd_<?php echo $key."_".count($value) ?>">
					<?php
						$i=0;
						foreach($value as $k=>$v){
					?>
						<a href="<?php echo "{$linkAbsolute}galeria/{$v['imagem_galeria_id']}/{$v['galeria_id']}/{$postTitulo}/{$_GET['post_id']}"; ?>" class="img">
							<img src="<?php echo "{$linkAbsolute}galerias/galeria_{$v['galeria_id']}/{$v['imagem_galeria_imagem']}"; ?>" />
						</a>
					<?php
						$i++;
						}
					?>
					</div>
				<?php	} ?>
			</div>
			<div style="clear:both"></div>
		</div>
		<img src="<?php echo "{$linkAbsolute}"?>imgs/box_bot.png" align="top" style="clear:both" />

		<!-- Banner 300x250 -->
		<div id="sideBanner"><img src="<?php echo "{$linkAbsolute}"?>banners/banner_300x250.jpg" /></div>


	</div>
<?php
	include_once 'includes/footer.php';
?>