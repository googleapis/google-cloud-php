<?php
/*
 * Copyright 2024 Google LLC
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

namespace Google\ApiCore\Tests\Unit;

use Google\ApiCore\InsecureCredentialsWrapper;
use Google\ApiCore\Transport\HttpUnaryTransportTrait;
use Google\ApiCore\Transport\GrpcTransport;
use Google\ApiCore\Call;
use Grpc\ChannelCredentials;
use GuzzleHttp\Promise\Promise;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class InsecureCredentialsWrapperTest extends TestCase
{
    use TestTrait;
    use ProphecyTrait;

    public function testInsecureCredentialsWrapperWithHttpTransport()
    {
        $httpImpl = new class () {
            use HttpUnaryTransportTrait {
                buildCommonHeaders as public;
            }
        };

        $headers = $httpImpl->buildCommonHeaders([
            'credentialsWrapper' => new InsecureCredentialsWrapper(),
        ]);

        $this->assertEmpty($headers);
    }

    public function testInsecureCredentialsWrapperWithGrpcTransport()
    {
        $this->requiresGrpcExtension();

        $message = $this->createMockRequest();
        $call = $this->prophesize(Call::class);
        $call->getMessage()->willReturn($message);
        $call->getMethod()->shouldBeCalled();
        $call->getDecodeType()->shouldBeCalled();

        $grpc = new GrpcTransport('', ['credentials' => ChannelCredentials::createInsecure()]);

        $response = $grpc->startUnaryCall(
            $call->reveal(),
            ['credentialsWrapper' => new InsecureCredentialsWrapper()]
        );

        $this->assertInstanceOf(Promise::class, $response);
    }

}
