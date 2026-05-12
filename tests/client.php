<?php

require __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Cookie\CookieJar;

$client = new GuzzleHttp\Client([
	'base_uri' => 'http://localhost:9001/',
]);

try {
	$rsp = $client->post('/ServerRequestFactoryTest.php', [
		'body' => json_encode([
			'test' => 'test',
		]),
		'cookies' => CookieJar::fromArray([
			'foo' => 'bar',
		], 'localhost'),
		'headers' => [
			'Content-Type' => 'application/json',
		],
	]);
} catch (\GuzzleHttp\Exception\RequestException $e) {
	$rsp = $e->getResponse();
	echo $rsp->getBody();
}

