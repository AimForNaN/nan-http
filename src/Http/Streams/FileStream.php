<?php

namespace NaN\Http\Streams;

class FileStream extends ResourceStream {
	public function __construct(string $filename, string $mode = 'r') {
		parent::__construct(\fopen($filename, $mode));
	}
}
