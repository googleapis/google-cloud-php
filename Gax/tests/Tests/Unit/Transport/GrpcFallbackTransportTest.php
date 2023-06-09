<?php
/*
 * Copyright 2018 Google LLC
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

namespace Google\ApiCore\Tests\Unit\Transport;

use Exception;
use Google\ApiCore\ApiException;
use Google\ApiCore\Call;
use Google\ApiCore\Testing\MockRequest;
use Google\ApiCore\Testing\MockResponse;
use Google\ApiCore\Transport\GrpcFallbackTransport;
use Google\ApiCore\ValidationException;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Google\Rpc\Code;
use Google\Rpc\Status;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use PHPUnit\Framework\TestCase;

class GrpcFallbackTransportTest extends TestCase
{
    private $call;

    public function setUp(): void
    {
        $this->call = new Call(
            'Testing123',
            MockResponse::class,
            new MockRequest()
        );
    }

    private function getTransport(callable $httpHandler)
    {
        return new GrpcFallbackTransport(
            'www.example.com',
            $httpHandler
        );
    }

    /**
     * @param $apiEndpoint
     * @param $requestMessage
     * @dataProvider startUnaryCallDataProvider
     */
    public function testStartUnaryCall($apiEndpoint, $requestMessage)
    {
        $expectedRequest = new Request(
            'POST',
            "https://$apiEndpoint/\$rpc/Testing123",
            [
                'Content-Type' => 'application/x-protobuf',
                'x-goog-api-client' => ['grpc-web'],
            ],
            $requestMessage->serializeToString()
        );

        $expectedResponse = (new MockResponse())
            ->setName('hello')
            ->setNumber(15);

        $httpHandler = function (RequestInterface $request, array $options = []) use ($expectedResponse, $expectedRequest) {
            $this->assertEquals($expectedRequest, $request);

            return Create::promiseFor(
                new Response(
                    200,
                    [],
                    $expectedResponse->serializeToString()
                )
            );
        };

        $transport = new GrpcFallbackTransport(
            $apiEndpoint,
            $httpHandler
        );
        $call = new Call(
            'Testing123',
            MockResponse::class,
            $requestMessage
        );
        $response = $transport->startUnaryCall($call, [])->wait();

        $this->assertEquals($expectedResponse->getName(), $response->getName());
        $this->assertEquals($expectedResponse->getNumber(), $response->getNumber());
    }

    public function startUnaryCallDataProvider()
    {
        return [
            ["www.example.com", new MockRequest()],
            ["www.example.com:443", new MockRequest()],
            ["www.example.com:447", new MockRequest()],
        ];
    }

    public function testStartUnaryCallThrowsException()
    {
        $httpHandler = function (RequestInterface $request, array $options = []) {
            return Create::rejectionFor(new Exception());
        };

        $this->expectException(Exception::class);

        $this->getTransport($httpHandler)
            ->startUnaryCall($this->call, [])
            ->wait();
    }

    public function testStartUnaryCallThrowsRequestException()
    {
        $httpHandler = function (RequestInterface $request, array $options = []) {
            $status = new Status();
            $status->setCode(Code::NOT_FOUND);
            $status->setMessage("Ruh-roh");
            return Create::rejectionFor(
                RequestException::create(
                    new Request('POST', 'http://www.example.com'),
                    new Response(
                        404,
                        [],
                        $status->serializeToString()
                    )
                )
            );
        };


        $this->expectException(Exception::class);

        $this->getTransport($httpHandler)
            ->startUnaryCall($this->call, [])
            ->wait();
    }

    /**
     * @dataProvider buildDataGrpcFallback
     */
    public function testBuildGrpcFallback($apiEndpoint, $config, $expectedTransport)
    {
        $actualTransport = GrpcFallbackTransport::build($apiEndpoint, $config);
        $this->assertEquals($expectedTransport, $actualTransport);
    }

    public function buildDataGrpcFallback()
    {
        $uri = "address.com";
        $apiEndpoint = "$uri:443";
        $httpHandler = [HttpHandlerFactory::build(), 'async'];
        return [
            [
                $apiEndpoint,
                ['httpHandler' => $httpHandler],
                new GrpcFallbackTransport($apiEndpoint, $httpHandler)
            ],
            [
                $apiEndpoint,
                [],
                new GrpcFallbackTransport($apiEndpoint, $httpHandler),
            ],
        ];
    }

    /**
     * @dataProvider buildInvalidData
     * @param $apiEndpoint
     * @param $args
     */
    public function testBuildInvalid($apiEndpoint, $args)
    {
        $this->expectException(ValidationException::class);

        GrpcFallbackTransport::build($apiEndpoint, $args);
    }

    public function buildInvalidData()
    {
        return [
            [
                "addresswithtoo:many:segments",
                [],
            ],
        ];
    }

    public function testNonBinaryProtobufResponseException()
    {
        $httpHandler = function (RequestInterface $request, array $options = []) {
            return Create::rejectionFor(
                RequestException::create(
                    new Request('POST', 'http://www.example.com'),
                    new Response(
                        404,
                        [],
                        "<html><body>This is an HTML response</body></html>"
                    )
                )
            );
        };


        $this->expectException(ApiException::class);
        $this->expectExceptionCode(5);
        $this->expectExceptionMessage('<html><body>This is an HTML response<\/body><\/html>');

        $this->getTransport($httpHandler)
            ->startUnaryCall($this->call, [])
            ->wait();
    }
}
