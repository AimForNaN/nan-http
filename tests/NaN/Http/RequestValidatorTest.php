<?php

use NaN\Http\{
	RequestHandlers\NoContentRequestHandler,
	RequestValidators\CookieRequestValidator,
	RequestValidators\GetRequestValidator,
	RequestValidators\PostRequestValidator,
	ServerRequestFactory};
use Nette\Schema\Expect;

describe('RequestValidator', function () {
	test('CookieRequestValidator', function () {
		$handler = new NoContentRequestHandler();
		$validator = new CookieRequestValidator(Expect::array([
			'session' => Expect::string()->required(),
		]));
		$request = new ServerRequestFactory()->createServerRequest('GET', '/');
		$response = $validator->process($request, $handler);

		expect($response->getStatusCode())->toBe(400);

		$response = $validator->process($request->withCookieParams([
			'session' => 'foobar',
		]), $handler);

		expect($response->getStatusCode())->toBe(204);
	});

	test('GetRequestValidator', function () {
		$handler = new NoContentRequestHandler();
		$validator = new GetRequestValidator();
		$request = new ServerRequestFactory()->createServerRequest('POST', '/');
		$response = $validator->process($request, $handler);

		expect($response->getStatusCode())->toBe(405);

		$validator = new GetRequestValidator(Expect::array([
			'foo' => Expect::string()->required(),
		]));
		$request = new ServerRequestFactory()->createServerRequest('GET', '/');
		$response = $validator->process($request->withQueryParams([
			'foo' => 'bar',
		]), $handler);

		expect($response->getStatusCode())->toBe(204);
	});

	test('PostRequestValidator', function () {
		$handler = new NoContentRequestHandler();
		$validator = new PostRequestValidator();
		$request = new ServerRequestFactory()->createServerRequest('GET', '/');
		$response = $validator->process($request, $handler);

		expect($response->getStatusCode())->toBe(405);

		$validator = new PostRequestValidator(Expect::array([
			'foo' => Expect::string()->required(),
		]));
		$request = new ServerRequestFactory()->createServerRequest('POST', '/');
		$response = $validator->process($request->withParsedBody([
			'foo' => 'bar',
		]), $handler);

		expect($response->getStatusCode())->toBe(204);
	});
});
