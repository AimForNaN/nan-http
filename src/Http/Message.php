<?php

namespace NaN\Http;

final class Message {
	public static function prepareHeaders(array $headers) : array {
		$prepared_headers = [];

		foreach ($headers as $key => $value) {
			$prepared_headers[\strtoupper($key)] = (array)$value;
		}

		return $prepared_headers;
	}

	public static function mergeHeaders(array $headers) : array {
		$merged_headers = [];

		foreach ($headers as $key => $value) {
			$merged_headers[\strtoupper($key)] = self::mergeHeaderValue($value);
		}

		return $merged_headers;
	}

	public static function mergeHeaderValue(array $value) : string {
		return \implode(',', $value);
	}
}
