<?php
session_start();
require_once ("topo.php");
require_once ("conexao.php");
require_once ("verifica.php");

$enviar = $_POST["txtEnviar"];

if ($enviar != 1) {
	$idModelo = $_GET["id"];
	$marca = $_GET["marca"];
	$modelo = $_GET["modelo"];
	$versao = $_GET["versao"];
	$query = mysql_query("select * from bios where id = '$idModelo'") or die ("Erro a selecionar modelo para exibir detalhes! ".mysql_error());
} else {
	$idModelo = $_POST["txtIdModelo"];
	$marca = $_POST["txtMarca"];
	$modelo = $_POST["txtModelo"];
	$versao = $_POST["txtVersao"];

	//Atualizando os dados do patrimônio
	mysql_query("update bios set marca = '$marca', modelo = '$modelo', versao = '$versao' where id = '$idModelo'") or die ("Erro ao atualizar os dados da BIOS! ".mysql_error());

	$query = mysql_query("select * from bios where id = '$idModelo'") or die ("Erro ao selecionar os dados da BIOS! ".mysql_error());
}
?>

	<div id="meio">
		<form action="frmDetalheBIOS.php" method="post" id="frmCadBIOS">
		<input type=hidden name=txtEnviar value="1">
		<h2>Detalhes da BIOS</h2><br>

		<?php
		if ($enviar == 1) {
			echo "<font color=blue>Dados da BIOS atualizados com sucesso!</font><br><br>";
		}
		?>

		<table>
		<?php

		
		while ($resultado = mysql_fetch_array($query)) {
			$idModelo = $resultado["id"];
			$marca = $resultado["marca"];
			$modelo = $resultado["modelo"];
			$versao = $resultado["versao"];
		?>

		<tr>
		<td colspan=2 id=separador>Dados da BIOS <?php echo $dataCerta;?></td>
		</tr>
		<tr>
		<td id="label">Modelo</td>
		<input type=hidden name=txtIdModelo value="<?php echo $idModelo;?>">
		<td><input type=text name=txtModelo value="<?php echo $modelo;?>"></td>
		</tr>
		<tr>
		<td id="label">Marca</td>
		<td><input type=text name=txtMarca value="<?php echo $marca;?>"></td>
		</tr>		
		<tr>
		<td id="label">Versão da BIOS/UEFI</td>
		<td><input type=text name=txtVersao value="<?php echo $versao;?>"></td>
		</tr>		
		</tr>

		<?php
		}
		?>
<!--
<select Emp Name='NEW'>  
		<option value="">--- Selecione ---</option>    
            <?php
                $list=mysql_query("select * from bios order by modelo asc");  
        	    while($row_list=mysql_fetch_assoc($list)){  
				?>  
					<option value="<?php echo $row_list['modelo']; ?>"<?php if($row_list['modelo']==$select){ echo "selected"; } ?>>
						<?php echo $row_list['modelo'];?>  
					</option>  
                <?php
                }  
                ?>  
	</select>  -->

		<tr>
		<td colspan=2 align=center><br><input type=submit value=Atualizar></td>
		</tr>
		</table>
		</form>
	</div>

<?php
require_once ("rodape.php");
?>
