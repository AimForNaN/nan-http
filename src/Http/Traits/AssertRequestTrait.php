<?php

namespace NaN\Http\Traits;

trait AssertRequestTrait {
	private function __assertMethod(string $method): void {
		if (empty($method)) {
			throw new \InvalidArgumentException('HTTP method cannot be empty!');
		}
	}

	private function __assertRequestTarget(string $target): void {
		if (empty($target)) {
			throw new \InvalidArgumentException('HTTP request target cannot be empty!');
		}
	}

	private function __assertUri(PsrUriInterface|string $uri): void {
		$uri = (string)$uri;

		if (empty($uri)) {
			throw new \InvalidArgumentException('URI cannot be empty!');
		}
	}
}
