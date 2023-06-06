<?php
require_once("top.php");
require_once("menu.php");
require_once __DIR__ . '/vendor/autoload.php';

$client = new \Github\Client();
$release = $client->api('repo')->releases()->latest('Kevin64', 'asset-and-personnel-control-system');
$gitHubVersion = substr($release["tag_name"], 1);
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
					<?php if (version_compare($line, $gitHubVersion) >= 0) { ?>
						<b><?php echo $translations["YOUR_SYSTEM_IS_UP_TO_DATE"]; ?></b>
					<?php } else { ?>
						<b><?php echo $translations["NEW_VERSION_AVAILABLE"] . ": "; ?></b><?php echo $release["tag_name"] . " - ";
																							?><a target=_blank id=linksameline href=<?php echo $release["html_url"]; ?>><?php echo $translations["CLICK_HERE_TO_DOWNLOAD"] ?></a><?php } ?>
				</p>
			</fieldset>
		<?php } ?>
	</div>
	<?php
	require_once("foot.php");
	?>