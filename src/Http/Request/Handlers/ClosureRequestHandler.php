<?php

namespace NaN\Http\Request\Handlers;

use Psr\Http\Message\{
	ResponseInterface as PsrResponseInterface,
	ServerRequestInterface as PsrServerRequestInterface,
};
use Psr\Http\Server\RequestHandlerInterface as PsrRequestHandlerInterface;

readonly class ClosureRequestHandler implements PsrRequestHandlerInterface{
	public function __construct(
		private \Closure $__callback,
	) {
	}

	public function handle(PsrServerRequestInterface $request): PsrResponseInterface {
		$callback = $this->__callback;

		return $callback($request);
	}
}
