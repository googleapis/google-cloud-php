<?php
/*
 * Copyright 2016, Google Inc.
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

namespace Google\Cloud\Tests\Unit\Core\Grpc;

use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Tests\GrpcTestTrait;
use Google\Cloud\Core\Grpc\GrpcTransport;
use Grpc\ChannelCredentials;
use PHPUnit_Framework_TestCase;
use ReflectionMethod;

class GrpcTransportTest extends PHPUnit_Framework_TestCase
{
    use GrpcTestTrait;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();
    }

    private function callCredentialsCallback(GrpcTransport $transport)
    {
        $method = new ReflectionMethod($transport, 'constructGrpcArgs');
        $method->setAccessible(true);
        list($request, $args) = $method->invoke($transport);
        return call_user_func($args['call_credentials_callback']);
    }

    /**
     * @expectedException Google\GAX\ValidationException
     * @expectedExceptionMessage Missing required argument serviceAddress
     */
    public function testServiceAddressRequired()
    {
        new GrpcTransport([
            'port' => 8443,
            'scopes' => ['my-scope'],
        ]);
    }

    /**
     * @expectedException \Google\GAX\ValidationException
     * @expectedExceptionMessage Missing required argument port
     */
    public function testPortRequired()
    {
        new GrpcTransport([
            'serviceAddress' => 'my-service-address',
            'scopes' => ['my-scope'],
        ]);
    }

    /**
     * @expectedException \Google\GAX\ValidationException
     * @expectedExceptionMessage Missing required argument createGrpcStubFunction
     */
    public function testCreateGrpcStubFunctionRequired()
    {
        new GrpcTransport([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'scopes' => ['my-scope'],
        ]);
    }

    /**
     * @expectedException \Google\GAX\ValidationException
     * @expectedExceptionMessage Missing required argument scopes
     */
    public function testScopesRequired()
    {
        // NOTE: scopes is only required if credentialsLoader is not provided
        new GrpcTransport([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'createGrpcStubFunction' => function() {},
        ]);
    }

    public function testConstructGrpcArgsCustomCredsLoader()
    {
        $credentialsLoader = $this->getMock(FetchAuthTokenInterface::class);
        $credentialsLoader->expects($this->once())
            ->method('fetchAuthToken')
            ->willReturn(['access_token' => 'accessToken']);

        $grpcTransport = new GrpcTransport([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'createGrpcStubFunction' => function() {},
            'credentialsLoader' => $credentialsLoader,
        ]);
        $callbackResult = $this->callCredentialsCallback($grpcTransport);
        $this->assertEquals(['Bearer accessToken'], $callbackResult['authorization']);
    }

    public function testCreateCallCredentialsCallbackDisableCaching()
    {
        $credentialsLoader = $this->getMock(FetchAuthTokenInterface::class);
        $credentialsLoader->expects($this->exactly(2))
            ->method('fetchAuthToken')
            ->will($this->onConsecutiveCalls(
                ['access_token' => 'accessToken'],
                ['access_token' => 'accessToken2']
            ));

        $grpcTransport = new GrpcTransport([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'createGrpcStubFunction' => function() {},
            'credentialsLoader' => $credentialsLoader,
            'enableCaching' => false,
        ]);
        $callbackResult = $this->callCredentialsCallback($grpcTransport);
        $this->assertEquals(['Bearer accessToken'], $callbackResult['authorization']);
        $callbackResult = $this->callCredentialsCallback($grpcTransport);
        $this->assertEquals(['Bearer accessToken2'], $callbackResult['authorization']);
    }

    public function testCreateCallCredentialsCallbackCaching()
    {
        $credentialsLoader = $this->getMock(FetchAuthTokenInterface::class);
        $credentialsLoader->expects($this->once())
            ->method('fetchAuthToken')
            ->willReturn(['access_token' => 'accessToken']);
        $credentialsLoader->expects($this->exactly(2))
            ->method('getCacheKey')
            ->willReturn('cacheKey');

        $grpcTransport = new GrpcTransport([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'createGrpcStubFunction' => function() {},
            'credentialsLoader' => $credentialsLoader,
        ]);
        $callbackResult = $this->callCredentialsCallback($grpcTransport);
        $this->assertEquals(['Bearer accessToken'], $callbackResult['authorization']);
        $callbackResult = $this->callCredentialsCallback($grpcTransport);
        $this->assertEquals(['Bearer accessToken'], $callbackResult['authorization']);
    }

    public function testCreateStubDefault()
    {
        $called = false;
        $grpcTransport = new GrpcTransport([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'createGrpcStubFunction' => function($addr, $opts, $channel) use (&$called) {
                $this->assertEquals('my-service-address:8443', $addr);
                $this->assertInstanceOf(ChannelCredentials::class, $opts['credentials']);
                $this->assertEquals(
                    'my-service-address:8443',
                    $opts['grpc.ssl_target_name_override']
                );
                $this->assertNull($channel);
                $called = true;
            },
            'scopes' => ['my-scope'],
        ]);
        $this->assertTrue($called);
    }

    public function testCreateStubWithExplicitSslCreds()
    {
        $called = false;
        $grpcTransport = new GrpcTransport([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'createGrpcStubFunction' => function($addr, $opts, $channel) use (&$called) {
                $this->assertEquals('provided-creds', $opts['credentials']);
                $called = true;
            },
            'scopes' => ['my-scope'],
            'sslCreds' => 'provided-creds',
        ]);
        $this->assertTrue($called);
    }

    public function testCreateStubWithInsecureSslCreds()
    {
        $called = false;
        $insecureCreds = ChannelCredentials::createInsecure();
        $grpcTransport = new GrpcTransport([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'createGrpcStubFunction' => function($addr, $opts, $channel) use (&$called, $insecureCreds) {
                $this->assertEquals($insecureCreds, $opts['credentials']);
                $called = true;
            },
            'scopes' => ['my-scope'],
            'sslCreds' => $insecureCreds,
        ]);
        $this->assertTrue($called);
    }

    public function testCreateStubWithChannel()
    {
        $called = false;
        $grpcTransport = new GrpcTransport([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'createGrpcStubFunction' => function($addr, $opts, $channel) use (&$called) {
                $this->assertEquals('my-channel', $channel);
                $called = true;
            },
            'scopes' => ['my-scope'],
            'channel' => 'my-channel'
        ]);
        $this->assertTrue($called);
    }

    public function testCreateStubWithForceNew()
    {
        $called = false;
        $grpcTransport = new GrpcTransport([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'createGrpcStubFunction' => function($addr, $opts, $channel) use (&$called) {
                $this->assertTrue($opts['force_new']);
                $called = true;
            },
            'scopes' => ['my-scope'],
            'forceNewChannel' => true
        ]);
        $this->assertTrue($called);
    }
}
