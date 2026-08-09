<?php

namespace NaN\Http\Request\Validators;

use NaN\Http\{
	ResponseFactory,
	ServerRequest,
};
use Nette\Schema\Elements\Structure;
use Psr\Http\{
	Message\ResponseFactoryInterface as PsrResponseFactoryInterface,
	Message\ResponseInterface as PsrResponseInterface,
	Message\ServerRequestInterface as PsrServerRequestInterface,
	Server\MiddlewareInterface as PsrMiddlewareInterface,
	Server\RequestHandlerInterface as PsrRequestHandlerInterface,
};

readonly class CookieRequestValidator implements PsrMiddlewareInterface {
	use Traits\RequestValidatorTrait;

	public function __construct(
		private Structure $__schema,
	) {
	}

	public function process(
		PsrServerRequestInterface $request,
		PsrRequestHandlerInterface $handler,
	): PsrResponseInterface {
		$response_factory = ServerRequest::getServiceFromRequest(
			PsrResponseFactoryInterface::class,
			$request,
			ResponseFactory::class,
		);
		$data = $this->__validateData($this->__schema, $request->getCookieParams());

		if (\is_null($data)) {
			return $response_factory->createResponse(400);
		}

		return $handler->handle($request->withCookieParams($data));
	}
}
