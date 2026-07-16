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

use Google\ApiCore\Call;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\ResumableUpload\ResumableUpload;
use Google\ApiCore\ResumableUpload\ResumableUploadClient;
use Google\ApiCore\ResumableUpload\ResumableUploadTransportInterface;
use Google\Protobuf\Internal\Message;
use Google\Protobuf\Timestamp;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\RequestInterface;

class ResumableUploadTest extends TestCase
{
    use ProphecyTrait;

    private function createStubTransport($requestBuilder, $httpHandler): ResumableUploadTransportInterface
    {
        return new class($requestBuilder, $httpHandler) implements ResumableUploadTransportInterface {
            public function __construct(private $requestBuilder, private $httpHandler) {}
            public function sendRawRequest(RequestInterface $request, array $options = []) {
                return ($this->httpHandler)($request, $options);
            }
            public function buildRequest(string $method, ?Message $message = null, array $headers = []): RequestInterface {
                return $this->requestBuilder->build($method, $message, $headers);
            }
        };
    }

    public function testInitializationAndReflection()
    {
        $httpHandler = function () {
        };
        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class)->reveal();
        $client = new ResumableUploadClient($this->createStubTransport($requestBuilder, $httpHandler), $this->prophesize(CredentialsWrapper::class)->reveal(), [], 'test.googleapis.com');

        $call = new Call('v1/test:create', Timestamp::class, new Timestamp(), [], Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call, [
            'chunkSize' => 1024,
            'progressCallback' => function (int $bytes) {
            }
        ]);

        $ref = new \ReflectionClass($upload);
        $clientProp = $ref->getProperty('resumableUploadClient');
        $this->assertSame($client, $clientProp->getValue($upload));

        $callProp = $ref->getProperty('call');
        $this->assertSame($call, $callProp->getValue($upload));
    }

    public function testProgressCallbackReceivesUploadObject()
    {
        $httpHandler = $this->createMockHttpHandler([
            new Response(200, ['X-Goog-Upload-Status' => 'active', 'X-Goog-Upload-URL' => 'https://upload.url/123']),
            new Response(200, ['X-Goog-Upload-Status' => 'final'], '"1970-01-01T00:00:00Z"')
        ]);

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class);
        $requestBuilder->build(Argument::any(), Argument::any(), Argument::any())->will(function ($args) {
            $path = $args[0];
            $headers = $args[2] ?? [];
            return new \GuzzleHttp\Psr7\Request('POST', 'https://test.googleapis.com/' . $path, $headers);
        });
        $client = new ResumableUploadClient($this->createStubTransport($requestBuilder->reveal(), $httpHandler), $this->prophesize(CredentialsWrapper::class)->reveal(), serviceAddress: 'test.googleapis.com');
        $callbackUpload = null;
        $call = new \Google\ApiCore\Call('v1/test:create', Timestamp::class, new Timestamp(), [], \Google\ApiCore\Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call, [
            'progressCallback' => function (int $bytes, ResumableUpload $u) use (&$callbackUpload) {
                $callbackUpload = $u;
            }
        ]);

        $stream = Utils::streamFor('hello world');
        $upload->startUpload($stream);

        $this->assertSame($upload, $callbackUpload);
        $this->assertSame('https://upload.url/123', $callbackUpload->getUploadUrl());
    }

    public function testStartUploadDelegation()
    {
        $requests = [];
        $httpHandler = $this->createMockHttpHandler([
            new Response(200, ['X-Goog-Upload-Status' => 'active', 'X-Goog-Upload-URL' => 'https://upload.url/123']),
            new Response(200, ['X-Goog-Upload-Status' => 'final'], '"1970-01-01T03:25:45Z"')
        ], $requests);

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class);
        $requestBuilder->build(Argument::any(), Argument::any(), Argument::any())->will(function ($args) {
            $path = $args[0];
            $headers = $args[2] ?? [];
            return new \GuzzleHttp\Psr7\Request('POST', 'https://test.googleapis.com/' . $path, $headers);
        });
        $client = new ResumableUploadClient(
            $this->createStubTransport($requestBuilder->reveal(), $httpHandler),
            $this->prophesize(CredentialsWrapper::class)->reveal(),
            serviceAddress: 'test.googleapis.com'
        );
        $call = new \Google\ApiCore\Call('v1/test:create', Timestamp::class, new Timestamp(), [], \Google\ApiCore\Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call);

        $stream = Utils::streamFor('hello world');
        $result = $upload->startUpload($stream);

        $this->assertInstanceOf(Timestamp::class, $result);
        $this->assertEquals(12345, $result->getSeconds());
        $this->assertCount(2, $requests);
        $this->assertEquals('POST', $requests[0]->getMethod());
        $this->assertEquals('start', $requests[0]->getHeaderLine('X-Goog-Upload-Command'));
        $this->assertEquals('upload, finalize', $requests[1]->getHeaderLine('X-Goog-Upload-Command'));
        $this->assertEquals('hello world', (string) $requests[1]->getBody());
        $this->assertEquals('https://upload.url/123', $upload->getUploadUrl());
    }

    public function testUploadUrlTrackingAndResume()
    {
        $requests = [];
        $httpHandler = $this->createMockHttpHandler([
            new Response(200, ['X-Goog-Upload-Status' => 'active', 'X-Goog-Upload-Size-Received' => '5']),
            new Response(200, ['X-Goog-Upload-Status' => 'final'], '"1970-01-01T00:16:39Z"')
        ], $requests);

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class)->reveal();
        $client = new ResumableUploadClient($this->createStubTransport($requestBuilder, $httpHandler), $this->prophesize(CredentialsWrapper::class)->reveal(), serviceAddress: 'test.googleapis.com');
        $call = new Call('test.method', Timestamp::class, null, [], Call::RESUMABLE_UPLOAD_CALL);
        $upload = new ResumableUpload($client, $call, [], 'https://upload.url/session123');
        $this->assertEquals('https://upload.url/session123', $upload->getUploadUrl());

        $stream = Utils::streamFor('hello world');
        $result = $upload->startUpload($stream);

        $this->assertInstanceOf(Timestamp::class, $result);
        $this->assertEquals(999, $result->getSeconds());
        $this->assertCount(2, $requests);
        $this->assertEquals('query', $requests[0]->getHeaderLine('X-Goog-Upload-Command'));
        $this->assertEquals('upload, finalize', $requests[1]->getHeaderLine('X-Goog-Upload-Command'));
        $this->assertEquals(' world', (string) $requests[1]->getBody());
    }

    public function testInvalidInitializationThrowsException()
    {
        $this->expectException(\TypeError::class);

        $requestBuilder = $this->prophesize(\Google\ApiCore\RequestBuilder::class)->reveal();
        $client = new ResumableUploadClient($this->createStubTransport($requestBuilder, function () {}), $this->prophesize(CredentialsWrapper::class)->reveal());
        new ResumableUpload($client, null);
    }

    private function createMockHttpHandler(array $responses, ?array &$requests = []): callable
    {
        return function ($request, $options = []) use (&$responses, &$requests) {
            $requests[] = $request;
            $response = array_shift($responses);
            if ($response instanceof \Exception) {
                return Create::rejectionFor($response);
            }
            return Create::promiseFor($response);
        };
    }
}
