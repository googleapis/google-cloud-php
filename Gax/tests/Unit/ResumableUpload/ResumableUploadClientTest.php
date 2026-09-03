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

namespace Google\ApiCore\Tests\Unit\ResumableUpload;

use Google\ApiCore\ApiException;
use Google\ApiCore\Call;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\ResumableUpload\ResumableUpload;
use Google\ApiCore\ResumableUpload\ResumableUploadClient;
use Google\ApiCore\ResumableUpload\ResumableUploadTransportInterface;
use Google\ApiCore\RetrySettings;
use Google\Protobuf\Internal\Message;
use Google\Protobuf\Timestamp;
use GuzzleHttp\Psr7\Utils;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;

class ResumableUploadClientTest extends TestCase
{
    use ProphecyTrait;

    private function createStubTransport($requestBuilder, $httpHandler): ResumableUploadTransportInterface
    {
        return new class($requestBuilder, $httpHandler) implements ResumableUploadTransportInterface {
            public function __construct(private $requestBuilder, private $httpHandler)
            {
            }
            public function sendRawRequest(RequestInterface $request, array $options = [])
            {
                return ($this->httpHandler)($request, $options);
            }
            public function buildRequest(
                string $method,
                ?Message $message = null,
                array $headers = []
            ): RequestInterface {
                return $this->requestBuilder->build($method, $message, $headers);
            }
        };
    }

    public function testClientCreationAndInitialization()
    {
        $httpHandler = function () {
        };
        $credentialsWrapper = $this->prophesize(CredentialsWrapper::class)->reveal();
        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class)->reveal();
        $client = new ResumableUploadClient(
            $this->createStubTransport($requestBuilder, $httpHandler),
            $credentialsWrapper
        );

        $ref = new \ReflectionClass($client);
        $transportProp = $ref->getProperty('transport');
        $this->assertInstanceOf(ResumableUploadTransportInterface::class, $transportProp->getValue($client));
        $this->assertSame($credentialsWrapper, $ref->getProperty('credentialsWrapper')->getValue($client));

        $call = new Call('v1/test:create', Timestamp::class, new Timestamp(), [], Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call);
        $this->assertInstanceOf(ResumableUpload::class, $upload);

        $uploadRef = new \ReflectionClass($upload);
        $this->assertSame($client, $uploadRef->getProperty('resumableUploadClient')->getValue($upload));
    }

    public function testStartUploadRendersWildcardsUsingRequestBuilder()
    {
        $requests = [];
        $httpHandler = function ($request, $options = []) use (&$requests) {
            $requests[] = $request;
            if (count($requests) === 1) {
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active',
                    'X-Goog-Upload-URL' => 'https://upload.url/123'
                ]));
            }
            return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                'X-Goog-Upload-Status' => 'final'
            ], '"1970-01-01T00:00:00Z"'));
        };

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class);
        $message = new Timestamp();
        $requestBuilder->build(Argument::any(), Argument::any(), Argument::any())
            ->shouldBeCalledOnce()
            ->willReturn(new \GuzzleHttp\Psr7\Request(
                'POST',
                'https://test.googleapis.com/v24/customers/12345/youTubeVideoUploads:create'
            ));

        $client = new ResumableUploadClient(
            $this->createStubTransport($requestBuilder->reveal(), $httpHandler),
            $this->prophesize(CredentialsWrapper::class)->reveal(),
            [],
            '/resumable/upload'
        );

        $call = new Call(
            'Google.Cloud.Example.V1.ExampleService/CreateYouTubeVideoUpload',
            Timestamp::class,
            $message,
            [],
            Call::RESUMABLE_UPLOAD_CALL
        );
        $upload = new ResumableUpload($client, $call);
        $stream = Utils::streamFor('hello');
        $upload->startUpload($stream);

        $this->assertCount(2, $requests);
        $this->assertSame(
            'https://test.googleapis.com/resumable/upload/v24/customers/12345/youTubeVideoUploads:create',
            (string) $requests[0]->getUri()
        );
    }

    public function testStartUploadWithoutRequestMessageThrowsException()
    {
        $this->expectException(\Google\ApiCore\ValidationException::class);
        $this->expectExceptionMessage('A Call with request message is required when starting a new resumable upload.');

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class)->reveal();
        $httpHandler = function () {
        };
        $client = new ResumableUploadClient(
            $this->createStubTransport($requestBuilder, $httpHandler),
            $this->prophesize(CredentialsWrapper::class)->reveal()
        );
        $call = new Call('v1/test:create', Timestamp::class, null, [], Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call);
        $client->startUpload($upload, Utils::streamFor('hello'), $call);
    }

    public function testStartUploadWithCredentialsWrapperAddsAuthorizationHeaders()
    {
        $requests = [];
        $httpHandler = function ($request, $options = []) use (&$requests) {
            $requests[] = $request;
            if (count($requests) === 1) {
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active',
                    'X-Goog-Upload-URL' => 'https://upload.url/123'
                ]));
            }
            return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                'X-Goog-Upload-Status' => 'final'
            ], '"1970-01-01T00:00:00Z"'));
        };

        $credentialsWrapper = $this->prophesize(CredentialsWrapper::class);
        $credentialsWrapper->getAuthorizationHeaderCallback(Argument::any())
            ->willReturn(function () {
                return ['authorization' => ['Bearer test-token-123']];
            });

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class);
        $message = new Timestamp();
        $requestBuilder->build(Argument::any(), Argument::any(), Argument::any())
            ->shouldBeCalledOnce()
            ->willReturn(new \GuzzleHttp\Psr7\Request(
                'POST',
                'https://test.googleapis.com/v24/customers/12345/youTubeVideoUploads:create'
            ));

        $client = new ResumableUploadClient(
            $this->createStubTransport($requestBuilder->reveal(), $httpHandler),
            $credentialsWrapper->reveal(),
            [],
            '/resumable/upload'
        );

        $call = new Call(
            'Google.Cloud.Example.V1.ExampleService/CreateYouTubeVideoUpload',
            Timestamp::class,
            $message,
            [],
            Call::RESUMABLE_UPLOAD_CALL
        );
        $upload = new ResumableUpload($client, $call);
        $stream = Utils::streamFor('hello');
        $upload->startUpload($stream);

        $this->assertCount(2, $requests);
        $this->assertSame('Bearer test-token-123', $requests[0]->getHeaderLine('authorization'));
        $this->assertSame('Bearer test-token-123', $requests[1]->getHeaderLine('authorization'));
    }

    public function testStartUploadWithTimeoutMillisFirstCallOnly()
    {
        $capturedOptions = [];
        $httpHandler = function ($request, $options = []) use (&$capturedOptions) {
            $capturedOptions[] = $options;
            if (count($capturedOptions) === 1) {
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active',
                    'X-Goog-Upload-URL' => 'https://upload.url/123'
                ]));
            }
            return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                'X-Goog-Upload-Status' => 'final'
            ], '"1970-01-01T00:00:00Z"'));
        };

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class);
        $requestBuilder->build(Argument::any(), Argument::any(), Argument::any())
            ->willReturn(new \GuzzleHttp\Psr7\Request('POST', 'https://test.googleapis.com/test'));
        $client = new ResumableUploadClient(
            $this->createStubTransport($requestBuilder->reveal(), $httpHandler),
            $this->prophesize(CredentialsWrapper::class)->reveal()
        );

        $call = new Call('test.method', Timestamp::class, new Timestamp(), [], Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call, [
            'timeoutMillis' => 5000
        ]);
        $upload->startUpload(Utils::streamFor('hello'));

        $this->assertCount(2, $capturedOptions);
        $this->assertSame(5, $capturedOptions[0]['timeout']);
        $this->assertArrayNotHasKey('timeout', $capturedOptions[1]);
    }

    public function testStartUploadWithRetrySettingsFirstCallOnly()
    {
        $capturedOptions = [];
        $httpHandler = function ($request, $options = []) use (&$capturedOptions) {
            $capturedOptions[] = $options;
            if (count($capturedOptions) === 1) {
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active',
                    'X-Goog-Upload-URL' => 'https://upload.url/123'
                ]));
            }
            return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                'X-Goog-Upload-Status' => 'final'
            ], '"1970-01-01T00:00:00Z"'));
        };

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class);
        $requestBuilder->build(Argument::any(), Argument::any(), Argument::any())
            ->willReturn(new \GuzzleHttp\Psr7\Request('POST', 'https://test.googleapis.com/test'));
        $client = new ResumableUploadClient(
            $this->createStubTransport($requestBuilder->reveal(), $httpHandler),
            $this->prophesize(CredentialsWrapper::class)->reveal()
        );

        $retrySettings = ['maxRetries' => 3];
        $call = new Call('test.method', Timestamp::class, new Timestamp(), [], Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call, [
            'retrySettings' => $retrySettings
        ]);
        $upload->startUpload(Utils::streamFor('hello'));

        $this->assertCount(2, $capturedOptions);
        $this->assertInstanceOf(RetrySettings::class, $capturedOptions[0]['retrySettings'] ?? null);
        $this->assertSame(3, $capturedOptions[0]['retrySettings']->getMaxRetries());
        $this->assertArrayNotHasKey('retrySettings', $capturedOptions[1]);
    }

    public function testStartUploadWithRetrySettingsRetriesInitialRequest()
    {
        $requests = [];
        $httpHandler = function ($request, $options = []) use (&$requests) {
            $requests[] = $request;
            if (count($requests) === 1) {
                // Return a 503 to trigger RetryMiddleware on the initial start call
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(503));
            }
            if (count($requests) === 2) {
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active',
                    'X-Goog-Upload-URL' => 'https://upload.url/123'
                ]));
            }
            return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                'X-Goog-Upload-Status' => 'final'
            ], '"1970-01-01T00:00:00Z"'));
        };

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class);
        $requestBuilder->build(Argument::any(), Argument::any(), Argument::any())
            ->willReturn(new \GuzzleHttp\Psr7\Request('POST', 'https://test.googleapis.com/test'));
        $client = new ResumableUploadClient(
            $this->createStubTransport($requestBuilder->reveal(), $httpHandler),
            $this->prophesize(CredentialsWrapper::class)->reveal()
        );

        $call = new Call('test.method', Timestamp::class, new Timestamp(), [], Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call, [
            'retrySettings' => [
                'maxRetries' => 2,
                'initialRetryDelayMillis' => 1,
                'maxRetryDelayMillis' => 1,
                'retryableCodes' => [\Google\ApiCore\ApiStatus::UNAVAILABLE]
            ]
        ]);
        $upload->startUpload(Utils::streamFor('hello'));

        $this->assertCount(3, $requests);
    }

    public function testStartUploadWithTotalTimeoutMillisExceeded()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Resumable upload total timeout exceeded.');

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class)->reveal();
        $client = new ResumableUploadClient($this->createStubTransport($requestBuilder, function () {
        }), $this->prophesize(CredentialsWrapper::class)->reveal());

        $call = new Call('test.method', Timestamp::class, new Timestamp(), [], Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call);
        $upload->startUpload(Utils::streamFor('hello'), [
            'totalTimeoutMillis' => -10000 // expired timeout in ms
        ]);
    }

    public function testStartUploadWithCustomHeaders()
    {
        $requests = [];
        $httpHandler = function ($request, $options = []) use (&$requests) {
            $requests[] = $request;
            if (count($requests) === 1) {
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active',
                    'X-Goog-Upload-URL' => 'https://upload.url/123'
                ]));
            }
            return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                'X-Goog-Upload-Status' => 'final'
            ], '"1970-01-01T00:00:00Z"'));
        };

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class);
        $requestBuilder->build(Argument::any(), Argument::any(), Argument::any())->will(function ($args) {
            $path = $args[0];
            $headers = $args[2] ?? [];
            return new \GuzzleHttp\Psr7\Request('POST', 'https://test.googleapis.com/' . $path, $headers);
        });
        $client = new ResumableUploadClient(
            $this->createStubTransport($requestBuilder->reveal(), $httpHandler),
            $this->prophesize(CredentialsWrapper::class)->reveal()
        );

        $call = new Call('test.method', Timestamp::class, new Timestamp(), [], Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call, [
            'headers' => ['X-Custom-Header' => 'custom-value']
        ]);
        $upload->startUpload(Utils::streamFor('hello'));

        $this->assertCount(2, $requests);
        $this->assertSame('custom-value', $requests[0]->getHeaderLine('X-Custom-Header'));
        $this->assertSame('', $requests[1]->getHeaderLine('X-Custom-Header'));
    }

    public function testStartUploadSendsConstructorHeadersOnInitialRequestOnly()
    {
        $requests = [];
        $httpHandler = function ($request, $options = []) use (&$requests) {
            $requests[] = $request;
            if (count($requests) === 1) {
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active',
                    'X-Goog-Upload-URL' => 'https://upload.url/123'
                ]));
            }
            return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                'X-Goog-Upload-Status' => 'final'
            ], '"1970-01-01T00:00:00Z"'));
        };

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class);
        $requestBuilder->build(Argument::any(), Argument::any(), Argument::any())->will(function ($args) {
            $path = $args[0];
            $headers = $args[2] ?? [];
            return new \GuzzleHttp\Psr7\Request('POST', 'https://test.googleapis.com/' . $path, $headers);
        });
        $client = new ResumableUploadClient(
            $this->createStubTransport($requestBuilder->reveal(), $httpHandler),
            $this->prophesize(CredentialsWrapper::class)->reveal(),
            headers: ['x-goog-api-client' => 'test-agent/1.0']
        );

        $call = new Call('test.method', Timestamp::class, new Timestamp(), [], Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call);
        $upload->startUpload(Utils::streamFor('hello'));

        $this->assertCount(2, $requests);
        $this->assertSame('test-agent/1.0', $requests[0]->getHeaderLine('x-goog-api-client'));
        $this->assertSame('', $requests[1]->getHeaderLine('x-goog-api-client'));
    }

    public function testStartUploadRecoversFromPreviousBufferWithoutSeeking()
    {
        $requests = [];
        $httpHandler = function ($request, $options = []) use (&$requests) {
            $requests[] = $request;
            if (count($requests) === 1) {
                // Request 0: start
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active',
                    'X-Goog-Upload-URL' => 'https://upload.url/123',
                    'X-Goog-Upload-Chunk-Granularity' => '1'
                ]));
            }
            if (count($requests) === 2) {
                // Request 1: upload first chunk (11 bytes)
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active'
                ]));
            }
            if (count($requests) === 3) {
                // Request 2: upload second chunk fails with 308 Resume Incomplete
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(308));
            }
            if (count($requests) === 4) {
                // Request 3: query recovery offset returns 5 (within previous chunk buffer [0..11])
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active',
                    'X-Goog-Upload-Size-Received' => '5'
                ]));
            }
            // Request 4: re-upload from offset 5 (`t-chunksecond-chunk`)
            return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                'X-Goog-Upload-Status' => 'final'
            ], '"1970-01-01T00:00:00Z"'));
        };

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class);
        $requestBuilder->build(Argument::any(), Argument::any(), Argument::any())
            ->willReturn(new \GuzzleHttp\Psr7\Request('POST', 'https://test.googleapis.com/test'));
        $client = new ResumableUploadClient(
            $this->createStubTransport($requestBuilder->reveal(), $httpHandler),
            $this->prophesize(CredentialsWrapper::class)->reveal()
        );

        $call = new Call('test.method', Timestamp::class, new Timestamp(), [], Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call, [
            'chunkSize' => 11
        ]);

        // Mock an unseekable stream using Prophecy to verify recovery happens in memory without seeking
        $unseekableStream = $this->prophesize(StreamInterface::class);
        $unseekableStream->seek(Argument::any())->shouldNotBeCalled();
        $unseekableStream->isSeekable()->willReturn(false);
        $unseekableStream->getSize()->willReturn(null);
        $unseekableStream->tell()->willReturn(11);
        $unseekableStream->read(Argument::any())->willReturn('first-chunk', 'second-chun');
        $unseekableStream->eof()->willReturn(false);

        $result = $upload->startUpload($unseekableStream->reveal());

        $this->assertInstanceOf(Timestamp::class, $result);
        $this->assertCount(5, $requests);
        $this->assertSame('5', $requests[4]->getHeaderLine('X-Goog-Upload-Offset'));
        $this->assertSame('-chunksecond-chun', (string) $requests[4]->getBody());
    }

    public function testStartUploadRecoveryThrowsExceptionForUnseekableStreamOutsideBuffer()
    {
        $this->expectException(\Google\ApiCore\ValidationException::class);
        $this->expectExceptionMessage(
            'Cannot recover resumable upload: the server confirmed offset 100, which falls outside the buffered ' .
            'chunks, and the provided data stream is not seekable.'
        );

        $requests = [];
        $httpHandler = function ($request, $options = []) use (&$requests) {
            $requests[] = $request;
            if (count($requests) === 1) {
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active',
                    'X-Goog-Upload-URL' => 'https://upload.url/123'
                ]));
            }
            if (count($requests) === 2) {
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(308));
            }
            // Server returns offset 100 which falls outside memory buffer
            return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                'X-Goog-Upload-Status' => 'active',
                'X-Goog-Upload-Size-Received' => '100'
            ]));
        };

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class);
        $requestBuilder->build(Argument::any(), Argument::any(), Argument::any())
            ->willReturn(new \GuzzleHttp\Psr7\Request('POST', 'https://test.googleapis.com/test'));
        $client = new ResumableUploadClient(
            $this->createStubTransport($requestBuilder->reveal(), $httpHandler),
            $this->prophesize(CredentialsWrapper::class)->reveal()
        );

        $call = new Call('test.method', Timestamp::class, new Timestamp(), [], Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call, ['chunkSize' => 10]);

        $unseekableStream = $this->prophesize(StreamInterface::class);
        $unseekableStream->seek(Argument::any())->shouldNotBeCalled();
        $unseekableStream->isSeekable()->willReturn(false);
        $unseekableStream->getSize()->willReturn(null);
        $unseekableStream->tell()->willReturn(10);
        $unseekableStream->read(Argument::any())->willReturn('first-chun', 'second-chu');
        $unseekableStream->eof()->willReturn(false);

        $upload->startUpload($unseekableStream->reveal());
    }

    public function testStartUploadWithoutCredentialsThrowsTypeError()
    {
        $this->expectException(\TypeError::class);

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class)->reveal();
        $httpHandler = function () {
        };

        new ResumableUploadClient($requestBuilder, $httpHandler, null);
    }

    public function testStartUploadInitialFailureThrowsOriginalExceptionWithoutQueryingEmptyUrl()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('HTTP error 400');

        $requests = [];
        $httpHandler = function ($request, $options = []) use (&$requests) {
            $requests[] = $request;
            return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(400, [], 'Bad Request'));
        };

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class);
        $requestBuilder->build(Argument::any(), Argument::any(), Argument::any())->willReturn(
            new \GuzzleHttp\Psr7\Request('POST', 'https://test.googleapis.com/test')
        );
        $client = new ResumableUploadClient(
            $this->createStubTransport($requestBuilder->reveal(), $httpHandler),
            $this->prophesize(CredentialsWrapper::class)->reveal()
        );

        $call = new Call('test.method', Timestamp::class, new Timestamp(), [], Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call);

        try {
            $upload->startUpload(Utils::streamFor('hello'));
        } finally {
            $this->assertCount(1, $requests);
        }
    }

    public function testHeadersSentOnlyOnInitialStartRequest()
    {
        $requests = [];
        $httpHandler = function ($request, $options = []) use (&$requests) {
            $requests[] = $request;
            if (count($requests) === 1) {
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active',
                    'X-Goog-Upload-URL' => 'https://upload.url/123'
                ]));
            }
            return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                'X-Goog-Upload-Status' => 'final'
            ], '"1970-01-01T00:00:00Z"'));
        };

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class);
        $requestBuilder->build(Argument::any(), Argument::any(), Argument::any())->will(function ($args) {
            $headers = $args[2] ?? [];
            return new \GuzzleHttp\Psr7\Request('POST', 'https://test.googleapis.com/' . $args[0], $headers);
        });

        $client = new ResumableUploadClient(
            $this->createStubTransport($requestBuilder->reveal(), $httpHandler),
            $this->prophesize(CredentialsWrapper::class)->reveal()
        );

        $call = new Call('test.method', Timestamp::class, new Timestamp(), [], Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call);

        $client->startUpload($upload, Utils::streamFor('hello'), $call, [
            'headers' => ['X-Initial-Custom-Header' => 'secret-value']
        ]);

        $this->assertCount(2, $requests);
        $this->assertEquals('start', $requests[0]->getHeaderLine('X-Goog-Upload-Command'));
        $this->assertEquals('secret-value', $requests[0]->getHeaderLine('X-Initial-Custom-Header'));
        $this->assertEquals('upload, finalize', $requests[1]->getHeaderLine('X-Goog-Upload-Command'));
        $this->assertEquals('', $requests[1]->getHeaderLine('X-Initial-Custom-Header'));
    }

    public function testStallControlDisabledWhenOnlyOneOptionProvided()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Resumable upload total timeout exceeded.');

        $currentTime = 0.0;
        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class);
        $requestBuilder->build(Argument::any(), Argument::any(), Argument::any())->willReturn(
            new \GuzzleHttp\Psr7\Request('POST', 'https://test.googleapis.com/test')
        );

        $httpHandler = function ($request, $options = []) use (&$currentTime) {
            $currentTime = 700.0; // Advance time past 600s default global deadline
            return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                'X-Goog-Upload-Status' => 'active',
                'X-Goog-Upload-URL' => 'https://upload.url/123'
            ]));
        };

        $client = new ResumableUploadClient(
            $this->createStubTransport($requestBuilder->reveal(), $httpHandler),
            $this->prophesize(CredentialsWrapper::class)->reveal()
        );
        $client->setClock(function () use (&$currentTime) {
            return $currentTime;
        });

        $call = new Call('test.method', Timestamp::class, new Timestamp(), [], Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call);

        // Only transferStallMinimumRate is set -> stall control disabled, default 10m global deadline applies
        $upload->startUpload(Utils::streamFor('hello'), [
            'transferStallMinimumRate' => 10.0,
        ]);
    }

    public function testStallControlDoesNotProvideDefaultGlobalDeadline()
    {
        $capturedOptions = [];
        $httpHandler = function ($request, $options = []) use (&$capturedOptions) {
            $capturedOptions[] = $options;
            if (count($capturedOptions) === 1) {
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active',
                    'X-Goog-Upload-URL' => 'https://upload.url/123'
                ]));
            }
            return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                'X-Goog-Upload-Status' => 'final'
            ], '"1970-01-01T00:00:00Z"'));
        };

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class);
        $requestBuilder->build(Argument::any(), Argument::any(), Argument::any())->willReturn(
            new \GuzzleHttp\Psr7\Request('POST', 'https://test.googleapis.com/test')
        );

        $client = new ResumableUploadClient(
            $this->createStubTransport($requestBuilder->reveal(), $httpHandler),
            $this->prophesize(CredentialsWrapper::class)->reveal()
        );

        // Advance simulated time past default 10-minute (600s) timeout
        $currentTime = 1000.0;
        $client->setClock(function () use (&$currentTime) {
            return $currentTime;
        });

        $call = new Call('test.method', Timestamp::class, new Timestamp(), [], Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call);

        // Stall control enabled: minimum rate 10 MiB/s, stall timeout 60s
        // totalTimeoutMillis is NOT set, so no default global deadline applies
        $result = $upload->startUpload(Utils::streamFor('hello'), [
            'transferStallMinimumRate' => 10.0,
            'transferStallTimeout' => 60.0,
        ]);

        $this->assertInstanceOf(Timestamp::class, $result);
    }

    public function testStallControlAppendix1WalkthroughWithClient()
    {
        // 160 MiB in bytes = 160 * 1048576 = 167772160 bytes
        $chunkBytes = 167772160;
        $currentTime = 0.0;
        $capturedTimeouts = [];

        $requests = [];
        $httpHandler = function ($request, $options = []) use (&$requests, &$currentTime, &$capturedTimeouts) {
            $requests[] = $request;
            if (isset($options['timeout'])) {
                $capturedTimeouts[] = $options['timeout'];
            }

            $count = count($requests);
            if ($count === 1) {
                // Initial start request at t = 0
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active',
                    'X-Goog-Upload-URL' => 'https://upload.url/123'
                ]));
            }
            if ($count === 2) {
                // Chunk 1: transferred in 8s (t becomes 8)
                $currentTime = 8.0;
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active'
                ]));
            }
            if ($count === 3) {
                // Chunk 2: transferred in 26s (t becomes 34)
                $currentTime = 34.0;
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active'
                ]));
            }
            if ($count === 4) {
                // Chunk 3: transferred in 14s (t becomes 48)
                $currentTime = 48.0;
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active'
                ]));
            }
            if ($count === 5) {
                // Chunk 4: transferred in 10s (t becomes 58)
                $currentTime = 58.0;
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active'
                ]));
            }
            if ($count === 6) {
                // Chunk 5: transferred in 8s (t becomes 66)
                $currentTime = 66.0;
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'final'
                ], '"1970-01-01T00:00:00Z"'));
            }
        };

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class);
        $requestBuilder->build(Argument::any(), Argument::any(), Argument::any())->willReturn(
            new \GuzzleHttp\Psr7\Request('POST', 'https://test.googleapis.com/test')
        );

        $client = new ResumableUploadClient(
            $this->createStubTransport($requestBuilder->reveal(), $httpHandler),
            $this->prophesize(CredentialsWrapper::class)->reveal()
        );
        $client->setClock(function () use (&$currentTime) {
            return $currentTime;
        });

        $call = new Call('test.method', Timestamp::class, new Timestamp(), [], Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call);

        $result = $upload->startUpload($this->createSizedStream($chunkBytes * 5), [
            'chunkSize' => $chunkBytes,
            'transferStallMinimumRate' => 10.0,
            'transferStallTimeout' => 60.0,
        ]);

        $this->assertInstanceOf(Timestamp::class, $result);
        $this->assertCount(6, $requests);

        // Next chunk timeouts from Appendix 1: [76, 76, 66, 68, 74]
        $this->assertEquals([76, 76, 66, 68, 74], $capturedTimeouts);
    }

    public function testStallControlUploadStalledRaisesApiException()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Upload stalled.');

        $chunkBytes = 167772160; // 160 MiB
        $currentTime = 0.0;

        $requests = [];
        $httpHandler = function ($request, $options = []) use (&$requests, &$currentTime) {
            $requests[] = $request;
            $count = count($requests);
            if ($count === 1) {
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active',
                    'X-Goog-Upload-URL' => 'https://upload.url/123'
                ]));
            }
            if ($count === 2) {
                // Chunk 1: transferred in 26s -> enters stall detection at t = 26
                $currentTime = 26.0;
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active'
                ]));
            }
            if ($count === 3) {
                // Chunk 2: transfer takes 65s (from t = 26 to t = 91; 65 > stallTimeout 60)
                $currentTime = 91.0;
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'final'
                ], '"1970-01-01T00:00:00Z"'));
            }
        };

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class);
        $requestBuilder->build(Argument::any(), Argument::any(), Argument::any())->willReturn(
            new \GuzzleHttp\Psr7\Request('POST', 'https://test.googleapis.com/test')
        );

        $client = new ResumableUploadClient(
            $this->createStubTransport($requestBuilder->reveal(), $httpHandler),
            $this->prophesize(CredentialsWrapper::class)->reveal()
        );
        $client->setClock(function () use (&$currentTime) {
            return $currentTime;
        });

        $call = new Call('test.method', Timestamp::class, new Timestamp(), [], Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call);

        $upload->startUpload($this->createSizedStream($chunkBytes * 2), [
            'chunkSize' => $chunkBytes,
            'transferStallMinimumRate' => 10.0,
            'transferStallTimeout' => 60.0,
        ]);
    }

    public function testStallControlChunkDeadlineExceededConvertsToUploadStalledWhenGlobalDeadlineNotSet()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Upload stalled.');

        $chunkBytes = 167772160; // 160 MiB
        $currentTime = 0.0;

        $requests = [];
        $httpHandler = function ($request, $options = []) use (&$requests, &$currentTime) {
            $requests[] = $request;
            $count = count($requests);
            if ($count === 1) {
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active',
                    'X-Goog-Upload-URL' => 'https://upload.url/123'
                ]));
            }
            // Chunk transfer hangs past chunk deadline (chunk deadline is 76s, time reaches 80s)
            $currentTime = 80.0;
            return \GuzzleHttp\Promise\Create::rejectionFor(
                new \GuzzleHttp\Exception\RequestException('cURL error 28: Operation timed out', $request)
            );
        };

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class);
        $requestBuilder->build(Argument::any(), Argument::any(), Argument::any())->willReturn(
            new \GuzzleHttp\Psr7\Request('POST', 'https://test.googleapis.com/test')
        );

        $client = new ResumableUploadClient(
            $this->createStubTransport($requestBuilder->reveal(), $httpHandler),
            $this->prophesize(CredentialsWrapper::class)->reveal()
        );
        $client->setClock(function () use (&$currentTime) {
            return $currentTime;
        });

        $call = new Call('test.method', Timestamp::class, new Timestamp(), [], Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call);

        $upload->startUpload($this->createSizedStream($chunkBytes), [
            'chunkSize' => $chunkBytes,
            'transferStallMinimumRate' => 10.0,
            'transferStallTimeout' => 60.0,
        ]);
    }

    public function testStallControlChunkDeadlineExceededConvertsToUploadStalledWhenGlobalDeadlineNotExceeded()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Upload stalled.');

        $chunkBytes = 167772160; // 160 MiB
        $currentTime = 0.0;

        $requests = [];
        $httpHandler = function ($request, $options = []) use (&$requests, &$currentTime) {
            $requests[] = $request;
            $count = count($requests);
            if ($count === 1) {
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active',
                    'X-Goog-Upload-URL' => 'https://upload.url/123'
                ]));
            }
            // Chunk deadline is 76s. Time reaches 80s.
            // Global deadline is 1000s (not exceeded).
            $currentTime = 80.0;
            return \GuzzleHttp\Promise\Create::rejectionFor(
                new \GuzzleHttp\Exception\RequestException('cURL error 28: Operation timed out', $request)
            );
        };

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class);
        $requestBuilder->build(Argument::any(), Argument::any(), Argument::any())->willReturn(
            new \GuzzleHttp\Psr7\Request('POST', 'https://test.googleapis.com/test')
        );

        $client = new ResumableUploadClient(
            $this->createStubTransport($requestBuilder->reveal(), $httpHandler),
            $this->prophesize(CredentialsWrapper::class)->reveal()
        );
        $client->setClock(function () use (&$currentTime) {
            return $currentTime;
        });

        $call = new Call('test.method', Timestamp::class, new Timestamp(), [], Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call);

        $upload->startUpload($this->createSizedStream($chunkBytes), [
            'chunkSize' => $chunkBytes,
            'transferStallMinimumRate' => 10.0,
            'transferStallTimeout' => 60.0,
            'totalTimeoutMillis' => 1000000, // 1000 seconds
        ]);
    }

    public function testStallControlChunkDeadlineExceededThrowsDeadlineExceededWhenGlobalDeadlineExceeded()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Resumable upload total timeout exceeded.');

        $chunkBytes = 167772160; // 160 MiB
        $currentTime = 0.0;

        $requests = [];
        $httpHandler = function ($request, $options = []) use (&$requests, &$currentTime) {
            $requests[] = $request;
            $count = count($requests);
            if ($count === 1) {
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active',
                    'X-Goog-Upload-URL' => 'https://upload.url/123'
                ]));
            }
            // Global deadline is 50s. Chunk timeout is 76s, trimmed to 50s.
            // Time reaches 55s -> global deadline exceeded.
            $currentTime = 55.0;
            return \GuzzleHttp\Promise\Create::rejectionFor(
                new \GuzzleHttp\Exception\RequestException('cURL error 28: Operation timed out', $request)
            );
        };

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class);
        $requestBuilder->build(Argument::any(), Argument::any(), Argument::any())->willReturn(
            new \GuzzleHttp\Psr7\Request('POST', 'https://test.googleapis.com/test')
        );

        $client = new ResumableUploadClient(
            $this->createStubTransport($requestBuilder->reveal(), $httpHandler),
            $this->prophesize(CredentialsWrapper::class)->reveal()
        );
        $client->setClock(function () use (&$currentTime) {
            return $currentTime;
        });

        $call = new Call('test.method', Timestamp::class, new Timestamp(), [], Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call);

        try {
            $upload->startUpload($this->createSizedStream($chunkBytes), [
                'chunkSize' => $chunkBytes,
                'transferStallMinimumRate' => 10.0,
                'transferStallTimeout' => 60.0,
                'totalTimeoutMillis' => 50000, // 50 seconds
            ]);
        } catch (ApiException $e) {
            $this->assertSame(\Google\Rpc\Code::DEADLINE_EXCEEDED, $e->getCode());
            $this->assertSame('Resumable upload total timeout exceeded.', $e->getMessage());
            throw $e;
        }
    }

    public function testStallControlRecoveryAndRetryTimeouts()
    {
        $chunkBytes = 167772160; // 160 MiB
        $currentTime = 0.0;
        $capturedRecoveryTimeout = null;
        $capturedRetryTimeout = null;

        $requests = [];
        $httpHandler = function ($request, $options = []) use (
            &$requests,
            &$currentTime,
            &$capturedRecoveryTimeout,
            &$capturedRetryTimeout
        ) {
            $requests[] = $request;
            $count = count($requests);
            if ($count === 1) {
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active',
                    'X-Goog-Upload-URL' => 'https://upload.url/123',
                    'X-Goog-Upload-Chunk-Granularity' => '1'
                ]));
            }
            if ($count === 2) {
                // Chunk 1 attempt 1 takes 10s then returns 308 (recovery needed)
                $currentTime = 10.0;
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(308));
            }
            if ($count === 3) {
                // Query recovery request uses stallTimeout (60s)
                $capturedRecoveryTimeout = $options['timeout'] ?? null;
                $currentTime = 11.0;
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active',
                    'X-Goog-Upload-Size-Received' => '0'
                ]));
            }
            if ($count === 4) {
                // Retried chunk upload request uses calculated next chunk timeout (76s)
                $capturedRetryTimeout = $options['timeout'] ?? null;
                $currentTime = 20.0;
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'final'
                ], '"1970-01-01T00:00:00Z"'));
            }
        };

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class);
        $requestBuilder->build(Argument::any(), Argument::any(), Argument::any())->willReturn(
            new \GuzzleHttp\Psr7\Request('POST', 'https://test.googleapis.com/test')
        );

        $client = new ResumableUploadClient(
            $this->createStubTransport($requestBuilder->reveal(), $httpHandler),
            $this->prophesize(CredentialsWrapper::class)->reveal()
        );
        $client->setClock(function () use (&$currentTime) {
            return $currentTime;
        });

        $call = new Call('test.method', Timestamp::class, new Timestamp(), [], Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call);

        $result = $upload->startUpload($this->createSizedStream($chunkBytes), [
            'chunkSize' => $chunkBytes,
            'transferStallMinimumRate' => 10.0,
            'transferStallTimeout' => 60.0,
        ]);

        $this->assertInstanceOf(Timestamp::class, $result);
        $this->assertEquals(60, $capturedRecoveryTimeout);
        $this->assertEquals(76, $capturedRetryTimeout);
    }

    public function testStallControlDoesNotApplyAttemptTimeoutSlicing()
    {
        $chunkBytes = 167772160; // 160 MiB
        $capturedTimeout = null;

        $httpHandler = function ($request, $options = []) use (&$capturedTimeout) {
            static $count = 0;
            $count++;
            if ($count === 1) {
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active',
                    'X-Goog-Upload-URL' => 'https://upload.url/123'
                ]));
            }
            $capturedTimeout = $options['timeout'] ?? null;
            return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                'X-Goog-Upload-Status' => 'final'
            ], '"1970-01-01T00:00:00Z"'));
        };

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class);
        $requestBuilder->build(Argument::any(), Argument::any(), Argument::any())->willReturn(
            new \GuzzleHttp\Psr7\Request('POST', 'https://test.googleapis.com/test')
        );

        $client = new ResumableUploadClient(
            $this->createStubTransport($requestBuilder->reveal(), $httpHandler),
            $this->prophesize(CredentialsWrapper::class)->reveal()
        );

        $call = new Call('test.method', Timestamp::class, new Timestamp(), [], Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call);

        $upload->startUpload($this->createSizedStream($chunkBytes), [
            'chunkSize' => $chunkBytes,
            'transferStallMinimumRate' => 10.0,
            'transferStallTimeout' => 60.0,
        ]);

        // Expected full chunk timeout: 160 / 10 + 60 = 76s.
        // If attempt slicing (2.0 * 160 / 10 = 32s) was applied, it would have been 32.
        $this->assertEquals(76, $capturedTimeout);
    }

    public function testStallControlChunkTimeoutTrimsToGlobalDeadline()
    {
        $chunkBytes = 167772160; // 160 MiB
        $capturedTimeout = null;

        $httpHandler = function ($request, $options = []) use (&$capturedTimeout) {
            static $count = 0;
            $count++;
            if ($count === 1) {
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active',
                    'X-Goog-Upload-URL' => 'https://upload.url/123'
                ]));
            }
            $capturedTimeout = $options['timeout'] ?? null;
            return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                'X-Goog-Upload-Status' => 'final'
            ], '"1970-01-01T00:00:00Z"'));
        };

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class);
        $requestBuilder->build(Argument::any(), Argument::any(), Argument::any())->willReturn(
            new \GuzzleHttp\Psr7\Request('POST', 'https://test.googleapis.com/test')
        );

        $currentTime = 10.0;
        $client = new ResumableUploadClient(
            $this->createStubTransport($requestBuilder->reveal(), $httpHandler),
            $this->prophesize(CredentialsWrapper::class)->reveal()
        );
        $client->setClock(function () use (&$currentTime) {
            return $currentTime;
        });

        $call = new Call('test.method', Timestamp::class, new Timestamp(), [], Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call);

        // Global deadline started at t = 10s with totalTimeoutMillis = 40000ms => deadline at t = 50s.
        // Chunk timeout would be 76s, but remaining global deadline is 50 - 10 = 40s.
        $upload->startUpload($this->createSizedStream($chunkBytes), [
            'chunkSize' => $chunkBytes,
            'transferStallMinimumRate' => 10.0,
            'transferStallTimeout' => 60.0,
            'totalTimeoutMillis' => 40000,
        ]);

        $this->assertEquals(40, $capturedTimeout);
    }

    public function testStallControlRecoveryTrimsToGlobalDeadline()
    {
        $chunkBytes = 167772160; // 160 MiB
        $currentTime = 0.0;
        $capturedRecoveryTimeout = null;

        $requests = [];
        $httpHandler = function ($request, $options = []) use (&$requests, &$currentTime, &$capturedRecoveryTimeout) {
            $requests[] = $request;
            $count = count($requests);
            if ($count === 1) {
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active',
                    'X-Goog-Upload-URL' => 'https://upload.url/123',
                    'X-Goog-Upload-Chunk-Granularity' => '1'
                ]));
            }
            if ($count === 2) {
                // Chunk 1 fails at t = 10s
                $currentTime = 10.0;
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(308));
            }
            if ($count === 3) {
                // Recovery request at t = 10s.
                // Global deadline started at t = 0 with 25s totalTimeout => expires at t = 25s.
                // Remaining global deadline is 25 - 10 = 15s (< 60s stallTimeout).
                $capturedRecoveryTimeout = $options['timeout'] ?? null;
                $currentTime = 11.0;
                return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                    'X-Goog-Upload-Status' => 'active',
                    'X-Goog-Upload-Size-Received' => '0'
                ]));
            }
            return \GuzzleHttp\Promise\Create::promiseFor(new \GuzzleHttp\Psr7\Response(200, [
                'X-Goog-Upload-Status' => 'final'
            ], '"1970-01-01T00:00:00Z"'));
        };

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class);
        $requestBuilder->build(Argument::any(), Argument::any(), Argument::any())->willReturn(
            new \GuzzleHttp\Psr7\Request('POST', 'https://test.googleapis.com/test')
        );

        $client = new ResumableUploadClient(
            $this->createStubTransport($requestBuilder->reveal(), $httpHandler),
            $this->prophesize(CredentialsWrapper::class)->reveal()
        );
        $client->setClock(function () use (&$currentTime) {
            return $currentTime;
        });

        $call = new Call('test.method', Timestamp::class, new Timestamp(), [], Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call);

        $upload->startUpload($this->createSizedStream($chunkBytes), [
            'chunkSize' => $chunkBytes,
            'transferStallMinimumRate' => 10.0,
            'transferStallTimeout' => 60.0,
            'totalTimeoutMillis' => 25000, // 25s global deadline
        ]);

        // Trims 60s stallTimeout to 15s remaining global deadline
        $this->assertEquals(15, $capturedRecoveryTimeout);
    }

    private function createSizedStream(int $totalBytes): StreamInterface
    {
        return new class($totalBytes) implements StreamInterface {
            private int $pos = 0;
            public function __construct(private int $totalSize)
            {
            }
            public function __toString(): string
            {
                return '';
            }
            public function close(): void
            {
            }
            public function detach()
            {
                return null;
            }
            public function getSize(): ?int
            {
                return $this->totalSize;
            }
            public function tell(): int
            {
                return $this->pos;
            }
            public function eof(): bool
            {
                return $this->pos >= $this->totalSize;
            }
            public function isSeekable(): bool
            {
                return true;
            }
            public function seek(int $offset, int $whence = SEEK_SET): void
            {
                $this->pos = $offset;
            }
            public function rewind(): void
            {
                $this->pos = 0;
            }
            public function isWritable(): bool
            {
                return false;
            }
            public function write(string $string): int
            {
                return 0;
            }
            public function isReadable(): bool
            {
                return true;
            }
            public function read(int $length): string
            {
                $len = min($length, $this->totalSize - $this->pos);
                $this->pos += $len;
                return str_repeat('a', $len);
            }
            public function getContents(): string
            {
                return '';
            }
            public function getMetadata(?string $key = null)
            {
                return null;
            }
        };
    }
}
