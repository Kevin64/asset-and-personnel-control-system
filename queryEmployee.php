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
	<table id="tbSearch">
		<form action=queryEmployee.php method=post>
			<input type=hidden name=txtSend value=1>
			<tr>
				<td align=center><?php echo $translations["SEARCH_FOR"] ?></td>
			</tr>
			<tr>
				<td align=center>
					<select id=filterEmployee name=rdCriterion>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbEmployeeArray["EMPLOYEE_REGISTRATION_NUMBER"]) echo "selected='selected'"; ?>value="<?php echo $dbEmployeeArray["EMPLOYEE_REGISTRATION_NUMBER"] ?>"><?php echo $translations["EMPLOYEE_REGISTRATION_NUMBER"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbEmployeeArray["SECTOR"]) echo "selected='selected'"; ?>value="<?php echo $dbEmployeeArray["SECTOR"] ?>"><?php echo $translations["EMPLOYEE_SECTOR"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbEmployeeArray["NAME"]) echo "selected='selected'"; ?>value="<?php echo $dbEmployeeArray["NAME"] ?>"><?php echo $translations["EMPLOYEE_NAME"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbEmployeeArray["EMPLOYEE_TYPE"]) echo "selected='selected'"; ?>value="<?php echo $dbEmployeeArray["EMPLOYEE_TYPE"] ?>"><?php echo $translations["EMPLOYEE_TYPE"]["NAME"] ?></option>
					</select>
					<input style="width:300px" type=text name=txtSearch> <input id="searchButton" type=submit value="OK">
				</td>
			</tr>
		</form>
		<?php
		if (isset($_POST["txtSearch"])) {
			if (isset($_POST["rdCriterion"])) {
				$value = $_POST["rdCriterion"];
			}
		}
		?>
	</table>
	<br><br>
	<h2><?php echo $translations["EMPLOYEE_LIST"] ?> (<?php echo $totalEmployees; ?>)</h2><br>
	<table id="employeeData" cellspacing=0>
		<form action="eraseSelectedEmployee.php" method="post">
			<tr id="header_">
				<?php
				if (isset($_SESSION["privilegeLevel"])) {
					if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
				?>
						<td><img src="<?php echo $imgArray["TRASH"] ?>" width="22" height="29"></td>
				<?php
					}
				}
				?>
				<td><a href="?orderBy=<?php $dbEmployeeArray["EMPLOYEE_REGISTRATION_NUMBER"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["EMPLOYEE_REGISTRATION_NUMBER"] ?></a></td>
				<td><a href="?orderBy=<?php $dbEmployeeArray["NAME"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["EMPLOYEE_NAME"] ?></a></td>
				<td><a href="?orderBy=<?php $dbEmployeeArray["SECTOR"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["EMPLOYEE_SECTOR"] ?></a></td>
				<?php
				if (!in_array(true, $devices)) {
				?>
					<td><a href="?orderBy=<?php $dbEmployeeArray["EMPLOYEE_TYPE"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["EMPLOYEE_TYPE"]["NAME"] ?></a></td>
				<?php
				}
				?>
			</tr>
			<?php
			while ($result = mysqli_fetch_array($query)) {
				$idEmployee = $result["id"];
				$employeeRegistrationNumber = $result[$dbEmployeeArray["EMPLOYEE_REGISTRATION_NUMBER"]];
				$name = $result[$dbEmployeeArray["NAME"]];
				$sector = $result[$dbEmployeeArray["SECTOR"]];
				$employeeType = $result[$dbEmployeeArray["EMPLOYEE_TYPE"]];
			?>
				<tr id="data">
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
							<td class="unselectable" style="background-color:darkred; color:white">
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
				<?php
			}
			if (isset($_SESSION["privilegeLevel"])) {
				if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
				?>
					<tr>
						<td colspan=7 align="center"><br><input id="eraseButton" type="submit" value="<?php echo $translations["LABEL_ERASE_BUTTON"] ?>" disabled></td>
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