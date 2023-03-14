<?php
require_once("verifica.php");
require_once("topo.php");
require_once __DIR__ . "/conexao.php";

$enviar = null;

if (isset($_POST["txtEnviar"]))
	$enviar = $_POST["txtEnviar"];

if ($enviar != 1) {
	$idUsuario = $_GET["id"];
	$query = mysqli_query($conexao, "select * from usuarios where id = '$idUsuario'") or die("Erro a selecionar agente para exibir detalhes! " . mysqli_error($conexao));
} else {
	if (isset($_POST["txtIdUsuario"]))
		$idUsuario = $_POST["txtIdUsuario"];
	if (isset($_POST["txtUsuario"]))
		$usuario = $_POST["txtUsuario"];
	if (isset($_POST["txtNivel"]))
		$nivel = $_POST["txtNivel"];

	//Atualizando os dados do agente
	mysqli_query($conexao, "update usuarios set usuario = '$usuario', nivel = '$nivel' where id = '$idUsuario'") or die("Erro ao atualizar os dados do agente! " . mysqli_error($conexao));

	$query = mysqli_query($conexao, "select * from usuarios where id = '$idUsuario'") or die("Erro ao selecionar os dados do agente! " . mysqli_error($conexao));
}
?>

<div id="meio">
	<form action="frmDetalheUsuario.php" method="post" id="frmGeneral">
		<input type=hidden name=txtEnviar value="1">
		<h2>Detalhes do agente</h2><br>
		<?php
		if ($enviar == 1) {
			echo "<font color=blue>Dados do agente atualizados com sucesso!</font><br><br>";
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
					<td colspan=2 id=separador>Dados do agente</td>
				</tr>
				<tr>
					<td id="label">Agente<mark id=asterisk>*</mark></td>
					<input type=hidden name=txtIdUsuario value="<?php echo $idUsuario; ?>">
					<td><input type=text name=txtUsuario required value="<?php echo $usuario; ?>"></td>
				</tr>
				<tr>
					<td id="label">Privilégio<mark id=asterisk>*</mark></td>
					<td>
						<select name=txtNivel required>
							<option disabled selected value> -- Selecione uma opção -- </option>
							<option value="Administrador" <?php if ($nivel == "Administrador") echo "selected='selected'"; ?>>Administrador</option>
							<option value="Padrão" <?php if ($nivel == "Padrão") echo "selected='selected'"; ?>>Padrão</option>
							<option value="Limitado" <?php if ($nivel == "Limitado") echo "selected='selected'"; ?>>Limitado</option>
						</select>
					</td>
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
require_once("rodape.php");
?>