<?php
require_once("checkSession.php");
require_once("top.php");
require_once __DIR__ . "/connection.php";

$enviar = null;
$ordenar = null;
$rdCriterio = null;
$pesquisar = null;

if (isset($_POST["txtEnviar"]))
	$enviar = $_POST["txtEnviar"];

if (isset($_GET["ordenar"]))
	$ordenar = $_GET["ordenar"];

if (isset($_GET["sort"]))
	$sort = $_GET["sort"];

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
	$queryAtivo = mysqli_query($conexao, "select * from (select * from patrimonio order by $ordenar $sort) T where descarte = 0") or die("Erro ao selecionar dados do patrimônio! " . mysqli_error($conexao));
	$queryDescarte = mysqli_query($conexao, "select * from (select * from patrimonio order by $ordenar $sort) T where descarte = 1") or die("Erro ao selecionar dados do patrimônio! " . mysqli_error($conexao));

	$totalAtivo = mysqli_num_rows($queryAtivo);
	$totalDescarte = mysqli_num_rows($queryDescarte);
} else {
	$queryPesquisa = mysqli_query($conexao, "select * from patrimonio where $rdCriterio like '%$pesquisar%'") or die("Erro ao efetuar a pesquisa! " . mysqli_error($conexao));
	$totalPesquisa = mysqli_num_rows($queryPesquisa);
}

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
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "patrimonio") echo "selected='selected'"; ?>value="patrimonio">Patrimônio</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "descarte") echo "selected='selected'"; ?>value="descarte">Patrimônio baixado</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "lacre") echo "selected='selected'"; ?>value="lacre">Lacre</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "sala") echo "selected='selected'"; ?>value="sala">Sala</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "predio") echo "selected='selected'"; ?>value="predio">Prédio</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "ad") echo "selected='selected'"; ?>value="ad">Cadastrado no Active Directory</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "padrao") echo "selected='selected'"; ?>value="padrao">Padrão</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "dataFormatacao") echo "selected='selected'"; ?>value="dataFormatacao">Data da última manutenção</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "marca") echo "selected='selected'"; ?>value="marca">Marca</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "modelo") echo "selected='selected'"; ?>value="modelo">Modelo</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "numSerie") echo "selected='selected'"; ?>value="numSerie">Número de Série</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "processador") echo "selected='selected'"; ?>value="processador">Processador</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "memoria") echo "selected='selected'"; ?>value="memoria">Memória RAM</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "hd") echo "selected='selected'"; ?>value="hd">Tamanho do Disco Rígido</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "sistemaOperacional") echo "selected='selected'"; ?>value="sistemaOperacional">Sistema Operacional</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "hostname") echo "selected='selected'"; ?>value="hostname">Nome do Computador</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "mac") echo "selected='selected'"; ?>value="mac">Endereço MAC</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "ip") echo "selected='selected'"; ?>value="ip">Endereço IP</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "bios") echo "selected='selected'"; ?>value="bios">Versão da BIOS/UEFI</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "tipo") echo "selected='selected'"; ?>value="tipo">Tipo de PC</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "tipoFW") echo "selected='selected'"; ?>value="tipoFW">Tipo de Firmware</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "tipoArmaz") echo "selected='selected'"; ?>value="tipoArmaz">Tipo de Armazenamento</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "gpu") echo "selected='selected'"; ?>value="gpu">Placa de Vídeo</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "modoArmaz") echo "selected='selected'"; ?>value="modoArmaz">Modo de Operação SATA/M.2</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "secBoot") echo "selected='selected'"; ?>value="secBoot">Secure Boot</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "vt") echo "selected='selected'"; ?>value="vt">Tecnologia de Virtualização</option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "tpm") echo "selected='selected'"; ?>value="tpm">Versão do Módulo TPM</option>
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
	<?php
	if(!isset($totalPesquisa)) {
	?>
		<h3>Patrimônios ativos (<?php echo $totalAtivo; ?>)</h3>
		<h3>Patrimônios baixados (<?php echo $totalDescarte; ?>)</h3><br>
	<?php
	}
	else {
		$queryAtivo = $queryPesquisa;
	?>
		<h3>Patrimônios resultantes (<?php echo $totalPesquisa; ?>)</h3><br>
	<?php
	}
	?>
	<table id="dadosPatrimonio" cellspacing=0>
		<form action="apagaSelecionadosPatrimonio.php" method="post">
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
			while ($resultado = mysqli_fetch_array($queryAtivo)) {
				$id = $resultado["id"];
				$patrimonio = $resultado["patrimonio"];
				$descarte = $resultado["descarte"];
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
					if (isset($_SESSION["nivel"])) {
						if ($_SESSION["nivel"] == "Administrador") {
					?>
							<td><input type="checkbox" name="chkDeletar[]" value="<?php echo $id; ?>" onclick="var input = document.getElementById('eraseButton'); if(this.checked){ input.disabled = false;}else{input.disabled=true;}" <?php if($descarte == 1) { ?> disabled <?php } ?>></td>
					<?php
						}
					}
					?>
					<td><a href="frmDetalhePatrimonio.php?id=<?php echo $id; ?>" <?php if($descarte == 1) { ?> id=discarded <?php } else { ?> style="color: <?php echo $cor; }?>"><?php echo $patrimonio; ?></a></td>
					<?php
					if (!in_array(true, $devices)) {
					?>
						<td><label <?php if($descarte == 1) { ?> id=discarded <?php } ?>><?php echo $predio; ?></label></td>
					<?php
					}
					?>
					<td><label <?php if($descarte == 1) { ?> id=discarded <?php } ?>><?php echo $sala; ?></label></td>
					<?php
					if (!in_array(true, $devices)) {
					?>
						<td><label <?php if($descarte == 1) { ?> id=discarded <?php } ?>><?php echo $padrao; ?></label></td>
						<td><label <?php if($descarte == 1) { ?> id=discarded <?php } ?>><?php echo $marca; ?></label></td>
					<?php
					}
					?>
					<td><label <?php if($descarte == 1) { ?> id=discarded <?php } ?>><?php echo $modelo; ?></label></td>
					<?php
					if (!in_array(true, $devices)) {
					?>
						<td><label <?php if($descarte == 1) { ?> id=discarded <?php } ?>><?php echo $ip; ?></label></td>
					<?php
					}
					?>
					<td><label <?php if($descarte == 1) { ?> id=discarded <?php } ?>><?php echo $dataFormatacao; ?></label></td>
				</tr>
				<?php
			}
			if(!isset($totalPesquisa)) {
				while ($resultado = mysqli_fetch_array($queryDescarte)) {
					$id = $resultado["id"];
					$patrimonio = $resultado["patrimonio"];
					$descarte = $resultado["descarte"];
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
						if (isset($_SESSION["nivel"])) {
							if ($_SESSION["nivel"] == "Administrador") {
						?>
								<td><input type="checkbox" name="chkDeletar[]" value="<?php echo $id; ?>" onclick="var input = document.getElementById("eraseButton"); if(this.checked){ input.disabled = false;}else{input.disabled=true;}" <?php if($descarte == 1) { ?> disabled <?php } ?>></td>
						<?php
							}
						}
						?>
						<td><a href="frmDetalhePatrimonio.php?id=<?php echo $id; ?>" <?php if($descarte == 1) { ?> id=discarded <?php } else { ?> style="color: <?php echo $cor; }?>"><?php echo $patrimonio; ?></a></td>
						<?php
						if (!in_array(true, $devices)) {
						?>
							<td><label <?php if($descarte == 1) { ?> id=discarded <?php } ?>><?php echo $predio; ?></label></td>
						<?php
						}
						?>
						<td><label <?php if($descarte == 1) { ?> id=discarded <?php } ?>><?php echo $sala; ?></label></td>
						<?php
						if (!in_array(true, $devices)) {
						?>
							<td><label <?php if($descarte == 1) { ?> id=discarded <?php } ?>><?php echo $padrao; ?></label></td>
							<td><label <?php if($descarte == 1) { ?> id=discarded <?php } ?>><?php echo $marca; ?></label></td>
						<?php
						}
						?>
						<td><label <?php if($descarte == 1) { ?> id=discarded <?php } ?>><?php echo $modelo; ?></label></td>
						<?php
						if (!in_array(true, $devices)) {
						?>
							<td><label <?php if($descarte == 1) { ?> id=discarded <?php } ?>><?php echo $ip; ?></label></td>
						<?php
						}
						?>
						<td><label <?php if($descarte == 1) { ?> id=discarded <?php } ?>><?php echo $dataFormatacao; ?></label></td>
					</tr>
					<?php
				}
			}
			if (isset($_SESSION["nivel"])) {
				if ($_SESSION["nivel"] == "Administrador") {
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
require_once("foot.php");
?>