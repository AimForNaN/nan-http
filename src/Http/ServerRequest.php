<?php

namespace NaN\Http;

use Psr\Http\Message\{
	ServerRequestInterface as PsrServerRequestInterface,
	StreamInterface as PsrStreamInterface,
	UriInterface as PsrUriInterface,
};

class ServerRequest extends Request implements PsrServerRequestInterface {
	use Traits\ServerRequestTrait;

	/**
	 * @throws \JsonException
	 */
	public function __construct(
		string $method,
		PsrUriInterface $uri,
		PsrStreamInterface $body,
		array $server_params = [],
	) {
		$headers = self::getHeadersFromServerParams($server_params);

		parent::__construct($method, $uri, $body, $headers);

		$cookie_params = self::parseCookiesFromString($this->getHeaderLine('COOKIE'));
		\parse_str($this->getUri()->getQuery(), $query_params);

		$this->__cookie_params = $cookie_params;
		$this->__parsed_body = self::parseServerRequestBody($body, $server_params);
		$this->__query_params = $query_params;
		$this->__server_params = $server_params;
	}

	public static function getHeadersFromServerParams(array $server_params): array {
		$headers = [];

		foreach ($server_params as $key => $value) {
			$upper_key = \strtoupper($key);
			if (\str_starts_with($upper_key, 'HTTP_')) {
				$key = substr($key, 5);
				$headers[$key] = $value;
			}

			if (
				\str_starts_with($upper_key, 'CONTENT_') ||
				\str_starts_with($upper_key, 'REQUEST_')
			) {
				$headers[$key] = $value;
			}
		}

		return $headers;
	}

	public static function parseCookiesFromString(string $cookie_str): array {
		$cookies = [];
		$split = \str_contains($cookie_str, '; ') ?
			\explode('; ', $cookie_str) :
			[$cookie_str]
		;

		foreach ($split as $part) {
			$parts = \explode('=', $part, 2);
			[$name, $value] = $parts + [null, null];

			if ($name && $value) {
				$cookies[$name] = $value;
			}
		}

		return $cookies;
	}

	/**
	 * @throws \JsonException
	 */
	public static function parseServerRequestBody(
		?PsrStreamInterface $body,
		array $server_params,
	): array {
		$request_method = $server_params['REQUEST_METHOD'] ?? '';
		$content_type = $server_params['CONTENT_TYPE'] ?? '';

		if ($request_method === 'POST') {
			switch ($content_type) {
				case 'application/json':
					return \json_decode($body, true, flags: JSON_THROW_ON_ERROR);
				case 'application/x-www-form-urlencoded':
				case 'multipart/form-data':
					\parse_str($body, $parsed_body);
					return $parsed_body;
			}
		}

		return [];
	}
}
