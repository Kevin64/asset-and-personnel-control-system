<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$enviar = null;

if (isset($_POST["txtEnviar"]))
	$enviar = $_POST["txtEnviar"];

if ($enviar != 1) {
	$idUsuario = $_GET["id"];
	$query = mysqli_query($conexao, "select * from usuarios where id = '$idUsuario'") or die($translations["ERROR_SHOW_DETAIL_USER"] . mysqli_error($conexao));
} else {
	if (isset($_POST["txtIdUsuario"]))
		$idUsuario = $_POST["txtIdUsuario"];
	if (isset($_POST["txtUsuario"]))
		$usuario = $_POST["txtUsuario"];
	if (isset($_POST["txtNivel"]))
		$nivel = $_POST["txtNivel"];

	//Atualizando os dados do agente
	mysqli_query($conexao, "update usuarios set usuario = '$usuario', nivel = '$nivel' where id = '$idUsuario'") or die($translations["ERROR_UPDATE_USER_DATA"] . mysqli_error($conexao));

	$query = mysqli_query($conexao, "select * from usuarios where id = '$idUsuario'") or die($translations["ERROR_SHOW_DETAIL_USER"] . mysqli_error($conexao));
}
?>

<div id="meio">
	<form action="formDetailUser.php" method="post" id="frmGeneral">
		<input type=hidden name=txtEnviar value="1">
		<h2>Detalhes do agente</h2><br>
		<?php
		if ($enviar == 1) {
			echo "<font color=blue>" . $translations["SUCCESS_UPDATE_USER_DATA"] . "</font><br><br>";
		}
		?>
		<label id=asteriskWarning>Os campos marcados com asterisco (<mark id=asterisk>*</mark>) são obrigatórios!</label>
		<table id="frmFields">
			<?php
			while ($resultado = mysqli_fetch_array($query)) {
				$idUsuario = $resultado["id"];
				$usuario = $resultado["usuario"];
				$nivel = $resultado["nivel"];
			?>
				<tr>
					<td colspan=2 id=separador><?php echo $translations["USER_DATA"] ?></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["USER"] ?><mark id=asterisk>*</mark></td>
					<input type=hidden name=txtIdUsuario value="<?php echo $idUsuario; ?>">
					<td><input type=text name=txtUsuario required value="<?php echo $usuario; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["PRIVILEGE"] ?><mark id=asterisk>*</mark></td>
					<td>
						<select name=txtNivel required>
							<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
							<option value="Administrador" <?php if ($nivel == $json_config_array["ADMIN_LEVEL"]) echo "selected='selected'"; ?>><?php echo $translations["ADMIN"] ?></option>
							<option value="Padrão" <?php if ($nivel == $json_config_array["STANDARD_LEVEL"]) echo "selected='selected'"; ?>><?php echo $translations["STD"] ?></option>
							<option value="Limitado" <?php if ($nivel == $json_config_array["LIMITED_LEVEL"]) echo "selected='selected'"; ?>><?php echo $translations["LIMIT"] ?></option>
						</select>
					</td>
				</tr>
			<?php
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