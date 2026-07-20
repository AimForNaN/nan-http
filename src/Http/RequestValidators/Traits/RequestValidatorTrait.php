<?php

namespace NaN\Http\RequestValidators\Traits;

use Nette\Schema\{
	Elements\Structure,
	Processor,
};

trait RequestValidatorTrait {
	private function __validateData(Structure $schema, mixed $data): mixed {
		try {
			$processor = new Processor();

			return $processor->process($schema, $data);
		} catch (\Throwable $e) {
			return null;
		}
	}
}
