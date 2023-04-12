<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$send = null;

if (isset($_POST["txtSend"]))
	$send = $_POST["txtSend"];

if ($send != 1) {
	$idTeacher = $_GET["id"];
	$query = mysqli_query($connection, "select * from teacher where id = '$idTeacher'") or die($translations["ERROR_SHOW_DETAIL_TEACHER"] . mysqli_error($connection));
} else {
	if (isset($_POST["txtIdTeacher"]))
		$idTeacher = $_POST["txtIdTeacher"];
	if (isset($_POST["txtTeacherRegistrationNumber"]))
		$teacherRegistrationNumber = $_POST["txtTeacherRegistrationNumber"];
	if (isset($_POST["txtOldTeacherRegistrationNumber"]))
		$oldTeacherRegistrationNumber = $_POST["txtOldTeacherRegistrationNumber"];
	if (isset($_POST["txtEmployeeType"]))
		$employeeType = $_POST["txtEmployeeType"];
	if (isset($_POST["txtName"]))
		$teacherName = $_POST["txtName"];
	if (isset($_POST["txtEmail"]))
		$teacherEmail = $_POST["txtEmail"];
	if (isset($_POST["txtPhoneExtension"]))
		$teacherPhoneExtension = $_POST["txtPhoneExtension"];
	if (isset($_POST["txtPhoneNumber"]))
		$teacherPhoneNumber = $_POST["txtPhoneNumber"];
	if (isset($_POST["txtCourse"]))
		$teacherCourse = $_POST["txtCourse"];
	if (isset($_POST["txtRoomNumber"]))
		$teacherRoom = $_POST["txtRoomNumber"];
	if (isset($_POST["txtFaltas"]))
		$faltas = $_POST["txtFaltas"];

	$query = mysqli_query($connection, "select * from teacher where teacherRegistrationNumber = '$teacherRegistrationNumber'") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$num_rows = mysqli_num_rows($query);

	if ($num_rows == 0) {
		mysqli_query($connection, "update teacher set teacherRegistrationNumber = '$teacherRegistrationNumber', employeeType = '$employeeType', name = '$teacherName', email = '$teacherEmail', phoneExtension = '$teacherPhoneExtension', phoneNumber = '$teacherPhoneNumber', course = '$teacherCourse', roomNumber = '$teacherRoom' where id = '$idTeacher'") or die($translations["ERROR_UPDATE_TEACHER_DATA"] . mysqli_error($connection));
	} else if ($num_rows == 1 && $teacherRegistrationNumber == $oldTeacherRegistrationNumber) {
		mysqli_query($connection, "update teacher set employeeType = '$employeeType', name = '$teacherName', email = '$teacherEmail', phoneExtension = '$teacherPhoneExtension', phoneNumber = '$teacherPhoneNumber', course = '$teacherCourse', roomNumber = '$teacherRoom' where id = '$idTeacher'") or die($translations["ERROR_UPDATE_TEACHER_DATA"] . mysqli_error($connection));
	}
	$query = mysqli_query($connection, "select * from teacher where id = '$idTeacher'") or die($translations["ERROR_SHOW_DETAIL_TEACHER"] . mysqli_error($connection));
}
?>

<div id="middle" <?php if (isset($_SESSION["privilegeLevel"])) {
					if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["LIMITED_LEVEL"]) { ?> class="readonly" <?php }} ?>>
	<form action="formDetailTeacher.php" method="post" id="formGeneral">
		<input type=hidden name=txtSend value="1">
		<h2><?php echo $translations["TEACHER_DETAIL"] ?></h2><br>
		<?php
		if ($send == 1) {
			if ($num_rows > 0 && $teacherRegistrationNumber != $oldTeacherRegistrationNumber) {
				echo "<font color=red>" . $translations["TEACHER_ALREADY_EXIST"] . "</font><br><br>";
			} else {
				echo "<font color=blue>" . $translations["SUCCESS_UPDATE_TEACHER_DATA"] . "</font><br><br>";
			}
		}
		?>
		<label id=asteriskWarning><?php echo $translations["ASTERISK_MARK_MANDATORY"] ?> (<mark id=asterisk>*</mark>)</label>
		<table id="formFields">
			<?php
			while ($result = mysqli_fetch_array($query)) {
				$idTeacher = $result["id"];
				$teacherRegistrationNumber = $result["teacherRegistrationNumber"];
				$oldTeacherRegistrationNumber = $result["teacherRegistrationNumber"];
				$employeeType = $result["employeeType"];
				$teacherName = $result["name"];
				$teacherEmail = $result["email"];
				$teacherPhoneExtension = $result["phoneExtension"];
				$teacherPhoneNumber = $result["phoneNumber"];
				$teacherCourse = $result["course"];
				$teacherRoom = $result["roomNumber"];
			?>
				<tr>
					<td colspan=2 id=spacer><?php echo $translations["TEACHER_DATA"] ?></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["TEACHER_REGISTRATION_NUMBER"] ?><mark id=asterisk>*</mark></td>
					<input type=hidden name=txtIdTeacher value="<?php echo $idTeacher; ?>">
					<input type=hidden name=txtOldTeacherRegistrationNumber value="<?php echo $oldTeacherRegistrationNumber; ?>">
					<td><input type=text name=txtTeacherRegistrationNumber maxlength="8" required value="<?php echo $teacherRegistrationNumber; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["EMPLOYEE_TYPE"]["NAME"] ?><mark id=asterisk>*</mark></td>
					<td>
						<select name=txtEmployeeType required>
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
					<td id="label"><?php echo $translations["TEACHER_NAME"] ?><mark id=asterisk>*</mark></td>
					<td><input type=text name=txtName required value="<?php echo $teacherName; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["TEACHER_EMAIL"] ?><mark id=asterisk>*</mark></td>
					<td><input type=email name=txtEmail required value="<?php echo $teacherEmail; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["TEACHER_PHONE_EXTENSION"] ?></td>
					<td><input type=text name=txtPhoneExtension maxLength=4 value="<?php echo $teacherPhoneExtension; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["TEACHER_PHONE_NUMBER"] ?><mark id=asterisk>*</mark></td>
					<td><input type=text name=txtPhoneNumber minLength=11 maxLength=11 required value="<?php echo $teacherPhoneNumber; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["TEACHER_COURSE"] ?><mark id=asterisk>*</mark></td>
					<td><input type=text name=txtCourse required value="<?php echo $teacherCourse; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["TEACHER_ROOM"] ?></td>
					<td><input type=text name=txtRoomNumber maxLength=4 value="<?php echo $teacherRoom; ?>"></td>
				</tr>
				<tr>
					<td colspan=2 id=spacer><?php echo $translations["MRBS_TEMPLATE"] ?></td>
				</tr>
				<tr>
					<?php
					if ($teacherRegistrationNumber == "" || $employeeType == null || $teacherName == "" || $teacherEmail == "" || $teacherPhoneNumber == "" || $teacherCourse == "") {
					?>
						<td colspan=2 style="color:red;"><br><?php echo "<h4>" . $translations["FILL_DATA_BEFORE_CONTINUE"] ?></br></td>
						<?php
					} else {
						if ($employeeType == "Técnico Administractive em Educação") {
						?>
							<td colspan=2><br><?php echo "<h4>" . "TAE" . " " . $teacherName . " - " . $translations["TEACHER_COURSE_OF"] . ": " . $teacherCourse; ?></br></td>
						<?php
						} else {
						?>
							<td colspan=2><br><?php echo "<h4>" . "Prof." . " " . $teacherName . $translations["COURSE_OF"] . " " . $teacherCourse; ?></br></td>
						<?php
						}
						?>
				</tr>
				<tr>
					<td colspan=2><br><?php echo $translations["TEACHER_REGISTRATION_NUMBER"] . ": " . $teacherRegistrationNumber; ?></br></td>
				</tr>
				<tr>
					<td colspan=2><?php echo $translations["TEACHER_COURSE"] . ": " . $teacherCourse; ?> </td>
				</tr>
				<tr>
					<td colspan=2><?php echo $translations["TEACHER_PHONE_NUMBER_SHORT"] . ": " . $teacherPhoneNumber; ?> </td>
				</tr>
				<tr>
					<td colspan=2><?php echo $translations["TEACHER_EMAIL"] . ": " . $teacherEmail; ?> </td>
				</tr>
			<?php
					}
				}
				if ($_SESSION["privilegeLevel"] != $privilegeLevelsArray["LIMITED_LEVEL"]) {
			?>
			<tr>
				<td colspan=2 align=center><br><input id="updateButton" type=submit value=<?php echo $translations["LABEL_UPDATE_BUTTON"] ?>></td>
			</tr>
		<?php
				}
		?>
		</table>
	</form>
</div>
<?php
require_once("foot.php");
?>