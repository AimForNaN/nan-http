<?php

namespace NaN\Http\Traits;

use Psr\Http\Message\{
	MessageInterface as PsrMessageInterface,
	StreamInterface as PsrStreamInterface,
};

trait MessageTrait {
	use AssertMessageTrait;

	private PsrStreamInterface $__body;
	private array $__headers = [];
	private string $__protocol_version = '1.1';

	public function getBody(): PsrStreamInterface {
		return $this->__body;
	}

	public function getHeader(string $name): array {
		$name = \strtolower($name);
		return $this->__headers[$name] ?? [];
	}

	public function getHeaderLine(string $name): string {
		if (!$this->hasHeader($name)) {
			return '';
		}

		return \implode(',', $this->getHeader($name));
	}

	public function getHeaders(): array {
		return $this->__headers;
	}

	public function getProtocolVersion(): string {
		return $this->__protocol_version;
	}

	public function hasHeader(string $name): bool {
		return \array_key_exists(\strtolower($name), $this->__headers);
	}

	public function withAddedHeader(string $name, $value): PsrMessageInterface {
		$this->__assertHttpHeaderName($name);
		$this->__assertHttpHeaderValue($value);

		$name = \strtolower($name);
		$value = (array)$value;
		$others = $this->__headers[$name] ?? [];
		$new = clone $this;

		$new->__headers[$name] = [...$others, ...$value];

		return $new;
	}

	public function withBody(PsrStreamInterface $body): PsrMessageInterface {
		$new = clone $this;
		$new->__body = $body;

		return $new;
	}

	public function withHeader(string $name, $value): PsrMessageInterface {
		$this->__assertHttpHeaderName($name);
		$this->__assertHttpHeaderValue($value);

		$name = \strtolower($name);
		$new = clone $this;

		$new->__headers[$name] = (array)$value;

		return $new;
	}

	public function withoutHeader(string $name): PsrMessageInterface {
		$name = \strtolower($name);
		$new = clone $this;

		unset($new->__headers[$name]);

		return $new;
	}

	public function withProtocolVersion(string $version): PsrMessageInterface {
		$new = clone $this;
		$new->__protocol_version = $version;
		return $new;
	}
}
