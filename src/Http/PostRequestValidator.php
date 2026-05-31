<?php

namespace NaN\Http;

use Nette\Schema\{
	Elements\Structure,
	Processor,
};
use Psr\Http\Message\ServerRequestInterface as PsrServerRequestInterface;

readonly class PostRequestValidator implements Interfaces\RequestValidatorInterface {
	public function __construct(
		public Structure $schema,
	) {
	}

	public function validateRequest(PsrServerRequestInterface $request): mixed {
		if ($request->getMethod() !== 'POST') {
			throw new \RuntimeException('Invalid request method!');
		}

		$processor = new Processor();

		return $processor->process($this->schema, $request->getParsedBody());
	}
}
