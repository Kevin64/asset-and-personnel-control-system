<?php
require_once ("verifica.php");
require_once ("topo.php");
require_once __DIR__ . '/../conexao.php';

$enviar = $_POST["txtEnviar"];
$ordenar = $_GET["ordenar"];

if ($ordenar == "")
	$ordenar = "usuario";

if ($enviar != 1) {
	$query = mysql_query("select * from usuarios order by $ordenar") or die ("Erro ao selecionar dados do usuario! ".mysql_error());
} else {
	$rdCriterio = $_POST["rdCriterio"];
	$pesquisar = $_POST["txtPesquisar"];

	$query = mysql_query("select * from usuarios where $rdCriterio like '%$pesquisar%'") or die ("Erro ao efetuar a pesquisa! ".mysql_error());
}

$totalUsuarios = mysql_num_rows(mysql_query("select * from usuarios"));
?>

<div id="meio">
	<h2>Lista de usuários (<?php echo $totalUsuarios;?>)</h2><br>
	<table id="tbPesquisarUsuario">
	<form action=consultarUsuario.php method=post>
	<input type=hidden name=txtEnviar value=1>
	</form>

	</table>
	<br><br>
	<table id="dadosUsuario" cellspacing=0>
	<form action="apagaSelecionadosUsuario.php" method="post">
	<tr id="cabecalho">
	<td><a href="?ordenar=usuario">Usuário</a></td>
	<td><a href="?ordenar=nivel">Privilégio</a></td>
	<td><a href="?ordenar=excluir">Excluir</a></td>
	<td><!-- Espaço para checkbox -->
	</tr>

	<?php
	while ($resultado = mysql_fetch_array($query)) {
		$id = $resultado["id"];
		$usuario = $resultado["usuario"];
		$nivel = $resultado["nivel"];
	?>

	<tr id="dados" bgcolor="<?php echo $corPredio;?>">
	<td><?php echo $usuario;?></td>
	<td><?php echo $nivel;?></td>
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
