<?php

namespace NaN\Http\Streams\Traits;

trait AssertStreamTrait {
	private function __assertResource(mixed $stream): void {
		assert(\is_resource($stream), new \RuntimeException('Invalid resource!'));
	}
}
