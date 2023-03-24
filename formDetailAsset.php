<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$enviar = null;
$idPatrimonio = null;
$patrimonioFK = null;

if (isset($_POST["txtEnviar"]))
	$enviar = $_POST["txtEnviar"];

if ($enviar != 1) {
	if (isset($_GET["id"]))
		$idPatrimonio = $_GET["id"];

	if (isset($_GET["patrimonioFK"]))
		$patrimonioFK = $_GET["patrimonioFK"];

	$query = mysqli_query($conexao, "select * from patrimonio where id = '$idPatrimonio'") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($conexao));
	$queryFormatAnt = mysqli_query($conexao, "select manutencoes.dataFormatacoesAnteriores, manutencoes.modoServico, manutencoes.trocaPilha, manutencoes.ticketNum, manutencoes.agent from (select * from patrimonio where id = '$idPatrimonio') as p inner join manutencoes on p.patrimonio = manutencoes.patrimonioFK") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($conexao));
} else {
	$idPatrimonio = $_POST["txtIdPatrimonio"];
	$patrimonio = $_POST["txtPatrimonio"];
	if (isset($_POST["chkBoxDescarte"])) {
		$descarte = $_POST["chkBoxDescarte"];
	} else {
		$descarte = "0";
	}
	$predio = $_POST["txtPredio"];
	$sala = $_POST["txtSala"];
	$siape = $_POST["txtSiapeRecebedor"];
	if (isset($_POST["txtEntregador"]))
		$entregador = $_POST["txtEntregador"];
	$dataEntrega = $_POST["txtDataEntrega"];
	$padrao = $_POST["txtPadrao"];
	$observacao = $_POST["txtObservacao"];
	$ultimaFormatacao = $_POST["txtUltimaFormatacao"];
	if (isset($_POST["txtFormatacoesAnterioresData"]))
		$manutencoesAnterioresData = $_POST["txtFormatacoesAnterioresData"];
	if (isset($_POST["txtFormatacoesAnterioresModo"]))
		$manutencoesAnterioresModo = $_POST["txtFormatacoesAnterioresModo"];
	if (isset($_POST["txtFormatacoesAnterioresPilha"]))
		$manutencoesAnterioresPilha = $_POST["txtFormatacoesAnterioresPilha"];
	if (isset($_POST["txtFormatacoesAnterioresTicket"]))
		$manutencoesAnterioresTicket = $_POST["txtFormatacoesAnterioresTicket"];
	if (isset($_POST["txtFormatacoesAnterioresAgente"]))
		$manutencoesAnterioresAgente = $_POST["txtFormatacoesAnterioresAgente"];
	$ad = $_POST["txtAd"];
	$marca = $_POST["txtMarca"];
	$modelo = $_POST["txtModelo"];
	$numSerie = $_POST["txtNumSerie"];
	$processador = $_POST["txtProcessador"];
	$memoria = $_POST["txtMemoria"];
	$hd = $_POST["txtHd"];
	$sistemaOperacional = $_POST["txtSistemaOperacional"];
	$hostname = $_POST["txtHostName"];
	$emUso = $_POST["txtEmUso"];
	$lacre = $_POST["txtLacre"];
	$etiqueta = $_POST["txtEtiqueta"];
	$tipo = $_POST["txtTipo"];
	$tipoFW = $_POST["txtTipoFW"];
	$mac = $_POST["txtMac"];
	$ip = $_POST["txtIp"];
	$bios = $_POST["txtBIOS"];
	$tipoArmaz = $_POST["txtTipoArmaz"];
	$gpu = $_POST["txtGPU"];
	$modoArmaz = $_POST["txtModoArmaz"];
	$secBoot = $_POST["txtSecBoot"];
	$vt = $_POST["txtVT"];
	$tpm = $_POST["txtTPM"];

	//Atualizando os dados do patrimônio
	mysqli_query($conexao, "update patrimonio set patrimonio = '$patrimonio', descarte = '$descarte', predio = '$predio', sala = '$sala', siapeRecebedor = '$siape', dataEntrega = '$dataEntrega', padrao = '$padrao', observacao = '$observacao', dataFormatacao = '$ultimaFormatacao', ad = '$ad', marca = '$marca', modelo = '$modelo', numSerie = '$numSerie', processador = '$processador', memoria = '$memoria', hd = '$hd', sistemaOperacional = '$sistemaOperacional', hostname = '$hostname', bios = '$bios', emUso = '$emUso', lacre = '$lacre', etiqueta = '$etiqueta', tipo = '$tipo', tipoFW = '$tipoFW', tipoArmaz = '$tipoArmaz', mac = '$mac', ip = '$ip', gpu = '$gpu', modoArmaz = '$modoArmaz', secBoot = '$secBoot', vt = '$vt', tpm = '$tpm' where id = '$idPatrimonio'") or die($translations["ERROR_UPDATE_ASSET_DATA"] . mysqli_error($conexao));

	$query = mysqli_query($conexao, "select * from patrimonio where id = '$idPatrimonio'") or die($translations["ERROR_QUERY_ASSET"] . mysqli_error($conexao));
	$queryFormatAnt = mysqli_query($conexao, "select manutencoes.dataFormatacoesAnteriores, manutencoes.modoServico, manutencoes.trocaPilha, manutencoes.ticketNum, manutencoes.agent from (select * from patrimonio where id = '$idPatrimonio') as p inner join manutencoes on p.patrimonio = manutencoes.patrimonioFK") or die($translations["ERROR_QUERY_ASSET"] . mysqli_error($conexao));
}
?>
<div id="meio">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script src="js/disable-controls.js"></script>
	<form action="frmDetalhePatrimonio.php" method="post" id="frmGeneral">
		<input type=hidden name=txtEnviar value="1">
		<h2>Detalhes do patrimônio</h2><br>
		<?php
		if ($enviar == 1)
			echo "<font color=blue>" . $translations["SUCCESS_UPDATE_ASSET_DATA"] . "</font><br><br>";
		?>
		<label id=asteriskWarning>Os campos marcados com asterisco (<mark id=asterisk>*</mark>) são obrigatórios!</label>
		<table id="frmFields">
			<?php
			while ($resultado = mysqli_fetch_array($query)) {
				$idPatrimonio = $resultado["id"];
				$patrimonio = $resultado["patrimonio"];
				$descarte = $resultado["descarte"];
				$predio = $resultado["predio"];
				$sala = $resultado["sala"];
				$siape = $resultado["siapeRecebedor"];
				$dataEntrega = $resultado["dataEntrega"];
				$entregador = $resultado["entregador"];
				$observacao = $resultado["observacao"];
				$ultimaFormatacao = $resultado["dataFormatacao"];
				$padrao = $resultado["padrao"];
				$ad = $resultado["ad"];
				$marca = $resultado["marca"];
				$modelo = $resultado["modelo"];
				$numSerie = $resultado["numSerie"];
				$processador = $resultado["processador"];
				$memoria = $resultado["memoria"];
				$hd = $resultado["hd"];
				$sistemaOperacional = $resultado["sistemaOperacional"];
				$hostname = $resultado["hostname"];
				$emUso = $resultado["emUso"];
				$lacre = $resultado["lacre"];
				$etiqueta = $resultado["etiqueta"];
				$tipo = $resultado["tipo"];
				$mac = $resultado["mac"];
				$ip = $resultado["ip"];
				$bios = $resultado["bios"];
				$tipoFW = $resultado["tipoFW"];
				$tipoArmaz = $resultado["tipoArmaz"];
				$gpu = $resultado["gpu"];
				$modoArmaz = $resultado["modoArmaz"];
				$secBoot = $resultado["secBoot"];
				$vt = $resultado["vt"];
				$tpm = $resultado["tpm"];
				$trocaPilha = $resultado["trocaPilha"];
				$ticketNum = $resultado["ticketNum"];

				$adOk = substr($ad, 0, 1);
				$padraoOk = substr($padrao, 0, 1);
				$emUsoOk = substr($emUso, 0, 1);
				$etiquetaOk = substr($etiqueta, 0, 1);

				if ($adOk == "N") $ad = "Não";
				if ($padraoOk == "N") $padrao = "Não";
				if ($emUsoOk == "N") $emUso = "Não";
				if ($etiquetaOk == "N") $etiqueta = "Não";
			?>
				<?php
				if (isset($_SESSION["nivel"])) {
					if ($_SESSION["nivel"] == $json_config_array["ADMIN_LEVEL"]) {
				?>
						<tr>
							<td id="label"><?php echo $translations["DISCARDED_ASSET_QUESTION"] ?></td>
							<td colspan=5><input type=checkbox class=chkBox name=chkBoxDescarte value="1" <?php echo ($resultado["descarte"] == 1 ? "checked" : ""); ?>></td>
						</tr>
				<?php
					}
				}
				?>
				<tr>
					<td colspan=7 id=separador><?php echo $translations["ASSET_DATA"] ?></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["ASSET_NUMBER"] ?><mark id=asterisk>*</mark></td>
					<input type=hidden name=txtIdPatrimonio value="<?php echo $idPatrimonio; ?>">
					<td colspan=5><input type=text name=txtPatrimonio placeholder="Ex.: 123456" maxlength="6" required value="<?php echo $patrimonio; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["BUILDING"] ?><mark id=asterisk>*</mark></td>
					<td colspan=5>
						<select id="frmFields" name="txtPredio" required>
							<?php
							foreach ($building_array as $str) {
							?>
								<option value=<?php echo $str ?> <?php if ($predio == $str) echo "selected"; ?>><?php echo $str ?></option>
							<?php
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["ASSET_ROOM"] ?><mark id=asterisk>*</mark></td>
					<td colspan=5><input id="frmFields" type=text name=txtSala placeholder="Ex.: 4413" maxlength="4" required value="<?php echo $sala; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["DELIVERED_TO_REGISTRATION_NUMBER"] ?></td>
					<td colspan=5><input type=text name=txtSiapeRecebedor maxlength="8" value="<?php echo $siape; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["LAST_DELIVERY_DATE"] ?></td>
					<td colspan=5><input type=date name=txtDataEntrega value="<?php echo $dataEntrega; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["LAST_DELIVERY_MADE_BY"] ?></td>
					<td colspan=5><label name=txtEntregador style=line-height:40px;color:green;font-size:12pt><?php echo $entregador; ?></label></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["NOTE"] ?></td>
					<td colspan=5><textarea name=txtObservacao cols=20 rows=2 placeholder="Opcional: Campo dedicado para observações e notas referente ao bem patrimonial"><?php echo $observacao; ?></textarea></td>
				</tr>
		</table>
		<table>
			<tr>
				<td colspan=5 id=separador><?php echo $translations["PERFORMED_MAINTENANCES_TITLE"] ?></td>
			<tr id=headerPreviousMaintenance>
				<td><?php echo $translations["PERFORMED_MAINTENANCES_DATE"] ?></td>
				<td><?php echo $translations["PERFORMED_MAINTENANCES_SERVICE"] ?></td>
				<td><?php echo $translations["PERFORMED_MAINTENANCES_BATTERY"] ?></td>
				<td><?php echo $translations["PERFORMED_MAINTENANCES_TICKET"] ?></td>
				<td><?php echo $translations["PERFORMED_MAINTENANCES_USER"] ?></td>
			</tr>
			<?php
				while ($resultadoFormatAnt = mysqli_fetch_array($queryFormatAnt)) {
			?>
				<tr id=bodyPreviousMaintenance>
					<td>
						<label name=txtFormatacoesAnterioresData>
							<?php $manutencoesAnterioresData = $resultadoFormatAnt["dataFormatacoesAnteriores"];
							$dataFA = substr($manutencoesAnterioresData, 0, 10);
							$dataExplodidaA = explode("-", $dataFA);
							$manutencoesAnterioresData = $dataExplodidaA[2] . "/" . $dataExplodidaA[1] . "/" . $dataExplodidaA[0];
							echo $manutencoesAnterioresData;
							?></label>
					</td>
					<td>
						<label name=txtFormatacoesAnterioresModo>
							<?php $manutencoesAnterioresModo = $resultadoFormatAnt["modoServico"];
							if ($manutencoesAnterioresModo != "")
								echo $manutencoesAnterioresModo;
							else
								echo "-";
							?>
						</label>
					</td>
					<td>
						<label name=txtFormatacoesAnterioresPilha>
							<?php $manutencoesAnterioresPilha = $resultadoFormatAnt["trocaPilha"];
							if ($manutencoesAnterioresPilha != "")
								echo $manutencoesAnterioresPilha;
							else
								echo "-";
							?>
						</label>
					</td>
					<td>
						<label type=text name=txtFormatacoesAnterioresTicket>
							<?php $manutencoesAnterioresTicket = $resultadoFormatAnt["ticketNum"];
							if ($manutencoesAnterioresTicket != "")
								echo $manutencoesAnterioresTicket;
							else
								echo "-";
							?>
						</label>
					</td>
					<td>
						<label type=text name=txtFormatacoesAnterioresAgente>
							<?php $manutencoesAnterioresAgente = $resultadoFormatAnt["agent"];
							if ($manutencoesAnterioresAgente != "")
								echo $manutencoesAnterioresAgente;
							else
								echo "-";
							?>
						</label>
					</td>
				</tr>
			<?php
				}
			?>
			</tr>
		</table>
		<table id="frmFields">
			<tr>
				<td colspan="2" id=separador><?php echo $translations["COMPUTER_DATA"] ?></td>
			</tr>
			<tr>
				<td><input type=hidden name=txtUltimaFormatacao value="<?php echo $ultimaFormatacao; ?>"></td>
			</tr>
			<tr>
				<td id="label"><?php echo $translations["STANDARD"] ?></td>
				<td colspan=5>
					<select name="txtPadrao">
						<option value="Aluno" <?php if ($padrao == "Aluno") echo "selected"; ?>>Aluno</option>
						<option value="Funcionário" <?php if ($padrao == "Funcionário") echo "selected"; ?>>Funcionário</option>
					</select>
				</td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["AD_REGISTERED"] ?></td>
				<td>
					<select name="txtAd">
						<option value="Sim" <?php if ($ad === "Sim") echo "selected"; ?>>Sim</option>
						<option value="Não" <?php if ($ad === "Não") echo "selected"; ?>>Não</option>
					</select>
			</tr>
			<tr>
				<td id=label><?php echo $translations["BRAND"] ?></td>
				<td><input type=text name=txtMarca value="<?php echo $marca; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["MODEL"] ?></td>
				<td><input type=text name=txtModelo value="<?php echo $modelo; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["SERIAL_NUMBER"] ?></td>
				<td><input type=text name=txtNumSerie value="<?php echo $numSerie; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["PROCESSOR"] ?></td>
				<td><input type=text name=txtProcessador value="<?php echo $processador; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["RAM"] ?></td>
				<td><input type=text name=txtMemoria value="<?php echo $memoria; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["STORAGE_SIZE"] ?></td>
				<td><input type=text name=txtHd value="<?php echo $hd; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["STORAGE_TYPE"] ?></td>
				<td><input type=text name=txtTipoArmaz value="<?php echo $tipoArmaz; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["MEDIA_OPERATION_MODE"] ?></td>
				<td><input type=text name=txtModoArmaz value="<?php echo $modoArmaz; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["VIDEO_CARD"] ?></td>
				<td><input type=text name=txtGPU value="<?php echo $gpu; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["OPERATING_SYSTEM"] ?></td>
				<td><input type=text name=txtSistemaOperacional value="<?php echo $sistemaOperacional; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["HOSTNAME"] ?></td>
				<td><input type=text name=txtHostName value="<?php echo $hostname; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["FW_TYPE"] ?></td>
				<td><input type=text name=txtTipoFW value="<?php echo $tipoFW; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["FW_VERSION"] ?></td>
				<td><input type=text name=txtBIOS value="<?php echo $bios; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["SECURE_BOOT"] ?></td>
				<td><input type=text name=txtSecBoot value="<?php echo $secBoot; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["VIRTUALIZATION_TECHNOLOGY"] ?></td>
				<td><input type=text name=txtVT value="<?php echo $vt; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["TPM_VERSION"] ?></td>
				<td><input type=text name=txtTPM value="<?php echo $tpm; ?>"></td>
			</tr>
			<tr>
				<td id="label"><?php echo $translations["MAC_ADDRESS"] ?></td>
				<td><input type="text" name="txtMac" value="<?php echo $mac; ?>"></td>
			</tr>
			<tr>
				<td id="label"><?php echo $translations["IP_ADDRESS"] ?></td>
				<td><input type="text" name="txtIp" value="<?php echo $ip; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["IN_USE"] ?></td>
				<td>
					<select name="txtEmUso">
						<option value="Sim" <?php if ($emUso === "Sim") echo "selected"; ?>>Sim</option>
						<option value="Não" <?php if ($emUso === "Não") echo "selected"; ?>>Não</option>
					</select>
			</tr>
			<tr>
				<td id="label"><?php echo $translations["SEAL_NUMBER"] ?></td>
				<td><input type="text" name="txtLacre" value="<?php echo $lacre; ?>"></td>
			</tr>
			<td id="label"><?php echo $translations["TAG"] ?></td>
			<td><select name="txtEtiqueta">
					<option value="Sim" <?php if ($etiqueta === "Sim") echo "selected"; ?>>Sim</option>
					<option value="Não" <?php if ($etiqueta === "Não") echo "selected"; ?>>Não</option>
				</select>
			</td>
			<tr>
				<td id="label"><?php echo $translations["HW_TYPE"] ?></td>
				<td>
					<select name="txtTipo">
						<?php
						foreach ($hwtype_array as $str) {
						?>
							<option value=<?php echo $str ?> <?php if ($tipo == $str) echo "selected"; ?>><?php echo $str ?></option>
						<?php
						}
						?>
					</select>
				</td>
			</tr>
			</tr>
			<?php
			}
			if (isset($_SESSION["nivel"])) {
				if ($_SESSION["nivel"] == $json_config_array["ADMIN_LEVEL"] or $_SESSION["nivel"] == $json_config_array["STANDARD_LEVEL"]) {
			?>
				<tr>
					<td colspan=7 align=center><br><input id="updateButton" type=submit value=Atualizar></td>
				</tr>
		<?php
				}
			}
		?>
		</table>
	</form>
</div>
<?php
require_once("foot.php");
?>