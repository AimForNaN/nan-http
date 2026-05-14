<?php

namespace NaN\Http\Traits;

use Psr\Http\Message\{
	RequestInterface as PsrRequestInterface,
	UriInterface as PsrUriInterface,
};

trait RequestTrait {
	use AssertRequestTrait;

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
		$this->__assertMethod($method);

		$new = clone $this;
		$new->__method = $method;

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
}
