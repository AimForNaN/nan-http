<?php

namespace NaN\Http\RequestValidators;

use Nette\Schema\Elements\Structure;
use Psr\Http\Message\ServerRequestInterface as PsrServerRequestInterface;

readonly class GetRequestValidator implements Interfaces\RequestValidatorInterface {
	use Traits\RequestValidatorTrait;

	public function __construct(
		public Structure $schema,
	) {
	}

	public function validateRequest(PsrServerRequestInterface $request): mixed {
		if ($request->getMethod() !== 'GET') {
			throw new \RuntimeException('Invalid request method!');
		}

		return $this->__validateData($this->schema, $request->getQueryParams());
	}
}
