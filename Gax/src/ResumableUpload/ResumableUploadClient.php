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
use Google\ApiCore\Call;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Middleware\RetryMiddleware;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\ValidationException;
use Google\Protobuf\Internal\Message;
use Google\Rpc\Code;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Throwable;

/**
 * Manages the REST transport and authentication credentials for resumable upload RPCs,
 * and executes the HTTP upload stream loop.
 * Instantiated during GAPIC client initialization when the service has resumable upload methods.
 *
 * @internal
 */
class ResumableUploadClient
{
    private const PHASE_STARTING = 'STARTING';
    private const PHASE_TRANSMITTING = 'TRANSMITTING';
    private const PHASE_FINALIZING = 'FINALIZING';
    private const PHASE_RECOVERY = 'RECOVERY';
    private const PHASE_DONE = 'DONE';
    private const DEFAULT_CHUNK_SIZE = 8388608;
    private const DEFAULT_TOTAL_TIMEOUT_MILLIS = 600000;
    private const MAX_RECOVERY_ATTEMPTS = 3;

    private ?ResponseInterface $finalResponse = null;
    /** @var callable|null */
    private $clock = null;

    /**
     * @param ResumableUploadTransportInterface $transport Transport implementing buildRequest and sendRawRequest.
     * @param CredentialsWrapper $credentialsWrapper The credentials wrapper from GAPIC client.
     * @param array $headers Custom headers to include with the initial upload request.
     * @param string $uploadPrefix Resumable upload path prefix (default: '/resumable/upload').
     */
    public function __construct(
        private ResumableUploadTransportInterface $transport,
        private CredentialsWrapper $credentialsWrapper,
        private array $headers = [],
        private string $uploadPrefix = '/resumable/upload'
    ) {
    }

    /**
     * For testing purposes only. Sets a custom clock callable returning float seconds.
     *
     * @param ?callable $clock
     * @internal
     */
    public function setClock(?callable $clock): void
    {
        $this->clock = $clock;
    }

    private function getMicrotime(): float
    {
        return $this->clock ? ($this->clock)() : microtime(true);
    }

    /**
     * Starts the resumable upload exchange using the provided data stream.
     *
     * @param ResumableUpload $upload
     * @param StreamInterface $dataStream
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
     *           entire resumable upload operation. Defaults to 600000 (10 minutes) when stall
     *           control is not enabled; when stall control is enabled, no default is set.
     *     @type string $uploadUrl Optional. An existing resumable upload session URL
     *           to resume an upload across process restarts or interruptions.
     *     @type int $transferStallMinimumRate Optional. The minimum data transfer speed in
     *           MiB/s for stall control. Must be set together with transferStallTimeout.
     *     @type int $transferStallTimeout Optional. The stall timeout interval in seconds
     *           for stall control. Must be set together with transferStallMinimumRate.
     * }
     * @return Message
     * @throws ApiException
     */
    public function startUpload(
        ResumableUpload $upload,
        StreamInterface $dataStream,
        Call $call,
        array $callOptions = [],
        array $resumableUploadOptions = []
    ): Message {
        $this->finalResponse = null;
        $uploadUrl = $upload->getUploadUrl() ?? $resumableUploadOptions['uploadUrl'] ?? null;

        $stallRate = isset($resumableUploadOptions['transferStallMinimumRate'])
            ? (int) $resumableUploadOptions['transferStallMinimumRate']
            : null;
        $stallTimeout = isset($resumableUploadOptions['transferStallTimeout'])
            ? (int) $resumableUploadOptions['transferStallTimeout']
            : null;

        $stallControlEnabled = $stallRate > 0 && $stallTimeout > 0;
        $stallRate = $stallControlEnabled ? $stallRate : null;
        $stallTimeout = $stallControlEnabled ? $stallTimeout : null;

        $totalTimeoutMillis = $resumableUploadOptions['totalTimeoutMillis']
            ?? ($stallControlEnabled ? null : self::DEFAULT_TOTAL_TIMEOUT_MILLIS);
        $globalDeadlineMs = $totalTimeoutMillis !== null
            ? $this->getMicrotime() * 1000 + (float) $totalTimeoutMillis
            : null;

        $state = new ResumableUploadState(
            $resumableUploadOptions['chunkSize'] ?? self::DEFAULT_CHUNK_SIZE,
            $resumableUploadOptions['progressCallback'] ?? null,
            $uploadUrl,
            $uploadUrl !== null ? self::PHASE_RECOVERY : self::PHASE_STARTING,
            $stallRate,
            $stallTimeout
        );

        while ($state->phase !== self::PHASE_DONE) {
            $this->checkDeadline($state, $globalDeadlineMs);
            try {
                $state->phase = match ($state->phase) {
                    self::PHASE_STARTING => $call->getMessage() !== null
                        ? $this->phaseStarting(
                            $state,
                            $upload,
                            $dataStream,
                            $call,
                            $callOptions
                        )
                        : throw new ValidationException(
                            'A Call with request message is required when starting a new resumable upload.'
                        ),
                    self::PHASE_TRANSMITTING,
                    self::PHASE_FINALIZING => $this->phaseUploading(
                        $state,
                        $upload,
                        $dataStream,
                        $globalDeadlineMs
                    ),
                    self::PHASE_RECOVERY => $this->phaseRecovery(
                        $state,
                        $upload,
                        $dataStream,
                        $globalDeadlineMs
                    ),
                    default => throw new ApiException("Unexpected phase: {$state->phase}", 0, ApiStatus::INTERNAL),
                };
            } catch (Throwable $e) {
                $state->phase = $this->handleException(
                    $e,
                    $state,
                    $globalDeadlineMs
                );
            }
        }

        $decodeType = $call->getDecodeType();
        if ($decodeType === null || !class_exists($decodeType)) {
            throw new ValidationException('A valid decodeType is required on the Call object.');
        }

        if ($this->finalResponse === null) {
            throw new ApiException('No final response received from server.', 0, ApiStatus::INTERNAL);
        }

        $body = (string) $this->finalResponse->getBody();
        if ($body === '') {
            throw new ApiException('Final response body was empty.', 0, ApiStatus::INTERNAL);
        }

        /** @var Message $responseMessage */
        $responseMessage = new $decodeType();
        $responseMessage->mergeFromJsonString($body, true);

        return $responseMessage;
    }

    private function phaseStarting(
        ResumableUploadState $state,
        ResumableUpload $upload,
        StreamInterface $dataStream,
        Call $call,
        array $callOptions = []
    ): string {
        $headers = array_merge($this->headers, $callOptions['headers'] ?? []);
        $headers['X-Goog-Upload-Protocol'] = 'resumable';
        $headers['X-Goog-Upload-Command'] = 'start';
        if ($dataStream->getSize() !== null) {
            $headers['X-Goog-Upload-Header-Content-Length'] = (string) $dataStream->getSize();
        }

        $request = $this->transport->buildRequest($call->getMethod(), $call->getMessage(), $headers);

        // Add upload prefix
        $uri = $request->getUri();
        $request = $request->withUri($uri->withPath($this->uploadPrefix . $uri->getPath()));

        // Add retry settings
        $retrySettings = $callOptions['retrySettings'] ?? null;
        if ($retrySettings !== null && !$retrySettings instanceof RetrySettings) {
            $retrySettings = RetrySettings::constructDefault()->with($retrySettings);
        }

        // Make the request
        $response = $this->sendRequest($request, $callOptions['timeoutMillis'] ?? null, $retrySettings);
        if ($response->getStatusCode() !== 200) {
            $this->handleErrorResponse($response);
        }
        $urlHeader = $response->getHeaderLine('X-Goog-Upload-URL');
        if (!empty($urlHeader)) {
            if ($request->getUri()->getScheme() === 'https'
                && str_starts_with($urlHeader, 'http://')
            ) {
                $urlHeader = 'https://' . substr($urlHeader, 7);
            }
            $state->uploadUrl = $urlHeader;
        }
        if ($state->uploadUrl !== null) {
            $upload->setUploadUrl($state->uploadUrl);
        }
        $granularityHeader = $response->getHeaderLine('X-Goog-Upload-Chunk-Granularity');
        $state->chunkGranularity = !empty($granularityHeader) ? (int) $granularityHeader : 1;
        $statusHeader = $response->getHeaderLine('X-Goog-Upload-Status');
        if ($statusHeader === 'final') {
            $this->finalResponse = $response;
            return self::PHASE_DONE;
        }
        return self::PHASE_TRANSMITTING;
    }

    private function phaseUploading(
        ResumableUploadState $state,
        ResumableUpload $upload,
        StreamInterface $dataStream,
        ?float $globalDeadlineMs = null
    ): string {
        $state->prepareBuffer($dataStream);

        $headers = [];
        $headers['X-Goog-Upload-Offset'] = (string) $state->committedOffset;
        $body = (string) $state->buffer;
        $chunkBytes = strlen($body);
        $chunkSizeMiB = $chunkBytes / 1048576.0;

        if ($state->isEof) {
            $phase = self::PHASE_FINALIZING;
            $headers['X-Goog-Upload-Command'] = $chunkBytes > 0 ? 'upload, finalize' : 'finalize';
        } else {
            $phase = self::PHASE_TRANSMITTING;
            $headers['X-Goog-Upload-Command'] = 'upload';
        }

        $now = $this->getMicrotime();
        $timeoutMillis = null;

        if ($state->isStallControlEnabled()) {
            $rate = $state->stallMinimumRate;
            $stallTimeout = $state->stallTimeout;

            // If starting this chunk, calculate chunk deadline
            if ($state->currentChunkDeadline === null) {
                $state->currentChunkStartTime = $now;
                $state->currentChunkSizeMiB = $chunkSizeMiB;

                $nextChunkTimeout = ($chunkSizeMiB / $rate) - $state->lag + $stallTimeout;
                $chunkDeadline = $now + $nextChunkTimeout;

                // Chunk deadlines will be trimmed to the global deadline
                if ($globalDeadlineMs !== null) {
                    $globalDeadlineSec = $globalDeadlineMs / 1000.0;
                    $chunkDeadline = min($chunkDeadline, $globalDeadlineSec);
                }

                $state->currentChunkDeadline = $chunkDeadline;
            }

            // Check if chunk deadline is already exceeded
            $remaining = $state->currentChunkDeadline - $now;
            if ($remaining <= 0) {
                $this->checkDeadline($state, $globalDeadlineMs);
            }

            // Calculate attempt timeout: min(remaining, 2.0 * chunk_size / rate)
            $maxAttemptTimeout = $chunkSizeMiB > 0
                ? (2.0 * $chunkSizeMiB / $rate)
                : $remaining;
            $attemptTimeout = min($remaining, $maxAttemptTimeout);
            $timeoutMillis = max(1, (int) round($attemptTimeout * 1000));
        }

        $response = $this->sendRequest(
            new Request('POST', (string) $state->uploadUrl, $headers, $body),
            $timeoutMillis
        );
        if ($response->getStatusCode() !== 200) {
            $this->handleErrorResponse($response);
        }

        if ($state->isStallControlEnabled()) {
            $completionTime = $this->getMicrotime();
            $elapsed = $completionTime - ($state->currentChunkStartTime ?? $now);
            $state->recordChunkTransfer(
                $state->currentChunkSizeMiB ?? $chunkSizeMiB,
                $elapsed,
                $completionTime
            );
            $state->currentChunkDeadline = null;
            $state->currentChunkStartTime = null;
            $state->currentChunkSizeMiB = null;
        }

        if ($state->progressCallback && $headers['X-Goog-Upload-Command'] !== 'finalize') {
            ($state->progressCallback)(
                $state->committedOffset + $chunkBytes,
                $upload
            );
        }

        if ($response->getHeaderLine('X-Goog-Upload-Status') === 'final') {
            $this->finalResponse = $response;
            return self::PHASE_DONE;
        }

        $state->commitBuffer();
        return self::PHASE_TRANSMITTING;
    }

    private function phaseRecovery(
        ResumableUploadState $state,
        ResumableUpload $upload,
        StreamInterface $dataStream,
        ?float $globalDeadlineMs = null
    ): string {
        if (empty($state->uploadUrl)) {
            throw new ValidationException('Cannot recover resumable upload: uploadUrl is not set.');
        }

        $now = $this->getMicrotime();
        $timeoutMillis = null;

        if ($state->isStallControlEnabled()) {
            if ($state->currentChunkDeadline !== null) {
                $remaining = $state->currentChunkDeadline - $now;
                if ($remaining <= 0) {
                    $this->checkDeadline($state, $globalDeadlineMs);
                }
                $attemptTimeout = min($remaining, max(1.0, $remaining / 2.0));
                $timeoutMillis = max(1, (int) round($attemptTimeout * 1000));
            } elseif ($globalDeadlineMs !== null) {
                $remaining = ($globalDeadlineMs / 1000.0) - $now;
                if ($remaining <= 0) {
                    $this->checkDeadline($state, $globalDeadlineMs);
                }
                $stallTimeout = $state->stallTimeout;
                $attemptTimeout = min($remaining, $stallTimeout);
                $timeoutMillis = max(1, (int) round($attemptTimeout * 1000));
            } else {
                $stallTimeout = $state->stallTimeout;
                $timeoutMillis = max(1, (int) round($stallTimeout * 1000));
            }
        }

        $headers = ['X-Goog-Upload-Command' => 'query'];
        $response = $this->sendRequest(
            new Request('POST', (string) $state->uploadUrl, $headers, ''),
            $timeoutMillis
        );
        $statusCode = $response->getStatusCode();
        if ($statusCode === 200) {
            $serverOffsetStr = $response->getHeaderLine('X-Goog-Upload-Size-Received');
            $serverOffset = !empty($serverOffsetStr) || $serverOffsetStr === '0'
                ? (int) $serverOffsetStr
                : $state->committedOffset;

            $state->reconcileRecoveryOffset($serverOffset, $dataStream, self::MAX_RECOVERY_ATTEMPTS);

            $statusHeader = $response->getHeaderLine('X-Goog-Upload-Status');
            if ($statusHeader === 'final') {
                $this->finalResponse = $response;
                return self::PHASE_DONE;
            }

            if ($state->progressCallback) {
                ($state->progressCallback)($state->committedOffset, $upload);
            }

            return self::PHASE_TRANSMITTING;
        }
        $this->handleErrorResponse($response);
    }

    private function sendRequest(
        RequestInterface $request,
        ?int $timeoutMillis = null,
        ?RetrySettings $retrySettings = null
    ): ResponseInterface {
        $reqHeaders = $request->getHeaders();
        if ($authCallback = $this->credentialsWrapper->getAuthorizationHeaderCallback()) {
            $reqHeaders = array_merge($reqHeaders, $authCallback());
        }
        foreach ($reqHeaders as $k => $v) {
            $request = $request->withHeader($k, $v);
        }

        $callOptions = [];
        if ($timeoutMillis !== null && $timeoutMillis > 0) {
            $callOptions['timeout'] = $timeoutMillis / 1000;
        }

        if ($retrySettings !== null) {
            $callOptions['retrySettings'] = $retrySettings;
            $middleware = new RetryMiddleware(
                fn (Call $unusedCall, array $options) => Create::promiseFor(
                    $this->transport->sendRawRequest($request, $options)
                ),
                $retrySettings
            );
            $response = $middleware(
                new Call(''), // unused
                $callOptions
            );
        } else {
            $response = $this->transport->sendRawRequest($request, $callOptions);
        }

        if (is_object($response) && method_exists($response, 'wait')) {
            $response = $response->wait();
        }
        return $response;
    }

    private function checkDeadline(
        ResumableUploadState $state,
        ?float $globalDeadlineMs,
        ?\Throwable $previous = null
    ): void {
        $now = $this->getMicrotime();

        // 1. Check global deadline if set
        if ($globalDeadlineMs !== null && $now * 1000 >= $globalDeadlineMs) {
            throw new ApiException(
                'Resumable upload total timeout exceeded.',
                Code::DEADLINE_EXCEEDED,
                ApiStatus::DEADLINE_EXCEEDED,
                $previous ? ['previous' => $previous] : []
            );
        }

        // 2. Check stall detection if stall control is active
        if ($state->isStallControlEnabled()) {
            $stallTimeout = $state->stallTimeout;

            // Check if accumulated positive lag exceeded the stall timeout clock
            if ($state->lag > 0 && $state->timeoutStarted !== null) {
                if ($now > $state->timeoutStarted + $stallTimeout) {
                    if ($globalDeadlineMs !== null && $now * 1000 >= $globalDeadlineMs) {
                        throw new ApiException(
                            'Resumable upload total timeout exceeded.',
                            Code::DEADLINE_EXCEEDED,
                            ApiStatus::DEADLINE_EXCEEDED,
                            $previous ? ['previous' => $previous] : []
                        );
                    }
                    throw new ApiException(
                        'Upload stalled.',
                        Code::DEADLINE_EXCEEDED,
                        ApiStatus::DEADLINE_EXCEEDED,
                        $previous ? ['previous' => $previous] : []
                    );
                }
            }

            // Check if the current chunk deadline has been exceeded
            if ($state->currentChunkDeadline !== null && $now >= $state->currentChunkDeadline) {
                if ($globalDeadlineMs !== null && $now * 1000 >= $globalDeadlineMs) {
                    throw new ApiException(
                        'Resumable upload total timeout exceeded.',
                        Code::DEADLINE_EXCEEDED,
                        ApiStatus::DEADLINE_EXCEEDED,
                        $previous ? ['previous' => $previous] : []
                    );
                }
                throw new ApiException(
                    'Upload stalled.',
                    Code::DEADLINE_EXCEEDED,
                    ApiStatus::DEADLINE_EXCEEDED,
                    $previous ? ['previous' => $previous] : []
                );
            }
        }
    }

    private function handleException(
        \Throwable $e,
        ResumableUploadState $state,
        ?float $globalDeadlineMs
    ): string {
        $this->checkDeadline($state, $globalDeadlineMs, $e);

        $code = (int) $e->getCode();
        if ($e instanceof RequestException) {
            $response = method_exists($e, 'getResponse') ? $e->getResponse() : null;
            if ($response) {
                $code = $response->getStatusCode();
            }
        }

        // For transient HTTP errors, return the current phase unchanged so that the match loop
        // re-runs the phase and retries the request until the total deadline is exceeded.
        if (in_array($code, [429, 500, 502, 503, 504])) {
            return $state->phase;
        }

        // For range mismatch or bad request errors, transition to the query/recovery phase to
        // verify the server's received offset and resume transmitting from there, provided
        // an uploadUrl session has already been established.
        if ($state->uploadUrl !== null && in_array($code, [308, 400, 412, 416])) {
            return self::PHASE_RECOVERY;
        }

        // If request timed out or connection was dropped during an active upload session,
        // transition to recovery to query server for committed bytes, provided uploadUrl is set
        if ($state->uploadUrl !== null && $e instanceof RequestException && in_array($code, [0, 408])) {
            return self::PHASE_RECOVERY;
        }

        if ($e instanceof ApiException || $e instanceof ValidationException) {
            throw $e;
        }
        throw new ApiException(
            $e->getMessage(),
            $code,
            ApiStatus::INTERNAL,
            ['previous' => $e]
        );
    }

    private function handleErrorResponse(ResponseInterface $response): never
    {
        $statusCode = $response->getStatusCode();
        $body = (string) $response->getBody();

        if ($response->getHeaderLine('X-Goog-Upload-Status') === 'final') {
            throw new ApiException(
                $body ?: 'Upload rejected by server',
                $statusCode,
                ApiStatus::INVALID_ARGUMENT
            );
        }

        throw new ApiException(
            "HTTP error {$statusCode}: {$body}",
            $statusCode,
            ApiStatus::statusFromRpcCode(ApiStatus::rpcCodeFromHttpStatusCode($statusCode))
        );
    }
}
