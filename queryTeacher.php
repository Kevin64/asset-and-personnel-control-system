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
	$query = mysqli_query($connection, "select * from teacher order by $orderBy $sort") or die($translations["ERROR_QUERY_TEACHER"] . mysqli_error($connection));
else {
	$rdCriterion = $_POST["rdCriterion"];
	$search = $_POST["txtSearch"];
	$query = mysqli_query($connection, "select * from teacher where $rdCriterion like '%$search%'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
}

$totalTeachers = mysqli_num_rows($query);
?>

<div id="middle">
	<table id="tbSearch">
		<form action=queryTeacher.php method=post>
			<input type=hidden name=txtSend value=1>
			<tr>
				<td align=center><?php echo $translations["SEARCH_FOR"] ?></td>
			</tr>
			<tr>
				<td align=center>
					<select id=filterTeacher name=rdCriterion>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "teacherRegistrationNumber") echo "selected='selected'"; ?>value="teacherRegistrationNumber"><?php echo $translations["TEACHER_REGISTRATION_NUMBER"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "course") echo "selected='selected'"; ?>value="course"><?php echo $translations["TEACHER_COURSE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "name") echo "selected='selected'"; ?>value="name"><?php echo $translations["TEACHER_NAME"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "employeeType") echo "selected='selected'"; ?>value="employeeType"><?php echo $translations["EMPLOYEE_TYPE"]["NAME"] ?></option>
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
	<h2><?php echo $translations["TEACHER_LIST"] ?> (<?php echo $totalTeachers; ?>)</h2><br>
	<table id="teacherData" cellspacing=0>
		<form action="eraseSelectedTeacher.php" method="post">
			<tr id="header_">
				<?php
				if (isset($_SESSION["privilegeLevel"])) {
					if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
				?>
						<td><img src="img/trash.png" width="22" height="29"></td>
				<?php
					}
				}
				?>
				<td><a href="?orderBy=teacherRegistrationNumber&sort=<?php echo $sort; ?>"><?php echo $translations["TEACHER_REGISTRATION_NUMBER"] ?></a></td>
				<td><a href="?orderBy=name&sort=<?php echo $sort; ?>"><?php echo $translations["TEACHER_NAME"] ?></a></td>
				<td><a href="?orderBy=course&sort=<?php echo $sort; ?>"><?php echo $translations["TEACHER_COURSE"] ?></a></td>
				<?php
				if (!in_array(true, $devices)) {
				?>
					<td><a href="?orderBy=employeeType&sort=<?php echo $sort; ?>"><?php echo $translations["EMPLOYEE_TYPE"]["NAME"] ?></a></td>
				<?php
				}
				?>
			</tr>
			<?php
			while ($result = mysqli_fetch_array($query)) {
				$idTeacher = $result["id"];
				$teacherRegistrationNumber = $result["teacherRegistrationNumber"];
				$name = $result["name"];
				$course = $result["course"];
				$employeeType = $result["employeeType"];
			?>
				<tr id="data">
					<?php
					if (isset($_SESSION["privilegeLevel"])) {
						if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
					?>
							<td><input type="checkbox" name="chkDelete[]" value="<?php echo $idTeacher; ?>" onclick="var input = document.getElementById('eraseButton'); if(this.checked){ input.disabled=false;}else{input.disabled=true;}"></td>
					<?php
						}
					}
					?>
					<td><a href="formDetailTeacher.php?id=<?php echo $idTeacher; ?>"><?php echo $teacherRegistrationNumber; ?></a></td>
					<td class="unselectable"><?php echo $name; ?></td>
					<td class="unselectable"><?php echo $course; ?></td>
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