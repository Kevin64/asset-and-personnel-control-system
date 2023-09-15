<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

if (isset($_SESSION["privilegeLevel"])) {
	if ($_SESSION["privilegeLevel"] != $privilegeLevelsArray["LIMITED_LEVEL"]) {

?>
		<div id="middle">
			<form action="addEmployee.php" method=post id=formGeneral>
				<h2><?php echo $translations["ADD_EMPLOYEE_FORM"] ?></h2><br>
				<label id=asteriskWarning><?php echo $translations["ASTERISK_MARK_MANDATORY"] ?> (<mark id=asterisk>*</mark>)</label>
				<table id="formFields">
					<tr>
						<td colspan=3 id=spacer><?php echo $translations["EMPLOYEE_DATA"] ?></td>
					</tr>
					<tr>
						<td id=lblFixed><?php echo $translations["EMPLOYEE_REGISTRATION_NUMBER"] ?><mark id=asterisk>*</mark></td>
						
						<td><input type=text name=txtEmployeeRegistrationNumber placeholder="<?php echo $translations["PLACEHOLDER_EMPLOYEE_REGISTRATION_NUMBER"] ?>" maxLength=8 required></td>
					</tr>
					<tr>
						<td id=lblFixed><?php echo $translations["EMPLOYEE_TYPE"]["NAME"] ?><mark id=asterisk>*</mark></td>
						
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
						<td id=lblFixed><?php echo $translations["EMPLOYEE_NAME"] ?><mark id=asterisk>*</mark></td>
						
						<td><input type=text name=txtName placeholder="<?php echo $translations["PLACEHOLDER_EMPLOYEE_NAME"] ?>" required></td>
					</tr>
					<tr>
						<td id=lblFixed><?php echo $translations["EMPLOYEE_EMAIL"] ?><mark id=asterisk>*</mark></td>
						
						<td><input type=email name=txtEmail placeholder="<?php echo $translations["PLACEHOLDER_EMPLOYEE_EMAIL"] ?>" required></td>
					</tr>
					<tr>
						<td id=lblFixed><?php echo $translations["EMPLOYEE_PHONE_EXTENSION"] ?></td>
						
						<td><input type=text name=txtPhoneExtension placeholder="<?php echo $translations["PLACEHOLDER_EMPLOYEE_PHONE_EXTENSION"] ?>" maxLength=4></td>
					</tr>
					<td id=lblFixed><?php echo $translations["EMPLOYEE_PHONE_NUMBER"] ?><mark id=asterisk>*</mark></td>
					
					<td><input type=text name=txtPhoneNumber placeholder="<?php echo $translations["PLACEHOLDER_EMPLOYEE_PHONE_NUMBER"] ?>" minLength=11 maxLength=11 required></td>
					</tr>
					<tr>
						<td id=lblFixed><?php echo $translations["EMPLOYEE_SECTOR"] ?><mark id=asterisk>*</mark></td>
						
						<td><input type=text name=txtSector placeholder="<?php echo $translations["PLACEHOLDER_EMPLOYEE_SECTOR"] ?>" required></td>
					</tr>
					<tr>
						<td id=lblFixed><?php echo $translations["EMPLOYEE_ROOM"] ?></td>
						
						<td><input type=text name=txtRoomNumber placeholder="<?php echo $translations["PLACEHOLDER_EMPLOYEE_ROOM_NUMBER"] ?>" maxLength=4></td>
					</tr>
					<tr>
						<td colspan=3 align="center"><br>
							<input id="registerButton" type="submit" value="<?php echo $translations["LABEL_REGISTER_BUTTON"] ?>">
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