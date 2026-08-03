<?php

namespace NaN\Http\RequestValidators;

use NaN\Http\{
	ResponseFactory,
	ServerRequest,
};
use Psr\Http\{
	Message\ResponseFactoryInterface as PsrResponseFactoryInterface,
	Message\ResponseInterface as PsrResponseInterface,
	Message\ServerRequestInterface as PsrServerRequestInterface,
	Server\MiddlewareInterface as PsrMiddlewareInterface,
	Server\RequestHandlerInterface as PsrRequestHandlerInterface,
};

class MethodRequestValidator implements PsrMiddlewareInterface {
	public function __construct(
		private array $__methods = [],
	) {
	}

    public function process(
		PsrServerRequestInterface $request,
		PsrRequestHandlerInterface $handler,
	): PsrResponseInterface {
		/** @var PsrResponseFactoryInterface $response_factory */
		$response_factory = ServerRequest::getServiceFromRequest(
			PsrResponseFactoryInterface::class,
			$request,
			ResponseFactory::class,
		);

		if (!\in_array($request->getMethod(), $this->__methods)) {
			return $response_factory->createResponse(405);
		}

        return $handler->handle($request);
    }
}
