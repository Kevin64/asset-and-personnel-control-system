<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$username = $_POST["txtUser"];
if ($_POST["txtPassword"] != "") {
	$password = password_hash($_POST["txtPassword"], PASSWORD_BCRYPT);
} else {
	$password = null;
}
$privilegeLevel = $_POST["txtPrivilegeLevel"];
$lastLoginDate = null;
$blocked = "0";

$query = mysqli_query($connection, "select * from " . $dbAgentArray["AGENTS_TABLE"] . " where " . $dbAgentArray["USERNAME"] . " = '$username'") or die($translations["ERROR_ADD_AGENT"] . mysqli_error($connection));
$total = mysqli_num_rows($query);

if ($total > 0) {
?>
	<div id="middle">
		<h2><?php echo $translations["AGENT_ALREADY_EXIST"] ?></h2><br><br>
		<a href=queryAgent.php>[<?php echo $translations["AGENT_LIST"] ?>]</a> &nbsp;&nbsp;&nbsp; <a href=index.php>[<?php echo $translations["BACK_TO_HOME"] ?>]</a>
	</div>
	<?php
} else {
	if ($password != null) {
		mysqli_query($connection, "insert into " . $dbAgentArray["AGENTS_TABLE"] . " (" . $dbAgentArray["USERNAME"] . ", " . $dbAgentArray["PASSWORD"] . ", " . $dbAgentArray["PRIVILEGE_LEVEL"] . ", " . $dbAgentArray["LAST_LOGIN_DATE"] . ", " . $dbAgentArray["BLOCKED"] . ") values ('$username', '$password', '$privilegeLevel', '$lastLoginDate', '$blocked')") or die($translations["ERROR_ADD_AGENT"] . mysqli_error($connection));
	?>
		<div id="middle">
			<h2><?php echo $translations["SUCCESS_ADD_AGENT"] ?></h2><br><br>
			<a href=formAddAgent.php>[<?php echo $translations["ADD_ANOTHER"] ?>]</a> &nbsp;&nbsp;&nbsp; <a href=queryAgent.php>[<?php echo $translations["SEE_AGENT_LIST"] ?>]</a> &nbsp;&nbsp;&nbsp; <a href=index.php>[<?php echo $translations["BACK_TO_HOME"] ?>]</a>
		</div>
	<?php
	} else {
	?>
		<div id="middle">
			<h2><?php echo $translations["ERROR_PASSWORD_BLANK"] ?></h2><br><br>
			<a href=queryAgent.php>[<?php echo $translations["SEE_AGENT_LIST"] ?>]</a> &nbsp;&nbsp;&nbsp; <a href=index.php>[<?php echo $translations["BACK_TO_HOME"] ?>]</a>
		</div>
<?php
	}
}
require_once("foot.php");
?>