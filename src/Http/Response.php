<?php

namespace NaN\Http;

use Amp\Http\HttpStatus;
use NaN\Http\Streams\TempStream;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

class Response implements PsrResponseInterface {
	use Traits\MessageTrait;
	use Traits\ResponseTrait;

	public function __construct(
		int $status_code = 200,
		string $reason_phrase = '',
		array $headers = [],
		string $protocol_version = '1.1',
	) {
		$headers = Message::prepareHeaders($headers);

		if (empty($reason_phrase)) {
			$reason_phrase = self::getReasonPhraseForStatusCode($status_code);
		}

		$this->__assertHeaders($headers);
		$this->__assertProtocolVersion($protocol_version);

		$this->__status_code = $status_code;
		$this->__reason_phrase = $reason_phrase;
		$this->__body = new TempStream();
		$this->__headers = $headers;
		$this->__protocol_version = $protocol_version;
	}

	public static function getReasonPhraseForStatusCode(int $status_code): string {
		return HttpStatus::getReason($status_code);
	}

	public static function withJson(
		PsrResponseInterface $response,
		array|object $data,
	): PsrResponseInterface {
		$body = new TempStream();

		$body->write(\json_encode($data));

		return $response
			->withBody($body)
			->withHeader('Content-Type', 'application/json')
		;
	}

	public static function withRedirect(
		PsrResponseInterface $response,
		string $path,
		int $status_code = 302,
	): PsrResponseInterface {
		if (!HttpStatus::isRedirect($status_code)) {
			throw new \RuntimeException('Invalid redirect response code!');
		}

		return $response
			->withHeader('Location', $path)
			->withStatus($status_code)
		;
	}
}
