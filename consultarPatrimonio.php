<?php
require_once ("verifica.php");
require_once ("topo.php");
require_once ("conexao.php");

$enviar = $_POST["txtEnviar"];
$ordenar = $_GET["ordenar"];

if ($ordenar == "")
	$ordenar = "sala";

if ($enviar != 1) {
	$query = mysql_query("select * from patrimonio order by $ordenar desc") or die ("Erro ao selecionar dados do patrimônio! ".mysql_error());
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
	<td align="center" id=search>Pesquisar por:<br> <input type=radio name=rdCriterio value="patrimonio" checked> Patrimônio <input type=radio name=rdCriterio value="lacre"> Lacre <input type=radio name=rdCriterio value="sala"> Sala <input type=radio name=rdCriterio value="predio"> Prédio <input type=radio name=rdCriterio value="ad"> AD<br> <input type=radio name=rdCriterio value="padrao"> Padrão <input type=radio name=rdCriterio value="dataFormatacao"> Última Formatação <input type=radio name=rdCriterio value="marca"> Marca <input type=radio name=rdCriterio value="modelo"> Modelo <input type=radio name=rdCriterio value="numSerie"> Número Serial<br> <input type=radio name=rdCriterio value="processador"> Processador <input type=radio name=rdCriterio value="memoria"> Memória <input type=radio name=rdCriterio value="hd"> HD <input type=radio name=rdCriterio value="sistemaOperacional"> Sistema Operacional <input type=radio name=rdCriterio value="hostname"> Nome do computador<br> <input type=radio name=rdCriterio value="mac"> Endereço MAC <input type=radio name=rdCriterio value="ip"> Endereço IP <input type=radio name=rdCriterio value="bios"> BIOS <input type=radio name=rdCriterio value="tipo"> Tipo de PC <input type=radio name=rdCriterio value="tipoFW"> Tipo de Firmware<br> <input type=radio name=rdCriterio value="tipoArmaz"> Tipo de Armazenamento <input type=radio name=rdCriterio value="gpu"> Placa de Vídeo <input type=radio name=rdCriterio value="modoArmaz"> Modo de Operação <input type=radio name=rdCriterio value="secBoot"> Secure Boot<br> <input type=text name=txtPesquisar> <input type=submit value="OK"></td>
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
	<td><a href="?ordenar=marca">Modelo</a></td>
	<td><a href="?ordenar=dataFormatacao">Última manutenção</a></td>
	<td><a href="?ordenar=ip">Endereço IP</a></td>
	<td><a href="?ordenar=excluir">Excluir</a></td>
	<td><!-- Espaço para checkbox -->
	</tr>

	<?php
	while ($resultado = mysql_fetch_array($query)) {
		$id = $resultado["id"];
		$patrimonio = $resultado["patrimonio"];
		$sala = $resultado["sala"];
		$hostname = $resultado["hostname"];
		$marca = $resultado["marca"];
		$modelo = $resultado["modelo"];
		$emUso = $resultado["emUso"];
		$formatacao = $resultado["dataFormatacao"];
		$ip = $resultado["ip"];

		$emUsoOk = substr($emUso, 0, 1);

		if ($emUsoOk == "N") $emUso = "NÃO";

		if ($emUso == "NÃO") {
			$cor = "red";
		} else {
			$cor = "green";
		}

		$dataF = substr($formatacao, 0, 10);
		$dataExplodida = explode("-", $dataF);
		$dataFormatacao = $dataExplodida[2]."/".$dataExplodida[1]."/".$dataExplodida[0];
	?>

	<tr id="dados" bgcolor="<?php echo $corPredio;?>">
	<td><a href="frmDetalhePatrimonio.php?id=<?php echo $id;?>" style="color: <?php echo $cor;?>"><?php echo $patrimonio;?></style></a></td>
	<td><?php echo $sala;?></td>
	<td><?php echo $hostname;?></td>
	<td><?php echo $marca . " " . $modelo;?></td>
	<td><?php echo $dataFormatacao;?></td>
	<td><?php echo $ip;?></td>
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
