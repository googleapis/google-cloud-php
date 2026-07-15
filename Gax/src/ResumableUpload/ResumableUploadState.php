<?php
/*
 * Copyright 2026 Google LLC
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google Inc. nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace Google\ApiCore\ResumableUpload;

use Google\ApiCore\ApiException;
use Google\ApiCore\ApiStatus;
use Google\ApiCore\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * State container for an active resumable upload session.
 *
 * @internal
 */
class ResumableUploadState
{
    public int $committedOffset = 0;
    public int $chunkGranularity = 1;
    public int $recoveryAttempts = 0;
    public int $lastRecoveryOffset = -1;
    public ?string $buffer = null;
    public ?string $previousBuffer = null;
    public int $previousOffset = 0;
    public bool $isEof = false;

    /**
     * @param int $chunkSize
     * @param callable|null $progressCallback
     * @param array $headers
     * @param ?string $uploadUrl
     * @param string $phase
     */
    public function __construct(
        public int $chunkSize,
        /** @var callable|null $progressCallback */
        public $progressCallback,
        public array $headers,
        public ?string $uploadUrl,
        public string $phase
    ) {
    }

    public function prepareBuffer(StreamInterface $dataStream): void
    {
        if ($this->buffer !== null) {
            return;
        }

        $effectiveChunkSize = $this->chunkSize;
        if ($this->chunkGranularity > 0 && ($effectiveChunkSize % $this->chunkGranularity !== 0)) {
            $effectiveChunkSize = (int) (
                floor($effectiveChunkSize / $this->chunkGranularity) * $this->chunkGranularity
            );
            if ($effectiveChunkSize === 0) {
                $effectiveChunkSize = $this->chunkGranularity;
            }
        }

        if ($this->committedOffset > 0 && $dataStream->tell() !== $this->committedOffset) {
            if (!$dataStream->isSeekable()) {
                throw new ValidationException(
                    "Cannot read from stream at offset {$this->committedOffset}: the stream "
                    . "position is {$dataStream->tell()} and the stream is not seekable."
                );
            }
            try {
                $dataStream->seek($this->committedOffset);
            } catch (\Throwable $e) {
                throw new ValidationException(
                    "Failed to seek data stream to offset {$this->committedOffset}: " . $e->getMessage(),
                    0,
                    $e
                );
            }
        }

        try {
            $this->buffer = $dataStream->read($effectiveChunkSize);
        } catch (\Throwable $e) {
            throw new ValidationException(
                "Error reading from data stream: " . $e->getMessage(),
                0,
                $e
            );
        }
        $this->isEof = $dataStream->eof();
    }

    public function commitBuffer(): void
    {
        $this->previousBuffer = $this->buffer;
        $this->previousOffset = $this->committedOffset;
        $this->committedOffset += strlen((string) $this->buffer);
        $this->buffer = null;
    }

    public function reconcileRecoveryOffset(
        int $serverOffset,
        StreamInterface $dataStream,
        int $maxRecoveryAttempts
    ): void {
        if ($serverOffset === $this->lastRecoveryOffset) {
            $this->recoveryAttempts++;
            if ($this->recoveryAttempts >= $maxRecoveryAttempts) {
                throw new ApiException(
                    'Exhausted recovery attempts with unchanged offset',
                    0,
                    ApiStatus::ABORTED
                );
            }
        } else {
            $this->recoveryAttempts = 0;
        }
        $this->lastRecoveryOffset = $serverOffset;

        if ($this->buffer !== null
            && $serverOffset >= $this->committedOffset
            && $serverOffset <= $this->committedOffset + strlen((string) $this->buffer)
        ) {
            $sliceOffset = $serverOffset - $this->committedOffset;
            $this->buffer = substr($this->buffer, $sliceOffset);
            $this->committedOffset = $serverOffset;
        } elseif ($this->previousBuffer !== null
            && $serverOffset >= $this->previousOffset
            && $serverOffset < $this->committedOffset
        ) {
            $combined = $this->previousBuffer . (string) $this->buffer;
            $sliceOffset = $serverOffset - $this->previousOffset;
            $this->buffer = substr($combined, $sliceOffset);
            $this->committedOffset = $serverOffset;
        } else {
            if (!$dataStream->isSeekable()) {
                throw new ValidationException(
                    "Cannot recover resumable upload: the server confirmed offset {$serverOffset}, "
                    . "which falls outside the buffered chunks, and the provided data stream is not seekable."
                );
            }
            try {
                $dataStream->seek($serverOffset);
            } catch (\Throwable $e) {
                throw new ValidationException(
                    "Failed to seek data stream to offset {$serverOffset}: " . $e->getMessage(),
                    0,
                    $e
                );
            }
            $this->committedOffset = $serverOffset;
            $this->buffer = null;
        }
    }
}
