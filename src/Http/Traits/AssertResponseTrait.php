<?php

namespace NaN\Http\Traits;

trait AssertResponseTrait {
	private function __assertStatusCode(int $code) {
		if ($code <= 0) {
			throw new \RuntimeException('Invalid status code!');
		}
	}
}
