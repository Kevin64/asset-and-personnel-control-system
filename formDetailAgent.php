<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$send = null;

if (isset($_POST["txtSend"]))
	$send = $_POST["txtSend"];

if ($send != 1) {
	$idUser = $_GET["id"];
	$query = mysqli_query($connection, "select * from " . $dbAgentArray["AGENTS_TABLE"] . " where id = '$idUser'") or die($translations["ERROR_SHOW_DETAIL_AGENT"] . mysqli_error($connection));
}
?>

<div id="middle">
	<form id="formGeneral">
		<h1><?php echo $translations["AGENT_DETAIL"] ?></h1><br>
		<table id="formFields">
			<?php
			while ($result = mysqli_fetch_array($query)) {
				$idUser = $result["id"];
				$username = $result[$dbAgentArray["USERNAME"]];
				$oldUsername = $result[$dbAgentArray["USERNAME"]];
				$privilegeLevel = $result[$dbAgentArray["PRIVILEGE_LEVEL"]];
				$lastLoginDate = $result[$dbAgentArray["LAST_LOGIN_DATE"]];
				$blocked = $result[$dbAgentArray["BLOCKED"]];
			?>
				<tr>
					<td colspan=3 id=section-header><?php echo $translations["AGENT_DATA"] ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["USERNAME"] ?></td>
					<input type=hidden name=txtIdUser value="<?php echo $idUser; ?>">
					<input type=hidden name=txtOldUsername value="<?php echo $oldUsername; ?>">
					<td id=lblData><?php echo $username; ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["PRIVILEGE"]["NAME"] ?></td>
					<td id=lblData>
						<?php
						if ($privilegeLevel == "") {
							$privilegeLevel = $json_constants_array["DASH"];
						} else {
							foreach ($privilegeLevelsArray as $str2) {
								if ($privilegeLevel == $str2) {
									echo $translations["PRIVILEGE"][$str2];
								}
							}
						}
						?>
					</td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["BLOCKED_AGENT"] ?></td id=lblData>
					<td id=lblData><?php if ($blocked == "") {
										echo $json_constants_array["DASH"];
									} else {
										if ($blocked == 1) {
											echo "Sim";
										} else {
											echo "Não";
										}
									}
									?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["LAST_LOGIN_DATE"] ?></td>
					<td id=lblData><?php if ($lastLoginDate == "") {
										echo $json_constants_array["DASH"];
									} else {
										echo $lastLoginDate;
									} ?></td>
				</tr>
				<?php
			}
			if (isset($_SESSION["privilegeLevel"])) {
				if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
				?>
					<tr>
						<td id=h-separator colspan=3 align=center><input id="updateButton" type=button onclick="location.href='editAgent.php?id=<?php echo $idUser ?>'" value=<?php echo $translations["LABEL_EDIT_BUTTON"] ?>></td>
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