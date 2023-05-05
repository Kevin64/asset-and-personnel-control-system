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
					<label id="hov"><span><?php echo $translations["ASSET"] ?></span></label>
					<ol class=slide>
						<li><a href="queryAsset.php"><?php echo $translations["QUERY_ASSET"] ?></a></li>
						<?php
						if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
						?>
							<li><a href="formAddModel.php"><?php echo $translations["ADD_MODEL"] ?></a></li>
						<?php
						}
						?>
						<li><a href="queryModel.php"><?php echo $translations["QUERY_MODEL"] ?></a></li>
					</ol>
				</li>
				<li>
					<label id="hov"><span><?php echo $translations["PERSONNEL"] ?></span></label>
					<ol class=slide>
						<?php
						if ($_SESSION["privilegeLevel"] != $privilegeLevelsArray["LIMITED_LEVEL"]) {
						?>
							<a href="formAddEmployee.php"><?php echo $translations["ADD_EMPLOYEE"] ?></a>
						<?php
						}
						?>
						<a href="queryEmployee.php"><?php echo $translations["QUERY_EMPLOYEE"] ?></a>
					</ol>
				</li>
			<?php
			}
			?>
			<li>
				<?php
				if (!isset($_SESSION["id"])) {
				?>
				<?php
				} else {
				?>
					<label id="hov">
						<span>
							<?php
							echo $_SESSION["username"];
							?>
						</span>
					</label>
				<?php
				}
				?>
				<ol class=slide>
					<?php
					if (isset($_SESSION["privilegeLevel"])) {
						if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
					?>
							<li><a href="queryAgent.php"><?php echo $translations["QUERY_AGENTS"] ?></a></li>
							<li><a href="formAddAgent.php"><?php echo $translations["ADD_AGENT"] ?></a></li>
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