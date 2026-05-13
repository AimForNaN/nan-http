<?php

namespace NaN\Http\Streams;

use Psr\Http\Message\{
	StreamFactoryInterface as PsrStreamFactoryInterface,
	StreamInterface as PsrStreamInterface,
};

class StreamsFactory implements PsrStreamFactoryInterface {
	public function createStream(string $content = ''): PsrStreamInterface {
		$stream = new TempStream();

		$stream->write($content);

		return $stream;
	}

	public function createStreamFromFile(
		string $filename,
		string $mode = 'r',
	): PsrStreamInterface {
		return new FileStream($filename, $mode);
	}

	public function createStreamFromResource($resource): PsrStreamInterface {
		return new ResourceStream($resource);
	}
}
