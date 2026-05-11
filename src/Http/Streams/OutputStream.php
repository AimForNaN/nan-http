<?php

namespace NaN\Http\Streams;

use Psr\Http\Message\StreamInterface as PsrStreamInterface;

class OutputStream implements PsrStreamInterface {
	use Traits\StreamTrait;

	public function __construct() {
		$this->__stream = \fopen('php://output', 'w');
	}

	public function isReadable(): bool {
		return false;
	}

	public function isWritable(): bool {
		return true;
	}
}
