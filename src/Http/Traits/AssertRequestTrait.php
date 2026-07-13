<?php

namespace NaN\Http\Traits;

trait AssertRequestTrait {
	private function __assertMethod(string $method): void {
		if (empty($method)) {
			throw new \ValueError('HTTP method cannot be empty!');
		}
	}

	private function __assertRequestTarget(string $target): void {
		if (empty($target)) {
			throw new \ValueError('HTTP request target cannot be empty!');
		}
	}

	private function __assertUri(PsrUriInterface|string $uri): void {
		$uri = (string)$uri;

		if (empty($uri)) {
			throw new \ValueError('URI cannot be empty!');
		}
	}
}
