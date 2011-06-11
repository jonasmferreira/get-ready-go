<?php
	include_once 'includes/cabecalho.php';
	include_once 'includes/header2.php';
	$aMeses = array(
		"01"=>"Janeiro",
		"02"=>"Fevereiro",
		"03"=>"Março",
		"04"=>"Abril",
		"05"=>"Maio",
		"06"=>"Junho",
		"07"=>"Julho",
		"08"=>"Agosto",
		"09"=>"Setembro",
		"10"=>"Outubro",
		"11"=>"Novembro",
		"12"=>"Dezembro"
	);
?>
<?php if(!isset($_SESSION['GET_READY_GO_2011_SITE']['usuario_id']) && empty($_SESSION['GET_READY_GO_2011_SITE']['usuario_id']) ){ ?>
<script type="text/javascript">
	alert("Você não está Logado!");
	window.location.href = '<?php echo $linkAbsolute ?>';
</script>
<?php } ?>
<img src="<?php echo $linkAbsolute ?>imgs/content_top.png" align="absbottom" style="display:block; margin:auto" />
<div id="conteudo" class="sistema">
	<!-- nome da seção -->
	<h2><b class="title">Meu perfil</b></h2>

	<div id="perfil">
		<div id="imgPerfil">
			<?php if($_SESSION['GET_READY_GO_2011_SITE']['usuario_avatar']==''){ ?>
			<img src="<?php echo $linkAbsolute ?>imgs/avatares/1.jpg" class="avatar" />
			<?php }else{ ?>
			<img src="<?php echo "{$linkAbsolute}avatars/{$_SESSION['GET_READY_GO_2011_SITE']['usuario_avatar']}" ?>" class="avatar" width="140px" height="140px" />
			<?php } ?><!-- usuário começa com imagem padrão -->
			<p><a href="javascript:popUp('listaavatares.php','Avatar',300,300,false);">Alterar avatar</a></p>
		</div>

		<div id="infoPerfil">
			<h1><?php echo $_SESSION['GET_READY_GO_2011_SITE']['usuario_nome'] ?></h1>
			<p class="data">cadastrado em 21.11.2010</p>
			<table>
				<tr>
					<td>Nome:</td>
					<td><input type="text" class="text" size="40" value="<?php echo $_SESSION['GET_READY_GO_2011_SITE']['usuario_nome'] ?>" /></td>
				</tr>
				<tr>
					<td>E-mail:</td>
					<td><input type="text" class="text" size="40" value="<?php echo $_SESSION['GET_READY_GO_2011_SITE']['usuario_email'] ?>" /></td>
				</tr>
				<tr>
					<td>País:</td>
					<td><input type="text" class="text" size="40" value="Brasil" /></td>
				</tr>
				<tr>
					<td>Cidade:</td>
					<td><input type="text" class="text" size="40" value="São Paulo" /></td>
				</tr>
				<tr>
					<td>Data de nascimento:</td>
					<td>
						<select name="dia">
							<?php
								for($i=1;$i<=31;$i++):
									$dia = ($i<=9)?"0{$i}":$i;
							?>
							<option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
							<?php endfor; ?>
						</select>
						<select id="mes">
							<?php foreach($aMeses as $k => $v): ?>
							<option value="<?php echo $v; ?>"><?php echo $v; ?></option>
							<?php endforeach; ?>
						</select>
						<select id="ano">
							<?php for($i=1900;$i<=date("Y");$i++): ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
							<?php endfor; ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Sexo:</td>
					<td>
						<select>
							<option>Masculino</option>
							<option>Feminino</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input type="image" src="<?php echo $linkAbsolute ?>imgs/bt_enviar.gif" /></td>
				</tr>
			</table>
		</div>
		<div style="clear:both"></div>
	</div>

</div>
<img src="<?php echo $linkAbsolute ?>imgs/content_bot.png" align="top"  style="display:block; margin:auto; clear:both" />
<?php
	include_once 'includes/footer2.php';
?>