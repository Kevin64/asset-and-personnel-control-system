<?php
require_once("connection.php");
?>
<div id="menu">
	<nav>
		<ul>
			<li>
				<a href="index.php"><?php echo $translations["HOMEPAGE"] ?></a>
			</li>
			<?php if (isset($_SESSION["id"])) {
			?>
				<li>
					<label id="hov"><span>Patrimônio</span></label>
					<ol class=slide>
						<li><a href="queryAsset.php"><?php echo $translations["QUERY_ASSET"] ?></a></li>
						<?php
						if ($_SESSION["privilegeLevel"] == $json_config_array["PrivilegeLevels"]["ADMIN_LEVEL"]) {
						?>
							<li><a href="formAddModel.php"><?php echo $translations["ADD_MODEL"] ?></a></li>
						<?php
						}
						?>
						<li><a href="queryModel.php"><?php echo $translations["QUERY_MODEL"] ?></a></li>
					</ol>
				</li>
				<li>
					<label id="hov"><span><?php echo $translations["TEACHER_TYPE_1"] ?></span></label>
					<ol class=slide>
						<?php
						if ($_SESSION["privilegeLevel"] != $json_config_array["PrivilegeLevels"]["LIMITED_LEVEL"]) {
						?>
							<a href="formAddTeacher.php"><?php echo $translations["ADD_TEACHER"] ?></a>
						<?php
						}
						?>
						<a href="queryTeacher.php"><?php echo $translations["QUERY_TEACHER"] ?></a>
					</ol>
				</li>
			<?php
			}
			?>
			<li>
				<?php
				if (!isset($_SESSION["id"])) {
				?>
					<!-- <span>Usuário desconectado</span> -->
				<?php
				} else {
				?>
					<label id="hov">
						<span>
							<?php
							echo "" . $_SESSION["username"];
							?>
						</span>
					</label>
				<?php
				}
				?>
				<ol class=slide>
					<?php
					if (isset($_SESSION["privilegeLevel"])) {
						if ($_SESSION["privilegeLevel"] == $json_config_array["PrivilegeLevels"]["ADMIN_LEVEL"]) {
					?>
							<li><a href="queryUser.php"><?php echo $translations["QUERY_USERS"] ?></a></li>
							<li><a href="formAddUser.php"><?php echo $translations["ADD_USER"] ?></a></li>
							<li><a href="formChangePassword.php"><?php echo $translations["CHANGE_PASSWORD"] ?></a></li>
							<li><a href="logout.php"><?php echo $translations["LOGOUT"] ?></a></li>
						<?php
						} else {
						?>
							<li><a href="formChangePassword.php"><?php echo $translations["CHANGE_PASSWORD"] ?></a></li>
							<li><a href="logout.php"><?php echo $translations["LOGOUT"] ?></a></li>
					<?php
						}
					}
					?>
				</ol>
			</li>
			<li>
				<a href="about.php"><?php echo $translations["ABOUT"] ?></a>
			</li>			
		</ul>
	</nav>
</div>