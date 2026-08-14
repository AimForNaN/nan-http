<?php

namespace NaN\Http\Request\Handlers;

use NaN\DI\{
	Arguments,
	DelegatesContainer,
};
use NaN\Http\ServerRequest;
use Psr\Container\{
	ContainerExceptionInterface as PsrContainerExceptionInterface,
	ContainerInterface as PsrContainerInterface,
	NotFoundExceptionInterface as PsrNotFoundExceptionInterface,
};
use Psr\Http\{
	Message\ResponseInterface as PsrResponseInterface,
	Message\ServerRequestInterface as PsrServerRequestInterface,
	Server\RequestHandlerInterface as PsrRequestHandlerInterface,
};

readonly class ClosureRequestHandler implements PsrRequestHandlerInterface {
	public function __construct(
		private \Closure $__callback,
	) {
	}

	/**
	 * @throws PsrContainerExceptionInterface
	 * @throws \ReflectionException
	 * @throws PsrNotFoundExceptionInterface
	 */
	public function handle(
		PsrServerRequestInterface $request,
	): PsrResponseInterface {
		$callback = $this->__callback;
		$container = new DelegatesContainer([
			PsrServerRequestInterface::class => $request,
		]);
		$services = ServerRequest::getServiceFromRequest(
			PsrContainerInterface::class,
			$request,
		);

		if ($services) {
			$container = $container->withDelegates($services);
		}

		$args = Arguments::fromCallable($callback);
		$resolved = $args->resolve($request->getQueryParams(), $container);

		return $callback(...$resolved);
	}
}
