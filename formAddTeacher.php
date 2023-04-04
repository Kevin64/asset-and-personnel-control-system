<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

if (isset($_SESSION["privilegeLevel"])) {
	if ($_SESSION["privilegeLevel"] != $privilegeLevelsArray["LIMITED_LEVEL"]) {

?>
		<div id="middle">
			<form action="addTeacher.php" method=post id=formGeneral>
				<h2><?php echo $translations["ADD_TEACHER_FORM"] ?></h2><br>
				<label id=asteriskWarning><?php echo $translations["ASTERISK_MARK_MANDATORY"] ?> (<mark id=asterisk>*</mark>)</label>
				<table id="formFields">
					<tr>
						<td colspan=2 id=spacer><?php echo $translations["TEACHER_DATA"] ?></td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["TEACHER_REGISTRATION_NUMBER"] ?><mark id=asterisk>*</mark></td>
						<td><input type=text name=txtTeacherRegistrationNumber placeholder="Ex.: 1234567" maxLength=8 required></td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["EMPLOYEE_TYPE"]["NAME"] ?><mark id=asterisk>*</mark></td>
						<td>
							<select name=txtEmployeeType required>
								<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
								<?php
								foreach ($employeeTypesArray as $str1 => $str2) {
								?>
									<option value=<?php echo $str1 ?>> <?php echo $translations["EMPLOYEE_TYPE"][$str1] ?></option>
									<?php
								}
									?>
							</select>
						</td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["TEACHER_NAME"] ?><mark id=asterisk>*</mark></td>
						<td><input type=text name=txtName placeholder="Ex.: Fulano de Tal" required></td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["TEACHER_EMAIL"] ?><mark id=asterisk>*</mark></td>
						<td><input type=email name=txtEmail placeholder="Ex.: fulano@email.com" required></td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["TEACHER_PHONE_EXTENSION"] ?></td>
						<td><input type=text name=txtPhoneExtension placeholder="Ex.: 9876" maxLength=4></td>
					</tr>
					<td id="label"><?php echo $translations["TEACHER_PHONE_NUMBER"] ?><mark id=asterisk>*</mark></td>
					<td><input type=text name=txtPhoneNumber placeholder="Ex.: 55998765432" minLength=11 maxLength=11 required></td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["TEACHER_COURSE"] ?><mark id=asterisk>*</mark></td>
						<td><input type=text name=txtCourse placeholder="Ex.: Curso de Humanas" required></td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["TEACHER_ROOM"] ?></td>
						<td><input type=text name=txtRoom placeholder="Ex.: 4413" maxLength=4></td>
					</tr>
					<tr>
						<td colspan="2" align="center"><br>
							<input id="registerButton" type="submit" value="<?php echo $translations["REGISTER"] ?>">
						</td>
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