<?php
session_start();
require_once ("topo.php");
require_once __DIR__ . '/../conexao.php';
require_once ("verifica.php");

$enviar = $_POST["txtEnviar"];

if ($enviar != 1) {
	$idPatrimonio = $_GET["id"];
	$patrimonioFK = $_GET["patrimonioFK"];
	$query = mysql_query("select * from patrimonio where id = '$idPatrimonio'") or die ("Erro a selecionar patrimônio para exibir detalhes! ".mysql_error());
	$queryFormatAnt = mysql_query("select manutencoes.dataFormatacoesAnteriores from (select * from patrimonio where id = '$idPatrimonio') as p inner join manutencoes on p.patrimonio = manutencoes.patrimonioFK") or die ("Erro a selecionar patrimônio para exibir detalhes! ".mysql_error());
} else {
	$idPatrimonio = $_POST["txtIdPatrimonio"];
	$patrimonio = $_POST["txtPatrimonio"];
	$predio = $_POST["txtPredio"];
	$sala = $_POST["txtSala"];
	$descricao = $_POST["txtDescricao"];
	$recebedor = $_POST["txtRecebedor"];
	$siape = $_POST["txtSiapeRecebedor"];
	$ramal = $_POST["txtRamal"];
	$dataEntrega = $_POST["txtDataEntrega"];
	$padrao = $_POST["txtPadrao"];
	$observacao = $_POST["txtObservacao"];
	$ultimaFormatacao = $_POST["txtUltimaFormatacao"];
	$formatacoesAnteriores = $_POST["txtFormatacoesAnteriores"];
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

	//Atualizando os dados do patrimônio
	mysql_query("update patrimonio set patrimonio = '$patrimonio', predio = '$predio', sala = '$sala', descricao = '$descricao', nomeRecebedor = '$recebedor', siapeRecebedor = '$siape', ramal = '$ramal', dataEntrega = '$dataEntrega', padrao = '$padrao', observacao = '$observacao', dataFormatacao = '$ultimaFormatacao', ad = '$ad', marca = '$marca', modelo = '$modelo', numSerie = '$numSerie', processador = '$processador', memoria = '$memoria', hd = '$hd', sistemaOperacional = '$sistemaOperacional', hostname = '$hostname', bios = '$bios', emUso = '$emUso', lacre = '$lacre', etiqueta = '$etiqueta', tipo = '$tipo', tipoFW = '$tipoFW', tipoArmaz = '$tipoArmaz', mac = '$mac', ip = '$ip', gpu = '$gpu', modoArmaz = '$modoArmaz', secBoot = '$secBoot' where id = '$idPatrimonio'") or die ("Erro ao atualizar os dados do patrimônio! ".mysql_error());

	$query = mysql_query("select * from patrimonio where id = '$idPatrimonio'") or die ("Erro ao selecionar os dados do patrimônio! ".mysql_error());
	$queryFormatAnt = mysql_query("select manutencoes.dataFormatacoesAnteriores from (select * from patrimonio where id = '$idPatrimonio') as p inner join manutencoes on p.patrimonio = manutencoes.patrimonioFK") or die ("Erro ao selecionar os dados do patrimônio! ".mysql_error());
}
?>

	<div id="meio">
		<form action="frmDetalhePatrimonio.php" method="post" id="frmCadPatrimonio">
		<input type=hidden name=txtEnviar value="1">
		<h2>Detalhes do patrimônio</h2><br>

		<?php
		if ($enviar == 1) {
			echo "<font color=blue>Dados do patrimônio atualizados com sucesso!</font><br><br>";
		}
		?>

		<table>
		<?php

		
		while ($resultado = mysql_fetch_array($query)) {
			$idPatrimonio = $resultado["id"];
			$patrimonio = $resultado["patrimonio"];
			$predio = $resultado["predio"];
			$sala = $resultado["sala"];
			$descricao = $resultado["descricao"];
			$recebedor = $resultado["nomeRecebedor"];
			$siape = $resultado["siapeRecebedor"];
			$ramal = $resultado["ramal"];
			$dataEntrega = $resultado["dataEntrega"];
			$padrao = $resultado["padrao"];
			$observacao = $resultado["observacao"];
			$ultimaFormatacao = $resultado["dataFormatacao"];			
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

			$adOk = substr($ad, 0, 1);
			$padraoOk = substr($padrao, 0, 1);
			$emUsoOk = substr($emUso, 0, 1);
			$etiquetaOk = substr($etiqueta, 0, 1);

			if ($adOk == "N") $ad = "NAO";
			if ($padraoOk == "N") $padrao = "NAO";
			if ($emUsoOk == "N") $emUso = "NAO";
			if ($etiquetaOk == "N") $etiqueta = "NAO";
	
		?>

		<tr>
		<td colspan=2 id=separador>Dados do patrimônio <?php echo $dataCerta;?></td>
		</tr>
		<tr>
		<td id="label">Patrimônio</td>
		<input type=hidden name=txtIdPatrimonio value="<?php echo $idPatrimonio;?>">
		<td><input type=text name=txtPatrimonio value="<?php echo $patrimonio;?>"></td>
		</tr>
		<tr>
		<td id="label">Prédio</td>
		<td>
			<select name="txtPredio">
			<option value="74 - A" <?php if ($predio == "74 - A") echo "selected";?>>74 - A</font></option>
			<option value="74 - B" <?php if ($predio == "74 - B") echo "selected";?>>74 - B</option>
			<option value="74 - C" <?php if ($predio == "74 - C") echo "selected";?>>74 - C</option>
			<option value="21" <?php if ($predio == "21") echo "selected";?>>21</option>
			<option value="67" <?php if ($predio == "67") echo "selected";?>>67</option>
			<option value="BIBLIOTECA SETORIAL" <?php if ($predio == "BIBLIOTECA SETORIAL") echo "selected";?>>BIBLIOTECA SETORIAL</option>
			<option value="ANTIGA REITORIA" <?php if ($predio == "ANTIGA REITORIA") echo "selected";?>>ANTIGA REITORIA</option>
			<option value="APOIO" <?php if ($predio == "APOIO") echo "selected";?>>APOIO</option>
		</td>
		</tr>
		<tr>
		<td id="label">Sala</td>
		<td><input type=text name=txtSala value="<?php echo $sala;?>"></td>
		</tr>
		<tr>
		<td id="label">Descrição</td>
		<td><input type=text name=txtDescricao value="<?php echo $descricao;?>"></td>
		</tr>
		<tr>
		<td id="label">Nome do recebedor</td>
		<td><input type=text name=txtRecebedor value="<?php echo $recebedor;?>"></td>
		</tr>
		<td id="label">Siape do recebedor</td>
		<td><input type=text name=txtSiapeRecebedor value="<?php echo $siape;?>"></td>
		</tr>
		<tr>
		<td id="label">Ramal</td>
		<td><input type=text name=txtRamal value="<?php echo $ramal;?>"></td>
		</tr>
		<td id="label">Data da entrega</td>
		<td><input type=date name=txtDataEntrega value="<?php echo $dataEntrega;?>"></td>
		</tr>
		<td id="label">Padrão</td>
		<td>
			<select name="txtPadrao">
			<option value="AD" <?php if ($padrao == "AD") echo "selected";?>>AD</option>
			<option value="PCCLI" <?php if ($padrao == "PCCLI") echo "selected";?>>PCCLI</option>
			</select>
		</td>
		</tr>
		<tr>
		<td id="label">Observação</td>
		<td><textarea name=txtObservacao cols=20 rows=3><?php echo $observacao;?></textarea></td>
		</tr>
		<tr>
		<td colspan=2 id=separador>Dados do equipamento</td>
		</tr>
		<tr>
		<td id=label>Última manutenção</td>
		<td><input type=date name=txtUltimaFormatacao value="<?php echo $ultimaFormatacao;?>"></td>
		</tr>
		<tr>
		<td id=label>Manutenções Anteriores</td>
		<td><textarea name=txtFormatacoesAnteriores cols=30 rows=10>
		<?php
		echo PHP_EOL;		
		while ($resultadoFormatAnt = mysql_fetch_array($queryFormatAnt)) {					
			$formatacoesAnteriores = $resultadoFormatAnt["dataFormatacoesAnteriores"];	
			$dataFA = substr($formatacoesAnteriores, 0, 10);
			$mode = substr($formatacoesAnteriores, 10, 30);
			$dataExplodidaA = explode("-", $dataFA);
			$formatacoesAnteriores = $dataExplodidaA[2]."/".$dataExplodidaA[1]."/".$dataExplodidaA[0].$mode;
			echo $formatacoesAnteriores.PHP_EOL;
		}
		?>
		</textarea></td>
		</tr>
		<tr>
		<td id=label>Cadastrado no AD</td>
		<td>
			<select name="txtAd">
			<option value="SIM" <?php if ($ad === "SIM") echo "selected";?>>SIM</option>
			<option value="NÃO" <?php if ($ad === "NAO") echo "selected";?>>NAO</option>
			</select>
		</tr>
		<tr>
		<td id=label>Marca</td>
		<td><input type=text name=txtMarca value="<?php echo $marca;?>"></td>
		</tr>
		<tr>
		<td id=label>Modelo</td>
		<td><input type=text name=txtModelo value="<?php echo $modelo;?>"></td>
		</tr>
		<tr>
		<td id=label>Número de série</td>
		<td><input type=text name=txtNumSerie value="<?php echo $numSerie;?>"></td>
		</tr>
		<tr>
		<td id=label>Processador</td>
		<td><input type=text name=txtProcessador value="<?php echo $processador;?>"></td>
		</tr>
		<tr>
		<td id=label>Memória</td>
		<td><input type=text name=txtMemoria value="<?php echo $memoria;?>"></td>
		</tr>
		<tr>
		<td id=label>Disco rígido (tamanho total)</td>
		<td><input type=text name=txtHd value="<?php echo $hd;?>"></td>
		</tr>
		<tr>
		<td id=label>Tipo de Armazenamento</td>
		<td><input type=text name=txtTipoArmaz value="<?php echo $tipoArmaz;?>"></td>
		</tr>
		<tr>
		<td id=label>Modo de operação SATA/M.2</td>
		<td><input type=text name=txtModoArmaz value="<?php echo $modoArmaz;?>"></td>
		</tr>
		<tr>
		<td id=label>Placa de Vídeo</td>
		<td><input type=text name=txtGPU value="<?php echo $gpu;?>"></td>
		</tr>
		<tr>
		<td id=label>Sistema Operacional</td>
		<td><input type=text name=txtSistemaOperacional value="<?php echo $sistemaOperacional;?>"></td>
		</tr>
		<tr>
		<td id=label>Nome do computador</td>
		<td><input type=text name=txtHostName value="<?php echo $hostname;?>"></td>
		</tr>
		<tr>
		<td id=label>Tipo de Firmware</td>
		<td><input type=text name=txtTipoFW value="<?php echo $tipoFW;?>"></td>
		</tr>
		<tr>
		<td id=label>Versão da BIOS/UEFI</td>
		<td><input type=text name=txtBIOS value="<?php echo $bios;?>"></td>
		</tr>
		<tr>
		<td id=label>Secure Boot</td>
		<td><input type=text name=txtSecBoot value="<?php echo $secBoot;?>"></td>
		</tr>
		<tr>
		<td id="label">Endereço MAC</td>
		<td><input type="text" name="txtMac" value="<?php echo $mac;?>"></td>
		</tr>
		<tr>
		<td id="label">Endereço IP</td>
		<td><input type="text" name="txtIp" value="<?php echo $ip;?>"></td>
		</tr>
		<tr>
		<td id=label>Em uso</td>
		<td>
			<select name="txtEmUso">
			<option value="SIM" <?php if ($emUso === "SIM") echo "selected";?>>SIM</option>
			<option value="NÃO" <?php if ($emUso === "NAO") echo "selected";?>>NAO</option>
			</select>
		</tr>
		<tr>
		<td id="label">Lacre</td>
		<td><input type="text" name="txtLacre" value="<?php echo $lacre;?>"></td>
		</tr>
		<td id="label">Etiqueta</td>
		<td><select name="txtEtiqueta">
			<option value="SIM" <?php if ($etiqueta === "SIM") echo "selected";?>>SIM</option>
			<option value="NÃO" <?php if ($etiqueta === "NAO" || $etiqueta == "não" || $etiqueta == "Não") echo "selected";?>>NAO</option>
		    </select>
		</td>
		<tr>
		<td id="label">Tipo</td>
		<td><select name="txtTipo">
			<option value="DESKTOP" <?php if ($tipo === "DESKTOP") echo "selected";?>>DESKTOP</option>
			<option value="NOTEBOOK" <?php if ($tipo === "NOTEBOOK") echo "selected";?>>NOTEBOOK</option>
			<option value="TABLET" <?php if ($tipo === "TABLET") echo "selected";?>>TABLET</option>
		    </select>
		</td>
		</tr>
		</tr>

		<?php
		}
		?>

		<tr>
		<td colspan=2 align=center><br><input type=submit value=Atualizar></td>
		</tr>
		</table>
		</form>
	</div>

<?php
require_once ("rodape.php");
?>
