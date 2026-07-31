<?php

namespace NaN\Http\RequestValidators;

use NaN\Http\ResponseFactory;
use NaN\Http\ServerRequest;
use Nette\Schema\Elements\Structure;
use Psr\Http\Message\{
	ResponseFactoryInterface as PsrResponseFactoryInterface,
	ResponseInterface as PsrResponseInterface,
	ServerRequestInterface as PsrServerRequestInterface,
};
use Psr\Http\Server\{
	MiddlewareInterface as PsrMiddlewareInterface,
	RequestHandlerInterface as PsrRequestHandlerInterface,
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
