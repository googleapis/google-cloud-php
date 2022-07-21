<?php
/*
 * Copyright 2021 Google LLC
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

namespace Google\ApiCore\Tests\Unit\Middleware;

use Google\ApiCore\Call;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\Middleware\OperationsMiddleware;
use Google\ApiCore\Testing\MockResponse;
use GuzzleHttp\Promise\Promise;
use PHPUnit\Framework\TestCase;

class OperationsMiddlewareTest extends TestCase
{
    public function testOperationNameMethodDescriptor()
    {
        $call = $this->getMockBuilder(Call::class)
            ->disableOriginalConstructor()
            ->getMock();
        $operationsClient = $this->getMockBuilder(OperationsClient::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept(['validate'])
            ->getMock();

        $descriptor = [
            'operationNameMethod' => 'getNumber'
        ];
        $handler = function(Call $call, $options) use (&$callCount) {
            return $promise = new Promise(function () use (&$promise) {
                $response = new MockResponse(['number' => 123]);
                $promise->resolve($response);
            });
        };
        $middleware = new OperationsMiddleware($handler, $operationsClient, $descriptor);
        $response = $middleware(
            $call,
            []
        )->wait();

        $this->assertEquals(123, $response->getName());
    }
}
