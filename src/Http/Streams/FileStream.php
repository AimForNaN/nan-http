<?php

namespace NaN\Http\Streams;

use Psr\Http\Message\StreamInterface as PsrStreamInterface;

class FileStream implements PsrStreamInterface {
	use Traits\StreamTrait;

	public function __construct(string $filename, string $mode = 'r') {
		$this->__stream = \fopen($filename, $mode);
	}
}
