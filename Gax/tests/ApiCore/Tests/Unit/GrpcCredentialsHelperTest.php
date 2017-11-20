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
namespace Google\ApiCore\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Google\ApiCore\Tests\Unit\Mocks\MockGrpcCredentialsHelper;
use Google\ApiCore\Tests\Unit\Mocks\MockCredentialsLoader;

class GrpcCredentialsHelperTest extends TestCase
{
    private $defaultScope = ['my-scope'];
    private $defaultTokens = [
        [
            'access_token' => 'accessToken',
            'expires_in' => '100',
        ],
        [
            'access_token' => 'accessToken2',
            'expires_in' => '100'
        ],
    ];

    /**
     * @expectedException \Google\ApiCore\ValidationException
     */
    public function testServiceAddressRequired()
    {
        new MockGrpcCredentialsHelper([
            'port' => 8443,
            'scopes' => $this->defaultScope,
        ]);
    }

    /**
     * @expectedException \Google\ApiCore\ValidationException
     */
    public function testPortRequired()
    {
        new MockGrpcCredentialsHelper([
            'serviceAddress' => 'my-service-address',
            'scopes' => $this->defaultScope,
        ]);
    }

    /**
     * @expectedException \Google\ApiCore\ValidationException
     */
    public function testScopesRequired()
    {
        // NOTE: scopes is only required if credentialsLoader is not provided
        new MockGrpcCredentialsHelper([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
        ]);
    }

    public function testCreateCallCredentialsCallbackDefault()
    {
        $grpcCredentialsHelper = new MockGrpcCredentialsHelper([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'scopes' => $this->defaultScope,
        ]);
        $callback = $grpcCredentialsHelper->createCallCredentialsCallback();
        $callbackResult = $callback();
        $this->assertEquals(['Bearer adcAccessToken'], $callbackResult['authorization']);
    }

    public function testCreateCallCredentialsCallbackCustomCredsLoader()
    {
        $grpcCredentialsHelper = new MockGrpcCredentialsHelper([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'credentialsLoader' => new MockCredentialsLoader(
                $this->defaultScope,
                $this->defaultTokens
            )
        ]);
        $callback = $grpcCredentialsHelper->createCallCredentialsCallback();
        $callbackResult = $callback();
        $this->assertEquals(['Bearer accessToken'], $callbackResult['authorization']);
    }

    public function testCreateCallCredentialsCallbackDisableCaching()
    {
        $grpcCredentialsHelper = new MockGrpcCredentialsHelper([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'credentialsLoader' => new MockCredentialsLoader(
                $this->defaultScope,
                $this->defaultTokens
            ),
            'enableCaching' => false,
        ]);
        $callback = $grpcCredentialsHelper->createCallCredentialsCallback();
        $callbackResult = $callback();
        $this->assertEquals(['Bearer accessToken'], $callbackResult['authorization']);
        $callback = $grpcCredentialsHelper->createCallCredentialsCallback();
        $callbackResult = $callback();
        $this->assertEquals(['Bearer accessToken2'], $callbackResult['authorization']);
    }

    public function testCreateCallCredentialsCallbackCaching()
    {
        $grpcCredentialsHelper = new MockGrpcCredentialsHelper([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'credentialsLoader' => new MockCredentialsLoader(
                $this->defaultScope,
                $this->defaultTokens
            ),
        ]);
        $callback = $grpcCredentialsHelper->createCallCredentialsCallback();
        $callbackResult = $callback();
        $this->assertEquals(['Bearer accessToken'], $callbackResult['authorization']);
        $callback = $grpcCredentialsHelper->createCallCredentialsCallback();
        $callbackResult = $callback();
        $this->assertEquals(['Bearer accessToken'], $callbackResult['authorization']);
    }

    public function testCreateStubWithDefaultSslCreds()
    {
        $grpcCredentialsHelper = new MockGrpcCredentialsHelper([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'scopes' => $this->defaultScope,
        ]);
        $createStubCallback = function ($hostname, $stubOpts, $channel) {
            return ['hostname' => $hostname, 'stubOpts' => $stubOpts, 'channel' => $channel];
        };
        $createStubResult = $grpcCredentialsHelper->createStub($createStubCallback);
        $this->assertEquals('my-service-address:8443', $createStubResult['hostname']);
        $this->assertEquals('DummySslCreds', $createStubResult['stubOpts']['credentials']);
        $this->assertEquals(
            'my-service-address:8443',
            $createStubResult['stubOpts']['grpc.ssl_target_name_override']
        );
        $this->assertNull($createStubResult['channel']);
    }

    public function testCreateStubWithExplicitSslCreds()
    {
        $grpcCredentialsHelper = new MockGrpcCredentialsHelper([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'scopes' => $this->defaultScope,
        ]);
        $createStubCallback = function ($hostname, $stubOpts, $channel) {
            return ['hostname' => $hostname, 'stubOpts' => $stubOpts, 'channel' => $channel];
        };
        $createStubResult = $grpcCredentialsHelper->createStub(
            $createStubCallback,
            ['sslCreds' => 'provided-creds']
        );
        $this->assertEquals('my-service-address:8443', $createStubResult['hostname']);
        $this->assertEquals('provided-creds', $createStubResult['stubOpts']['credentials']);
        $this->assertEquals(
            'my-service-address:8443',
            $createStubResult['stubOpts']['grpc.ssl_target_name_override']
        );
        $this->assertNull($createStubResult['channel']);
    }

    public function testCreateStubWithInsecureSslCreds()
    {
        $grpcCredentialsHelper = new MockGrpcCredentialsHelper([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'scopes' => $this->defaultScope,
        ]);
        $createStubCallback = function ($hostname, $stubOpts, $channel) {
            return ['hostname' => $hostname, 'stubOpts' => $stubOpts, 'channel' => $channel];
        };
        $insecureCreds = \Grpc\ChannelCredentials::createInsecure();
        $createStubResult = $grpcCredentialsHelper->createStub(
            $createStubCallback,
            ['sslCreds' => $insecureCreds]
        );
        $this->assertEquals('my-service-address:8443', $createStubResult['hostname']);
        $this->assertEquals($insecureCreds, $createStubResult['stubOpts']['credentials']);
        $this->assertEquals(
            'my-service-address:8443',
            $createStubResult['stubOpts']['grpc.ssl_target_name_override']
        );
        $this->assertNull($createStubResult['channel']);
    }

    public function testCreateStubOverrideOptions()
    {
        $grpcCredentialsHelper = new MockGrpcCredentialsHelper([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'scopes' => $this->defaultScope,
        ]);
        $createStubCallback = function ($hostname, $stubOpts, $channel) {
            return ['hostname' => $hostname, 'stubOpts' => $stubOpts, 'channel' => $channel];
        };
        $createStubResult = $grpcCredentialsHelper->createStub($createStubCallback, [
            'serviceAddress' => 'my-alternate-address',
            'port' => 9554,
        ]);
        $this->assertEquals('my-alternate-address:9554', $createStubResult['hostname']);
        $this->assertEquals('DummySslCreds', $createStubResult['stubOpts']['credentials']);
        $this->assertEquals(
            'my-alternate-address:9554',
            $createStubResult['stubOpts']['grpc.ssl_target_name_override']
        );
        $this->assertNull($createStubResult['channel']);
    }

    public function testCreateStubWithChannel()
    {
        $grpcCredentialsHelper = new MockGrpcCredentialsHelper([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'scopes' => $this->defaultScope,
            'channel' => 'my-channel'
        ]);
        $createStubCallback = function ($hostname, $stubOpts, $channel) {
            return ['hostname' => $hostname, 'stubOpts' => $stubOpts, 'channel' => $channel];
        };
        $createStubResult = $grpcCredentialsHelper->createStub($createStubCallback);
        $this->assertEquals('my-service-address:8443', $createStubResult['hostname']);
        $this->assertEquals('DummySslCreds', $createStubResult['stubOpts']['credentials']);
        $this->assertEquals(
            'my-service-address:8443',
            $createStubResult['stubOpts']['grpc.ssl_target_name_override']
        );
        $this->assertEquals('my-channel', $createStubResult['channel']);
    }

    public function testCreateStubWithForceNew()
    {
        $grpcCredentialsHelper = new MockGrpcCredentialsHelper([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'scopes' => $this->defaultScope,
            'forceNewChannel' => true
        ]);
        $createStubCallback = function ($hostname, $stubOpts, $channel) {
            return ['hostname' => $hostname, 'stubOpts' => $stubOpts, 'channel' => $channel];
        };
        $createStubResult = $grpcCredentialsHelper->createStub($createStubCallback);
        $this->assertEquals('my-service-address:8443', $createStubResult['hostname']);
        $this->assertEquals('DummySslCreds', $createStubResult['stubOpts']['credentials']);
        $this->assertEquals(
            'my-service-address:8443',
            $createStubResult['stubOpts']['grpc.ssl_target_name_override']
        );
        $this->assertNull($createStubResult['channel']);
        $this->assertTrue($createStubResult['stubOpts']['force_new']);
    }
}
