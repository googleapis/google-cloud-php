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
use Google\Rpc\Code;
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
    public float $lag = 0.0;
    public ?float $timeoutStarted = null;
    public ?float $currentChunkDeadline = null;
    public ?float $currentChunkStartTime = null;
    public ?float $currentChunkSizeMiB = null;

    /**
     * @param int $chunkSize
     * @param callable|null $progressCallback
     * @param ?string $uploadUrl
     * @param string $phase
     * @param ?int $stallMinimumRate
     * @param ?int $stallTimeout
     */
    public function __construct(
        public int $chunkSize,
        /** @var callable|null $progressCallback */
        public $progressCallback,
        public ?string $uploadUrl,
        public string $phase,
        public ?int $stallMinimumRate = null,
        public ?int $stallTimeout = null
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
                'Error reading from data stream: ' . $e->getMessage(),
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
                    . 'which falls outside the buffered chunks, and the provided data stream is not seekable.'
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

        if ($this->buffer === '' || $this->buffer === null) {
            $this->buffer = null;
            $this->currentChunkDeadline = null;
            $this->currentChunkStartTime = null;
            $this->currentChunkSizeMiB = null;
        }
    }

    /**
     * Whether stall control is active for this upload session.
     */
    public function isStallControlEnabled(): bool
    {
        return $this->stallMinimumRate !== null
            && $this->stallMinimumRate > 0
            && $this->stallTimeout !== null
            && $this->stallTimeout > 0;
    }

    /**
     * Calculates the timeout for the next chunk transfer in seconds.
     *
     * @param float $chunkSizeMiB
     * @return float Timeout in seconds.
     */
    public function calculateNextChunkTimeout(float $chunkSizeMiB): float
    {
        if (!$this->isStallControlEnabled()) {
            return 0.0;
        }
        $expectedTime = $chunkSizeMiB / $this->stallMinimumRate;
        return $expectedTime - $this->lag + $this->stallTimeout;
    }

    /**
     * Records chunk transfer completion and updates aggregate lag and stall timeout clock.
     *
     * @param float $chunkSizeMiB
     * @param float $elapsed Seconds taken to transfer the chunk.
     * @param float $currentTime Current timestamp in seconds.
     * @throws ApiException
     */
    public function recordChunkTransfer(float $chunkSizeMiB, float $elapsed, float $currentTime): void
    {
        if (!$this->isStallControlEnabled()) {
            return;
        }
        $expectedTime = $chunkSizeMiB / $this->stallMinimumRate;
        $currentLag = $elapsed - $expectedTime;
        $this->lag = max(0.0, $this->lag + $currentLag);

        if ($this->lag > 0) {
            if ($this->timeoutStarted === null) {
                $this->timeoutStarted = $currentTime;
            }
            if ($currentTime > $this->timeoutStarted + $this->stallTimeout) {
                throw new ApiException(
                    'Upload stalled.',
                    Code::DEADLINE_EXCEEDED,
                    ApiStatus::DEADLINE_EXCEEDED
                );
            }
        } else {
            // Recovered from stall: lag is 0, exit stall detection
            $this->timeoutStarted = null;
        }
    }
}
