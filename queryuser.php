<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

if (isset($_SESSION["privilegeLevel"])) {
	if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {

		$send = null;
		$orderBy = null;

		if (isset($_POST["txtSend"]))
			$send = $_POST["txtSend"];

		if (isset($_GET["orderBy"]))
			$orderBy = $_GET["orderBy"];

		if ($orderBy == "")
			$orderBy = "username";

		if (isset($_GET["sort"]))
			$sort = $_GET["sort"];

		if (isset($sort) and $sort == "desc") {
			$sort = "asc";
		} else {
			$sort = "desc";
		}

		if ($send != 1)
			$query = mysqli_query($connection, "select * from " . $dbAgentsArray["AGENTS_TABLE"] . " order by $orderBy $sort") or die($translations["ERROR_QUERY_USER"] . mysqli_error($connection));
		else {
			$rdCriterion = $_POST["rdCriterion"];
			$search = $_POST["txtSearch"];
			$query = mysqli_query($connection, "select * from " . $dbAgentsArray["AGENTS_TABLE"] . " where $rdCriterion like '%$search%'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
		}

		$totalusers = mysqli_num_rows($query);
?>

		<div id="middle">
			<table>
				<form action=queryUser.php method=post>
					<input type=hidden name=txtSend value=1>
				</form>
			</table>
			<br><br>
			<h2><?php echo $translations["USER_LIST"] ?> (<?php echo $totalusers; ?>)
			</h2><br>
			<form action="eraseSelectedUser.php" method="post">
				<table id="userData" cellspacing=0>
					<thead id="header_">
						<th><img src="<?php echo $imgArray["TRASH"] ?>" width="22" height="29"></th>
						<th><a href="?orderBy=<?php $dbAgentsArray["USERNAME"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["USERNAME"] ?></a>
						</th>
						<th><a href="?orderBy=<?php $dbAgentsArray["PRIVILEGE_LEVEL"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["PRIVILEGE"]["NAME"] ?></a></th>
						<?php
						if (!in_array(true, $devices)) {
						?>
							<th><a href="?orderBy=<?php $dbAgentsArray["LAST_LOGIN_DATE"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["LAST_LOGIN_DATE"] ?></a></th>
						<?php
						}
						?>
					</thead>
					<tbody>
						<?php
						while ($result = mysqli_fetch_array($query)) {
							$idUser = $result["id"];
							$username = $result[$dbAgentsArray["USERNAME"]];
							$privilegeLevel = $result[$dbAgentsArray["PRIVILEGE_LEVEL"]];
							$lastLoginDate = $result[$dbAgentsArray["LAST_LOGIN_DATE"]];
						?>
							<tr id="data">
								<td><input type="checkbox" name="chkDelete[]" value="<?php echo $idUser; ?>" onclick="var input = document.getElementById('eraseButton'); if(this.checked){ input.disabled=false;}else{input.disabled=true;}" <?php if ($_SESSION["id"] == $idUser) { ?> disabled <?php } ?>>
								</td>
								<td><a href="formDetailUser.php?id=<?php echo $idUser; ?>"><?php echo $username; ?></a></td>
								<td>
									<?php
									if ($privilegeLevel == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
										echo $translations["ADMINISTRATOR_NAME"];
									} else if ($privilegeLevel == $privilegeLevelsArray["STANDARD_LEVEL"]) {
										echo $translations["STANDARD_NAME"];
									} else if ($privilegeLevel == $privilegeLevelsArray["LIMITED_LEVEL"]) {
										echo $translations["LIMITED_NAME"];
									}
									?>
								</td>
								<?php
								if (!in_array(true, $devices)) {
								?>
									<td>
										<?php echo $lastLoginDate; ?>
									</td>
								<?php
								}
								?>
							</tr>
					</tbody>
				<?php
						}
				?>
				<tr>
					<td colspan=7 align="center"><br><input id="eraseButton" type="submit" value="<?php echo $translations["LABEL_ERASE_BUTTON"] ?>" disabled></td>
				</tr>
				</table>
			</form>
		</div>
<?php
		require_once("foot.php");
	} else {
		header("Location: denied.php");
	}
}
?>