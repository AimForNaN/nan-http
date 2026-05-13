<?php

use NaN\Http\ResponseFactory;
use Psr\Http\Message\ResponseInterface;

describe('Response', function () {
	$rsp = new ResponseFactory()->createResponse();

	test('Response status', function () use ($rsp) {
		expect($rsp)->toBeInstanceOf(ResponseInterface::class)
			->and($rsp->getStatusCode())->toBe(200)
			->and($rsp->getReasonPhrase())->toBe('OK')
		;
	});

	test('Response body', function () use ($rsp) {
		expect($rsp->getBody()->isReadable())->toBeTrue()
			->and($rsp->getBody()->isWritable())->toBeTrue()
		;

		$rsp->getBody()->write('test');

		expect((string) $rsp->getBody())->toBe('test');
	});
});
