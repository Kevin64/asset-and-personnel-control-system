<?php
session_start();
require_once("topo.php");
require_once("verifica.php");
require_once __DIR__ . '/../conexao.php';

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

	$query = mysqli_query($conexao, "select * from patrimonio where id = '$idPatrimonio'") or die("Erro a selecionar patrimônio para exibir detalhes! " . mysqli_error($conexao));
	$queryFormatAnt = mysqli_query($conexao, "select manutencoes.dataFormatacoesAnteriores, manutencoes.modoServico, manutencoes.trocaPilha, manutencoes.ticketNum, manutencoes.agent from (select * from patrimonio where id = '$idPatrimonio') as p inner join manutencoes on p.patrimonio = manutencoes.patrimonioFK") or die("Erro a selecionar patrimônio para exibir detalhes! " . mysqli_error($conexao));
} else {
	$idPatrimonio = $_POST["txtIdPatrimonio"];
	$patrimonio = $_POST["txtPatrimonio"];
	$predio = $_POST["txtPredio"];
	$sala = $_POST["txtSala"];
	$siape = $_POST["txtSiapeRecebedor"];
	if (isset($_POST["txtEntregador"]))
		$entregador = $_POST["txtEntregador"];
	$dataEntrega = $_POST["txtDataEntrega"];
	$padrao = $_POST["txtPadrao"];
	$observacao = $_POST["txtObservacao"];
	$ultimaFormatacao = $_POST["txtUltimaFormatacao"];
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
	mysqli_query($conexao, "update patrimonio set patrimonio = '$patrimonio', predio = '$predio', sala = '$sala', siapeRecebedor = '$siape', dataEntrega = '$dataEntrega', padrao = '$padrao', observacao = '$observacao', dataFormatacao = '$ultimaFormatacao', ad = '$ad', marca = '$marca', modelo = '$modelo', numSerie = '$numSerie', processador = '$processador', memoria = '$memoria', hd = '$hd', sistemaOperacional = '$sistemaOperacional', hostname = '$hostname', bios = '$bios', emUso = '$emUso', lacre = '$lacre', etiqueta = '$etiqueta', tipo = '$tipo', tipoFW = '$tipoFW', tipoArmaz = '$tipoArmaz', mac = '$mac', ip = '$ip', gpu = '$gpu', modoArmaz = '$modoArmaz', secBoot = '$secBoot', vt = '$vt', tpm = '$tpm' where id = '$idPatrimonio'") or die("Erro ao atualizar os dados do patrimônio! " . mysqli_error($conexao));

	$query = mysqli_query($conexao, "select * from patrimonio where id = '$idPatrimonio'") or die("Erro ao selecionar os dados do patrimônio! " . mysqli_error($conexao));
	$queryFormatAnt = mysqli_query($conexao, "select manutencoes.dataFormatacoesAnteriores, manutencoes.modoServico, manutencoes.trocaPilha, manutencoes.ticketNum, manutencoes.agent from (select * from patrimonio where id = '$idPatrimonio') as p inner join manutencoes on p.patrimonio = manutencoes.patrimonioFK") or die("Erro ao selecionar os dados do patrimônio! " . mysqli_error($conexao));
}
?>
<div id="meio">
	<form action="frmDetalhePatrimonio.php" method="post" id="frmGeneral">
		<input type=hidden name=txtEnviar value="1">
		<h2>Detalhes do patrimônio</h2><br>
		<label style="color:darkblue">Os campos marcados com asterisco (<mark id=asterisk>*</mark>) são obrigatórios!</label>
		<?php
		if ($enviar == 1)
			echo "<font color=blue>Dados do patrimônio atualizados com sucesso!</font><br><br>";
		?>
		<table id="frmFields">
			<?php
			while ($resultado = mysqli_fetch_array($query)) {
				$idPatrimonio = $resultado["id"];
				$patrimonio = $resultado["patrimonio"];
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
				<tr>
					<td colspan=7 id=separador>Dados do patrimônio</td>
				</tr>
				<tr>
					<td id="label">Patrimônio<mark id=asterisk>*</mark></td>
					<input type=hidden name=txtIdPatrimonio value="<?php echo $idPatrimonio; ?>">
					<td colspan=5><input type=text name=txtPatrimonio placeholder="Ex.: 123456" maxlength="6" required value="<?php echo $patrimonio; ?>"></td>
				</tr>
				<tr>
					<td id="label">Prédio<mark id=asterisk>*</mark></td>
					<td colspan=5>
						<select id="frmFields" name="txtPredio" required>
							<option value="21" <?php if ($predio == "21") echo "selected"; ?>>21</option>
							<option value="67" <?php if ($predio == "67") echo "selected"; ?>>67</option>
							<option value="74A" <?php if ($predio == "74A") echo "selected"; ?>>74A</option>
							<option value="74B" <?php if ($predio == "74B") echo "selected"; ?>>74B</option>
							<option value="74C" <?php if ($predio == "74C") echo "selected"; ?>>74C</option>
							<option value="74D" <?php if ($predio == "74D") echo "selected"; ?>>74D</option>
							<option value="AR" <?php if ($predio == "AR") echo "selected"; ?>>AR</option>
					</td>
				</tr>
				<tr>
					<td id="label">Sala<mark id=asterisk>*</mark></td>
					<td colspan=5><input id="frmFields" type=text name=txtSala placeholder="Ex.: 4413" maxlength="4" required value="<?php echo $sala; ?>"></td>
				</tr>
				<tr>
					<td id="label">Siape do recebedor da última entrega</td>
					<td colspan=5><input type=text name=txtSiapeRecebedor maxlength="8" value="<?php echo $siape; ?>"></td>
				</tr>
				<tr>
					<td id="label">Data da última entrega</td>
					<td colspan=5><input type=date name=txtDataEntrega value="<?php echo $dataEntrega; ?>"></td>
				</tr>
				<tr>
					<td id="label">Última entrega feita por</td>
					<td colspan=5><label name=txtEntregador style=line-height:40px;color:green;font-size:12pt><?php echo $entregador; ?></label></td>
				</tr>
				<tr>
					<td id="label">Observação</td>
					<td colspan=5><textarea name=txtObservacao cols=20 rows=2 placeholder="Opcional: Campo dedicado para observações e notas referente ao bem patrimonial"><?php echo $observacao; ?></textarea></td>
				</tr>
		</table>
		<table id="frmFields">
			<tr>
				<td colspan=5 id=separador>Manutenções realizadas</td>
			<tr>
				<td>Data</td>
				<td>Serviço</td>
				<td>Troca de pilha</td>
				<td>Nº chamado</td>
				<td>Agente responsável</td>
			</tr>
			<?php
				while ($resultadoFormatAnt = mysqli_fetch_array($queryFormatAnt)) {
			?>
				<tr>
					<td>
						<label name=txtFormatacoesAnteriores style="color:green; font-size:12pt">
							<?php
							$formatacoesAnteriores = $resultadoFormatAnt["dataFormatacoesAnteriores"];
							$dataFA = substr($formatacoesAnteriores, 0, 10);
							$dataExplodidaA = explode("-", $dataFA);
							$formatacoesAnteriores = $dataExplodidaA[2] . "/" . $dataExplodidaA[1] . "/" . $dataExplodidaA[0];
							echo $formatacoesAnteriores;
							?>
						</label>
					</td>
					<td>
						<label name=txtFormatacoesAnteriores style="color:green; font-size:12pt">
							<?php
							$modoServico = $resultadoFormatAnt["modoServico"];
							echo $modoServico;
							?>
						</label>
					</td>
					<td>
						<label name=txtFormatacoesAnteriores style="color:green; font-size:12pt">
							<?php
							$pilhaAnteriores = $resultadoFormatAnt["trocaPilha"];
							echo $pilhaAnteriores;
							?>
						</label>
					</td>
					<td>
						<label name=txtFormatacoesAnteriores style="color:green; font-size:12pt">
							<?php
							$ticketAnteriores = $resultadoFormatAnt["ticketNum"];
							echo $ticketAnteriores;
							?>
						</label>
					</td>
					<td>
						<label name=txtFormatacoesAnteriores style="color:green; font-size:12pt">
							<?php
							$agent = $resultadoFormatAnt["agent"];
							echo $agent;
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
				<td colspan="2" id=separador>Dados do equipamento</td>
			</tr>
			<tr>
					<!-- <td id=label>Última manutenção</td> -->
					<td><input type=hidden name=txtUltimaFormatacao value="<?php echo $ultimaFormatacao; ?>"></td>					
			</tr>
			<tr>
				<td id="label">Padrão</td>
				<td colspan=5>
					<select name="txtPadrao">
						<option value="Aluno" <?php if ($padrao == "Aluno") echo "selected"; ?>>Aluno</option>
						<option value="Funcionário" <?php if ($padrao == "Funcionário") echo "selected"; ?>>Funcionário</option>
					</select>
				</td>
			</tr>
			<tr>
				<td id=label>Cadastrado no Active Directory</td>
				<td>
					<select name="txtAd">
						<option value="Sim" <?php if ($ad === "Sim") echo "selected"; ?>>Sim</option>
						<option value="Não" <?php if ($ad === "Não") echo "selected"; ?>>Não</option>
					</select>
			</tr>
			<tr>
				<td id=label>Marca</td>
				<td><input type=text name=txtMarca value="<?php echo $marca; ?>"></td>
			</tr>
			<tr>
				<td id=label>Modelo</td>
				<td><input type=text name=txtModelo value="<?php echo $modelo; ?>"></td>
			</tr>
			<tr>
				<td id=label>Número de série</td>
				<td><input type=text name=txtNumSerie value="<?php echo $numSerie; ?>"></td>
			</tr>
			<tr>
				<td id=label>Processador</td>
				<td><input type=text name=txtProcessador value="<?php echo $processador; ?>"></td>
			</tr>
			<tr>
				<td id=label>Memória</td>
				<td><input type=text name=txtMemoria value="<?php echo $memoria; ?>"></td>
			</tr>
			<tr>
				<td id=label>Disco rígido (tamanho total)</td>
				<td><input type=text name=txtHd value="<?php echo $hd; ?>"></td>
			</tr>
			<tr>
				<td id=label>Tipo de Armazenamento</td>
				<td><input type=text name=txtTipoArmaz value="<?php echo $tipoArmaz; ?>"></td>
			</tr>
			<tr>
				<td id=label>Modo de operação SATA/M.2</td>
				<td><input type=text name=txtModoArmaz value="<?php echo $modoArmaz; ?>"></td>
			</tr>
			<tr>
				<td id=label>Placa de Vídeo</td>
				<td><input type=text name=txtGPU value="<?php echo $gpu; ?>"></td>
			</tr>
			<tr>
				<td id=label>Sistema Operacional</td>
				<td><input type=text name=txtSistemaOperacional value="<?php echo $sistemaOperacional; ?>"></td>
			</tr>
			<tr>
				<td id=label>Nome do computador</td>
				<td><input type=text name=txtHostName value="<?php echo $hostname; ?>"></td>
			</tr>
			<tr>
				<td id=label>Tipo de Firmware</td>
				<td><input type=text name=txtTipoFW value="<?php echo $tipoFW; ?>"></td>
			</tr>
			<tr>
				<td id=label>Versão da BIOS/UEFI</td>
				<td><input type=text name=txtBIOS value="<?php echo $bios; ?>"></td>
			</tr>
			<tr>
				<td id=label>Secure Boot</td>
				<td><input type=text name=txtSecBoot value="<?php echo $secBoot; ?>"></td>
			</tr>
			<tr>
				<td id=label>Tecnologia de Virtualização</td>
				<td><input type=text name=txtVT value="<?php echo $vt; ?>"></td>
			</tr>
			<tr>
				<td id=label>Versão do módulo TPM</td>
				<td><input type=text name=txtTPM value="<?php echo $tpm; ?>"></td>
			</tr>
			<tr>
				<td id="label">Endereço MAC</td>
				<td><input type="text" name="txtMac" value="<?php echo $mac; ?>"></td>
			</tr>
			<tr>
				<td id="label">Endereço IP</td>
				<td><input type="text" name="txtIp" value="<?php echo $ip; ?>"></td>
			</tr>
			<tr>
				<td id=label>Em uso</td>
				<td>
					<select name="txtEmUso">
						<option value="Sim" <?php if ($emUso === "Sim") echo "selected"; ?>>Sim</option>
						<option value="Não" <?php if ($emUso === "Não") echo "selected"; ?>>Não</option>
					</select>
			</tr>
			<tr>
				<td id="label">Lacre</td>
				<td><input type="text" name="txtLacre" value="<?php echo $lacre; ?>"></td>
			</tr>
			<td id="label">Etiqueta</td>
			<td><select name="txtEtiqueta">
					<option value="Sim" <?php if ($etiqueta === "Sim") echo "selected"; ?>>Sim</option>
					<option value="Não" <?php if ($etiqueta === "Não") echo "selected"; ?>>Não</option>
				</select>
			</td>
			<tr>
				<td id="label">Tipo</td>
				<td><select name="txtTipo">
						<option value="Desktop" <?php if ($tipo === "Desktop") echo "selected"; ?>>Desktop</option>
						<option value="Notebook" <?php if ($tipo === "Notebook") echo "selected"; ?>>Notebook</option>
						<option value="Tablet" <?php if ($tipo === "Tablet") echo "selected"; ?>>Tablet</option>
					</select>
				</td>
			</tr>
			</tr>
			<?php
			}
			if (isset($_SESSION['nivel'])) {
				if ($_SESSION["nivel"] == "adm" or $_SESSION["nivel"] == "user") {
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
require_once("rodape.php");
?>