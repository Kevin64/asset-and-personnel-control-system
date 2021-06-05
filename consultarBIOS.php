<?php
require_once ("verifica.php");
require_once ("topo.php");
require_once __DIR__ . '/../conexao.php';

$enviar = $_POST["txtEnviar"];
$ordenar = $_GET["ordenar"];
$query = null;

if ($enviar != 1) {
	$query = mysql_query("select * from bios") or die ("Erro ao selecionar dados de BIOS! ".mysql_error());
} else {
	$rdCriterio = $_POST["rdCriterio"];
	$pesquisar = $_POST["txtPesquisar"];

	$query = mysql_query("select * from bios where $rdCriterio like '%$pesquisar%'") or die ("Erro ao efetuar a pesquisa! ".mysql_error());
}

$totalSalas = mysql_num_rows(mysql_query("select * from bios"));
?>

<div id="meio">
	<h2>Lista de BIOS (<?php echo $totalSalas;?>)</h2><br>
	<table id="tbPesquisarBIOS">
	<form action=consultarBIOS.php method=post>
	<input type=hidden name=txtEnviar value=1>
	<tr>
	<td align="center" id=search>Pesquisar por:<br> <input type=radio name=rdCriterio value="modelo" checked> Modelo <input type=radio name=rdCriterio value="marca"> Marca <input type=radio name=rdCriterio value="versao"> Versão <input type=radio name=rdCriterio value="tipo"> Tipo <input type=text name=txtPesquisar> <input type=submit value="OK"></td>
	</tr>
	</form>

	</table>
	<br><br>
	<table id="dadosBIOS" cellspacing=0>
	<form action="apagaSelecionadosBIOS.php" method="post">
	<tr id="cabecalho">
	<td><a href="?ordenar=modelo">Modelo</a></td>
	<td><a href="?ordenar=marca">Marca</a></td>
	<td><a href="?ordenar=versao">Versão</a></td>
	<td><a href="?ordenar=tipo">Tipo</a></td>
	<td><a href="?ordenar=excluir">Excluir</a></td>
	<td><!-- Espaço para checkbox -->
	</tr>

	<?php
	while ($resultado = mysql_fetch_array($query)) {
		$id = $resultado["id"];
		$marca = $resultado["marca"];
		$modelo = $resultado["modelo"];
		$versao = $resultado["versao"];
		$tipo = $resultado["tipo"];
	?>

	<tr id="dados" bgcolor="<?php echo $corPredio;?>">
	<td><a href="frmDetalheBIOS.php?id=<?php echo $id;?>" style="color: <?php echo $cor;?>"><?php echo $modelo;?></style></a></td>
	<td><?php echo $marca;?></td>
	<td><?php echo $versao;?></td>
	<td><?php echo $tipo;?></td>
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
