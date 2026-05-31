<?php

namespace NaN\Http\Interfaces;

use Psr\Http\Message\ServerRequestInterface as PsrServerRequestInterface;

interface RequestValidatorInterface {
	public function validateRequest(PsrServerRequestInterface $request): mixed;
}
