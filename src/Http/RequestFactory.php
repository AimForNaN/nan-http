<?php

namespace NaN\Http;

use Laminas\Diactoros\Uri;
use NaN\Http\Streams\TempStream;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;

class RequestFactory implements RequestFactoryInterface {

	public function createRequest(
		string $method,
		$uri,
		array $headers = [],
	): RequestInterface {
		return new Request($method, new Uri((string)$uri), new TempStream(), $headers);
	}
}
