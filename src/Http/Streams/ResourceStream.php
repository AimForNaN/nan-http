<?php

namespace NaN\Http\Streams;

use Psr\Http\Message\StreamInterface as PsrStreamInterface;

class ResourceStream implements PsrStreamInterface {
	use Traits\StreamTrait;
	use Traits\AssertStreamTrait;

	public function __construct($resource) {
		$this->__assertResource($resource);

		$this->__stream = $resource;
	}
}
