<?php
require_once("checkSession.php");
require_once("top.php");
require_once __DIR__ . "/connection.php";

$enviar = null;
$ordenar = null;

if (isset($_POST["txtEnviar"]))
	$enviar = $_POST["txtEnviar"];

if (isset($_GET["ordenar"]))
	$ordenar = $_GET["ordenar"];

if (isset($_GET["sort"]))
	$sort = $_GET["sort"];

if ($ordenar == "")
	$ordenar = "marca";

if (isset($sort) and $sort == "asc") {
	$sort = "desc";
} else {
	$sort = "asc";
}

if ($enviar != 1)
	$query = mysqli_query($conexao, "select * from bios order by $ordenar $sort") or die("Erro ao selecionar dados de BIOS! " . mysqli_error($conexao));
else {
	$rdCriterio = $_POST["rdCriterio"];
	$pesquisar = $_POST["txtPesquisar"];
	$query = mysqlI_query($conexao, "select * from bios where $rdCriterio like "%$pesquisar%"") or die("Erro ao efetuar a pesquisa! " . mysqli_error($conexao));
}

$totalSalas = mysqli_num_rows($query);
?>

<div id="meio">
	<table id="tbPesquisar">
		<form action=consultarBIOS.php method=post>
			<input type=hidden name=txtEnviar value=1>
			<tr>
				<td align=center>Pesquisar por:</td>
			</tr>
			<tr>
				<td align=center>
					<select id=filterBIOS name=rdCriterio>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "modelo") echo "selected='selected'"; ?>value="modelo">Modelo</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "marca") echo "selected='selected'"; ?>value="marca">Marca</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "versao") echo "selected='selected'"; ?>value="versao">Versão</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "tipo") echo "selected='selected'"; ?>value="tipo">Tipo</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "tpm") echo "selected='selected'"; ?>value="tpm">Versão TPM</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "mediaOp") echo "selected='selected'"; ?>value="mediaOp">Modo Armaz.</option>
					</select>
					<input style="width:300px" type=text name=txtPesquisar> <input id="searchButton" type=submit value="OK">
				</td>
			</tr>
		</form>
		<?php
			if(isset($_POST["txtPesquisar"])){
				if(isset($_POST["rdCriterio"])){
					$value = $_POST["rdCriterio"];
				}
			}
		?>
	</table>
	<br><br>
	<h2>Lista de modelos (<?php echo $totalSalas; ?>)</h2><br>
	<table id="dadosBIOS" cellspacing=0>
		<form action="apagaSelecionadosBIOS.php" method="post">
			<tr id="cabecalho">
				<?php
				if (isset($_SESSION["nivel"])) {
					if ($_SESSION["nivel"] == "Administrador") {
				?>
						<td><img src="img/trash.png" width="22" height="29"></td>
				<?php
					}
				}
				?>
				<td><a href="?ordenar=modelo&sort=<?php echo $sort; ?>">Modelo</a></td>
				<td><a href="?ordenar=marca&sort=<?php echo $sort; ?>">Marca</a></td>
				<td><a href="?ordenar=versao&sort=<?php echo $sort; ?>">Versão</a></td>
				<td><a href="?ordenar=tipo&sort=<?php echo $sort; ?>">Tipo</a></td>
				<td><a href="?ordenar=tpm&sort=<?php echo $sort; ?>">Versão TPM</a></td>
				<td><a href="?ordenar=mediaOp&sort=<?php echo $sort; ?>">Modo Armaz.</a></td>
			</tr>
			<?php
			while ($resultado = mysqli_fetch_array($query)) {
				$id = $resultado["id"];
				$marca = $resultado["marca"];
				$modelo = $resultado["modelo"];
				$versao = $resultado["versao"];
				$tipo = $resultado["tipo"];
				$tpm = $resultado["tpm"];
				$mediaOp = $resultado["mediaOp"];
			?>
				<tr id="dados">
					<?php
					if (isset($_SESSION["nivel"])) {
						if ($_SESSION["nivel"] == "Administrador") {
					?>
							<td><input type="checkbox" name="chkDeletar[]" value="<?php echo $id; ?>" onclick="var input = document.getElementById('eraseButton'); if(this.checked){ input.disabled = false;}else{input.disabled=true;}"></td>
					<?php
						}
					}
					?>
					<td><a href="frmDetalheBIOS.php?id=<?php echo $id; ?>"><?php echo $modelo; ?></a></td>
					<td><?php echo $marca; ?></td>
					<td><?php echo $versao; ?></td>
					<td><?php echo $tipo; ?></td>
					<td><?php echo $tpm; ?></td>
					<td><?php echo $mediaOp; ?></td>
				</tr>
				<?php
			}
			if (isset($_SESSION["nivel"])) {
				if ($_SESSION["nivel"] == "Administrador") {
				?>
					<tr>
						<td colspan=7 align="center"><br><input id="eraseButton" type="submit" value="Apagar selecionados" disabled></td>
					</tr>
			<?php
				}
			}
			?>
		</form>
	</table>
</div>
<?php
require_once("foot.php");
?>