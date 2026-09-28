<?php
/**
 * Copyright 2026 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Storage;

use GuzzleHttp\Psr7\StreamDecoratorTrait;
use Psr\Http\Message\StreamInterface;
use RuntimeException;
use UnexpectedValueException;

/**
 * A Guzzle stream decorator that computes CRC32C and MD5 hashes on the fly
 * and validates them when the end of the stream is reached.
 */
class HashValidatingStream implements StreamInterface
{
    use StreamDecoratorTrait;

    private $stream;
    private $expectedCrc32c;
    private $expectedMd5;
    private $crc32cContext;
    private $md5Context;
    private $crc32cEnabled = false;
    private $md5Enabled = false;

    /**
     * @param StreamInterface $stream The underlying stream to wrap.
     * @param array $options {
     *     Configuration options.
     *
     *     @type string $expectedCrc32c Base64-encoded expected CRC32C checksum.
     *     @type string $expectedMd5 Base64-encoded expected MD5 checksum.
     * }
     * @throws RuntimeException If a requested hashing algorithm is not supported on the platform.
     */
    public function __construct(StreamInterface $stream, array $options = [])
    {
        $this->stream = $stream;
        $this->expectedCrc32c = $options['expectedCrc32c'] ?? null;
        $this->expectedMd5 = $options['expectedMd5'] ?? null;

        if ($this->expectedCrc32c !== null) {
            if (!in_array('crc32c', hash_algos())) {
                throw new RuntimeException('CRC32C hashing algorithm is not supported on this platform.');
            }
            $this->crc32cContext = hash_init('crc32c');
            $this->crc32cEnabled = true;
        }

        if ($this->expectedMd5 !== null) {
            $this->md5Context = hash_init('md5');
            $this->md5Enabled = true;
        }
    }

    /**
     * Validating streams are not seekable since hash calculations are done on-the-fly.
     *
     * @return bool
     */
    public function isSeekable(): bool
    {
        return false;
    }

    /**
     * Seek operations are not supported on validating streams.
     *
     * @param int $offset
     * @param int $whence
     * @throws RuntimeException
     */
    public function seek($offset, $whence = SEEK_SET): void
    {
        throw new RuntimeException('Seeking is not supported on a validating stream.');
    }

    /**
     * Read from the stream and update hash calculations.
     *
     * @param int $length
     * @return string
     */
    public function read($length): string
    {
        $data = $this->stream->read($length);
        $this->updateHashes($data);

        if ($this->stream->eof()) {
            $this->validate();
        }

        return $data;
    }

    /**
     * Get the entire remaining contents of the stream and validate.
     *
     * @return string
     */
    public function getContents(): string
    {
        $data = $this->stream->getContents();
        $this->updateHashes($data);
        $this->validate();
        return $data;
    }

    /**
     * Update hash contexts with the new chunk of data.
     */
    private function updateHashes(string $data)
    {
        if ($data === '') {
            return;
        }

        if ($this->crc32cEnabled) {
            hash_update($this->crc32cContext, $data);
        }

        if ($this->md5Enabled) {
            hash_update($this->md5Context, $data);
        }
    }

    /**
     * Validate the accumulated checksums against expected values.
     *
     * @throws UnexpectedValueException If checksum validation fails.
     */
    private function validate()
    {
        if ($this->crc32cEnabled) {
            $crc32cHash = hash_final($this->crc32cContext, true);
            $calculatedCrc32c = base64_encode($crc32cHash);
            $this->crc32cEnabled = false; // Prevent double validation
            if ($calculatedCrc32c !== $this->expectedCrc32c) {
                throw new UnexpectedValueException(sprintf(
                    'CRC32C checksum mismatch. Expected: %s, Calculated: %s',
                    $this->expectedCrc32c,
                    $calculatedCrc32c
                ));
            }
        }

        if ($this->md5Enabled) {
            $md5Hash = hash_final($this->md5Context, true);
            $calculatedMd5 = base64_encode($md5Hash);
            $this->md5Enabled = false; // Prevent double validation

            if ($calculatedMd5 !== $this->expectedMd5) {
                throw new UnexpectedValueException(sprintf(
                    'MD5 checksum mismatch. Expected: %s, Calculated: %s',
                    $this->expectedMd5,
                    $calculatedMd5
                ));
            }
        }
    }
}
