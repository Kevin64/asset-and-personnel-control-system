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
	if (isset($_POST["txtregNum"]))
		$deliveredToRegistrationNumber = $_POST["txtregNum"];
	if (isset($_POST["txttypeemployee"]))
		$typeemployee = $_POST["txttypeemployee"];
	if (isset($_POST["txtname"]))
		$name = $_POST["txtname"];
	if (isset($_POST["txtEmail"]))
		$email = $_POST["txtEmail"];
	if (isset($_POST["txtextNum"]))
		$extNum = $_POST["txtextNum"];
	if (isset($_POST["txtphone"]))
		$phone = $_POST["txtphone"];
	if (isset($_POST["txtcourse"]))
		$course = $_POST["txtcourse"];
	if (isset($_POST["txtroom"]))
		$room = $_POST["txtroom"];
	if (isset($_POST["txtFaltas"]))
		$faltas = $_POST["txtFaltas"];
	if (isset($_POST["txtDataUltimaFalta"]))
		$data_ultima_falta = $_POST["txtDataUltimaFalta"];

	//currentizando os dados do docente
	mysqli_query($connection, "update teacher set regNum = '$deliveredToRegistrationNumber', typeemployee = '$typeemployee', name = '$name', email = '$email', extNum = '$extNum', phone = '$phone', course = '$course', room = '$room' where id = '$idTeacher'") or die($translations["ERROR_UPDATE_TEACHER_DATA"] . mysqli_error($connection));

	$query = mysqli_query($connection, "select * from teacher where id = '$idTeacher'") or die($translations["ERROR_SHOW_DETAIL_TEACHER"] . mysqli_error($connection));
}
?>

<div id="middle">
	<form action="formDetailTeacher.php" method="post" id="formGeneral">
		<input type=hidden name=txtSend value="1">
		<h2><?php echo $translations["TEACHER_DETAIL"] ?></h2><br>
		<?php
		if ($send == 1) {
			echo "<font color=blue>" . $translations["SUCCESS_UPDATE_TEACHER_DATA"] . "</font><br><br>";
		}
		?>
		<label id=asteriskWarning>Os campos branddos com asterisco (<mark id=asterisk>*</mark>) são obrigatórios!</label>
		<table id="formFields">
			<?php
			while ($result = mysqli_fetch_array($query)) {
				$idTeacher = $result["id"];
				$deliveredToRegistrationNumber = $result["registrationNumber"];
				$employeeType = $result["employeeType"];
				$name = $result["name"];
				$email = $result["email"];
				$extNum = $result["phoneExtension"];
				$phone = $result["phoneNumber"];
				$course = $result["course"];
				$room = $result["room"];
			?>
				<tr>
					<td colspan=2 id=spacer><?php echo $translations["TEACHER_DATA"] ?></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["TEACHER_REGISTRATION_NUMBER"] ?><mark id=asterisk>*</mark></td>
					<input type=hidden name=txtIdTeacher value="<?php echo $idTeacher; ?>">
					<td><input type=text name=txtregNum maxlength="8" required value="<?php echo $deliveredToRegistrationNumber; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["EMPLOYEE_TYPE"] ?><mark id=asterisk>*</mark></td>
					<td>
						<select name=txttypeemployee required>
							<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?></option>
							<option value="Teacher" <?php if ($typeemployee == "Teacher") echo "selected='selected'"; ?>><?php echo $translations["TEACHER_TYPE_1"] ?></option>
							<option value="Técnico Administractive em Educação" <?php if ($typeemployee == "Técnico Administractive em Educação") echo "selected='selected'"; ?>><?php echo $translations["TEACHER_TYPE_2"] ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td id="label">name<mark id=asterisk>*</mark></td>
					<td><input type=text name=txtname required value="<?php echo $name; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["TEACHER_EMAIL"] ?><mark id=asterisk>*</mark></td>
					<td><input type=email name=txtEmail required value="<?php echo $email; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["TEACHER_PHONE_EXTENSION"] ?></td>
					<td><input type=text name=txtextNum maxLength=4 value="<?php echo $extNum; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["TEACHER_PHONE_NUMBER"] ?><mark id=asterisk>*</mark></td>
					<td><input type=text name=txtphone minLength=11 maxLength=11 required value="<?php echo $phone; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["TEACHER_COURSE"] ?><mark id=asterisk>*</mark></td>
					<td><input type=text name=txtcourse required value="<?php echo $course; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["TEACHER_ROOM"] ?></td>
					<td><input type=text name=txtroom maxLength=4 value="<?php echo $room; ?>"></td>
				</tr>
				<tr>
					<td colspan=2 id=spacer><?php echo $translations["MRBS_TEMPLATE"] ?></td>
				</tr>
				<tr>
					<?php
					if ($deliveredToRegistrationNumber == "" || $employeeType == null || $name == "" || $email == "" || $phone == "" || $course == "") {
					?>
						<td colspan=2 style="color:red;"><br><?php echo "<h4> Completar dados cadastrais antes de continuar! " ?></br></td>
						<?php
					} else {
						if ($employeeType == "Técnico Administractive em Educação") {
						?>
							<td colspan=2><br><?php echo "<h4>" . "TAE" . " " . $name . " - course de " . $course; ?></br></td>
						<?php
						} else {
						?>
							<td colspan=2><br><?php echo "<h4>" . "Prof." . " " . $name . $translations["COURSE_OF"] . $course; ?></br></td>
						<?php
						}
						?>
				</tr>
				<tr>
					<td colspan=2><br><?php echo $translations["TEACHER_REGISTRATION_NUMBER"] . $deliveredToRegistrationNumber; ?></br></td>
				</tr>
				<tr>
					<td colspan=2><?php echo $translations["TEACHER_COURSE"] . $course; ?> </td>
				</tr>
				<tr>
					<td colspan=2><?php echo $translations["TEACHER_PHONE_NUMBER_SHORT"] . $phone; ?> </td>
				</tr>
				<tr>
					<td colspan=2><?php echo $translations["TEACHER_EMAIL"] . $email; ?> </td>
				</tr>
			<?php
					}
				}
				if ($_SESSION["privilegeLevel"] != $json_config_array["PrivilegeLevels"]["LIMITED_LEVEL"]) {
			?>
			<tr>
				<td colspan=2 align=center><br><input id="updateButton" type=submit value=currentizar></td>
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