<?php

require __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\RequestException;

$client = new GuzzleHttp\Client([
	'base_uri' => 'http://localhost:9001/',
]);

try {
	$rsp = $client->get('/ServerRequestFactoryTest.php?test=test');
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
} catch (RequestException $e) {
	$rsp = $e->getResponse();
	echo $rsp->getBody();
}

