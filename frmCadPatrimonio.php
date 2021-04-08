<?php
session_start();
require_once ("verifica.php");
require_once ("topo.php");

?>

	<div id="meio">

		<form action="cadPatrimonio.php" method=post id=frmCadPatrimonio>
		<h2>Formulário de cadastro de patrimônio</h2><br>
		<table>
		<tr>
		<td colspan=2 id=separador>Dados do patrimônio</td>
		</tr>
		<tr>
		<td id="label">Patrimônio</td>
		<td><input type=text name=txtPatrimonio></td>
		</tr>
		<tr>
		<td id="label">Prédio</td>
		<td><select name=txtPredio>
			<option value="74 - A">74 - A</option>
			<option value="74 - B">74 - B</option>
			<option value="74 - C">74 - C</option>
			<option value="21">21</option>
			<option value="67">67</option>
			<option value="BIBLIOTECA SETORIAL">BIBLIOTECA SETORIAL</option>
			<option value="ANTIGA REITORIA">ANTIGA REITORIA</option>
			<option value="APOIO">APOIO</option>
		    </select>
		</td>
		</tr>
		<tr>
		<td id="label">Sala</td>
		<td><input type=text name=txtSala></td>
		</tr>
		<tr>
		<td id="label">Descrição</td>
		<td><input type=text name=txtDescricao></td>
		</tr>
		<tr>
		<td id="label">Nome do recebedor</td>
		<td><input type=text name=txtRecebedor></td>
		</tr>
		<td id="label">Siape do recebedor</td>
		<td><input type=text name=txtSiapeRecebedor></td>
		</tr>
		<tr>
		<td id="label">Ramal</td>
		<td><input type=text name=txtRamal></td>
		</tr>
		<td id="label">Data da entrega</td>
		<td><input type=date name=txtDataEntrega></td>
		</tr>
		<td id="label">Padrão</td>
		<td><select name=txtPadrao>
		    <option value="SIM">AD</option>
		    <option value="NAO">PCCLI</option>
		    </select>
		</td>
		</tr>
		<tr>
		<td id="label">Observação</td>
		<td><textarea name=txtObservacao cols=20 rows=3></textarea></td>
		</tr>
		<tr>
		<td colspan="2" id="separador">Dados do equipamento</td>
		</tr>
		<tr>
		<td id="label">Última formatação</td>
		<td><input type="date" name="txtUltimaFormatacao"></td>
		</tr>
		<tr>
		<td id="label">Cadastrado no AD</td>
		<td><select name="txtAd">
		    <option value="SIM">SIM</option>
		    <option value="NAO">NAO</option>
		    </select>
		</td>
		</tr>
		<tr>
		<td id="label">Marca</td>
		<td><input type="text" name="txtMarca"></td>
		</tr>
		<tr>
		<td id="label">Modelo</td>
		<td><input type="text" name="txtModelo"></td>
		</tr>
		<tr>
		<td id="label">Número de série</td>
		<td><input type="text" name="txtNumSerie"></td>
		</tr>
		<tr>
		<td id="label">Processador</td>
		<td><input type="text" name="txtProcessador"></td>
		</tr>
		<tr>
		<td id="label">Memória</td>
		<td><input type="text" name="txtMemoria"></td>
		</tr>
		<tr>
		<td id="label">Disco rígido (tamanho total)</td>
		<td><input type="text" name="txtHd"></td>
		</tr>
		<tr>
		<td id="label">Tipo de Armazenamento</td>
		<td><input type="text" name="txtTipoArmaz"></td>
		</tr>
		<tr>
		<td id="label">Modo de Operação SATA/M.2</td>
		<td><input type="text" name="txtModoArmaz"></td>
		</tr>
		<tr>
		<td id="label">Placa de Vídeo</td>
		<td><input type="text" name="txtGPU"></td>
		</tr>
		<tr>
		<td id="label">Sistema Operacional</td>
		<td><input type="text" name="txtSistemaOperacional"></td>
		</tr>
		<tr>
		<td id="label">Nome do computador</td>
		<td><input type="text" name="txtHostName"></td>
		</tr>
		<tr>
		<td id="label">Tipo de Firmware</td>
		<td><input type="text" name="txtTipoFW"></td>
		</tr>
		<tr>
		<td id="label">Versão da BIOS/UEFI</td>
		<td><input type="text" name="txtBIOS"></td>
		</tr>
		<tr>
		<td id="label">Secure Boot</td>
		<td><input type="text" name="txtSecBoot"></td>
		</tr>
		<tr>
		<td id="label">Número do lacre</td>
		<td><input type="text" name="txtLacre"></td>
		</tr>
		<tr>
		<td id="label">Etiqueta</td>
		<td><select name="txtEtiqueta">
		    <option value="SIM">SIM</option>
		    <option value="NAO">NAO</option>
		    </select>
		</td>
		</tr>
		<tr>
		<td id="label">Em uso</td>
		<td><select name="txtEmUso">
		    <option value="SIM">SIM</option>
		    <option value="NAO">NAO</option>
		    </select>
		</td>
		</tr>
		<tr>
		<td id="label">Tipo</td>
		<td><select name="txtTipo">
		    <option value="DESKTOP">DESKTOP</option>
		    <option value="NOTEBOOK">NOTEBOOK</option>
			<option value="TABLET">TABLET</option>
		    </select>
		</td>
		</tr>
		<tr>
		<td colspan="2" align="center"><br>
		<input type="submit" value="Cadastrar"></td>
		</tr>
		</table>
		</form>
	</div>

<?php
require_once ("rodape.php");
?>
