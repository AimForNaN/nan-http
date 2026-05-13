<?php

namespace NaN\Http\Streams;

use Psr\Http\Message\StreamInterface as PsrStreamInterface;

class TempStream implements PsrStreamInterface {
	use Traits\StreamTrait;

	public function __construct() {
		$this->__stream = \fopen('php://temp', 'r+');
	}
}
