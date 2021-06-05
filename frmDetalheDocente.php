<?php
session_start();
require_once ("topo.php");
require_once __DIR__ . '/../conexao.php';
require_once ("verifica.php");

$enviar = $_POST["txtEnviar"];

if ($enviar != 1) {
	$idDocente = $_GET["id"];
	$query = mysql_query("select * from docente where id = '$idDocente'") or die ("Erro a selecionar docente para exibir detalhes! ".mysql_error());
} else {
	$idDocente = $_POST["txtIdDocente"];
	$siape = $_POST["txtSiape"];
	$nome = $_POST["txtNome"];
	$email = $_POST["txtEmail"];
	$ramal = $_POST["txtRamal"];
	$celular = $_POST["txtCelular"];
	$curso = $_POST["txtCurso"];
	$sala = $_POST["txtSala"];
	$faltas = $_POST["txtFaltas"];
	$data_ultima_falta = $_POST["txtDataUltimaFalta"];

	//Atualizando os dados do docente
	mysql_query("update docente set siape = '$siape', nome = '$nome', email = '$email', ramal = '$ramal', celular = '$celular', curso = '$curso', sala = '$sala', faltas = '$faltas', data_ultima_falta = '$data_ultima_falta' where id = '$idDocente'") or die ("Erro ao atualizar os dados do docente! ".mysql_error());

	$query = mysql_query("select * from docente where id = '$idDocente'") or die ("Erro ao selecionar os dados do docente! ".mysql_error());
}
?>

	<div id="meio">
		<form action="frmDetalheDocente.php" method="post" id="frmCadDocente">
		<input type=hidden name=txtEnviar value="1">
		<h2>Detalhes do docente</h2><br>

		<?php
		if ($enviar == 1) {
			echo "<font color=blue>Dados do docente atualizados com sucesso!</font><br><br>";
		}
		?>

		<table>
		<?php
		while ($resultado = mysql_fetch_array($query)) {
			$idDocente = $resultado["id"];
			$siape = $resultado["siape"];
			$nome = $resultado["nome"];
			$email = $resultado["email"];
			$ramal = $resultado["ramal"];
			$celular = $resultado["celular"];
			$curso = $resultado["curso"];
			$sala = $resultado["sala"];
			$faltas = $resultado["faltas"];
			$data_ultima_falta = $resultado["data_ultima_falta"];

		?>

		<tr>
		<td colspan=2 id=separador>Dados do docente <?php echo $dataCerta;?></td>
		</tr>
		<tr>
		<td id="label">Siape</td>
		<input type=hidden name=txtIdDocente value="<?php echo $idDocente;?>">
		<td><input type=text name=txtSiape value="<?php echo $siape;?>"></td>
		</tr>
<!--		<tr>
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
		</tr>-->
		<tr>
		<td id="label">Nome</td>
		<td><input type=text name=txtNome value="<?php echo $nome;?>"></td>
		</tr>		
		<tr>
		<td id="label">E-mail</td>
		<td><input type=text name=txtEmail value="<?php echo $email;?>"></td>
		</tr>
		<tr>
		<td id="label">Ramal</td>
		<td><input type=text name=txtRamal value="<?php echo $ramal;?>"></td>
		</tr>
		<tr>
		<td id="label">Celular</td>
		<td><input type=text name=txtCelular value="<?php echo $celular;?>"></td>
		</tr>
		<tr>
		<td id="label">Curso</td>
		<td><input type=text name=txtCurso value="<?php echo $curso;?>"></td>
		</tr>
		<tr>
		<td id="label">Sala</td>
		<td><input type=text name=txtSala value="<?php echo $sala;?>"></td>
		</tr>
		<tr>
		<td id="label">Faltas</td>
		<td><input type=text name=txtFaltas value="<?php echo $faltas;?>"></td>
		</tr>
		<tr>
		<td id="label">Data da ultima falta</td>
		<td><input type=date name=txtDataUltimaFalta value="<?php echo $data_ultima_falta;?>"></td>
		</tr>
		<tr>
		<td colspan=2 id=separador>Modelo para Reserva de Salas (Copiar e Colar) <?php echo $dataCerta;?></td>
		</tr>
		<tr>
		<td colspan=2><br><?php echo "<h4>Prof. " .$nome . " - Curso de " .$curso;?></br></td>
		</tr>
		<tr>
		<td colspan=2><br><?php echo "SIAPE: " .$siape; ?></br></td>
		</tr>
		<tr>
		<td colspan=2><?php echo "Curso: " .$curso; ?> </td>
		</tr>
		<tr>
		<td colspan=2><?php echo "Ramal: " .$ramal; ?> </td>
		</tr>
		<tr>
		<td colspan=2><?php echo "Celular: " .$celular; ?> </td>
		</tr>
		<tr>
		<td colspan=2><?php echo "E-mail: " .$email; ?> </td>		
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
