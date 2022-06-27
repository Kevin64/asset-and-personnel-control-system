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

if ($ordenar == "")
	$ordenar = "nome";

if (isset($_GET['sort']))
	$sort = $_GET['sort'];

if (isset($sort) and $sort == "asc") {
	$sort = "desc";
} else {
	$sort = "asc";
}

if ($enviar != 1)
	$query = mysqli_query($conexao, "select * from docente order by $ordenar $sort") or die("Erro ao selecionar dados do docente! " . mysqli_error($conexao));
else {
	$rdCriterio = $_POST["rdCriterio"];
	$pesquisar = $_POST["txtPesquisar"];
	$query = mysqli_query($conexao, "select * from docente where $rdCriterio like '%$pesquisar%'") or die("Erro ao efetuar a pesquisa! " . mysqli_error($conexao));
}

$totalDocentes = mysqli_num_rows($query);
?>

<div id="meio">
	<table id="tbPesquisar">
		<form action=consultarDocente.php method=post>
			<input type=hidden name=txtEnviar value=1>
			<tr>
				<td align=center>Pesquisar por:
					<select id=filterDocente name=rdCriterio>
						<option value="siape">SIAPE</option>
						<option value="nome">Nome</option>
						<option value="curso">Curso</option>
					</select>
					<input type=text name=txtPesquisar> <input id="searchButton" type=submit value="OK">
				</td>
			</tr>
		</form>
	</table>
	<br><br>
	<h2>Lista de docentes (<?php echo $totalDocentes; ?>)</h2><br>
	<table id="dadosDocente" cellspacing=0>
		<form action="apagaSelecionadosDocente.php" method="post">
			<tr id="cabecalho">
				<td><a href="?ordenar=siape&sort=<?php echo $sort; ?>">SIAPE</a></td>
				<td><a href="?ordenar=nome&sort=<?php echo $sort; ?>">Nome</a></td>
				<td><a href="?ordenar=curso&sort=<?php echo $sort; ?>">Curso</a></td>
				<td><a href="?ordenar=faltas&sort=<?php echo $sort; ?>">Faltas</a></td>
				<td>Excluir</td>
				<td>
			</tr>
			<?php
			while ($resultado = mysqli_fetch_array($query)) {
				$id = $resultado["id"];
				$siape = $resultado["siape"];
				$nome = $resultado["nome"];
				$curso = $resultado["curso"];
				$faltas = $resultado["faltas"];
			?>
				<tr id="dados">
					<td><a href="frmDetalheDocente.php?id=<?php echo $id; ?>"><?php echo $siape; ?></style></a></td>
					<td><?php echo $nome; ?></td>
					<td><?php echo $curso; ?></td>
					<td width=120><input id="missMinusButton" type="submit" class="button" name="menosfalta" formaction="faltasDocente.php" value="<?php echo '-' ?>"><?php echo " " . $faltas . " "; ?><input id="missPlusButton" type="submit" class="button" name="maisfalta" formaction="faltasDocente.php" value="<?php echo '+' ?>"></td>
					<td><input type="checkbox" name="chkDeletar[]" value="<?php echo $id; ?>"></td>
				</tr>
			<?php
			}
			?>
			<tr>
				<td colspan=7 align="center"><br><input id="eraseButton" type="submit" value="Apagar selecionados" style="width: 300px;"></td>
			</tr>
		</form>
	</table>
</div>
<?php
require_once("rodape.php");
?>