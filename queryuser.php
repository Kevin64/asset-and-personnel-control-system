<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

if (isset($_SESSION["privilegeLevel"])) {
	if ($_SESSION["privilegeLevel"] == $json_config_array["PrivilegeLevels"]["ADMIN_LEVEL"]) {

		$send = null;
		$orderBy = null;

		if (isset($_POST["txtSend"]))
			$send = $_POST["txtSend"];

		if (isset($_GET["orderBy"]))
			$orderBy = $_GET["orderBy"];

		if ($orderBy == "")
			$orderBy = "user";

		if (isset($_GET["sort"]))
			$sort = $_GET["sort"];

		if (isset($sort) and $sort == "desc") {
			$sort = "asc";
		} else {
			$sort = "desc";
		}

		if ($send != 1)
			$query = mysqli_query($connection, "select * from users order by $orderBy $sort") or die($translations["ERROR_QUERY_USER"] . mysqli_error($connection));
		else {
			$rdCriterion = $_POST["rdCriterion"];
			$search = $_POST["txtSearch"];
			$query = mysqli_query($connection, "select * from users where $rdCriterion like '%$search%'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
		}

		$totalusers = mysqli_num_rows($query);
?>

		<div id="middle">
			<table>
				<form action=consultaruser.php method=post>
					<input type=hidden name=txtSend value=1>
				</form>
			</table>
			<br><br>
			<h2>Lista de usuários (<?php echo $totalusers; ?>)</h2><br>
			<table id="userData" cellspacing=0>
				<form action="eraseSelectedUser.php" method="post">
					<tr id="header_">
						<td><img src="img/trash.png" width="22" height="29"></td>
						<td><a href="?orderBy=user&sort=<?php echo $sort; ?>"><?php echo $translations["USERNAME"] ?></a></td>
						<td><a href="?orderBy=status&sort=<?php echo $sort; ?>"><?php echo $translations["PRIVILEGE"] ?></a></td>
					</tr>
					<?php
					while ($result = mysqli_fetch_array($query)) {
						$id = $result["id"];
						$user = $result["user"];
						$privilegeLevel = $result["status"];
					?>
						<tr id="data">
							<td><input type="checkbox" name="chkdelete[]" value="<?php echo $id; ?>" onclick="var input = document.getElementById('eraseButton'); if(this.checked){ input.disabled=false;}else{input.disabled=true;}"></td>
							<td><a href="formDetailUser.php?id=<?php echo $id; ?>"><?php echo $user; ?></a></td>
							<td><?php echo $privilegeLevel; ?></td>
						</tr>
					<?php
					}
					?>
					<tr>
						<td colspan=7 align="center"><br><input id="eraseButton" type="submit" value="<?php echo $translations["LABEL_ERASE_BUTTOn"] ?>" disabled></td>
					</tr>
				</form>
			</table>
		</div>
<?php
		require_once("foot.php");
	} else {
		header("Location: denied.php");
	}
}
?>