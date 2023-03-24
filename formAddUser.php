<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

if (isset($_SESSION["nivel"])) {
	if ($_SESSION["nivel"] == $json_config_array["ADMIN_LEVEL"]) {

?>
		<div id="meio">
			<form action=addNewUser.php method=post id="frmGeneral">
				<h2><?php echo $translations["ADD_USER_FORM"] ?></h2><br>
				<input type=hidden name=txtStatus value="0">
				<table id="frmFields">
					<tr>
						<td id=label><?php echo $translations["USER"] ?></td>
						<td><input type=text name=txtUsuario></td>
					</tr>
					<tr>
						<td id=label><?php echo $translations["PASSWORD"] ?></td>
						<td><input type=password name=txtSenha></td>
					</tr>
					<tr>
						<td id=label><?php echo $translations["PRIVILEGE"] ?></td>
						<td>
							<select name=txtNivel>
								<option value="Administrador"><?php echo $translations["ADMIN_USER"] ?></option>
								<option value="Padrão"><?php echo $translations["STANDARD_USER"] ?></option>
								<option value="Limitado"><?php echo $translations["LIMITED_USER"] ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan=2><br>
							<input id="registerButton" type=submit value="Cadastrar">
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