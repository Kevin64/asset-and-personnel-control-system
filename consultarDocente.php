<?php
require_once ("verifica.php");
require_once ("topo.php");
require_once ("conexao.php");

$enviar = $_POST["txtEnviar"];
$ordenar = $_GET["ordenar"];

if ($ordenar == "")
	$ordenar = "nome";

if ($enviar != 1) {
	$query = mysql_query("select * from docente order by $ordenar") or die ("Erro ao selecionar dados do docente! ".mysql_error());
} else {
	$rdCriterio = $_POST["rdCriterio"];
	$pesquisar = $_POST["txtPesquisar"];

	$query = mysql_query("select * from docente where $rdCriterio like '%$pesquisar%'") or die ("Erro ao efetuar a pesquisa! ".mysql_error());
}

$totalDocentes = mysql_num_rows(mysql_query("select * from docente"));
?>

<div id="meio">
	<h2>Lista de docentes (<?php echo $totalDocentes;?>)</h2><br>
	<table id="tbPesquisarDocente">
	<form action=consultarDocente.php method=post>
	<input type=hidden name=txtEnviar value=1>
	<tr>
	<td id=search>Pesquisar por: <input type=radio name=rdCriterio value="siape" checked>Siape <input type=radio name=rdCriterio value="nome"> Nome <input type=radio name=rdCriterio value="curso">Curso <input type=text name=txtPesquisar> <input type=submit value="OK"></td>
	</tr>
	</form>

	</table>
	<br><br>
	<table id="dadosDocente" cellspacing=0>
	<form action="apagaSelecionadosDocente.php" method="post">
	<tr id="cabecalho">
	<td><a href="?ordenar=siape">Siape</a></td>
	<td><a href="?ordenar=nome">Nome</a></td>
	<td><a href="?ordenar=curso">Curso</a></td>
	<td><a href="?ordenar=faltas">Faltas</a></td>
	<td><a href="?ordenar=excluir">Excluir</a></td>
	<td><!-- Espaço para checkbox -->
	</tr>

	<?php
	while ($resultado = mysql_fetch_array($query)) {
		$id = $resultado["id"];
		$siape = $resultado["siape"];
		$nome = $resultado["nome"];
		$curso = $resultado["curso"];
		$faltas = $resultado["faltas"];
		
	?>

	<tr id="dados" bgcolor="<?php echo $corPredio;?>">
	<td><a href="frmDetalheDocente.php?id=<?php echo $id;?>" style="color: <?php echo $cor;?>"><?php echo $siape;?></style></a></td>
	<td><?php echo $nome;?></td>
	<td><?php echo $curso;?></td>
	<td><input type="submit" class="button" name="menosfalta" value="<?php echo '-'?>"><?php echo $faltas;?><input type="submit" class="button" name="maisfalta" value="<?php echo '+'?>"></td>
	<td><input type="checkbox" name="chkDeletar[]" value="<?php echo $id;?>"></td>
	</tr>

	<?php
	}
	?>
	<tr>
	<td colspan=7 align="center"><br><input type="submit" value="Apagar selecionados" style="width: 300px;"></td>
	</tr>
	</form>
	</table>
</div>

<?php
require_once ("rodape.php");
?>
