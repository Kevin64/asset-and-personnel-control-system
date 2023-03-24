<?php
require_once("top.php");
require_once("menu.php");
?>

<div id="container">
	<div id="meio">
		<font size=5><b><?php echo $translations["ATCS"] ?></b></font><br><br>
		<p align=justify style="padding: 10px; text-indent: 30px;">
		<?php echo $translations["ABOUT_TEXT"] ?><br><br>
		<fieldset style="text-align: left; font-weight: bold; font-size: 15px; border-radius: 20px; padding: 15px; width: 90%; margin: 0 auto;">
			<legend><?php echo $translations["COLLABORATORS"] ?></legend>
			<p style="font-weight: normal; font-size: 14px;">
			<?php echo $translations["DEVELOPERS_TEXT"] ?>
			</p>
		</fieldset>
	</div>
	<?php
	require_once("foot.php");
	?>