<?php
session_start();
require_once("topo.php");
require_once("verifica.php");
require_once __DIR__ . '/../conexao.php';

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

	$query = mysqli_query($conexao, "select * from bios where id = '$idModelo'") or die("Erro a selecionar modelo para exibir detalhes! " . mysqli_error($conexao));
} else {
	$idModelo = $_POST["txtIdModelo"];
	$marca = $_POST["txtMarca"];
	$modelo = $_POST["txtModelo"];
	$versao = $_POST["txtVersao"];
	$tipo = $_POST["txtTipo"];

	//Atualizando os dados do patrimônio
	mysqli_query($conexao, "update bios set marca = '$marca', modelo = '$modelo', versao = '$versao', tipo = '$tipo' where id = '$idModelo'") or die("Erro ao atualizar os dados da BIOS! " . mysqli_error($conexao));

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
		<table id="frmFields">
			<?php
			while ($resultado = mysqli_fetch_array($query)) {
				$idModelo = $resultado["id"];
				$marca = $resultado["marca"];
				$modelo = $resultado["modelo"];
				$versao = $resultado["versao"];
				$tipo = $resultado["tipo"];
			?>
				<tr>
					<td colspan=2 id=separador>Dados da BIOS</td>
				</tr>
				<tr>
					<td id="label">Modelo</td>
					<input type=hidden name=txtIdModelo value="<?php echo $idModelo; ?>">
					<td><input type=text name=txtModelo value="<?php echo $modelo; ?>"></td>
				</tr>
				<tr>
					<td id="label">Marca</td>
					<td><input type=text name=txtMarca value="<?php echo $marca; ?>"></td>
				</tr>
				<tr>
					<td id="label">Versão da BIOS/UEFI</td>
					<td><input type=text name=txtVersao value="<?php echo $versao; ?>"></td>
				</tr>
				<tr>
					<td id="label">Tipo</td>
					<td>
						<?php
						?>
						<select name=txtTipo required>
							<option value=BIOS <?php if($tipo=="BIOS") echo 'selected="selected"'; ?>>BIOS</option>
							<option value=UEFI <?php if($tipo=="UEFI") echo 'selected="selected"'; ?>>UEFI</option>
						</select>
					</td>
				</tr>
				</tr>
			<?php
			}
			?>
			<tr>
				<td colspan=2 align=center><br><input id="updateButton" type=submit value=Atualizar></td>
			</tr>
		</table>
	</form>
</div>
<?php
require_once("rodape.php");
?>