<?php
require_once("verifica.php");
require_once("topo.php");
require_once __DIR__ . '/../conexao.php';

$enviar = null;
$ordenar = null;

if (isset($_POST["txtEnviar"]))
	$enviar = $_POST["txtEnviar"];

if (isset($_GET["ordenar"]))
	$ordenar = $_GET["ordenar"];

if (isset($_GET['sort']))
	$sort = $_GET['sort'];

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
	$query = mysqlI_query($conexao, "select * from bios where $rdCriterio like '%$pesquisar%'") or die("Erro ao efetuar a pesquisa! " . mysqli_error($conexao));
}

$totalSalas = mysqli_num_rows($query);
?>

<div id="meio">
	<table id="tbPesquisar">
		<form action=consultarBIOS.php method=post>
			<input type=hidden name=txtEnviar value=1>
			<tr>
				<td align="center">Pesquisar por:
					<select id=filterBIOS name=rdCriterio>
						<option value="modelo">Modelo</option>
						<option value="marca">Marca</option>
						<option value="versao">Versão</option>
						<option value="tipo">Tipo</option>
					</select>
					<input type=text name=txtPesquisar> <input id="searchButton" type=submit value="OK">
				</td>
			</tr>
		</form>
	</table>
	<br><br>
	<h2>Lista de BIOS (<?php echo $totalSalas; ?>)</h2><br>
	<table id="dadosBIOS" cellspacing=0>
		<form action="apagaSelecionadosBIOS.php" method="post">
			<tr id="cabecalho">
				<td><a href="?ordenar=modelo&sort=<?php echo $sort; ?>">Modelo</a></td>
				<td><a href="?ordenar=marca&sort=<?php echo $sort; ?>">Marca</a></td>
				<td><a href="?ordenar=versao&sort=<?php echo $sort; ?>">Versão</a></td>
				<td><a href="?ordenar=tipo&sort=<?php echo $sort; ?>">Tipo</a></td>
				<?php
				if (isset($_SESSION['nivel'])) {
					if ($_SESSION["nivel"] == "adm") {
				?>
						<td>Excluir</td>
				<?php
					}
				}
				?>
				<td>
			</tr>
			<?php
			while ($resultado = mysqli_fetch_array($query)) {
				$id = $resultado["id"];
				$marca = $resultado["marca"];
				$modelo = $resultado["modelo"];
				$versao = $resultado["versao"];
				$tipo = $resultado["tipo"];
			?>
				<tr id="dados">
					<td><a href="frmDetalheBIOS.php?id=<?php echo $id; ?>"><?php echo $modelo; ?></style></a></td>
					<td><?php echo $marca; ?></td>
					<td><?php echo $versao; ?></td>
					<td><?php echo $tipo; ?></td>
					<?php
					if (isset($_SESSION['nivel'])) {
						if ($_SESSION["nivel"] == "adm") {
					?>
							<td><input type="checkbox" name="chkDeletar[]" value="<?php echo $id; ?>"></td>
					<?php
						}
					}
					?>
				</tr>
				<?php
			}
			if (isset($_SESSION['nivel'])) {
				if ($_SESSION["nivel"] == "adm") {
				?>
					<tr>
						<td colspan=7 align="center"><br><input id="eraseButton" type="submit" value="Apagar selecionados" style="width: 300px;"></td>
					</tr>
			<?php
				}
			}
			?>
		</form>
	</table>
</div>
<?php
require_once("rodape.php");
?>