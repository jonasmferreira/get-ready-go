<?php
	include_once 'includes/cabecalho.php';
	include_once 'includes/header2.php';
?>
<img src="imgs/content_top.png" align="absbottom" style="display:block; margin:auto" />
<div id="conteudo" class="sistema">
	<!-- nome da seção -->
	<h2><b class="title">Meu perfil</b></h2>

	<div id="perfil">
		<div id="imgPerfil">
			<img src="imgs/avatares/1.jpg" /><!-- usuário começa com imagem padrão -->
			<p><a href="#">Alterar avatar</a></p>
		</div>

		<div id="infoPerfil">
			<h1>Fulano de tal</h1>
			<p class="data">cadastrado em 21.11.2010</p>
			<table>
				<tr>
					<td>Nome:</td>
					<td><input type="text" class="text" size="40" value="fulanodetal@email.com" /></td>
				</tr>
				<tr>
					<td>E-mail:</td>
					<td><input type="text" class="text" size="40" value="Nome completo do cara" /></td>
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
						<select>
							<option>01</option>
						</select>
						<select>
							<option>Janeiro</option>
						</select>
						<select>
							<option>1983</option>
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
					<td><input type="image" src="imgs/bt_enviar.gif" /></td>
				</tr>
			</table>
		</div>
		<div style="clear:both"></div>
	</div>

</div>
<img src="imgs/content_bot.png" align="top"  style="display:block; margin:auto; clear:both" />
<?php
	include_once 'includes/footer2.php';
?>