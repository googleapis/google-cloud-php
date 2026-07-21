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

use Google\ApiCore\Call;
use Google\Protobuf\Internal\Message;
use Psr\Http\Message\StreamInterface;

/**
 * User-facing object returned when a resumable upload method is called.
 * Contains the ResumableUploadClient and manages the upload operation.
 *
 * NOTE: The ResumableUpload class is designed for standard, single-threaded PHP execution
 * environments such as PHP-FPM and PHP-CLI. Concurrency controls are out of scope. If pause() or
 * cancel() are called, they will block and execute synchronously. ResumableUpload instances
 * are NOT thread-safe, and should not be shared across concurrent asynchronous contexts (such as
 * parallel Fibers or Swoole coroutines) without external synchronization.
 */
class ResumableUpload
{
    /**
     * @param ResumableUploadClient $resumableUploadClient
     * @param Call $call
     * @param array $callOptions {
     *     Optional.
     *
     *     @type array $headers Optional. Key-value array of custom HTTP headers to
     *           include with upload requests.
     *     @type int $timeoutMillis Optional. The timeout in milliseconds for the
     *           initial start call.
     *     @type RetrySettings|array $retrySettings Optional. Retry settings to use for the
     *           initial start call.
     * }
     * @param ?string $uploadUrl An existing resumable upload session URL to resume an upload
     *        across process restarts or interruptions.
     */
    public function __construct(
        private ResumableUploadClient $resumableUploadClient,
        private Call $call,
        private array $callOptions = [],
        private ?string $uploadUrl = null
    ) {
    }

    /**
     * Returns the resumable upload session URL, if available.
     * This URL can be persisted and used later with `$client->resumeUpload($methodName, $uploadUrl)`
     * to resume the upload across process restarts or background jobs.
     *
     * @return ?string
     */
    public function getUploadUrl(): ?string
    {
        return $this->uploadUrl;
    }

    /**
     * Sets the resumable upload session URL.
     *
     * @param string $uploadUrl
     * @return void
     */
    public function setUploadUrl(string $uploadUrl): void
    {
        $this->uploadUrl = $uploadUrl;
    }

    /**
     * Starts or resumes the resumable upload exchange using the provided data stream.
     * If this instance already has an `uploadUrl` (e.g. created via `$client->resumeUpload($methodName, $uploadUrl)`
     * or after a previous start/interruption), calling `startUpload($dataStream, $resumableUploadOptions)` queries
     * the server for the current byte offset and resumes transmitting remaining chunks.
     *
     * @param StreamInterface $dataStream
     * @param array $resumableUploadOptions {
     *     Optional.
     *
     *     @type int $chunkSize Optional. The size of each chunk to upload in bytes.
     *           Must be a multiple of 262144 (256 KB). Values smaller than the server's chunk
     *           granularity (typically 256 KB) will be rounded up to match the granularity.
     *           Defaults to 8388608 (8 MB).
     *     @type callable $progressCallback Optional. A callback function executed after
     *           every chunk upload or query. The callback should accept two arguments:
     *           (int $bytesUploaded, ResumableUpload $upload).
     *     @type int $totalTimeoutMillis Optional. The total timeout in milliseconds for the
     *           entire resumable upload operation. Defaults to 600000 (10 minutes).
     * }
     * @return Message
     */
    public function startUpload(StreamInterface $dataStream, array $resumableUploadOptions = []): Message
    {
        return $this->resumableUploadClient->startUpload(
            $this,
            $dataStream,
            $this->call,
            $this->callOptions,
            $resumableUploadOptions
        );
    }
}

