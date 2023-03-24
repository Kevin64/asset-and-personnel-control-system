<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$enviar = null;
$idModelo = null;
$marca = null;
$modelo = null;
$versao = null;
$tipo = null;

if (isset($_POST["txtEnviar"]))
	$enviar = $_POST["txtEnviar"];

if ($enviar != 1) {
	if (isset($_GET["id"]))
		$idModelo = $_GET["id"];

	if (isset($_GET["marca"]))
		$marca = $_GET["marca"];

	if (isset($_GET["modelo"]))
		$modelo = $_GET["modelo"];

	if (isset($_GET["versao"]))
		$versao = $_GET["versao"];

	if (isset($_GET["tipo"]))
		$tipo = $_GET["tipo"];

	if (isset($_GET["tpm"]))
		$tpm = $_GET["tpm"];

	if (isset($_GET["mediaOp"]))
		$mediaOp = $_GET["mediaOp"];

	$query = mysqli_query($conexao, "select * from bios where id = '$idModelo'") or die($translations["ERROR_SHOW_DETAIL_MODEL"] . mysqli_error($conexao));
} else {
	$idModelo = $_POST["txtIdModelo"];
	$marca = $_POST["txtMarca"];
	$modelo = $_POST["txtModelo"];
	$versao = $_POST["txtVersao"];
	$tipo = $_POST["txtTipo"];
	$tpm = $_POST["txtTPM"];
	$mediaOp = $_POST["txtMediaOp"];

	//Atualizando os dados do patrimônio
	mysqli_query($conexao, "update bios set marca = '$marca', modelo = '$modelo', versao = '$versao', tipo = '$tipo', tpm = '$tpm', mediaOp = '$mediaOp' where id = '$idModelo'") or die($translations["ERROR_UPDATE_MODEL_DATA"] . mysqli_error($conexao));

	$query = mysqli_query($conexao, "select * from bios where id = '$idModelo'") or die($translations["ERROR_SHOW_DETAIL_MODEL"] . mysqli_error($conexao));
}
?>

<div id="meio">
	<form action="frmDetalheBIOS.php" method="post" id="frmGeneral">
		<input type=hidden name=txtEnviar value="1">
		<h2><?php echo $translations["MODEL_DETAIL"] ?></h2><br>
		<?php
		if ($enviar == 1)
			echo "<font color=blue>" . $translations["SUCCESS_UPDATE_MODEL_DATA"] . "</font><br><br>";
		?>
		<label id=asteriskWarning>Os campos marcados com asterisco (<mark id=asterisk>*</mark>) são obrigatórios!</label>
		<table id="frmFields">
			<?php
			while ($resultado = mysqli_fetch_array($query)) {
				$idModelo = $resultado["id"];
				$marca = $resultado["marca"];
				$modelo = $resultado["modelo"];
				$versao = $resultado["versao"];
				$tipo = $resultado["tipo"];
				$tpm = $resultado["tpm"];
				$mediaOp = $resultado["mediaOp"];
			?>
				<tr>
					<td colspan=2 id=separador><?php echo $translations["MODEL_DATA"] ?></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["BRAND"] ?><mark id=asterisk>*</mark></td>
					<td><input type=text name=txtMarca placeholder="Ex.: Dell, Hewlett-Packard, LENOVO, etc" required value="<?php echo $marca; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["MODEL"] ?><mark id=asterisk>*</mark></td>
					<input type=hidden name=txtIdModelo value="<?php echo $idModelo; ?>">
					<td><input type=text name=txtModelo placeholder="Ex.: 9010, 6005, etc" required value="<?php echo $modelo; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["FW_VERSION"] ?><mark id=asterisk>*</mark></td>
					<td><input type=text name=txtVersao placeholder="Ex.: A30, 1.17, etc" required value="<?php echo $versao; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["FW_TYPE"] ?><mark id=asterisk>*</mark></td>
					<td>
						<?php
						?>
						<select name=txtTipo required>
							<option value=BIOS <?php if ($tipo == $json_config_array["FW_BIOS"]) echo "selected='selected'"; ?>><?php echo $json_config_array["FW_BIOS"] ?></option>
							<option value=UEFI <?php if ($tipo == $json_config_array["FW_UEFI"]) echo "selected='selected'"; ?>><?php echo $json_config_array["FW_UEFI"] ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["TPM_VERSION"] ?><mark id=asterisk>*</mark></td>
					<td>
						<?php
						?>
						<select name=txtTPM required>
							<option value="Não existente" <?php if ($tpm == "Não existente") echo "selected='selected'"; ?>>Não existente</option>
							<option value=1.2 <?php if ($tpm == $json_config_array["TPM_1_2"]) echo "selected='selected'"; ?>><?php echo $json_config_array["TPM_1_2"] ?></option>
							<option value=2.0 <?php if ($tpm == $json_config_array["TPM_2_0"]) echo "selected='selected'"; ?>><?php echo $json_config_array["TPM_2_0"] ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["MEDIA_OPERATION_MODE"] ?><mark id=asterisk>*</mark></td>
					<td>
						<?php
						?>
						<select name=txtMediaOp required>
							<option value=IDE/RAID <?php if ($mediaOp == $json_config_array["MEDIA_OP_IDE"]) echo "selected='selected'"; ?>><?php echo $json_config_array["MEDIA_OP_IDE"] ?></option>
							<option value=AHCI <?php if ($mediaOp == $json_config_array["MEDIA_OP_AHCI"]) echo "selected='selected'"; ?>><?php echo $json_config_array["MEDIA_OP_AHCI"] ?></option>
							<option value=NVMe <?php if ($mediaOp == $json_config_array["MEDIA_OP_NVME"]) echo "selected='selected'"; ?>><?php echo $json_config_array["MEDIA_OP_NVME"] ?></option>
						</select>
					</td>
				</tr>
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