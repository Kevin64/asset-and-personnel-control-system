<?php
require_once("verifica.php");
require_once("topo.php");
require_once __DIR__ . '/../conexao.php';

$enviar = null;
$ordenar = null;
$rdCriterio = null;
$pesquisar = null;

if (isset($_POST["txtEnviar"]))
	$enviar = $_POST["txtEnviar"];

if (isset($_GET["ordenar"]))
	$ordenar = $_GET["ordenar"];

if (isset($_GET['sort']))
	$sort = $_GET['sort'];

if (isset($_POST["rdCriterio"]))
	$rdCriterio = $_POST["rdCriterio"];

if (isset($_POST["txtPesquisar"]))
	$pesquisar = $_POST["txtPesquisar"];

if ($ordenar == "")
	$ordenar = "dataFormatacao";

if (isset($sort) and $sort == "desc") {
	$sort = "asc";
} else {
	$sort = "desc";
}

if ($enviar != 1) {
	$query = mysqli_query($conexao, "select * from patrimonio order by $ordenar $sort") or die("Erro ao selecionar dados do patrimônio! " . mysqli_error($conexao));
} else {
	$query = mysqli_query($conexao, "select * from patrimonio where $rdCriterio like '%$pesquisar%'") or die("Erro ao efetuar a pesquisa! " . mysqli_error($conexao));
}

$totalSalas = mysqli_num_rows($query);
?>

<div id="meio">
	<table id="tbPesquisar">
		<form action=consultarPatrimonio.php method=post>
			<input type=hidden name=txtEnviar value=1>
			<tr>
				<td align=center>Pesquisar por:</td>
			</tr>
			<tr>
				<td align=center>
					<select id=filterPatrimonio name=rdCriterio>
						<option value="patrimonio">Patrimônio</option>
						<option value="lacre">Lacre</option>
						<option value="sala">Sala</option>
						<option value="predio">Prédio</option>
						<option value="ad">Cadastrado no Active Directory</option>
						<option value="padrao">Padrão</option>
						<option value="dataFormatacao">Data da última manutenção</option>
						<option value="marca">Marca</option>
						<option value="modelo">Modelo</option>
						<option value="numSerie">Número de Série</option>
						<option value="processador">Processador</option>
						<option value="memoria">Memória RAM</option>
						<option value="hd">Tamanho do Disco Rígido</option>
						<option value="sistemaOperacional">Sistema Operacional</option>
						<option value="hostname">Nome do Computador</option>
						<option value="mac">Endereço MAC</option>
						<option value="ip">Endereço IP</option>
						<option value="bios">Versão da BIOS/UEFI</option>
						<option value="tipo">Tipo de PC</option>
						<option value="tipoFW">Tipo de Firmware</option>
						<option value="tipoArmaz">Tipo de Armazenamento</option>
						<option value="gpu">Placa de Vídeo</option>
						<option value="modoArmaz">Modo de Operação SATA/M.2</option>
						<option value="secBoot">Secure Boot</option>
						<option value="vt">Tecnologia de Virtualização</option>
						<option value="tpm">Versão do Módulo TPM</option>
					</select>
					<input style="width:300px" type=text name=txtPesquisar> <input id="searchButton" type=submit value="OK">
				</td>
			</tr>
		</form>
	</table>
	<br><br>
	<h2>Lista de patrimônios (<?php echo $totalSalas; ?>)</h2><br>
	<table id="dadosPatrimonio" cellspacing=0>
		<form action="apagaSelecionados.php" method="post">
			<tr id="cabecalho">
				<?php
				if (isset($_SESSION['nivel'])) {
					if ($_SESSION["nivel"] == "adm") {
				?>
						<td><img src="img/trash.png" width="22" height="29"></td>
				<?php
					}
				}
				?>
				<td><a href="?ordenar=patrimonio&sort=<?php echo $sort; ?>">Patrim.</a></td>
				<?php
				if (!in_array(true, $devices)) {
				?>
					<td><a href="?ordenar=predio&sort=<?php echo $sort; ?>">Prédio</a></td>
				<?php
				}
				?>
				<td><a href="?ordenar=sala&sort=<?php echo $sort; ?>">Sala</a></td>
				<?php
				if (!in_array(true, $devices)) {
				?>
					<td><a href="?ordenar=padrao&sort=<?php echo $sort; ?>">Padrão</a></td>
					<td><a href="?ordenar=marca&sort=<?php echo $sort; ?>">Marca</a></td>
				<?php
				}
				?>
				<td><a href="?ordenar=modelo&sort=<?php echo $sort; ?>">Modelo</a></td>
				<?php
				if (!in_array(true, $devices)) {
				?>
					<td><a href="?ordenar=ip&sort=<?php echo $sort; ?>">Endereço IP</a></td>
				<?php
				}
				?>
				<td><a href="?ordenar=dataFormatacao&sort=<?php echo $sort; ?>">Últ. manut.</a></td>
			</tr>
			<?php
			while ($resultado = mysqli_fetch_array($query)) {
				$id = $resultado["id"];
				$patrimonio = $resultado["patrimonio"];
				$predio = $resultado["predio"];
				$sala = $resultado["sala"];
				$padrao = $resultado["padrao"];
				$marca = $resultado["marca"];
				$modelo = $resultado["modelo"];
				$emUso = $resultado["emUso"];
				$formatacao = $resultado["dataFormatacao"];
				$ip = $resultado["ip"];

				$emUsoOk = substr($emUso, 0, 1);

				if ($emUsoOk == "N") $emUso = "Não";

				if ($emUso == "Não") {
					$cor = "red";
				} else {
					$cor = "green";
				}

				$dataF = substr($formatacao, 0, 10);
				$dataExplodida = explode("-", $dataF);
				if ($dataExplodida[0] != "")
					$dataFormatacao = $dataExplodida[2] . "/" . $dataExplodida[1] . "/" . $dataExplodida[0];
			?>
				<tr id="dados">
					<?php
					if (isset($_SESSION['nivel'])) {
						if ($_SESSION["nivel"] == "adm") {
					?>
							<td><input type="checkbox" name="chkDeletar[]" value="<?php echo $id; ?>" onclick="var input = document.getElementById('eraseButton'); if(this.checked){ input.disabled = false;}else{input.disabled=true;}"></td>
					<?php
						}
					}
					?>
					<td><a href="frmDetalhePatrimonio.php?id=<?php echo $id; ?>" style="color: <?php echo $cor; ?>"><?php echo $patrimonio; ?></style></a></td>
					<?php
					if (!in_array(true, $devices)) {
					?>
						<td><?php echo $predio; ?></td>
					<?php
					}
					?>
					<td><?php echo $sala; ?></td>
					<?php
					if (!in_array(true, $devices)) {
					?>
						<td><?php echo $padrao; ?></td>
						<td><?php echo $marca; ?></td>
					<?php
					}
					?>
					<td><?php echo $modelo;	?></td>
					<?php
					if (!in_array(true, $devices)) {
					?>
						<td><?php echo $ip; ?></td>
					<?php
					}
					?>
					<td><?php echo $dataFormatacao; ?></td>
				</tr>
				<?php
			}
			if (isset($_SESSION['nivel'])) {
				if ($_SESSION["nivel"] == "adm") {
				?>
					<tr>
						<td colspan=9 align="center"><br><input id="eraseButton" type="submit" value="Apagar selecionados" disabled></td>
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