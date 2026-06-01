<?php

namespace NaN\Http\RequestValidators\Interfaces;

use Psr\Http\Message\ServerRequestInterface as PsrServerRequestInterface;

interface RequestValidatorInterface {
	public function validateRequest(PsrServerRequestInterface $request): mixed;
}
