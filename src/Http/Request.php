<?php

namespace NaN\Http;

use NaN\Http\Streams\InputStream;
use Psr\Http\Message\{
	RequestInterface as PsrRequestInterface,
	StreamInterface as PsrStreamInterface,
	UriInterface as PsrUriInterface,
};

class Request implements PsrRequestInterface {
	use Traits\MessageTrait;
	use Traits\RequestTrait;
	use Traits\AssertRequestTrait;

	public function __construct(
		string $method,
		PsrUriInterface $uri,
		PsrStreamInterface $body,
		array $headers = [],
	) {
		$this->__assertMethod($method);
		$this->__assertUri($uri);
		$this->__assertHeaders($headers);

		$this->__method = $method;
		$this->__uri = $uri;
		$this->__body = $body;
		$this->__headers = self::prepareHeaders($headers);
	}

	public static function prepareHeaders(array $headers) : array {
		$headers = \array_change_key_case($headers, \CASE_UPPER);

		foreach ($headers as $key => $value) {
			$headers[$key] = (array)$value;
		}

		return $headers;
	}
}
