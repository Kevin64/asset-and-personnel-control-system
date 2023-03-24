<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

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
	$queryAtivo = mysqli_query($conexao, "select * from (select * from patrimonio order by $ordenar $sort) T where descarte = 0") or die($translations["ERROR_QUERY_ASSET"] . mysqli_error($conexao));
	$queryDescarte = mysqli_query($conexao, "select * from (select * from patrimonio order by $ordenar $sort) T where descarte = 1") or die($translations["ERROR_QUERY_ASSET"] . mysqli_error($conexao));

	$totalAtivo = mysqli_num_rows($queryAtivo);
	$totalDescarte = mysqli_num_rows($queryDescarte);
} else {
	$queryPesquisa = mysqli_query($conexao, "select * from patrimonio where $rdCriterio like '%$pesquisar%'") or die($translations["ERROR_QUERY"] . mysqli_error($conexao));
	$totalPesquisa = mysqli_num_rows($queryPesquisa);
}

?>

<div id="meio">
	<table id="tbPesquisar">
		<form action=queryAsset.php method=post>
			<input type=hidden name=txtEnviar value=1>
			<tr>
				<td align=center><?php echo $translations["SEARCH_FOR"] ?></td>
			</tr>
			<tr>
				<td align=center>
					<select id=filterPatrimonio name=rdCriterio>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "patrimonio") echo "selected='selected'"; ?>value="patrimonio"><?php echo $translations["ASSETS_ACTIVE"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "descarte") echo "selected='selected'"; ?>value="descarte"><?php echo $translations["ASSETS_DISCARDED"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "lacre") echo "selected='selected'"; ?>value="lacre"><?php echo $translations["SEAL_NUMBER"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "sala") echo "selected='selected'"; ?>value="sala"><?php echo $translations["ASSET_ROOM"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "predio") echo "selected='selected'"; ?>value="predio"><?php echo $translations["BUILDING"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "ad") echo "selected='selected'"; ?>value="ad"><?php echo $translations["AD_REGISTERED"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "padrao") echo "selected='selected'"; ?>value="padrao"><?php echo $translations["STANDARD"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "dataFormatacao") echo "selected='selected'"; ?>value="dataFormatacao"><?php echo $translations["LAST_MAINTENANCE_DATE"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "marca") echo "selected='selected'"; ?>value="marca"><?php echo $translations["BRAND"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "modelo") echo "selected='selected'"; ?>value="modelo"><?php echo $translations["MODEL"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "numSerie") echo "selected='selected'"; ?>value="numSerie"><?php echo $translations["SERIAL_NUMBER"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "processador") echo "selected='selected'"; ?>value="processador"><?php echo $translations["PROCESSOR"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "memoria") echo "selected='selected'"; ?>value="memoria"><?php echo $translations["RAM"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "hd") echo "selected='selected'"; ?>value="hd"><?php echo $translations["STORAGE_SIZE"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "sistemaOperacional") echo "selected='selected'"; ?>value="sistemaOperacional"><?php echo $translations["OPERATING_SYSTEM"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "hostname") echo "selected='selected'"; ?>value="hostname"><?php echo $translations["HOSTNAME"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "mac") echo "selected='selected'"; ?>value="mac"><?php echo $translations["MAC_ADDRESS"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "ip") echo "selected='selected'"; ?>value="ip"><?php echo $translations["IP_ADDRESS"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "bios") echo "selected='selected'"; ?>value="bios"><?php echo $translations["FW_VERSION"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "tipo") echo "selected='selected'"; ?>value="tipo"><?php echo $translations["HW_TYPE"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "tipoFW") echo "selected='selected'"; ?>value="tipoFW"><?php echo $translations["FW_TYPE"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "tipoArmaz") echo "selected='selected'"; ?>value="tipoArmaz"><?php echo $translations["STORAGE_TYPE"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "gpu") echo "selected='selected'"; ?>value="gpu"><?php echo $translations["VIDEO_CARD"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "modoArmaz") echo "selected='selected'"; ?>value="modoArmaz"><?php echo $translations["MEDIA_OPERATION_MODE"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "secBoot") echo "selected='selected'"; ?>value="secBoot"><?php echo $translations["SECURE_BOOT"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "vt") echo "selected='selected'"; ?>value="vt"><?php echo $translations["VIRTUALIZATION_TECHNOLOGY"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "tpm") echo "selected='selected'"; ?>value="tpm"><?php echo $translations["TPM_VERSION"] ?></option>
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
		<h3><?php echo $translations["ASSETS_ACTIVE"] ?> (<?php echo $totalAtivo; ?>)</h3>
		<h3><?php echo $translations["ASSETS_DISCARDED"] ?> (<?php echo $totalDescarte; ?>)</h3><br>
	<?php
	}
	else {
		$queryAtivo = $queryPesquisa;
	?>
		<h3><?php echo $translations["RESULTING_ASSETS"] ?> (<?php echo $totalPesquisa; ?>)</h3><br>
	<?php
	}
	?>
	<table id="dadosPatrimonio" cellspacing=0>
		<form action="apagaSelecionadosPatrimonio.php" method="post">
			<tr id="cabecalho">
				<?php
				if (isset($_SESSION["nivel"])) {
					if ($_SESSION["nivel"] == $json_config_array["ADMIN_LEVEL"]) {
				?>
						<td><img src="img/trash.png" width="22" height="29"></td>
				<?php
					}
				}
				?>
				<td><a href="?ordenar=patrimonio&sort=<?php echo $sort; ?>"><?php echo $translations["SHORT_ASSET"] ?></a></td>
				<?php
				if (!in_array(true, $devices)) {
				?>
					<td><a href="?ordenar=predio&sort=<?php echo $sort; ?>"><?php echo $translations["BUILDING"] ?></a></td>
				<?php
				}
				?>
				<td><a href="?ordenar=sala&sort=<?php echo $sort; ?>"><?php echo $translations["ASSET_ROOM"] ?></a></td>
				<?php
				if (!in_array(true, $devices)) {
				?>
					<td><a href="?ordenar=padrao&sort=<?php echo $sort; ?>"><?php echo $translations["STANDARD"] ?></a></td>
					<td><a href="?ordenar=marca&sort=<?php echo $sort; ?>"><?php echo $translations["BRAND"] ?></a></td>
				<?php
				}
				?>
				<td><a href="?ordenar=modelo&sort=<?php echo $sort; ?>"><?php echo $translations["MODEL"] ?></a></td>
				<?php
				if (!in_array(true, $devices)) {
				?>
					<td><a href="?ordenar=ip&sort=<?php echo $sort; ?>"><?php echo $translations["IP_ADDRESS"] ?></a></td>
				<?php
				}
				?>
				<td><a href="?ordenar=dataFormatacao&sort=<?php echo $sort; ?>"><?php echo $translations["SHORT_LAST_MAINTENANCE_DATE"] ?></a></td>
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
						if ($_SESSION["nivel"] == $json_config_array["ADMIN_LEVEL"]) {
					?>
							<td><input type="checkbox" name="chkDeletar[]" value="<?php echo $id; ?>" onclick="var input = document.getElementById('eraseButton'); if(this.checked){ input.disabled = false;}else{input.disabled=true;}" <?php if($descarte == 1) { ?> disabled <?php } ?>></td>
					<?php
						}
					}
					?>
					<td><a href="formDetailAsset.php?id=<?php echo $id; ?>" <?php if($descarte == 1) { ?> id=discarded <?php } else { ?> style="color: <?php echo $cor; }?>"><?php echo $patrimonio; ?></a></td>
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
							if ($_SESSION["nivel"] == $json_config_array["ADMIN_LEVEL"]) {
						?>
								<td><input type="checkbox" name="chkDeletar[]" value="<?php echo $id; ?>" onclick="var input = document.getElementById("eraseButton"); if(this.checked){ input.disabled = false;}else{input.disabled=true;}" <?php if($descarte == 1) { ?> disabled <?php } ?>></td>
						<?php
							}
						}
						?>
						<td><a href="formDetailAsset.php?id=<?php echo $id; ?>" <?php if($descarte == 1) { ?> id=discarded <?php } else { ?> style="color: <?php echo $cor; }?>"><?php echo $patrimonio; ?></a></td>
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
				if ($_SESSION["nivel"] == $json_config_array["ADMIN_LEVEL"]) {
				?>
					<tr>
						<td colspan=9 align="center"><br><input id="eraseButton" type="submit" value=<?php echo $translations["LABEL_ERASE_BUTTON"] ?> disabled></td>
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