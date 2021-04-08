<?php
session_start();
require_once ("verifica.php");
require_once ("conexao.php");

$siape = $_POST["txtSiape"];
$nome = $_POST["txtNome"];
$email = $_POST["txtEmail"];
$ramal = $_POST["txtRamal"];
$celular = $_POST["txtCelular"];
$curso = $_POST["txtCurso"];
$sala = $_POST["txtSala"];

$query = mysql_query("select usuario from usuarios where id = '$idUsuario'");
$usuario = mysql_result($query, 0, "usuario");

$validaDocente = mysql_query("select * from docente where siape = '$siape'") or die ("Erro ao procurar docente! ".mysql_error());
$totalDocente = mysql_num_rows($validaDocente);

if ($totalDocente == 0) {
//Inserir dados no banco
mysql_query("insert into docente (siape, nome, email, ramal, celular, curso, sala) values ('$siape', '$nome', '$email', '$ramal', '$celular', '$curso', '$sala')") or die ("Erro ao tentar cadastrar docente! ".mysql_error());

header("Location: sucessoDocente.php");
} else {
	header("Location: cadastroExistenteDocente.php?siape='$siape'");
}
?>
