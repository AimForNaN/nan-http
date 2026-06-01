<?php

namespace NaN\Http\RequestValidators;

use Nette\Schema\{
	Elements\Structure,
	Processor,
};
use Psr\Http\Message\ServerRequestInterface as PsrServerRequestInterface;

readonly class CookieRequestValidator implements Interfaces\RequestValidatorInterface {
	public function __construct(
		public Structure $schema,
	) {
	}

	public function validateRequest(PsrServerRequestInterface $request): mixed {
		$processor = new Processor();

		return $processor->process($this->schema, $request->getCookieParams());
	}
}
