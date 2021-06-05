<?php
session_start();
require_once ("verifica.php");
require_once __DIR__ . '/../conexao.php';

$marca = $_POST["txtMarca"];
$modelo = $_POST["txtModelo"];
$versao = $_POST["txtVersao"];
$tipo = $_POST["txtTipo"];

$query = mysql_query("select usuario from usuarios where id = '$idUsuario'");
$usuario = mysql_result($query, 0, "usuario");

$validaBIOS = mysql_query("select * from bios where modelo = '$modelo'") or die ("Erro ao procurar modelo! ".mysql_error());
$totalBIOS = mysql_num_rows($validaBIOS);

if ($totalPatrimonio == 0) {
//Inserir dados no banco
mysql_query("insert into bios (marca, modelo, versao, tipo) values ('$marca', '$modelo', '$versao', '$tipo')") or die ("Erro ao tentar cadastrar BIOS! ".mysql_error());

header("Location: sucessoBIOS.php");
} else {
	header("Location: cadastroExistenteBIOS.php?modelo='$modelo'");
}
?>
