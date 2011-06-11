<?php
	include_once 'includes/cabecalho.php';
	require_once 'class/meu_perfil.class.php';

	$obj = new meu_perfil();
	$aAvatares = $obj->getAvatares();
	$aAvataresChuck = array_chunk($aAvatares, 4);
?>
	<body>			
		<h2><b class="title">Escolha um avatar</b></h2>
		<table cellspacing="5" cellpadding="5">
			<?php foreach($aAvataresChuck as $key => $value){ ?>
			<tr>
				<?php foreach($value as $k => $v){ ?>
				<td style="border:1px solid #000;">
					<img src="<?php echo $linkAbsolute ?>avatar_user/<?php echo $v['avatar_imagem'] ?>" style="border:3px solid transparent" class="imagem" id="<?php echo $v['avatar_imagem'] ?>" /><br />
					<div style="margin-top: 5px;text-align:center;">
						<input type="button" class="selectAvatar" style="background: #cb3f1e;color:#FFF;border:1px solid #cb3f1e;cursor: pointer;" value="Confirmar" disabled="disabled" />
					</div>
				</td>
				<?php } ?>
			</tr>
			<?php } ?>
		</table>
	</body>
</html>