<?php
require_once ("verifica.php");
require_once ("topo.php");
require_once ("conexao.php");

$enviar = $_POST["txtEnviar"];
$ordenar = $_GET["ordenar"];

if ($ordenar == "")
	$ordenar = "sala";

if ($enviar != 1) {
	$query = mysql_query("select * from patrimonio order by $ordenar") or die ("Erro ao selecionar dados do patrimônio! ".mysql_error());
} else {
	$rdCriterio = $_POST["rdCriterio"];
	$pesquisar = $_POST["txtPesquisar"];

	$query = mysql_query("select * from patrimonio where $rdCriterio like '%$pesquisar%'") or die ("Erro ao efetuar a pesquisa! ".mysql_error());
}

$totalSalas = mysql_num_rows(mysql_query("select * from patrimonio"));
?>

<div id="meio">
	<h2>Lista de patrimônios (<?php echo $totalSalas;?>)</h2><br>
	<table id="tbPesquisarPatrimonio">
	<form action=consultarPatrimonio.php method=post>
	<input type=hidden name=txtEnviar value=1>
	<tr>
	<td id=search>Pesquisar por: <input type=radio name=rdCriterio value="patrimonio" checked>Patrimônio <input type=radio name=rdCriterio value="predio"> Prédio <input type=radio name=rdCriterio value="hostname">Hostname <input type=radio name=rdCriterio value="sala">Sala <input type=text name=txtPesquisar> <input type=submit value="OK"></td>
	</tr>
	</form>

	</table>
	<br><br>
	<table id="dadosPatrimonio" cellspacing=0>
	<form action="apagaSelecionados.php" method="post">
	<tr id="cabecalho">
	<td><a href="?ordenar=patrimonio">Patrimônio</a></td>
	<td><a href="?ordenar=sala">Sala</a></td>
	<td><a href="?ordenar=hostname">Hostname</a></td>
	<td><a href="?ordenar=predio">Prédio</a></td>
	<td><!-- Espaço para checkbox -->
	</tr>

	<?php
	while ($resultado = mysql_fetch_array($query)) {
		$id = $resultado["id"];
		$patrimonio = $resultado["patrimonio"];
		$sala = $resultado["sala"];
		$hostname = $resultado["hostname"];
		$predio = $resultado["predio"];
		$emUso = $resultado["emUso"];

		$emUsoOk = substr($emUso, 0, 1);

		if ($emUsoOk == "N") $emUso = "NÃO";

		if ($emUso == "NÃO") {
			$cor = "red";
		} else {
			$cor = "blue";
		}

/*		if ($predio == "74 - A") {
			$corPredio = "#2315589";
		}

		if ($predio == "74 - B") {
			$corPredio = "#24118154";
		}

		if ($predio == "74 - C") {
			$corPredio = "#10270108";
		}
*/
	?>

	<tr id="dados" bgcolor="<?php echo $corPredio;?>">
	<td><a href="frmDetalhePatrimonio.php?id=<?php echo $id;?>" style="color: <?php echo $cor;?>"><?php echo $patrimonio;?></style></a></td>
	<td><?php echo $sala;?></td>
	<td><?php echo $hostname;?></td>
	<td><?php echo $predio;?></td>
	<td><input type="checkbox" name="chkDeletar[]" value="<?php echo $id;?>"></td>
	</tr>

	<?php
	}
	?>
	<tr>
	<td colspan=4 align="center"><br><input type="submit" value="Apagar selecionados" style="width: 300px;"></td>
	</tr>
	</form>
	</table>
</div>

<?php
require_once ("rodape.php");
?>
