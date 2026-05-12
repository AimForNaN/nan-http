<?php

namespace NaN\Http;

use Psr\Http\Message\{
	ResponseFactoryInterface as PsrResponseFactoryInterface,
	ResponseInterface as PsrResponseInterface,
};

class ResponseFactory implements PsrResponseFactoryInterface {
	public function createResponse(
		int $code = 200,
		string $reason_phrase = '',
		array $headers = [],
	): PsrResponseInterface {
		return new Response($code, $reason_phrase, $headers);
	}
}
