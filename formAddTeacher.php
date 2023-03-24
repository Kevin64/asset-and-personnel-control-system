<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

if (isset($_SESSION["nivel"])) {
	if ($_SESSION["nivel"] != $json_config_array["LIMITED_LEVEL"]) {

?>
		<div id="meio">
			<form action="addTeacher.php" method=post id=frmGeneral>
				<h2><?php echo $translations["ADD_TEACHER_FORM"] ?></h2><br>
				<label id=asteriskWarning>Os campos marcados com asterisco (<mark id=asterisk>*</mark>) são obrigatórios!</label>
				<table id="frmFields">
					<tr>
						<td colspan=2 id=separador><?php echo $translations["TEACHER_DATA"] ?></td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["TEACHER_REGISTRATION_NUMBER"] ?><mark id=asterisk>*</mark></td>
						<td><input type=text name=txtSiape placeholder="Ex.: 1234567" maxLength=8 required></td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["EMPLOYEE_TYPE"] ?><mark id=asterisk>*</mark></td>
						<td>
							<select name=txtTipoServidor required>
								<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
								<option value="Docente"><?php echo $translations["TEACHER_TYPE_1"] ?></option>
								<option value="Técnico Administrativo em Educação"><?php echo $translations["TEACHER_TYPE_2"] ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["TEACHER_NAME"] ?><mark id=asterisk>*</mark></td>
						<td><input type=text name=txtNome placeholder="Ex.: Fulano de Tal" required></td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["TEACHER_EMAIL"] ?><mark id=asterisk>*</mark></td>
						<td><input type=email name=txtEmail placeholder="Ex.: fulano@email.com" required></td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["TEACHER_PHONE_EXTENSION"] ?></td>
						<td><input type=text name=txtRamal placeholder="Ex.: 9876" maxLength=4></td>
					</tr>
					<td id="label"><?php echo $translations["TEACHER_PHONE_NUMBER"] ?><mark id=asterisk>*</mark></td>
					<td><input type=text name=txtCelular placeholder="Ex.: 55998765432" minLength=11 maxLength=11 required></td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["TEACHER_COURSE"] ?><mark id=asterisk>*</mark></td>
						<td><input type=text name=txtCurso placeholder="Ex.: Curso de Humanas" required></td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["TEACHER_ROOM"] ?></td>
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
		require_once("foot.php");
	} else {
		header("Location: denied.php");
	}
}
?>