<?php

namespace NaN\Http\Traits;

trait AssertMessageTrait {
	private function __assertHeaderName(string $name): void {
		if (empty($name)) {
			throw new \InvalidArgumentException('HTTP header name cannot be empty!');
		}

		if (\is_numeric($name)) {
			throw new \InvalidArgumentException('HTTP header name cannot be numeric!');
		}
	}

	private function __assertHeaders(array $headers): void {
		if (empty($headers)) {
			return;
		}

		foreach ($headers as $name => $value) {
			$this->__assertHeaderName($name);
			$this->__assertHeaderValue($value);
		}
	}

	private function __assertHeaderValue(array|string $value): void {
		if (empty($value)) {
			throw new \InvalidArgumentException('HTTP header value cannot be empty!');
		}
	}
}
