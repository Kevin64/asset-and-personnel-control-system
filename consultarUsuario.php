<?php
require_once("verifica.php");
require_once("topo.php");
require_once __DIR__ . '/../conexao.php';

$enviar = null;
$ordenar = null;

if (isset($_POST["txtEnviar"]))
	$enviar = $_POST["txtEnviar"];

if (isset($_GET["ordenar"]))
	$ordenar = $_GET["ordenar"];

if ($ordenar == "")
	$ordenar = "usuario";

if (isset($_GET['sort']))
	$sort = $_GET['sort'];

if (isset($sort) and $sort == "desc") {
	$sort = "asc";
} else {
	$sort = "desc";
}

if ($enviar != 1)
	$query = mysqli_query($conexao, "select * from usuarios order by $ordenar $sort") or die("Erro ao selecionar dados do usuario! " . mysqli_error($conexao));
else {
	$rdCriterio = $_POST["rdCriterio"];
	$pesquisar = $_POST["txtPesquisar"];
	$query = mysqli_query($conexao, "select * from usuarios where $rdCriterio like '%$pesquisar%'") or die("Erro ao efetuar a pesquisa! " . mysqli_error($conexao));
}

$totalUsuarios = mysqli_num_rows($query);
?>

<div id="meio">
	<table>
		<form action=consultarUsuario.php method=post>
			<input type=hidden name=txtEnviar value=1>
		</form>
	</table>
	<br><br>
	<h2>Lista de usuários (<?php echo $totalUsuarios; ?>)</h2><br>
	<table id="dadosUsuario" cellspacing=0>
		<form action="apagaSelecionadosUsuario.php" method="post">
			<tr id="cabecalho">
				<td><img src="img/trash.png" width="22" height="29"></td>
				<td><a href="?ordenar=usuario&sort=<?php echo $sort; ?>">Usuário</a></td>
				<td><a href="?ordenar=nivel&sort=<?php echo $sort; ?>">Privilégio</a></td>
			</tr>
			<?php
			while ($resultado = mysqli_fetch_array($query)) {
				$id = $resultado["id"];
				$usuario = $resultado["usuario"];
				$nivel = $resultado["nivel"];
			?>

				<tr id="dados">
					<td><input type="checkbox" name="chkDeletar[]" value="<?php echo $id; ?>" onclick="var input = document.getElementById('eraseButton'); if(this.checked){ input.disabled = false;}else{input.disabled=true;}"></td>
					<td><?php echo $usuario; ?></td>
					<td><?php echo $nivel; ?></td>
				</tr>
			<?php
			}
			?>
			<tr>
				<td colspan=7 align="center"><br><input id="eraseButton" type="submit" value="Apagar selecionados" disabled></td>
			</tr>
		</form>
	</table>
</div>
<?php
require_once("rodape.php");
?>