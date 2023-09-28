<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$send = null;

if (isset($_POST["txtSend"]))
	$send = $_POST["txtSend"];

if ($send != 1) {
	$idEmployee = $_GET["id"];
	$query = mysqli_query($connection, "select * from " . $dbEmployeeArray["EMPLOYEE_TABLE"] . " where id = '$idEmployee'") or die($translations["ERROR_SHOW_DETAIL_EMPLOYEE"] . mysqli_error($connection));
}
?>

<div id="middle" <?php if (isset($_SESSION["privilegeLevel"])) {
						if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["LIMITED_LEVEL"]) { ?> class="readonly" <?php }
																													} ?>>
	<form id="formGeneral">
		<h1><?php echo $translations["EMPLOYEE_DETAIL"] ?></h1><br>
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
					<td id=lblFixed><?php echo $translations["EMPLOYEE_REGISTRATION_NUMBER"] ?></td>
					<input type=hidden name=txtIdEmployee value="<?php echo $idEmployee; ?>">
					<input type=hidden name=txtOldEmployeeRegistrationNumber value="<?php echo $oldEmployeeRegistrationNumber; ?>">
					<td id=lblData><?php echo $employeeRegistrationNumber; ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["EMPLOYEE_TYPE"]["NAME"] ?></td>
					<td id=lblData>
						<?php
						if ($employeeType == "") {
							echo $json_constants_array["DASH"];
						} else {
							foreach ($employeeTypesArray as $str1 => $str2) {
								if ($employeeType == $str1) {
									echo $translations["EMPLOYEE_TYPE"][$str1];
								}
							}
						}
						?>
					</td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["EMPLOYEE_NAME"] ?></td>
					<td id=lblData><?php if ($employeeName == "") {
										echo $json_constants_array["DASH"];
									} else {
										echo $employeeName;
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["EMPLOYEE_EMAIL"] ?></td>
					<td id=lblData><?php if ($employeeEmail == "") {
										echo $json_constants_array["DASH"];
									} else {
										echo $employeeEmail;
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["EMPLOYEE_PHONE_EXTENSION"] ?></td>
					<td id=lblData><?php if ($employeePhoneExtension == "") {
										echo $json_constants_array["DASH"];
									} else {
										echo $employeePhoneExtension;
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["EMPLOYEE_PHONE_NUMBER"] ?></td>
					<td id=lblData><?php if ($employeePhoneNumber == "") {
										echo $json_constants_array["DASH"];
									} else {
										echo $employeePhoneNumber;
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["EMPLOYEE_SECTOR"] ?></td>
					<td id=lblData><?php if ($employeeSector == "") {
										echo $json_constants_array["DASH"];
									} else {
										echo $employeeSector;
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["EMPLOYEE_ROOM"] ?></td>
					<td id=lblData><?php if ($employeeRoom == "") {
										echo $json_constants_array["DASH"];
									} else {
										echo $employeeRoom;
									} ?></td>
				</tr>
				<tr>
					<td colspan=3 id=section-header><?php echo $translations["MRBS_TEMPLATE"] ?></td>
				</tr>
				<tr>
					<?php
					if ($employeeRegistrationNumber == "" || $employeeType == null || $employeeName == "" || $employeeEmail == "" || $employeePhoneNumber == "" || $employeeSector == "") {
					?>
						<td colspan=3 style=color:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>><br><?php echo "<h4>" . $translations["FILL_DATA_BEFORE_CONTINUE"] ?></br></td>
					<?php
					} else {
					?>
						<td colspan=3><br><?php echo "<h4>" . $employeeName . " - " . $employeeSector; ?></br></td>
				</tr>
				<tr>
					<td colspan=3><br><?php echo $translations["EMPLOYEE_REGISTRATION_NUMBER"] . ": " . $employeeRegistrationNumber; ?></td>
				</tr>
				<tr>
					<td colspan=3><?php echo $translations["EMPLOYEE_TYPE"]["NAME"] . ": " . $translations["EMPLOYEE_TYPE"][$employeeType]; ?></td>
				</tr>
				<tr>
					<td colspan=3><?php echo $translations["EMPLOYEE_SECTOR"] . ": " . $employeeSector; ?> </td>
				</tr>
				<tr>
					<td colspan=3><?php echo $translations["EMPLOYEE_PHONE_NUMBER_SHORT"] . ": " . $employeePhoneNumber; ?> </td>
				</tr>
				<tr>
					<td colspan=3><?php echo $translations["EMPLOYEE_EMAIL"] . ": " . $employeeEmail; ?> </td>
				</tr>
			<?php
					}
				}
				if (isset($_SESSION["privilegeLevel"])) {
					if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
			?>
				<tr>
					<td id=h-separator colspan=3 align=center><input id="updateButton" type=button onclick="location.href='editEmployee.php?id=<?php echo $idEmployee ?>'" value=<?php echo $translations["LABEL_EDIT_BUTTON"] ?>></td>
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