<?php

require_once __DIR__ . '/../vendor/autoload.php';

use NaN\Http\ServerRequestFactory;
use function NaN\Tests\expect;

$nan_server_request = new ServerRequestFactory()->createServerRequest('', '', $_SERVER);

try {
	expect($nan_server_request->getCookieParams())->toBe($_COOKIE)
		->and($nan_server_request->getQueryParams())->toBe($_GET)
		->and($nan_server_request->getServerParams())->toBe($_SERVER)
		->and($nan_server_request->getParsedBody())->toBe(
			\json_decode(
				\file_get_contents('php://input'),
				true
			)
		)
		->and($nan_server_request->getMethod())->toBe($_SERVER['REQUEST_METHOD'])
		->and((string)$nan_server_request->getUri())->toBe($_SERVER['REQUEST_URI'])
	;
} catch (\Throwable $e) {
	\http_response_code(500);
	print_r($e->getTrace());
}
