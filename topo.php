<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php

$userAgent = !empty($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';

$android = str_contains($userAgent, "Android");
$iphone = str_contains($userAgent, "iPhone");
$ipad = str_contains($userAgent, "iPad");

$devices = array($android, $iphone, $ipad);

if (!isset($_SESSION)) {
	session_start();
}

?>

<html>

<head>
	<?php
	if (in_array(true, $devices)) {
	?>
	<link rel="stylesheet" href="css.mobile/tabelas.css">
		<link rel="stylesheet" href="css.mobile/estilos.css">
		<link rel="stylesheet" href="css.mobile/formularios.css">
		<link rel="stylesheet" href="css.mobile/menu.css">
		<link rel="stylesheet" href="css.mobile/input.css">
		<link rel="stylesheet" href="css.mobile/anim.css">		
	<?php
	} else {
	?>
		<link rel="stylesheet" href="css.desktop/tabelas.css">
		<link rel="stylesheet" href="css.desktop/estilos.css">
		<link rel="stylesheet" href="css.desktop/formularios.css">
		<link rel="stylesheet" href="css.desktop/menu.css">
		<link rel="stylesheet" href="css.desktop/input.css">
		<link rel="stylesheet" href="css.desktop/anim.css">
	<?php
	}
	?>
	<meta charset="utf-8">
	<title>.:: Sistema de Controle de Patrimônio e Docentes do CCSH ::.</title>
	<link rel="icon" href="favicon.png" type="image/x-icon" />
</head>

<body>
	<?php
	//require_once ("menu.php");
	?>

	<div id="container">
		<div id="topo">
			<?php
			require_once("menu.php");
			?>
		</div>