<?php
require_once("verify.php");
require_once("top.php");
require_once("connection.php");

$delete = $_POST["chkDelete"];

if (isset($delete)) {
	for ($i = 0; $i < count($delete); $i++) {
		$query2 = mysqli_query($connection, "delete from maintenances where id in (select main from (select maintenances.id as main from maintenances inner join (select asset from asset where id = '$delete[$i]') as a on a.asset = maintenances.assetNumberFK) as m)") or die($translations["ERROR_DELETE_ASSET"] . mysqli_error($connection));
		$query = mysqli_query($connection, "delete from asset where id = '$delete[$i]'") or die($translations["ERROR_DELETE_ASSET"] . mysqli_error($connection));
	}
}

header("Location: queryAsset.php?del=ok");
