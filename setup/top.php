<!DOCTYPE html>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php

require_once("connection.php");

$userAgent = !empty($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : "";

$android = str_contains($userAgent, "Android");
$iphone = str_contains($userAgent, "iPhone");
$ipad = str_contains($userAgent, "iPad");

$devices = array($android, $iphone, $ipad);

?>

<html>

<head>
	<?php
	if (in_array(true, $devices)) {
	?>
		<link rel="stylesheet" href="<?php __DIR__ ?>/../css.mobile/table.css">
		<link rel="stylesheet" href="<?php __DIR__ ?>/../css.mobile/styles.css">
		<link rel="stylesheet" href="<?php __DIR__ ?>/../css.mobile/forms.css">
		<link rel="stylesheet" href="<?php __DIR__ ?>/../css.mobile/menu.css">
		<link rel="stylesheet" href="<?php __DIR__ ?>/../css.mobile/input.css">
		<link rel="stylesheet" href="<?php __DIR__ ?>/../css.mobile/animation.css">
	<?php
	} else {
	?>
		<link rel="stylesheet" href="<?php __DIR__ ?>/../css.desktop/table.css">
		<link rel="stylesheet" href="<?php __DIR__ ?>/../css.desktop/styles.css">
		<link rel="stylesheet" href="<?php __DIR__ ?>/../css.desktop/forms.css">
		<link rel="stylesheet" href="<?php __DIR__ ?>/../css.desktop/menu.css">
		<link rel="stylesheet" href="<?php __DIR__ ?>/../css.desktop/input.css">
		<link rel="stylesheet" href="<?php __DIR__ ?>/../css.desktop/animation.css">
	<?php
	}
	?>
	<meta charset="utf-8">
	<title>.:: <?php echo $translations["APCS"] ?> ::.</title>
	<link rel="icon" href="<?php echo $imgArray["FAVICON"] ?>" type="image/x-icon" />
</head>

<body>
	<div id="container">
		<div id="top">
		</div>