<?php

namespace NaN\Http\Request\Handlers;

use NaN\Http\{
	ResponseFactory,
	ServerRequest,
};
use Psr\Http\Message\{
	ResponseFactoryInterface as PsrResponseFactoryInterface,
	ResponseInterface as PsrResponseInterface,
	ServerRequestInterface as PsrServerRequestInterface,
};
use Psr\Http\Server\RequestHandlerInterface as PsrRequestHandlerInterface;

class NotFoundRequestHandler implements PsrRequestHandlerInterface {
	public function handle(PsrServerRequestInterface $request): PsrResponseInterface {
		$response_factory = ServerRequest::getServiceFromRequest(
			PsrResponseFactoryInterface::class,
			$request,
			ResponseFactory::class,
		);

		return $response_factory->createResponse(404);
	}
}
