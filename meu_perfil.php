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
	$dataNascimento = explode('-',$_SESSION['GET_READY_GO_2011_SITE']['usuario_birthdate']);
	$diaSelect = $dataNascimento[2];
	$mes = $dataNascimento[1];
	$ano = $dataNascimento[0];
?>
<?php if(!isset($_SESSION['GET_READY_GO_2011_SITE']['usuario_id']) && empty($_SESSION['GET_READY_GO_2011_SITE']['usuario_id']) ){ ?>
<script type="text/javascript">
	alert("Você não está Logado!");
	window.location.href = '<?php echo $linkAbsolute ?>';
</script>
<?php } ?>
<script type="text/javascript" src="<?php echo $linkAbsolute?>js/meu_perfil.js"></script>
<img src="<?php echo $linkAbsolute ?>imgs/content_top.png" align="absbottom" style="display:block; margin:auto" />
<div id="conteudo" class="sistema">
	<!-- nome da seção -->
	<h2><b class="title">Meu perfil</b></h2>
	<form action="" name="form_save" id="form_save" />
		
		<div id="perfil">
			<div id="imgPerfil">
				<?php if($_SESSION['GET_READY_GO_2011_SITE']['usuario_avatar']==''){ ?>
				<img src="<?php echo $linkAbsolute ?>imgs/avatares/1.jpg" class="avatar" />
				<?php }else{ ?>
				<?php
					if(@file_get_contents("{$linkAbsolute}avatars/{$_SESSION['GET_READY_GO_2011_SITE']['usuario_avatar']}")==true){
						$file = "{$linkAbsolute}avatars/{$_SESSION['GET_READY_GO_2011_SITE']['usuario_avatar']}";
					}else{
						$file = "{$linkAbsolute}avatar_user/{$_SESSION['GET_READY_GO_2011_SITE']['usuario_avatar']}";
					}
				?>
				<img src="<?php echo "{$file}" ?>" class="avatar" width="140px" height="140px" />
				<?php } ?><!-- usuário começa com imagem padrão -->
				<p><a href="<?php echo $linkAbsolute ?>alterarfoto" id="newAvatar" title="Alterar avatar">Alterar avatar</a></p>
			</div>
			<div id="infoPerfil">
				<h1><?php echo $_SESSION['GET_READY_GO_2011_SITE']['usuario_nome'] ?></h1>
				<div id="respostacadastra_usuario"></div>
				<p class="data">cadastrado em 21.11.2010</p>
				<table>
					<tr>
						<td>Nome:</td>
						<td><input type="text" class="text" size="40" value="<?php echo $_SESSION['GET_READY_GO_2011_SITE']['usuario_nome'] ?>" id="nome" /></td>
					</tr>
					<tr>
						<td>E-mail:</td>
						<td><input type="text" class="text" size="40" value="<?php echo $_SESSION['GET_READY_GO_2011_SITE']['usuario_email'] ?>" id="email" /></td>
					</tr>
					<tr>
						<td>País:</td>
						<td><input type="text" class="text" size="40" value="<?php echo $_SESSION['GET_READY_GO_2011_SITE']['usuario_country'] ?>" id="pais" /></td>
					</tr>
					<tr>
						<td>Cidade:</td>
						<td><input type="text" class="text" size="40" value="<?php echo $_SESSION['GET_READY_GO_2011_SITE']['usuario_city'] ?>" id="cidade" /></td>
					</tr>
					<tr>
						<td>Data de nascimento:</td>
						<td>
							<select name="dia" id="dia">
								<?php
									for($i=1;$i<=31;$i++):
										$dia = ($i<=9)?"0{$i}":$i;
								?>
								<option value="<?php echo $dia; ?>" <?php echo ($diaSelect==$dia)?'selected="selected"':'' ?>><?php echo $dia; ?></option>
								<?php endfor; ?>
							</select>
							<select id="mes" id="mes">
								<?php foreach($aMeses as $k => $v): ?>
								<option value="<?php echo $k; ?>" <?php echo ($mes==$k)?'selected="selected"':'' ?>><?php echo $v; ?></option>
								<?php endforeach; ?>
							</select>
							<select id="ano" id="ano">
								<?php for($i=1900;$i<=date("Y");$i++): ?>
									<option value="<?php echo $i; ?>" <?php echo ($ano==$i)?'selected="selected"':'' ?>><?php echo $i; ?></option>
								<?php endfor; ?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Sexo:</td>
						<td>
							<select id="sexo">
								<option value="M" <?php echo ($_SESSION['GET_READY_GO_2011_SITE']['usuario_gender']=="M")?'selected="selected"':'' ?>>Masculino</option>
								<option value="F" <?php echo ($_SESSION['GET_READY_GO_2011_SITE']['usuario_gender']=="F")?'selected="selected"':'' ?>>Feminino</option>
							</select>
						</td>
					</tr>
					<tr>
						<td valign="top">Sobre:</td>
						<td align="left">
							<textarea cols="31" rows="4" id="meuperfil" name="meuperfil"><?php echo (trim($_SESSION['GET_READY_GO_2011_SITE']['usuario_perfil'])!="")?"{$_SESSION['GET_READY_GO_2011_SITE']['usuario_perfil']}":''; ?></textarea>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type="image" src="<?php echo $linkAbsolute ?>imgs/bt_enviar.gif" id="salvar" /></td>
					</tr>
				</table>
			</div>
			<div style="clear:both"></div>
		</div>
	</form>

</div>
<img src="<?php echo $linkAbsolute ?>imgs/content_bot.png" align="top"  style="display:block; margin:auto; clear:both" />
<?php
	include_once 'includes/footer2.php';
?>