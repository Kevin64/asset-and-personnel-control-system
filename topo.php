<?php
if (!isset($_SESSION)) {
	session_start();
}

?>

<html>

<head>
	<link rel="stylesheet" href="css/tabelas.css">
	<link rel="stylesheet" href="css/estilos.css">
	<link rel="stylesheet" href="css/formularios.css">
	<link rel="stylesheet" href="css/menu.css">
	<link rel="stylesheet" href="css/input.css">
	<link rel="stylesheet" href="css/anim.css">
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