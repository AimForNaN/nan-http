<?php

namespace NaN\Http\Traits;

use Psr\Http\Message\ServerRequestInterface as PsrServerRequestInterface;

trait ServerRequestTrait {
	use RequestTrait;

	private array $__attributes = [];
	private array $__cookie_params = [];
	private array|object|null $__parsed_body = null;
	private array $__query_params = [];
	private array $__server_params = [];
	private array $__uploaded_files = [];

	public function getAttribute(string $name, $default = null): mixed {
		return $this->__attributes[$name] ?? $default;
	}

	public function getAttributes(): array {
		return $this->__attributes;
	}

	public function getCookieParams(): array {
		return $this->__cookie_params;
	}

	public function getParsedBody(): array|object|null {
		return $this->__parsed_body;
	}

	public function getQueryParams(): array {
		return $this->__query_params;
	}

	public function getServerParams(): array {
		return $this->__server_params;
	}

	public function getUploadedFiles(): array {
		return $this->__uploaded_files;
	}

	public function withAttribute(string $name, $value): PsrServerRequestInterface {
		$new = clone $this;
		$new->__attributes[$name] = $value;

		return $new;
	}

	public function withCookieParams(array $cookie_params): PsrServerRequestInterface {
		$new = clone $this;
		$new->__cookie_params = $cookie_params;

		return $new;
	}

	public function withoutAttribute(string $name): PsrServerRequestInterface {
		$new = clone $this;

		unset($new->__attributes[$name]);

		return $new;
	}

	public function withParsedBody($data): PsrServerRequestInterface {
		$this->__assertParsedBody($data);

		$new = clone $this;
		$new->__parsed_body = $data;

		return $new;
	}

	public function withQueryParams(array $query): PsrServerRequestInterface {
		$new = clone $this;
		$new->__query_params = $query;

		return $new;
	}

	public function withUploadedFiles(array $uploaded_files): PsrServerRequestInterface {
		$this->__assertUploadedFiles($uploaded_files);

		$new = clone $this;
		$new->__uploaded_files = $uploaded_files;

		return $new;
	}

	private function __assertParsedBody(array|object|null $value): void {
	}

	private function __assertUploadedFiles(array $value): void {
	}
}
