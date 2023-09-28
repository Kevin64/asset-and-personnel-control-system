<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$send = null;
$orderBy = null;

if (isset($_POST["txtSend"]))
	$send = $_POST["txtSend"];

if (isset($_GET["orderBy"]))
	$orderBy = $_GET["orderBy"];

if ($orderBy == "")
	$orderBy = "name";

if (isset($_GET["sort"]))
	$sort = $_GET["sort"];

if (isset($sort) and $sort == "asc") {
	$sort = "desc";
} else {
	$sort = "asc";
}

if ($send != 1)
	$query = mysqli_query($connection, "select * from " . $dbEmployeeArray["EMPLOYEE_TABLE"] . " order by $orderBy $sort") or die($translations["ERROR_QUERY_EMPLOYEE"] . mysqli_error($connection));
else {
	$rdCriterion = $_POST["rdCriterion"];
	$search = $_POST["txtSearch"];
	$query = mysqli_query($connection, "select * from " . $dbEmployeeArray["EMPLOYEE_TABLE"] . " where $rdCriterion like '%$search%'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
}

$totalEmployees = mysqli_num_rows($query);
?>

<div id="middle">
	<form action=queryEmployee.php method=post>
		<table id="tbSearch">
			<input type=hidden name=txtSend value=1>
			<tr>
				<td align=center><?php echo $translations["SEARCH_FOR"] ?></td>
			</tr>
			<tr>
				<td align=center>
					<select id=filterEmployee name=rdCriterion>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbEmployeeArray["REGISTRATION_NUMBER"]) echo "selected='selected'"; ?>value="<?php echo $dbEmployeeArray["REGISTRATION_NUMBER"] ?>"><?php echo $translations["EMPLOYEE_REGISTRATION_NUMBER"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbEmployeeArray["SECTOR"]) echo "selected='selected'"; ?>value="<?php echo $dbEmployeeArray["SECTOR"] ?>"><?php echo $translations["EMPLOYEE_SECTOR"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbEmployeeArray["NAME"]) echo "selected='selected'"; ?>value="<?php echo $dbEmployeeArray["NAME"] ?>"><?php echo $translations["EMPLOYEE_NAME"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbEmployeeArray["TYPE"]) echo "selected='selected'"; ?>value="<?php echo $dbEmployeeArray["TYPE"] ?>"><?php echo $translations["EMPLOYEE_TYPE"]["NAME"] ?></option>
					</select>
					<input style="width:335px" type=text name=txtSearch> <input id="searchButton" type=submit value="OK">
				</td>
			</tr>
			<?php
			if (isset($_POST["txtSearch"])) {
				if (isset($_POST["rdCriterion"])) {
					$value = $_POST["rdCriterion"];
				}
			}
			?>
		</table>
	</form>
	<br><br>
	<h1><?php echo $translations["EMPLOYEE_LIST"] ?> (<?php echo $totalEmployees; ?>)</h1><br>
	<form action="eraseSelectedEmployee.php" method="post">
		<table id="employeeData" cellspacing=1>
			<thead id="header_">
				<?php
				if (isset($_SESSION["privilegeLevel"])) {
					if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
				?>
						<th><img src="<?php echo $imgArray["TRASH"] ?>" width="22" height="29"></th>
				<?php
					}
				}
				?>
				<th><a href="?orderBy=<?php echo $dbEmployeeArray["REGISTRATION_NUMBER"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["EMPLOYEE_REGISTRATION_NUMBER"] ?></a></th>
				<th><a href="?orderBy=<?php echo $dbEmployeeArray["NAME"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["EMPLOYEE_NAME"] ?></a></th>
				<th><a href="?orderBy=<?php echo $dbEmployeeArray["SECTOR"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["EMPLOYEE_SECTOR"] ?></a></th>
				<?php
				if (!in_array(true, $devices)) {
				?>
					<th><a href="?orderBy=<?php echo $dbEmployeeArray["TYPE"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["EMPLOYEE_TYPE"]["NAME"] ?></a></th>
				<?php
				}
				?>
			</thead>
			<tbody>
				<?php
				while ($result = mysqli_fetch_array($query)) {
					$idEmployee = $result["id"];
					$employeeRegistrationNumber = $result[$dbEmployeeArray["REGISTRATION_NUMBER"]];
					$name = $result[$dbEmployeeArray["NAME"]];
					$sector = $result[$dbEmployeeArray["SECTOR"]];
					$employeeType = $result[$dbEmployeeArray["TYPE"]];
				?>
					<tr id=tableList>
						<?php
						if (isset($_SESSION["privilegeLevel"])) {
							if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
						?>
								<td><input type="checkbox" name="chkDelete[]" value="<?php echo $idEmployee; ?>" onclick="var input = document.getElementById('eraseButton'); if(this.checked){ input.disabled=false;}else{input.disabled=true;}"></td>
						<?php
							}
						}
						?>
						<td><a href="formDetailEmployee.php?id=<?php echo $idEmployee; ?>"><?php echo $employeeRegistrationNumber; ?></a></td>
						<td class="unselectable"><?php echo $name; ?></td>
						<td class="unselectable"><?php echo $sector; ?></td>
						<?php
						if (!in_array(true, $devices)) {
							if ($employeeType == null) {
						?>
								<td class="unselectable" style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>">
									<?php echo $translations["INCOMPLETE_REGISTRATION_DATA"] ?>
								</td>
							<?php
							} else {
							?>
								<td class="unselectable">
									<?php echo $translations["EMPLOYEE_TYPE"][$employeeType] ?>
								</td>
						<?php
							}
						}
						?>

					</tr>
			</tbody>
			<?php
				}
				if (isset($_SESSION["privilegeLevel"])) {
					if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
			?>
				<tr>
					<td id=h-separator colspan=7 align="center"><input id="eraseButton" type="submit" value="<?php echo $translations["LABEL_ERASE_BUTTON"] ?>" disabled></td>
				</tr>
		<?php
					}
				}
		?>
		</table>
	</form>
</div>
<?php
require_once("foot.php");
?>