<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME']) && $_SESSION["privilegeLevel"] != $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
	header('HTTP/1.1 403 Forbidden', TRUE, 403);
	die(header('location: /denied.php'));
}

$send = null;

if (isset($_POST["txtSend"]))
	$send = $_POST["txtSend"];

if ($send != 1) {
	$idEmployee = $_GET["id"];
	$query = mysqli_query($connection, "select * from " . $dbEmployeeArray["EMPLOYEE_TABLE"] . " where id = '$idEmployee'") or die($translations["ERROR_SHOW_DETAIL_EMPLOYEE"] . mysqli_error($connection));
} else {
	if (isset($_POST["txtIdEmployee"]))
		$idEmployee = $_POST["txtIdEmployee"];
	if (isset($_POST["txtEmployeeRegistrationNumber"]))
		$employeeRegistrationNumber = $_POST["txtEmployeeRegistrationNumber"];
	if (isset($_POST["txtOldEmployeeRegistrationNumber"]))
		$oldEmployeeRegistrationNumber = $_POST["txtOldEmployeeRegistrationNumber"];
	if (isset($_POST["txtEmployeeType"]))
		$employeeType = $_POST["txtEmployeeType"];
	if (isset($_POST["txtName"]))
		$employeeName = $_POST["txtName"];
	if (isset($_POST["txtEmail"]))
		$employeeEmail = $_POST["txtEmail"];
	if (isset($_POST["txtPhoneExtension"]))
		$employeePhoneExtension = $_POST["txtPhoneExtension"];
	if (isset($_POST["txtPhoneNumber"]))
		$employeePhoneNumber = $_POST["txtPhoneNumber"];
	if (isset($_POST["txtSector"]))
		$employeeSector = $_POST["txtSector"];
	if (isset($_POST["txtRoomNumber"]))
		$employeeRoom = $_POST["txtRoomNumber"];
	if (isset($_POST["txtFaltas"]))
		$faltas = $_POST["txtFaltas"];

	$query = mysqli_query($connection, "select * from " . $dbEmployeeArray["EMPLOYEE_TABLE"] . " where " . $dbEmployeeArray["REGISTRATION_NUMBER"] . " = '$employeeRegistrationNumber'") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$num_rows = mysqli_num_rows($query);

	if ($num_rows == 0) {
		mysqli_query($connection, "update " . $dbEmployeeArray["EMPLOYEE_TABLE"] . " set " . $dbEmployeeArray["REGISTRATION_NUMBER"] . " = '$employeeRegistrationNumber', " . $dbEmployeeArray["TYPE"] . " = '$employeeType', " . $dbEmployeeArray["NAME"] . " = '$employeeName', " . $dbEmployeeArray["EMAIL"] . " = '$employeeEmail', " . $dbEmployeeArray["PHONE_EXTENSION"] . " = '$employeePhoneExtension', " . $dbEmployeeArray["PHONE_NUMBER"] . " = '$employeePhoneNumber', " . $dbEmployeeArray["SECTOR"] . " = '$employeeSector', " . $dbEmployeeArray["ROOM_NUMBER"] . " = '$employeeRoom' where id = '$idEmployee'") or die($translations["ERROR_UPDATE_EMPLOYEE_DATA"] . mysqli_error($connection));
	} else if ($num_rows == 1 && $employeeRegistrationNumber == $oldEmployeeRegistrationNumber) {
		mysqli_query($connection, "update " . $dbEmployeeArray["EMPLOYEE_TABLE"] . " set " . $dbEmployeeArray["TYPE"] . " = '$employeeType', " . $dbEmployeeArray["NAME"] . " = '$employeeName', " . $dbEmployeeArray["EMAIL"] . " = '$employeeEmail', " . $dbEmployeeArray["PHONE_EXTENSION"] . " = '$employeePhoneExtension', " . $dbEmployeeArray["PHONE_NUMBER"] . " = '$employeePhoneNumber', " . $dbEmployeeArray["SECTOR"] . " = '$employeeSector', " . $dbEmployeeArray["ROOM_NUMBER"] . " = '$employeeRoom' where id = '$idEmployee'") or die($translations["ERROR_UPDATE_EMPLOYEE_DATA"] . mysqli_error($connection));
	}
	$query = mysqli_query($connection, "select * from " . $dbEmployeeArray["EMPLOYEE_TABLE"] . " where id = '$idEmployee'") or die($translations["ERROR_SHOW_DETAIL_EMPLOYEE"] . mysqli_error($connection));

	header("Location: formDetailEmployee.php?id=$idEmployee");
}
?>

<div id="middle" <?php if (isset($_SESSION["privilegeLevel"])) {
						if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["LIMITED_LEVEL"]) { ?> class="readonly" <?php }
																													} ?>>
	<form action="editEmployee.php" method="post" id="formGeneral">
		<input type=hidden name=txtSend value="1">
		<h2><?php echo $translations["EMPLOYEE_EDIT"] ?></h2><br>
		<?php
		if ($send == 1) {
			if ($num_rows > 0 && $employeeRegistrationNumber != $oldEmployeeRegistrationNumber) {
				echo "<label style=color:var(--error-forecolor)>" . $translations["EMPLOYEE_ALREADY_EXIST"] . "</label><br><br>";
			} else {
				echo "<label style=color:var(--success-forecolor)>" . $translations["SUCCESS_UPDATE_EMPLOYEE_DATA"] . "</label><br><br>";
			}
		}
		?>
		<label id=asteriskWarning><?php echo $translations["ASTERISK_MARK_MANDATORY"] ?> (<mark id=asterisk>*</mark>)</label>
		<table id="formFields">
			<?php
			while ($result = mysqli_fetch_array($query)) {
				$idEmployee = $result["id"];
				$employeeRegistrationNumber = $result[$dbEmployeeArray["REGISTRATION_NUMBER"]];
				$oldEmployeeRegistrationNumber = $result[$dbEmployeeArray["REGISTRATION_NUMBER"]];
				$employeeType = $result[$dbEmployeeArray["TYPE"]];
				$employeeName = $result[$dbEmployeeArray["NAME"]];
				$employeeEmail = $result[$dbEmployeeArray["EMAIL"]];
				$employeePhoneExtension = $result[$dbEmployeeArray["PHONE_EXTENSION"]];
				$employeePhoneNumber = $result[$dbEmployeeArray["PHONE_NUMBER"]];
				$employeeSector = $result[$dbEmployeeArray["SECTOR"]];
				$employeeRoom = $result[$dbEmployeeArray["ROOM_NUMBER"]];
			?>
				<tr>
					<td colspan=3 id=section-header><?php echo $translations["EMPLOYEE_DATA"] ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["EMPLOYEE_REGISTRATION_NUMBER"] ?><mark id=asterisk>*</mark></td>
					<input type=hidden name=txtIdEmployee value="<?php echo $idEmployee; ?>">
					<input type=hidden name=txtOldEmployeeRegistrationNumber value="<?php echo $oldEmployeeRegistrationNumber; ?>">
					<td><input type=text name=txtEmployeeRegistrationNumber maxlength="8" required value="<?php echo $employeeRegistrationNumber; ?>"></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["EMPLOYEE_TYPE"]["NAME"] ?><mark id=asterisk>*</mark></td>
					<td>
						<select name=txtEmployeeType required <?php if ($employeeType == "") { ?> style="background:var(--missing-data-background);color:var(--missing-data-foreground)" <?php } ?>>
							<?php
							foreach ($employeeTypesArray as $str1 => $str2) {
							?>
								<option value=<?php echo $str1 ?> <?php if ($employeeType == $str1) echo "selected='selected'"; ?>><?php echo $translations["EMPLOYEE_TYPE"][$str1] ?></option>
							<?php
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["EMPLOYEE_NAME"] ?><mark id=asterisk>*</mark></td>
					<td><input type=text name=txtName required value="<?php echo $employeeName; ?>" <?php if ($employeeName == "") { ?> style="background:var(--missing-data-background);color:var(--missing-data-foreground)" <?php } ?>></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["EMPLOYEE_EMAIL"] ?><mark id=asterisk>*</mark></td>
					<td><input type=email name=txtEmail required value="<?php echo $employeeEmail; ?>" <?php if ($employeeEmail == "") { ?> style="background:var(--missing-data-background);color:var(--missing-data-foreground)" <?php } ?>></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["EMPLOYEE_PHONE_EXTENSION"] ?></td>
					<td><input type=text name=txtPhoneExtension maxLength=4 value="<?php echo $employeePhoneExtension; ?>"></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["EMPLOYEE_PHONE_NUMBER"] ?><mark id=asterisk>*</mark></td>
					<td><input type=text name=txtPhoneNumber minLength=11 maxLength=11 required value="<?php echo $employeePhoneNumber; ?>" <?php if ($employeePhoneNumber == "") { ?> style="background:var(--missing-data-background);color:var(--missing-data-foreground)" <?php } ?>></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["EMPLOYEE_SECTOR"] ?><mark id=asterisk>*</mark></td>
					<td><input type=text name=txtSector required value="<?php echo $employeeSector; ?>" <?php if ($employeeSector == "") { ?> style="background:var(--missing-data-background);color:var(--missing-data-foreground)" <?php } ?>></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["EMPLOYEE_ROOM"] ?></td>
					<td><input type=text name=txtRoomNumber maxLength=4 value="<?php echo $employeeRoom; ?>"></td>
				</tr>
			<?php
			}
			?>
			<tr>
				<td id=h-separator colspan=3 align=center><input id="updateButton" type=submit value=<?php echo $translations["LABEL_UPDATE_BUTTON"] ?>></td>
			</tr>
		</table>
	</form>
</div>
<?php
require_once("foot.php");
?>