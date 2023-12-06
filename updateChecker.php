<?php

require_once(__DIR__ . "/vendor/autoload.php");

if (isset($_SESSION) && $_SESSION != null) {
	$client = new \Github\Client();
	$release = $client->api('repo')->releases()->latest($json_constants_array["GITHUB_REPO_OWNER"], $json_constants_array["GITHUB_REPO_NAME"]);
	$gitHubVersion = substr($release["tag_name"], 1);
}
