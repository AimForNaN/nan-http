<?php

namespace NaN\Http;

use Laminas\Diactoros\Uri;
use Psr\Http\Message\{
	ServerRequestFactoryInterface as PsrServerRequestFactoryInterface,
	ServerRequestInterface as PsrServerRequestInterface,
	UriInterface as PsrUriInterface,
};

class ServerRequestFactory implements PsrServerRequestFactoryInterface {
	use Traits\AssertRequestTrait;

	/**
	 * @param string $method If empty, defaults to `$server_params['REQUEST_METHOD']`.
	 * @param PsrUriInterface|string $uri If empty, will default to `$server_params['REQUEST_URI']`.
	 * @param array $server_params If empty, will default to `$_SERVER`.
	 *
	 * @return PsrServerRequestInterface Will be based off of server parameters.
	 * @throws \JsonException
	 */
	public function createServerRequest(
		string $method,
		$uri,
		array $server_params = [],
	): PsrServerRequestInterface {
		if (empty($server_params)) {
			$server_params = $_SERVER;
		}

		if (empty($method)) {
			$method = $server_params['REQUEST_METHOD'] ?? '';
		}

		if (empty($uri)) {
			$uri = $server_params['REQUEST_URI'] ?? '';
		}

		$this->__assertUri($uri);

		return new ServerRequest(
			$method,
			new Uri((string)$uri),
			$server_params,
		);
	}
}
