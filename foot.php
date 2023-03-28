<?php
require_once("connection.php");

if ($file = fopen("etc/version", "r")) {
	while (!feof($file)) {
		$line = fgets($file);
	}
	fclose($file);
}
?>
<div id="foot">
	<font style="font-size: 14px;">
		<b><?php echo $translations["ATCS"] ?></b><br>
		<?php echo $translations["ATCS_VERSION"] ?><?php echo $line ?><br>
		Sistema de desenvolvido pela Subdivisão de Tecnologia da Informação do CCSH<Br>
		<?php echo $translations["ATCS_EMAIL"] ?><?php echo $email ?><br>
		<?php echo $translations["ATCS_PHONE"] ?><?php echo $phoneNumber ?>
	</font>
</div>
</div>

</html>