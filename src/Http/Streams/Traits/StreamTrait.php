<?php

namespace NaN\Http\Streams\Traits;

trait StreamTrait {
	use AssertStreamTrait;

	private $__stream = null;

	public function __destruct() {
		$this->close();
	}

	public function __toString(): string {
		if (!$this->isReadable()) {
			return '';
		}

		if (!$this->isSeekable()) {
			return '';
		}

		try {
			$pos = $this->tell();

			$this->rewind();

			$content = $this->getContents();

			$this->seek($pos);

			return $content;
		} catch (\Throwable $e) {
			return '';
		}
	}

	public function close(): void {
		if (\is_resource($this->__stream)) {
			\fclose($this->__stream);
		}

		$this->detach();
	}

	public function detach() {
		$stream = $this->__stream;
		$this->__stream = null;

		return $stream;
	}

	public function eof(): bool {
		return !\is_resource($this->__stream) || \feof($this->__stream);
	}

	public function getContents(): string {
		$this->__assertResource($this->__stream);

		if (!$this->isReadable()) {
			return '';
		}

		return \stream_get_contents($this->__stream) ?: '';
	}

	public function getMetadata(?string $key = null) {
		$metadata = [];

		if (\is_resource($this->__stream)) {
			$metadata = \stream_get_meta_data($this->__stream);
		}

		return $key ? $metadata[$key] ?? null : $metadata;
	}

	public function getSize(): ?int {
		if (!\is_resource($this->__stream)) {
			return 0;
		}

		$stats = \fstat($this->__stream);

		if ($stats === false) {
			return 0;
		}

		return $stats['size'] ?? 0;
	}

	public function isReadable(): bool {
		return match ($this->getMetadata('mode')) {
			'a+', 'a+b',
			'c+', 'c+b',
			'r', 'rb', 'r+', 'r+b',
			'w+', 'w+b',
			'x+', 'x+b' => true,
			default => false,
		};
	}

	public function isSeekable(): bool {
		return (bool)$this->getMetadata('seekable');
	}

	public function isWritable(): bool {
		return match ($this->getMetadata('mode')) {
			'r', 'rb' => false,
			default => true,
		};
	}

	public function read(int $length): string {
		$this->__assertResource($this->__stream);

		if (!$this->isReadable()) {
			throw new \RuntimeException('Stream is not readable!');
		}

		return \fread($this->__stream, $length);
	}

	public function rewind(): void {
		$this->seek(0);
	}

	public function seek(int $offset, int $whence = \SEEK_SET): void {
		$this->__assertResource($this->__stream);

		if (!$this->isSeekable()) {
			throw new \RuntimeException('Stream is not seekable!');
		}

		\fseek($this->__stream, $offset, $whence);
	}

	public function tell(): int {
		$this->__assertResource($this->__stream);

		return \ftell($this->__stream) ?: 0;
	}

	public function write(string $string): int {
		$this->__assertResource($this->__stream);

		if (!$this->isWritable()) {
			throw new \RuntimeException('Stream is not writable!');
		}

		return \fwrite($this->__stream, $string) ?: 0;
	}
}
