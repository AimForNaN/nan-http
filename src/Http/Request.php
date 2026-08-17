<?php

namespace NaN\Http;

use NaN\Http\Streams\TempStream;
use Psr\Http\Message\{
	RequestInterface as PsrRequestInterface,
	StreamInterface as PsrStreamInterface,
	UriInterface as PsrUriInterface,
};

class Request implements PsrRequestInterface {
	use Traits\MessageTrait;
	use Traits\RequestTrait;

	public function __construct(
		string $method,
		PsrUriInterface $uri,
		PsrStreamInterface $body = new TempStream(),
		array $headers = [],
	) {
		$headers = Message::prepareHeaders($headers);

		$this->__assertMethod($method);
		$this->__assertUri($uri);
		$this->__assertHeaders($headers);

		$this->__method = $method;
		$this->__uri = $uri;
		$this->__body = $body;
		$this->__headers = $headers;
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
}
