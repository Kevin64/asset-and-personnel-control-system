<?php

header("Content-Type:application/json; charset=UTF-8");

$jsonFinal = file_get_contents(__DIR__ . "/../etc/db-config.json");
echo $jsonFinal;

