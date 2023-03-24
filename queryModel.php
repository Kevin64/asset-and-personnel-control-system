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

if (isset($_GET["sort"]))
	$sort = $_GET["sort"];

if ($ordenar == "")
	$ordenar = "marca";

if (isset($sort) and $sort == "asc") {
	$sort = "desc";
} else {
	$sort = "asc";
}

if ($enviar != 1)
	$query = mysqli_query($conexao, "select * from bios order by $ordenar $sort") or die($translations["ERROR_QUERY_MODEL"] . mysqli_error($conexao));
else {
	$rdCriterio = $_POST["rdCriterio"];
	$pesquisar = $_POST["txtPesquisar"];
	$query = mysqlI_query($conexao, "select * from bios where $rdCriterio like "%$pesquisar%"") or die($translations["ERROR_QUERY"] . mysqli_error($conexao));
}

$totalSalas = mysqli_num_rows($query);
?>

<div id="meio">
	<table id="tbPesquisar">
		<form action=queryModel.php method=post>
			<input type=hidden name=txtEnviar value=1>
			<tr>
				<td align=center><?php echo $translations["SEARCH_FOR"] ?></td>
			</tr>
			<tr>
				<td align=center>
					<select id=filterBIOS name=rdCriterio>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "modelo") echo "selected='selected'"; ?>value="modelo"><?php echo $translations["MODEL"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "marca") echo "selected='selected'"; ?>value="marca"><?php echo $translations["BRAND"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "versao") echo "selected='selected'"; ?>value="versao"><?php echo $translations["FW_VERSION"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "tipo") echo "selected='selected'"; ?>value="tipo"><?php echo $translations["FW_TYPE"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "tpm") echo "selected='selected'"; ?>value="tpm"><?php echo $translations["TPM_VERSION"] ?></option>
						<option <?php if(isset($_POST["rdCriterio"]) && $_POST["rdCriterio"] == "mediaOp") echo "selected='selected'"; ?>value="mediaOp"><?php echo $translations["MEDIA_OPERATION_MODE"] ?></option>
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
	<h2><?php echo $translations["MODEL_LIST"] ?>(<?php echo $totalSalas; ?>)</h2><br>
	<table id="dadosBIOS" cellspacing=0>
		<form action="eraseSelectedModel.php" method="post">
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
				<td><a href="?ordenar=modelo&sort=<?php echo $sort; ?>"><?php echo $translations["MODEL"] ?></a></td>
				<td><a href="?ordenar=marca&sort=<?php echo $sort; ?>"><?php echo $translations["BRAND"] ?></a></td>
				<td><a href="?ordenar=versao&sort=<?php echo $sort; ?>"><?php echo $translations["FW_VERSION"] ?></a></td>
				<td><a href="?ordenar=tipo&sort=<?php echo $sort; ?>"><?php echo $translations["FW_TYPE"] ?></a></td>
				<td><a href="?ordenar=tpm&sort=<?php echo $sort; ?>"><?php echo $translations["TPM_VERSION"] ?></a></td>
				<td><a href="?ordenar=mediaOp&sort=<?php echo $sort; ?>"><?php echo $translations["MEDIA_OPERATION_MODE"] ?></a></td>
			</tr>
			<?php
			while ($resultado = mysqli_fetch_array($query)) {
				$id = $resultado["id"];
				$marca = $resultado["marca"];
				$modelo = $resultado["modelo"];
				$versao = $resultado["versao"];
				$tipo = $resultado["tipo"];
				$tpm = $resultado["tpm"];
				$mediaOp = $resultado["mediaOp"];
			?>
				<tr id="dados">
					<?php
					if (isset($_SESSION["nivel"])) {
						if ($_SESSION["nivel"] == $json_config_array["ADMIN_LEVEL"]) {
					?>
							<td><input type="checkbox" name="chkDeletar[]" value="<?php echo $id; ?>" onclick="var input = document.getElementById('eraseButton'); if(this.checked){ input.disabled = false;}else{input.disabled=true;}"></td>
					<?php
						}
					}
					?>
					<td><a href="formDetailModel.php?id=<?php echo $id; ?>"><?php echo $modelo; ?></a></td>
					<td><?php echo $marca; ?></td>
					<td><?php echo $versao; ?></td>
					<td><?php echo $tipo; ?></td>
					<td><?php echo $tpm; ?></td>
					<td><?php echo $mediaOp; ?></td>
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