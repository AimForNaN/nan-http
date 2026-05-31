<?php

namespace NaN\Http;

use Nette\Schema\{
	Elements\Structure,
	Processor,
};
use Psr\Http\Message\ServerRequestInterface as PsrServerRequestInterface;

readonly class RequestValidator {
	public function __construct(
		public Structure $schema,
	) {
	}

	public function validate(PsrServerRequestInterface $request): mixed {
		$method = $request->getMethod();
		$data = $method === 'GET' ? $request->getQueryParams() : $request->getParsedBody();
		$processor = new Processor();

		return $processor->process($this->schema, $data);
	}
}
