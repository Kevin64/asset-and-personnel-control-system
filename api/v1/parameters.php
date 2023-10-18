<?php

header("Content-Type:application/json; charset=UTF-8");

$jsonFinal = file_get_contents(__DIR__ . "/../../etc/parameters.json");
http_response_code(200);
echo $jsonFinal;

