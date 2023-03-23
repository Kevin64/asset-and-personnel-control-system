<?php
require_once("checkSession.php");
require_once("top.php");
require_once __DIR__ . "/connection.php";

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

	$query = mysqli_query($conexao, "select * from bios where id = '$idModelo'") or die("Erro a selecionar modelo para exibir detalhes! " . mysqli_error($conexao));
} else {
	$idModelo = $_POST["txtIdModelo"];
	$marca = $_POST["txtMarca"];
	$modelo = $_POST["txtModelo"];
	$versao = $_POST["txtVersao"];
	$tipo = $_POST["txtTipo"];
	$tpm = $_POST["txtTPM"];
	$mediaOp = $_POST["txtMediaOp"];

	//Atualizando os dados do patrimônio
	mysqli_query($conexao, "update bios set marca = '$marca', modelo = '$modelo', versao = '$versao', tipo = '$tipo', tpm = '$tpm', mediaOp = '$mediaOp' where id = '$idModelo'") or die("Erro ao atualizar os dados da BIOS! " . mysqli_error($conexao));

	$query = mysqli_query($conexao, "select * from bios where id = '$idModelo'") or die("Erro ao selecionar os dados da BIOS! " . mysqli_error($conexao));
}
?>

<div id="meio">
	<form action="frmDetalheBIOS.php" method="post" id="frmGeneral">
		<input type=hidden name=txtEnviar value="1">
		<h2>Detalhes da BIOS</h2><br>
		<?php
		if ($enviar == 1)
			echo "<font color=blue>Dados da BIOS atualizados com sucesso!</font><br><br>";
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
					<td colspan=2 id=separador>Dados do modelo</td>
				</tr>
				<tr>
					<td id="label">Marca<mark id=asterisk>*</mark></td>
					<td><input type=text name=txtMarca placeholder="Ex.: Dell, Hewlett-Packard, LENOVO, etc" required value="<?php echo $marca; ?>"></td>
				</tr>
				<tr>
					<td id="label">Modelo<mark id=asterisk>*</mark></td>
					<input type=hidden name=txtIdModelo value="<?php echo $idModelo; ?>">
					<td><input type=text name=txtModelo placeholder="Ex.: 9010, 6005, etc" required value="<?php echo $modelo; ?>"></td>
				</tr>
				<tr>
					<td id="label">Versão da BIOS/UEFI<mark id=asterisk>*</mark></td>
					<td><input type=text name=txtVersao placeholder="Ex.: A30, 1.17, etc" required value="<?php echo $versao; ?>"></td>
				</tr>
				<tr>
					<td id="label">Tipo de firmware<mark id=asterisk>*</mark></td>
					<td>
						<?php
						?>
						<select name=txtTipo required>
							<option value=BIOS <?php if ($tipo == "BIOS") echo "selected='selected'"; ?>>BIOS</option>
							<option value=UEFI <?php if ($tipo == "UEFI") echo "selected='selected'"; ?>>UEFI</option>
						</select>
					</td>
				</tr>
				<tr>
					<td id="label">Versão TPM<mark id=asterisk>*</mark></td>
					<td>
						<?php
						?>
						<select name=txtTPM required>
							<option value="Não existente" <?php if ($tpm == "Não existente") echo "selected='selected'"; ?>>Não existente</option>
							<option value=1.2 <?php if ($tpm == "1.2") echo "selected='selected'"; ?>>1.2</option>
							<option value=2.0 <?php if ($tpm == "2.0") echo "selected='selected'"; ?>>2.0</option>
						</select>
					</td>
				</tr>
				<tr>
					<td id="label">Modo Armaz.<mark id=asterisk>*</mark></td>
					<td>
						<?php
						?>
						<select name=txtMediaOp required>
							<option value=IDE/RAID <?php if ($mediaOp == "IDE/RAID") echo "selected='selected'"; ?>>IDE/RAID</option>
							<option value=AHCI <?php if ($mediaOp == "AHCI") echo "selected='selected'"; ?>>AHCI</option>
							<option value=NVMe <?php if ($mediaOp == "NVMe") echo "selected='selected'"; ?>>NVMe</option>
						</select>
					</td>
				</tr>
				</tr>
			<?php
			}
			if ($_SESSION["nivel"] != "Limitado") {
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