<?php

namespace NaN\Http\Traits;

trait AssertMessageTrait {
	private function __assertHeaderName(string $name): void {
		if (empty($name)) {
			throw new \ValueError('HTTP header name cannot be empty!');
		}

		if (\is_numeric($name)) {
			throw new \ValueError('HTTP header name cannot be numeric!');
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
	}

	private function __assertProtocolVersion(string $protocol_version): void {
		if (!\is_float((float)$protocol_version)) {
			throw new \ValueError('HTTP protocol version must contain a major and minor version!');
		}
	}
}
