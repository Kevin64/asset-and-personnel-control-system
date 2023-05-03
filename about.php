<?php
require_once("top.php");
require_once("menu.php");
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
					<b><?php echo $translations["PHP_VERSION"] ?></b><?php echo phpversion(); ?><br>
					<b><?php echo $translations["MYSQL_VERSION"] ?></b><?php echo mysqli_get_server_info($connection); ?>
				</p>
			</fieldset>
		<?php } ?>
	</div>
	<?php
	require_once("foot.php");
	?>