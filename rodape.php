	<?php
	if ($file = fopen("version.txt", "r")) {
		while(!feof($file)) {
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
			E-mail: ti.ccsh@ufsm.br<br>
			Telefone: 3220-9625<br>
		</font>
	</div>
	</div>

	</html>