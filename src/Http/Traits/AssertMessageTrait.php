<?php

namespace NaN\Http\Traits;

trait AssertMessageTrait {
	private function __assertHttpHeaderName(string $name): void {
		if (empty($name)) {
			throw new \InvalidArgumentException('HTTP header name cannot be empty!');
		}

		if (\is_numeric($name)) {
			throw new \InvalidArgumentException('HTTP header name cannot be numeric!');
		}
	}

	private function __assertHttpHeaders(array $headers): void {
		if (empty($headers)) {
			return;
		}

		foreach ($headers as $name => $value) {
			$this->__assertHttpHeaderName($name);
			$this->__assertHttpHeaderValue($value);
		}
	}

	private function __assertHttpHeaderValue(array|string $value): void {
		if (empty($value)) {
			throw new \InvalidArgumentException('HTTP header value cannot be empty!');
		}
	}
}
