<?php
require_once("top.php");
require_once("menu.php");
require_once("updateChecker.php");

?>

<div id="container">
	<div id="middle">
		<fieldset style="text-align: left; font-weight: bold; font-size: 22px; border-radius: 10px; padding: 15px; width: 90%; margin: 0 auto;">
			<legend><?php echo $translations["ABOUT_APCS"] ?></legend>
			<p style="font-weight: normal; font-size: 20px;">
				<?php echo nl2br($translations["DEVELOPERS_TEXT"]) ?>
			</p>
		</fieldset>
		<?php if ($_SESSION != null) { ?>
			<fieldset style="text-align: left; font-weight: bold; font-size: 22px; border-radius: 10px; padding: 15px; width: 90%; margin: 0 auto;">
				<legend><?php echo $translations["ABOUT_HOST_SERVER"] ?></legend>
				<p style="font-weight: normal; font-size: 20px;">
					<b><?php echo $translations["SERVER_OS"] ?></b><?php echo php_uname(); ?><br>
					<b><?php echo $translations["WEBSERVER_VERSION"] ?></b><?php echo $_SERVER["SERVER_SOFTWARE"]; ?><br>
					<b><?php echo $translations["PHP_VERSION"] ?></b><?php echo phpversion(); ?><br>
					<b><?php echo $translations["MYSQL_VERSION"] ?></b><?php echo mysqli_get_server_info($connection); ?><br>
					<b><?php echo $translations["UPDATES"] ?></b>
					<?php if (version_compare($line, $gitHubVersion) >= 0) { ?>
						<font color=<?php echo $colorArray["UPDATED"]; ?>><?php echo $translations["YOUR_SYSTEM_IS_UP_TO_DATE"]; ?></font>
					<?php } else { ?>
						<font color=<?php echo $colorArray["UPDATE_AVAILABLE"]; ?>><?php echo $translations["UPDATE_AVAILABLE"] . " "; ?></b></font><?php echo $release["tag_name"] . " - ";
																							?><a target=_blank id=linksameline href=<?php echo $release["html_url"]; ?>><?php echo $translations["CLICK_HERE_TO_DOWNLOAD"] ?></a><?php } ?>
				</p>
			</fieldset>
		<?php } ?>
	</div>
	<?php
	require_once("foot.php");
	?>