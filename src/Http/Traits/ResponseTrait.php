<?php

namespace NaN\Http\Traits;

use Psr\Http\Message\ResponseInterface;

trait ResponseTrait {
	use AssertResponseTrait;

	private int $__status_code;
	private string $__reason_phrase;

	public function getReasonPhrase(): string {
		return $this->__reason_phrase;
	}

	public function getStatusCode(): int {
		return $this->__status_code;
	}

	public function withStatus($code, $reason_phrase = ''): ResponseInterface {
		$this->__assertStatusCode($code);

		if (empty($reason_phrase)) {
			$reason_phrase = \Amp\Http\HttpStatus::getReason($code);
		}

		$new = clone $this;
		$new->__status_code = $code;
		$new->__reason_phrase = $reason_phrase;

		return $new;
	}
}
