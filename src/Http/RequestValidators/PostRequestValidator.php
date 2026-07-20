<?php

namespace NaN\Http\RequestValidators;

use Nette\Schema\Elements\Structure;
use Psr\Http\Message\ServerRequestInterface as PsrServerRequestInterface;

readonly class PostRequestValidator implements Interfaces\RequestValidatorInterface {
	use Traits\RequestValidatorTrait;

	public function __construct(
		public Structure $schema,
	) {
	}

	public function validateRequest(PsrServerRequestInterface $request): mixed {
		if ($request->getMethod() !== 'POST') {
			throw new \RuntimeException('Invalid request method!');
		}

		return $this->__validateData($this->schema, $request->getParsedBody());
	}
}
