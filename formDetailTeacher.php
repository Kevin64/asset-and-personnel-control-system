<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$enviar = null;

if (isset($_POST["txtEnviar"]))
	$enviar = $_POST["txtEnviar"];

if ($enviar != 1) {
	$idDocente = $_GET["id"];
	$query = mysqli_query($conexao, "select * from docente where id = '$idDocente'") or die($translations["ERROR_SHOW_DETAIL_TEACHER"] . mysqli_error($conexao));
} else {
	if (isset($_POST["txtIdDocente"]))
		$idDocente = $_POST["txtIdDocente"];
	if (isset($_POST["txtSiape"]))
		$siape = $_POST["txtSiape"];
	if (isset($_POST["txtTipoServidor"]))
		$tipoServidor = $_POST["txtTipoServidor"];
	if (isset($_POST["txtNome"]))
		$nome = $_POST["txtNome"];
	if (isset($_POST["txtEmail"]))
		$email = $_POST["txtEmail"];
	if (isset($_POST["txtRamal"]))
		$ramal = $_POST["txtRamal"];
	if (isset($_POST["txtCelular"]))
		$celular = $_POST["txtCelular"];
	if (isset($_POST["txtCurso"]))
		$curso = $_POST["txtCurso"];
	if (isset($_POST["txtSala"]))
		$sala = $_POST["txtSala"];
	if (isset($_POST["txtFaltas"]))
		$faltas = $_POST["txtFaltas"];
	if (isset($_POST["txtDataUltimaFalta"]))
		$data_ultima_falta = $_POST["txtDataUltimaFalta"];

	//Atualizando os dados do docente
	mysqli_query($conexao, "update docente set siape = '$siape', tipoServidor = '$tipoServidor', nome = '$nome', email = '$email', ramal = '$ramal', celular = '$celular', curso = '$curso', sala = '$sala' where id = '$idDocente'") or die($translations["ERROR_UPDATE_TEACHER_DATA"] . mysqli_error($conexao));

	$query = mysqli_query($conexao, "select * from docente where id = '$idDocente'") or die($translations["ERROR_SHOW_DETAIL_TEACHER"] . mysqli_error($conexao));
}
?>

<div id="meio">
	<form action="formDetailTeacher.php" method="post" id="frmGeneral">
		<input type=hidden name=txtEnviar value="1">
		<h2><?php echo $translations["TEACHER_DETAIL"] ?></h2><br>
		<?php
		if ($enviar == 1) {
			echo "<font color=blue>" . $translations["SUCCESS_UPDATE_TEACHER_DATA"] . "</font><br><br>";
		}
		?>
		<label id=asteriskWarning>Os campos marcados com asterisco (<mark id=asterisk>*</mark>) são obrigatórios!</label>
		<table id="frmFields">
			<?php
			while ($resultado = mysqli_fetch_array($query)) {
				$idDocente = $resultado["id"];
				$siape = $resultado["siape"];
				$tipoServidor = $resultado["tipoServidor"];
				$nome = $resultado["nome"];
				$email = $resultado["email"];
				$ramal = $resultado["ramal"];
				$celular = $resultado["celular"];
				$curso = $resultado["curso"];
				$sala = $resultado["sala"];
				$faltas = $resultado["faltas"];
				$data_ultima_falta = $resultado["data_ultima_falta"];
			?>
				<tr>
					<td colspan=2 id=separador><?php echo $translations["TEACHER_DATA"] ?></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["TEACHER_REGISTRATION_NUMBER"] ?><mark id=asterisk>*</mark></td>
					<input type=hidden name=txtIdDocente value="<?php echo $idDocente; ?>">
					<td><input type=text name=txtSiape maxlength="8" required value="<?php echo $siape; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["EMPLOYEE_TYPE"] ?><mark id=asterisk>*</mark></td>
					<td>
						<select name=txtTipoServidor required>
							<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?></option>
							<option value="Docente" <?php if ($tipoServidor == "Docente") echo "selected='selected'"; ?>><?php echo $translations["TEACHER_TYPE_1"] ?></option>
							<option value="Técnico Administrativo em Educação" <?php if ($tipoServidor == "Técnico Administrativo em Educação") echo "selected='selected'"; ?>><?php echo $translations["TEACHER_TYPE_2"] ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td id="label">Nome<mark id=asterisk>*</mark></td>
					<td><input type=text name=txtNome required value="<?php echo $nome; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["TEACHER_EMAIL"] ?><mark id=asterisk>*</mark></td>
					<td><input type=email name=txtEmail required value="<?php echo $email; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["TEACHER_PHONE_EXTENSION"] ?></td>
					<td><input type=text name=txtRamal maxLength=4 value="<?php echo $ramal; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["TEACHER_PHONE_NUMBER"] ?><mark id=asterisk>*</mark></td>
					<td><input type=text name=txtCelular minLength=11 maxLength=11 required value="<?php echo $celular; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["TEACHER_COURSE"] ?><mark id=asterisk>*</mark></td>
					<td><input type=text name=txtCurso required value="<?php echo $curso; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["TEACHER_ROOM"] ?></td>
					<td><input type=text name=txtSala maxLength=4 value="<?php echo $sala; ?>"></td>
				</tr>
				<tr>
					<td colspan=2 id=separador><?php echo $translations["MRBS_TEMPLATE"] ?></td>
				</tr>
				<tr>
					<?php
					if ($siape == "" || $tipoServidor == null || $nome == "" || $email == "" || $celular == "" || $curso == "") {
					?>
						<td colspan=2 style="color:red;"><br><?php echo "<h4> Completar dados cadastrais antes de continuar! " ?></br></td>
						<?php
					} else {
						if ($tipoServidor == "Técnico Administrativo em Educação") {
						?>
							<td colspan=2><br><?php echo "<h4>" . "TAE" . " " . $nome . " - Curso de " . $curso; ?></br></td>
						<?php
						} else {
						?>
							<td colspan=2><br><?php echo "<h4>" . "Prof." . " " . $nome . $translations["COURSE_OF"] . $curso; ?></br></td>
						<?php
						}
						?>
				</tr>
				<tr>
					<td colspan=2><br><?php echo $translations["TEACHER_REGISTRATION_NUMBER"] . $siape; ?></br></td>
				</tr>
				<tr>
					<td colspan=2><?php echo $translations["TEACHER_COURSE"] . $curso; ?> </td>
				</tr>
				<tr>
					<td colspan=2><?php echo $translations["TEACHER_PHONE_NUMBER_SHORT"] . $celular; ?> </td>
				</tr>
				<tr>
					<td colspan=2><?php echo $translations["TEACHER_EMAIL"] . $email; ?> </td>
				</tr>
			<?php
					}
				}
				if ($_SESSION["nivel"] != $json_config_array["LIMITED_LEVEL"]) {
			?>
			<tr>
				<td colspan=2 align=center><br><input id="updateButton" type=submit value=Atualizar></td>
			</tr>
		<?php
				}
		?>
		</table>
	</form>
</div>
<?php
require_once("foot.php");
?>