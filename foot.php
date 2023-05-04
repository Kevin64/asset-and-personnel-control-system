<?php
require_once("connection.php");

if ($file = fopen("etc/version", "r")) {
	while (!feof($file)) {
		$line = fgets($file);
	}
	fclose($file);
}
?>

<div>
	<div id="foot-up" style="font-size:14px;display:grid;grid-template-columns: 1fr 1fr 1fr;">
		<div style="text-align:center">
			<a href=<?php echo $orgURL ?> target="_blank" style="text-decoration:none;color:white"><?php echo $orgFullName . " " ?><img src="<?php echo $imgArray["OPEN_LINK"] ?>" width="13" height="13"></a>
		</div>
		<div>
			<a href=<?php echo $depURL ?> target="_blank" style="text-decoration:none;color:white"><?php echo $depFullName . " " ?><img src="<?php echo $imgArray["OPEN_LINK"] ?>" width="13" height="13"></a>
		</div>
		<div>
			<a href=<?php echo $subURL ?> target="_blank" style="text-decoration:none;color:white"><?php echo $subDepFullName . " " ?><img src="<?php echo $imgArray["OPEN_LINK"] ?>" width="13" height="13"></a>
		</div>
	</div>
	<div id="foot-up" style="font-size:14px;display:grid;grid-template-columns: 1fr 1fr 1fr;">
		<div style="text-align:center">
			<?php echo $translations["APCS_EMAIL"] ?><a id=linksameline href=<?php echo "mailto:" . $email ?> target="_blank" style="text-decoration:none;color:white"><?php echo $email . " " ?><img src="<?php echo $imgArray["OPEN_LINK"] ?>" width="13" height="13"></a><br>
		</div>
		<div>
			<?php echo $translations["APCS_PHONE"] ?><?php echo $phoneNumber ?>
		</div>
		<?php if ($location != "") { ?>
		<div>
			<a id=linksameline href=<?php echo "https://www.google.com/maps/search/?api=1&query=" . $location ?> target="_blank" style="text-decoration:none;color:white"><?php echo $translations["LOCATION"] . " "  ?><img src="<?php echo $imgArray["OPEN_LINK"] ?>" width="13" height="13"></a>
		</div>
		<?php } ?>
	</div>
	<div id="band">
		<div>
			&nbsp;
		</div>
	</div>
	<div>
		<div id="foot-down" style="font-size:14px;">
			<b><?php echo $json_constants_array["APCS"] ?></b><br>
			<b><?php echo $translations["APCS_VERSION"] ?></b><?php echo $line ?><br>
		</div>
	</div>
</div>

</html>