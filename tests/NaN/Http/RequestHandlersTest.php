<?php

use NaN\Http\{
	ResponseFactory,
	ServerRequestFactory,
};
use NaN\Http\Request\Handlers\{
	ClosureRequestHandler,
	NotFoundRequestHandler,
};
use Psr\Http\Message\ServerRequestInterface as PsrServerRequestInterface;

describe('RequestHandlers', function () {
	test('ClosureRequestHandler', function () {
		$handler = new ClosureRequestHandler(function (PsrServerRequestInterface $request) {
			return new ResponseFactory()->createResponse();
		});
		$req = new ServerRequestFactory()->createServerRequest('GET', '/');
		$rsp = $handler->handle($req);

		expect($rsp->getStatusCode())->toBe(200);
	});

	test('NotFoundRequestHandler', function () {
		$handler = new NotFoundRequestHandler();
		$req = new ServerRequestFactory()->createServerRequest('GET', '/');
		$rsp = $handler->handle($req);

		expect($rsp->getStatusCode())->toBe(404);
	});
});
