<?php

namespace NaN\Http\Streams\Traits;

trait AssertStreamTrait {
	private function __assertResource(mixed $stream): void {
		\get_resource_type($stream);
	}
}
