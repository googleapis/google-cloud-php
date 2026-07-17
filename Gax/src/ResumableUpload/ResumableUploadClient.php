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

use Exception;
use Google\ApiCore\ApiException;
use Google\ApiCore\ApiStatus;
use Google\ApiCore\Call;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Middleware\RetryMiddleware;
use Google\ApiCore\RequestBuilder;
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

    /**
     * @param ResumableUploadTransportInterface $transport Transport implementing buildRequest and sendRawRequest.
     * @param CredentialsWrapper $credentialsWrapper The credentials wrapper from GAPIC client.
     * @param array $headers Custom headers to include with the initial upload request.
     * @param string $serviceAddress Service address or API endpoint.
     * @param string $uploadPrefix Resumable upload path prefix (default: '/resumable/upload').
     */
    private ?ResponseInterface $finalResponse = null;

    public function __construct(
        private ResumableUploadTransportInterface $transport,
        private CredentialsWrapper $credentialsWrapper,
        private array $headers = [],
        private string $serviceAddress = '',
        private string $uploadPrefix = '/resumable/upload'
    ) {
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
     *           entire resumable upload operation. Defaults to 600000 (10 minutes).
     *     @type string $uploadUrl Optional. An existing resumable upload session URL
     *           to resume an upload across process restarts or interruptions.
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
        $totalTimeoutMillis = (float) ($resumableUploadOptions['totalTimeoutMillis']
            ?? self::DEFAULT_TOTAL_TIMEOUT_MILLIS);
        $deadlineMs = microtime(true) * 1000 + $totalTimeoutMillis;

        $state = new ResumableUploadState(
            $resumableUploadOptions['chunkSize'] ?? self::DEFAULT_CHUNK_SIZE,
            $resumableUploadOptions['progressCallback'] ?? null,
            $uploadUrl,
            $uploadUrl !== null ? self::PHASE_RECOVERY : self::PHASE_STARTING
        );

        while ($state->phase !== self::PHASE_DONE) {
            $this->checkDeadline($deadlineMs);
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
                        : throw new ValidationException("A Call with request message is required when starting a new resumable upload."),
                    self::PHASE_TRANSMITTING,
                    self::PHASE_FINALIZING => $this->phaseUploading($state, $upload, $dataStream),
                    self::PHASE_RECOVERY => $this->phaseRecovery($state, $upload, $dataStream),
                    default => throw new ApiException("Unexpected phase: {$state->phase}", 0, ApiStatus::INTERNAL),
                };
            } catch (ApiException | RequestException $e) {
                $state->phase = $this->handleException(
                    $e,
                    $state,
                    $deadlineMs
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
        StreamInterface $dataStream
    ): string {
        $state->prepareBuffer($dataStream);

        $headers = [];
        $headers['X-Goog-Upload-Offset'] = (string) $state->committedOffset;
        $body = (string) $state->buffer;

        if ($state->isEof) {
            $phase = self::PHASE_FINALIZING;
            $headers['X-Goog-Upload-Command'] = strlen($body) > 0 ? 'upload, finalize' : 'finalize';
        } else {
            $phase = self::PHASE_TRANSMITTING;
            $headers['X-Goog-Upload-Command'] = 'upload';
        }

        $response = $this->sendRequest(
            new Request('POST', (string) $state->uploadUrl, $headers, $body)
        );
        if ($response->getStatusCode() !== 200) {
            $this->handleErrorResponse($response);
        }

        if ($state->progressCallback && $headers['X-Goog-Upload-Command'] !== 'finalize') {
            ($state->progressCallback)(
                $state->committedOffset + strlen($body),
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

    private function phaseRecovery(ResumableUploadState $state, ResumableUpload $upload, StreamInterface $dataStream): string
    {
        if (empty($state->uploadUrl)) {
            throw new ValidationException('Cannot recover resumable upload: uploadUrl is not set.');
        }
        $headers = ['X-Goog-Upload-Command' => 'query'];
        $response = $this->sendRequest(
            new Request('POST', (string) $state->uploadUrl, $headers, '')
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
        return self::PHASE_RECOVERY;
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
                fn(Call $unusedCall, array $options) => Create::promiseFor($this->transport->sendRawRequest($request, $options)),
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

    private function checkDeadline(float $deadlineMs, ?\Throwable $previous = null): void
    {
        if (microtime(true) * 1000 >= $deadlineMs) {
            throw new ApiException(
                'Resumable upload total timeout exceeded.',
                Code::DEADLINE_EXCEEDED,
                ApiStatus::DEADLINE_EXCEEDED,
                $previous ? ['previous' => $previous] : []
            );
        }
    }

    private function handleException(
        ApiException|RequestException $e,
        ResumableUploadState $state,
        float $deadlineMs
    ): string {
        $this->checkDeadline($deadlineMs, $e);

        $code = $e->getCode();
        if ($e instanceof RequestException) {
            $response = $e->getResponse();
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

        if ($e instanceof ApiException) {
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

        throw new RequestException(
            "HTTP error {$statusCode}",
            new Request('POST', ''),
            $response
        );
    }
}
