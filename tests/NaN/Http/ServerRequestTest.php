<?php

use NaN\Http\ServerRequestFactory;
use Psr\Http\Message\ServerRequestInterface;

describe('ServerRequest', function() {
	test('createServerRequest() with empty arguments', function() {
		$req = new ServerRequestFactory()->createServerRequest('', '', [
			'REQUEST_METHOD' => 'GET',
			'REQUEST_URI' => '/',
		]);

		expect($req)->toBeInstanceOf(ServerRequestInterface::class)
			->and($req->getMethod())->toBe('GET')
			->and($req->getUri()->getPath())->toBe('/')
		;
	});
});
