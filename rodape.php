<?php
require_once __DIR__ . "/conexao.php";

if ($file = fopen("etc/version", "r")) {
	while (!feof($file)) {
		$line = fgets($file);
	}
	fclose($file);
}
?>
<div id="rodape">
	<font style="font-size: 14px;">
		<b>Sistema de controle de patrimônio e docentes do CCSH</b><br>
		Versão: <?php echo $line ?><br>
		Sistema de desenvolvido pela Subdivisão de Tecnologia da Informação do CCSH<Br>
		E-mail: <?php echo $email ?><br>
		Telefone: <?php echo $phone ?>
	</font>
</div>
</div>

</html>