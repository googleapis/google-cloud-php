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

use PHPUnit_Framework_TestCase;
use Google\Cloud\Tests\Mocks\MockCredentialsLoader;
use Google\Cloud\Tests\Mocks\MockGrpcTransport;
use Google\Cloud\Tests\Mocks\MockGrpcTransportStub;

class GrpcTransportTest extends PHPUnit_Framework_TestCase
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
     * @expectedException \Google\GAX\ValidationException
     */
    public function testServiceAddressRequired()
    {
        new MockGrpcTransport([
            'port' => 8443,
            'scopes' => $this->defaultScope,
        ]);
    }

    /**
     * @expectedException \Google\GAX\ValidationException
     */
    public function testPortRequired()
    {
        new MockGrpcTransport([
            'serviceAddress' => 'my-service-address',
            'scopes' => $this->defaultScope,
        ]);
    }

    /**
     * @expectedException \Google\GAX\ValidationException
     */
    public function testScopesRequired()
    {
        // NOTE: scopes is only required if credentialsLoader is not provided
        new MockGrpcTransport([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
        ]);
    }

    public function testConstructGrpcArgsDefault()
    {
        $grpcTransport = new MockGrpcTransport([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'scopes' => $this->defaultScope,
        ]);
        list($request, $options) = $grpcTransport->doConstructGrpcArgs();
        $callbackResult = call_user_func($options['call_credentials_callback']);
        $this->assertEquals(['Bearer adcAccessToken'], $callbackResult['authorization']);
    }

    public function testConstructGrpcArgsCustomCredsLoader()
    {
        $grpcTransport = new MockGrpcTransport([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'credentialsLoader' => new MockCredentialsLoader(
                $this->defaultScope,
                $this->defaultTokens
            )
        ]);
        list($request, $options) = $grpcTransport->doConstructGrpcArgs();
        $callbackResult = call_user_func($options['call_credentials_callback']);
        $this->assertEquals(['Bearer accessToken'], $callbackResult['authorization']);
    }

    public function testCreateCallCredentialsCallbackDisableCaching()
    {
        $grpcTransport = new MockGrpcTransport([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'credentialsLoader' => new MockCredentialsLoader(
                $this->defaultScope,
                $this->defaultTokens
            ),
            'enableCaching' => false,
        ]);
        list($request, $options) = $grpcTransport->doConstructGrpcArgs();
        $callbackResult = call_user_func($options['call_credentials_callback']);
        $this->assertEquals(['Bearer accessToken'], $callbackResult['authorization']);
        list($request, $options) = $grpcTransport->doConstructGrpcArgs();
        $callbackResult = call_user_func($options['call_credentials_callback']);
        $this->assertEquals(['Bearer accessToken2'], $callbackResult['authorization']);
    }

    public function testCreateCallCredentialsCallbackCaching()
    {
        $grpcTransport = new MockGrpcTransport([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'credentialsLoader' => new MockCredentialsLoader(
                $this->defaultScope,
                $this->defaultTokens
            ),
        ]);
        list($request, $options) = $grpcTransport->doConstructGrpcArgs();
        $callbackResult = call_user_func($options['call_credentials_callback']);
        $this->assertEquals(['Bearer accessToken'], $callbackResult['authorization']);
        list($request, $options) = $grpcTransport->doConstructGrpcArgs();
        $callbackResult = call_user_func($options['call_credentials_callback']);
        $this->assertEquals(['Bearer accessToken'], $callbackResult['authorization']);
    }

    public function testCreateStubWithDefaultSslCreds()
    {
        $grpcTransport = new MockGrpcTransport([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'scopes' => $this->defaultScope,
        ]);
        $this->assertEquals('my-service-address:8443', $grpcTransport->hostname);
        $this->assertEquals('DummySslCreds', $grpcTransport->stubOpts['credentials']);
        $this->assertEquals(
            'my-service-address:8443',
            $grpcTransport->stubOpts['grpc.ssl_target_name_override']
        );
        $this->assertNull($grpcTransport->channel);
    }

    public function testCreateStubWithExplicitSslCreds()
    {
        $grpcTransport = new MockGrpcTransport([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'scopes' => $this->defaultScope,
            'sslCreds' => 'provided-creds',
        ]);
        $this->assertEquals('my-service-address:8443', $grpcTransport->hostname);
        $this->assertEquals('provided-creds', $grpcTransport->stubOpts['credentials']);
        $this->assertEquals(
            'my-service-address:8443',
            $grpcTransport->stubOpts['grpc.ssl_target_name_override']
        );
        $this->assertNull($grpcTransport->channel);
    }

    public function testCreateStubWithInsecureSslCreds()
    {
        $insecureCreds = \Grpc\ChannelCredentials::createInsecure();
        $grpcTransport = new MockGrpcTransport([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'scopes' => $this->defaultScope,
            'sslCreds' => $insecureCreds,
        ]);
        $this->assertEquals('my-service-address:8443', $grpcTransport->hostname);
        $this->assertEquals($insecureCreds, $grpcTransport->stubOpts['credentials']);
        $this->assertEquals(
            'my-service-address:8443',
            $grpcTransport->stubOpts['grpc.ssl_target_name_override']
        );
        $this->assertNull($grpcTransport->channel);
    }

    public function testCreateStubWithChannel()
    {
        $grpcTransport = new MockGrpcTransport([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'scopes' => $this->defaultScope,
            'channel' => 'my-channel'
        ]);
        $this->assertEquals('my-service-address:8443', $grpcTransport->hostname);
        $this->assertEquals('DummySslCreds', $grpcTransport->stubOpts['credentials']);
        $this->assertEquals(
            'my-service-address:8443',
            $grpcTransport->stubOpts['grpc.ssl_target_name_override']
        );
        $this->assertEquals('my-channel', $grpcTransport->channel);
    }

    public function testCreateStubWithForceNew()
    {
        $grpcTransport = new MockGrpcTransport([
            'serviceAddress' => 'my-service-address',
            'port' => 8443,
            'scopes' => $this->defaultScope,
            'forceNewChannel' => true
        ]);
        $this->assertEquals('my-service-address:8443', $grpcTransport->hostname);
        $this->assertEquals('DummySslCreds', $grpcTransport->stubOpts['credentials']);
        $this->assertEquals(
            'my-service-address:8443',
            $grpcTransport->stubOpts['grpc.ssl_target_name_override']
        );
        $this->assertNull($grpcTransport->channel);
        $this->assertTrue($grpcTransport->stubOpts['force_new']);
    }
}
