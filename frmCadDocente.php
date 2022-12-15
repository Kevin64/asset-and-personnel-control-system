<?php
session_start();
require_once("verifica.php");
require_once("topo.php");
?>

<div id="meio">
	<form action="cadDocente.php" method=post id=frmGeneral>
		<h2>Formulário de cadastro de servidor</h2><br>
		<label id=asteriskWarning>Os campos marcados com asterisco (<mark id=asterisk>*</mark>) são obrigatórios!</label>
		<table id="frmFields">
			<tr>
				<td colspan=2 id=separador>Dados do docente</td>
			</tr>
			<tr>
				<td id="label">SIAPE<mark id=asterisk>*</mark></td>
				<td><input type=text name=txtSiape placeholder="Ex.: 1234567" maxLength=8 required></td>
			</tr>
			<tr>
				<td id="label">Tipo de servidor<mark id=asterisk>*</mark></td>
				<td>
					<select name=txtTipoServidor required>
						<option disabled selected value> -- Selecione uma opção -- </option>
						<option value="Docente">Docente</option>
						<option value="Técnico Administrativo em Educação">Técnico Administrativo em Educação</option>
					</select>
				</td>
			</tr>
			<tr>
				<td id="label">Nome<mark id=asterisk>*</mark></td>
				<td><input type=text name=txtNome placeholder="Ex.: Fulano de Tal" required></td>
			</tr>
			<tr>
				<td id="label">E-mail<mark id=asterisk>*</mark></td>
				<td><input type=email name=txtEmail placeholder="Ex.: fulano@email.com" required></td>
			</tr>
			<tr>
				<td id="label">Ramal</td>
				<td><input type=text name=txtRamal placeholder="Ex.: 9876" maxLength=4></td>
			</tr>
			<td id="label">Celular (com DDD)<mark id=asterisk>*</mark></td>
			<td><input type=text name=txtCelular placeholder="Ex.: 55998765432" minLength=11 maxLength=11 required></td>
			</tr>
			<tr>
				<td id="label">Curso<mark id=asterisk>*</mark></td>
				<td><input type=text name=txtCurso placeholder="Ex.: Curso de Humanas" required></td>
			</tr>
			<tr>
				<td id="label">Sala</td>
				<td><input type=text name=txtSala placeholder="Ex.: 4413" maxLength=4></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><br>
					<input id="registerButton" type="submit" value="Cadastrar">
				</td>
			</tr>
		</table>
	</form>
</div>
<?php
require_once("rodape.php");
?>