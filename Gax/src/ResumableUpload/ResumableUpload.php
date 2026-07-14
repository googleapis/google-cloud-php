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
 */
class ResumableUpload
{
    /**
     * @param ResumableUploadClient $resumableUploadClient
     * @param Call $call
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
     *     @type array $headers Optional. Key-value array of custom HTTP headers to
     *           include with upload requests.
     *     @type int $timeoutMillis Optional. The timeout in milliseconds for the
     *           initial start call.
     *     @type int $totalTimeoutMillis Optional. The total timeout in milliseconds for the
     *           entire resumable upload operation. Defaults to 600000 (10 minutes).
     *     @type RetrySettings|array $retrySettings Optional. Retry settings to use for the
     *           initial start call.
     * }
     * @param ?string $uploadUrl An existing resumable upload session URL to resume an upload
     *        across process restarts or interruptions.
     */
    public function __construct(
        private ResumableUploadClient $resumableUploadClient,
        private Call $call,
        private array $resumableUploadOptions = [],
        private ?string $uploadUrl = null
    ) {
    }

    /**
     * Returns the resumable upload session URL, if available.
     * This URL can be persisted and used later with `$client->resumeUpload($uploadUrl)`
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
     * If this instance already has an `uploadUrl` (e.g. created via `$client->resumeUpload($uploadUrl)`
     * or after a previous start/interruption), calling `startUpload($dataStream)` queries the server
     * for the current byte offset and resumes transmitting remaining chunks.
     *
     * @param StreamInterface $dataStream
     * @return Message
     */
    public function startUpload(StreamInterface $dataStream): Message
    {
        return $this->resumableUploadClient->startUpload(
            $this,
            $dataStream,
            $this->call,
            $this->resumableUploadOptions
        );
    }
}
