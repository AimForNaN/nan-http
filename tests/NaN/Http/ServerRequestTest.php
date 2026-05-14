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

	test('withAttribute()', function() {
		$req = new ServerRequestFactory()->createServerRequest('POST', '/test')
			->withAttribute('Test', 'test')
		;

		expect($req)->toBeInstanceOf(ServerRequestInterface::class)
			->and($req->getMethod())->toBe('POST')
			->and($req->getUri()->getPath())->toBe('/test')
			->and($req->getAttribute('Test'))->toBe('test')
		;
	});
});
