<?php

require_once(__DIR__ . "/vendor/autoload.php");

if (isset($_SESSION) && $_SESSION != null) {
	$queryEtag = mysqli_query($connection, "select * from updater") or die("dead " . mysqli_error($connection));

	$row = mysqli_fetch_array($queryEtag, MYSQLI_ASSOC);
	$eTagDB = $row["eTag"];

	$client = new GuzzleHttp\Client();

	$result = $client->head('https://api.github.com/repos/Kevin64/asset-and-personnel-control-system/releases/latest', [
		'headers' => [
			'If-None-Match' => "\"" . $eTagDB . "\""
		]
	]);

	if ($result->getStatusCode() != 304) {
		$client = new \Github\Client();
		$release = $client->api('repo')->releases()->latest($json_constants_array["GITHUB_REPO_OWNER"], $json_constants_array["GITHUB_REPO_NAME"]);
		$gitHubVersion = substr($release["tag_name"], 1);
		$rateLimitRemaining = (string)((int)implode($result->getHeaders()['X-RateLimit-Remaining']) - 2);
	} else {
		$gitHubVersion = $line;
		$rateLimitRemaining = implode($result->getHeaders()['X-RateLimit-Remaining']);
	}
	$eTag = substr($result->getHeaders()["ETag"][0], 3, -1);
	$rateLimit = implode($result->getHeaders()['X-RateLimit-Limit']);

	mysqli_query($connection, "update updater set eTag = '$eTag', rateLimit = '$rateLimit', rateLimitRemaining = '$rateLimitRemaining'") or die("dead " . mysqli_error($connection));
}

?>