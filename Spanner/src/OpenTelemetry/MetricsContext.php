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

namespace Google\Cloud\Spanner\OpenTelemetry;

use OpenTelemetry\API\Metrics\CounterInterface;
use OpenTelemetry\API\Metrics\HistogramInterface;

/**
 * MetricsContext holds state shared between Spanner client methods,
 * GAX metrics middlewares, and the Result row iterator to accurately
 * track attempt counts, latency, and operation/attempt retry lifecycles.
 *
 * @internal
 */
class MetricsContext
{
    private string $operationId;
    private int $attemptCount = 0;
    private bool $isResume = false;
    private float $operationStartTime;
    private float $lastAttemptStartTime;
    private ?CounterInterface $attemptCountCounter = null;
    private ?HistogramInterface $attemptLatencyHistogram = null;
    private ?CounterInterface $operationCountCounter = null;
    private ?HistogramInterface $operationLatencyHistogram = null;
    private array $baseLabels = [];

    public function __construct()
    {
        $this->operationId = uniqid('spanner-op-', true);
        $this->operationStartTime = microtime(true);
        $this->lastAttemptStartTime = $this->operationStartTime;
    }

    /**
     * Registers OTel attempt instruments.
     */
    public function setAttemptInstruments(?CounterInterface $counter, ?HistogramInterface $histogram): void
    {
        $this->attemptCountCounter = $counter;
        $this->attemptLatencyHistogram = $histogram;
    }

    /**
     * Returns the registered attempt counter.
     */
    public function getAttemptCountCounter(): ?CounterInterface
    {
        return $this->attemptCountCounter;
    }

    /**
     * Returns the registered attempt latency histogram.
     */
    public function getAttemptLatencyHistogram(): ?HistogramInterface
    {
        return $this->attemptLatencyHistogram;
    }

    /**
     * Registers OTel operation instruments.
     */
    public function setOperationInstruments(?CounterInterface $counter, ?HistogramInterface $histogram): void
    {
        $this->operationCountCounter = $counter;
        $this->operationLatencyHistogram = $histogram;
    }

    /**
     * Returns the registered operation counter.
     */
    public function getOperationCountCounter(): ?CounterInterface
    {
        return $this->operationCountCounter;
    }

    /**
     * Returns the registered operation latency histogram.
     */
    public function getOperationLatencyHistogram(): ?HistogramInterface
    {
        return $this->operationLatencyHistogram;
    }

    /**
     * Sets the base metric labels.
     */
    public function setBaseLabels(array $labels): void
    {
        $this->baseLabels = $labels;
    }

    /**
     * Returns the base metric labels.
     */
    public function getBaseLabels(): array
    {
        return $this->baseLabels;
    }

    /**
     * Returns the unique logical operation ID.
     */
    public function getOperationId(): string
    {
        return $this->operationId;
    }

    /**
     * Returns the operation start timestamp.
     */
    public function getOperationStartTime(): float
    {
        return $this->operationStartTime;
    }

    /**
     * Sets the start timestamp of the last initiated attempt.
     */
    public function setLastAttemptStartTime(float $timestamp): void
    {
        $this->lastAttemptStartTime = $timestamp;
    }

    /**
     * Gets the start timestamp of the last initiated attempt.
     */
    public function getLastAttemptStartTime(): float
    {
        return $this->lastAttemptStartTime;
    }

    /**
     * Sets whether the next attempt is a stream resumption.
     */
    public function setIsResume(bool $isResume): void
    {
        $this->isResume = $isResume;
    }

    /**
     * Returns whether the next attempt is a stream resumption.
     */
    public function isResume(): bool
    {
        return $this->isResume;
    }

    /**
     * Increments and returns the attempt count.
     */
    public function incrementAttemptCount(): int
    {
        $this->attemptCount++;
        return $this->attemptCount;
    }

    /**
     * Returns the current attempt count.
     */
    public function getAttemptCount(): int
    {
        return $this->attemptCount;
    }
}
