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
			$query = mysqli_query($connection, "select * from " . $dbAgentArray["AGENTS_TABLE"] . " order by $orderBy $sort") or die($translations["ERROR_QUERY_AGENT"] . mysqli_error($connection));
		else {
			$rdCriterion = $_POST["rdCriterion"];
			$search = $_POST["txtSearch"];
			$query = mysqli_query($connection, "select * from " . $dbAgentArray["AGENTS_TABLE"] . " where $rdCriterion like '%$search%'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
		}

		$totalusers = mysqli_num_rows($query);
?>

		<div id="middle">
			<h1><?php echo $translations["AGENT_LIST"] ?> (<?php echo $totalusers; ?>)
			</h1><br>
			<form action="eraseSelectedAgent.php" method="post">
				<table id="userData" cellspacing=1>
					<thead id="header_">
						<th><img src="<?php echo $imgArray["TRASH"] ?>" width="22" height="29"></th>
						<th><a href="?orderBy=<?php echo $dbAgentArray["USERNAME"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["USERNAME"] ?></a>
						</th>
						<th><a href="?orderBy=<?php echo $dbAgentArray["PRIVILEGE_LEVEL"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["PRIVILEGE"]["NAME"] ?></a></th>
						<?php
						if (!in_array(true, $devices)) {
						?>
							<th><a href="?orderBy=<?php echo $dbAgentArray["LAST_LOGIN_DATE"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["LAST_LOGIN_DATE"] ?></a></th>
						<?php
						}
						?>
					</thead>
					<tbody>
						<?php
						while ($result = mysqli_fetch_array($query)) {
							$idUser = $result["id"];
							$username = $result[$dbAgentArray["USERNAME"]];
							$privilegeLevel = $result[$dbAgentArray["PRIVILEGE_LEVEL"]];
							$lastLoginDate = $result[$dbAgentArray["LAST_LOGIN_DATE"]];
							$blocked = $result[$dbAgentArray["BLOCKED"]];

							$formatDate1 = substr($lastLoginDate, 0, 10);
							$formatDate2 = substr($lastLoginDate, 11, 16);
							$explodedDate = explode("-", $formatDate1);
							if ($explodedDate[0] != "")
								$lastLoginDate = $explodedDate[2] . "/" . $explodedDate[1] . "/" . $explodedDate[0] . " " . $formatDate2;
						?>
							<tr id=tableList>
								<td><input type="checkbox" name="chkDelete[]" value="<?php echo $idUser; ?>" onclick="var input = document.getElementById('eraseButton'); if(this.checked){ input.disabled=false;}else{input.disabled=true;}" <?php if ($_SESSION["id"] == $idUser) { ?> disabled <?php } ?> <?php if ($blocked == 1) { ?> disabled <?php } ?>>
								</td>
								<td><a href="formDetailAgent.php?id=<?php echo $idUser; ?>" <?php if ($blocked == 1) { ?> id=inactive <?php } ?>><?php echo $username; ?></a></td>
								<td><label <?php if ($blocked == 1) { ?> id=inactive <?php } ?>>
										<?php
										if ($privilegeLevel == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
											echo $translations["ADMINISTRATOR_NAME"];
										} else if ($privilegeLevel == $privilegeLevelsArray["STANDARD_LEVEL"]) {
											echo $translations["STANDARD_NAME"];
										} else if ($privilegeLevel == $privilegeLevelsArray["LIMITED_LEVEL"]) {
											echo $translations["LIMITED_NAME"];
										}
										?></label>
								</td>
								<?php
								if (!in_array(true, $devices)) {
								?>
									<td><label <?php if ($blocked == 1) { ?> id=inactive <?php } ?>>
											<?php echo $lastLoginDate; ?>
										</label>
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
					<td id=h-separator colspan=7 align="center"><input id="eraseButton" type="submit" value="<?php echo $translations["LABEL_ERASE_BUTTON"] ?>" disabled></td>
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