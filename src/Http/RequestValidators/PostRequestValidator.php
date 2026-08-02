<?php

namespace NaN\Http\RequestValidators;

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

readonly class PostRequestValidator implements PsrMiddlewareInterface {
	use Traits\RequestValidatorTrait;

	public function __construct(
		private ?Structure $__schema = null,
	) {
	}

	public function process(
		PsrServerRequestInterface $request,
		PsrRequestHandlerInterface $handler
	): PsrResponseInterface {
		$response_factory = ServerRequest::getServiceFromRequest(
			PsrResponseFactoryInterface::class,
			$request,
			ResponseFactory::class,
		);

		if ($request->getMethod() !== 'POST') {
			return $response_factory->createResponse(405);
		}

		if (!\is_null($this->__schema)) {
			$data = $this->__validateData($this->__schema, $request->getParsedBody());

			if (\is_null($data)) {
				return $response_factory->createResponse(400);
			}

			return $handler->handle($request->withParsedBody($data));
		}

		return $handler->handle($request);
	}
}
