<?php

namespace NaN\Http\Streams\Traits;

trait StreamTrait {
	use AssertStreamTrait;

	private $__stream = null;

	public function __toString(): string {
		try {
			$this->rewind();
			return $this->getContents();
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

	public function detach(): void {
		$this->__stream = null;
	}

	public function eof(): bool {
		return !\is_resource($this->__stream) || \feof($this->__stream);
	}

	public function getContents(): string {
		$this->__assertResource($this->__stream);

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
			'c+', 'r', 'r+', 'w+' => true,
			default => false,
		};
	}

	public function isSeekable(): bool {
		return (bool)$this->getMetadata('seekable');
	}

	public function isWritable(): bool {
		return match ($this->getMetadata('mode')) {
			'r' => false,
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
