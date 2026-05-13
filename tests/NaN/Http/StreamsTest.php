<?php

use NaN\Http\Streams\{InputStream, OutputStream, TempStream};

describe('Streams', function () {
	test('InputStream', function () {
		$stream = new InputStream();

		expect($stream->isReadable())->toBeTrue()
			->and($stream->isWritable())->toBeFalse()
		;
	});

	test('OutputStream', function () {
		$stream = new OutputStream();

		expect($stream->isReadable())->toBeFalse()
			->and($stream->isWritable())->toBeTrue()
		;

		\ob_start();
		$stream->write('test');
		expect(\ob_get_clean())->toBe('test');
	});

	test('TempStream', function () {
		$stream = new TempStream();

		expect($stream->isReadable())->toBeTrue()
			->and($stream->isWritable())->toBeTrue()
		;

		$stream->write('test');

		expect((string)$stream)->toBe('test');
	});
});
