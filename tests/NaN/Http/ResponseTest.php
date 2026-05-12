<?php

use NaN\Http\ResponseFactory;
use Psr\Http\Message\ResponseInterface;

describe('Response', function () {
	test('ResponseFactory', function () {
		$rsp = new ResponseFactory()->createResponse();

		expect($rsp)->toBeInstanceOf(ResponseInterface::class)
			->and($rsp->getStatusCode())->toBe(200)
			->and($rsp->getReasonPhrase())->toBe('OK')
		;
	});
});
