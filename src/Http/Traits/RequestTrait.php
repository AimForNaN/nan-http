<?php

namespace NaN\Http\Traits;

use Psr\Http\Message\{
	RequestInterface as PsrRequestInterface,
	UriInterface as PsrUriInterface,
};

trait RequestTrait {
	use MessageTrait;

	private string $__method;
	private string $__request_target;
	private PsrUriInterface $__uri;

	public function getMethod(): string {
		return \strtoupper($this->__method);
	}

	public function getRequestTarget(): string {
		return $this->__request_target;
	}

	public function getUri(): PsrUriInterface {
		return $this->__uri;
	}

	public function withMethod(string $method): PsrRequestInterface {
		$this->__assertHttpMethod($method);

		$new = clone $this;
		$new->__method = \strtoupper($method);

		return $new;
	}

	public function withRequestTarget(string $target): PsrRequestInterface {
		$this->__assertRequestTarget($target);

		$new = clone $this;
		$new->__request_target = $target;

		return $new;
	}
	public function withUri(PsrUriInterface $uri, bool $preserve_host = false): PsrRequestInterface {
		$new = clone $this;

		if ($preserve_host) {
			$host = $this->__uri->getHost();
			$uri = $uri->withHost($host);
		}

		$new->__uri = $uri;

		return $new;
	}

	private function __assertHttpMethod(string $method): void {
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
