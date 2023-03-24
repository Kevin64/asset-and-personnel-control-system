<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$enviar = null;
$ordenar = null;

if (isset($_POST["txtEnviar"]))
	$enviar = $_POST["txtEnviar"];

if (isset($_GET["ordenar"]))
	$ordenar = $_GET["ordenar"];

if ($ordenar == "")
	$ordenar = "nome";

if (isset($_GET["sort"]))
	$sort = $_GET["sort"];

if (isset($sort) and $sort == "asc") {
	$sort = "desc";
} else {
	$sort = "asc";
}

if ($enviar != 1)
	$query = mysqli_query($conexao, "select * from docente order by $ordenar $sort") or die($translations["ERROR_QUERY_TEACHER"] . mysqli_error($conexao));
else {
	$rdCriterio = $_POST["rdCriterio"];
	$pesquisar = $_POST["txtPesquisar"];
	$query = mysqli_query($conexao, "select * from docente where $rdCriterio like '%$pesquisar%'") or die($translations["ERROR_QUERY"] . mysqli_error($conexao));
}

$totalDocentes = mysqli_num_rows($query);
?>

<div id="meio">
	<table id="tbPesquisar">
		<form action=queryTeacher.php method=post>
			<input type=hidden name=txtEnviar value=1>
			<tr>
				<td align=center><?php echo $translations["SEARCH_FOR"] ?></td>
			</tr>
			<tr>
				<td align=center>
					<select id=filterDocente name=rdCriterio>
						<option <?php if (isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "siape") echo "selected='selected'"; ?>value="siape"><?php echo $translations["TEACHER_REGISTRATION_NUMBER"] ?></option>
						<option <?php if (isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "curso") echo "selected='selected'"; ?>value="curso"><?php echo $translations["TEACHER_COURSE"] ?></option>
						<option <?php if (isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "nome") echo "selected='selected'"; ?>value="nome"><?php echo $translations["TEACHER_NAME"] ?></option>
						<option <?php if (isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "tipoServidor") echo "selected='selected'"; ?>value="tipoServidor"><?php echo $translations["EMPLOYEE_TYPE"] ?></option>
					</select>
					<input style="width:300px" type=text name=txtPesquisar> <input id="searchButton" type=submit value="OK">
				</td>
			</tr>
		</form>
		<?php
		if (isset($_POST["txtPesquisar"])) {
			if (isset($_POST["rdCriterio"])) {
				$value = $_POST["rdCriterio"];
			}
		}
		?>
	</table>
	<br><br>
	<h2><?php echo $translations["TEACHER_LIST"] ?> (<?php echo $totalDocentes; ?>)</h2><br>
	<table id="dadosDocente" cellspacing=0>
		<form action="eraseSelectedTeacher.php" method="post">
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
				<td><a href="?ordenar=siape&sort=<?php echo $sort; ?>"><?php echo $translations["TEACHER_REGISTRATION_NUMBER"] ?></a></td>
				<td><a href="?ordenar=nome&sort=<?php echo $sort; ?>"><?php echo $translations["TEACHER_NAME"] ?></a></td>
				<td><a href="?ordenar=curso&sort=<?php echo $sort; ?>"><?php echo $translations["TEACHER_COURSE"] ?></a></td>
				<?php
				if (!in_array(true, $devices)) {
				?>
					<td><a href="?ordenar=tipoServidor&sort=<?php echo $sort; ?>"><?php echo $translations["EMPLOYEE_TYPE"] ?></a></td>
				<?php
				}
				?>
			</tr>
			<?php
			while ($resultado = mysqli_fetch_array($query)) {
				$id = $resultado["id"];
				$siape = $resultado["siape"];
				$nome = $resultado["nome"];
				$curso = $resultado["curso"];
				$tipo = $resultado["tipoServidor"];
			?>
				<tr id="dados">
					<?php
					if (isset($_SESSION["nivel"])) {
						if ($_SESSION["nivel"] == $json_config_array["ADMIN_LEVEL"]) {
					?>
							<td><input type="checkbox" name="chkDeletar[]" value="<?php echo $id; ?>" onclick="var input = document.getElementById('eraseButton'); if(this.checked){ input.disabled=false;}else{input.disabled=true;}"></td>
					<?php
						}
					}
					?>
					<td><a href="formDetailTeacher.php?id=<?php echo $id; ?>"><?php echo $siape; ?></a></td>
					<td class="unselectable"><?php echo $nome; ?></td>
					<td class="unselectable"><?php echo $curso; ?></td>
					<?php
					if (!in_array(true, $devices)) {
						if ($tipo == null) {
					?>
							<td class="unselectable" style="background-color:darkred;">
								<?php echo $translations["INCOMPLETE_REGISTRATION_DATA"] ?>
							</td>
						<?php
						} else {
						?>
							<td class="unselectable">
								<?php echo $tipo; ?>
							</td>
					<?php
						}
					}
					?>

				</tr>
				<?php
			}
			if (isset($_SESSION["nivel"])) {
				if ($_SESSION["nivel"] == $json_config_array["ADMIN_LEVEL"]) {
				?>
					<tr>
						<td colspan=7 align="center"><br><input id="eraseButton" type="submit" value=<?php echo $translations["LABEL_ERASE_BUTTON"] ?> disabled></td>
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