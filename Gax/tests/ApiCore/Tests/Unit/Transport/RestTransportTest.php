<?php
/*
 * Copyright 2018, Google Inc.
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

use Google\ApiCore\AuthWrapper;
use Google\ApiCore\Call;
use Google\ApiCore\RequestBuilder;
use Google\ApiCore\Testing\MockRequest;
use Google\ApiCore\Testing\MockResponse;
use Google\ApiCore\Transport\RestTransport;
use Google\Auth\FetchAuthTokenInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class RestTransportTest extends TestCase
{
    private $call;

    public function setUp()
    {
        $this->call = new Call(
            'Testing123',
            MockResponse::class,
            new MockRequest()
        );
    }
    private function getTransport(callable $httpHandler)
    {
        $request = new Request('POST', 'http://www.example.com');
        $requestBuilder = $this->getMockBuilder(RequestBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $requestBuilder->method('build')
            ->willReturn($request);
        $credentialsLoader = $this->getMockBuilder(FetchAuthTokenInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $credentialsLoader->method('fetchAuthToken')
            ->willReturn(['access_token' => 'abc']);

        $authWrapper = new AuthWrapper(
            $credentialsLoader,
            function (RequestInterface $request, array $options = []) {
                return null;
            }
        );

        return new RestTransport(
            $requestBuilder,
            $authWrapper,
            $httpHandler
        );
    }

    public function testStartUnaryCall()
    {
        $body = ['name' => 'hello', 'number' => 15];
        $code = 200;

        $httpHandler = function (RequestInterface $request, array $options = []) use ($body, $code) {
            return Promise\promise_for(
                new Response(
                    200,
                    [],
                    json_encode($body)
                )
            );
        };

        $response = $this->getTransport($httpHandler)
            ->startUnaryCall($this->call, [])
            ->wait();

        $this->assertEquals($body['name'], $response->getName());
        $this->assertEquals($body['number'], $response->getNumber());
    }

    /**
     * @expectedException \Exception
     */
    public function testStartUnaryCallThrowsException()
    {
        $httpHandler = function (RequestInterface $request, array $options = []) {
            return Promise\rejection_for(new \Exception());
        };

        $this->getTransport($httpHandler)
            ->startUnaryCall($this->call, [])
            ->wait();
    }

    /**
     * @expectedException Google\ApiCore\ApiException
     */
    public function testStartUnaryCallThrowsRequestException()
    {
        $httpHandler = function (RequestInterface $request, array $options = []) {
            return Promise\rejection_for(
                RequestException::create(
                    new Request('POST', 'http://www.example.com'),
                    new Response(
                        404,
                        [],
                        json_encode([
                            'error' => [
                                'status' => 'NOT_FOUND',
                                'message' => 'Ruh-roh.'
                            ]
                        ])
                    )
                )
            );
        };

        $this->getTransport($httpHandler)
            ->startUnaryCall($this->call, [])
            ->wait();
    }
}
