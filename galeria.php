<?php
	include_once 'includes/cabecalho.php';
	include_once 'includes/header.php';
?>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".anterior").click(function(){
				var divAtual = $("#imgsGalerias").children().not(".displayNone");
				var anterior = divAtual.prev();
				if(anterior.html()!=null){
					divAtual.fadeOut(function(){
						anterior.fadeIn();
						divAtual.addClass('displayNone');
						anterior.removeClass('displayNone');
						$('.qtdImage').text(parseInt($('.qtdImage').text())-1)
					});
				}
			});
			$(".proxima").click(function(){
				var divAtual = $("#imgsGalerias").children().not(".displayNone");
				var proxima = divAtual.next();
				if(proxima.html()!=null){
					divAtual.fadeOut(function(){
						proxima.fadeIn();
						divAtual.addClass('displayNone');
						proxima.removeClass('displayNone');
						$('.qtdImage').text(parseInt($('.qtdImage').text())+1)
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
			
			<h2><b class="title">Galeria</b></h2>
			<h3>Batman: Arkham City</h3>

			<!-- Galeria -->
			<table width="100%">
				<tr>
					<td><a href="#">◄ Anterior</a></td>
					<td align="center">Imagem 1 de 50</td>
					<td align="right"><a href="#">Próxima ►</a></td>
				</tr>
			</table>
			<div id="imgsGalerias">
				<?php
					for($i=1;$i<=4;$i++):
					$displayNone = ($i==1)?'':'displayNone';
				?>
				<div class="imgGaleria <?=$displayNone?>" style="background-image:url(imgs/galerias/jogo1_0<?=$i?>.jpg);">
					<img src="imgs/image.png" />
				</div>
				<?php
					$totalImagem++;
					endfor;
				?>
			</div>
			<table width="100%">
				<tr>
					<td><a href="javascript:void(0)" class="anterior">◄ Anterior</a></td>
					<td align="center">Imagem <span class="qtdImage">1</span> de <?=$totalImagem?></td>
					<td align="right"><a href="javascript:void(0)" class="proxima">Próxima ►</a></td>
				</tr>
			</table>
			<br />

		</div>
		<img src="imgs/content_bot.png" align="top" />

	</div>
	<!-- Coluna Direita -->
	<div id="rightCol">

		<!-- Thumbs -->
		<img src="imgs/box_top.png" align="absbottom" />
		<div id="rightBox" class="thubsGaleria">
			<table width="100%">
				<tr>
					<td><a href="#">◄</a> <a href="#">►</a></td>
					<td align="right">Imagens 1-9 de 50</td>
				</tr>
			</table>
			<a href="galeria.html" class="img"><img src="imgs/galerias/jogo1_01.jpg" /></a>
			<a href="galeria.html" class="img"><img src="imgs/galerias/jogo1_02.jpg" /></a>
			<a href="galeria.html" class="img"><img src="imgs/galerias/jogo1_03.jpg" /></a>
			<a href="galeria.html" class="img"><img src="imgs/galerias/jogo1_04.jpg" /></a>
			<a href="galeria.html" class="img"><img src="imgs/galerias/jogo1_01.jpg" /></a>
			<a href="galeria.html" class="img"><img src="imgs/galerias/jogo1_02.jpg" /></a>
			<a href="galeria.html" class="img"><img src="imgs/galerias/jogo1_03.jpg" /></a>
			<a href="galeria.html" class="img"><img src="imgs/galerias/jogo1_04.jpg" /></a>
			<a href="galeria.html" class="img"><img src="imgs/galerias/jogo1_01.jpg" /></a>
			<div style="clear:both"></div>
		</div>
		<img src="imgs/box_bot.png" align="top" style="clear:both" />

		<!-- Banner 300x250 -->
		<div id="sideBanner"><img src="banners/banner_300x250.jpg" /></div>


	</div>
<?php
	include_once 'includes/footer.php';
?>